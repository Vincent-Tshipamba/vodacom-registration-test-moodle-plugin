<?php

require(__DIR__ . '/../../../../config.php');

require_login();
require_sesskey();

header('Content-Type: application/json; charset=utf-8');

global $DB;

$id = optional_param('id', 0, PARAM_INT);
$editionid = required_param('editionid', PARAM_INT);
$field = required_param('field', PARAM_ALPHANUMEXT);
$value = optional_param('value', '', PARAM_RAW_TRIMMED);

$allowedfields = [
    'durationmin',
    'starttime',
    'endtime',
    'passingscore',
];

if (!in_array($field, $allowedfields, true)) {
    echo json_encode([
        'success' => false,
        'message' => 'Champ non autorisé.',
    ]);
    exit;
}

$record = $id
    ? $DB->get_record('local_scholarship_phasetest', ['id' => $id], '*', MUST_EXIST)
    : null;

if (!$record) {
    $record = new stdClass();
    $record->editionid = $editionid;
    $record->status = 'AWAITING';
    $record->timecreated = time();
}

if (in_array($field, ['starttime', 'endtime'], true)) {
    $record->$field = $value ? strtotime($value) : null;
} else if (in_array($field, ['durationmin'], true)) {
    $record->$field = $value !== '' ? (int) $value : null;
} else if ($field === 'passingscore') {
    $record->$field = $value !== '' ? (float) $value : null;
}

$record->timemodified = time();

if (empty($record->id)) {
    $record->id = $DB->insert_record('local_scholarship_phasetest', $record);
} else {
    $DB->update_record('local_scholarship_phasetest', $record);
}

$phase = $DB->get_record('local_scholarship_phasetest', ['id' => $record->id], '*', MUST_EXIST);

echo json_encode([
    'success' => true,
    'phase' => [
        'id' => (int) $phase->id,
        'editionid' => (int) $phase->editionid,
        'status' => $phase->status,
        'durationmin' => $phase->durationmin,
        'starttime' => !empty($phase->starttime) ? date('Y-m-d\TH:i', $phase->starttime) : '',
        'endtime' => !empty($phase->endtime) ? date('Y-m-d\TH:i', $phase->endtime) : '',
        'passingscore' => $phase->passingscore,
    ],
]);
exit;