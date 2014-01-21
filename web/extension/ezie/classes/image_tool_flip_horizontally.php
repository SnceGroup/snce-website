<?php
/**
 * File containing the eZIEImageToolFlipHor class.
 * 
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 5.2.0
 * @package ezie
 */
class eZIEImageToolFlipHorizontally extends eZIEImageAction
{
    /**
     * Creates a horizontal flip filter
     * @param  array(int) $region Affected region, as an array of 4 keys: w, h, x, y
     * @return array( ezcImageFilter )
     */
    static function filter( $region = null )
    {
        return array(
            new ezcImageFilter( 
                'horizontalFlip',
                array( 
                    'region' => $region 
                )
            )
        );
    }
}

?>
