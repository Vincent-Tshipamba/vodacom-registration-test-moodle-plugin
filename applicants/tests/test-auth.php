<?php

use local_scholarship\controllers\ApplicantController;

require('../../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/tests/test-auth.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Authentification candidat');
$PAGE->set_heading('Authentification candidat');
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/css/authenticate.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ApplicantController::authenticate_applicant();
}

require(__DIR__ . '/authenticate.php');

echo $OUTPUT->footer();
