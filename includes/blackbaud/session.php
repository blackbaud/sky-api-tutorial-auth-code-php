<?php
namespace blackbaud;

session_start();

class Session {
  private static $tokenName = 'SKY_AUTH_TOKEN';

  public static function setToken($token = array()) {
    $_SESSION[self::$tokenName] = $token;
  }

  public static function getAccessToken() {
    if (!self::isAuthenticated()) {
      return;
    }
    return $_SESSION[self::$tokenName]['access_token'];
  }

  public static function getRefreshToken() {
    if (!self::isAuthenticated()) {
      return;
    }
    return $_SESSION[self::$tokenName]['refresh_token'];
  }

  public static function isAuthenticated() {
    return isset($_SESSION[self::$tokenName]) && isset($_SESSION[self::$tokenName]['access_token']);
  }

  public static function logout() {
    unset($_SESSION[self::$tokenName]);
  }
}
