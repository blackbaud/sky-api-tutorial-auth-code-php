<?php
session_start();
require_once('../controllers/token.php');
require_once('../controllers/api.php');
require_once('../controllers/session.php');
$tokenController = new TokenController();
$sessionService = new SessionController();

$method = $sessionService->requestMethod();
$apiController = new APIController($_GET['path']);

if(isset($method)) {
    switch($method) 
    {
        case 'GET':
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                $token = $sessionService->getAccessToken();
                echo json_encode($apiController->getById($id, $token));
            } else {
                echo http_response_code(404);
            }
            break;
        case 'PUT':
        case 'POST':
        case 'DELETE':
        default:
        echo http_response_code(404);
    }
}