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
            Verifiez en un clic le statut de votre candidature !
        </h1>
        <p class="mt-4 text-lg md:text-xl">
            Vous n'avez qu'à saisir votre code coupon reçu lors de la soumission de la candidature
        </p>

        <!-- Resultat de la verification -->
        <?php if (isset($data)): ?>
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
                        <span class="flex items-center justify-start text-gray-500">
                            <?= $data->examcode ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <form action="<?= new moodle_url('/local/scholarship/applicants/followup-layout.php') ?>" method="post">
            <div class="mt-2 flex-col md:flex items-center justify-center space-x-1">
                <div class="flex items-center bg-gray-900 p-4 rounded-md max-w-xl mb-2">
                    <span class="text-green-500">&gt;</span>
                    <input type="text" value="<?= $data->regcode ?>" autocapitalize="characters" name="coupon"
                        class="border-none placeholder-gray-400 bg-gray-900 text-white p-0.5 outline-none ml-2 w-full"
                        placeholder="Saisissez votre coupon ici">
                </div>
                <div>
                    <button type="submit"
                        class="px-6 py-3 bg-red-500 hover:bg-red-600 rounded-lg text-lg font-semibold transition inline-flex items-center">
                        Vérifier
                        <i class="fa-solid fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </button>
                </div>
            </div>
        </form>

    </div>
</section>