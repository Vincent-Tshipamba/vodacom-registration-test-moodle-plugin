<?php

use local_scholarship\controllers\ApplicantController;
require('../../config.php');

$context = context_system::instance();

$PAGE->set_url(new moodle_url('/local/scholarship/apply.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('apply_title', 'local_scholarship'));
$PAGE->set_heading(get_string('apply_title', 'local_scholarship'));
$PAGE->requires->css(new moodle_url('/local/scholarship/assets/build/tailwind.css'));
$PAGE->requires->strings_for_js([
    'apply_step_1_title',
    'apply_step_2_title',
    'apply_step_3_title',
    'apply_step_4_title',
    'apply_step_5_title',
], 'local_scholarship');
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/registration-form.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/copy-to-clipboard.js'), true);
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/build/app.js'), true);
$PAGE->add_body_class('local-scholarship-home');
$PAGE->add_body_class('scholarship-home-bg');

$submitted = optional_param('submitted', 0, PARAM_BOOL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_sesskey();

    header('Content-Type: application/json; charset=utf-8');

    try {
        $controller = new ApplicantController();
        $result = $controller->store();

        echo json_encode([
            'success' => true,
            'apply_confirmation_details' => get_string('apply_confirmation_details', 'local_scholarship', [
                'fullname' => $result['fullname'] ?? '',
            ]),
            'apply_confirmation_coupon' => $result['regcode'] ?? null,
        ]);
        exit;

    } catch (\moodle_exception $e) {
        http_response_code(422);

        echo json_encode([
            'message' => 'Validation error',
            'errors' => [
                'general' => [$e->getMessage()],
            ],
        ]);
        exit;

    } catch (\Throwable $e) {
        http_response_code(422);

        echo json_encode([
            'message' => 'Validation error',
            'errors' => [
                'general' => [$e->getMessage()],
            ],
        ]);
        exit;
    }
}

echo $OUTPUT->header();
require(__DIR__ . '/templates/register.php');

echo $OUTPUT->footer();