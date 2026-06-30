<?php require(__DIR__ . '/../partials/topbar.php'); ?>
<nav class="flex justify-between items-center my-3" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= new moodle_url('/local/scholarship/admin/') ?>"
                class="inline-flex items-center font-medium text-gray-700 hover:text-indigo-800 text-base">
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="mx-1 w-5 h-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                        stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ml-1 md:ml-2 font-medium text-gray-700 text-base">
                    <?= get_string('admin_interviews_title', 'local_scholarship') ?>
                </span>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="mx-1 w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                        stroke="#E5E7EB" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                    style="margin-right: 0.5rem;">
                    <path fill-rule="evenodd"
                        d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                        clip-rule="evenodd" />
                    <path fill-rule="evenodd"
                        d="M2 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm6.585 1.08a.75.75 0 0 1 .336 1.005l-1.75 3.5a.75.75 0 0 1-1.16.234l-1.75-1.5a.75.75 0 0 1 .977-1.139l1.02.875 1.321-2.64a.75.75 0 0 1 1.006-.336Z"
                        clip-rule="evenodd" />
                </svg>
                <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base">
                    <?= $currentEdition->name ?>
                </span>
            </div>
        </li>
    </ol>

    <div class="float-right flex items-center space-x-2">
        <a id="closeVote" href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
            data-phase-id="" data-phase-status="COMPLETED"
            data-phase-message="Voulez-vous cloturer cette phase ?"
            data-phase-route="<?= new moodle_url('/local/scholarship/admin/tests/') ?>"
            class="inline-flex items-center bg-[#fe042c] hover:bg-[#fe042c]/80 dark:hover:bg-[#fe042c]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#fe042c]/50 focus:ring-4 dark:focus:ring-[#fe042c]/40 font-medium text-white text-sm text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                style="margin-right: 0.5rem; display:none">
                <path fill-rule="evenodd"
                    d="M6.455 1.45A.5.5 0 0 1 6.952 1h2.096a.5.5 0 0 1 .497.45l.186 1.858a4.996 4.996 0 0 1 1.466.848l1.703-.769a.5.5 0 0 1 .639.206l1.047 1.814a.5.5 0 0 1-.14.656l-1.517 1.09a5.026 5.026 0 0 1 0 1.694l1.516 1.09a.5.5 0 0 1 .141.656l-1.047 1.814a.5.5 0 0 1-.639.206l-1.703-.768c-.433.36-.928.649-1.466.847l-.186 1.858a.5.5 0 0 1-.497.45H6.952a.5.5 0 0 1-.497-.45l-.186-1.858a4.993 4.993 0 0 1-1.466-.848l-1.703.769a.5.5 0 0 1-.639-.206l-1.047-1.814a.5.5 0 0 1 .14-.656l1.517-1.09a5.033 5.033 0 0 1 0-1.694l-1.516-1.09a.5.5 0 0 1-.141-.656L2.46 3.593a.5.5 0 0 1 .639-.206l1.703.769c.433-.36.928-.65 1.466-.848l.186-1.858Zm-.177 7.567-.022-.037a2 2 0 0 1 3.466-1.997l.022.037a2 2 0 0 1-3.466 1.997Z"
                    clip-rule="evenodd" />
            </svg>
            <p class="flex justify-inline items-center">Clôturer la phase</p>
        </a>

        <button type="button" id="dropdownLeftButtonStatus" data-dropdown-toggle="dropdownLeftStatus"
            data-dropdown-placement="left"
            class="inline-flex items-center bg-[#fe042c] hover:bg-[#fe042c]/80 dark:hover:bg-[#fe042c]/80 px-3 py-2 rounded-lg focus:outline-none focus:ring-[#fe042c]/50 focus:ring-4 dark:focus:ring-[#fe042c]/40 font-medium text-white text-sm text-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4"
                style="margin-right: 0.5rem;">
                <path fill-rule="evenodd"
                    d="M6.455 1.45A.5.5 0 0 1 6.952 1h2.096a.5.5 0 0 1 .497.45l.186 1.858a4.996 4.996 0 0 1 1.466.848l1.703-.769a.5.5 0 0 1 .639.206l1.047 1.814a.5.5 0 0 1-.14.656l-1.517 1.09a5.026 5.026 0 0 1 0 1.694l1.516 1.09a.5.5 0 0 1 .141.656l-1.047 1.814a.5.5 0 0 1-.639.206l-1.703-.768c-.433.36-.928.649-1.466.847l-.186 1.858a.5.5 0 0 1-.497.45H6.952a.5.5 0 0 1-.497-.45l-.186-1.858a4.993 4.993 0 0 1-1.466-.848l-1.703.769a.5.5 0 0 1-.639-.206l-1.047-1.814a.5.5 0 0 1 .14-.656l1.517-1.09a5.033 5.033 0 0 1 0-1.694l-1.516-1.09a.5.5 0 0 1-.141-.656L2.46 3.593a.5.5 0 0 1 .639-.206l1.703.769c.433-.36.928-.65 1.466-.848l.186-1.858Zm-.177 7.567-.022-.037a2 2 0 0 1 3.466-1.997l.022.037a2 2 0 0 1-3.466 1.997Z"
                    clip-rule="evenodd" />
            </svg>
            <p class="flex justify-inline items-center">Changer statut</p>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownLeftStatus"
            class="hidden z-10 bg-white shadow rounded-lg divide-y divide-gray-100 dark:divide-gray-600 w-15">

            <ul class="py-1 text-gray-700 text-xs" aria-labelledby="dropdownLeftButtonStatus">
                <li id="enCours" style="margin-right: 0.2rem; margin-left: 0.2rem;">
                    <?php $message = 'Voulez-vous lancer cette phase?'; ?>
                    <a href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
                        data-phase-id="" data-phase-status="IN_PROGRESS"
                        data-phase-message="Voulez-vous lancer cette phase ?"
                        data-phase-route="<?= new moodle_url('/local/scholarship/admin/tests/') ?>"
                        class="inline-flex items-center hover:bg-blue-100 dark:hover:bg-blue-600 px-3 py-1 rounded-md dark:hover:text-white text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="flex justify-inline items-center" style="margin-left: 0.2rem;">
                            Lancer la phase
                        </p>
                    </a>
                </li>

                <li id="fermer" style="margin-right: 0.2rem; margin-left: 0.2rem;">
                    <?php $message = 'Voulez-vous fermer cette phase?'; ?>
                    <a href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
                        data-phase-id="" data-phase-status="CANCELLED"
                        data-phase-message="Voulez-vous fermer cette phase ?"
                        data-phase-route="<?= new moodle_url('/local/scholarship/admin/tests/') ?>"
                        class="inline-flex items-center hover:bg-red-100 dark:hover:bg-red-600 px-3 py-1 rounded-md dark:hover:text-white text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-5">
                            <path
                                d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z" />
                        </svg>
                        <p class="flex justify-inline items-center" style="margin-left: 0.2rem;">
                            Fermer la phase
                        </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>