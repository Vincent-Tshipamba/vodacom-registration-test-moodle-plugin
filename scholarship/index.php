<?php
require('../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/index.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('home:title', 'local_scholarship'));
$PAGE->set_heading(get_string('home:title', 'local_scholarship'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();

require(__DIR__ . '/templates/home.php');

echo $OUTPUT->footer();
