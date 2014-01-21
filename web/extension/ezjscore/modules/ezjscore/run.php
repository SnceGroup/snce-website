<?php
//
// Created on: <16-Jun-2008 00:00:00 ar>
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

/* 
 * Brief: ezjsc module run
 * A light redirector to be able to run other modules indirectly w/o having to use empty layout/set/*.
 */

$uriParams = $Params['Parameters'];
$userParams = $Params['UserParameters'];

// Functions that earlier existed in index_ajax.php (now removed from ezjscore)
function exitWithInternalError( $errorText )
{
    header( $_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error' );
    //include_once( 'extension/ezjscore/classes/ezjscajaxcontent.php' );
    $contentType = ezjscAjaxContent::getHttpAccept();

    // set headers
    if ( $contentType === 'xml' )
        header('Content-Type: text/xml; charset=utf-8');
    else if ( $contentType === 'json' )
        header('Content-Type: text/javascript; charset=utf-8');

    echo ezjscAjaxContent::autoEncode( array( 'error_text' => $errorText, 'content' => '' ), $contentType );
    eZExecution::cleanExit();
}

function hasAccessToBySetting( $moduleName, $view = false, $policyAccessList = false )
{
    if ( $policyAccessList !== false )
    {
        if ( in_array( $moduleName, $policyAccessList) )
            return true;
        if ( $view && in_array( $moduleName . '/' . $view, $policyAccessList) )
            return true;
    }
    return false;
}



// look for module and view info in uri parameters
if ( !isset( $uriParams[1] ) )
{
    exitWithInternalError( "Did not find module info in url." );
    return;
}

// find module
$uri = eZURI::instance( eZSys::requestURI() );
$moduleName = $uri->element();
$module = eZModule::findModule( $moduleName );
if ( !$module instanceof eZModule )
{
    exitWithInternalError( "'$moduleName' module does not exist, or is not a valid module." );
    return;
}

// check existance of view
$viewName = $uri->element( 1 );
$moduleViews = $module->attribute('views');
if ( !isset( $moduleViews[ $viewName ] ) )
{
    exitWithInternalError( "'$viewName' view does not exist on the current module." );
    return;
}

// Check if module / view is disabled
$moduleCheck = eZModule::accessAllowed( $uri );
if ( !$moduleCheck['result'] )
{
    exitWithInternalError( '$moduleName/$viewName is disabled.' );
}


// check access to view
$ini         = eZINI::instance();
$currentUser = eZUser::currentUser();
if ( !hasAccessToBySetting( $moduleName, $viewName, $ini->variable( 'RoleSettings', 'PolicyOmitList' ) )
  && !$currentUser->hasAccessToView( $module, $viewName, $params ) )
{
    exitWithInternalError( "User does not have access to the $moduleName/$viewName policy." );
    return;
}

// run module view
$uri->increase();
$uri->increase();
$GLOBALS['eZRequestedModule'] = $module;
$moduleResult = $module->run( $viewName, $uri->elements( false ), false, $uri->userParameters() );

// ouput result and end exit cleanly
eZDB::checkTransactionCounter();
echo ezpEvent::getInstance()->filter( 'response/output', $moduleResult['content'] );
eZExecution::cleanExit();
