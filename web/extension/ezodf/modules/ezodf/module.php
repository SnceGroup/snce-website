<?php
//
// Created on: <17-Aug-2004 12:57:54 bf>
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

$Module = array( 'name' => 'eZODF',
                 'variable_params' => true );

$ViewList = array();
$ViewList['import'] = array(
    'script' => 'import.php',
    'params' => array(),
    'functions' => array( 'import' ),
    'post_actions' => array( 'BrowseActionName' ),
    'unordered_params' => array( 'node_id' => 'NodeID',
                                 'import_type' => 'ImportType' ) );

$ViewList['export'] = array(
    'script' => 'export.php',
    'params' => array(),
    'functions' => array( 'export' ),
    'post_actions' => array( 'BrowseActionName' ),
    'unordered_params' => array( 'node_id' => 'NodeID',
                                 'export_type' => 'ExportType' ) );


/*
$ViewList['upload_import'] = array(
    'script' => 'upload_import.php',
    'params' => array() );

$ViewList['authenticate'] = array(
    'script' => 'authenticate.php',
    'params' => array() );

$ViewList['upload_export'] = array(
    'script' => 'upload_export.php',
    'params' => array() );
*/

$FunctionList = array();
$FunctionList['import'] = array();
$FunctionList['export'] = array();

?>
