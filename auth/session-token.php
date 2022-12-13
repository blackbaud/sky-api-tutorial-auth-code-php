<?php
require_once '../includes/blackbaud/blackbaud.php';

$response = blackbaud\Session::getToken();

echo json_encode($response);
