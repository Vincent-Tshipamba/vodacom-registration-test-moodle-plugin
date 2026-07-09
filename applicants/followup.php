<section
    class="relative w-full min-h-[90vh] flex flex-col items-center justify-center text-center px-6 lg:px-16 py-16 md:py-32">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center blur-sm"
        style="background-image: url('../assets/img/OR68WQ0.jpg');">
    </div>
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Content -->
    <div class="relative z-10 text-white max-w-2xl">
        <h1 class="text-2xl md:text-4xl font-bold leading-tight">
            Verification du statut de votre candidature !
        </h1>

        <!-- Resultat de la verification -->
        <?php if (isset($data)): ?>
            <?php if (isset($data->error)): ?>
                <div class="max-w-2xl mx-auto my-3">
                    <div class="flex gap-3 bg-gray-900 rounded-xl overflow-hidden items-center justify-center shadow-md p-4">
                        <span class="text-red-500 text-center text-md md:text-lg font-semibold"><?= $data->error ?></span>
                    </div>
                </div>
            <?php else: ?>
                <div class="max-w-2xl mx-auto my-3">
                    <div class="flex gap-3 bg-gray-900 rounded-xl overflow-hidden items-center justify-start shadow-md">
                        <div class="relative w-36 h-36 flex-shrink-0">
                            <img class="absolute left-0 top-0 w-full h-full object-cover object-center transition duration-50"
                                loading="lazy"
                                src="<?= $data->documents['PHOTO'] ? $data->documents['PHOTO']['url'] : new moodle_url('/local/scholarship/assets/img/profil.jpg') ?>">
                        </div>

                        <div class="flex flex-col gap-2 py-2">
                            <p class="text-start text-xl font-bold"><?= $data->fullname ?></p>

                            <p class="text-gray-500 text-start">
                                <?php if ($data->statusname === 'PENDING'): ?>
                                    <span class="text-gray-400">
                                        Votre candidature est en attente de vérification. Revenez plus tard pour consulter son
                                        statut.
                                    </span>
                                <?php endif; ?>

                                <?php if ($data->statusname === 'SHORTLISTED'): ?>
                                    <span class="text-green-500">
                                        Félicitations ! Vous avez été sélectionné(e) pour passer le test écrit ! Vous recevrez plus
                                        de détails sur le lieu du test très bientôt. En attendant, consultez la plateforme vodaeduc
                                        pour vous préparer.
                                    </span>
                                <?php endif; ?>

                                <?php if ($data->statusname === 'REJECTED'): ?>
                                    <span class="text-red-500">
                                        Nous regrettons de vous informer que votre candidature n'a pas été retenue. Nous vous
                                        remercions pour l'intérêt que vous avez porté à notre programme et vous souhaitons le
                                        meilleur pour vos projets futurs.
                                    </span>
                                <?php endif; ?>

                                <?php if ($data->statusname === 'TEST_PASSED'): ?>
                                    <span class="text-green-500">
                                        Félicitations ! Vous avez réussi le test écrit. Vous serez contacté(e) pour la prochaine
                                        étape du processus de sélection.
                                    </span>
                                <?php endif; ?>

                                <?php if ($data->statusname === 'INTERVIEW_PASSED'): ?>
                                    <span class="text-green-500">
                                        Félicitations ! Vous avez réussi l'entretien. Vous serez contacté(e) pour la prochaine étape
                                        du processus de sélection.
                                    </span>
                                <?php endif; ?>

                                <?php if ($data->statusname === 'ADMITTED'): ?>
                                    <span class="text-green-500">
                                        Nos sincères félicitations ! Vous avez été retenu(e) comme boursier(ère). Nous vous
                                        contacterons bientôt pour les prochaines étapes.
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>