<?php
session_start();
require_once('../libs/services/simpleHTTPClient.php');
require_once('../controllers/token.php');
require_once('../controllers/auth.php');
require_once('../controllers/session.php');
require('../config.php');

$tokenController = new TokenController();
$sessionController = new SessionController();
$authController = new AuthController();

$method = $_SERVER['REQUEST_METHOD'];
$request = $_GET['request'];

if(isset($request)){
    switch($request) 
    {
        case 'authenticated':
             $authed = $sessionController->accessTokenIsSet();
             echo json_encode(array('authenticated' => $authed));
            break;
        case 'login':
            $authController->loginMethod();
            break;
        case 'logout':
            session_unset(void);
            exit();
            break;
        case 'refresh-token':
            refreshAccessToken($sessionController->getRefreshToken());
        default;
    }
}

function refreshAccessToken($refresh_token) {
    $sessionController = new SessionController();
    $tokenController = new TokenController();
    $jsonArray = $tokenController->refreshToken($refresh_token);
    $sessionController->setToken($jsonArray['access_token'], 'ACCESS_TOKEN');
    $sessionController->setToken($jsonArray['refresh_token'], 'REFRESH_TOKEN');
    echo json_encode($jsonArray);
}