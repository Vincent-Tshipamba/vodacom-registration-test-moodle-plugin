<?php
defined('MOODLE_INTERNAL') || die();

$applicant = $data->applicant;
$phasetest = $data->phasetest;

$examquestionsjson = json_encode($data->examquestions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$exammetajson = json_encode($data->exammeta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$saveurl = new moodle_url('/local/scholarship//applicants/tests/save-progress.php');
$violationurl = new moodle_url('/local/scholarship/applicants/tests/register-violation.php');
$submiturl = new moodle_url('/local/scholarship/applicants/tests/submitted-layout.php');
$redirecturl = new moodle_url('/local/scholarship/applicants/tests/submitted-layout.php');
?>
<style>
    #question-text p,
    #question-text div,
    .rich-render p,
    .rich-render div {
        margin: 0 0 0.5rem;
    }

    #question-text ul,
    #question-text ol,
    .rich-render ul,
    .rich-render ol {
        margin: 0.5rem 0 0.5rem 1.25rem;
        padding: 0;
    }

    #question-text,
    .rich-render {
        white-space: break-spaces;
    }

    #question-text ul,
    .rich-render ul {
        list-style: disc;
    }

    #question-text ol,
    .rich-render ol {
        list-style: decimal;
    }
</style>
<section id="evaluationUser"
    class="bg-[radial-gradient(circle_at_top,_rgba(255,255,255,0.18),_transparent_42%),linear-gradient(180deg,#eaf7f9_0%,#d9eef2_48%,#d8edf0_100%)] min-h-screen select-none">

    <div class="mx-auto px-3 md:px-6 py-4 md:py-6 max-w-7xl" id="exam-app">

        <div
            class="top-0 z-30 sticky bg-white/90 shadow-[0_16px_48px_rgba(15,23,42,0.16)] backdrop-blur mb-5 px-4 md:px-6 py-3 border border-white/70 rounded-[26px]">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-3 md:gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="bg-slate-200 rounded-full h-2 overflow-hidden">
                            <div id="timer-progress"
                                class="bg-gradient-to-r from-teal-600 to-cyan-500 rounded-full h-full transition-all duration-700"
                                style="width:100%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 md:gap-3 bg-slate-50 px-3 md:px-4 py-1 rounded-2xl shrink-0">
                        <p id="timer-label" class="font-semibold tabular-nums text-slate-900 text-lg md:text-2xl">
                            00:00
                        </p>
                        <div
                            class="flex justify-center items-center border border-slate-200 rounded-full w-7 md:w-9 h-7 md:h-9 text-slate-500">
                            ⏱
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap justify-between items-center gap-3 mt-4 text-slate-600 text-sm">
                <div>
                    Question
                    <span id="current-question-number" class="font-semibold text-slate-900">1</span>
                    /
                    <span id="total-question-count">
                        <?= count($data->examquestions) ?>
                    </span>
                </div>

                <div>
                    Répondues :
                    <span id="answered-count" class="font-semibold text-slate-900">0</span>
                </div>
            </div>
        </div>

        <div id="warning-banner"
            class="hidden bg-amber-50/90 mb-5 px-5 py-4 border border-amber-200/80 rounded-2xl text-amber-800 text-sm">
        </div>

        <div class="gap-5 grid xl:grid-cols-[minmax(0,1fr)_320px]">

            <div
                class="bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] px-4 md:px-8 py-6 border border-white/70 rounded-[28px]">

                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div>
                        <p id="question-category" class="text-slate-500 text-xs uppercase font-bold"></p>

                        <div id="question-text" class="mt-2 font-semibold text-slate-900 text-xl md:text-2xl leading-8">
                        </div>
                    </div>

                    <span
                        class="inline-flex items-center bg-slate-100 px-3 py-1 rounded-full font-semibold text-slate-600 text-xs">
                        Point(s) :
                        <span id="question-points" class="ml-1"></span>
                    </span>
                </div>

                <div id="question-options" class="space-y-4 mt-8"></div>

                <div
                    class="flex sm:flex-row flex-col sm:justify-between sm:items-center gap-4 mt-8 pt-6 border-slate-200/80 border-t">
                    <div class="flex items-center gap-3">
                        <button type="button" id="prev-question"
                            class="inline-flex items-center gap-2 hover:bg-slate-100 hover:font-medium disabled:opacity-40 px-4 py-3 border border-slate-200 rounded-2xl font-medium text-slate-700 text-sm transition disabled:cursor-not-allowed">
                            ← Précédent
                        </button>

                        <button type="button" id="next-question"
                            class="inline-flex items-center gap-2 hover:bg-slate-100 hover:font-medium disabled:opacity-40 px-4 py-3 border border-slate-200 rounded-2xl font-medium text-slate-700 text-sm transition disabled:cursor-not-allowed">
                            Suivant →
                        </button>
                    </div>

                    <form id="exam-submit-form" action="<?= $submiturl ?>" method="post">
                        <input type="hidden" name="sesskey" value="<?= sesskey() ?>">
                        <input type="hidden" name="current_index" id="submit-current-index"
                            value="<?= (int) $data->currentquestionindex ?>">
                        <input type="hidden" name="auto_submitted" id="submit-auto-submitted" value="0">

                        <button type="submit" id="submit-exam-button"
                            class="inline-flex justify-center items-center gap-2 bg-[#ff1453] hover:bg-[#e0114a] px-5 py-3 rounded-2xl focus:outline-none focus:ring-[#ff1453]/20 focus:ring-4 w-full sm:w-auto font-semibold text-white transition">
                            Soumettre l'évaluation
                        </button>
                    </form>
                </div>
            </div>

            <aside class="space-y-5">
                <div
                    class="bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] p-5 border border-white/70 rounded-[26px]">
                    <div class="flex justify-between items-center gap-3">
                        <h3 class="font-semibold text-slate-500 text-sm uppercase">
                            Navigation
                        </h3>
                        <span class="text-slate-500 text-xs">Cliquez sur un numéro</span>
                    </div>

                    <div id="question-nav" class="gap-2 grid grid-cols-5 sm:grid-cols-8 xl:grid-cols-5 mt-4"></div>
                </div>

                <div
                    class="bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] p-5 border border-white/70 rounded-[26px] text-slate-600 text-sm">
                    <h3 class="font-semibold text-slate-500 uppercase">
                        Surveillance
                    </h3>

                    <p class="mt-4 leading-6">
                        Tentatives détectées:
                        <span id="violation-count" class="font-semibold text-slate-900">
                            <?= (int) $data->violationcount ?>
                        </span>
                        /
                        <?= (int) $data->maxviolations ?>
                    </p>

                    <p class="mt-2 leading-6 text-justify">
                        Ne réduisez pas la fenêtre et ne changez pas d'onglet.
                        Au maximum autorisé, tout est soumis automatiquement.
                    </p>
                </div>
            </aside>
        </div>

        <div id="violation-modal" class="hidden z-50 fixed inset-0 justify-center items-center bg-slate-950/55 px-4">
            <div class="bg-white shadow-2xl p-6 border border-slate-200/80 rounded-[28px] w-full max-w-md">
                <h3 class="font-semibold text-slate-900 text-lg">
                    Attention
                </h3>

                <p id="violation-modal-message" class="mt-3 text-slate-600 text-sm leading-6"></p>

                <div class="flex justify-end mt-6">
                    <button type="button" id="close-violation-modal"
                        class="bg-[#ff1453] hover:bg-[#e0114a] px-4 py-2 rounded-2xl font-medium text-white transition">
                        OK
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const examState = {
            sesskey: '<?= sesskey() ?>',
            questions: <?= $examquestionsjson ?>,
            currentIndex: <?= (int) $data->currentquestionindex ?>,
            violationCount: <?= (int) $data->violationcount ?>,
            maxViolations: <?= (int) $data->maxviolations ?>,
            saveUrl: '<?= $saveurl ?>',
            violationUrl: '<?= $violationurl ?>',
            redirectUrl: '<?= $redirecturl ?>',
            endsAt: <?= json_encode($data->exammeta['ends_at']) ?>,
            startedAt: <?= json_encode($data->exammeta['started_at']) ?>,
            submitting: false,
            countdownInterval: null,
            saveTimeout: null,
            lastViolationAt: 0,
            readyAt: Date.now() + 3000,
        };

        const els = {
            warningBanner: document.getElementById('warning-banner'),
            timerLabel: document.getElementById('timer-label'),
            timerProgress: document.getElementById('timer-progress'),
            currentQuestionNumber: document.getElementById('current-question-number'),
            answeredCount: document.getElementById('answered-count'),
            questionCategory: document.getElementById('question-category'),
            questionText: document.getElementById('question-text'),
            questionPoints: document.getElementById('question-points'),
            questionOptions: document.getElementById('question-options'),
            questionNav: document.getElementById('question-nav'),
            prevQuestion: document.getElementById('prev-question'),
            nextQuestion: document.getElementById('next-question'),
            submitCurrentIndex: document.getElementById('submit-current-index'),
            submitAutoSubmitted: document.getElementById('submit-auto-submitted'),
            examSubmitForm: document.getElementById('exam-submit-form'),
            submitExamButton: document.getElementById('submit-exam-button'),
            violationCount: document.getElementById('violation-count'),
            violationModal: document.getElementById('violation-modal'),
            violationModalMessage: document.getElementById('violation-modal-message'),
            closeViolationModal: document.getElementById('close-violation-modal'),
        };

        function currentQuestion() {
            return examState.questions[examState.currentIndex] || { options: [] };
        }

        function selectedIds(question) {
            if (Array.isArray(question.selected_option_ids)) {
                return question.selected_option_ids.map(Number);
            }

            if (question.selected_option_id) {
                return [Number(question.selected_option_id)];
            }

            return [];
        }

        function isAnswered(question) {
            return selectedIds(question).length > 0;
        }

        function answeredCount() {
            return examState.questions.filter(question => isAnswered(question)).length;
        }

        function setWarning(message) {
            if (!message) {
                els.warningBanner.classList.add('hidden');
                els.warningBanner.textContent = '';
                return;
            }

            els.warningBanner.textContent = message;
            els.warningBanner.classList.remove('hidden');
        }

        function renderOptions() {
            const question = currentQuestion();
            els.questionOptions.innerHTML = '';

            question.options.forEach((option, optionIndex) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'group flex w-full items-start gap-4 rounded-2xl border px-4 py-4 text-left transition duration-200';

                const isSelected = selectedIds(question).includes(Number(option.id));

                if (isSelected) {
                    button.classList.add('border-teal-500', 'bg-teal-50');
                } else {
                    button.classList.add('border-slate-200', 'bg-slate-50/70', 'hover:border-slate-300');
                }

                const letter = document.createElement('span');
                letter.className = 'mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-semibold';
                letter.textContent = String.fromCharCode(65 + optionIndex);

                if (isSelected) {
                    letter.classList.add('border-teal-500', 'bg-teal-500', 'text-white');
                } else {
                    letter.classList.add('border-slate-300', 'text-slate-500');
                }

                const text = document.createElement('span');
                text.className = 'rich-render flex-1 text-sm md:text-base leading-7 text-slate-800';
                text.innerHTML = option.optiontext || '';

                button.appendChild(letter);
                button.appendChild(text);

                button.addEventListener('click', function () {
                    const optionId = Number(option.id);

                    if (question.allow_multiple) {
                        const ids = selectedIds(question);

                        if (ids.includes(optionId)) {
                            question.selected_option_ids = ids.filter(id => id !== optionId);
                        } else {
                            question.selected_option_ids = [...ids, optionId];
                        }

                        question.selected_option_id = question.selected_option_ids.length
                            ? question.selected_option_ids[0]
                            : null;
                    } else {
                        question.selected_option_id = optionId;
                        question.selected_option_ids = [optionId];
                    }

                    render();
                    scheduleSave();
                });

                els.questionOptions.appendChild(button);
            });
        }

        function navButtonClass(index) {
            if (index === examState.currentIndex) {
                return ['border-teal-500', 'bg-teal-500', 'text-white'];
            }

            if (examState.questions[index] && examState.questions[index].selected_option_id) {
                return ['border-teal-200', 'bg-teal-50', 'text-teal-700'];
            }

            return ['border-slate-200', 'bg-slate-50', 'text-slate-500', 'hover:border-slate-300'];
        }

        function renderNav() {
            els.questionNav.innerHTML = '';

            examState.questions.forEach(function (question, index) {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'flex h-11 items-center justify-center rounded-2xl border text-sm font-semibold transition';
                button.classList.add(...navButtonClass(index));
                button.textContent = index + 1;

                button.addEventListener('click', function () {
                    goTo(index);
                });

                els.questionNav.appendChild(button);
            });
        }

        function render() {
            const question = currentQuestion();

            els.currentQuestionNumber.textContent = examState.currentIndex + 1;
            els.answeredCount.textContent = answeredCount();
            els.questionCategory.textContent = question.allow_multiple
                ? `${question.category || 'Question'} · Plusieurs réponses possibles`
                : (question.category || 'Question');
            els.questionText.innerHTML = question.questiontext || '';
            els.questionPoints.textContent = question.ponderation ?? '';
            els.prevQuestion.disabled = examState.currentIndex === 0;
            els.nextQuestion.disabled = examState.currentIndex === examState.questions.length - 1;
            els.submitCurrentIndex.value = examState.currentIndex;
            els.violationCount.textContent = examState.violationCount;

            const allAnswered = answeredCount() === examState.questions.length && examState.questions.length > 0;
            els.submitExamButton.classList.toggle('hidden', !allAnswered);

            renderOptions();
            renderNav();
        }

        function goTo(index) {
            if (index < 0 || index >= examState.questions.length) {
                return;
            }

            examState.currentIndex = index;
            render();
            persistCurrentIndex();

            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        }

        function updateTimer() {
            const now = new Date();
            const end = new Date(examState.endsAt);
            const start = new Date(examState.startedAt);

            const totalSeconds = Math.max(1, Math.floor((end.getTime() - start.getTime()) / 1000));
            const remainingSeconds = Math.max(0, Math.floor((end.getTime() - now.getTime()) / 1000));

            const minutes = String(Math.floor(remainingSeconds / 60)).padStart(2, '0');
            const seconds = String(remainingSeconds % 60).padStart(2, '0');

            els.timerLabel.textContent = `${minutes}:${seconds}`;
            els.timerProgress.style.width = `${Math.min(100, Math.max(0, (remainingSeconds / totalSeconds) * 100))}%`;

            if (remainingSeconds === 0 && !examState.submitting) {
                autoSubmit('Le temps est écoulé. Les réponses sont soumises.');
            }
        }

        async function saveProgress(silent = false) {
            const question = currentQuestion();

            if (!question.id || examState.submitting) {
                return;
            }

            try {
                const body = new URLSearchParams();

                body.append('sesskey', examState.sesskey);
                body.append('question_phase_test_id', question.id);
                body.append('selected_option_ids', JSON.stringify(selectedIds(question)));
                body.append('current_index', examState.currentIndex);

                const response = await fetch(examState.saveUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: body.toString(),
                });

                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    if (payload.redirect_url) {
                        window.location.href = payload.redirect_url;
                        return;
                    }

                    throw new Error(payload.message || 'save_failed');
                }

                if (typeof payload.answered_count !== 'undefined') {
                    els.answeredCount.textContent = payload.answered_count;
                }

                if (!silent) {
                    setWarning('');
                }

            } catch (error) {
                if (!silent) {
                    setWarning("La sauvegarde automatique a échoué. Vérifie ta connexion avant de continuer.");
                }

                console.warn('Sauvegarde échouée', error);
            }
        }

        function scheduleSave() {
            window.clearTimeout(examState.saveTimeout);
            examState.saveTimeout = window.setTimeout(function () {
                saveProgress();
            }, 180);
        }

        function persistCurrentIndex() {
            saveProgress(true);
        }

        function showViolationModal(message) {
            els.violationModalMessage.textContent = message;
            els.violationModal.classList.remove('hidden');
            els.violationModal.classList.add('flex');
        }

        function closeViolationModal() {
            els.violationModal.classList.add('hidden');
            els.violationModal.classList.remove('flex');
        }

        async function registerViolation() {
            if (examState.submitting) {
                return;
            }

            const now = Date.now();
            if (now < examState.readyAt) {
                return;
            }

            if (now - examState.lastViolationAt < 1500) {
                return;
            }

            examState.lastViolationAt = now;
            try {
                await saveProgress(true);

                const body = new URLSearchParams();

                body.append('sesskey', examState.sesskey);
                body.append('current_index', examState.currentIndex);

                const response = await fetch(examState.violationUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: body.toString(),
                });

                if (!response.ok) {
                    return;
                }

                const payload = await response.json();

                examState.violationCount = payload.count ?? examState.violationCount;

                render();

                if (payload.auto_submitted) {
                    examState.submitting = true;

                    showViolationModal(
                        "Le nombre maximal de tentatives a été atteint. L'évaluation a été soumise automatiquement."
                    );

                    window.setTimeout(function () {
                        window.location.href = payload.redirect_url || examState.redirectUrl;
                    }, 1800);

                    return;
                }

                showViolationModal(
                    `Tentative détectée. Il te reste ${payload.remaining} tentative(s) avant soumission automatique.`
                );

            } catch (error) {
                console.warn('Violation non enregistrée', error);
            }
        }

        async function autoSubmit(message) {
            examState.submitting = true;
            setWarning(message);
            els.submitAutoSubmitted.value = '1';
            await saveProgress(true);
            els.examSubmitForm.submit();
        }

        function blockBackNavigation() {
            history.pushState(null, '', window.location.href);

            window.addEventListener('popstate', function () {
                history.pushState(null, '', window.location.href);
            });
        }

        els.prevQuestion.addEventListener('click', function () {
            goTo(examState.currentIndex - 1);
        });

        els.nextQuestion.addEventListener('click', function () {
            goTo(examState.currentIndex + 1);
        });

        els.closeViolationModal.addEventListener('click', closeViolationModal);

        els.examSubmitForm.addEventListener('submit', function () {
            examState.submitting = true;
        });

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                registerViolation();
            }
        });

        window.addEventListener('blur', function () {
            registerViolation();
        });

        examState.countdownInterval = window.setInterval(updateTimer, 1000);

        blockBackNavigation();
        updateTimer();
        render();
        persistCurrentIndex();
    });
</script>