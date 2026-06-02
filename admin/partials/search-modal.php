<!-- Search Modal -->
<div id="searchModal" class="hidden z-50 fixed inset-0 mt-10 overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="sm:block flex justify-center items-center sm:p-0 px-4 pt-4 pb-20 min-h-screen text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modalBackdrop">
        </div>

        <!-- Modal panel -->
        <div
            class="inline-block bg-white shadow-xl sm:my-8 rounded-lg sm:w-full sm:max-w-lg overflow-hidden text-left sm:align-middle align-bottom transition-all transform">
            <div class="sm:p-6 px-4 pt-5 pb-4 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 sm:mt-0 sm:ml-4 w-full sm:text-left text-center">
                        <h3 class="mb-4 font-medium text-gray-900 text-lg leading-6" id="modal-title">
                            Rechercher un candidat
                        </h3>

                        <!-- Search input -->
                        <div class="relative">
                            <input type="text" id="searchInput"
                                class="px-4 py-2 pr-3 pl-5 border border-gray-300 focus:border-blue-500 rounded-lg focus:ring-2 focus:ring-blue-500 w-full text-sm"
                                placeholder="<?= get_string('applicants_search_placeholder', 'local_scholarship') ?>"
                                autocomplete="off">
                            <div class="left-0 absolute inset-y-0 flex items-center pl-2 pe-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Search results -->
                        <div id="searchResults" class="hidden mt-4 max-h-60 overflow-y-auto">
                            <ul class="divide-y divide-gray-200">
                                <!-- Results will be inserted here by JavaScript -->
                            </ul>
                        </div>

                        <div id="noResults" class="hidden mt-4 text-gray-500 dark:text-gray-400 text-center">
                            <?= get_string('applicants_no_results', 'local_scholarship') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm:flex sm:flex-row-reverse bg-gray-50 px-4 sm:px-6 py-3">
                <button type="button" id="closeModal" class="bg-blue-600 hover:bg-blue-700 text-white btn">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>