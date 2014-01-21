<?php
//
// Definition of eZOETemplateUtils class
//
// Created on: <14-May-2008 18:42:08 ar>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Online Editor
// SOFTWARE RELEASE: 5.2.0
// COPYRIGHT NOTICE: Copyright (C) 1999-2013 eZ Systems AS
// SOFTWARE LICENSE: eZ Business Use License Agreement eZ BUL Version 2.1
// NOTICE: >
//   This source file is part of the eZ Publish CMS and is
//   licensed under the terms and conditions of the eZ Business Use
//   License v2.1 (eZ BUL).
// 
//   A copy of the eZ BUL was included with the software. If the
//   license is missing, request a copy of the license via email
//   at license@ez.no or via postal mail at
//  	Attn: Licensing Dept. eZ Systems AS, Klostergata 30, N-3732 Skien, Norway
// 
//   IMPORTANT: THE SOFTWARE IS LICENSED, NOT SOLD. ADDITIONALLY, THE
//   SOFTWARE IS LICENSED "AS IS," WITHOUT ANY WARRANTIES WHATSOEVER.
//   READ THE eZ BUL BEFORE USING, INSTALLING OR MODIFYING THE SOFTWARE.

// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

/*
 Some misc template operators to get access to some of the features in eZ Publish API
 
*/

class eZOETemplateUtils
{
    function eZOETemplateUtils()
    {
    }

    function operatorList()
    {
        return array( 'ezoe_ini_section' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'ezoe_ini_section' => array( 'section' => array( 
                                                       'type' => 'string',
                                                       'required' => true,
                                                       'default' => '' ),
                                                   'file' => array( 
                                                       'type' => 'string',
                                                       'required' => false,
                                                       'default' => 'site.ini' )
                                           ));
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        $ret = '';

        switch ( $operatorName )
        {
            case 'ezoe_ini_section':
                {                    
                    $ini = eZINI::instance( $namedParameters['file'] );
                    $ret = $ini->hasSection( $namedParameters['section'] );
                } break;
        }
        $operatorValue = $ret;
    }
 
}

?>
