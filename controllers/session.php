<?php
class SessionController {
    public function __construct() {}

    public function setToken($token, $tokenName) {
        $_SESSION[$tokenName] = $token;
    }

    public function getAccessToken() {
        return $_SESSION['ACCESS_TOKEN'];
    }

    public function getRefreshToken() {
        return $_SESSION['REFRESH_TOKEN'];
    }

    public function accessTokenIsSet() {
        return isset($_SESSION['ACCESS_TOKEN']);
    }

    public function requestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
}