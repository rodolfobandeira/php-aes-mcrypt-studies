<?php

/*
 * Got this example from: http://php.net/mcrypt_encrypt
 * Someone commented there saying the right way to do this nowadays
 * is using openssl. So, I'll make another repository to explore 
 * this alternative. 
 *
 */
require ("vendor/autoload.php");

use Symfony\Component\Yaml\Yaml;

$config = Yaml::parse(file_get_contents(__DIR__ . '/config/config.yml'));

    # --- ENCRYPTION ---

    # Converting string (secret_key) to hex:
    $hexstr = unpack('H*', md5($config['secret_key']));
    $secret_key = array_shift($hexstr);

    $key = pack('H*', $secret_key);
    
    # show key size use either 16, 24 or 32 byte keys for AES-128, 192
    # and 256 respectively
    $key_size =  strlen($key);
    echo "Key size: " . $key_size . " (AES-256)\n";
    
    $plaintext = "This string was AES-256 / CBC / ZeroBytePadding encrypted.";

    # create a random IV to use with CBC encoding
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    
    # creates a cipher text compatible with AES (Rijndael block size = 128)
    # to keep the text confidential 
    # only suitable for encoded input that never ends with value 00h
    # (because of default zero padding)
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                                 $plaintext, MCRYPT_MODE_CBC, $iv);

    # prepend the IV for it to be available for decryption
    $ciphertext = $iv . $ciphertext;
    
    # encode the resulting cipher text so it can be represented by a string
    $ciphertext_base64 = base64_encode($ciphertext);

    echo "Encrypted AES string: \n";
    echo  $ciphertext_base64 . "\n";


    # --- DECRYPTION ---
    
    $ciphertext_dec = base64_decode($ciphertext_base64);
    
    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    
    # retrieves the cipher text (everything except the $iv_size in the front)
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);

    # may remove 00h valued characters from end of plain text
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    
    echo "\nDecrypted AES string: \n";
    echo  $plaintext_dec . "\n";


/*
Output:

Key size: 32 (AES-256)
Encrypted AES string:
05UlGJ0CoXIoDJSuiFsfcvZ9vwYr/Z7bR9G0Ab+eaDvJmjV0yAaNyKwTGY03t5Zz/NMVHnIZMmVcma/v2hYxrTRCiYdTNDImImLahbVSsCU=

Decrypted AES string:
This string was AES-256 / CBC / ZeroBytePadding encrypted.

*/


