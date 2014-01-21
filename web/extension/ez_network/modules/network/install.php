<?php
/**
 * install/ View
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

$db                  = eZDB::instance();
$tpl                 = eZTemplate::factory();
$http                = eZHTTPTool::instance();

// look for ajax actions
if ( $http->hasPostVariable( 'doAction' ) )
{
    $res = array( 'action' => $http->postVariable( 'doAction' ), 'error' => array(), 'warning' => array() );
    switch ( $res['action'] )
    {
    case 'env'://sanity
        $certify = new eZNetCertify();
        $res = $certify->env();
    break;
    case 'md5'://sanity
        $certify = new eZNetCertify();
        $res = $certify->md5();
    break;
    case 'install':
        // Check key
        $key = $http->postVariable( 'nwKey' );
        if ( $key === '' || trim($key) == '' )
        {
            $res['error']['key'] = 'Network key was not present in the install action, it\'s needed for the installation!';
            break;
        }
        elseif ( !isset( $key[31] ) )
        {
            $res['error']['key'] = 'Network key was too short to possibly be valid!';
            break;
        }

        // Check schema file
        $schemaFilePath = eZExtension::baseDirectory() . '/'
                    . eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'ExtensionPath' )
                    . '/share/db_schema.dba';

        $dbContents = eZDbSchema::read( $schemaFilePath, true );
        if ( $dbContents === false || !isset( $dbContents['schema'] ) )
        {
            $res['error']['schema'] = 'Could not read schema information from:' . $schemaFilePath;
            break;
        }

        // Install key
        $db->query( "DELETE FROM ezsite_data WHERE name='ezpublish_site_id'" );
        $db->query( "INSERT INTO ezsite_data ( name, value ) values ( 'ezpublish_site_id', '" . $db->escapeString( $key ) . "' )" );

        eZNetUtils::createTable( $dbContents['schema'] );
    break;
    case 'snapshoot':// post install
        // Store all ini files to DB, and create timestamp log.
        $timestampArray = array();
        $iniFileNameList = eZNetUtils::iniFileNameList();
        $availableSiteAccesses = eZINI::instance()->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' );
        foreach( $availableSiteAccesses as $siteAccess )
        {
            $timestampArray[$siteAccess] = array();

            foreach( $iniFileNameList as $iniFile )
            {
                $timestampArray[$siteAccess][$iniFile] = array();
                $file = '';
                $ini = eZSiteAccess::getIni( $siteAccess, $iniFile );
                $ini->findInputFiles( $inputFiles, $file );

                foreach( $inputFiles as $inputFile )
                {
                    eZNetUtils::addSettingsFile( $inputFile, $siteAccess );
                    $timestampArray[$siteAccess][$iniFile][$inputFile] = filemtime( $inputFile );
                }
            }
        }
        eZNetStorage::set( eZNetUtils::SETTINGS_KEY, $timestampArray, eZNetUtils::nodeID() );

        // Store role setup
        $roleArray = eZNetUtils::getRoleIDList();
        eZNetStorage::set( eZNetUtils::ROLE_KEY, $roleArray );

        // Store md5 Sums using the net utils caclulation method.
        $fileList = file_exists( eZMD5::CHECK_SUM_LIST_FILE ) ? file_get_contents( eZMD5::CHECK_SUM_LIST_FILE ) : "";
        $fileList = explode( "\n", $fileList );
        $totalCount = count( $fileList );
        foreach( $fileList as $count => $line )
        {
            if ( strlen( $line ) )
            {
                list( $oldMD5, $tmp, $filename ) = explode( " ", $line );
                eZNetUtils::setFileMD5( $filename );
            }
        }

        // Set client version
        $clientInfo = eZNetClientInfo::instance();
        $clientInfo->updateVersion();
    break;
    case 'sync':// post install
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

        $fakeCLI = new eznetWebInstallFakeCLI();
        $syncINI = eZINI::instance( 'sync.ini' );
        $Server  = $syncINI->variable( 'NetworkSettings', 'Server' );
        $Path    = $syncINI->variable( 'NetworkSettings', 'Path' );
        $Port    = eZNetSOAPSync::getPort( $Server, $Path, $syncINI->variable( 'NetworkSettings', 'Port' ) );
        $syncManager = new eZNetSOAPSyncManager( new eZSOAPClient( $Server, $Path, $Port ),
                                                 $classList,
                                                 $fakeCLI );
        $syncManager->syncronizeClient();

        /*if ( isset( $fakeCLI->data['output'][0] ) )
            $res['warning']['output'] = "eZNetSOAPSyncManager output: \"" . implode( '", "', $fakeCLI->data['output'] ) . '"';*/

        if ( isset( $fakeCLI->data['error'][0] ) )
        {
            $res['error']['sync'] = "Installation went ok, but eZNetSOAPSyncManager reported issues: \"" . implode( '", "', $fakeCLI->data['error'] ) . '"';
        }
        elseif ( in_array( 'eZNetInstallation', $classList ) )
        {
            $hostID = eZNetSOAPSync::hostID();
            if ( !eZNetInstallation::fetchBySiteID( $hostID ) )
            {
                $res['warning']['object'] = 'eZNetInstallation object with the installation key (' . $hostID . ') was not found in the database.' . "\n" .
                  'Make sure the installation key is correct and has been sent to eZ Systems' . "\n" .
                  'or contact your system administrator.';
            }
        }

    break;
    default:
        $res['error']['action'] = "Unsupported action: $res[action]";
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode( $res );
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}


$hasDBTables = in_array( 'ezx_oauth_client_consumer_user', $db->relationList() );
$nwKeyList   = $db->arrayQuery( "SELECT value FROM ezsite_data WHERE name='ezpublish_site_id'" );

if ( $hasDBTables && $nwKeyList )
{
    return $Module->redirectTo( "network/service_portal" );
}

$Result = array();

$tpl->setVariable( 'has_nw_oauth_table', $hasDBTables );
$tpl->setVariable( 'nw_key_list', $nwKeyList );
$tpl->setVariable( 'rnd_minute',  mt_rand(3, 40) );
$tpl->setVariable( 'rnd_hour',    mt_rand(2, 6) );
$tpl->setVariable( 'root_dir',    eZSys::rootDir() );

$Result['content'] = $tpl->fetch( "design:network/install.tpl" );// setup
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Network' ),
                                'url' => false ),
                         array( 'text' => ezpI18n::tr( 'kernel/content', 'Install' ),
                                'url' => false ) );

$Result['content_info'] = array('persistent_variable' => array( 'extra_menu' => false,
                                                                'left_menu'  => false ));

/**
 * A fake CLI class that catches calls to all functions and stores calls to error and output
 */
class eznetWebInstallFakeCLI
{
    public $data = array('error' => array(), 'output' => array());
    public function __call( $name, $arguments )
    {
        if ( isset( $this->data[$name] ) )
            $this->data[$name][] = $arguments[0];
    }
}



?>
