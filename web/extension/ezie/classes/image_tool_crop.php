<?php
/**
 * File containing the eZIEImageToolCrop class.
 * 
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 5.2.0
 * @package ezie
 */
class eZIEImageToolCrop extends eZIEImageAction
{
    /**
    * Creates a crop filter
    * 
    * @param  array(int) $region Affected region, as a 4 keys array: w, h, x, y
    * @return array( ezcImageFilter )
    */
    public static function filter( $region )
    {
        $r = array(
            'x'      => intval( $region['x'] ),
            'y'      => intval( $region['y'] ),
            'width'  => intval( $region['w'] ),
            'height' => intval( $region['h'] ) 
        );
        return array( new ezcImageFilter( 'crop', $r ) );
    }
}

?>
