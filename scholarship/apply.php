<?php
require('../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/apply.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('apply_title', 'local_scholarship'));
$PAGE->set_heading(get_string('apply_title', 'local_scholarship'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/registration-form.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->add_body_class('local-scholarship-home');
$PAGE->add_body_class('scholarship-home-bg');

$submitted = optional_param('submitted', 0, PARAM_BOOL);

echo $OUTPUT->header();
require(__DIR__ . '/templates/register.php');

echo $OUTPUT->footer();