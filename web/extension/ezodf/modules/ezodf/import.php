<?php
//
// Created on: <17-Aug-2004 12:58:56 bf>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: eZ Publish
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

function makeErrorArray( $num, $msg )
{
    return array( 'number' => $num, 'message' => $msg );
}

$http = eZHTTPTool::instance();
$module = $Params["Module"];
$NodeID = $Params['NodeID'];
$ImportType = $Params['ImportType'];

$tpl = eZTemplate::factory();

$tpl->setVariable( 'error', false );
$tpl->setVariable( 'import_type', 'import' );

$doImport = false;
$replaceObject = false;
// Check if we should create a new document as a child of the selected or
// replace it creating a new version
if ( $http->hasPostVariable( "ImportType" ) )
{
    $type = $http->postVariable( "ImportType" );
    if ( $type == "replace" )
    {
        $replaceObject = true;
    }
}

// Check import type in GET variables
if ( $ImportType == "replace" )
{
    $replaceObject = true;
}

if ( $http->hasPostVariable( "NodeID" ) or is_numeric( $NodeID ) )
{
    if ( is_numeric( $NodeID ) )
        $nodeID = $NodeID;
    else
        $nodeID = $http->postVariable( "NodeID" );

    $doImport = true;
    $node = eZContentObjectTreeNode::fetch( $nodeID );

    if ( $replaceObject == true )
    {
        $tpl->setVariable( 'import_type', "replace" );
        $http->setSessionVariable( 'oo_import_type', 'replace' );
    }
    else
    {
        $http->setSessionVariable( 'oo_import_type', 'import' );
    }

    $tpl->setVariable( 'import_node', $node );
    $http->setSessionVariable( 'oo_direct_import_node', $nodeID );
}

if ( $http->hasPostVariable( 'Locale' ) )
{
    $http->setSessionVariable(
        'oo_import_locale', $http->postVariable( 'Locale' )
    );
}

if ( $module->isCurrentAction( 'OOPlace' ) )
{
    // We have the file and the placement. Do the actual import.
    $selectedNodeIDArray = eZContentBrowse::result( 'OOPlace' );

    $nodeID = $selectedNodeIDArray[0];

    if ( is_numeric( $nodeID ) )
    {
        $fileName = $http->sessionVariable( "oo_import_filename" );
        if ( file_exists( $fileName ) )
        {
            $import = new eZOOImport();
            $result = $import->import(
                $http->sessionVariable( "oo_import_filename" ),
                $nodeID,
                $http->sessionVariable( "oo_import_original_filename" ),
                "import",
                null,
                $http->sessionVariable( 'oo_import_locale' )
            );
            // Cleanup of uploaded file
            //unlink( $http->sessionVariable( "oo_import_filename" ) );


            if( $result )
            {
                $tpl->setVariable( 'class_identifier', $result['ClassIdentifier'] );
                $tpl->setVariable( 'url_alias', $result['URLAlias'] );
                $tpl->setVariable( 'node_name', $result['NodeName'] );
                $tpl->setVariable( 'oo_mode', 'imported' );
            }
            else
            {
                if( $import->getErrorNumber() != 0 )
                {
                    $tpl->setVariable( 'error', makeErrorArray( $import->getErrorNumber(), $import->getErrorMessage() ) );
                }
                else
                {
                    $tpl->setVariable( 'error', makeErrorArray( eZOOImport::ERROR_DOCNOTSUPPORTED,
                                                                ezpI18n::tr( 'extension/ezodf/import/error', "Document is not supported." ) ) );
                }

            }
            $http->removeSessionVariable( 'oo_import_step' );
            $http->removeSessionVariable( 'oo_import_filename' );
            $http->removeSessionVariable( 'oo_import_original_filename' );
            $http->removeSessionVariable( 'oo_import_locale' );
        }
        else
        {
            eZDebug::writeError( "Cannot import. File not found. Already imported?" );
            $tpl->setVariable( 'error', makeErrorArray( eZOOImport::ERROR_FILENOTFOUND,
                                                        ezpI18n::tr( 'extension/ezodf/import/error', "Cannot import. File not found. Already imported?" ) ) );
        }
    }
    else
    {
        eZDebug::writeError( "Cannot import document, supplied placement nodeID is not valid." );
        $tpl->setVariable( 'error', makeErrorArray( eZOOImport::ERROR_PLACEMENTINVALID,
                                                    ezpI18n::tr( 'extension/ezodf/import/error', "Cannot import document, supplied placement nodeID is not valid." ) ) );
    }

//    $tpl->setVariable( 'oo_mode', 'imported' );
}
else
{
    $tpl->setVariable( 'oo_mode', 'browse' );

    if( eZHTTPFile::canFetch( "oo_file" ) )
    {
        $file = eZHTTPFile::fetch( "oo_file" );

        if ( $file )
        {
            if ( $file->store() )
            {
                $fileName = $file->attribute( 'filename' );

                $originalFileName = $file->attribute( 'original_filename' );

                // If we have the NodeID do the import/replace directly
                if (  $http->sessionVariable( 'oo_direct_import_node' )  )
                {
                    $nodeID = $http->sessionVariable( 'oo_direct_import_node' );
                    $importType = $http->sessionVariable( 'oo_import_type' );
                    if ( $importType != "replace" )
                        $importType = "import";
                    $import = new eZOOImport();
                    $result = $import->import(
                        $fileName, $nodeID, $originalFileName,
                        $importType, null,
                        $http->sessionVariable( 'oo_import_locale' )
                    );
                    // Cleanup of uploaded file
                    unlink( $fileName );

                    if ( $result )
                    {
                        $tpl->setVariable( 'class_identifier', $result['ClassIdentifier'] );
                        $tpl->setVariable( 'url_alias', $result['URLAlias'] );
                        $tpl->setVariable( 'node_name', $result['NodeName'] );
                        $tpl->setVariable( 'published', $result['Published'] );
                        $tpl->setVariable( 'oo_mode', 'imported' );
                    }
                    else
                    {
                        if( $import->getErrorNumber() != 0 )
                        {
                            $tpl->setVariable( 'error', makeErrorArray( $import->getErrorNumber(), $import->getErrorMessage() ) );
                        }
                        else
                        {
                            $tpl->setVariable( 'error', makeErrorArray( eZOOImport::ERROR_DOCNOTSUPPORTED,
                                                                        ezpI18n::tr( 'extension/ezodf/import/error',"Document is not supported." ) ) );
                        }
                    }
                    $http->removeSessionVariable( 'oo_direct_import_node' );
                    $http->removeSessionVariable( 'oo_import_locale' );
                }
                else
                {
                    // Make the user browser for document placement
                    $http->setSessionVariable( 'oo_import_step', 'browse' );
                    $http->setSessionVariable( 'oo_import_filename', $fileName );
                    $http->setSessionVariable( 'oo_import_original_filename', $originalFileName );

                    eZContentBrowse::browse( array( 'action_name' => 'OOPlace',
                                                    'description_template' => 'design:ezodf/browse_place.tpl',
                                                    'content' => array(),
                                                    'from_page' => '/ezodf/import/',
                                                    'cancel_page' => '/ezodf/import/' ),
                                             $module );
                    return;
                }
            }
            else
            {
                eZDebug::writeError( "Cannot store uploaded file, cannot import" );
                $tpl->setVariable( 'error', makeErrorArray( eZOOImport::ERROR_CANNOTSTORE,
                                                            ezpI18n::tr( 'extension/ezodf/import/error',"Cannot store uploaded file, cannot import." ) ) );
            }
        }
    }
}



$Result = array();
$Result['content'] = $tpl->fetch( "design:ezodf/import.tpl" );
$Result['path'] = array( array( 'url' => '/ezodf/import/',
                                'text' => ezpI18n::tr( 'extension/ezodf', 'OpenOffice.org import' ) ));



?>
