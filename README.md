# encrypt
To use this class to encrypt and decrypt data, you can create a new instance of the Encryption class and call the encrypt and decrypt methods:


``` php
  $encryption = new Encryption('my-secret-key');

  $encryptedData = $encryption->encrypt('my secret data');
  echo $encryptedData . "\n"; // Output: <base64-encoded-encrypted-data>

  $decryptedData = $encryption->decrypt($encryptedData);
  echo $decryptedData . "\n"; // Output: my secret data
```
To encrypt and decrypt files, you can use the encryptFile and decryptFile methods:

```php
  $encryption = new Encryption('my-secret-key');

  $encryption->encryptFile('input.txt', 'encrypted.txt');
  $encryption->decryptFile('encrypted.txt', 'output.txt');
```
Note that this implementation uses the AES-256-CBC encryption algorithm with a randomly generated initialization vector (IV) for each encryption operation. The key is derived from a user-provided passphrase using the MD5 hash function. While this implementation is suitable for simple use cases, it may not provide sufficient security for more sensitive applications. Therefore, it is recommended to use a well-established encryption library or consult a security expert before deploying this code
