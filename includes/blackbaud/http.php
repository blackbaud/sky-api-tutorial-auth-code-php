<?php
namespace blackbaud;

class Http {
  public static function get($url = '', $headers = array()) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
     // CURLOPT_SSL_VERIFYHOST => false,  //it can be used to bypass SSL issuer errors when running in local development only.
     // CURLOPT_SSL_VERIFYPEER => false,  //it can be used to bypass SSL issuer errors when running in local development only.
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  public static function patch($url = '', $body = array(), $headers = array()) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
     // CURLOPT_SSL_VERIFYHOST => false,  //it can be used to bypass SSL issuer errors when running in local development only.
     // CURLOPT_SSL_VERIFYPEER => false,  //it can be used to bypass SSL issuer errors when running in local development only.
      CURLOPT_CUSTOMREQUEST => 'PATCH',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_POSTFIELDS => json_encode($body)
    ));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }

  public static function post($url = '', $body = array(), $headers = array()) {
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
     // CURLOPT_SSL_VERIFYHOST => false,  //it can be used to bypass SSL issuer errors when running in local development only.
     // CURLOPT_SSL_VERIFYPEER => false,  //it can be used to bypass SSL issuer errors when running in local development only. 
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
