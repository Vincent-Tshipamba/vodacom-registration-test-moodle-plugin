<?php
$applicant = $data->applicant;

require('../partials/values.php');
require('../../partials/values_for_registration.php');
?>

<?php require(__DIR__ . '/../partials/topbar.php'); ?>

<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <?= get_string('applicant_details_title', 'local_scholarship', [
            'fullname' => $applicant->fullname ?? ''
        ]); ?>
    </h1>
    <p class="text-slate-500 mt-1">
        
    </p>
</div>


<nav class="flex my-3" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="<?= new moodle_url('/local/scholarship/admin') ?>"
                class="inline-flex items-center font-medium text-gray-700 hover:text-indigo-800 hover:font-bold text-base">
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="mx-1 w-5 h-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <a href="<?= new moodle_url('/local/scholarship/admin/applicants') ?>"
                    class="ml-1 md:ml-2 font-medium text-gray-700 hover:text-indigo-800 hover:font-bold dark:hover:font-bold text-base">
                    Applicants</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="mx-1 w-5 h-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7.5 15L11.0858 11.4142C11.7525 10.7475 12.0858 10.4142 12.0858 10C12.0858 9.58579 11.7525 9.25245 11.0858 8.58579L7.5 5"
                        stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ml-1 md:ml-2 font-medium text-indigo-600 text-base"><?= $applicant->fullname ?></span>
            </div>
        </li>
    </ol>
</nav>

<section class="relative pt-36 pb-24">
    <img src="<?= new moodle_url('/local/scholarship/assets/img/OR68WQ0.jpg') ?>" alt="cover-image" loading="lazy"
        class="top-0 left-0 z-0 absolute w-full h-36 object-cover">
    <div class="top-[-72px] z-10 relative flex justify-center items-center">
        <button type="button" <?php if (isset($applicant->documents['PHOTO']['url'])): ?>
                onclick="showProfilePhoto('<?= $applicant->documents['PHOTO']['url'] ?>', <?= $applicant->documents['PHOTO']['id'] ?>, '<?= addslashes($applicant->fullname) ?>')"
            <?php endif; ?> class="group relative rounded-full focus:outline-none focus:ring-4 focus:ring-blue-400/30">
            <img src="<?= $applicant->documents['PHOTO']['url'] ?? new moodle_url('/local/scholarship/assets/img/profil.jpg') ?>"
                alt="<?= $applicant->fullname . ' avatar' ?>" loading="lazy"
                class="bg-[#0a0022] border-4 border-gray-600 border-solid rounded-full w-36 h-36 object-cover transition duration-200 group-hover:scale-[1.02]">
            <span
                class="right-1 bottom-1 absolute inline-flex items-center gap-1 bg-slate-900/80 group-hover:bg-slate-900 px-2.5 py-1 rounded-full text-white text-[11px] transition">
                <i data-lucide="zoom-in" class="size-3"></i>
                Voir
            </span>
        </button>
    </div>
    <div class="mx-auto -mt-12 px-6 md:px-8 w-full max-w-7xl">
        <h3 class="mb-3 font-manrope font-bold text-gray-900 text-3xl text-center leading-10">
            <?= $applicant->fullname ?>
        </h3>
        <div class="mx-auto text-center">
            <span
                class="inline-flex justify-center items-center gap-1.5 <?= $statusClasses[$applicant->statusname]['classes'] ?> mx-auto px-3 py-1 rounded-full font-medium text-center status">
                <?= $statusClasses[$applicant->statusname]['svg'] ?>
                <?= $statusLabels[$applicant->statusname] ?>
            </span>
        </div>
        <?php if ($applicant->statusname === 'PENDING'): ?>
            <div class="flex sm:flex-row flex-col justify-center gap-3 mt-5">
                <form method="POST"
                    action="<?php new moodle_url('/local/scholarship/admin/applicants/show', ['id' => $applicant->id]) ?>">
                    <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
                    <input type="hidden" name="application_status" value="SHORTLISTED">
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-green-600 hover:bg-green-700 dark:hover:bg-green-500 shadow-sm px-5 py-2.5 rounded-lg font-medium text-white transition">
                        <i data-lucide="badge-check" class="size-4"></i>
                        Je le valide
                    </button>
                </form>
                <form method="POST"
                    action="<?php new moodle_url('/local/scholarship/admin/applicants/show', ['id' => $applicant->id]) ?>">
                    <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
                    <input type="hidden" name="application_status" value="REJECTED">
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-red-600 hover:bg-red-700 dark:hover:bg-red-500 shadow-sm px-5 py-2.5 rounded-lg font-medium text-white transition">
                        <i data-lucide="user-x" class="size-4"></i>
                        Je ne le retiens pas
                    </button>
                </form>
            </div>
        <?php endif; ?>
        <div class="flex flex-col justify-center gap-2 my-auto py-6 w-full">
            <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                <div class="w-full">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_fullname', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg"><?= $applicant->fullname ?></dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_birthdate', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg">
                                <?= $applicant->birthdate ?>
                                (<?= $applicant->age ?> <?= get_string('applicant_years_old', 'local_scholarship') ?>)
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_gender', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg"><?= $genders[$applicant->gender] ?></dd>
                        </div>
                    </dl>
                </div>
                <div class="w-full">
                    <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                        <div class="flex flex-col pb-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_address', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg"><?= $applicant->address ?></dd>
                        </div>

                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_phone', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg"><?= $applicant->phone ?></dd>
                        </div>

                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_vulntype', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold hover:text-blue-500 text-lg">
                                <?= $vulnerabilities[$applicant->vulntype] ?? '' ?>
                            </dd>
                        </div>
                        <div class="flex flex-col py-3">
                            <dt class="mb-1 text-gray-500 md:text-lg">
                                <?= get_string('applicant_coupon', 'local_scholarship') ?>
                            </dt>
                            <dd class="font-semibold text-lg"><?= $applicant->regcode ?></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="my-3 w-full">
                <!--  -->
                <h1
                    class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md md:text-lg lg:text-xl">
                    <?= get_string('applicant_citiesinfo', 'local_scholarship') ?>
                </h1>
                <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_diplomacity', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->diplomacityname ?></dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_currentcity', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->currentcityname ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="my-3 w-full">
                <!--  -->
                <h1
                    class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md md:text-lg lg:text-xl">
                    <?= get_string('applicant_schoolinfo', 'local_scholarship') ?>
                </h1>
                <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_schoolname', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->schoolname ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_schoolfield', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg">
                                    <?= isset($study_options[$applicant->schoolfield]) ? $study_options[$applicant->schoolfield] : $applicant->schoolfield ?>
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_examcode', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->examcode ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_percentage', 'local_scholarship') ?> %
                                </dt>
                                <dd class="font-semibold text-lg"><?= intval($applicant->percentage) ?> %</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="my-3 w-full">
                <!--  -->
                <h1
                    class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md md:text-lg lg:text-xl">
                    <?= get_string('applicant_documents', 'local_scholarship') ?>
                </h1>
                <div class="gap-4 grid grid-cols-1 sm:grid-cols-3 w-full">
                    <?php foreach ($applicant->documents as $type => $doc): ?>
                        <a href="#" onclick="showDocument(
                            event,
                            '<?= s($doc['url']) ?>',
                            <?= (int) $doc['id'] ?>,
                            '<?= s($doc['type']) ?>',
                            <?= (int) $applicant->id ?>,
                            '<?= s($applicant->fullname) ?>',
                            '<?= $doc['is_pdf'] ? '1' : '0' ?>')"
                            class="bg-white shadow-sm hover:shadow-md border rounded-lg overflow-hidden transition">

                            <div class="flex justify-center items-center bg-gray-100 h-40">
                                <?php if (in_array($doc['ext'], ['jpg', 'jpeg', 'png', 'webp'])): ?>
                                    <img src="<?= s($doc['url']) ?>" alt="<?= s($doc['label']) ?>"
                                        class="w-full h-full object-cover">

                                <?php elseif ($doc['is_pdf']): ?>
                                    <iframe src="<?= s($doc['url']) ?>" class="w-full h-full pointer-events-none"></iframe>

                                <?php else: ?>
                                    <div class="flex flex-col items-center text-gray-600">
                                        <i data-lucide="file-text" class="mb-2 w-12 h-12"></i>
                                        <span class="text-sm uppercase">
                                            <?= s($doc['ext']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="p-3 font-medium text-gray-800 text-sm text-center">
                                <?= s($doc['label']) ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="my-3 w-full">
                <!--  -->
                <h1
                    class="my-4 pr-2 pb-3 border-red-400 dark:border-yellow-600 border-b-4 dark:border-b-4 rounded-b-md w-fit font-serif text-md md:text-lg lg:text-xl">
                    <?= get_string('applicant_ambitions', 'local_scholarship') ?>
                </h1>
                <div class="flex sm:flex-row flex-col justify-center gap-2 w-full">
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_intendedfield', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg">
                                    <?= isset($intendedfields[$applicant->intendedfield]) ? $intendedfields[$applicant->intendedfield] : $applicant->intendedfield ?>
                                </dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_motivation', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->motivation ?></dd>
                            </div>
                        </dl>
                    </div>
                    <div class="w-full">
                        <dl class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900">
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_careergoals', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->careergoals ?></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg">
                                    <?= get_string('applicant_additionalinfo', 'local_scholarship') ?>
                                </dt>
                                <dd class="font-semibold text-lg"><?= $applicant->additionalinfo ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50  p-4 md:p-8 border border-gray-200 dark:border-gray-700 rounded-lg">
            <h3 class="mb-4 font-semibold text-gray-900 text-xl">
                Historique de changement de statuts
            </h3>
            <?php foreach ($applicant->history as $history): ?>
                <div
                    class="gap-4 grid grid-cols-1 md:grid-cols-4 bg-white dark:bg-gray-900 mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-xl">
                    <div>
                        <p class="text-gray-500 text-sm">Modifie par</p>
                        <p class="mt-1 font-semibold text-gray-900"><?= $history->changerfirstname ?>
                            <?= $history->changerlastname ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Date</p>
                        <p class="mt-1 font-semibold text-gray-900">
                            <?= date('Y-m-d H:i:s', $history->timecreated) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Ancien statut</p>
                        <span
                            class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full text-xs font-medium <?= $statusClasses[$history->oldstatusname]['classes'] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-300' ?>">
                            <?=
                                $statusLabels[$history->oldstatusname] ?>
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Nouveau statut</p>
                        <span
                            class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full text-xs font-medium <?= $statusClasses[$history->newstatusname]['classes'] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/15 dark:text-gray-300' ?>">
                            <?=
                                $statusLabels[$history->newstatusname] ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($applicant->history)): ?>
                <div
                    class="bg-white dark:bg-gray-900 p-5 border border-dashed border-gray-300 dark:border-gray-600 rounded-xl text-gray-500">
                    Aucun changement de statut n'a encore été enregistré pour ce candidat.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>