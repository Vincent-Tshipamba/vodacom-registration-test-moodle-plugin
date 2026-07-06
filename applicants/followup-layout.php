<?php

use local_scholarship\controllers\ApplicantController;

require_once(__DIR__ . '/../../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/applicants//followup-layout.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Suivi de votre candidature');
$PAGE->set_heading('Suivi de votre candidature');
$PAGE->add_body_class('local-scholarship-home');

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ApplicantController::followup();
}

// $data = ApplicantController::instructions();

echo $OUTPUT->header();

require(__DIR__ . '/followup.php');

echo $OUTPUT->footer();