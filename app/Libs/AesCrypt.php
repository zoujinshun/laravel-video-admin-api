<?php
/*
 * @Descripttion: Aes加解密
 * @Autor: zjs
 * @Date: 2020-11-25 09:49:42
 * @LastEditTime: 2020-11-25 11:43:11
 * @FilePath: /app/Libs/AesCrypt.php
 */
namespace App\Libs;

class AesCrypt
{
    private static $hex_iv = '00000000000000000000000000000000';

    private static $key;

    public function __construct()
    {
        $this->key = config('app.aeskey');
        $this->key = hash('sha256', self::$key, true);
    }

    public static function encrypt($input)
    {
        if (!is_string($input) && \is_array($input)) {
            $input = json_encode($input);
        }
        $data = openssl_encrypt($input, 'AES-256-CBC', self::$key, OPENSSL_RAW_DATA, self::hexToStr(self::$hex_iv));
        $data = base64_encode($data);
        return $data;
    }

    public static function decrypt($input, $array = true)
    {
        $decrypted = openssl_decrypt(base64_decode($input), 'AES-256-CBC', self::$key, OPENSSL_RAW_DATA, self::hexToStr(self::$hex_iv));
        if ($array) {
            $decrypted = json_decode($decrypted);
        }
        return $decrypted;
    }

    /*
    For PKCS7 padding
     */

    private function addpadding($string, $blocksize = 16)
    {

        $len = strlen($string);

        $pad = $blocksize - ($len % $blocksize);

        $string .= str_repeat(chr($pad), $pad);

        return $string;

    }

    private static function strippadding($string)
    {

        $slast = ord(substr($string, -1));

        $slastc = chr($slast);

        $pcheck = substr($string, -$slast);

        if (preg_match("/$slastc{" . $slast . "}/", $string)) {

            $string = substr($string, 0, strlen($string) - $slast);

            return $string;

        } else {

            return false;

        }

    }

    public static function hexToStr($hex)
    {

        $string = '';

        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {

            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));

        }

        return $string;
    }
}
