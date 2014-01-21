<?php
/**
 * File containing eZNetCrypt class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * @deprecated Class is no longer doing anything as of php5
 */
class eZNetCrypt
{

    /**
     * Encrypt text using DES if encryption is enabled (it's not)
     *
     * @param string $text
     * @return string
    */
    public static function encrypt( $text )
    {
        if ( self::$enabled === false )
        {
            return $text;
        }

        return mcrypt_encrypt( MCRYPT_3DES, self::$key, $text, MCRYPT_MODE_CFB, self::$IV );
    }

    /**
     * Decrypt text using DES if encryption is enabled (it's not)
     *
     * @param string $text
     * @return string
    */
    public static function decrypt( $enc )
    {
        if ( self::$enabled === false )
        {
            return $enc;
        }

        return mcrypt_decrypt( MCRYPT_3DES, self::$key, $enc, MCRYPT_MODE_CFB, self::$IV );
    }

    /**
     * Generate IV values
    */
    private function setIV()
    {
//        self::$IVSize = mcrypt_get_iv_size( MCRYPT_XTEA, MCRYPT_MODE_ECB );
//        self::$IV = mcrypt_create_iv( self::$IVSize, MCRYPT_RAND );
    }

    private static $IVSize = null;
    private static $IV = null;
    private static $key = '*321 regninger 123*';

    private static $enabled = false;
}

?>
