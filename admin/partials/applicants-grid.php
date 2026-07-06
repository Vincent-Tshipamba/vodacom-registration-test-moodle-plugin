<?php foreach ($applicants as $candidat): ?>
    <div class="card applicant-card cursor-pointer hover:bg-gray-100 hover:shadow-xl shadow-lg transition-all duration-200 mx-2"
        data-fullname="<?= s(mb_strtolower($candidat->fullname ?? '')) ?>"
        data-regcode="<?= s(mb_strtolower($candidat->regcode ?? '')) ?>"
        data-phone="<?= s(preg_replace('/\s+/', '', $candidat->phone ?? '')) ?>" data-search="<?= s(mb_strtolower(
                  ($candidat->fullname ?? '') . ' ' .
                  ($candidat->regcode ?? '') . ' ' .
                  preg_replace('/\s+/', '', $candidat->phone ?? '')
              )) ?>"
        onclick="if (event.target.closest('a, button, .dropdown, .dropdown-menu, input, select, textarea, label')) return; window.location.href='<?= new moodle_url('/local/scholarship/admin/applicants/show.php', ['id' => $candidat->id]) ?>'">
        <div class="card-body">
            <div
                class="relative flex justify-center items-center bg-slate-100 dark:bg-zink-600 mx-auto rounded-full size-16 text-lg">
                <img src="<?= $candidat->documents['PHOTO'] ? $candidat->documents['PHOTO']['url'] : new moodle_url('/local/scholarship/assets/img/profil.jpg') ?>"
                    alt="<?= 'Photo de ' . $candidat->fullname ?>"
                    class="border border-gray-500 rounded-full size-16 object-cover" loading="lazy">
            </div>
            <div class="mt-2 text-center">
                <h5 class="mb-1 font-medium text-lg">
                    <?= $candidat->fullname ?>
                </h5>
                <p class="mb-3 text-slate-500 dark:text-zink-200"><?= $candidat->diplomacityname ?></p>

                <p
                    class="w-fit mx-auto flex items-center justify-center px-2.5 py-0.5 space-x-1 border border-transparent rounded <?= $statusClasses[$candidat->statusname]['classes'] ?>">
                    <span><?= $statusClasses[$candidat->statusname]['svg'] ?></span>

                    <span><?= $statusLabels[$candidat->statusname] ?></span>
                </p>
                <p class="mt-2 text-slate-800"><?= $candidat->regcode ?></p>
            </div>
            <div class="flex justify-center items-center gap-2 mt-5">
                <a href="tel:<?= $candidat->phone ?>"
                    class="bg-white hover:bg-custom-600 focus:bg-custom-600 active:bg-custom-600 border-custom-500 hover:border-custom-600 focus:border-custom-600 active:border-custom-600 focus:ring active:ring focus:ring-custom-100 active:ring-custom-100 dark:ring-custom-400/20 text-custom-500 hover:font-medium btn grow"><i
                        data-lucide="messages-square" class="inline-block ltr:mr-1 rtl:ml-1 size-4"></i> <span
                        class="align-middle"><?= $candidat->phone ?></span></a>
                <div class="relative scholarship-dropdown">
                    <button type="button" data-scholarship-dropdown="dropdown-<?= $candidat->id ?>"
                        class="flex justify-center items-center bg-blue-600 hover:bg-blue-700 p-0 rounded-lg size-[37.5px] text-white">
                        <i data-lucide="more-horizontal" class="w-5 h-5"></i>
                    </button>

                    <div id="dropdown-<?= $candidat->id ?>"
                        class="scholarship-dropdown-menu hidden absolute right-0 top-11 z-50 bg-white shadow-lg border border-slate-200 rounded-md min-w-[12rem] py-2">
                        <?php foreach ($candidat->documents as $type => $doc): ?>
                            <a href="#" onclick="showDocument(
                            event,
                            '<?= s($doc['url']) ?>',
                            <?= (int) $doc['id'] ?>,
                            '<?= s($doc['type']) ?>',
                            <?= (int) $candidat->id ?>,
                            '<?= s($candidat->fullname) ?>',
                            '<?= $doc['is_pdf'] ? '1' : '0' ?>')"
                                class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-100">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                <span><?= s($doc['type']) ?></span>
                            </a>
                        <?php endforeach; ?>

                        <a href="<?= new moodle_url('/local/scholarship/admin/applicants/show.php', ['id' => $candidat->id]) ?>"
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