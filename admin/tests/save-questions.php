<?php

require(__DIR__ . '/../../../../config.php');

use local_scholarship\controllers\TestController;

require_login();
require_sesskey();

header('Content-Type: application/json; charset=utf-8');

try {
    echo json_encode(TestController::save_questions());
    exit;
} catch (Throwable $e) {
    http_response_code(422);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
    exit;
}