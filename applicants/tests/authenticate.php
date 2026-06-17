<?php
defined('MOODLE_INTERNAL') || die();

$actionurl = new moodle_url('/local/scholarship/applicants/tests/test-auth.php');

$vodacomlogo = new moodle_url('/local/scholarship/assets/img/vodacom-seeklogo.png');
$schoollogo = new moodle_url('/local/scholarship/assets/img/instant-school-logo.png');
?>

<section id="scholarship-auth" class="scholarship-auth-page bg-white bg-cover bg-center">

    <div
        class="scholarship-auth-wrapper flex flex-col justify-center items-center mx-auto px-6 py-8 lg:py-0 min-h-screen">

        <h2 class="flex items-center mb-6">
            <span class="flex items-center gap-4">
                <img src="<?= $vodacomlogo ?>" class="w-14 md:w-40" alt="Logo Vodacom">

                <img src="<?= $schoollogo ?>" class="w-10 md:w-14 h-10 md:h-14" alt="Logo Instant School">
            </span>
        </h2>

        <?php if (optional_param('error', '', PARAM_TEXT)): ?>
            <div class="mb-4 w-full max-w-4xl rounded-md bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                <?= s(optional_param('error', '', PARAM_TEXT)) ?>
            </div>
        <?php endif; ?>

        <div class="scholarship-auth-card bg-white opacity-95 shadow-md sm:rounded-lg overflow-hidden">

            <div class="scholarship-auth-forms-container">
                <div class="scholarship-auth-signin">
                    <form class="scholarship-auth-form" action="<?= $actionurl ?>" autocomplete="off" method="post">

                        <input type="hidden" name="sesskey" value="<?= sesskey() ?>">

                        <div class="space-y-4 md:space-y-6 p-6 sm:p-8">
                            <h2 class="font-bold text-2xl leading-tight tracking-tight text-gray-900">
                                Connexion
                            </h2>

                            <div class="mb-5">
                                <label for="national_exam_code" class="block mb-2 font-medium text-sm text-gray-900">
                                    Code élève (14 chiffres)
                                </label>

                                <input type="text" autocomplete="off" id="national_exam_code" name="national_exam_code"
                                    inputmode="numeric"
                                    class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-gray-500 rounded-lg focus:ring-gray-500 w-full text-gray-900 text-sm"
                                    placeholder="Entrez votre code élève à 14 chiffres..." maxlength="14"
                                    pattern="\d{14}" title="Le code élève doit contenir exactement 14 chiffres."
                                    required>
                            </div>

                            <div class="mb-5">
                                <label for="coupon" class="block mb-2 font-medium text-sm text-gray-900">
                                    Coupon
                                </label>

                                <input type="text" autocomplete="off" id="coupon" name="coupon"
                                    class="block bg-gray-50 p-2.5 border border-gray-300 focus:border-gray-500 rounded-lg focus:ring-gray-500 w-full text-gray-900 text-sm"
                                    required>
                            </div>

                            <button type="submit"
                                class="bg-gray-900 hover:bg-gray-800 border border-gray-700 hover:border-gray-600 rounded-lg focus:outline-none focus:ring-4 focus:ring-gray-500 w-full sm:w-40 h-10 font-bold text-gray-300 hover:text-gray-100 text-sm text-center">
                                Connexion
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="scholarship-auth-panels-container">
                <div class="scholarship-auth-left-panel scholarship-auth-panel">
                    <div class="scholarship-auth-content">
                        <p class="font-semibold text-sm md:text-base leading-8">
                            Cette section concerne<br>
                            l'authentification des candidats avant<br>
                            leur évaluation.<br>
                            Nous voulons juste vérifier votre<br>
                            identité pour s'assurer que vous êtes<br>
                            éligible à participer au processus<br>
                            d'évaluation.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>