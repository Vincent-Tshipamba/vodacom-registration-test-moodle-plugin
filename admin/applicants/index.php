<?php

use local_scholarship\controllers\AdminController;

require('../../../../config.php');

require_login();

$context = context_system::instance();

require_capability('local/scholarship:manage', $context);

$PAGE->set_url(new moodle_url('/local/scholarship/admin/applicants/index.php'));

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('applicants_title', 'local_scholarship'));
$PAGE->set_heading(get_string('applicants_title', 'local_scholarship'));

$PAGE->requires->jquery();
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.tailwindcss.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/buttons.dataTables.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/select.dataTables.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.dataTables.min.css'));

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/lucide.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.min.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.tailwindcss.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/chart.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/select.dataTables.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.select.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/sweetalert2.js'), true);

$PAGE->add_body_class('local-scholarship-home');
$data = AdminController::applicants();

echo $OUTPUT->header();


echo html_writer::div('', '', [
    'id' => 'scholarship-config',
    'data-next-page-url' => s($data->nextpageurl),
    'data-search-url' => (new moodle_url('/local/scholarship/admin/applicants/index.php'))->out(false),
    'data-document-status-url' => (new moodle_url('/local/scholarship/admin/applicants/document-status.php'))->out(false),
    'data-sesskey' => sesskey(),
]);
require(__DIR__ . '/../partials/topbar.php');
require(__DIR__ . '/../partials/values.php');

require(__DIR__ . '/applicants.php');

echo $OUTPUT->footer();