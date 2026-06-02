<?php

use local_scholarship\controllers\AdminController;

require('../../../../config.php');

require_login();
require_sesskey();

$context = context_system::instance();

header('Content-Type: application/json; charset=utf-8');

$results = AdminController::search();

echo json_encode($results);
exit;