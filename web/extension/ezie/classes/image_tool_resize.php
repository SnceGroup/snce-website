<?php
/**
* File containing the eZIEImageToolResize class.
* 
* @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
* @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
* @version 5.2.0
* @package ezie
*/
class eZIEImageToolResize extends eZIEImageAction
{
    /**
    * Returns a resize filter
    * 
    * @param  int $width Resize width
    * @param  int $height Resize height 
    * @return array( ezcImageFilter )
    */
    static function filter( $width, $height )
    {
        return array(
            new ezcImageFilter( 
                'scale',
                array( 
                    'width'     => intval( $width ),
                    'height'    => intval( $height ),
                    'direction' => ezcImageGeometryFilters::SCALE_BOTH 
                )
            )
        );
    }

    /**
    * Resizes an image
    * 
    * @param  string $src Source image path
    * @param  string $dst Destination image path
    * @param  int $width Resize width
    * @param  int $height Resize height
    * 
    * @return void
    */
    static function resize( $src, $dst, $width, $height )
    {
        $imageconverter = new eZIEezcImageConverter( self::filter( $width, $height ) );
        $imageconverter->perform( $src, $dst );
    }

    /**
    * Creates a thumb (250x250px) out of an image
    * @param  string $src Source image path
    * @param  string $dst Destination image path
    * @return void
    */
    static function doThumb( $src, $dst )
    {
        self::resize( $src, $dst, 250, 250 );
    }
}

?>
