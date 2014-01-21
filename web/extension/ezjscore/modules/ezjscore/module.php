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

$Module = array( 'name' => 'ezjsc Module and Views' );


$ViewList = array();

$ViewList['hello'] = array(
    'script' => 'hello.php',
    'params' => array( 'with_pagelayout' )
    );
    
$ViewList['call'] = array(
    'functions' => array( 'call' ),
    'script' => 'call.php',
    'params' => array( 'function_arguments', 'type', 'interval', 'debug' )
    );

$ViewList['run'] = array(
    'functions' => array( 'run' ),
    'script' => 'run.php',
    'params' => array( )
    );



$ezjscServerFunctionList = array(
    'name'=> 'FunctionList',
    'values'=> array()
    );

$iniFunctionList = eZINI::instance('ezjscore.ini')->variable( 'ezjscServer', 'FunctionList' );
foreach ( $iniFunctionList as $iniFunction )
{
    $ezjscServerFunctionList['values'][] = array(
               'Name' => $iniFunction,
               'value' => $iniFunction
    );
} 

$FunctionList = array();
$FunctionList['run'] = array();
$FunctionList['call'] = array( 'FunctionList' => $ezjscServerFunctionList );


?>
