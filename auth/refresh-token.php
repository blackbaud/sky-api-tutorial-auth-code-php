<?php
require_once '../includes/blackbaud/blackbaud.php';

$response = blackbaud\Auth::refreshAccessToken();

echo json_encode(json_decode($response, true));
