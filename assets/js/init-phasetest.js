// TODO!: Decouper la fonction en plusieurs fichiers.
(function () {
    function scholarshipQuestionsManager(payload, container) {
        const state = {
            phaseid: Number(payload.phaseid || 0),
            categories: asArray(payload.categories),
            questions: [],
            sesskey: payload.sesskey || '',
            saveurl: payload.saveurl || '',
            locked: !!payload.locked,
            lockReason: payload.lock_reason || '',
            openUuid: '',
            backups: {},
            error: '',
            success: '',
            saving: false,
            questionSuggestions: asArray(payload.questionSuggestions || payload.question_suggestions || []),
            assertionSuggestions: asArray(payload.assertionSuggestions || payload.assertion_suggestions || []),
            activeSuggest: null,
        };

        state.questions = asArray(payload.questions).map((q, index) => normalizeQuestion(q, index));

        if (state.questions.length === 0) {
            const q = emptyQuestion();
            state.questions.push(q);
            state.openUuid = q.uuid;
        }

        function ensureNotLocked() {
            if (!state.locked) {
                return true;
            }

            state.error = state.lockReason || 'Cette phase est verrouillée. Les questions ne peuvent plus être modifiées.';
            state.success = '';
            render();
            if (state.error || state.success) {
                scrollToFeedbackMessage();
            }
            return false;
        }

        function asArray(value) {
            if (Array.isArray(value)) {
                return value;
            }

            if (value && typeof value === 'object') {
                return Object.values(value);
            }

            return [];
        }

        function asBool(value) {
            return value === true || value === 1 || value === '1' || value === 'true';
        }

        function uid(prefix) {
            return prefix + Date.now() + '_' + Math.random().toString(16).slice(2);
        }

        function clone(value) {
            return JSON.parse(JSON.stringify(value));
        }

        function safeHtml(value) {
            const template = document.createElement('template');
            template.innerHTML = String(value || '');

            template.content
                .querySelectorAll('script, iframe, object, embed, style')
                .forEach(node => node.remove());

            template.content.querySelectorAll('*').forEach(el => {
                [...el.attributes].forEach(attr => {
                    const name = attr.name.toLowerCase();

                    if (name.startsWith('on') || name === 'srcdoc') {
                        el.removeAttribute(attr.name);
                    }

                    if (name === 'href' && /^javascript:/i.test(attr.value)) {
                        el.removeAttribute(attr.name);
                    }
                });
            });

            return template.innerHTML;
        }

        function isMathCategory(q) {
            const cat = state.categories.find(c => Number(c.id) === Number(q.category_question_id));
            const name = cat ? String(cat.name || '').toLowerCase() : '';

            return name.includes('math');
        }

        function mathKeyboardHtml(q) {
            if (!isMathCategory(q)) {
                return '';
            }

            const symbols = ['π', '√', '²', '³', '≤', '≥', '≠', '≈', '÷', '×', '±', '∞', '∑', '∫', '∆', 'θ'];

            return `
        <div class="rounded-lg border border-purple-200 bg-purple-50 p-3">
            <div class="text-sm text-purple-800 mb-2">
                Clavier mathématique
            </div>

            <div class="flex flex-wrap gap-2">
                ${symbols.map(symbol => `
                    <button type="button"
                            class="px-3 py-2 bg-white border border-purple-200 rounded-md text-purple-800"
                            data-action="insert-math"
                            data-value="${escapeHtml(symbol)}">
                        ${escapeHtml(symbol)}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
        }

        function questionEditorHtml(q) {
            return `
        <div>
            <label class="block text-sm text-gray-700 mb-1">
                Texte de la question
            </label>

            <div class="flex flex-wrap gap-2 border border-gray-200 rounded-t-md bg-gray-50 px-2 py-2">
                <button type="button" class="px-3 py-1 border rounded bg-white font-bold"
                        data-action="format-question" data-command="bold">B</button>

                <button type="button" class="px-3 py-1 border rounded bg-white italic"
                        data-action="format-question" data-command="italic">I</button>

                <button type="button" class="px-3 py-1 border rounded bg-white underline"
                        data-action="format-question" data-command="underline">U</button>

                <button type="button" class="px-3 py-1 border rounded bg-white"
                        data-action="format-question" data-command="insertUnorderedList">• Liste</button>

                <button type="button" class="px-3 py-1 border rounded bg-white"
                        data-action="format-question" data-command="insertOrderedList">1. Liste</button>
            </div>

            <div class="rich-question-editor w-full min-h-[130px] border border-gray-300 border-t-0 rounded-b-md px-3 py-2 bg-white"
                 contenteditable="true"
                 data-rich-field="question_text">${safeHtml(q.question_text)}</div>
        </div>

        ${mathKeyboardHtml(q)}
    `;
        }

        function normalizeSearch(value) {
            return String(value || '')
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/<[^>]*>/g, '')
                .trim();
        }

        function stripHtml(value) {
            const div = document.createElement('div');
            div.innerHTML = String(value || '');
            return div.textContent || div.innerText || '';
        }

        function shortText(value, max = 120) {
            const text = stripHtml(value).trim();

            if (text.length <= max) {
                return text;
            }

            return text.slice(0, max) + '...';
        }

        function getQuestionMatches(query, currentQuestion) {
            const needle = normalizeSearch(query);

            if (needle.length < 2) {
                return [];
            }

            return state.questionSuggestions
                .filter(item => {
                    const text = item.question_text ?? item.questiontext ?? '';
                    const haystack = normalizeSearch(text);

                    const sameQuestion = Number(item.id || 0) === Number(currentQuestion.id || 0);
                    const sameCategory =
                        !currentQuestion.category_question_id ||
                        Number(item.category_question_id ?? item.categoryid ?? 0) === Number(currentQuestion.category_question_id);

                    return !sameQuestion && sameCategory && haystack.includes(needle);
                })
                .slice(0, 5);
        }

        function getAssertionMatches(query, currentOption) {
            const needle = normalizeSearch(query);

            if (needle.length < 2) {
                return [];
            }

            return state.assertionSuggestions
                .filter(item => {
                    const text = item.option_text ?? item.optiontext ?? '';
                    const haystack = normalizeSearch(text);

                    const sameAssertion = Number(item.id || 0) === Number(currentOption.id || 0);

                    return !sameAssertion && haystack.includes(needle);
                })
                .slice(0, 5);
        }

        function updateRichField(element) {
            const info = getQuestionFromElement(element);

            if (!info) {
                return;
            }

            info.question.question_text = element.innerHTML;
            info.question.is_validated = false;
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function normalizeQuestion(q, index) {
            q = q || {};

            const options = asArray(q.options).map((opt, optIndex) => {
                opt = opt || {};

                return {
                    uuid: opt.uuid || uid('o_'),
                    id: Number(opt.id || 0),
                    option_text: opt.option_text ?? opt.optiontext ?? '',
                    is_correct: asBool(opt.is_correct ?? opt.iscorrect),
                    position: optIndex,
                };
            });

            return {
                uuid: q.uuid || uid('q_'),
                id: Number(q.id || 0),
                category_question_id: Number(q.category_question_id ?? q.categoryid ?? 0),
                question_text: q.question_text ?? q.questiontext ?? '',
                ponderation: Number(q.ponderation || 1),
                allow_multiple: asBool(q.allow_multiple ?? q.allowmultiple),
                suggestions_enabled: q.suggestions_enabled === undefined ? true : asBool(q.suggestions_enabled),
                is_validated: q.is_validated === undefined ? false : asBool(q.is_validated),
                position: index,
                options: options.length ? options : [
                    emptyOption(true),
                    emptyOption(false),
                ],
            };
        }

        function emptyOption(correct = false) {
            return {
                uuid: uid('o_'),
                id: 0,
                option_text: '',
                is_correct: correct,
                position: 0,
            };
        }

        function emptyQuestion() {
            return {
                uuid: uid('q_'),
                id: 0,
                category_question_id: state.categories.length ? Number(state.categories[0].id) : 0,
                question_text: '',
                ponderation: 1,
                allow_multiple: false,
                suggestions_enabled: true,
                is_validated: false,
                position: state.questions.length,
                options: [
                    emptyOption(true),
                    emptyOption(false),
                ],
            };
        }

        function refreshPositions() {
            state.questions = asArray(state.questions).map((q, qIndex) => {
                return {
                    ...q,
                    position: qIndex,
                    options: asArray(q.options).map((opt, optIndex) => {
                        return {
                            ...opt,
                            position: optIndex,
                        };
                    }),
                };
            });
        }

        function categoryName(id) {
            const cat = state.categories.find(c => Number(c.id) === Number(id));
            return cat ? cat.name : 'Sans catégorie';
        }

        function categoriesOptions(selectedId) {
            return state.categories.map(cat => {
                const selected = Number(cat.id) === Number(selectedId) ? 'selected' : '';

                return `
                    <option value="${escapeHtml(cat.id)}" ${selected}>
                        ${escapeHtml(cat.name)}
                    </option>
                `;
            }).join('');
        }

        function compactOptionsHtml(q) {
            return asArray(q.options).map(opt => {
                return `
            <div class="flex items-center gap-3 text-sm">
                <span class="w-5 h-5 flex items-center justify-center rounded-full border
                    ${opt.is_correct ? 'border-emerald-500 text-emerald-600' : 'border-gray-400 text-gray-500'}">
                    ${opt.is_correct ? '✓' : 'X'}
                </span>

                <span class="${opt.is_correct ? 'text-emerald-700 font-medium' : 'text-gray-700'}">
                    ${escapeHtml(opt.option_text || 'Assertion vide')}
                </span>
            </div>
        `;
            }).join('');
        }

        function optionRowsHtml(q) {
            return asArray(q.options).map((opt, optIndex) => {
                return `
            <div class="space-y-1" data-option-index="${optIndex}">
                <div class="flex items-center gap-2">
                    <button type="button"
                            class="w-10 h-10 rounded-md border flex items-center justify-center
                            ${opt.is_correct ? 'border-emerald-400 bg-emerald-50 text-emerald-700' : 'border-gray-300 text-gray-500'}"
                            data-action="toggle-correct"
                            data-oidx="${optIndex}">
                        ${opt.is_correct ? '✓' : '×'}
                    </button>

                    <input type="text"
                           class="flex-1 border border-gray-300 placeholder-gray-500 rounded-md px-3 py-2"
                           data-field="option_text"
                           data-oidx="${optIndex}"
                           value="${escapeHtml(opt.option_text)}"
                           placeholder="Texte de l'assertion">

                    <button type="button"
                            class="px-3 py-2 border rounded-md disabled:opacity-40"
                            data-action="move-option"
                            data-oidx="${optIndex}"
                            data-direction="-1"
                            ${optIndex === 0 ? 'disabled' : ''}>
                        ↑
                    </button>

                    <button type="button"
                            class="px-3 py-2 border rounded-md disabled:opacity-40"
                            data-action="move-option"
                            data-oidx="${optIndex}"
                            data-direction="1"
                            ${optIndex === asArray(q.options).length - 1 ? 'disabled' : ''}>
                        ↓
                    </button>

                    <button type="button"
                            class="px-3 py-2 border border-red-300 text-red-600 rounded-md"
                            data-action="delete-option"
                            data-oidx="${optIndex}">
                        🗑
                    </button>
                </div>

                <div class="js-option-autocomplete ml-12" data-oidx="${optIndex}"></div>
            </div>
        `;
            }).join('');
        }

        function scrollToFeedbackMessage() {
            requestAnimationFrame(() => {
                const message = container.querySelector('[data-feedback-message]');

                if (!message) {
                    return;
                }

                message.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'nearest',
                });

                message.focus({
                    preventScroll: true,
                });
            });
        }

        function render() {
            refreshPositions();

            const questionsHtml = state.questions.map((q, qIndex) => {
                const isOpen = state.openUuid === q.uuid;

                return `
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
                         data-question-card
                         data-qindex="${qIndex}"
                         data-qkey="${escapeHtml(q.uuid)}">

                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                            <div class="font-semibold text-gray-900">
                                Question ${qIndex + 1}
                            </div>

                            <div class="flex items-center gap-2">
                                ${q.is_validated ? `
                                    <span class="px-2 py-1 text-xs rounded bg-emerald-50 text-emerald-700">
                                        Validée
                                    </span>
                                ` : `
                                    <span class="px-2 py-1 text-xs rounded bg-amber-50 text-amber-700">
                                        Brouillon
                                    </span>
                                `}

                                <button type="button"
                                        class="px-3 py-2 border rounded-md hover:bg-gray-50 disabled:opacity-40"
                                        data-action="move-question"
                                        data-direction="-1"
                                        ${qIndex === 0 ? 'disabled' : ''}>
                                    ↑
                                </button>

                                <button type="button"
                                        class="px-3 py-2 border rounded-md hover:bg-gray-50 disabled:opacity-40"
                                        data-action="move-question"
                                        data-direction="1"
                                        ${qIndex === state.questions.length - 1 ? 'disabled' : ''}>
                                    ↓
                                </button>

                                <button type="button"
                                        class="px-3 py-2 border rounded-md hover:bg-gray-50"
                                        data-action="duplicate-question">
                                    ⧉
                                </button>

                                <button type="button"
                                        class="px-3 py-2 border border-red-300 text-red-600 rounded-md hover:bg-red-50"
                                        data-action="delete-question">
                                    🗑
                                </button>
                            </div>
                        </div>

                        <div class="js-question-compact p-4 ${isOpen ? 'hidden' : ''}">
                            <div class="text-sm text-gray-500 mb-2">
                                ${escapeHtml(categoryName(q.category_question_id))}
                                ·
                                ${escapeHtml(q.ponderation)} point(s)
                            </div>

                            <div class="question-html font-semibold text-gray-900 mb-4">
                                ${q.question_text ? safeHtml(q.question_text) : '<span class="text-gray-400">Question sans texte</span>'}
                            </div>

                            <div class="space-y-2">
                                ${compactOptionsHtml(q)}
                            </div>

                            <button type="button"
                                    class="mt-4 text-sm text-sky-700 hover:underline"
                                    data-action="open-edit">
                                Cliquez pour modifier cette question
                            </button>
                        </div>

                        <div class="js-question-edit p-4 space-y-4 ${isOpen ? '' : 'hidden'}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Catégorie</label>
                                    <select class="w-full border border-gray-300 rounded-md px-3 py-2"
                                            data-field="category_question_id">
                                        ${categoriesOptions(q.category_question_id)}
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Points</label>
                                    <input type="number"
                                           min="1"
                                           class="w-full border border-gray-300 rounded-md px-3 py-2"
                                           data-field="ponderation"
                                           value="${escapeHtml(q.ponderation)}">
                                </div>
                            </div>

                            <div>
                                ${questionEditorHtml(q)}
                            </div>
                            <div class="js-question-autocomplete mt-2"></div>

                            <div class="space-y-2">
                                ${optionRowsHtml(q)}

                                <button type="button"
                                        class="text-sm text-sky-700 hover:underline"
                                        data-action="add-option">
                                    + Ajouter une assertion
                                </button>
                            </div>

                            <div class="border-t border-gray-200 pt-4 flex items-center gap-6">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox"
                                           data-field="allow_multiple"
                                           ${q.allow_multiple ? 'checked' : ''}>
                                    Plusieurs réponses
                                </label>

                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox"
                                           data-field="suggestions_enabled"
                                           ${q.suggestions_enabled ? 'checked' : ''}>
                                    Suggestions
                                </label>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button"
                                        class="px-4 py-2 border rounded-md"
                                        data-action="cancel-edit">
                                    Annuler
                                </button>

                                <button type="button"
                                        class="px-4 py-2 bg-sky-700 text-white rounded-md"
                                        data-action="validate-question">
                                    Valider la question
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = `
                <div class="space-y-4">
                    ${state.error ? `
                        <div data-feedback-message
                            tabindex="-1"
                            class="rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm scroll-mt-24">
                            ${escapeHtml(state.error)}
                        </div>
                    ` : ''}

                    ${state.success ? `
                        <div data-feedback-message
                            tabindex="-1"
                            class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm scroll-mt-24">
                            ${escapeHtml(state.success)}
                        </div>
                    ` : ''}

                    ${questionsHtml}

                    <div class="flex items-center justify-between pt-2">
                        <button type="button"
                                class="text-sky-700 hover:underline"
                                data-action="add-question">
                            + Ajouter une question
                        </button>

                        <button type="button"
                                class="px-5 py-2 bg-emerald-700 text-white rounded-md disabled:opacity-50"
                                data-action="save-all"
                                ${state.saving ? 'disabled' : ''}>
                            ${state.saving ? 'Enregistrement...' : 'Enregistrer les questions'}
                        </button>
                    </div>
                </div>
            `;
        }

        function clearAutocompletes(card) {
            const root = card || container;

            root.querySelectorAll('.js-question-autocomplete, .js-option-autocomplete').forEach(box => {
                box.innerHTML = '';
            });
        }

        function renderQuestionAutocomplete(card, qIndex) {
            const q = state.questions[qIndex];

            if (!q || !q.suggestions_enabled) {
                clearAutocompletes(card);
                return;
            }

            const box = card.querySelector('.js-question-autocomplete');

            if (!box) {
                return;
            }

            const matches = getQuestionMatches(q.question_text, q);

            if (!matches.length) {
                box.innerHTML = '';
                return;
            }

            box.innerHTML = `
        <div class="rounded-lg border border-sky-200 bg-sky-50 p-2 shadow-sm">
            <div class="text-xs font-semibold text-sky-800 mb-1">
                Questions similaires trouvées
            </div>

            <div class="space-y-1">
                ${matches.map(item => `
                    <button type="button"
                            class="block w-full text-left px-3 py-2 rounded-md bg-white hover:bg-sky-100 border border-sky-100 text-sm text-gray-800"
                            data-action="use-question-suggestion"
                            data-suggestion-id="${escapeHtml(item.id)}">
                        ${escapeHtml(shortText(item.question_text ?? item.questiontext ?? ''))}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
        }

        function renderOptionAutocomplete(card, qIndex, optIndex) {
            const q = state.questions[qIndex];

            if (!q || !q.suggestions_enabled) {
                clearAutocompletes(card);
                return;
            }

            const opt = q.options[optIndex];

            if (!opt) {
                return;
            }

            const box = card.querySelector(`.js-option-autocomplete[data-oidx="${optIndex}"]`);

            if (!box) {
                return;
            }

            const matches = getAssertionMatches(opt.option_text, opt);

            if (!matches.length) {
                box.innerHTML = '';
                return;
            }

            box.innerHTML = `
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-2 shadow-sm">
            <div class="text-xs font-semibold text-emerald-800 mb-1">
                Assertions similaires trouvées
            </div>

            <div class="space-y-1">
                ${matches.map(item => `
                    <button type="button"
                            class="block w-full text-left px-3 py-2 rounded-md bg-white hover:bg-emerald-100 border border-emerald-100 text-sm text-gray-800"
                            data-action="use-assertion-suggestion"
                            data-suggestion-id="${escapeHtml(item.id)}"
                            data-oidx="${optIndex}">
                        ${escapeHtml(shortText(item.option_text ?? item.optiontext ?? ''))}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
        }

        function cardFromElement(element) {
            return element.closest('[data-question-card]');
        }

        function indexFromCard(card) {
            if (!card) {
                return -1;
            }

            return Number(card.dataset.qindex);
        }

        function optionIndexFromElement(element) {
            return Number(element.dataset.oidx);
        }

        function getQuestionFromElement(element) {
            const card = cardFromElement(element);
            const qIndex = indexFromCard(card);

            if (qIndex < 0 || qIndex >= state.questions.length) {
                return null;
            }

            return {
                card,
                qIndex,
                question: state.questions[qIndex],
            };
        }

        function openQuestion(uuid) {
            state.openUuid = String(uuid || '');
            render();
        }

        function closeQuestion() {
            state.openUuid = '';
            render();
        }

        function normalizeCorrectAnswers(q) {
            q.options = asArray(q.options);

            if (asBool(q.allow_multiple)) {
                return q;
            }

            let firstCorrectIndex = q.options.findIndex(opt => asBool(opt.is_correct));

            if (firstCorrectIndex === -1 && q.options.length) {
                firstCorrectIndex = 0;
            }

            q.options = q.options.map((opt, index) => {
                opt.is_correct = index === firstCorrectIndex;
                return opt;
            });

            return q;
        }

        function cleanQuestion(q) {
            q = clone(q);

            q.category_question_id = Number(q.category_question_id || 0);
            q.question_text = String(q.question_text || '').trim();
            q.ponderation = Number(q.ponderation || 1);
            q.allow_multiple = asBool(q.allow_multiple);
            q.suggestions_enabled = asBool(q.suggestions_enabled);

            q.options = asArray(q.options).map(opt => {
                opt.option_text = String(opt.option_text || '').trim();
                opt.is_correct = asBool(opt.is_correct);
                return opt;
            });

            normalizeCorrectAnswers(q);

            return q;
        }
        
        function normalizeAssertionText(value) {
            return normalizeSearch(stripHtml(value))
                .replace(/\s+/g, ' ')
                .trim();
        }

        function assertionDuplicateKey(opt) {
            const id = Number(opt.id || 0);

            if (id > 0) {
                return 'id:' + id;
            }

            return 'text:' + normalizeAssertionText(opt.option_text);
        }

        function findDuplicateAssertion(q) {
            const seen = new Map();
            const options = asArray(q.options);

            for (let i = 0; i < options.length; i++) {
                const opt = options[i];
                const text = normalizeAssertionText(opt.option_text);
                const id = Number(opt.id || 0);

                if (!id && !text) {
                    continue;
                }

                const key = assertionDuplicateKey(opt);

                if (seen.has(key)) {
                    return {
                        firstIndex: seen.get(key),
                        secondIndex: i,
                        text: stripHtml(opt.option_text || '').trim(),
                    };
                }

                seen.set(key, i);
            }

            return null;
        }

        function assertionAlreadyExistsInQuestion(q, candidate, exceptIndex = -1) {
            const candidateKey = assertionDuplicateKey(candidate);

            return asArray(q.options).some((opt, index) => {
                if (index === exceptIndex) {
                    return false;
                }

                return assertionDuplicateKey(opt) === candidateKey;
            });
        }

        function validateQuestion(q) {
            q = cleanQuestion(q);

            if (!Number(q.category_question_id)) {
                return 'Catégorie obligatoire.';
            }

            if (!q.question_text) {
                return 'Texte de question obligatoire.';
            }

            if (!q.options || q.options.length < 2) {
                return 'Une question doit avoir au moins deux assertions.';
            }

            const emptyOption = q.options.find(opt => !String(opt.option_text || '').trim());

            if (emptyOption) {
                return 'Toutes les assertions doivent être remplies.';
            }

            const duplicate = findDuplicateAssertion(q);

            if (duplicate) {
                return `Assertion en double : "${duplicate.text || 'assertion existante'}". Une même question ne peut pas contenir deux fois la même assertion.`;
            }

            const correctCount = q.options.filter(opt => asBool(opt.is_correct)).length;

            if (correctCount < 1) {
                return 'Sélectionnez au moins une bonne réponse.';
            }

            if (!asBool(q.allow_multiple) && correctCount > 1) {
                return 'Cette question est en réponse unique mais contient plusieurs bonnes réponses.';
            }

            return '';
        }

        function toServerPayload() {
            return state.questions.map(q => {
                q = cleanQuestion(q);

                return {
                    id: Number(q.id || 0),
                    categoryid: Number(q.category_question_id),
                    questiontext: q.question_text,
                    ponderation: Number(q.ponderation || 1),
                    allowmultiple: q.allow_multiple ? 1 : 0,
                    options: q.options.map(opt => {
                        return {
                            id: Number(opt.id || 0),
                            optiontext: String(opt.option_text || '').trim(),
                            iscorrect: asBool(opt.is_correct) ? 1 : 0,
                        };
                    }),
                };
            });
        }

        function updateField(element) {
            const info = getQuestionFromElement(element);

            if (!info) {
                return;
            }

            const q = info.question;
            const field = element.dataset.field;

            if (field === 'category_question_id') {
                q.category_question_id = Number(element.value || 0);
                q.is_validated = false;
                state.openUuid = q.uuid;

                render();
                return;
            }

            if (field === 'ponderation') {
                q.ponderation = Number(element.value || 1);
                q.is_validated = false;
                return;
            }

            if (field === 'allow_multiple') {
                q.allow_multiple = element.checked;
                normalizeCorrectAnswers(q);
                q.is_validated = false;
                state.openUuid = q.uuid;

                render();
                return;
            }

            if (field === 'suggestions_enabled') {
                q.suggestions_enabled = element.checked;
                q.is_validated = false;
                state.openUuid = q.uuid;

                render();
                return;
            }

            if (field === 'option_text') {
                const optIndex = optionIndexFromElement(element);

                if (q.options[optIndex]) {
                    q.options[optIndex].option_text = element.value;
                    q.options[optIndex].id = Number(q.options[optIndex].id || 0);
                    q.is_validated = false;

                    if (q.suggestions_enabled) {
                        renderOptionAutocomplete(info.card, info.qIndex, optIndex);
                    }
                }

                return;
            }

            q.is_validated = false;
        }

        async function askConfirm(title, text) {
            if (window.Swal) {
                const result = await Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#dc2626',
                });

                return result.isConfirmed;
            }

            return confirm(title);
        }

        let savedEditorRange = null;

        function saveEditorSelection() {
            const selection = window.getSelection();

            if (!selection || selection.rangeCount === 0) {
                return;
            }

            const range = selection.getRangeAt(0);

            if (!container.contains(range.commonAncestorContainer)) {
                return;
            }

            savedEditorRange = range.cloneRange();
        }

        function restoreEditorSelection(editor) {
            if (!savedEditorRange) {
                return;
            }

            const selection = window.getSelection();

            editor.focus();
            selection.removeAllRanges();
            selection.addRange(savedEditorRange);
        }

        function placeCursorAtEnd(editor) {
            editor.focus();

            const range = document.createRange();
            range.selectNodeContents(editor);
            range.collapse(false);

            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);

            savedEditorRange = range.cloneRange();
        }

        function fallbackList(editor, ordered = false) {
            const text = stripHtml(editor.innerHTML).trim() || 'Nouvel élément';

            editor.innerHTML = ordered
                ? `<ol><li>${escapeHtml(text)}</li></ol>`
                : `<ul><li>${escapeHtml(text)}</li></ul>`;

            placeCursorAtEnd(editor);
        }

        function runEditorCommand(info, command, value = null) {
            if (!info || !info.card) {
                return;
            }

            const editor = info.card.querySelector('[data-rich-field="question_text"]');

            if (!editor) {
                return;
            }

            restoreEditorSelection(editor);
            editor.focus();

            const before = editor.innerHTML;

            try {
                document.execCommand(command, false, value);
            } catch (e) {
                if (command === 'insertText' && value) {
                    document.execCommand('insertHTML', false, escapeHtml(value));
                }
            }

            const after = editor.innerHTML;
            const isListCommand = command === 'insertUnorderedList' || command === 'insertOrderedList';

            if (isListCommand && before === after && !editor.querySelector('ul, ol')) {
                fallbackList(editor, command === 'insertOrderedList');
            }

            updateRichField(editor);
            saveEditorSelection();

            info.question.is_validated = false;
            state.openUuid = info.question.uuid;
        }

        async function handleClick(event) {
            const actionElement = event.target.closest('[data-action]');

            if (!actionElement || !container.contains(actionElement)) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const action = actionElement.dataset.action;

            state.error = '';
            state.success = '';

            if (action === 'add-question') {
                if (!ensureNotLocked()) {
                    return;
                }
                const q = emptyQuestion();

                state.questions = [
                    ...state.questions,
                    q,
                ];

                state.openUuid = q.uuid;
                render();
                return;
            }

            if (action === 'save-all') {
                saveAll();
                return;
            }

            const info = getQuestionFromElement(actionElement);

            if (!info) {
                return;
            }

            const q = info.question;
            const qIndex = info.qIndex;
            const key = q.uuid;

            if (action === 'format-question') {
                const command = actionElement.dataset.command;

                if (command) {
                    runEditorCommand(info, command);
                }

                return;
            }

            if (action === 'insert-math') {
                const value = actionElement.dataset.value || '';

                if (value) {
                    runEditorCommand(info, 'insertText', value);
                }

                return;
            }

            if (action === 'use-question-suggestion') {
                const suggestionId = Number(actionElement.dataset.suggestionId || 0);

                const suggestion = state.questionSuggestions.find(item => {
                    return Number(item.id) === suggestionId;
                });

                if (!suggestion) {
                    state.error = 'Suggestion introuvable.';
                    state.openUuid = key;
                    render();
                    return;
                }

                const reused = normalizeQuestion({
                    uuid: q.uuid,
                    id: Number(suggestion.id || 0),
                    category_question_id: Number(suggestion.category_question_id ?? suggestion.categoryid ?? q.category_question_id),
                    question_text: suggestion.question_text ?? suggestion.questiontext ?? '',
                    ponderation: q.ponderation,
                    suggestions_enabled: q.suggestions_enabled,
                    is_validated: false,
                    options: asArray(suggestion.options).map(opt => {
                        return {
                            uuid: uid('o_'),
                            id: Number(opt.id || 0),
                            option_text: opt.option_text ?? opt.optiontext ?? '',
                            is_correct: asBool(opt.is_correct ?? opt.iscorrect),
                        };
                    }),
                }, qIndex);

                reused.allow_multiple = reused.options.filter(opt => asBool(opt.is_correct)).length > 1;

                state.questions[qIndex] = reused;
                state.openUuid = reused.uuid;
                render();
                return;
            }

            if (action === 'use-assertion-suggestion') {
                const optIndex = optionIndexFromElement(actionElement);
                const suggestionId = Number(actionElement.dataset.suggestionId || 0);

                const suggestion = state.assertionSuggestions.find(item => {
                    return Number(item.id) === suggestionId;
                });

                if (!suggestion) {
                    state.error = 'Suggestion introuvable.';
                    state.openUuid = key;
                    render();
                    return;
                }

                const candidate = {
                    id: Number(suggestion.id || 0),
                    option_text: suggestion.option_text ?? suggestion.optiontext ?? '',
                };

                if (assertionAlreadyExistsInQuestion(q, candidate, optIndex)) {
                    state.error = 'Cette assertion existe déjà dans cette question.';
                    state.openUuid = key;
                    render();
                    return;
                }

                if (q.options[optIndex]) {
                    q.options[optIndex].id = Number(suggestion.id || 0);
                    q.options[optIndex].option_text = suggestion.option_text ?? suggestion.optiontext ?? '';
                }

                q.is_validated = false;
                state.openUuid = key;
                render();
                return;
            }

            if (action === 'open-edit') {
                if (!ensureNotLocked()) {
                    return;
                }
                state.backups[key] = clone(q);
                state.openUuid = key;
                render();
                return;
            }

            if (action === 'cancel-edit') {
                if (!q.id && !q.is_validated) {
                    state.questions = state.questions.filter((_, i) => i !== qIndex);
                    state.openUuid = '';
                    delete state.backups[key];
                    render();
                    return;
                }

                if (state.backups[key]) {
                    state.questions[qIndex] = clone(state.backups[key]);
                    delete state.backups[key];
                }

                state.openUuid = '';
                render();
                return;
            }

            if (action === 'validate-question') {
                const cleaned = cleanQuestion(q);
                const message = validateQuestion(cleaned);

                if (message) {
                    state.error = message;
                    state.openUuid = key;
                    render();
                    if (state.error || state.success) {
                        scrollToFeedbackMessage();
                    }
                    return;
                }

                cleaned.is_validated = true;
                state.questions[qIndex] = cleaned;
                state.openUuid = '';
                delete state.backups[key];
                render();
                return;
            }

            if (action === 'duplicate-question') {
                if (!ensureNotLocked()) {
                    return;
                }
                const copy = normalizeQuestion(clone(q), qIndex + 1);

                copy.uuid = uid('q_');
                copy.id = 0;
                copy.is_validated = false;

                copy.options = asArray(copy.options).map((opt, index) => {
                    return {
                        uuid: uid('o_'),
                        id: 0,
                        option_text: opt.option_text || '',
                        is_correct: asBool(opt.is_correct),
                        position: index,
                    };
                });

                const before = state.questions.slice(0, qIndex + 1);
                const after = state.questions.slice(qIndex + 1);

                state.questions = [
                    ...before,
                    copy,
                    ...after,
                ];

                refreshPositions();

                state.openUuid = copy.uuid;
                state.backups[copy.uuid] = clone(copy);

                render();
                return;
            }

            if (action === 'delete-question') {
                if (!ensureNotLocked()) {
                    return;
                }
                const ok = await askConfirm(
                    'Supprimer cette question ?',
                    'Cette action retirera la question de cette phase de test.'
                );

                if (!ok) {
                    return;
                }

                state.questions = state.questions.filter((_, i) => i !== qIndex);

                if (state.openUuid === key) {
                    state.openUuid = '';
                }

                delete state.backups[key];

                render();
                return;
            }

            if (action === 'move-question') {
                const direction = Number(actionElement.dataset.direction);
                const newIndex = qIndex + direction;

                if (newIndex < 0 || newIndex >= state.questions.length) {
                    return;
                }

                const items = state.questions.map(item => clone(item));

                const temp = items[qIndex];
                items[qIndex] = items[newIndex];
                items[newIndex] = temp;

                state.questions = items;
                state.openUuid = key;

                render();
                return;
            }

            if (action === 'add-option') {
                q.options = [
                    ...asArray(q.options),
                    emptyOption(false),
                ];

                q.is_validated = false;
                state.openUuid = key;

                render();
                return;
            }

            if (action === 'delete-option') {
                const optIndex = optionIndexFromElement(actionElement);

                if (q.options.length <= 2) {
                    state.error = 'Une question doit avoir au moins deux assertions.';
                    state.openUuid = key;
                    render();
                    return;
                }

                q.options = q.options.filter((_, i) => i !== optIndex);
                q.is_validated = false;
                normalizeCorrectAnswers(q);

                state.openUuid = key;
                render();
                return;
            }

            if (action === 'move-option') {
                const optIndex = optionIndexFromElement(actionElement);
                const direction = Number(actionElement.dataset.direction);
                const newIndex = optIndex + direction;

                if (newIndex < 0 || newIndex >= q.options.length) {
                    return;
                }

                const options = q.options.map(opt => clone(opt));

                const temp = options[optIndex];
                options[optIndex] = options[newIndex];
                options[newIndex] = temp;

                q.options = options;
                q.is_validated = false;
                state.openUuid = key;

                render();
                return;
            }

            if (action === 'toggle-correct') {
                const optIndex = optionIndexFromElement(actionElement);

                if (q.allow_multiple) {
                    q.options[optIndex].is_correct = !asBool(q.options[optIndex].is_correct);
                } else {
                    q.options = q.options.map((opt, index) => {
                        opt.is_correct = index === optIndex;
                        return opt;
                    });
                }

                q.is_validated = false;
                state.openUuid = key;

                render();
            }
        }

        async function saveAll() {
            if (!ensureNotLocked()) {
                return;
            }
            state.error = '';
            state.success = '';

            const cleanedQuestions = state.questions.map(q => cleanQuestion(q));

            for (let i = 0; i < cleanedQuestions.length; i++) {
                const message = validateQuestion(cleanedQuestions[i]);

                if (message) {
                    state.questions = cleanedQuestions;
                    state.error = message;
                    state.openUuid = cleanedQuestions[i].uuid;
                    render();
                    return;
                }
            }

            state.questions = cleanedQuestions;
            state.saving = true;
            render();

            try {
                const body = new URLSearchParams();

                body.append('sesskey', state.sesskey);
                body.append('phaseid', state.phaseid);
                body.append('questions', JSON.stringify(toServerPayload()));

                const response = await fetch(state.saveurl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: body.toString(),
                });

                if (!response.ok) {
                    throw new Error('Erreur HTTP ' + response.status);
                }

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.message || 'Enregistrement impossible.');
                }

                state.questions = asArray(result.questions).map((q, index) => normalizeQuestion(q, index));
                state.backups = {};
                state.openUuid = '';
                state.success = 'Questions enregistrées avec succès.';

            } catch (e) {
                state.error = e.message || 'Erreur pendant l’enregistrement.';
            } finally {
                state.saving = false;
                render();

                if (state.error || state.success) {
                    scrollToFeedbackMessage();
                }
            }
        }

        container.addEventListener('click', handleClick);

        container.addEventListener('input', function (event) {
            const richEditor = event.target.closest('[data-rich-field="question_text"]');

            if (richEditor && container.contains(richEditor)) {
                const info = getQuestionFromElement(richEditor);

                if (!info) {
                    return;
                }

                info.question.question_text = richEditor.innerHTML;
                info.question.is_validated = false;

                if (info.question.suggestions_enabled) {
                    renderQuestionAutocomplete(info.card, info.qIndex);
                }

                return;
            }

            if (!event.target.matches('[data-field]')) {
                return;
            }

            updateField(event.target);
        });

        container.addEventListener('change', function (event) {
            if (!event.target.matches('[data-field]')) {
                return;
            }

            updateField(event.target);
        });

        render();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('styled-questions');

        if (!container) {
            return;
        }

        const payload = window.scholarshipQuestionsData || {};

        scholarshipQuestionsManager(payload, container);
    });
})();
