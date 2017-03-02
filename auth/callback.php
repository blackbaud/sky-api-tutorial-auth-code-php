<?php
require_once '../includes/blackbaud/blackbaud.php';

blackbaud\Auth::exchangeCodeForAccessToken($_GET['code']);

header('Location: /');
exit();
