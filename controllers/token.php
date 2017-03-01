<?php
require_once('../config.php');
require_once('../libs/services/simpleHTTPClient.php');

$client = new SimpleHTTPClient();

class TokenController {
    public function __construct() {}

    public function exchangeCodeForToken($code) {
        $body = array(
                "code" => $code,
                "grant_type" => "authorization_code",
                "redirect_uri"=> AuthRedirectUri
        );

        $header = array(
            'Content-type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode(AuthClientId . ':' . AuthClientSecret)
        );

        $jsonArray = $this->_postToTokenEndpoint($header, $body);
        return $jsonArray;
    }

    public function refreshToken($token) {
       $body = array(
                "grant_type" => "refresh_token",
                "refresh_token" => $token
        );

        $header = array(
            'Content-type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode(AuthClientId . ':' . AuthClientSecret)
        );
        $jsonArray = $this->_postToTokenEndpoint($header, $body);
        return $jsonArray;
    }

    private function _postToTokenEndpoint($headerArray, $bodyArray) {
        $client = new SimpleHTTPClient();
        $dataQueryString = http_build_query($bodyArray);
        $response = $client->makeRequest(BBOAuthBaseURI.'/token', 'POST', $dataQueryString, $headerArray);
        $jsonResponseAsArray = json_decode($response['body'], true);
        return $jsonResponseAsArray;
    }
}