<?php

use local_scholarship\controllers\ApplicantController;

require_once(__DIR__ . '/../../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Évaluation soumise');
$PAGE->set_heading('Évaluation soumise');
$PAGE->add_body_class('local-scholarship-home');

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));

$data = ApplicantController::submitted();

echo $OUTPUT->header();

require(__DIR__ . '/submitted.php');

echo $OUTPUT->footer();