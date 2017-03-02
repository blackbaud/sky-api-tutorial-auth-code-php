<?php
require_once '../includes/blackbaud/blackbaud.php';

$response = blackbaud\Auth::refreshAccessToken();

echo json_encode(array(
  'tokenResponse' => json_decode($response, true)
));
