<?php
namespace blackbaud;
use DateTime;
use DateTimeInterval;

class Auth {
  public static function redirect() {
    // redirect the user to the OAuth Authorize page
    $auth_uri = self::getAuthorizationUri();
    header("Location: $auth_uri", true, 301);
    exit();
  }

  public static function exchangeCodeForAccessToken($code = 0, $state = '') {
    // get the code verifier using the state from session
    $verifier = Session::getStateVerifier($state);

    // only fetch the tokens if the code verifier is set
    if (isset($verifier)) {
      $body = array(
        'code' => $code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => AUTH_REDIRECT_URI,
        'code_verifier' => $verifier
      );

      // clear the value in session for the state code verifier
      Session::clearStateVerifier($state);

      // fetch the tokens
      $result = self::fetchTokens($body);

      // return the tokens
      return $result;
    }

    throw 'Invalid code verifier';
  }

  public static function refreshAccessToken() {
    // call the refresh token endpoint with the refresh token in session
    $body = array(
      'grant_type' => 'refresh_token',
      'refresh_token' => Session::getRefreshToken()
    );
    return self::fetchTokens($body);
  }

  private static function getAuthorizationUri() {
    // create the verifier and challenge for pkce
    $pkce = new Pkce();
    // create a unique state string
    $state = uniqid();
    // store the code verifier value in session using the state unique id
    Session::setStateVerifier($state, $pkce->getVerifier());

    // create the url to the OAuth authrize page
    // with the pkce code challange parameters and the unique state value
    return AUTH_BASE_URI . 'authorization?' . 
      http_build_query(array(
        'client_id'=> AUTH_CLIENT_ID,
        'response_type' => 'code',
        'redirect_uri' => AUTH_REDIRECT_URI,
        'code_challenge_method' => 'S256',
        'code_challenge' => $pkce->getChallenge(),
        'state' => $state
      )); 
  }

  private static function fetchTokens($body = array()) {
    $headers = array(
      'Content-type: application/x-www-form-urlencoded',
      'Authorization: Basic ' . base64_encode(AUTH_CLIENT_ID . ':' . AUTH_CLIENT_SECRET)
    );

    $url = AUTH_BASE_URI . 'token';

    $response = Http::post($url, $body, $headers);

    // json decode the response
    $token = json_decode($response, true);

    // set the expiration date of the access and refresh tokens
    $accessExpires = new DateTime();
    $refreshExpires = new DateTime();
    // add the expires in seconds to the current date
    $accessExpires = $accessExpires->add(new \DateInterval("PT{$token['expires_in']}S"));
    // add the refresh token expires in to the current date
    $refreshExpires = $refreshExpires->add(new \DateInterval("PT{$token['refresh_token_expires_in']}S"));
    // add the exipiration dates to the the token
    $token['access_token_expires'] = $accessExpires;
    $token['refresh_token_expires'] = $refreshExpires;

    // set the token response in session
    Session::setToken($token);

    return $response;
  }
}
