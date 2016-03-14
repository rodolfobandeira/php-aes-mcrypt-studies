# php-aes-mcrypt-studies
A simple personal repository to learn a bit about AES Encryption using PHP/Mcrypt

---

- Run composer to install required libraries. If you don't have composer google it how to get it;
- `composer install`
- Edit the config/config.yml with your secret key. This string will be converted to a 32 chars md5 hash before getting encrypted to AES-256;
- Run the example! `php example.php` The string to be encrypted is `$plaintext` inside example.php

**This is the output:**

```
Key size: 32 (AES-256)
Encrypted AES string:
05UlGJ0CoXIoDJSuiFsfcvZ9vwYr/Z7bR9G0Ab+eaDvJmjV0yAaNyKwTGY03t5Zz/NMVHnIZMmVcma/v2hYxrTRCiYdTNDImImLahbVSsCU=

Decrypted AES string:
This string was AES-256 / CBC / ZeroBytePadding encrypted.
```



---

Reference:

- [http://php.net/mcrypt_encrypt] (http://php.net/mcrypt_encrypt)
