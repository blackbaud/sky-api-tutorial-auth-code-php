<?php
namespace blackbaud;

class Pkce {
    private $verifier = '';
    private $challenge = '';
    private $size = 128;
    
    public function __construct($verifierSize = 128) {
        if ($verifierSize > 43 && $verifierSize < 129) {
            $this->size = $verifierSize;
        }
        $this->verifier = $this->generateVerifier(); 
        $this->challenge = $this->generateChallenge();              
    }

    public function getChallenge() {
        return $this->challenge;
    }

    public function getVerifier() {
        return $this->verifier;
    }

    private function generateVerifier() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-._~';
        $randomString = '';
     
        for ($i = 0; $i < $this->size; $i++) {
            $index = random_int(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }

    private function generateChallenge() {
        return self::base64_urlencode(pack('H*', hash('sha256', $this->verifier)));
    }

    private function base64_urlencode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}