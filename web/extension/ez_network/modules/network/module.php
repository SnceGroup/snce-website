<?php
/**
 * Network module
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */


$Module = array( 'name' => 'Network',
                 'variable_params' => true
);

$ViewList = array();

// CLIENT (CONSUMER) //

$ViewList['oauth'] = array(
    'functions' => array( 'service_portal' ),
    'script' => 'oauth.php',
    'default_navigation_part' => 'eznetworknavigationpart',
    'params' => array( ), // Params use GET parameters instead here as oauth lib is tweaked for that
    'unordered_params' => array( ) );


$ViewList['service_portal'] = array(
    'functions' => array( 'service_portal' ),
    'script' => 'service_portal.php',
    'default_navigation_part' => 'eznetworknavigationpart',
    'params' => array( ),
    'unordered_params' => array( ) );

$ViewList['service_portal_iframe'] = array(
    'functions' => array( 'service_portal' ),
    'script' => 'service_portal_iframe.php',
    'default_navigation_part' => 'eznetworknavigationpart',
    'params' => array( ),
    'unordered_params' => array( ) );

$ViewList['install'] = array(
    'functions' => array( 'service_portal', 'install' ),
    'script' => 'install.php',
    'default_navigation_part' => 'eznetworknavigationpart',
    'params' => array( ),
    'unordered_params' => array( ) );

$FunctionList= array();
$FunctionList['service_portal'] = array();
$FunctionList['install'] = array();



?>
