<?php

$applicants = $data->applicants;
?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900"><?= get_string('applicants_title', 'local_scholarship') ?></h1>
    <p class="text-slate-500 mt-1">
        Gestion des candidatures
    </p>
</div>

<div class="flex justify-between items-center mb-6">
    <!-- View Toggle -->
    <div class="inline-flex bg-gray-100 shadow-sm p-1 rounded-lg">
        <button id="gridViewBtn"
            class="inline-flex items-center hover:bg-white px-3 py-2 rounded-md font-medium text-gray-800 text-sm transition-all duration-200 active">
            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Grille
        </button>
        <button id="listViewBtn"
            class="inline-flex items-center hover:bg-white px-3 py-2 rounded-md font-medium text-gray-600 text-sm transition-all duration-200">
            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            Liste
        </button>
    </div>
    <!-- Search Button -->
    <button id="searchModalButton" type="button"
        class="bg-blue-600 hover:bg-blue-700 text-white btn cursor-pointer z-10">
        <i data-lucide="search" class="inline-block mr-2 size-4"></i>
        Recherche
    </button>
</div>

<?php require(__DIR__ . '/../../partials/cdn-datatables.php') ?>
<script src="../../assets/js/init-admin-applicants.js"></script>
<script src="../../assets/js/details-applicant.js"></script>

<!-- Grid View -->
<div id="gridView" class="w-full">
    <div id="applicantsGrid" class="gap-5 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
        <?php include(__DIR__ . '/../partials/applicants-grid.php'); ?>
    </div>
</div>

<!-- List View (initially hidden) -->
<div id="listView" class="hidden w-full">
    <?php include(__DIR__ . '/../partials/applicants-list.php'); ?>
</div>

<!-- Loading Placeholders (initially hidden) -->
<?php include(__DIR__ . '/../partials/loading-placeholders.php'); ?>

<!-- Search Modal -->
<?php include(__DIR__ . '/../partials/search-modal.php'); ?>