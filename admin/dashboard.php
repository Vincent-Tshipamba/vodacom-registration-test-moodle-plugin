<?php

$currentedition = $data->currentedition;
$stats = $data->stats;
$editionstats = $data->editionstats;
$recentapplications = $data->recentapplications;
$statusLabels = $data->statusLabels;
$statusClasses = $data->statusClasses;
$isregistrationopen = $data->isRegistrationOpen;

$labels = [];
$values = [];

foreach ($editionstats as $edition) {
    $labels[] = $edition->name ?: $edition->year;
    $values[] = (int) $edition->total;
}
?>

<!-- Topbar -->
<?php require(__DIR__ . '/partials/topbar.php'); ?>

<div class="min-h-screen bg-slate-50">

    <!-- Content -->
    <main class="w-full">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-slate-500 mt-1">
                Statistiques de gestion des candidatures
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg height="24" width="24" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                fill: #000000;
                            }
                        </style>
                        <g>
                            <path class="st0" d="M366.042,378.266c-26.458-9.72-49.309-18.113-51.793-42.026c-1.149-11.024-0.214-23.982,2.702-37.507
                                c9.144-9.798,16.72-23.936,24.484-45.691c15.458-5.955,25.31-19.192,30.109-40.442c2.461-10.885-1.058-22.073-9.655-30.807
                                c0.773-13.206,0.095-13.928-0.402-14.456l-0.542-0.536H151.497v14.914c-9.897,9.115-13.61,19.503-11.038,30.885
                                c4.794,21.242,14.648,34.48,30.12,40.442c7.762,21.754,15.332,35.885,24.464,45.675c2.06,9.518,4.158,23.61,2.71,37.523
                                c-2.484,23.913-25.336,32.306-51.795,42.026c-36.32,13.338-77.484,28.462-77.484,88.641C68.474,485.634,126.653,512,256,512
                                c129.347,0,187.526-26.366,187.526-45.093C443.526,406.729,402.362,391.605,366.042,378.266z M233.908,484.578L203.021,359.12
                                l37.47,15.598l-2.302,20.66l6.572-0.148L233.908,484.578z M277.101,395.378l-2.302-20.66l37.47-15.598l-30.887,125.458
                                l-10.854-89.348L277.101,395.378z" />
                            <path class="st0" d="M91.083,82.779l54.864,24.13v36.397h222.66v-36.397l22.395-9.852v51.234c-4.75,0.753-8.389,4.728-8.389,9.495
                            c0,4.146,2.741,7.74,6.704,9.053l-6.378,40.217c-0.421,2.663,0.34,5.357,2.081,7.392c1.739,2.042,4.28,3.214,6.972,3.214h16.792
                            c2.692,0,5.233-1.172,6.968-3.214c1.745-2.034,2.506-4.728,2.085-7.392l-6.374-40.217c3.969-1.312,6.714-4.907,6.714-9.053
                            c0-4.767-3.643-8.742-8.397-9.495V88.804l13.686-6.017c2.696-1.172,4.439-3.789,4.439-6.654c0-2.85-1.739-5.458-4.433-6.646
                            L272.931,3.284C267.987,1.102,262.72,0,257.273,0c-5.446,0-10.712,1.102-15.652,3.284L91.081,69.487
                            c-2.692,1.188-4.431,3.796-4.431,6.646C86.649,79.006,88.392,81.614,91.083,82.779z" />
                        </g>
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_scholars', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['total_scholars'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-semibold">
                            <i class="fas fa-arrow-up"></i> 100%
                        </span>
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg class="hover:text-slate-800" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 14C21.2091 14 23 16 23 17.5C23 18.3284 22.3284 19 21.5 19H21M17 11C18.6569 11 20 9.65685 20 8C20 6.34315 18.6569 5 17 5M5 14C2.79086 14 1 16 1 17.5C1 18.3284 1.67157 19 2.5 19H3M7 11C5.34315 11 4 9.65685 4 8C4 6.34315 5.34315 5 7 5M16.5 19H7.5C6.67157 19 6 18.3284 6 17.5C6 15 9 14 12 14C15 14 18 15 18 17.5C18 18.3284 17.3284 19 16.5 19ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z"
                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_applicants', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['total_applicants'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-semibold">
                            <i class="fas fa-arrow-up"></i> 100%
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg height="24" width="24" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                        <style type="text/css">
                            .st0 {
                                fill: #000000;
                            }
                        </style>
                        <g>
                            <path class="st0" d="M366.042,378.266c-26.458-9.72-49.309-18.113-51.793-42.026c-1.149-11.024-0.214-23.982,2.702-37.507
        c9.144-9.798,16.72-23.936,24.484-45.691c15.458-5.955,25.31-19.192,30.109-40.442c2.461-10.885-1.058-22.073-9.655-30.807
        c0.773-13.206,0.095-13.928-0.402-14.456l-0.542-0.536H151.497v14.914c-9.897,9.115-13.61,19.503-11.038,30.885
                            c4.794,21.242,14.648,34.48,30.12,40.442c7.762,21.754,15.332,35.885,24.464,45.675c2.06,9.518,4.158,23.61,2.71,37.523
                            c-2.484,23.913-25.336,32.306-51.795,42.026c-36.32,13.338-77.484,28.462-77.484,88.641C68.474,485.634,126.653,512,256,512
                            c129.347,0,187.526-26.366,187.526-45.093C443.526,406.729,402.362,391.605,366.042,378.266z M233.908,484.578L203.021,359.12
                            l37.47,15.598l-2.302,20.66l6.572-0.148L233.908,484.578z M277.101,395.378l-2.302-20.66l37.47-15.598l-30.887,125.458
                            l-10.854-89.348L277.101,395.378z" />
                            <path class="st0" d="M91.083,82.779l54.864,24.13v36.397h222.66v-36.397l22.395-9.852v51.234c-4.75,0.753-8.389,4.728-8.389,9.495
                            c0,4.146,2.741,7.74,6.704,9.053l-6.378,40.217c-0.421,2.663,0.34,5.357,2.081,7.392c1.739,2.042,4.28,3.214,6.972,3.214h16.792
                            c2.692,0,5.233-1.172,6.968-3.214c1.745-2.034,2.506-4.728,2.085-7.392l-6.374-40.217c3.969-1.312,6.714-4.907,6.714-9.053
                            c0-4.767-3.643-8.742-8.397-9.495V88.804l13.686-6.017c2.696-1.172,4.439-3.789,4.439-6.654c0-2.85-1.739-5.458-4.433-6.646
                            L272.931,3.284C267.987,1.102,262.72,0,257.273,0c-5.446,0-10.712,1.102-15.652,3.284L91.081,69.487
                            c-2.692,1.188-4.431,3.796-4.431,6.646C86.649,79.006,88.392,81.614,91.083,82.779z" />
                        </g>
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_admitted', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['admitted'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['admitted'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg fill="#000000" width="24" height="24" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg">
                        <title />
                        <path
                            d="M23.93,2H8.07a2.8,2.8,0,0,0-2.8,2.8V27.2A2.8,2.8,0,0,0,8.07,30H23.93a2.8,2.8,0,0,0,2.8-2.8V4.8A2.8,2.8,0,0,0,23.93,2Zm.94,25.2a.94.94,0,0,1-.94.93H8.07a.94.94,0,0,1-.94-.93V4.8a.94.94,0,0,1,.94-.93H23.93a.94.94,0,0,1,.94.93Z" />
                        <path
                            d="M21,11.54l-7.41,7L11,16.14A.93.93,0,1,0,9.76,17.5l3.15,3a.94.94,0,0,0,1.28,0l8-7.56A.93.93,0,1,0,21,11.54Z" />
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_shortlisted', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['shortlisted'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['shortlisted'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 1024 1024" class="icon" version="1.1"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M182.99 146.2h585.14v402.29h73.14V73.06H109.84v877.71H512v-73.14H182.99z"
                            fill="#0F1F3C" />
                        <path
                            d="M256.13 219.34h438.86v73.14H256.13zM256.13 365.63h365.71v73.14H256.13zM256.13 511.91h219.43v73.14H256.13zM731.55 585.06c-100.99 0-182.86 81.87-182.86 182.86s81.87 182.86 182.86 182.86c100.99 0 182.86-81.87 182.86-182.86s-81.86-182.86-182.86-182.86z m0 292.57c-60.5 0-109.71-49.22-109.71-109.71 0-60.5 49.22-109.71 109.71-109.71 60.5 0 109.71 49.22 109.71 109.71 0.01 60.49-49.21 109.71-109.71 109.71z"
                            fill="#0F1F3C" />
                        <path d="M758.99 692.08h-54.86v87.27l69.39 68.76 38.61-38.96-53.14-52.66z" fill="#0F1F3C" />
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_pending', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['pending'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['pending'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg fill="#000000" width="24" height="24" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg">
                        <title />
                        <path
                            d="M23.93,2H8.07a2.8,2.8,0,0,0-2.8,2.8V27.2A2.8,2.8,0,0,0,8.07,30H23.93a2.8,2.8,0,0,0,2.8-2.8V4.8A2.8,2.8,0,0,0,23.93,2Zm.94,25.2a.94.94,0,0,1-.94.93H8.07a.94.94,0,0,1-.94-.93V4.8a.94.94,0,0,1,.94-.93H23.93a.94.94,0,0,1,.94.93Z" />
                        <path
                            d="M21,11.54l-7.41,7L11,16.14A.93.93,0,1,0,9.76,17.5l3.15,3a.94.94,0,0,0,1.28,0l8-7.56A.93.93,0,1,0,21,11.54Z" />
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_test_passed', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['test_passed'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['test_passed'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg fill="#000000" width="24" height="24" viewBox="0 0 32 32" data-name="Layer 1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg">
                        <title />
                        <path
                            d="M23.93,2H8.07a2.8,2.8,0,0,0-2.8,2.8V27.2A2.8,2.8,0,0,0,8.07,30H23.93a2.8,2.8,0,0,0,2.8-2.8V4.8A2.8,2.8,0,0,0,23.93,2Zm.94,25.2a.94.94,0,0,1-.94.93H8.07a.94.94,0,0,1-.94-.93V4.8a.94.94,0,0,1,.94-.93H23.93a.94.94,0,0,1,.94.93Z" />
                        <path
                            d="M21,11.54l-7.41,7L11,16.14A.93.93,0,1,0,9.76,17.5l3.15,3a.94.94,0,0,0,1.28,0l8-7.56A.93.93,0,1,0,21,11.54Z" />
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_interview_passed', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['interview_passed'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['interview_passed'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-lg shadow-lg border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>cancelled</title>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="add" fill="#000000" transform="translate(42.666667, 42.666667)">
                                <path
                                    d="M213.333333,1.42108547e-14 C331.15408,1.42108547e-14 426.666667,95.5125867 426.666667,213.333333 C426.666667,331.15408 331.15408,426.666667 213.333333,426.666667 C95.5125867,426.666667 4.26325641e-14,331.15408 4.26325641e-14,213.333333 C4.26325641e-14,95.5125867 95.5125867,1.42108547e-14 213.333333,1.42108547e-14 Z M42.6666667,213.333333 C42.6666667,307.589931 119.076736,384 213.333333,384 C252.77254,384 289.087204,370.622239 317.987133,348.156908 L78.5096363,108.679691 C56.044379,137.579595 42.6666667,173.894198 42.6666667,213.333333 Z M213.333333,42.6666667 C173.894198,42.6666667 137.579595,56.044379 108.679691,78.5096363 L348.156908,317.987133 C370.622239,289.087204 384,252.77254 384,213.333333 C384,119.076736 307.589931,42.6666667 213.333333,42.6666667 Z"
                                    id="Combined-Shape">

                                </path>
                            </g>
                        </g>
                    </svg>
                </div>

                <div>
                    <div class="text-slate-500 text-sm mb-3">
                        <?= get_string('dashboard_status_title_rejected', 'local_scholarship') ?>
                    </div>
                    <div class="flex items-end justify-between">
                        <div class="text-4xl font-bold text-slate-900">
                            <?= (int) $stats['rejected'] ?>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-600 text-sm font-semibold">
                            <?= $stats['total_applicants'] ? round(($stats['rejected'] / $stats['total_applicants']) * 100) : 0 ?>%
                        </span>
                    </div>
                </div>
            </div>

        </div>

        <div
            class="bg-white rounded-lg border border-slate-200 p-7 min-h-[190px] flex flex-col justify-between hover:scale-105 transition-transform">
            <h2 class="text-xl font-bold text-slate-900 mb-6">
                Candidatures par édition
            </h2>

            <canvas id="applicationsByEditionChart" height="120"></canvas>
        </div>

        <?php if ($currentedition && $isregistrationopen): ?>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 mt-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">
                            Candidatures récentes
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Édition en cours :
                            <?= s($currentedition->name) ?>
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                        Inscriptions ouvertes
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table id="recentApplicationsTable" class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500">
                                <th class="text-left py-3 px-4">Candidat</th>
                                <th class="text-left py-3 px-4">Téléphone</th>
                                <th class="text-left py-3 px-4">Ville</th>
                                <th class="text-left py-3 px-4">Pourcentage</th>
                                <th class="text-left py-3 px-4">Statut</th>
                                <th class="text-left py-3 px-4">Soumis le</th>
                                <th class="text-right py-3 px-4">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($recentapplications as $app): ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-3 px-4 font-semibold text-slate-800">
                                        <?= s($app->fullname) ?>
                                        <div class="text-xs text-slate-400 font-normal">
                                            <?= s($app->email) ?>
                                        </div>
                                    </td>

                                    <td class="py-3 px-4">
                                        <?= s($app->phone) ?>
                                    </td>

                                    <td class="py-3 px-4">
                                        <?= s($app->diplomacityname) ?>
                                    </td>

                                    <td class="py-3 px-4">
                                        <?= s((float) $app->percentage) ?>%
                                    </td>

                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                            <?= get_string($app->statusname, 'local_scholarship') ?? 'N/A' ?>
                                        </span>
                                    </td>

                                    <td class="py-3 px-4">
                                        <?= $app->submittedat ? userdate($app->submittedat) : '-' ?>
                                    </td>

                                    <td class="py-3 px-4 text-right">
                                        <a href="<?= new moodle_url('/local/scholarship/admin/applicant.php', ['id' => $app->id]) ?>"
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 font-semibold">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php endif; ?>
    </main>
</div>

<!-- TODO: Remplacer les CDNs et pointer vers des liens locaux -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.6/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('applicationsByEditionChart');

        if (!ctx) return;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Candidatures',
                    data: <?= json_encode($values) ?>,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery && $('#recentApplicationsTable').length) {
            $('#recentApplicationsTable').DataTable({
                pageLength: 10,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Exporter Excel',
                        className: 'bg-green-400 text-gray-300 px-4 py-2 rounded-lg'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exporter PDF',
                        className: 'bg-red-400 text-gray-300 px-4 py-2 rounded-lg'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimer',
                        className: 'bg-slate-700 text-gray-300 px-4 py-2 rounded-lg'
                    }
                ],
                language: {
                    search: 'Rechercher :',
                    lengthMenu: 'Afficher _MENU_ lignes',
                    info: 'Affichage de _START_ à _END_ sur _TOTAL_ candidatures',
                    paginate: {
                        previous: 'Précédent',
                        next: 'Suivant'
                    },
                    zeroRecords: 'Aucune candidature trouvée'
                }
            });
        }

        if (window.lucide) {
            window.lucide.createIcons({
                icons: lucide.icons
            });
        }
    });
</script>