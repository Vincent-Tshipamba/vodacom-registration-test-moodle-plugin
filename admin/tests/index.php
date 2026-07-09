<?php

use local_scholarship\controllers\TestController;

require('../../../../config.php');

require_login();

$context = context_system::instance();

require_capability('local/scholarship:manage', $context);

$PAGE->set_url(new moodle_url('/local/scholarship/admin/tests/index.php'));

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
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
$PAGE->requires->js(new moodle_url('/local/scholarship/assets/js/sweetalert2.js'), true);

$PAGE->add_body_class('local-scholarship-home');

echo $OUTPUT->header();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_sesskey();
    TestController::update_phase_status();
}

$data = TestController::index();
$currentEdition = $data->currentEdition;
$phaseTest = $data->phaseTest;
$phasePayload = [
    'id' => $phaseTest->id ?? null,
    'editionid' => $currentEdition->id,
    'status' => $phaseTest->status ?? 'AWAITING',
    'durationmin' => $phaseTest->durationmin ?? '',
    'starttime' => !empty($phaseTest->starttime) ? date('Y-m-d\TH:i', $phaseTest->starttime) : '',
    'endtime' => !empty($phaseTest->endtime) ? date('Y-m-d\TH:i', $phaseTest->endtime) : '',
    'passingscore' => $phaseTest->passingscore ?? '',
];
$builderPayload = [
    'phaseid' => (int) $phaseTest->id,
    'categories' => $data->categories,
    'questions' => $data->questions,
];

$testCandidates = $data->testCandidates;

$testDashboardStats = $data->testDashboardStats;

$testResults = $data->testResults;
$testResultsStats = $data->testResultsStats;
$testResultDetails = $data->testResultDetails;
$resultDetailsJson = json_encode($testResultDetails, JSON_HEX_APOS | JSON_HEX_QUOT);


$builderJson = json_encode($builderPayload, JSON_HEX_APOS | JSON_HEX_QUOT);

$questionspayload = [
    'phaseid' => (int) $data->phaseTest->id,
    'categories' => array_values($data->categories),
    'locked' => (bool) $data->lockstatus->locked,
    'lock_reason' => $data->lockstatus->reason,
    'active_count' => (int) $data->lockstatus->activecount,
    'completed_count' => (int) $data->lockstatus->completedcount,
    'questions' => array_values($data->questions),
    'questionSuggestions' => array_values($data->questionSuggestions),
    'assertionSuggestions' => array_values($data->assertionSuggestions),
    'sesskey' => sesskey(),
    'saveurl' => (new moodle_url('/local/scholarship/admin/tests/save-questions.php'))->out(false),
];

$questionsjson = json_encode(
    $questionspayload,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
);

echo html_writer::div('', '', [
    'id' => 'scholarship-test-config',
    'data-promote-url' => (new moodle_url('/local/scholarship/admin/tests/promote-passed.php'))->out(false),
    'data-save-questions-url' => (new moodle_url('/local/scholarship/admin/tests/save-questions.php'))->out(false),
    'data-update-url' => (new moodle_url('/local/scholarship/admin/tests/update-field.php'))->out(false),
    'data-status-url' => (new moodle_url('/local/scholarship/admin/tests/update-status.php'))->out(false),
    'data-sesskey' => sesskey(),
    'data-phaseid' => (int) $phaseTest->id
]);
// echo '<pre>';
// print_r($builderJson);
// die();
require(__DIR__ . '/tests.php');

echo $OUTPUT->footer();