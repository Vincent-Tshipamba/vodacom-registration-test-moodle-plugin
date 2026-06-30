<?php

use local_scholarship\controllers\InterviewController;
use local_scholarship\controllers\TestController;

require('../../../../config.php');

require_login();

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/admin/interviews/index.php'));

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
//TODO: Replace the page title
$PAGE->set_title(get_string('admin_tests_title', 'local_scholarship'));
$PAGE->set_heading(get_string('admin_tests_title', 'local_scholarship'));

$PAGE->requires->jquery();

$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.tailwindcss.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/buttons.dataTables.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/select.dataTables.css'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.dataTables.min.css'));

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/sweetalert2.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/lucide.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/init-phasetest.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.min.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.tailwindcss.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/chart.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/select.dataTables.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.select.js'), true);

$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();

$data = InterviewController::index();
$currentEdition = $data->currentEdition;

require(__DIR__ . '/interviews.php');

echo $OUTPUT->footer();