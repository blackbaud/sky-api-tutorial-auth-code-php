<?php
namespace blackbaud;

class Constituents {
  private static $headers = array();
  private static $baseUri;
  
  public static function init() {
    self::$headers = array(
      'bb-api-subscription-key: ' . AUTH_SUBSCRIPTION_KEY,
      'Authorization: Bearer ' . Session::getAccessToken(),
      'Content-type: application/x-www-form-urlencoded'
    );
    self::$baseUri = SKY_API_BASE_URI . 'constituent/v1/';
  }

  public static function getById($id = 0) {
    $url = self::$baseUri . 'constituents/' . $id;
    $response = Http::get($url, self::$headers);
    return json_decode($response, true);
  }
}

Constituents::init();
