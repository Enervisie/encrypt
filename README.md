#PHP Encryption Class

This is a PHP class for encrypting and decrypting data and files using the AES-256-CBC encryption algorithm. It does not rely on any external libraries or extensions, as it uses the built-in OpenSSL functions provided by PHP.

### Usage
To use the Encryption class, include the class file in your PHP script and create an object of the class with the encryption key and initialization vector (IV) as parameters:

``` php
  require_once 'Encryption.php';

  $key = 'my_secret_key';
  $iv = 'my_secret_iv';

  $encryption = new Encryption($key, $iv);
```
You can then use any of the methods provided by the class to encrypt or decrypt data or files.


### Encrypting and decrypting strings
To encrypt a string, use the encryptString() method:

``` php
  $plaintext = 'hello world';
  $ciphertext = $encryption->encryptString($plaintext);
```

To decrypt a ciphertext back to plaintext, use the decryptString() method:

```php
  $plaintext = $encryption->decryptString($ciphertext);
```

### Encrypting and decrypting files
To encrypt a file, use the encryptFile() method:

``` php
  $inputFile = 'plain.txt';
  $outputFile = 'encrypted.txt';

  $encryption->encryptFile($inputFile, $outputFile);

```
To decrypt an encrypted file back to its original plaintext, use the decryptFile() method:

``` php
  $inputFile = 'encrypted.txt';
  $outputFile = 'plain.txt';

  $encryption->decryptFile($inputFile, $outputFile);
```

### Generating random keys and hashing passphrases
To generate a random encryption key, use the generateRandomKey() static method:

```php
  $key = Encryption::generateRandomKey();
```

To hash a passphrase for secure storage, use the hashPassphrase() static method:

``` php
  $passphrase = 'my_secret_password';
  $hash = Encryption::hashPassphrase($passphrase);
```

To verify a passphrase against a hash, use the verifyPassphrase() static method:

``` php
  $passphrase = 'my_secret_password';
  $hash = '$2y$10$afQ2Pi1H.8ib0o9XccGm7uON5M5i5r5h5fFkV7D84L/0b.R8UKv3G';

  if (Encryption::verifyPassphrase($passphrase, $hash)) {
      // passphrase is valid
  } else {
      // passphrase is invalid
  }
```

### Encrypting and decrypting large files
To encrypt a large file that doesn't fit in memory, use the encryptLargeFile() method:

``` php
  $inputFile = 'large_plain.txt';
  $outputFile = 'large_encrypted.txt';

  $encryption->encryptLargeFile($inputFile, $outputFile);

```

To decrypt a large encrypted file back to its original plaintext, use the decryptLargeFile() method:

``` php
  $inputFile = 'large_encrypted.txt';
  $outputFile = 'large_plain.txt';

  $encryption->decryptLargeFile($inputFile, $outputFile);
```

### Decrypting and deleting a file
To decrypt an encrypted file and delete it, use the decryptAndDeleteFile() method:

``` php
  $inputFile = 'encrypted.txt';
  $outputFile = 'plain.txt';

  $encryption->decryptAndDeleteFile($inputFile, $outputFile);
```

## Security Considerations
The AES-256-CBC encryption algorithm used by this class is considered to be secure when used correctly. However, the security of the encryption depends on the secrecy of the encryption key

