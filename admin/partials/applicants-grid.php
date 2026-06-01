<?php foreach ($applicants as $candidat): ?>
    <div class="card cursor-pointer hover:bg-gray-100 shadow-lg transition-all duration-200"
        onclick="if (event.target.closest('a, button, .dropdown, .dropdown-menu, input, select, textarea, label')) return; window.location.href='<?= new moodle_url('/local/scholarship/admin/applicants/show', ['id' => $candidat->id]) ?>'">
        <div class="card-body">
            <div
                class="relative flex justify-center items-center bg-slate-100 dark:bg-zink-600 mx-auto rounded-full size-16 text-lg">
                <?php if (isset($candidat->documents->photo)): ?>
                    <img src="<?= $candidat->documents->photo['url'] ?>" alt="<?= 'Photo de ' . $candidat->first_name ?>"
                        class="rounded-full size-16" loading="lazy">
                    <span
                        class="ltr:right-1 bottom-1 rtl:left-1 absolute bg-green-400 border-2 border-white dark:border-zink-700 rounded-full size-3"></span>
                <?php else: ?>
                    <div class="flex justify-center items-center bg-gray-100 rounded-full w-16 h-16">
                        <img src="<?= new moodle_url('/local/scholarship/assets/img/profil.jpg') ?>"
                            alt="<?= 'Photo de ' . $candidat->fullname ?>" class="border border-gray-500 rounded-full w-fit"
                            loading="lazy">
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-2 text-center">
                <h5 class="mb-1 font-medium text-lg">
                    <?= $candidat->fullname ?>
                </h5>
                <p class="mb-3 text-slate-500 dark:text-zink-200"><?= $candidat->diplomacityname ?></p>

                <?php if ($candidat->statusname == 'PENDING'): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 border border-transparent rounded <?= $statusClasses['PENDING']['classes'] ?>">
                        <?= $statusClasses['PENDING']['svg'] ?>

                        En attente
                    </span>
                <?php elseif ($candidat->statusname == 'ADMITTED'): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 border border-transparent rounded <?= $statusClasses['ADMITTED']['classes'] ?>">
                        <?= $statusClasses['ADMITTED']['svg'] ?>
                        Admis
                    </span>
                <?php elseif ($candidat->statusname == 'REJECTED'): ?>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 border border-transparent rounded <?= $statusClasses['REJECTED']['classes'] ?>">
                        <?= $statusClasses['REJECTED']['svg'] ?>
                        Refusé</span>
                <?php elseif ($candidat->statusname == 'SHORTLISTED'): ?>
                    <span
                        class="inline-flex items-center bg-yellow-100 dark:bg-green-500/20 px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-yellow-500 text-xs status">
                        <?= $statusClasses['SHORTLISTED']['svg'] ?>
                        Préselectionné
                    </span>
                <?php elseif ($candidat->statusname == 'INTERVIEW_PASSED'): ?>
                    <span
                        class="inline-flex items-center bg-green-100 dark:bg-green-500/20 px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-green-500 text-xs status">
                        <?= $statusClasses['INTERVIEW_PASSED']['svg'] ?>
                        Entretien passé
                    </span>
                <?php elseif ($candidat->statusname == 'TEST_PASSED'): ?>
                    <span
                        class="inline-flex items-center bg-green-100 dark:bg-green-500/20 px-2.5 py-0.5 border border-transparent dark:border-transparent rounded font-medium text-green-500 text-xs status">
                        <?= $statusClasses['TEST_PASSED']['svg'] ?>
                        Test passé
                    </span>
                <?php endif; ?>
                <p class="mt-2 text-slate-500 dark:text-zink-200"><?= $candidat->full_address ?></p>
            </div>
            <div class="flex gap-2 mt-5">
                <a href="tel:<?= $candidat->phone_number ?>"
                    class="bg-white hover:bg-custom-600 focus:bg-custom-600 active:bg-custom-600 border-custom-500 hover:border-custom-600 focus:border-custom-600 active:border-custom-600 focus:ring active:ring focus:ring-custom-100 active:ring-custom-100 dark:ring-custom-400/20 text-custom-500 hover:font-medium btn grow"><i
                        data-lucide="messages-square" class="inline-block ltr:mr-1 rtl:ml-1 size-4"></i> <span
                        class="align-middle"><?= $candidat->phone ?></span></a>
                <div class="relative scholarship-dropdown">
                    <button type="button" data-scholarship-dropdown="dropdown-<?= $candidat->id ?>"
                        class="flex justify-center items-center bg-blue-600 hover:bg-blue-700 p-0 rounded-lg size-[37.5px] text-white">
                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>

                    <div id="dropdown-<?= $candidat->id ?>"
                        class="scholarship-dropdown-menu hidden absolute right-0 top-11 z-[99999] bg-white shadow-lg border border-slate-200 rounded-md min-w-[12rem] py-2">

                        <a href="#"
                            onclick="showDocument(event, '<?= $diploma_url ?>', <?= (int) $diploma_id ?>, 'DIPLOMA', <?= (int) $candidat->id ?>, '<?= s($candidat->fullname) ?>', '<?= $diploma_is_pdf ?>')"
                            class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-100">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <span>Attestation de réussite</span>
                        </a>

                        <a href="#"
                            onclick="showDocument(event, '<?= $id_url ?>', <?= (int) $id_id ?>, 'ID', <?= (int) $candidat->id ?>, '<?= s($candidat->fullname) ?>', '<?= $id_is_pdf ?>')"
                            class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-100">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Pièce d'identité</span>
                        </a>

                        <a href="<?= new moodle_url('/local/scholarship/admin/applicant.php', ['id' => $candidat->id]) ?>"
                            class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-100">
                            <i data-lucide="user-round-search" class="w-4 h-4"></i>
                            <span>Voir tous les détails</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>