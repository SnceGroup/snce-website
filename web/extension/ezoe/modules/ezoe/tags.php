<?php
//
// Created on: <15-Feb-2008 00:00:00 ar>
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


$objectID      = isset( $Params['ObjectID'] ) ? (int) $Params['ObjectID'] : 0;
$objectVersion = isset( $Params['ObjectVersion'] ) ? (int) $Params['ObjectVersion'] : 0;
$tagName       = isset( $Params['TagName'] ) ? strtolower( trim( $Params['TagName'] )) : '';
$customTagName = isset( $Params['CustomTagName'] ) ? trim( $Params['CustomTagName'] ) : '';

if ( $customTagName === 'undefined' ) $customTagName = '';

if ( $objectID === 0  || $objectVersion === 0 )
{
   echo ezpI18n::tr( 'design/standard/ezoe', 'Invalid or missing parameter: %parameter', null, array( '%parameter' => 'ObjectID/ObjectVersion' ) );
   eZExecution::cleanExit();
}

$object = eZContentObject::fetch( $objectID );
if ( !$object instanceof eZContentObject || !$object->canEdit() )
{
   echo ezpI18n::tr( 'design/standard/ezoe', 'Invalid parameter: %parameter = %value', null, array( '%parameter' => 'ObjectId', '%value' => $objectID ) );
   eZExecution::cleanExit();
}


$templateName = '';


// pick template based on tag, tags that have same
// set of attributes usually share template.
switch ( $tagName )
{
    case 'strong':
    case 'emphasize':
    case 'literal':
    case 'li':
    case 'ol':
    case 'ul':
    case 'tr':
    case 'paragraph':
        $templateName = 'tag_general.tpl';
        break;
    case 'header':
        $templateName = 'tag_header.tpl';
        break;
    case 'custom':
        $templateName = 'tag_custom.tpl';
        break;
    case 'link':
        $templateName = 'tag_link.tpl';
        break;
    case 'anchor':
        $templateName = 'tag_anchor.tpl';
        break;
    case 'table':
        $templateName = 'tag_table.tpl';
        break;
    case 'th':
    case 'td':
        $templateName = 'tag_table_cell.tpl';
        break;
    //case 'embed': this view is not used for embed tags, look in relations.php
}


if ( !$templateName )
{
   echo ezpI18n::tr( 'design/standard/ezoe', 'Invalid parameter: %parameter = %value', null, array( '%parameter' => 'TagName', '%value' => $tagName ) );
   eZExecution::cleanExit();
}



// class list with description
$classList  = array();
$customInlineList = array();
$contentIni = eZINI::instance( 'content.ini' );

if ( $tagName === 'custom' )
{
    // custom tags dosn't have a class, so we use custom tag name as class internally
    // in the editor to be able to have different styles on differnt custom tags.
    if ( $contentIni->hasVariable( 'CustomTagSettings', 'CustomTagsDescription' ) )
        $customTagDescription = $contentIni->variable( 'CustomTagSettings', 'CustomTagsDescription' );
    else
        $customTagDescription = array();

    if ( $contentIni->hasVariable( 'CustomTagSettings', 'IsInline' ) )
        $customInlineList = $contentIni->variable( 'CustomTagSettings', 'IsInline' );

    foreach( $contentIni->variable( 'CustomTagSettings', 'AvailableCustomTags' ) as $tag )
    {
        if ( isset( $customTagDescription[$tag] ) )
            $classList[$tag] = $customTagDescription[$tag];
        else
            $classList[$tag] = $tag;
    }
}
else
{
    // class data for normal tags
    if ( $contentIni->hasVariable( $tagName, 'ClassDescription' ) )
        $classListDescription = $contentIni->variable( $tagName, 'ClassDescription' );
    else
        $classListDescription = array();

    $classList['-0-'] = 'None';
    if ( $contentIni->hasVariable( $tagName, 'AvailableClasses' ) )
    {
        foreach ( $contentIni->variable( $tagName, 'AvailableClasses' ) as $class )
        {
            if ( isset( $classListDescription[$class] ) )
                $classList[$class] = $classListDescription[$class];
            else
                $classList[$class] = $class;
        }
    }
}

include_once( 'kernel/common/template.php' );
$tpl = eZTemplate::factory();
$tpl->setVariable( 'object', $object );
$tpl->setVariable( 'object_id', $objectID );
$tpl->setVariable( 'object_version', $objectVersion );

$tpl->setVariable( 'tag_name', $tagName );
$tpl->setVariable( 'custom_tag_name', $customTagName );

$tpl->setVariable( 'custom_inline_tags', $customInlineList );

$tpl->setVariable( 'class_list', $classList );

$ezoeIni = eZINI::instance( 'ezoe.ini' );
$tpl->setVariable( 'custom_attribute_style_map', json_encode( $ezoeIni->variable('EditorSettings', 'CustomAttributeStyleMap' ) ) );

// use persistent_variable like content/view does, sending parameters
// to pagelayout as a hash.
$tpl->setVariable( 'persistent_variable', array() );

$xmlTagAliasList = $ezoeIni->variable( 'EditorSettings', 'XmlTagNameAlias' );
if ( isset( $xmlTagAliasList[$tagName] ) )
    $tpl->setVariable( 'tag_name_alias', $xmlTagAliasList[$tagName] );
else
    $tpl->setVariable( 'tag_name_alias', $tagName );


if ( $tagName === 'td' || $tagName === 'th' )
{
    // generate javascript data for td / th classes
    $tagName2 = $tagName === 'td' ? 'th' : 'td';
    $cellClassList = array( $tagName => $classList, $tagName2 => array('-0-' => 'None') );

    if ( $contentIni->hasVariable( $tagName2, 'ClassDescription' ) )
        $classListDescription = $contentIni->variable( $tagName2, 'ClassDescription' );
    else
        $classListDescription = array();

    if ( $contentIni->hasVariable( $tagName2, 'AvailableClasses' ) )
    {
        foreach ( $contentIni->variable( $tagName2, 'AvailableClasses' ) as $class )
        {
            if ( isset( $classListDescription[$class] ) )
                $cellClassList[$tagName2][$class] = $classListDescription[$class];
            else
                $cellClassList[$tagName2][$class] = $class;
        }
    }
    $tpl->setVariable( 'cell_class_list', json_encode( $cellClassList ) );
}

// run template and return result
$Result = array();
$Result['content'] = $tpl->fetch( 'design:ezoe/' . $templateName );
$Result['pagelayout'] = 'design:ezoe/popup_pagelayout.tpl';
$Result['persistent_variable'] = $tpl->variable( 'persistent_variable' );
return $Result;


//eZExecution::cleanExit();
//$GLOBALS['show_page_layout']

?>
