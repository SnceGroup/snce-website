<?php
/**
 * File containing eZNetScriptEvent class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetScriptEvent eznetscriptevent.php
  \brief The class eZNetScriptEvent does

  How the status field works:

  When a new script event is reported, the status is set to New.
  When the conrjobs for creating issue, sending SMS and/or mail is run, the status
  is set to pending for the first eZNetScriptEvent matching the :
  Installation, Server, ServerIP, Monitor identifier and Threshold.

  The system will only create new Issue and send SMS as long as there are no
  eZNetScriptEvent object matching the criterias above pending.

  To reset the pending eZNetScriptEvent, use the webGUI on <TODO>. This will enable
  the system to send SMS and create issues again.

  Emails will be sent every time a new eZNetScriptEvent is reported.

*/
include_once( 'kernel/common/i18n.php' );

class eZNetScriptEvent extends eZPersistentObject
{
    /// Consts
    const StatusNew = 0;
    const StatusPending = 1;
    const StatusClosed = 2;
    const StatusFailed = 3;

    const ServerTypeDatabase = 'database';
    const ServerTypeWeb = 'web';
    const ServerTypeProxy = 'proxy';
    const ServerTypeDiretor = 'director';

    const ThresholdWarning = 'warning';
    const ThresholdCritical = 'critical';

    const MonitorIdentifierDiskSpace = 'diskspace';
    const MonitorIdentifierDiskIO = 'diskio';
    const MonitorIdentifierPhysMem = 'physicalmemory';
    const MonitorIdentifierVirtMem = 'virtualmemory';
    const MonitorIdentifierNetwork = 'network';
    const MonitorIdentifierCPULoad = 'cpuload';

    /*!
     Constructor
    */
    function eZNetScriptEvent( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    /*!
     \reimp
    */
    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'options' => array( 'name' => 'Options',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'installation_hash' => array( 'name' => 'InstallationHash',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ),
                                         'server' => array( 'name' => 'Server',
                                                            'datatype' => 'string',
                                                            'default' => '',
                                                            'required' => true ),
                                         'server_ip' => array( 'name' => 'ServerIP',
                                                               'datatype' => 'string',
                                                               'default' => '',
                                                               'required' => true ),
                                         'monitor_ident' => array( 'name' => 'MonitorIndentifier',
                                                                   'datatype' => 'string',
                                                                   'default' => '',
                                                                   'required' => true ),
                                         'threshold' => array( 'name' => 'Threshold',
                                                               'datatype' => 'string',
                                                               'default' => '',
                                                               'required' => true ),

                                         ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'option_array' => 'optionArray',
                                                      'installation' => 'installation' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetScriptEvent",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_script_event" );
    }

    /*!
     \static
     Fetch count by status

     \param status ( eZNetScriptEvent::StatusNew, eZNetScriptEvent::StatusPending or eZNetScriptEvent::StatusClosed )

     \return count
    */
    static function fetchCountByStatus( $status = eZNetScriptEvent::StatusNew )
    {
        $resultSet = eZNetScriptEvent::fetchObjectList( eZNetScriptEvent::definition(),
                                                        array(),
                                                        array( 'status' => $status ),
                                                        null,
                                                        null,
                                                        false,
                                                        false,
                                                        array( array( 'operation' => 'count(id)',
                                                                      'name' => 'count' ) ) );
        return $resultSet[0]['count'];
    }

    /*!
     \static
     Fetch count by installation key and status

     \param installation key
     \param status ( eZNetScriptEvent::StatusNew, eZNetScriptEvent::StatusPending or eZNetScriptEvent::StatusClosed )

     \return count
    */
    static function countByInstallationKey( $installationKey,
                                            $status = eZNetScriptEvent::StatusNew )
    {
        $resultSet = eZNetScriptEvent::fetchObjectList( eZNetScriptEvent::definition(),
                                                        array(),
                                                        array( 'installation_hash' => $installationKey,
                                                               'status' => $status ),
                                                        null,
                                                        null,
                                                        false,
                                                        false,
                                                        array( array( 'operation' => 'count(id)',
                                                                      'name' => 'count' ) ) );
        return $resultSet[0]['count'];

    }

    /*!
     \static
     Fetch list by istallation key and status.

     \param installation key
     \param status ( eZNetScriptEvent::StatusNew, eZNetScriptEvent::StatusPending or eZNetScriptEvent::StatusClosed )
     \param offset
     \param limit
     \param $asObject

     \return eZNetScriptEvent list
    */
    static function fetchListByInstallationKey( $installationKey,
                                                $status = eZNetScriptEvent::StatusNew,
                                                $offset = 0,
                                                $limit = 10,
                                                $asObject = true )
    {
        return eZNetScriptEvent::fetchObjectList( eZNetScriptEvent::definition(),
                                                  null,
                                                  array( 'installation_hash' => $installationKey,
                                                         'status' => $status ),
                                                  null,
                                                  array( 'limit' => $limit,
                                                         'offset' => $offset ),
                                                  $asObject );
    }

    /*!
     \static
     Fetch list by status

     \param status ( eZNetScriptEvent::StatusNew, eZNetScriptEvent::StatusPending or eZNetScriptEvent::StatusClosed )
     \param offset
     \param limit
     \param $asObject

     \return script event array.
    */
    static function fetchListByStatus( $status = eZNetScriptEvent::StatusNew,
                                       $offset = 0,
                                       $limit = 10,
                                       $asObject = true )
    {
        return eZNetScriptEvent::fetchObjectList( eZNetScriptEvent::definition(),
                                                  null,
                                                  array( 'status' => $status ),
                                                  null,
                                                  array( 'limit' => $limit,
                                                         'offset' => $offset ),
                                                  $asObject );
    }

    /*!
     \static
     Add event.

    This function checks if the event is already registered. If it's registered,
    update the entry. If it does not exist, create a new entry.

    \param Installation name
    \param Server
    \param ServerIP
    \param monitor identifier
    \param Threshold
    \param ServerType
    \param Monitor value
    \param Monitor description
    */
    static function addEvent( $installation,
                              $server,
                              $serverIP,
                              $monitorIdentifier,
                              $threshold,
                              $serverType,
                              $monitorValue,
                              $monitorDescription )
    {
        $existingObject = eZNetScriptEvent::fetchByValues( $installation,
                                                           $server,
                                                           $serverIP,
                                                           $monitorIdentifier,
                                                           $threshold,
                                                           eZNetScriptEvent::StatusNew );
        if ( $existingObject )
        {
            $existingObject->setAttribute( 'modified', time() );
            $existingObject->sync();
        }
        else
        {
            $scriptEvent = eZNetScriptEvent::create( $installation,
                                                     $server,
                                                     $serverIP,
                                                     $monitorIdentifier,
                                                     $threshold,
                                                     $serverType,
                                                     $monitorValue,
                                                     $monitorDescription );
            $scriptEvent->store();
        }
    }

    /*!
     Check if pending script event exists
    */
    function pendingExists()
    {
        return eZNetScriptEvent::fetchByValues( $this->attribute( 'installation_hash' ),
                                                $this->attribute( 'server' ),
                                                $this->attribute( 'server_ip' ),
                                                $this->attribute( 'monitor_ident' ),
                                                $this->attribute( 'threshold' ),
                                                eZNetScriptEvent::StatusPending ) ?
            true:
            false;
    }

    /*!
     Fetch eZNetScriptEvent by values.

     \param Installation
     \param Server
     \param ServerIP
     \param Monitor identifier
     \param Threshold
     \param Status ( optional )
     \param asObject ( optional )

     \return eZNetScriptEvent if exists
    */
    static function fetchByValues( $installation,
                                   $server,
                                   $serverIP,
                                   $monitorIdentifier,
                                   $threshold,
                                   $status = eZNetScriptEvent::StatusNew,
                                   $asObject = true )
    {
        return eZNetScriptEvent::fetchObject( eZNetScriptEvent::definition(),
                                              null,
                                              array( 'installation_hash' => $installation,
                                                     'server' => $server,
                                                     'server_ip' => $serverIP,
                                                     'monitor_ident' => $monitorIdentifier,
                                                     'threshold' => $threshold,
                                                     'status' => $status ),
                                              $asObject );
    }

    /*!
     \static
     Fetch by ID

     \param ID
     \param status ( optional )
     \param $asObject ( optional )

     \return eZNetScriptEvent
    */
    static function fetch( $id,
                           $status = false,
                           $asObject = true )
    {
        $condArray = array( 'id' => $id );
        if ( $status !== false )
        {
            $condArray['status'] = $status;
        }
        return eZNetScriptEvent::fetchObject( eZNetScriptEvent::definition(),
                                              null,
                                              $condArray,
                                              $asObject );
    }

    /*!
     \static

     Create new eZNetScriptEvent

    \param Installation name
    \param Server
    \param ServerIP
    \param monitor identifier
    \param Threshold
    \param ServerType
    \param Monitor value
    \param Monitor description

    \return new event
    */
    static function create( $installation,
                            $server,
                            $serverIP,
                            $monitorIdentifier,
                            $threshold,
                            $serverType,
                            $monitorValue,
                            $monitorDescription )
    {
        $scriptEvent = new eZNetScriptEvent( array( 'installation_hash' => $installation,
                                                    'server' => $server,
                                                    'server_ip' => $serverIP,
                                                    'monitor_ident' => $monitorIdentifier,
                                                    'threshold' => $threshold,
                                                    'status' => eZNetScriptEvent::StatusNew,
                                                    'created' => time(),
                                                    'modified' => time() ) );
        $scriptEvent->setOption( 'server_type', $serverType );
        $scriptEvent->setOption( 'monitor_value', $monitorValue );
        $scriptEvent->setOption( 'monitor_description', $monitorDescription );

        return $scriptEvent;
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'installation':
            {
                $retVal = eZNetInstallation::fetchBySiteID( $this->attribute( 'installation_hash' ) );
            } break;

            case 'option_array':
            {
                $optionDef = $this->attribute( 'options' );
                $retVal = $optionDef == '' ? array() : unserialize( $optionDef );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     Set option

     \param option name
     \param option value
    */
    function setOption( $attr, $value )
    {
        $optionArray = $this->attribute( 'option_array' );
        $optionArray[$attr] = $value;
        $this->setAttribute( 'options', serialize( $optionArray ) );
    }

    /*!
     Check if option is set.

     \param option name
    */
    function hasOption( $attr )
    {
        $optionArray = $this->attribute( 'option_array' );
        return isset( $optionArray[$attr] );
    }

    /*
     Get option

     \param option name

     \return option value
    */
    function option( $attr )
    {
        $optionArray = $this->attribute( 'option_array' );
        return isset( $optionArray[$attr] ) ? $optionArray[$attr] : false;
    }

    /*!
     \static

     Get server type array

     \return server type array
     */
    static function serverTypeArray()
    {
        return array( eZNetScriptEvent::ServerTypeDatabase,
                      eZNetScriptEvent::ServerTypeWeb,
                      eZNetScriptEvent::ServerTypeProxy,
                      eZNetScriptEvent::ServerTypeDiretor );
    }

    /*!
     \static

     Get Trhreshold array

     \return threshold array
    */
    static function thresholdArray()
    {
        return array( eZNetScriptEvent::ThresholdWarning,
                      eZNetScriptEvent::ThresholdCritical );
    }

    /*!
     \static

     Get Monitor identifier array

     return monitor identifier array
    */
    static function monitorIdentifierArray()
    {
        return array( eZNetScriptEvent::MonitorIdentifierDiskSpace,
                      eZNetScriptEvent::MonitorIdentifierDiskIO,
                      eZNetScriptEvent::MonitorIdentifierPhysMem,
                      eZNetScriptEvent::MonitorIdentifierVirtMem,
                      eZNetScriptEvent::MonitorIdentifierNetwork,
                      eZNetScriptEvent::MonitorIdentifierCPULoad );
    }

    /*!
     \static

     Check if Server type is valid

     \param server type

     \return true if server type is valid
    */
    static function validServerType( $serverType )
    {
        return in_array( $serverType, eZNetScriptEvent::serverTypeArray() );
    }

    /*!
     \static

     Check if Threshold is valid

     \param threshold

     \return true if threshold is valid
    */
    static function validThreshold( $threshold )
    {
        return in_array( $threshold, eZNetScriptEvent::thresholdArray() );
    }

    /*!
     \static

     Check if monitor identified is valid

     \param monitor identifier

     \return true if monitor identifier is valid
    */
    static function validMonitorIdentifier( $monitorIdentifier )
    {
        return in_array( $monitorIdentifier, eZNetScriptEvent::monitorIdentifierArray() );
    }

    /*!
     Set script event status, and store

     \param status
    */
    function setStatus( $status )
    {
        $this->setAttribute( 'status', $status );
        $this->sync();
    }

    /*!
     \static
     Change allow list

     \return change allow list
    */
    static function changeAllowList()
    {
        return array( eZNetScriptEvent::StatusNew,
                      eZNetScriptEvent::StatusPending,
                      eZNetScriptEvent::StatusFailed );
    }

    /*!
     \static
     Change to allow list

     \return change to allow list
    */
    static function changeToAllowList()
    {
        return array( eZNetScriptEvent::StatusClosed );
    }

    /*!
     \static
     Client show allow list

     \return client show allow list
    */
    static function clientShowAllowList()
    {
        return array( eZNetScriptEvent::StatusNew,
                      eZNetScriptEvent::StatusPending,
                      eZNetScriptEvent::StatusClosed );
    }

    /*!
     \static
     Status name map

     \return status name map
    */
    static function statusNameMap()
    {
        return array( eZNetScriptEvent::StatusNew => ezi18n( 'eznetmon_event', 'New' ),
                      eZNetScriptEvent::StatusPending => ezi18n( 'eznetmon_event', 'Pending' ),
                      eZNetScriptEvent::StatusClosed => ezi18n( 'eznetmon_event', 'Closed' ),
                      eZNetScriptEvent::StatusFailed => ezi18n( 'eznetmon_event', 'Failed' ) );
    }

}

?>
