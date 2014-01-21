<?php
/**
* File containing the eZIEImageToolRotation class.
* 
* @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
* @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
* @version 5.2.0
* @package ezie
*/
class eZIEImageToolRotation extends eZIEImageAction
{
    /**
    * Returns a rotation filter
    * 
    * @param  int $angle Rotation angle. Valid range [0-360]
    * @param  string $backgroundColor Background color hex code
    * @return array( ezcImageFilter  )
    */
    static function filter( $angle, $backgroundColor = 'FFFFFF' )
    {
        return array(
            new ezcImageFilter( 
                'rotate',
                array( 
                    'angle'      => $angle,
                    'background' => $backgroundColor 
                )
            )
        );
    }
}

?>
