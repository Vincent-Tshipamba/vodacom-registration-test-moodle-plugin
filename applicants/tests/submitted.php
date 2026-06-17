<?php
defined('MOODLE_INTERNAL') || die();

$applicant = $data->applicant;
$summary = $data->summary;

$applicantname = !empty($applicant->fullname)
    ? format_string($applicant->fullname)
    : 'Candidat #' . (int) $applicant->id;
?>

<section id="evaluationUser"
    class="scholarship min-h-screen">
    <div class="mx-auto px-4 md:px-10 py-10 max-w-5xl">
        <div
            class="bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.14)] border border-white/60 rounded-[28px] overflow-hidden">
            <div class="gap-8 grid lg:grid-cols-[1.05fr_0.95fr] px-5 md:px-8 py-8">

                <div class="space-y-6 text-slate-700">
                    <div>
                        <h1 class="font-semibold text-slate-900 text-2xl md:text-3xl">
                            Ton évaluation a été soumise avec succès !
                        </h1>
                    </div>

                    <p class="text-sm md:text-base leading-7">
                        Merci,
                        <?= s($applicantname) ?>. Ta participation a bien été enregistrée.
                        Tu seras recontacté(e) plus tard en fonction de l'issue du processus de sélection.
                    </p>

                    <?php if (!empty($summary['auto_submitted'])): ?>
                        <div
                            class="bg-amber-50/90 px-5 py-4 border border-amber-200/80 rounded-2xl text-amber-800 text-sm leading-6">
                            Cette évaluation a été soumise automatiquement.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="gap-4 grid sm:grid-cols-2 lg:grid-cols-2">

                    <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl">
                        <p class="text-slate-500 text-xs uppercase">
                            Questions répondues
                        </p>
                        <p class="mt-2 font-semibold text-slate-900 text-2xl">
                            <?= (int) $summary['answered_count'] ?> /
                            <?= (int) $summary['total_questions'] ?>
                        </p>
                    </div>

                    <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl">
                        <p class="text-slate-500 text-xs uppercase">
                            Temps utilisé
                        </p>
                        <p class="mt-2 font-semibold text-slate-900 text-2xl">
                            <?= s($summary['time_used_label']) ?>
                        </p>
                    </div>

                    <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl">
                        <p class="text-slate-500 text-xs uppercase">
                            Tentatives de triche
                        </p>
                        <p class="mt-2 font-semibold text-slate-900 text-2xl">
                            <?= (int) $summary['cheating_attempts'] ?>
                        </p>
                    </div>

                    <div class="bg-slate-50/80 px-5 py-4 border border-slate-200/70 rounded-2xl">
                        <p class="text-slate-500 text-xs uppercase">
                            Date de soumission
                        </p>
                        <p class="mt-2 font-semibold text-slate-900 text-xl">
                            <?= s($summary['submitted_at']) ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    history.pushState(null, '', window.location.href);

    window.addEventListener('popstate', function () {
        history.pushState(null, '', window.location.href);
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>