<?php

use local_scholarship\controllers\ApplicantController;

require_once(__DIR__ . '/../../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/applicants/tests/instructions.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Instructions de l\'évaluation');
$PAGE->set_heading('Instructions de l\'évaluation');
$PAGE->add_body_class('local-scholarship-home');

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/css/authenticate.css'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ApplicantController::start_exam();
}

$data = ApplicantController::instructions();

echo $OUTPUT->header();

require(__DIR__ . '/instructions.php');

echo $OUTPUT->footer();