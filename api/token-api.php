<?php
session_start();
require_once('../controllers/session.php');
require_once('../controllers/token.php');
$tokenController = new TokenController();
$sessionController = new SessionController();

if(isset($_GET['code'])) {
    exchangeCodeForToken($_GET['code']);
} else {
    header('Location: http://localhost:8888');
    exit();
}

function exchangeCodeForToken($code) {
    $tokenController = new TokenController();
    $sessionController = new SessionController();
    $jsonArray = $tokenController->exchangeCodeForToken($code);
    
    if ($jsonArray['access_token'] !== null) {
        $sessionController->setToken($jsonArray['access_token'], 'ACCESS_TOKEN');
        $sessionController->setToken($jsonArray['refresh_token'], 'REFRESH_TOKEN');
    }

    if($sessionController->accessTokenIsSet()) {
        header('Location: http://localhost:8888');
        exit();
    }
}

