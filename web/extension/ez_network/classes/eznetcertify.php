<?php
/**
 * File containing the eZNetCertify class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetCertify
 *
 * A simplified certification class, only tests some of the more important features of scripts/certify.php
 */
class eZNetCertify
{
    /**
     * @var array
     */
    public $result = array( 'action' => '', 'error' => array(), 'warning' => array() );

    /**
     * Constructor
     *
     * @param string $action
    */
    public function __construct( $action = null )
    {
        if ( !$action )
            return;

        $this->result['action'] = $action;

        if ( method_exists( $this, $action ) )
            $this->$action();
        else
            throw new Exception( 'Unsupported action: ' . $action );
    }

    /**
     * @return array
     */
    public function env()
    {
        $this->result['action'] = 'env';
        if ( ini_get( 'safe_mode' ) != 0 )
            $this->result['error']['safe_mode'] = 'PHP Safe mode is not supported!';

        if ( extension_loaded( 'suhosin' ) )
            $this->result['warning']['suhosin'] = 'PHP extension suhosin is enabled and might cause issues';

        if ( is_link( eZExtension::baseDirectory() ) )
            $this->result['warning']['symlink'] = 'Your extension directory is a symlink, this might cause issues for you when untaring new extensions to the link.';

        if ( ( @ini_set( 'memory_limit', '96M' ) ) === false  )
            $this->result['warning']['ini_set'] = 'Did not have access to set php ini variables from script using ini_set(), make sure you have memory_limit set to 512M for scripts!';

        if ( !in_array( 'curl', get_loaded_extensions() ) )
            $this->result['error']['curl'] = 'Curl needs to be installed to be able to do soap calls over ssl, see http://php.net/curl';

        $ini    = eZINI::instance( 'sync.ini' );
        $server = $ini->variable( 'NetworkSettings', 'Server' );
        $port   = (int) $ini->variable( 'NetworkSettings', 'Port' );
        if ( !$this->checkMonitorConnectionTo( $server, $port ) )
        {
            $this->result['error']['critmon'] = "Could not contact $server:$port, this is needed for all network cronjobs";
        }

        $server = eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'Server' );
        $nw = eZHTTPTool::sendHTTPRequest( $server, false, false, 'eZ Publish', false );
        if ( strpos( $nw, 'HTTP/1.1 200' ) !== 0 && strpos( $nw, 'HTTP/1.0 200' ) !== 0 )
        {
            $this->result['error']['oauth'] = "Could not contact $server, this is needed for Service Portal tab";
            $this->result['debug_oauth'] = substr( $nw, 0, 50 );
        }

        if ( !eZNetUtils::isMaster() )
        {
            $this->result['error']['cluster'] = 'eZ Network install can only be performed on master cluster server';
        }

        $db = eZDB::instance();
        $currentCharset = '';
        if ( !$db->checkCharset( 'utf-8', $currentCharset ) )
            $this->result['error']['charset'] = "Your not using uf8 charset in your database, $currentCharset is not supported.";

        if ( $db->databaseName() == 'mysql' )// Make sure MyISAM is not used on eZ Publish tables
        {
            $myISAMTables = array();
            $dbTableStatusArray = $db->arrayQuery( "SHOW TABLE STATUS;" );
            foreach ( $dbTableStatusArray as $dbTableStatus )
            {
                if ( $dbTableStatus['Engine'] == 'MyISAM' && strpos( $dbTableStatus['Name'], 'ez' ) === 0 )
                {
                    $myISAMTables[] =  $dbTableStatus['Name'];
                }
            }
            if ( $myISAMTables )
                $this->result['error']['db_engine'] = "Detected MyISAM table type on ez database table(s): " . implode( ', ', $myISAMTables );
        }
        return $this->result;
    }

    /**
     * @return array
     */
    public function md5()
    {
        $this->result['action'] = 'md5';
        if ( !defined( 'eZMD5::CHECK_SUM_LIST_FILE' ) )
        {
            $this->result['error']['md5'] = 'This web installer requires eZ Publish 4.4 or higher!';
        }
        elseif ( !file_exists( eZMD5::CHECK_SUM_LIST_FILE ) )
        {
            $this->result['error']['md5'] = 'Could not read your md5 file(' . eZMD5::CHECK_SUM_LIST_FILE . '), running from svn/git is not supported!';
        }
        else
        {
            $checkResult = eZMD5::checkMD5Sums( eZMD5::CHECK_SUM_LIST_FILE );
            $extensionsDir = eZExtension::baseDirectory();
            foreach( eZextension::activeExtensions() as $activeExtension )
            {
                $extensionPath = "$extensionsDir/$activeExtension/";
                if ( file_exists( $extensionPath . eZMD5::CHECK_SUM_LIST_FILE ) )
                {
                    $checkResult = array_merge( $checkResult, eZMD5::checkMD5Sums( $extensionPath . eZMD5::CHECK_SUM_LIST_FILE, $extensionPath ) );
                }
            }

            if ( count( $checkResult ) !== 0 )
            {
                $this->result['warning']['md5'] = count( $checkResult ) . ' files did not pass the md5 checksum test, '
                                                . 'use "Setup/Upgrade check" in admin gui to see details!';
            }
        }
        return $this->result;
    }

    /**
     * For testing soap connections
     *
     * @param string $host
     * @param int $port
     * @return bool
     */
    protected function checkMonitorConnectionTo( $host, $port )
    {
        $client   = new eZSOAPClient( $host, '/', $port );
        $request  = new eZSOAPRequest( 'certifyTest', 'ez.no', array() );
        $this->resultponse = $client->send( $request );
        if ( !$this->resultponse || $this->resultponse->faultString() !== 'Method not found' )
        {
            return false;
        }
        return true;
    }
}

?>
