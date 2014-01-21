<?php
//
// Definition of ezjscEncodingTemplateFunctions
//
// Created on: <17-Sep-2007 12:42:08 ar>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ JSCore extension for eZ Publish
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


/**
 * ezjscAjaxContent related template operators
 * 
 * (json|xml)_encode( hash $hash ): 
 * Encodes a array hash to (json|xml)
 * 
 * node_encode( array|eZContentObjectTreeNode $node[, hash $parameter[, string $type = 'json' ]]  ):
 * Simplifies a node or array of nodes to a array hash and encodes it to
 * json(default), xml or just the generated array hash.
 */

class ezjscEncodingTemplateFunctions
{
    function ezjscEncodingTemplateFunctions()
    {
    }

    function operatorList()
    {
        return array( 'json_encode',
                      'xml_encode',
                      'node_encode',
                      );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'json_encode' => array( 'hash' => array( 'type' => 'hash',
                                                'required' => true,
                                                'default' => array() )),
                      'xml_encode' => array( 'hash' => array( 'type' => 'hash',
                                                'required' => true,
                                                'default' => array() )),
                      'node_encode' => array( 'node' => array( 'type' => 'object',
                                                'required' => true,
                                                'default' => array() ),
                                              'params' => array( 'type' => 'hash',
                                                'required' => false,
                                                'default' => array() ),
                                              'type' => array( 'type' => 'string',
                                                'required' => false,
                                                'default' => 'json' )),
        );
                                              
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'json_encode':
            {
                // Lets you use json_encode from templates
                $operatorValue = json_encode( $namedParameters['hash'] );
            } break;
            case 'xml_encode':
            {
                // Lets you use ezjscAjaxContent::xmlEncode from templates
                $operatorValue = ezjscAjaxContent::xmlEncode( $namedParameters['hash'] );
            } break;
            case 'node_encode':
            {
                // Lets you use ezjscAjaxContent::nodeEncode from templates
                $operatorValue = ezjscAjaxContent::nodeEncode( $namedParameters['node'], $namedParameters['params'], $namedParameters['type'] );
            } break;
        }
    }
}

?>
