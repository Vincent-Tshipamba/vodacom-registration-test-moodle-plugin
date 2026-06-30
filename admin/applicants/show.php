<?php

use local_scholarship\controllers\AdminController;

require('../../../../config.php');

require_login();

$context = context_system::instance();
$id = optional_param('id', null, PARAM_INT);
$PAGE->set_url(new moodle_url('/local/scholarship/admin/applicants/show.php'), ['id' => $id]);

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$data = AdminController::applicant_details();
$PAGE->set_title(get_string('applicant_details_title', 'local_scholarship', [
    'fullname' => $data->applicant->fullname ?? '',
]));
$PAGE->set_heading(get_string('applicant_details_title', 'local_scholarship', [
    'fullname' => $data->applicant->fullname ?? '',
]));

$PAGE->requires->jquery();
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/lucide.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/sweetalert2.js'), true);
echo html_writer::div('', '', [
    'id' => 'scholarship-config',
    'data-document-status-url' => (new moodle_url('/local/scholarship/admin/applicants/document-status.php'))->out(false),
    'data-sesskey' => sesskey(),
]);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/details-applicant.js'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_sesskey();

    $status = optional_param('application_status', null, PARAM_TEXT);
    AdminController::update_applicant_status();
}

$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();


require(__DIR__ . '/../partials/values.php');

require(__DIR__ . '/applicant-details.php');