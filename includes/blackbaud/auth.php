<?php
namespace blackbaud;

class Auth {
  public static function redirect() {
    $auth_uri = Auth::getAuthorizationUri();
    header("Location: $auth_uri", true, 301);
    exit();
  }

  public static function exchangeCodeForAccessToken($code = 0) {
    $body = array(
      'code' => $code,
      'grant_type' => 'authorization_code',
      'redirect_uri' => AUTH_REDIRECT_URI
    );
    return self::fetchTokens($body);
  }

  public static function refreshAccessToken() {
    $body = array(
      'grant_type' => 'refresh_token',
      'refresh_token' => Session::getRefreshToken()
    );
    return self::fetchTokens($body);
  }

  private static function getAuthorizationUri() {
    return AUTH_BASE_URI . 'authorization?' . 
      http_build_query(array(
        'client_id'=> AUTH_CLIENT_ID,
        'response_type' => 'code',
        'redirect_uri' => AUTH_REDIRECT_URI
      ));
  }

  private static function fetchTokens($body = array()) {
    $headers = array(
      'Content-type: application/x-www-form-urlencoded',
      'Authorization: Basic ' . base64_encode(AUTH_CLIENT_ID . ':' . AUTH_CLIENT_SECRET)
    );

    $url = AUTH_BASE_URI . 'token';

    $response = Http::post($url, $body, $headers);
    $token = json_decode($response, true);
    Session::setToken($token);
    return $response;
  }
}
