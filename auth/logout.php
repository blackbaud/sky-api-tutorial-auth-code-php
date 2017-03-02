<?php
require_once '../includes/blackbaud/blackbaud.php';

blackbaud\Session::logout();
echo json_encode(array());
