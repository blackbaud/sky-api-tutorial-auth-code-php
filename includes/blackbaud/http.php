<?php
namespace blackbaud;

class Http {
  public static function get($url = '', $headers = array()) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  public static function post($url = '', $body = array(), $headers = array()) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_POSTFIELDS => http_build_query($body)
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }
}
