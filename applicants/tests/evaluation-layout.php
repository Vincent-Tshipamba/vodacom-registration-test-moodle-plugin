<?php

use local_scholarship\controllers\ApplicantController;

require_once(__DIR__ . '/../../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/pages/test/evaluation.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Évaluation');
$PAGE->set_heading('Évaluation');

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);

$data = ApplicantController::evaluation();

echo $OUTPUT->header();

require(__DIR__ . '/evaluation.php');

echo $OUTPUT->footer();