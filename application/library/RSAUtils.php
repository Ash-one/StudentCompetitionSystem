<?php

require "ConfigRSA.php";
class RSAUtils
{

    /**
     * 获取私钥
     * @return resource
     */
    private static function getPrivateKey()
    {
        $return = openssl_pkey_get_private(RSA_private);
        if(!$return){
            die("私钥不可用");
        }
        return $return;
    }

    /**
     * 获取公钥
     * @return resource
     */
    private static function getPublicKey()
    {

        $return = openssl_pkey_get_public(RSA_public);
        if(!$return){
            die("公钥不可用");
        }
        return $return;
    }

    /**
     * 私钥加密
     * @param string $data
     * @return null|string
     */
    public static function privEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, self::getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 公钥加密
     * @param string $data
     * @return null|string
     */
    public static function publicEncrypt($data = '')
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, self::getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * 私钥解密
     * @param string $encrypted
     * @return null
     */
    public static function privDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey())) ? $decrypted : null;
    }

    /**
     * 公钥解密
     * @param string $encrypted
     * @return null
     */
    public static function publicDecrypt($encrypted = '')
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, self::getPublicKey())) ? $decrypted : null;
    }

}