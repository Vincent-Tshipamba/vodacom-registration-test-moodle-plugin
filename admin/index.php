<?php

use local_scholarship\controllers\AdminController;
// use local_scholarship\controllers\AdminController;

require('../../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/admin/index.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('dashboard_title', 'local_scholarship'));
$PAGE->set_heading(get_string('dashboard_title', 'local_scholarship'));

$PAGE->requires->jquery();
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/jquery-3.7.1.min.js'), true);

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

// TODO: remplacer les liens CDN pour pointer vers les fichiers locaux ci-dessous parce que pour le moment ça ne fonctionne pas. 
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/buttons.dataTables.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/dataTables.buttons.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/buttons.html5.min.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/buttons.print.min.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/jszip.min.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/pdfmake.min.js'), true);
// $PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/datatables/vfs_fonts.js'), true);

$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();

$data = AdminController::dashboard();

require(__DIR__ . '/dashboard.php');

echo $OUTPUT->footer();