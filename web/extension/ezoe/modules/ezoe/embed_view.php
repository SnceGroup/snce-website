<?php
//
// Created on: <28-Feb-2008 00:00:00 ar>
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

/*
 * Display the embed view of a object with params for class/inline/view/align/size
 * TODO: support for custom attributes
 */

$embedId         = 0;
$http            = eZHTTPTool::instance();
$tplSuffix       = '';
$idString        = '';
$tagName         = 'embed';
$embedObject     = false;

if ( isset( $Params['EmbedID'] )  && $Params['EmbedID'])
{
    $embedType = 'ezobject';
    if (  is_numeric( $Params['EmbedID'] ) )
        $embedId = $Params['EmbedID'];
    else
        list($embedType, $embedId) = explode('_', $Params['EmbedID']);

    if ( strcasecmp( $embedType  , 'eznode'  ) === 0 )
    {
        $embedNode   = eZContentObjectTreeNode::fetch( $embedId );
        $embedObject = $embedNode->object();
        $tplSuffix   = '_node';
        $idString    = 'eZNode_' . $embedId;
    }
    else
    {
        $embedObject = eZContentObject::fetch( $embedId );
        $idString    = 'eZObject_' . $embedId;
    }
}

if ( $embedObject instanceof eZContentObject )
{
    $objectName      = $embedObject->attribute( 'name' );
    $classID         = $embedObject->attribute( 'contentclass_id' );
    $classIdentifier = $embedObject->attribute( 'class_identifier' );
    if ( !$embedObject->attribute( 'can_read' ) || !$embedObject->attribute( 'can_view_embed' ) )
    {
        $tplSuffix = '_denied';
    }
}
else
{
    $objectName      = 'Unknown';
    $classID         = 0;
    $classIdentifier = false;
}

$className = '';
$size  = 'medium';
$view  = 'embed';
$align = 'none';
//$style = '';//'text-align: left;';

if ( isset( $_GET['inline'] ) && $_GET['inline'] === 'true' )
{
    $tagName = 'embed-inline';
}
else if ( $http->hasPostVariable('inline') &&
     $http->postVariable('inline') === 'true' )
{
    $tagName = 'embed-inline';
}

if ( isset( $_GET['class'] ) )
{
    $className = $_GET['class'];
}
else if ( $http->hasPostVariable('class') )
{
    $className = $http->postVariable('class');
}

if ( isset( $_GET['size'] ) )
{
    $size = $_GET['size'];
}
else if ( $http->hasPostVariable('size') )
{
    $size = $http->postVariable('size');
}

if ( isset( $_GET['view'] ) )
{
    $view = $_GET['view'];
}
else if ( $http->hasPostVariable('view') )
{
    $view = $http->postVariable('view');
}

if ( isset( $_GET['align'] ) )
{
    $align = $_GET['align'] === 'middle' ? 'center' : $_GET['align'];
}
else if ( $http->hasPostVariable('align') )
{
    $align = $http->postVariable('align');
    if ( $align === 'middle' )
        $align = 'center';
}

//if ( $align === 'left' || $align === 'right' )
//    $style .= ' float: ' . $align . ';';


$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array('classification', $className) ) );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'view', $view );
$tpl->setVariable( 'object', $embedObject );
$tpl->setVariable( 'link_parameters', array() );
$tpl->setVariable( 'classification', $className );
$tpl->setVariable( 'object_parameters', array( 'size' => $size, 'align' => $align, 'show_path' => true ) );
if ( isset( $embedNode ) ) $tpl->setVariable( 'node', $embedNode );

//if ( $style !== '' )
//    $style = ' style="' . $style . '"';

$templateOutput = $tpl->fetch( 'design:content/datatype/view/ezxmltags/' . $tagName . $tplSuffix . '.tpl' );
//echo '<div id="' . $idString . '" title="' . $objectName . '"' . $style . '>' . $templateOutput . '</div>';

//echo "<!--\r\n";
//eZDebug::printReport( false, false );
//echo "-->\r\n";
echo $templateOutput;



eZDB::checkTransactionCounter();
eZExecution::cleanExit();

?>
