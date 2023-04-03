<?php

class Encryption
{
    private $key;
    private $iv;

    public function __construct($key, $iv)
    {
        $this->key = $key;
        $this->iv = $iv;
    }

    public function encryptString($plaintext)
    {
        return openssl_encrypt($plaintext, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $this->iv);
    }

    public function decryptString($ciphertext)
    {
        return openssl_decrypt($ciphertext, 'aes-256-cbc', $this->key, OPENSSL_RAW_DATA, $this->iv);
    }

    public function encryptFile($inputFile, $outputFile)
    {
        $plaintext = file_get_contents($inputFile);
        $encrypted = $this->encryptString($plaintext);
        file_put_contents($outputFile, $this->iv . $encrypted);
    }

    public function decryptFile($inputFile, $outputFile)
    {
        $ciphertext = file_get_contents($inputFile);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $this->iv = substr($ciphertext, 0, $ivLength);
        $ciphertext = substr($ciphertext, $ivLength);
        $plaintext = $this->decryptString($ciphertext);
        file_put_contents($outputFile, $plaintext);
    }

    public static function generateRandomKey($length = 32)
    {
        return bin2hex(random_bytes($length));
    }

    public static function hashPassphrase($passphrase)
    {
        return password_hash($passphrase, PASSWORD_DEFAULT);
    }

    public static function verifyPassphrase($passphrase, $hash)
    {
        return password_verify($passphrase, $hash);
    }

    public function encryptLargeFile($inputFile, $outputFile)
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

    public function decryptLargeFile($inputFile, $outputFile)
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

    public function decryptAndDeleteFile($inputFile, $outputFile)
    {
        $this->decryptFile($inputFile, $outputFile);
        unlink($inputFile);
    }
}
