<?php
/**
 * File containing the eZNetMonitor class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

/**
 *
 * @deprecated Is not used anymore
 *
 */

class eZNetMonitor extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZNetMonitor( $rows = array() )
    {
        $this->eZPersistentObject( $rows );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "timestamp" => array( 'name' => 'Timestamp',
                                                         'datatype' => 'integer',
                                                         'default' => 0,
                                                         'required' => true ),
                                         "text" => array( 'name' => 'Text',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                         "started" => array( 'name' => 'Started',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         "finnished" => array( 'name' => 'Finnished',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ),
                                         'synced' => array( 'name' => 'Synced',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array(),
                      "increment_key" => "id",
                      "class_name" => "eZNetMonitor",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_monitor" );
    }

    /*!
     Create new monitor object
    */
    public static function create()
    {
        return new eZNetMonitor( array( 'timestamp' => time() ) );
    }

    /*!
     Run and store monitor.

     \param CLI object ( optional )
    */
    function run( $cli = false )
    {
        $this->setAttribute( 'started', time() );

        $this->DomDocument = new eZDomDocument();
        $this->DomDocument->setName( 'Monitor report' );
        $this->XMLRoot = $this->DomDocument->createElementNode( 'MonitorReport' );
        $this->DomDocument->setRoot( $this->XMLRoot );

        $ini = eZINI::instance( 'network.ini' );
        foreach( $ini->variable( 'MonitorSettings', 'FunctionList' ) as $function )
        {
            $functionResult = serialize( $this->$function() );
            if ( $cli )
            {
                $cli->output( 'Monitor test starting  : ' . $function );
            }
            $this->XMLRoot->appendChild( $this->DomDocument->createElementTextNode( $function,
                                                                                    $functionResult,
                                                                                    array( 'timestamp' => time() ) ) );
            if ( $cli )
            {
                $cli->output( 'Monitor test finished : ' . $function );
            }
        }

        $this->setAttribute( 'text', $this->DomDocument->toString() );
        $this->setAttribute( 'finnished', time() );

        $this->store();
    }

    /*!
     Return Role setup log
     // TODO
    */
    function eZRoleLog()
    {
        $originalRoleDefinition = eZNetStorage::get( eZNetUtils::ROLE_KEY );
        $currentRoleDefinition = eZNetUtils::getRoleIDList();
        return eZNetUtils::arrayDiffRecursive( $originalRoleDefinition, $currentRoleDefinition );
    }

    /*!
     Add Content object log  //TODO - add, remove, count

    */
    function eZObjectLog()
    {
        $objectCountSQL = 'SELECT COUNT( id ) as count FROM ezcontentobject AND is_published=\'1\'';

        $db = eZDb::instance();
        $resArray = $db->arrayQuery( $objectCountSQL );
        if ( !empty( $resArray ) )
        {
            $maxObjectCount = $resArray[0]['count'];
        }

        $originalCreationCount = eZNetStorage::get( eZNetUtils::OBJECT_CREATION_COUNT );
        $currentCreationCount = eZNetUtils::objectsCreated();

        return array( 'object_count' => $maxObjectCount,
                      'creation_count' => $currentCreationCount - $originalCreationCount );
    }

    function eZFilePermissions()
    {
        return ''; // TODO
    }

    /*!
     Check eZ Publish settings

     \return serialized string with all setting files and change timestamps.
    */
    function eZSettings()
    {
        if ( !method_exists('eZSiteAccess','change') )// since 4.4
            include_once( 'access.php' );
        $ini = eZINI::instance();

        $currentAccess = $GLOBALS['eZCurrentAccess']['name'];
        $availableSiteAccesses = $ini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' );

        $iniFileNameList = eZNetUtils::iniFileNameList();

        $originalSettings = eZNetStorage::get( eZNetUtils::SETTINGS_KEY );

        $detectedFileArray = array();
        $removedSettingsArray = array();
        $newSettingArray = array();
        $changedSettingArray = array();

        foreach( $availableSiteAccesses as $siteAccess )
        {
            $GLOBALS['eZCurrentAccess']['name'] = $siteAccess;
            if ( method_exists('eZSiteAccess','change') )// since 4.4
                eZSiteAccess::change( array( 'name' => $siteAccess ) );
            else
                changeAccess( array( 'name' => $siteAccess ) );

            foreach( $iniFileNameList as $iniFile )
            {
                $file = '';
                $ini = eZINI::instance( $iniFile );
                $ini->findInputFiles( $inputFiles, $file );

                foreach( $inputFiles as $inputFile )
                {
                    $fileDescription = array( 'Filename' => $inputFile,
                                              'IniFile' => $iniFile,
                                              'SiteAccess' => $siteAccess,
                                              'StoredTimestamp' => filemtime( $inputFile ) );

                    $storedFile = eZNetStorage::get( array( 'Filename' => $inputFile ),
                                                     array( 'SiteAccess' => $siteAccess ) );

                    if ( !$storedFile )
                    {
                        $newSettingArray[] = $fileDescription;
                        eZNetUtils::addSettingsFile( $inputFile, $siteAccess );
                        $originalSettings[$siteAccess][$iniFile][$inputFile] = filemtime( $inputFile );
                    }
                    else
                    {
                        if ( md5_file( $inputFile ) != $storedFile['MD5'] )
                        {
                            $changedSettingArray[] = $fileDescription;
                        }
                    }
                    $detectedFileArray[] = $fileDescription;
                }
            }
        }

        eZNetStorage::set( eZNetUtils::SETTINGS_KEY, $originalSettings, eZNetUtils::nodeID() );

        foreach( $detectedFileArray as $fileDescription )
        {
            if ( isset( $originalSettings[$fileDescription['SiteAccess']][$fileDescription['IniFile']][$fileDescription['Filename']] ) )
            {
                unset( $originalSettings[$fileDescription['SiteAccess']][$fileDescription['IniFile']][$fileDescription['Filename']] );
            }
        }

        foreach( $originalSettings as $siteAccess => $siteAccessSettings )
        {
            foreach( $siteAccessSettings as $iniFile => $iniFileSettings )
            {
                foreach( $iniFileSettings as $filename => $timestamp )
                {
                    $fileDescription = array( 'Filename' => $filename,
                                              'IniFile' => $iniFile,
                                              'SiteAccess' => $siteAccess,
                                              'StoredTimestamp' => $timestamp );
                    $removedSettingsArray[] = $fileDescription;
                }
            }
        }

        return array( 'Added' => $newSettingArray,
                      'Changed' => $changedSettingArray,
                      'Removed' => $removedSettingsArray );
    }

    /*!
     Check eZ Publish core file status // TODO - update list for patched files.

     \return empty array if list OK, serialized string of filenames if not.
    */
    function eZCoreFiles()
    {
        return eZNetUtils::checkMD5Sums();
    }

    /*!
     Get number of object created since start.

     \get objects created
    */
    function objectsCreated()
    {
    }

    // Dom Document
    var $DomDocument = false;
    var $XMLRoot = false;
}

?>
