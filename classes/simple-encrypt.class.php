<?php

class Encryption
{
    private $key;
    private $iv;

    public function __construct($key)
    {
        $this->key = md5($key, true);
        $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    }

    public function encrypt($data)
    {
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $this->iv);
        return base64_encode($this->iv . $encrypted);
    }

    public function decrypt($encrypted)
    {
        $encrypted = base64_decode($encrypted);
        $iv = substr($encrypted, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $data = substr($encrypted, openssl_cipher_iv_length('aes-256-cbc'));
        return openssl_decrypt($data, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
    }

    public function encryptFile($inputFile, $outputFile)
    {
        $inputHandle = fopen($inputFile, 'rb');
        $outputHandle = fopen($outputFile, 'wb');
        fwrite($outputHandle, $this->iv);
        while (!feof($inputHandle)) {
            $chunk = fread($inputHandle, 8192);
            $encrypted = openssl_encrypt($chunk, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $this->iv);
            fwrite($outputHandle, $encrypted);
        }
        fclose($inputHandle);
        fclose($outputHandle);
    }

    public function decryptFile($inputFile, $outputFile)
    {
        $inputHandle = fopen($inputFile, 'rb');
        $outputHandle = fopen($outputFile, 'wb');
        $iv = fread($inputHandle, openssl_cipher_iv_length('aes-256-cbc'));
        while (!feof($inputHandle)) {
            $chunk = fread($inputHandle, 8192);
            $decrypted = openssl_decrypt($chunk, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $iv);
            fwrite($outputHandle, $decrypted);
        }
        fclose($inputHandle);
        fclose($outputHandle);
    }
}
