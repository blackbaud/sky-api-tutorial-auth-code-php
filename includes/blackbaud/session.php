<?php
namespace blackbaud;

session_start();

class Session {
  private static $tokenName = 'SKY_AUTH_TOKEN';

  public static function setToken($token = array()) {
    $_SESSION[self::$tokenName] = $token;
  }

  public static function getToken() {
    return $_SESSION[self::$tokenName];
  }
  
  public static function setStateVerifier($state = '', $verifier = '') {
    $_SESSION[$state] = $verifier;
  }

  public static function getStateVerifier($state = '') {
    return $_SESSION[$state];
  }
  
  public static function clearStateVerifier($state = '') {
    unset($_SESSION[$state]);
  }

  public static function getAccessToken() {
    // return the acces token if it is valid
    if (self::isAccessTokenValid()) {
      return $_SESSION[self::$tokenName]['access_token'];
    } else if (self::hasValidRefreshToken()) {
      // refresh the access token since it was invalid
      Auth::refreshAccessToken();
    } else {
      // log the user out since the access token and refresh tokens are invalid
      self::logout();
      
      //return a 401 response
      http_response_code(401);
      exit();
    }

    // return the access token if it is valid
    if (self::isAccessTokenValid()) {
      return $_SESSION[self::$tokenName]['access_token']; 
    }

    return;
  }

  public static function getRefreshToken() {
    if (!self::hasValidRefreshToken()) {
      return;
    }
    return $_SESSION[self::$tokenName]['refresh_token'];
  }

  public static function isAuthenticated() {
    return self::isAccessTokenValid() || self::hasValidRefreshToken();
  }

  private static function isAccessTokenValid() {
    // check the existance of the session values for the access token
    $exists = isset($_SESSION[self::$tokenName]) && isset($_SESSION[self::$tokenName]['access_token']) && isset($_SESSION[self::$tokenName]['access_token_expires']);
    if (!$exists) {
      return false;
    }
    // determine if the access token is expired
    $expires = $_SESSION[self::$tokenName]['access_token_expires'];
    $now = new \DateTime();
    // it is valid if the expiration is in the future
    $valid = $now < $expires;

    // return the validity of the access token
    return $valid;
  }

  private static function hasValidRefreshToken() {
    // check the existance of the session refresh token values
    $exists = isset($_SESSION[self::$tokenName]) && isset($_SESSION[self::$tokenName]['refresh_token']) && isset($_SESSION[self::$tokenName]['refresh_token_expires']);
    // return false if the session values were not found
    if (!$exists) {
      return false;
    }
    // get the expiration date from session
    $expires = $_SESSION[self::$tokenName]['refresh_token_expires'];
    $now = new \DateTime();

    // the refresh token is valid if the expiration date is in the future
    return $now < $expires;
  }

  public static function logout() {
    unset($_SESSION[self::$tokenName]);
  }
}
