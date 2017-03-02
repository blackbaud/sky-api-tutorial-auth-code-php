<?php
require_once('../libs/services/simpleHTTPClient.php');
require('../config.php');

class APIController {
    public $_path;
    public $_client;

    public function __construct($path) {
        $this->_path = $path;
        $this->_client = new SimpleHTTPClient();
    }

    public function getById($id, $access_token) {
        $requestHeader = array(
            'bb-api-subscription-key: ' . AuthSubscriptionKey,
            'Authorization: Bearer ' . $access_token,
            'Content-type: application/x-www-form-urlencoded',
        );

        $response = $this->_client->makeRequest(
            'https://api.sky.blackbaud.com/constituent/v1/' . $this->_path . '/' . $id,
            'GET', 
            null,
            $requestHeader
        );

        if(json_decode($response['body'], true)['statusCode'] == 401) {
            return array('error' => $response);
        }
         return array('constituent' => json_decode($response['body'], true));
    }

    public function getPath () {
        return $this->_path;
    }

}