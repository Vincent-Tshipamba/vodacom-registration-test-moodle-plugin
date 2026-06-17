<?php require(__DIR__ . '/../partials/topbar.php'); ?>
<?php
$phasefields = [
    [
        'name' => 'durationmin',
        'label' => 'Durée du test',
        'type' => 'number',
        'icon' => 'timer',
    ],
    [
        'name' => 'starttime',
        'label' => 'Heure de début',
        'type' => 'datetime-local',
        'icon' => 'calendar-clock',
    ],
    [
        'name' => 'endtime',
        'label' => 'Heure de fin',
        'type' => 'datetime-local',
        'icon' => 'calendar-check',
    ],
    [
        'name' => 'passingscore',
        'label' => 'Score de réussite',
        'type' => 'number',
        'icon' => 'badge-check',
    ],
];

$payload = json_encode($phasePayload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>


<script src="<?= new moodle_url('/local/scholarship/assets/js/init-phasetest.js') ?>"></script>

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
                <span
                    class="ml-1 md:ml-2 font-medium text-gray-700 text-base"><?= get_string('admin_tests_title', 'local_scholarship') ?></span>
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
                <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base"><?= $currentEdition->name ?></span>
            </div>
        </li>
    </ol>

    <div class="float-right flex items-center space-x-2">
        <a id="closeVote" href="#" data-modal-target="status-modal" data-modal-toggle="status-modal"
            data-phase-id="<?= $phasePayload['id'] ?>" data-phase-status="COMPLETED"
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
                        data-phase-id="<?= $phasePayload['id'] ?>" data-phase-status="IN_PROGRESS"
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
                        data-phase-id="<?= $phasePayload['id'] ?>" data-phase-status="CANCELLED"
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

<div id="scholarship-phase-editor"
    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">

    <script type="application/json" id="test-phase-payload">
        <?= $payload ?>
    </script>

    <div class="flex justify-between items-center mb-5">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Configuration du test
            </h2>
            <p class="text-sm text-gray-500">
                Édition :
                <?= s($currentEdition->name) ?>
            </p>
        </div>

        <span data-phase-status class="px-3 py-1 rounded-full text-xs font-semibold">
        </span>
    </div>

    <dl class="divide-y divide-gray-200">
        <?php foreach ($phasefields as $field): ?>
            <div class="flex justify-between items-center py-2 gap-3" data-phase-row data-field="<?= s($field['name']) ?>"
                data-type="<?= s($field['type']) ?>">

                <dt class="flex items-center gap-2 text-gray-500">
                    <i data-lucide="<?= s($field['icon']) ?>" class="w-4 h-4"></i>
                    <span><?= s($field['label']) ?></span>
                </dt>

                <dd class="flex-1 text-right">

                    <div data-view-mode class="flex justify-end items-center gap-3">
                        <span data-phase-display class="font-semibold text-gray-900">
                            Non défini
                        </span>

                        <button type="button" data-action="edit" class="text-blue-600 hover:underline text-sm">
                            Modifier
                        </button>
                    </div>

                    <div data-edit-mode class="hidden justify-end items-center gap-2">
                        <input type="<?= s($field['type']) ?>" data-phase-input
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-56">

                        <button type="button" data-action="save"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">
                            Sauver
                        </button>

                        <button type="button" data-action="cancel" class="text-gray-500 hover:text-gray-700 text-sm">
                            ✕
                        </button>
                    </div>

                </dd>
            </div>
        <?php endforeach; ?>
    </dl>
</div>

<div class="mb-4 border-gray-500 border-b">
    <ul class="flex flex-wrap -mb-px font-medium text-sm text-center" id="default-styled-tab"
        data-tabs-toggle="#default-styled-tab-content"
        data-tabs-active-classes="text-[#fe042c] hover:text-[#fe042c] border-[#fe042c]"
        data-tabs-inactive-classes="dark:border-transparent text-gray-700 hover:text-gray-800 border-default hover:border-gray-700"
        role="tablist">
        <li class="me-2" role="presentation">
            <button class="flex space-x-1 p-4 border-b-2 rounded-t-base" id="dashboard-styled-tab"
                data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard"
                aria-selected="false">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </button>
        </li>
        <li class="me-2" role="presentation">
            <button class="flex space-x-1 p-4 hover:border-brand border-b-2 rounded-medium hover:text-fg-brand"
                id="candidats-styled-tab" data-tabs-target="#styled-candidats" type="button" role="tab"
                aria-controls="candidats" aria-selected="false">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Candidats</span>
            </button>
        </li>
        <li class="me-2" role="presentation">
            <button class="flex space-x-1 p-4 hover:border-brand border-b-2 rounded-t-base hover:text-fg-brand"
                id="results-styled-tab" data-tabs-target="#styled-results" type="button" role="tab"
                aria-controls="results" aria-selected="false">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
                <span>Résultats</span>
            </button>
        </li>
        <li class="me-2" role="presentation">
            <button class="flex space-x-1 p-4 hover:border-brand border-b-2 rounded-t-base hover:text-fg-brand"
                id="questions-styled-tab" data-tabs-target="#styled-questions" type="button" role="tab"
                aria-controls="questions" aria-selected="false">
                <i data-lucide="circle-question-mark" class="w-5 h-5"></i>
                <span>Questions</span>
            </button>
        </li>
    </ul>
</div>

<div id="default-styled-tab-content">
    <div class="hidden bg-gray-300 p-4 rounded-sm" id="styled-dashboard" role="tabpanel"
        aria-labelledby="dashboard-styled-tab">
        <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3">
            <!-- Stats candidats -->
            <div class="bg-white shadow mr-2 p-4 md:p-6 rounded-lg w-full">
                <div class="flex justify-between">
                    <div class="flex items-center mb-3">
                        <h5 class="pe-1 font-bold text-gray-900 text-xl leading-none">
                            Stats des candidats
                        </h5>
                        <i data-popover-target="chart-info" data-popover-placement="right" data-lucide="circle-help"
                            class="ms-1 w-4 h-4 text-gray-500"></i>
                        <div data-popover id="chart-info" role="tooltip"
                            class="invisible inline-block z-10 absolute bg-white dark:bg-gray-800 opacity-0 shadow-sm border border-gray-200 dark:border-gray-600 rounded-lg w-72 text-gray-500 dark:text-gray-400 text-sm transition-opacity duration-300">
                            <div class="space-y-2 p-3">
                                <h3 class="font-semibold text-gray-900">Total</h3>
                                <p>
                                    <?= get_string('total_explaination', 'local_scholarship') ?>
                                </p>
                                <h3 class="font-semibold text-gray-900">
                                    <?= get_string('FEMALE', 'local_scholarship') ?>
                                </h3>
                                <p>
                                    <?= get_string('female_explaination', 'local_scholarship') ?>
                                </p>
                                <h3 class="font-semibold text-gray-900">
                                    <?= get_string('MALE', 'local_scholarship') ?>
                                </h3>
                                <p>
                                    <?= get_string('male_explaination', 'local_scholarship') ?>
                                </p>
                                <h3 class="font-semibold text-gray-900">Start</h3>
                                <p>
                                    <?= get_string('start_explaination', 'local_scholarship') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="gap-4 grid grid-cols-<?= $testDashboardStats->ismixed ? '4' : '2' ?> mb-2">

                        <dl class="flex flex-col justify-center items-center bg-orange-50 rounded-lg h-[78px]">
                            <dt
                                class="flex justify-center items-center bg-orange-100 mb-1 rounded-full w-8 h-8 font-medium text-[#ff1453] text-sm">
                                <?= (int) $testDashboardStats->shortlisted ?>
                            </dt>
                            <dd class="font-medium text-[#ff1453] text-sm">Total</dd>
                        </dl>

                        <?php if ($testDashboardStats->ismixed): ?>
                            <dl class="flex flex-col justify-center items-center bg-teal-50 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-teal-100 mb-1 rounded-full w-8 h-8 font-medium text-teal-600 text-sm">
                                    <?= (int) $testDashboardStats->shortlistedfemale ?>
                                </dt>
                                <dd class="font-medium text-teal-600 text-sm">Filles</dd>
                            </dl>

                            <dl class="flex flex-col justify-center items-center bg-blue-50 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-blue-100 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 text-sm">
                                    <?= (int) $testDashboardStats->shortlistedmale ?>
                                </dt>
                                <dd class="font-medium text-blue-600 text-sm">Garçons</dd>
                            </dl>
                        <?php endif; ?>

                        <dl class="flex flex-col justify-center items-center bg-indigo-50 rounded-lg h-[78px]">
                            <dt
                                class="flex justify-center items-center bg-indigo-100 mb-1 rounded-full w-8 h-8 font-medium text-indigo-600 text-sm">
                                <?= (int) $testDashboardStats->started ?>
                            </dt>
                            <dd class="font-medium text-indigo-600 text-sm">Start</dd>
                        </dl>

                    </div>
                </div>
            </div>

            <!-- Stats évaluation -->
            <div class="bg-white shadow mr-2 p-4 md:p-6 rounded-lg w-full">
                <div class="flex justify-between">
                    <div class="flex items-center mb-3">
                        <h5 class="pe-1 font-bold text-gray-900 text-xl leading-none">
                            Stats de l'évaluation
                        </h5>
                        <i data-lucide="circle-help" class="ms-1 w-4 h-4 text-gray-500"></i>
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="gap-4 grid grid-cols-<?= $testDashboardStats->ismixed ? '4' : '2' ?> mb-2">

                        <dl class="flex flex-col justify-center items-center bg-blue-50 rounded-lg h-[78px]">
                            <dt
                                class="flex justify-center items-center bg-blue-100 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 text-sm">
                                <?= (int) $testDashboardStats->passed ?>
                            </dt>
                            <dd class="font-medium text-blue-600 text-sm">Réussites</dd>
                        </dl>

                        <dl class="flex flex-col justify-center items-center bg-red-50 rounded-lg h-[78px]">
                            <dt
                                class="flex justify-center items-center bg-red-100 mb-1 rounded-full w-8 h-8 font-medium text-red-600 text-sm">
                                <?= (int) $testDashboardStats->failed ?>
                            </dt>
                            <dd class="font-medium text-red-600 text-sm">Échecs</dd>
                        </dl>

                        <?php if ($testDashboardStats->ismixed): ?>
                            <dl class="flex flex-col justify-center items-center bg-blue-50 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-blue-100 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 text-sm">
                                    <?= (int) $testDashboardStats->passedmale ?>
                                </dt>
                                <dd class="font-medium text-blue-600 text-sm">Garçons</dd>
                            </dl>

                            <dl class="flex flex-col justify-center items-center bg-teal-50 rounded-lg h-[78px]">
                                <dt
                                    class="flex justify-center items-center bg-teal-100 mb-1 rounded-full w-8 h-8 font-medium text-teal-600 text-sm">
                                    <?= (int) $testDashboardStats->passedfemale ?>
                                </dt>
                                <dd class="font-medium text-teal-600 text-sm">Filles</dd>
                            </dl>
                        <?php endif; ?>

                    </div>

                    <p class="mt-3 text-center text-gray-500 text-xs">
                        Taux de réussite :
                        <span class="font-semibold text-green-600">
                            <?= $testDashboardStats->completed > 0
                                ? round(($testDashboardStats->passed / $testDashboardStats->completed) * 100, 1)
                                : 0 ?>%
                        </span>
                    </p>
                </div>
            </div>

            <!-- Stats questions -->
            <div class="bg-white shadow mr-2 p-4 md:p-6 rounded-lg w-full">
                <div class="flex justify-between">
                    <div class="flex items-center mb-3">
                        <h5 class="pe-1 font-bold text-gray-900 text-xl leading-none">
                            Stats des questions
                        </h5>
                        <i data-lucide="circle-help" class="ms-1 w-4 h-4 text-gray-500"></i>
                    </div>
                </div>

                <div class="bg-gray-50 p-3 rounded-lg">
                    <dl class="flex flex-col justify-center items-center bg-blue-50 rounded-lg h-[78px]">
                        <dt
                            class="flex justify-center items-center bg-blue-100 mb-1 rounded-full w-8 h-8 font-medium text-blue-600 text-sm">
                            <?= (int) $testDashboardStats->questions ?>
                        </dt>
                        <dd class="font-medium text-blue-600 text-sm">Total</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden bg-gray-300 p-4 rounded-sm" id="styled-candidats" role="tabpanel"
        aria-labelledby="candidats-tab">
        <div class="relative shadow-md sm:rounded-lg overflow-x-auto" style="padding-top: 10px;">
            <div class="mb-4 border-default border-b">
                <ul class="flex flex-wrap -mb-px font-medium text-sm text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button
                            class="flex items-center space-x-2 p-4 hover:border-brand border-b-2 rounded-full hover:text-fg-brand"
                            id="list-candidats-tab" data-tabs-target="#listCandidats" type="button" role="tab"
                            aria-controls="listCandidats" aria-selected="true">
                            <i data-lucide="list" class="w-5 h-5"></i>
                            <span>Liste</span>
                        </button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="flex items-center space-x-2 p-4 border-b-2 rounded-full text-gray-900"
                            id="grid-tab" data-tabs-target="#grid" type="button" role="tab" aria-controls="grid"
                            aria-selected="false">
                            <i data-lucide="layout-grid" class="w-5 h-5"></i>
                            <span>Grid view</span>
                        </button>
                    </li>

                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden bg-gray-300 p-4 rounded-base text-gray-900 dark:text-gray-300" id="grid"
                    role="tabpanel" aria-labelledby="grid-tab">
                    <div class="grid gap-5 grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
                        <?php foreach ($testCandidates as $candidate): ?>

                            <?php
                            $statusColor = 'bg-gray-100 text-gray-600';

                            if ($candidate->teststatus === 'COMPLETED') {
                                $statusColor = 'bg-green-100 text-green-700';
                            }

                            if ($candidate->teststatus === 'IN_PROGRESS') {
                                $statusColor = 'bg-blue-100 text-blue-700';
                            }

                            if ($candidate->teststatus === 'FAILED') {
                                $statusColor = 'bg-red-100 text-red-700';
                            }
                            ?>

                            <div
                                class="bg-white shadow-sm hover:shadow-md border border-gray-200 rounded-xl overflow-hidden transition">
                                <div class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex justify-center items-center bg-indigo-100 rounded-full w-14 h-14 font-bold text-indigo-700 text-lg">
                                            <?= strtoupper(substr($candidate->fullname, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">
                                                <?= s($candidate->fullname) ?>
                                            </h3>
                                            <p class="text-gray-500 text-sm">
                                                <?= s($candidate->regcode) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 mx-auto text-center">
                                        <?php if (!$candidate->testsessionid): ?>
                                            <span
                                                class="px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold text-center">
                                                Non commencé
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold text-center">
                                                <?= s($candidate->teststatus) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="gap-3 grid grid-cols-2 mt-5 text-sm">
                                        <div>
                                            <p class="text-gray-500">Téléphone</p>
                                            <p class="font-medium text-gray-800">
                                                <?= s($candidate->phone ?: '-') ?>
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-gray-500">Score</p>
                                            <p class="font-medium text-gray-800">
                                                <?= $candidate->totalscore ?? '-' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex border-gray-100 border-t">
                                    <a href="#" class="flex-1 hover:bg-gray-50 py-3 text-center text-indigo-600 text-sm">
                                        Voir résultat
                                    </a>
                                    <div class="bg-gray-100 w-px"></div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="hidden bg-neutral-secondary-soft p-4 rounded-base" id="listCandidats" role="tabpanel"
                    aria-labelledby="list-candidats-tab">
                    <div class="bg-white border border-gray-200 rounded-xl p-5">

                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Candidats au test</h2>
                                <p class="text-sm text-gray-500">
                                    Liste des candidats de l’édition en cours
                                </p>
                            </div>

                            <button class="bg-[#fe042c] hover:bg-[#fe042c]/80 text-white px-4 py-2 rounded-lg text-sm">
                                Envoyer les SMS
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left" id="test-candidates-table">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-4 py-3">#</th>
                                        <th class="px-4 py-3">Candidat</th>
                                        <th class="px-4 py-3">Genre</th>
                                        <th class="px-4 py-3">Téléphone</th>
                                        <th class="px-4 py-3">Code</th>
                                        <th class="px-4 py-3">Statut test</th>
                                        <th class="px-4 py-3">Score</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                    <?php foreach ($testCandidates as $i => $candidate): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <?= $i + 1 ?>
                                            </td>

                                            <td class="px-4 py-3 font-semibold text-gray-900">
                                                <?= s($candidate->fullname) ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?= get_string(strtoupper($candidate->gender), 'local_scholarship') ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?= s($candidate->phone ?: '-') ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?= s($candidate->regcode ?: '-') ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?php if ($candidate->testsessionid): ?>
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                                        <?= s($candidate->teststatus) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span
                                                        class="px-2 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                                        Non planifié
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="px-4 py-3">
                                                <?= $candidate->totalscore !== null ? s($candidate->totalscore) : '-' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hidden bg-gray-300 p-4 rounded-sm" id="styled-results" role="tabpanel"
        aria-labelledby="results-styled-tab">

        <div class="space-y-5">
            <button type="button" id="promotePassedButton"
                class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg text-white text-sm font-semibold">
                Promouvoir les réussis
            </button>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                <div class="bg-white shadow p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Complétés</p>
                    <p class="mt-2 font-semibold text-gray-900 text-2xl">
                        <?= (int) $testResultsStats->completed ?>
                    </p>
                </div>

                <div class="bg-white shadow p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Réussites</p>
                    <p class="mt-2 font-semibold text-emerald-600 text-2xl">
                        <?= (int) $testResultsStats->passed ?>
                    </p>
                </div>

                <div class="bg-white shadow p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Échecs</p>
                    <p class="mt-2 font-semibold text-rose-600 text-2xl">
                        <?= (int) $testResultsStats->failed ?>
                    </p>
                </div>

                <div class="bg-white shadow p-4 rounded-lg">
                    <p class="text-gray-500 text-xs uppercase tracking-wider">Auto-submit</p>
                    <p class="mt-2 font-semibold text-gray-900 text-2xl">
                        <?= (int) $testResultsStats->autosubmitted ?>
                    </p>
                </div>
            </div>

            <div class="bg-white shadow p-4 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg">
                            Résultats de la phase
                        </h3>
                        <p class="text-gray-500 text-sm">
                            Classement des candidats ayant terminé le test.
                        </p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-x-auto">
                    <table class="w-full text-sm text-left display" id="results-table">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Candidat</th>
                                <th class="px-4 py-3">Genre</th>
                                <th class="px-4 py-3">Téléphone</th>
                                <th class="px-4 py-3">Score</th>
                                <th class="px-4 py-3">%</th>
                                <th class="px-4 py-3">Statut</th>
                                <th class="px-4 py-3">Triche</th>
                                <th class="px-4 py-3">Auto</th>
                                <th class="px-4 py-3">Durée</th>
                                <th class="px-4 py-3">Fin</th>
                                <th class="px-4 py-3 not-export">Détail</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($testResults as $index => $result): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3"><?= $index + 1 ?></td>

                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900">
                                            <?= s($result->fullname) ?>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <?= s($result->regcode ?: '-') ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= s($result->gender ?: '-') ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= s($result->phone ?: '-') ?>
                                    </td>

                                    <td class="px-4 py-3" data-order="<?= (float) $result->totalscore ?>">
                                        <?= number_format((float) $result->totalscore, 2) ?>
                                        /
                                        <?= number_format((float) $result->totalpoints, 2) ?>
                                    </td>

                                    <td class="px-4 py-3" data-order="<?= (float) $result->percentage ?>">
                                        <?= number_format((float) $result->percentage, 2) ?>%
                                    </td>

                                    <td class="px-4 py-3">
                                        <?php if ((int) $result->ispassed === 1): ?>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                                Réussi
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-medium">
                                                Échoué
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= (int) $result->cheatingattempts ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= (int) $result->autosubmitted === 1 ? 'Oui' : 'Non' ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= s($result->duration) ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= !empty($result->endtime) ? userdate($result->endtime) : '-' ?>
                                    </td>
                                    <td class="px-4 py-3 not-export">
                                        <button type="button"
                                            class="inline-flex items-center bg-cyan-700 hover:bg-cyan-800 px-3 py-1.5 rounded-lg text-white text-xs result-detail-trigger"
                                            data-session-id="<?= (int) $result->sessionid ?>"
                                            data-candidate-name="<?= s($result->fullname) ?>"
                                            data-score="<?= number_format((float) $result->percentage, 2) ?>%"
                                            data-status="<?= (int) $result->ispassed === 1 ? 'Réussi' : 'Échoué' ?>">
                                            Voir
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="result-detail-modal" class="hidden z-[5000] fixed inset-0 bg-gray-950/60 p-4 overflow-y-auto">
            <div class="mx-auto mt-10 max-w-4xl">
                <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-gray-200 border-b">
                        <div>
                            <h3 id="result-detail-title" class="font-semibold text-gray-900 text-lg"></h3>
                            <p id="result-detail-meta" class="text-gray-500 text-sm"></p>
                        </div>

                        <button type="button" id="result-detail-close"
                            class="inline-flex justify-center items-center hover:bg-gray-100 rounded-lg w-10 h-10 text-gray-500">
                            ✕
                        </button>
                    </div>

                    <div id="result-detail-body" class="space-y-4 bg-gray-100 p-6"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.scholarshipQuestionsData = <?= $questionsjson ?>;
    </script>

    <div class="hidden bg-gray-300 p-4 rounded-base" id="styled-questions" role="tabpanel"
        aria-labelledby="questions-tab">
    </div>
</div>

<?php require(__DIR__ . '/../../partials/cdn-datatables.php') ?>
<?php require(__DIR__ . '/../partials/change-phase-status.php') ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('scholarship-phase-editor');
        const payloadScript = document.getElementById('test-phase-payload');
        const config = document.getElementById('scholarship-test-config');

        if (!container || !payloadScript) {
            return;
        }

        let initialPhase = {};

        try {
            initialPhase = JSON.parse(payloadScript.textContent || '{}');
        } catch (error) {
            console.error('Payload phase invalide', error);
            initialPhase = {};
        }

        initTestPhaseEditor(config, container, initialPhase);
    });

    function initTestPhaseEditor(config, container, initialPhase) {
        const state = {
            phase: initialPhase || {},
            editing: {},
            values: {},
        };

        const fields = [
            {
                name: 'durationmin',
                type: 'number',
            },
            {
                name: 'starttime',
                type: 'datetime-local',
            },
            {
                name: 'endtime',
                type: 'datetime-local',
            },
            {
                name: 'passingscore',
                type: 'number',
            },
        ];

        fields.forEach(function (field) {
            state.editing[field.name] = false;
            state.values[field.name] = normalizeInputValue(field.name, state.phase[field.name]);
        });

        function normalizeInputValue(field, value) {
            if (!value) {
                return '';
            }

            if (field === 'starttime' || field === 'endtime') {
                return toDatetimeLocal(value);
            }

            return value;
        }

        function toDatetimeLocal(value) {
            if (!value) {
                return '';
            }

            if (typeof value === 'string' && value.includes('T')) {
                return value.substring(0, 16);
            }

            const timestamp = Number(value);

            if (!timestamp) {
                return '';
            }

            const date = new Date(timestamp * 1000);
            date.setMinutes(date.getMinutes() - date.getTimezoneOffset());

            return date.toISOString().slice(0, 16);
        }

        function displayValue(field) {
            const value = state.phase[field];

            if (!value) {
                return 'Non défini';
            }

            if (field === 'durationmin') {
                return value + ' min';
            }

            if (field === 'passingscore') {
                return value + ' %';
            }

            if (field === 'starttime' || field === 'endtime') {
                return formatDateTime(value);
            }

            return value;
        }

        function formatDateTime(value) {
            if (!value) {
                return 'Non défini';
            }

            let date;

            if (typeof value === 'string' && value.includes('T')) {
                date = new Date(value);
            } else {
                date = new Date(Number(value) * 1000);
            }

            if (isNaN(date.getTime())) {
                return value;
            }

            return date.toLocaleString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
            });
        }

        function statusClass(status) {
            if (status === 'AWAITING') {
                return 'bg-yellow-100 text-yellow-700';
            }

            if (status === 'IN_PROGRESS') {
                return 'bg-green-100 text-green-700';
            }

            if (status === 'COMPLETED') {
                return 'bg-blue-100 text-blue-700';
            }

            if (status === 'CANCELLED') {
                return 'bg-red-100 text-red-700';
            }

            return 'bg-gray-100 text-gray-700';
        }

        function renderStatus() {
            const badge = container.querySelector('[data-phase-status]');

            if (!badge) {
                return;
            }

            const status = state.phase.status || 'draft';

            badge.textContent = status;
            badge.className = 'px-3 py-1 rounded-full text-xs font-semibold ' + statusClass(status);
        }

        function renderRow(field) {
            const row = container.querySelector('[data-phase-row][data-field="' + field + '"]');

            if (!row) {
                return;
            }

            const viewMode = row.querySelector('[data-view-mode]');
            const editMode = row.querySelector('[data-edit-mode]');
            const display = row.querySelector('[data-phase-display]');
            const input = row.querySelector('[data-phase-input]');

            if (display) {
                display.textContent = displayValue(field);
            }

            if (input) {
                input.value = state.values[field] ?? '';
            }

            if (state.editing[field]) {
                viewMode.classList.add('hidden');
                viewMode.classList.remove('flex');

                editMode.classList.remove('hidden');
                editMode.classList.add('flex');
            } else {
                editMode.classList.add('hidden');
                editMode.classList.remove('flex');

                viewMode.classList.remove('hidden');
                viewMode.classList.add('flex');
            }
        }

        function render() {
            fields.forEach(function (field) {
                renderRow(field.name);
            });

            renderStatus();

            if (window.lucide) {
                window.lucide.createIcons({
                    icons: window.lucide.icons
                });
            }
        }

        function edit(field) {
            state.editing[field] = true;
            state.values[field] = normalizeInputValue(field, state.phase[field]);

            renderRow(field);

            const row = container.querySelector('[data-phase-row][data-field="' + field + '"]');
            const input = row ? row.querySelector('[data-phase-input]') : null;

            if (input) {
                input.focus();
            }
        }

        function cancel(field) {
            state.editing[field] = false;
            state.values[field] = normalizeInputValue(field, state.phase[field]);

            renderRow(field);
        }

        async function save(field) {
            const row = container.querySelector('[data-phase-row][data-field="' + field + '"]');
            const input = row ? row.querySelector('[data-phase-input]') : null;

            if (!input) {
                return;
            }

            state.values[field] = input.value;

            const formData = new FormData();

            formData.append('sesskey', config.dataset.sesskey);
            formData.append('field', field);
            formData.append('value', state.values[field]);
            formData.append('editionid', state.phase.editionid || '');

            if (state.phase.id) {
                formData.append('id', state.phase.id);
            }
            
            try {
                const response = await fetch(config.dataset.updateUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        Accept: 'application/json',
                    },
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    showError(result.message || 'Erreur serveur');
                    return;
                }

                state.phase = result.phase || state.phase;
                state.values[field] = normalizeInputValue(field, state.phase[field]);
                state.editing[field] = false;

                render();

                showSuccess('Modification enregistrée');

            } catch (error) {
                console.error(error);
                showError('Erreur de connexion avec le serveur.');
            }
        }

        function showError(message) {
            if (window.Swal) {
                Swal.fire('Erreur', message || 'Erreur serveur', 'error');
                return;
            }

            alert(message || 'Erreur serveur');
        }

        function showSuccess(message) {
            if (window.Swal) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 2500,
                });

                return;
            }

            console.log(message);
        }

        container.addEventListener('click', function (event) {
            const button = event.target.closest('[data-action]');

            if (!button) {
                return;
            }

            const row = button.closest('[data-phase-row]');

            if (!row) {
                return;
            }

            const field = row.dataset.field;
            const action = button.dataset.action;

            if (action === 'edit') {
                edit(field);
                return;
            }

            if (action === 'cancel') {
                cancel(field);
                return;
            }

            if (action === 'save') {
                save(field);
            }
        });

        container.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter') {
                return;
            }

            const input = event.target.closest('[data-phase-input]');

            if (!input) {
                return;
            }

            const row = input.closest('[data-phase-row]');

            if (!row) {
                return;
            }

            event.preventDefault();

            save(row.dataset.field);
        });

        render();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('[data-phase-status]');
        const form = document.getElementById('phase-status-form');
        const statusInput = document.getElementById('phase-status-value');
        const phaseInput = document.getElementById('phase-status-id');
        const message = document.getElementById('phase-status-message');

        triggers.forEach((trigger) => {
            trigger.addEventListener('click', function () {
                const route = this.dataset.phaseRoute || '';
                if (!route) {
                    return;
                }

                form.action = route;
                phaseInput.value = this.dataset.phaseId || '';
                statusInput.value = this.dataset.phaseStatus || '';
                message.textContent = this.dataset.phaseMessage || '';
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resultDetails = <?= $resultDetailsJson ?>;

        const modal = document.getElementById('result-detail-modal');
        const modalTitle = document.getElementById('result-detail-title');
        const modalMeta = document.getElementById('result-detail-meta');
        const modalBody = document.getElementById('result-detail-body');
        const modalClose = document.getElementById('result-detail-close');

        const config = document.getElementById('scholarship-phase-editor');

        document.getElementById('promotePassedButton')?.addEventListener('click', async function () {
            const confirmation = await Swal.fire({
                title: 'Confirmer la promotion',
                text: 'Tous les candidats ayant réussi le test passeront au statut TEST_PASSED.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, promouvoir',
                cancelButtonText: 'Annuler'
            });

            if (!confirmation.isConfirmed) {
                return;
            }
            const formData = new FormData();
            formData.append('sesskey', config.dataset.sesskey);
            formData.append('phaseid', config.dataset.phaseid);

            const response = await fetch(config.dataset.promoteUrl, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            });

            const result = await response.json();

            Swal.fire({
                icon: result.success ? 'success' : 'error',
                title: result.success ? 'Succès' : 'Erreur',
                text: result.message || 'Opération terminée.'
            }).then(() => {
                if (result.success) {
                    window.location.reload();
                }
            });
        });

        if (window.DataTable && document.getElementById('results-table')) {
            const resultsTable = new DataTable('#results-table', {
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100, { label: 'Tout', value: -1 }],
                order: [[5, 'desc']],
                layout: {
                    topStart: {
                        buttons: [
                            { extend: 'copyHtml5', exportOptions: { columns: ':not(.not-export)' } },
                            { extend: 'excelHtml5', exportOptions: { columns: ':not(.not-export)' } },
                            { extend: 'pdfHtml5', exportOptions: { columns: ':not(.not-export)' }, orientation: 'landscape', pageSize: 'A4' },
                            { extend: 'print', exportOptions: { columns: ':not(.not-export)' } },
                        ],
                    },
                },
                language: {
                    search: 'Rechercher :',
                    lengthMenu: 'Afficher _MENU_ lignes',
                    info: 'Affichage de _START_ à _END_ sur _TOTAL_',
                    infoEmpty: 'Aucun résultat',
                    zeroRecords: 'Aucun résultat trouvé',
                    paginate: {
                        first: 'Début',
                        last: 'Fin',
                        next: 'Suivant',
                        previous: 'Précédent',
                    },
                },
            });

            document.getElementById('results-gender-filter')?.addEventListener('change', function () {
                resultsTable.column(2).search(this.value ? '^' + this.value + '$' : '', true, false).draw();
            });
            document.getElementById('results-auto-filter')?.addEventListener('change', function () {
                resultsTable.column(9).search(this.value ? '^' + this.value + '$' : '', true, false).draw();
            });
        }

        function closeResultModal() {
            modal.classList.add('hidden');
            modalBody.innerHTML = '';
        }

        function renderDetailCard(question, index) {
            const statusClass = question.is_correct
                ? 'bg-emerald-100 text-emerald-700'
                : 'bg-rose-100 text-rose-700';

            const statusLabel = question.selected_option_id
                ? (question.is_correct ? 'Réponse correcte' : 'Réponse incorrecte')
                : 'Sans réponse';

            const options = question.options.map((option) => `
            <li class="flex items-center gap-3 text-sm">
                <span class="inline-flex justify-center items-center rounded-full w-6 h-6 ${option.is_selected
                    ? 'bg-cyan-700 text-white'
                    : 'border border-gray-400 text-gray-500'
                }">
                    ${option.is_selected ? '&#10003;' : '&#9675;'}
                </span>

                <span class="${option.is_selected
                    ? 'font-medium text-cyan-700'
                    : 'text-gray-700'
                }">
                    ${option.option_text}
                </span>
            </li>
        `).join('');

            return `
            <article class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                <div class="flex justify-between items-center bg-gray-50 px-4 py-3 border-gray-200 border-b">
                    <div>
                        <p class="font-medium text-gray-900 text-sm">
                            Question ${index + 1}
                        </p>
                        <p class="text-gray-500 text-xs">
                            ${question.category || 'Question'} • ${question.ponderation} pt(s)
                        </p>
                    </div>

                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusClass}">
                        ${statusLabel}
                    </span>
                </div>

                <div class="p-4">
                    <div class="mb-3 text-gray-900 text-sm leading-6">
                        ${question.question_text}
                    </div>

                    <ul class="space-y-2">
                        ${options}
                    </ul>
                </div>
            </article>
        `;
        }

        document.querySelectorAll('.result-detail-trigger').forEach((button) => {
            button.addEventListener('click', function () {
                const sessionId = this.dataset.sessionId;
                const details = resultDetails[sessionId] || [];

                modalTitle.textContent = this.dataset.candidateName || 'Candidat';
                modalMeta.textContent = `${this.dataset.score || '-'} • ${this.dataset.status || '-'}`;
                modalBody.innerHTML = details.map(renderDetailCard).join('');

                modal.classList.remove('hidden');
            });
        });

        modalClose?.addEventListener('click', closeResultModal);

        modal?.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeResultModal();
            }
        });
    });
</script>