<?php

require('../../../../config.php');

require_login();
require_sesskey();

$context = context_system::instance();

header('Content-Type: application/json; charset=utf-8');

$id = required_param('id', PARAM_INT);
$isvalid = required_param('isvalid', PARAM_BOOL);

global $DB, $USER;

$document = $DB->get_record('local_scholarship_document', ['id' => $id], '*', MUST_EXIST);

$document->verifstatus = $isvalid ? 'VALID' : 'INVALID';
$document->reviewedby = $USER->id;
$document->reviewedat = time();
$document->timemodified = time();

$DB->update_record('local_scholarship_document', $document);

echo json_encode([
    'success' => true,
    'message' => $isvalid
        ? 'Document validé avec succès.'
        : 'Document invalidé avec succès.',
]);
exit;