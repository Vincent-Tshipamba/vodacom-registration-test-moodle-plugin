<?php
defined('MOODLE_INTERNAL') || die();

$applicant = $data->applicant;
$phasetest = $data->phasetest;

$duration = !empty($phasetest->durationmin) ? (int) $phasetest->durationmin : 0;
$description = !empty($phasetest->description)
    ? format_string($phasetest->description)
    : 'Test de sélection Bourse Vodacom';

$applicantname = !empty($applicant->fullname)
    ? format_string($applicant->fullname)
    : 'Candidat #' . (int) $applicant->id;
?>

<section id="evaluationUser"
    class="bg-gray-50 min-h-screen select-none">

    <div class="mx-auto px-4 md:px-10 py-10 max-w-5xl">
        <div
            class="bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] border border-white/60 rounded-[28px] overflow-hidden">

            <div class="gap-8 grid lg:grid-cols-[1.15fr_0.85fr] px-5 md:px-8 py-8">

                <div class="space-y-6 text-slate-700">
                    <div>
                        <h1 class="font-semibold text-slate-900 text-2xl md:text-3xl">
                            <?= $description ?>
                        </h1>
                    </div>

                    <p class="text-sm md:text-base leading-7">
                        Cette évaluation vise à mesurer tes connaissances et tes capacités de raisonnement
                        à travers plusieurs disciplines, notamment le français, l'anglais, les mathématiques,
                        la biologie, la physique, la chimie et les tests psychotechniques.
                        Elle permet d'évaluer ton niveau global et ton aptitude à intégrer le programme concerné.
                    </p>

                    <div class="gap-4 grid sm:grid-cols-2">
                        <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl shadow-md">
                            <p class="text-slate-500 text-xs uppercase font-bold">
                                Durée du test
                            </p>
                            <p class="mt-2 font-semibold text-slate-900 text-xl">
                                <?= $duration ?> min
                            </p>
                        </div>

                        <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl shadow-md">
                            <p class="text-slate-500 text-xs uppercase font-bold">
                                Candidat
                            </p>
                            <p class="mt-2 font-semibold text-slate-900 text-xl">
                                <?= s($applicantname) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-[linear-gradient(180deg,rgba(13,148,136,0.08),rgba(255,255,255,0))] px-5 py-6 border border-slate-200/70 rounded-[24px] text-slate-700">
                    <h2 class="font-semibold text-slate-900 text-lg">
                        Consignes importantes
                    </h2>

                    <ul class="space-y-3 mt-4 text-sm leading-6 list-disc pl-5">
                        <li>
                            Dès que tu démarres l'évaluation, le compte à rebours se lance automatiquement.
                        </li>
                        <li>
                            L'évaluation se termine automatiquement lorsque le temps imparti expire.
                        </li>
                        <li>
                            Toute perte de focus de la fenêtre d'examen est enregistrée comme tentative de tricherie.
                            Après 3 tentatives, l'évaluation est soumise automatiquement.
                        </li>
                        <li>
                            Assure-toi d'avoir répondu à toutes les questions avant de soumettre.
                        </li>
                    </ul>

                    <form action="<?= new moodle_url('/local/scholarship/applicants/tests/instructions-layout.php') ?>" method="post"
                        class="mt-8">

                        <input type="hidden" name="sesskey" value="<?= sesskey() ?>">

                        <button type="submit"
                            class="inline-flex justify-center items-center gap-2 bg-[#ff1453] hover:bg-[#e0114a] px-5 py-3 rounded-2xl focus:outline-none focus:ring-[#ff1453]/20 focus:ring-4 w-full font-semibold text-white transition">
                            Démarrer l'évaluation
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>