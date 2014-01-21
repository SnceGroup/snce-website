<?php
//
// Created on: <20-Feb-2008 00:00:00 ar>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Online Editor extension for eZ Publish
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


/* For loading json data of a given object by object id */

$embedId         = 0;
$http            = eZHTTPTool::instance();

if ( isset( $Params['EmbedID'] ) && $Params['EmbedID'])
{
    $embedType = 'ezobject';
    if (  is_numeric( $Params['EmbedID'] ) )
        $embedId = $Params['EmbedID'];
    else
        list($embedType, $embedId) = explode('_', $Params['EmbedID']);

    if ( strcasecmp( $embedType  , 'eznode'  ) === 0 )
        $embedObject = eZContentObject::fetchByNodeID( $embedId );
    else
        $embedObject = eZContentObject::fetch( $embedId );
}

if ( !$embedObject instanceof eZContentObject || !$embedObject->canRead() )
{
   echo 'false';
   eZExecution::cleanExit();
}

// Params for node to json encoder
$params    = array('loadImages' => true);
$params['imagePreGenerateSizes'] = array('small', 'original');

// look for datamap parameter ( what datamap attribute we should load )
if ( isset( $Params['DataMap'] )  && $Params['DataMap'])
    $params['dataMap'] = array($Params['DataMap']);

// what image sizes we want returned with full data ( url++ )
if ( $http->hasPostVariable( 'imagePreGenerateSizes' ) )
    $params['imagePreGenerateSizes'][] = $http->postVariable( 'imagePreGenerateSizes' );
else if ( isset( $Params['ImagePreGenerateSizes'] )  && $Params['ImagePreGenerateSizes'])
    $params['imagePreGenerateSizes'][] = $Params['ImagePreGenerateSizes'];

// encode embed object as a json response
$json = ezjscAjaxContent::nodeEncode( $embedObject, $params );

// display debug as a js comment
//echo "/*\r\n";
//eZDebug::printReport( false, false );
//echo "*/\r\n";
echo $json;

eZDB::checkTransactionCounter();
eZExecution::cleanExit();

?>
