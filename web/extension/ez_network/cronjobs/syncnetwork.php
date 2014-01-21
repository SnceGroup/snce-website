<?php
/**
 * File containing the syncnetwork cronjob
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

@ini_set( 'memory_limit', '512M' );
$GLOBALS['eZDebugEnabled'] = false;

require 'extension/ez_network/classes/include_all.php';

if ( !$isQuiet )
{
    $cli->output( 'Starting eZ Network syncronization.' . "\n" .
                  'Use the --clear-all to reset client side data.' );
}

$clearAll = false;
foreach( $GLOBALS['argv'] as $argument )
{
    if ( $argument === '--clear-all' )
    {
        $clearAll = true;
    }
}

// Make sure network extensions is up to date.
$clientInfo = eZNetClientInfo::instance();
if ( !$clientInfo->validate() )
{
    $cli->output( 'eZNetwork version check did not validate. Usually happens if db upgrade fails, exiting!' );
    return;
}

if ( $clearAll )
{
    $cli->output( 'Clearing existing data.' );
    $clientInfo->clearDB();
}

$classList = array( 'eZNetBranch',
                    'eZNetPatch',
                    'eZNetPatchItem',
                    'eZNetInstallation',
                    'eZNetModuleInstallation',
                    'eZNetModuleBranch',
                    'eZNetModulePatch',
                    'eZNetModulePatchItem',
                    'eZNetMonitorItem',
                    'eZNetMonitorGroup' );

$syncINI = eZINI::instance( 'sync.ini' );
$Server = $syncINI->variable( 'NetworkSettings', 'Server' );
$Port = $syncINI->variable( 'NetworkSettings', 'Port' );
$Path = $syncINI->variable( 'NetworkSettings', 'Path' );
$Timeout = $syncINI->variable( 'NetworkSettings', 'Timeout' );

// If use of SSL fails the client must attempt to use HTTP
$Port = eZNetSOAPSync::getPort( $Server, $Path, $Port );

$client = new eZSOAPClient( $Server, $Path, $Port );
$client->setTimeout( $Timeout );

$networkInfo = eZNetUtils::extensionInfo( 'ez_network' );
$cli->output( $networkInfo['name'] . ' client ' . $networkInfo['version'] );
$cli->output( '' );

// Initialize Soap sync manager, and start syncronization.
$syncManager = new eZNetSOAPSyncManager( $client,
                                         $classList,
                                         $cli );
$syncManager->syncronizeClient();

/* Check existence of eZNetInstallation object in current DB.
 * If the first synchronizing was not successful then eZNetIntsllation doesn't exist.
 * We should notify the user about that.
 * NOTE: Failed synchronizing can be caused through incorrect installation key.
 */

// If eZNetInstallation should not be synchronized We should not check the existence.
if ( !in_array( 'eZNetInstallation', $classList ) )
    return;

$hostID = eZNetSOAPSync::hostID();
$installation = eZNetInstallation::fetchBySiteID( $hostID );
if ( !$installation )
{
    $cli->output( "\n".
                  'eZNetInstallation object with the installation key (' . $hostID . ') was not found in the database.' . "\n" .
                  'Make sure the installation key is correct and has been sent to eZ Systems' . "\n" .
                  'or contact your system administrator.' );
}


?>
