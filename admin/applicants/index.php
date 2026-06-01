<?php

use local_scholarship\controllers\AdminController;

require('../../../../config.php');

require_login();

$context = context_system::instance();

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
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/lucide.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.min.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.tailwindcss.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/chart.js'), true);

$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/select.dataTables.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.select.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/sweetalert2@11.js'), true);
echo $OUTPUT->header();

$data = AdminController::applicants();

require(__DIR__ . '/../partials/values.php');

require(__DIR__ . '/applicants.php');