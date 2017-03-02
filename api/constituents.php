<?php
require_once '../includes/blackbaud/blackbaud.php';

// Get one constituent record by ID.
if (isset($_GET['id'])) {
  $data = blackbaud\Constituents::getById($_GET['id']);

  // Access token has expired. Attempt to refresh.
  if (isset($data['statusCode']) && $data['statusCode'] == 401) {
    $response = blackbaud\Auth::refreshAccessToken();
    $token = json_decode($response, true);
    if (!isset($token['access_token'])) {
      echo json_encode($token);
      return;
    }
    $data = blackbaud\Constituents::getById($_GET['id']);
  }

  echo json_encode(array('constituent' => $data));
}