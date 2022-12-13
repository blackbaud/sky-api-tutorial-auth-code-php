<?php
namespace blackbaud;

class Constituents {
  private static $baseUri;
  
  public static function init() {
    self::$baseUri = SKY_API_BASE_URI . 'constituent/v1/';
  }

  public static function getHeaders($contentType) {
    return array(
      'bb-api-subscription-key: ' . AUTH_SUBSCRIPTION_KEY,
      'Authorization: Bearer ' . Session::getAccessToken(),
      'Content-type: ' . $contentType
    );
  }

  public static function getById($id = 0) {
    $url = self::$baseUri . 'constituents/' . $id;
    $headers = self::getHeaders('application/x-www-form-urlencoded');
    $response = Http::get($url, $headers);
    return json_decode($response, true);
  }

  public static function update($constituent = array()) {
    $url = self::$baseUri . 'constituents/' . $constituent['constituent_id'];
    $headers = self::getHeaders('application/json');
    $response = Http::patch($url, $constituent, $headers);
    return json_decode($response, true);
  }
}

Constituents::init();
