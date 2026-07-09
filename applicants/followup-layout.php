<?php

use local_scholarship\controllers\ApplicantController;

require('../../../config.php');

$context = context_system::instance();

require_login();

force_current_language('fr');

if (!isloggedin() || isguestuser()) {
    $loginurl = new moodle_url('/login/index.php', [
        'wantsurl' => qualified_me(),
    ]);

    redirect($loginurl);
}

$PAGE->set_url(new moodle_url('/local/scholarship/applicants//followup-layout.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title('Suivi de votre candidature');
$PAGE->set_heading('Suivi de votre candidature');
$PAGE->add_body_class('local-scholarship-home');

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);


$data = ApplicantController::followup();

echo $OUTPUT->header();

require(__DIR__ . '/followup.php');

echo $OUTPUT->footer();