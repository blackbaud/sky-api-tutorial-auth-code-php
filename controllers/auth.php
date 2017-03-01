<?php
require('session.php');
$sessionController = new SessionController();

class AuthController {
    public function __construct() {}

    public function Login() {
        header('Location: '. $this->_getAuthorizationUri(), TRUE, 301);
        exit();
    }

    protected function _getAuthorizationUri() {
        return  BBOAuthBaseURI . "/authorization" .
                "?client_id=" . AuthClientId . 
                "&response_type=code" . 
                "&redirect_uri=" . AuthRedirectUri;
    }
}