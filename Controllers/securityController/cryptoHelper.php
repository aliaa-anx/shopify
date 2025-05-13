<?php
require_once __DIR__ . "/config.php";


class CryptoHelper
{
    private $cipherMethod = "AES-256-CBC";
    private $key;
    private $options = 0;

    public function __construct()
    {
        $this->key = ENCRYPTIONKEY; // Loaded from config
    }

    public function encrypt($data)
    {
        $ivLength = openssl_cipher_iv_length($this->cipherMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $encryptedData = openssl_encrypt($data, $this->cipherMethod, $this->key, $this->options, $iv);

        return [
            'encryptedData' => $encryptedData,
            'iv' => base64_encode($iv)// Store this in DB to use for decryption
        ];
    }


    public function decrypt($encryptedData,$iv)
    {
         $iv=base64_decode($iv); // Decode the IV from base64
         $decryptedData = openssl_decrypt($encryptedData, $this->cipherMethod, $this->key, $this->options, $iv);
         return $decryptedData;
    }
}
