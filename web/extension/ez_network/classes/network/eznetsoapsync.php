<?php
/**
 * File containing eZNetSOAPSync class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPSync eznetsoapsync.php
  \brief The class eZNetSOAPSync does

*/
class eZNetSOAPSync
{
    /// Consts
    const SYNC_NAMESPACE = 'network_namespace';

    /*!
     Constructor

     \param eZPersistenceObject definition
    */
    function eZNetSOAPSync( $definition = false , $remoteHost = false )
    {
        if ( !$definition )
        {
            return;
        }
        $this->RemoteHost = $remoteHost;
        $this->RemoteTable = $definition['name'];
        $this->LocalTable = $definition['name'];
        $this->Fields = $definition['fields'];
        $this->Keys = $definition['keys'];
        $this->ClassName = $definition['class_name'];
        $this->ClassDefinition = $definition;

        foreach( $this->Fields as $attributeName => $attributeDefinition )
        {
            if ( isset( $attributeDefinition['foreign_override_attribute'] ) &&
                 isset( $attributeDefinition['foreign_override_class'] ) )
            {
                $this->OverrideKeys[$attributeName] = array( 'class_name' => $attributeDefinition['foreign_override_class'],
                                                             'attribute' => $attributeDefinition['foreign_override_attribute'] );
            }
        }
    }

    /*!
     Get host id
    */
    static function hostID()
    {
        return eZNetUtils::hostID();
    }

    /*!
     Syncronize - push. Push data to client.
    */
    function syncronizePush( $soapClient )
    {
        // 1. Get Latest ID ( to send update from then )
        $request = new eZSOAPRequest( 'getLatestID', eZNetSOAPSync::SYNC_NAMESPACE );
        $request->addParameter( 'className', $this->ClassName );
        $request->addParameter( 'hostID', eZNetUtils::hostID() );
        $response = $soapClient->send( $request );

        if( !$response ||
            $response->isFault() )
        {
            eZDebug::writeNotice( 'Did not get valid result running SOAP method : getLatestID, on class : ' . $this->ClassName );
            return false;
        }

        $latestID = $response->value(); // Missing message IDs

        // 2. Send list of elements to send to server.
        $latestList = $this->fetchListByLatestID( $latestID );

        if ( !empty( $latestList ) )
        {
            $request = new eZSOAPRequest( 'importElementsByHostID', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'data', $latestList );
            $response = $soapClient->send( $request );

            if( !$response ||
                $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : importElements, on class : ' . $this->ClassName );
                return false;
            }
        }

        return array( 'class_name' => $this->ClassName,
                      'export_count' => $latestList ? count( $latestList ) : 0 );
    }

    /*!
     Syncronize the specified class, using the specified soap client. Download missing entries from other soap server.

     \param SOAP client
     \param fetch count limit ( optional, default 100 )
     \param max key value ( optional, default false ). If this value if specified, only content with
                key less or equal to max key value will be syncronized.

     \return true if syncronization succeded, false if not.
    */
    function syncronize( $soapClient,
                         $limit = 100,
                         $maxKeyValue = false,
                         $cli = null )
    {
        // 1. Get remote eZ Publish hostID
        $request = new eZSOAPRequest( 'hostID', eZNetSOAPSync::SYNC_NAMESPACE );
        $response = $soapClient->send( $request );

        if( !$response ||
            $response->isFault() )
        {
            eZDebug::writeError( 'Did not get valid result running SOAP method : hostID, on class : ' . $this->ClassName );
            return false;
        }

        $this->RemoteHost = $response->value(); // Missing message IDs

        if ( !$this->RemoteHost )
        {
            eZDebug::writeError( 'RemoteHost not set: ' . var_export( $this->RemoteHost, 1 ),
                                 'eZNetSOAPSync::syncronize()' );
            return false;
        }

        // 2. Get all missing messages.
        if ( isset( $this->ClassDefinition['soap_custom_handler'] ) &&
             $this->ClassDefinition['soap_custom_handler'] === true )
        {
            $request = new eZSOAPRequest( 'doCustomDataRequest', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'latestID', call_user_func_array( array( $this->ClassName, 'getLatestID' ), array( $this->RemoteHost ) ) );
            $request->addParameter( 'fetchDefinition', call_user_func( array( $this->ClassName, 'customDataFetchDefinition' ) ) );
            $request->addParameter( 'dataMapDefinition', call_user_func( array( $this->ClassName, 'customDataMapDefinition' ) ) );
            $response = $soapClient->send( $request );

            if( !$response ||
                $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : doCustomDataRequest, on class : ' . $this->ClassName );
                return false;
            }

            $resultCount = 0;
            $result = $response->value(); // List of missing rows.

            if( $result &&
                !empty( $result ) )
            {
                $this->importElements( $result,
                                       false,
                                       call_user_func( array( $this->ClassName, 'customDataFilter' ) ),
                                       $maxKeyValue );
                $resultCount += count( $result );
            }
        }
        else
        {
            $request = $this->createFetchListSoapRequest( $limit, $cli );
            $response = $soapClient->send( $request );

            if( !$response ||
                $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : fetchListByLatestModified, on class : ' . $this->ClassName );
                return false;
            }

            $resultCount = 0;
            $result = $response->value(); // List of missing rows.
            while( $result &&
                   !empty( $result ) )
            {
                if ( !$this->importElements( $result,
                                             true,
                                             false,
                                             $maxKeyValue ) )
                {
                    break;
                }
                $resultCount += count( $result );

                $request = $this->createFetchListSoapRequest( $limit, $cli );
                $response = $soapClient->send( $request );

                if( !$response ||
                    $response->isFault() )
                {
                    eZDebug::writeNotice( 'Did not get valid result running SOAP method : fetchListByLatestID, on class : ' . $this->ClassName );
                    return false;
                }

                $result = $response->value(); // List of missing rows.

                // Abort synchronization if less than 20MB memory i left
                if ( eZNetUtils::memoryLimit() - memory_get_usage() < 20000000 )
                {
                    eZDebug::writeNotice( 'Less than 2OMB memory left, starting clean exit, on class : ' . $this->ClassName );
                    $cli = eZCLI::instance();
                    $cli->output( "Less than 20MB memory left, doing a clean exit to prevent a fatal error" );
                    break;
                }
            }
        }

        return array( 'class_name' => $this->ClassName,
                      'import_count' => $resultCount );
    }

    /*!
     Get max value name for current class. ( modified, if not exists, use id )

     \return max value name to use
    */
    function maxValueName()
    {
        if ( isset( $this->ClassDefinition['soap_custom_handler'] ) &&
             $this->ClassDefinition['soap_custom_handler'] === true )
        {
            return call_user_func( array( $this->ClassName, 'customKeyName' ) );
        }
        else if ( isset( $this->Fields['modified'] ) )
        {
            return 'modified';
        }
        return 'id';
    }

    /*!
     Create standard soap request for "Fetch by latest"

     \param optional, number of entries to fetch at a time.

     \return Soap request
    */
    function createFetchListSoapRequest( $limit = 100, $cli = null )
    {
        $useModified = isset( $this->Fields['modified'] );
        $cli = $cli === null ? eZCLI::instance() : $cli;

        if ( $useModified )
        {
            $request = new eZSOAPRequest( 'fetchListByLatestModified', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'latestModified', $this->getLatestModified() );
            $request->addParameter( 'limit', $limit );
            $cli->output( 'Synchronizing: ' . $this->ClassName . ', latest updated: ' . $this->getLatestModified() );
        }
        else
        {
            $request = new eZSOAPRequest( 'fetchListByLatestID', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'latestID', $this->getLatestID() );
            $request->addParameter( 'limit', $limit );
            $cli->output( 'Synchronizing: ' . $this->ClassName . ', id: ' . $this->getLatestID() );
        }

        return $request;
    }

    /*!
     \static
     Get SOAP function definition list
    */
    static function functionDefinitionList()
    {
        $defaultParameters = array( 'className' => 'string',
                                    'hostID' => 'string' );
        return array( 'getLatestID' => $defaultParameters,
                      'getMaxID' => $defaultParameters,
                      'getMinID' => $defaultParameters,
                      'getMaxModified' => $defaultParameters,
                      'getCustomMax' => $defaultParameters,
                      'latestIDList' => array_merge( $defaultParameters,
                                                     array( 'latestID' => 'string' ) ),
                      'fetchListByLatestID' => array_merge( $defaultParameters,
                                                            array( 'latestID' => 'string',
                                                                    'limit' => 'string' ) ),
                      'getLatestModified' => $defaultParameters,
                      'latestModifiedList' => array_merge( $defaultParameters,
                                                           array( 'latestModified' => 'string' ) ),
                      'fetchListByLatestModified' => array_merge( $defaultParameters,
                                                                  array( 'latestModified' => 'string',
                                                                         'limit' => 'string' ) ),
                      'hostID' => array(),
                      'importElements' => array_merge( $defaultParameters,
                                                       array( 'data' => 'array' ) ),
                      'importElementsByHostID' => array_merge( $defaultParameters,
                                                               array( 'data' => 'array' ) ),
                      'doCustomDataRequest' => array_merge( $defaultParameters,
                                                            array( 'latestID' => 'string',
                                                                   'fetchDefinition' => 'array',
                                                                   'dataMapDefinition' => 'array' ) ),
                      'fetchListByHostIDLatestID' => array_merge( $defaultParameters,
                                                                  array( 'latestID' => 'string',
                                                                         'limit' => 'string' ) ),
                      'fetchListByHostIDLatestModified' => array_merge( $defaultParameters,
                                                                  array( 'latestModified' => 'string',
                                                                         'limit' => 'string' ) ) );
    }

    /*!
     Get maximum key from remote host.

     \return max remote value
     */
    function maxRemoteValue( $soapClient )
    {
        if ( isset( $this->ClassDefinition['soap_custom_handler'] ) &&
             $this->ClassDefinition['soap_custom_handler'] === true ) // Use custom max
        {
            $request = new eZSOAPRequest( 'getCustomMax', eZNetSOAPSync::SYNC_NAMESPACE );
        }
        else
        {
            if ( isset( $this->Fields['modified'] ) ) // Use modified
            {
                $request = new eZSOAPRequest( 'getMaxModified', eZNetSOAPSync::SYNC_NAMESPACE );
            }
            else // Use ID
            {
                $request = new eZSOAPRequest( 'getMaxID', eZNetSOAPSync::SYNC_NAMESPACE );
            }
        }
        $request->addParameter( 'className', $this->ClassName );
        $request->addParameter( 'hostID', eZNetUtils::hostID() );

        $response = $soapClient->send( $request );

        if( !$response ||
            $response->isFault() )
        {
            eZDebug::writeNotice( 'Did not get valid result running SOAP method : doCustomDataRequest, on class : ' . $this->ClassName );
            return false;
        }

        return $response->value(); // List of missing rows.
    }

    /*!
     Get latest modified form table specified in this SOAPSync instance
    */
    function getLatestModified()
    {
        $db = eZDB::instance();

        $sql = "SELECT max( remote_modified ) as max FROM ezx_ezpnet_soap_log
                  WHERE remote_host = '" . $db->escapeString( $this->RemoteHost ) . "' AND
                        class_name = '" . $db->escapeString( $this->ClassName ) . "' AND
                        key_name = '" . $db->escapeString( $this->Keys[0] ) . "'";

        $result = $db->arrayQuery( $sql );
        if ( $result )
        {
            return max( -1, $result[0]['max'] );
        }

        return 0;
    }

    /*!
     Get custom max value from specified class.
    */
    function getCustomMax()
    {
        return call_user_func_array( array( $this->ClassName,
                                            'getCustomMax' ),
                                     array() );
    }

    /*!
     Get Max ID from of specified class.
    */
    function getMaxID()
    {
        $resultSet = call_user_func_array( array( $this->ClassName,
                                                  'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  array(),
                                                  null,
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => 'max( id )',
                                                                'name' => 'max_id' ) ) ) );
        return isset( $resultSet[0]['max_id'] ) ? $resultSet[0]['max_id'] : false;
    }

    /*!
     Get Min ID from of specified class.
    */
    function getMinID()
    {
        $resultSet = call_user_func_array( array( $this->ClassName,
                                                  'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  array(),
                                                  null,
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => 'min( id )',
                                                                'name' => 'min_id' ) ) ) );
        return isset( $resultSet[0]['min_id'] ) ? $resultSet[0]['min_id'] : false;
    }

    /*!
     Get Max modified from of specified class.
    */
    function getMaxModified()
    {
        $resultSet = call_user_func_array( array( $this->ClassName,
                                                  'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  array(),
                                                  null,
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => 'max( modified )',
                                                                'name' => 'max_modified' ) ) ) );
        return isset( $resultSet[0]['max_modified'] ) ? $resultSet[0]['max_modified'] : false;
    }

    /*!
     Get latest ID form table specified in this SOAPSync instance
    */
    function getLatestID()
    {
        $db = eZDB::instance();

        $sql = "SELECT max( remote_value ) as max FROM ezx_ezpnet_soap_log
                  WHERE remote_host = '" . $db->escapeString( $this->RemoteHost ) . "' AND
                        class_name = '" . $db->escapeString( $this->ClassName ) . "' AND
                        key_name = '" . $db->escapeString( $this->Keys[0] ) . "'";

        $result = $db->arrayQuery( $sql );
        if ( $result )
        {
            return max( -1, $result[0]['max'] );
        }

        return 0;
    }

    /*!
     Get all id's created after specified ID

     \return array of id's
    */
    function latestIDList( $latestID, $limit = 100 )
    {
        $tmpList = eZPersistentObject::fetchObjectList( $this->ClassDefinition,
                                                        array( $this->Keys[0] ),
                                                        array( $this->Keys[0] => array( '>', $latestID ) ),
                                                        array( $this->Keys[0] => 'asc' ),
                                                        array( 'limit' => $limit,
                                                               'offset' => 0 ),
                                                        false );
        $localKeyList = array();
        foreach( $tmpList as $resultSet )
        {
            $localKeyList[(string)$resultSet[$this->Keys[0]]] = $resultSet[$this->Keys[0]];
        }

        // If no localKeys, return empty array.
        if ( empty( $localKeyList ) )
        {
            return $localKeyList;
        }

        $soapLogEntryList = eZNetSOAPLog::fetchByConds( array( 'class_name' => $this->ClassName,
                                                               'local_value' => array( $localKeyList ),
                                                               'key_name' => $this->Keys[0] ),
                                                        array( 'local_value' ),
                                                        false );
        foreach( $soapLogEntryList as $soapLogEntry )
        {
            unset( $localKeyList[(string)$soapLogEntry['local_value']] );
        }
        return $localKeyList;
    }

    /*!
     Get all id's created after specified modified TS

     \return array of id's
    */
    function latestModifiedList( $latestModified, $limit = 100 )
    {
        $tmpList = eZPersistentObject::fetchObjectList( $this->ClassDefinition,
                                                        array( $this->Keys[0] ),
                                                        array( 'modified' => array( '>', $latestModified ) ),
                                                        array( 'modified' => 'asc' ),
                                                        array( 'limit' => $limit,
                                                               'offset' => 0 ),
                                                        false );
        $localKeyList = array();
        foreach( $tmpList as $resultSet )
        {
            $localKeyList[(string)$resultSet[$this->Keys[0]]] = $resultSet[$this->Keys[0]];
        }

        return $localKeyList;
    }

    /*!
     Get all id's created after specified ID

     \return array of id's
    */
    function latestIDListByHostID( $latestID, $limit = 100 )
    {
        // 1. Get first 100 elements.
        $tmpList = call_user_func_array( array( $this->ClassName,
                                                'fetchListByRemoteIDAndLatestID' ),
                                         array( $this->RemoteHost,
                                                $latestID,
                                                0,
                                                $limit,
                                                false ) );

        // Clean up result
        $localKeyList = array();
        foreach( $tmpList as $resultSet )
        {
            $localKeyList[(string)$resultSet[$this->Keys[0]]] = $resultSet[$this->Keys[0]];
        }

        $soapLogEntryList = eZNetSOAPLog::fetchByConds( array( 'class_name' => $this->ClassName,
                                                               'local_value' => array( $localKeyList ),
                                                               'key_name' => $this->Keys[0],
                                                               'remote_host' => $this->RemoteHost ),
                                                        array( 'local_value' ),
                                                        false );

        // Remove imported ID's from Host from list.
        foreach( $soapLogEntryList as $soapLogEntry )
        {
            unset( $localKeyList[(string)$soapLogEntry['local_value']] );
        }
        return $localKeyList;
    }

    /*!
     Get all id's created after specified modified date

     \return array of id's
    */
    function latestModifiedListByHostID( $latestModified, $limit = 100 )
    {
        // 1. Get first 100 elements.
        $tmpList = call_user_func_array( array( $this->ClassName,
                                                'fetchListByRemoteIDAndLatestModified' ),
                                         array( $this->RemoteHost,
                                                $latestModified,
                                                0,
                                                $limit,
                                                false ) );

        // Clean up result
        $localKeyList = array();
        foreach( $tmpList as $resultSet )
        {
            $localKeyList[(string)$resultSet[$this->Keys[0]]] = $resultSet[$this->Keys[0]];
        }

/*        $soapLogEntryList = eZNetSOAPLog::fetchByConds( array( 'class_name' => $this->ClassName,
                                                               'local_value' => array( $localKeyList ),
                                                               'key_name' => $this->Keys[0],
                                                               'remote_host' => $this->RemoteHost ),
                                                        array( 'local_value' ),
                                                        false );

        // Remove imported ID's from Host from list.
        foreach( $soapLogEntryList as $soapLogEntry )
        {
            unset( $localKeyList[(string)$soapLogEntry['local_value']] );
        }*/
        return $localKeyList;
    }

    /*!
     Import elements with values as specified in supplied arrays

     \param value list
     \param deleteKeys - Keys which should be removed before importing. These are normally auto increments in the
            DB tables. ( optional, default true )
     \param $extendedFilter ( optional, default false )
     \param $maxKeyValue ( optional, default false ). All elements with primary keys less or equal to the
            max key value will be discarded.
    */
    function importElements( $valueList,
                             $deleteKeys = true,
                             $extendedFilter = false,
                             $maxKeyValue = false )
    {
        $retVal = true;
        $db = eZDB::instance();

        foreach( $valueList as $valueArray )
        {
            if ( $maxKeyValue !== false )
            {
                if ( $valueArray[$this->maxValueName()] > $maxKeyValue )
                {
                    $retVal = false;
                    continue;
                }
            }

            $db->begin();

            $newValueArray = array();
            $foreignOverrideValues = array();

            // Translate field names
            $valueArray = eZNetSoapsync::translateFieldNames( $valueArray );

            // Check if element already exists
            $entryList = eZNetSOAPLog::fetchExistingEntryList( $this->RemoteHost,
                                                               $this->ClassName,
                                                               $this->Keys,
                                                               $valueArray,
                                                               $extendedFilter );

            // Entry exists. update current
            $insertNew = true;
            if ( $entryList )
            {
                $insertNew = !$this->updateExistingEntry( $valueArray, $entryList );
            }
            else if ( isset( $valueArray[eZNetSOAPLog::OriginatingSiteIDKey] ) &&
                      $valueArray[eZNetSOAPLog::OriginatingSiteIDKey] == eZNetUtils::hostID() )
            {
                $insertNew = !$this->updateExistingEntry( $valueArray,
                                                          $entryList,
                                                          $this->conditionArrayFromValues( $valueArray ) );
            }

            if ( $insertNew )
            {
                $this->insertNewEntry( $valueArray,
                                       $deleteKeys,
                                       $extendedFilter );
            }

            $db->commit();
        }

        return $retVal;
    }

    /*!
     Insert new entry

     \param $valueArray
     \param $deleteKeys
     \param $extendedFilter
    */
    function insertNewEntry( $valueArray,
                             $deleteKeys,
                             $extendedFilter = false )
    {

        // Find foreign keys, and translate them to local values.
        $newValueArray = array();
        foreach( $this->Fields as $attributeName => $attributeDefinition )
        {
            if ( !isset( $valueArray[$attributeName] ) )
                continue;

            if ( isset( $attributeDefinition['foreign_attribute'] ) &&
                 isset( $attributeDefinition['foreign_class'] ) )
            {
                $newAttributeValue = eZNetSOAPLog::translateForeignKey( $this->RemoteHost,
                                                                        $valueArray[$attributeName],
                                                                        $attributeDefinition['foreign_class'],
                                                                        $attributeDefinition['foreign_attribute'] );
                if ( $newAttributeValue === false )
                {
                    // Do nothing, use old one.
                }
                else
                {
                    $newValueArray[$attributeName] = $newAttributeValue;
                }
            }
            if ( isset( $attributeDefinition['foreign_override_class'] ) &&
                 isset( $attributeDefinition['foreign_override_attribute'] ) )
            {
                $foreignOverrideValues[$attributeName] = $valueArray[$attributeName];
            }
        }

        $remoteKeyList = $this->removeKeys( $valueArray, $deleteKeys );

        $valueArray = array_merge( $valueArray, $newValueArray );
        $importObject = new $this->ClassName( $valueArray );
        $importObject->store();

        $this->createEntryList( array_merge( $valueArray, $remoteKeyList ),
                                $importObject,
                                $extendedFilter );

        foreach( $this->OverrideKeys as $attributeName => $overrideDefinition )
        {
            $soapLog = eZNetSOAPLog::create( $this->RemoteHost,
                                             $foreignOverrideValues[$attributeName],
                                             $importObject->attribute( $attributeName ),
                                             $overrideDefinition['class_name'],
                                             $overrideDefinition['attribute'],
                                             $extendedFilter );
            if ( isset( $this->Fields['modified'] ) )
            {
                $soapLog->setAttribute( 'remote_modified', $valueArray['modified'] );
            }

            $soapLog->store();
        }

        // Create possible notification event.
        $ini = eZINI::instance( 'network.ini' );
        if ( $ini->hasVariable( 'NotificationSettings', 'EventClassMap' ) )
            $eventClassMap = $ini->variable( 'NotificationSettings', 'EventClassMap' );
        else
            $eventClassMap = array();

        if ( isset( $eventClassMap[$this->ClassName] ) )
        {
            $mapData = explode( ';', $eventClassMap[$this->ClassName] );
            $parameters = array();
            foreach( explode( ',', $mapData[1] ) as $parameter )
            {
                $parameters[$parameter] = $importObject->attribute( $parameter );
            }

            $event = eZNotificationEvent::create( $mapData[0], $parameters );
            $event->store();
        }
    }

    /*!
     Update existing data.

     \param $valueArray
     \param $entryList
     */
    function updateExistingEntry( $valueArray, $entryList, $condArray = false )
    {
        // Get local keys, and build condition array.
        if ( !$condArray )
        {
            $condArray = array();
            foreach( $entryList as $existingEntry )
            {
                $condArray[$existingEntry->attribute( 'key_name' )] = $existingEntry->attribute( 'local_value' );
            }
        }

        // Remove key values from value array.
        $remoteKeyList = $this->removeKeys( $valueArray, true );

        // Fetch object and,update attribute values.
        $existingObject = eZPersistentObject::fetchObject( $this->ClassDefinition,
                                                           null,
                                                           $condArray );
        if ( !$existingObject )
        {
            eZLog::writeStorageLog( 'Could not load existing object: ' . $this->ClassName . ': ' . var_export( $condArray, 1 ),
                          'network.log' );
            return false;
        }

        // Find foreign keys, and translate them to local values.
        $newValueArray = array();
        foreach( $this->Fields as $attributeName => $attributeDefinition )
        {
            if ( !isset( $valueArray[$attributeName] ) )
                continue;

            if ( isset( $attributeDefinition['foreign_attribute'] ) &&
                 isset( $attributeDefinition['foreign_class'] ) )
            {
                $newAttributeValue = eZNetSOAPLog::translateForeignKey( $this->RemoteHost,
                                                                        $valueArray[$attributeName],
                                                                        $attributeDefinition['foreign_class'],
                                                                        $attributeDefinition['foreign_attribute'] );

                if ( $newAttributeValue !== false )
                {
                    $newValueArray[$attributeName] = $newAttributeValue;
                }
            }
        }

        foreach( $valueArray as $attributeName => $attributeValue )
        {
            $existingObject->setAttribute( $attributeName, isset( $newValueArray[$attributeName] ) ? $newValueArray[$attributeName] : $attributeValue );
        }
        $existingObject->sync();

        // Update Soap sync log with updated entry
        if ( !$entryList )
        {
            $this->createEntryList( array_merge( $remoteKeyList, $valueArray ),
                                    $existingObject );
        }
        else
        {
            foreach( $entryList as $existingEntry )
            {
                $existingEntry->setAttribute( 'remote_modified', $existingObject->attribute( 'modified' ) );
                $existingEntry->sync();
            }
        }

        return true;
    }

    /*!
     Update soap sync log with new entry

     \param old value array
     \param New persistent object
     \param extended filter ( optional )
    */
    function createEntryList( $oldValueArray,
                              $persistentObject,
                              $extendedFilter = false )
    {
        foreach( $this->Keys as $key )
        {
            $soapLog = eZNetSOAPLog::create( $this->RemoteHost,
                                             $oldValueArray[$key],
                                             $persistentObject->attribute( $key ),
                                             $this->ClassName,
                                             $key,
                                             $extendedFilter );
            if ( isset( $this->Fields['modified'] ) )
            {
                $soapLog->setAttribute( 'remote_modified', $oldValueArray['modified'] );
            }

            $soapLog->store();
        }

    }

    /*!
     Import elements with values as specified in supplied arrays

     \param value list
    */
    function importElementsByHostID( $valueList, $deleteKeys = true )
    {
        $db = eZDB::instance();

        $installation = eZNetInstallation::fetchBySiteID( $this->RemoteHost );

        foreach( $valueList as $valueArray )
        {
            $db->begin();

            $newValueArray = array();
            $foreignOverrideValues = array();

            $correctInstallation = call_user_func_array( array( $this->ClassName, "belongsToInstallation" ),
                                                         array( $valueArray, $installation, $this->RemoteHost ) );
            if ( !$correctInstallation )
            {
                eZLog::write( "Unauthorized soap push access\n" .
                              "             Class                  : " . $this->ClassName . "\n" .
                              "             Remote Host ID         : " . $this->RemoteHost . "\n" .
                              "             Remote installation ID : " . eZNetInstallation::fetchBySiteID( $this->RemoteHost ) . "\n" .
                              "             Value installation ID  : " . $valueArray['installation_id'] . "\n", 'network.log' );
            }

            // Check if element already exists
            $entryList = eZNetSOAPLog::fetchExistingEntryList( $this->RemoteHost,
                                                               $this->ClassName,
                                                               $this->Keys,
                                                               $valueArray );

            // Entry exists. update current
            $insertNew = true;
            if ( $entryList )
            {
                $insertNew = !$this->updateExistingEntry( $valueArray, $entryList );
            }
            else if ( $valueArray[eZNetSOAPLog::OriginatingSiteIDKey] == eZNetUtils::hostID() )
            {
                $insertNew = !$this->updateExistingEntry( $valueArray,
                                                          $entryList,
                                                          $this->conditionArrayFromValues( $valueArray ) );
            }

            if ( $insertNew )
            {
                $this->insertNewEntry( $valueArray );
            }

            $db->commit();
        }

        return true;
    }

    /*!
     Fetch Items specified by ID list

     \return list of issues
    */
    function fetchListByLatestID( $latestID, $limit = 100 )
    {
        $idList = $this->latestIDList( $latestID, $limit );

        // No entries found.
        if ( empty( $idList ) )
        {
            return false;
        }

        $valueList = call_user_func_array( array( $this->ClassName, 'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  null,
                                                  array( $this->Keys[0] => array( $idList ) ),
                                                  null,
                                                  null,
                                                  false ) );
        return eZNetSOAPLog::fixupReturnArray( $this->ClassName,
                                               $this->Keys,
                                               $this->RemoteHost,
                                               $this->Fields,
                                               $valueList );
    }

    /*!
     Fetch Items specified by modified date list

     \return list of issues
    */
    function fetchListByLatestModified( $latestModified, $limit = 100 )
    {
        $idList = $this->latestModifiedList( $latestModified, $limit );
        if ( !empty( $idList ) )
        {
            $valueList = call_user_func_array( array( $this->ClassName, 'fetchObjectList' ),
                                               array( $this->ClassDefinition,
                                                      null,
                                                      array( $this->Keys[0] => array( $idList ) ),
                                                      null,
                                                      null,
                                                      false ) );
        }
        else
        {
            $valueList = array();
        }

        return eZNetSOAPLog::fixupReturnArray( $this->ClassName,
                                               $this->Keys,
                                               $this->RemoteHost,
                                               $this->Fields,
                                               $valueList );
    }

    /*!
     Fetch Items specified by ID list

     \return list of issues
    */
    function fetchListByHostIDLatestID( $latestID, $limit = 100 )
    {
        $idList = $this->latestIDListByHostID( $latestID, $limit );
        $valueList = call_user_func_array( array( $this->ClassName, 'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  null,
                                                  array( $this->Keys[0] => array( $idList ) ),
                                                  null,
                                                  null,
                                                  false ) );
        return eZNetSOAPLog::fixupReturnArray( $this->ClassName,
                                               $this->Keys,
                                               $this->RemoteHost,
                                               $this->Fields,
                                               $valueList );
    }

    /*!
     Fetch Items specified by modified date list

     \return list of issues
    */
    function fetchListByHostIDLatestModified( $latestModified, $limit = 100 )
    {
        $idList = $this->latestModifiedListByHostID( $latestModified, $limit );
        $valueList = call_user_func_array( array( $this->ClassName, 'fetchObjectList' ),
                                           array( $this->ClassDefinition,
                                                  null,
                                                  array( $this->Keys[0] => array( $idList ) ),
                                                  null,
                                                  null,
                                                  false ) );
        return eZNetSOAPLog::fixupReturnArray( $this->ClassName,
                                               $this->Keys,
                                               $this->RemoteHost,
                                               $this->Fields,
                                               $valueList );
    }

    /*!
     Register SOAP functions
    */
    function registerFunctionList( &$server )
    {
        foreach( $this->functionDefinitionList() as $functionName => $parameterDefinition )
        {
            $server->registerFunction( $functionName, $parameterDefinition );
            $phpCode = 'function ' . $functionName . '(';
            $firstParam = true;
            foreach( $parameterDefinition as $parameterName => $parameterType )
            {
                if ( !$firstParam )
                {
                    $phpCode .= ', ';
                }
                $firstParam = false;
                $phpCode .= '$' . $parameterName;
            }
            $phpCode .= ' ) {';
            if ( empty( $parameterDefinition ) )
            {
                $phpCode .= ' return ' . get_class( $this ) . '::' . $functionName . '();';
            }
            else
            {
                $phpCode .= '$soapSync = new '. get_class( $this ) . '( call_user_func( array( $className, "definition" ) ), $hostID );' . "\n" .
                    'return $soapSync->' . $functionName . '( ';
                if ( count( $parameterDefinition ) > 2 )
                {
                    array_shift( $parameterDefinition );
                    array_shift( $parameterDefinition );
                    $firstParam = true;
                    foreach( $parameterDefinition as $parameterName => $parameterType )
                    {
                        if ( !$firstParam )
                        {
                            $phpCode .= ', ';
                        }
                        $firstParam = false;
                        $phpCode .= '$' . $parameterName;
                    }
                }
                $phpCode .= ' );';
            }
            $phpCode .= ' }';

            eval( $phpCode );
        }
    }

    /*!
     Do custom data request to SOAP server
    */
    function doCustomDataRequest( $latestID,
                                  $fetchDefinition,
                                  $dataMapDefinition )
    {
        $className = $fetchDefinition['class_name'];
        $classDefinition = call_user_func( array( $className, 'definition' ) );
        $classKey = $classDefinition['keys'][0];
        if ( isset( $fetchDefinition['include_file'] ) )
        {
        }
        // Build fetch condition array
        $condArray = $fetchDefinition['conditions'];
        if ( $latestID )
        {
            $condArray[$classKey] = array( '>', $latestID );
        }
        $tmpList = call_user_func_array( array( $this->ClassName, 'fetchObjectList' ),
                                         array( $classDefinition,
                                                array( $classKey ),
                                                $condArray,
                                                array( $classKey => 'asc' ),
                                                null,
                                                false ) );
        $localKeyList = array();
        foreach( $tmpList as $resultSet )
        {
            $localKeyList[(string)$resultSet[$classKey]] = $resultSet[$classKey];
        }

        $soapLogEntryList = eZNetSOAPLog::fetchByConds( array( 'class_name' => $className,
                                                               'local_value' => array( $localKeyList ),
                                                               'key_name' => $classKey ),
                                                        array( 'local_value' ),
                                                        false );
        if ( is_array( $soapLogEntryList ) )
        {
            foreach( $soapLogEntryList as $soapLogEntry )
            {
                unset( $localKeyList[(string)$soapLogEntry['local_value']] );
            }
        }

        $objectList = eZPersistentObject::fetchObjectList( $classDefinition,
                                                           null,
                                                           array( $classKey => array( $localKeyList ) ) );

        $resultSet = array();
        if ( is_array( $objectList ) )
        {
            foreach( $objectList as $idx => $object )
            {
                $resultSet[$idx] = array();
                foreach( $dataMapDefinition['fields'] as $attribute => $functionList )
                {
                    $result = $object;
                    foreach( $functionList as $function => $parameterList )
                    {
                        if ( is_array( $parameterList ) )
                        {
                            $result = call_user_func_array( array( $result, $function ), $parameterList );
                        }
                        else
                        {
                            $result = $result[$parameterList];
                        }
                    }

                    $resultSet[$idx][$attribute] = $result;
                }
            }
        }
        return $resultSet;
    }

    /*!
     Handle custom data request from SOAP client.
    */
    function handleCustomDataRequest( )
    {
    }

    /*!
     Create condition array from keys

     \param value array

     \return conditionArray
    */
    function conditionArrayFromValues( $valueArray )
    {
        $conditionArray = array();
        foreach( $this->Keys as $key )
        {
            $conditionArray[$key] = $valueArray[$key];
        }
        return $conditionArray;
    }

    /*!
     Remove keys from value array

     \param ( reference ) value array
     \param $deleteKeys ( default true )

     \return $remote Key list
    */
    function removeKeys( &$valueArray, $deleteKeys = true )
    {
        $remoteKeyList = array();
        foreach( $this->Keys as $key )
        {
            $remoteKeyList[$key] = $valueArray[$key];
            if ( $deleteKeys &&
                 ( !isset( $this->Fields[$key]['keep_key'] ) ||
                   $this->Fields[$key]['keep_key'] != true ) )
            {
                unset( $valueArray[$key] );
            }
        }
        return $remoteKeyList;
    }

    /*!
     eZ Network client must attempt to use HTTP if use of SSL fails.
     If SSL fails return HTTP port or SSL port otherwise.

     \return port number
    */
    static function getPort( $server, $path, $port )
    {
        // Port 80 is used as fallback when port is set to 443 or ssl
        if ( $port == 443 or $port == 'ssl' )
        {
            $returnPort = 80;
        }
        else
        {
            $returnPort = $port;
        }

        // If current port is SSL and we support 'curl' we should check proper connection using this port
        if ( ( $port == 443 or $port == 'ssl' ) and in_array( "curl", get_loaded_extensions() ) )
        {
            // eZ Publish 4.0.1 only accepts port 'ssl' when using SSL
            if ( eZPublishSDK::version() == '4.0.1' )
            {
                $port = 'ssl';
            }
            $client = new eZSOAPClient( $server, $path, $port );
            // Just try to fetch remote (critmon) timestamp
            $request = new eZSOAPRequest( 'eZNetMonSOAPTools__timestamp', 'eZNetNS' );
            $response = $client->send( $request );
            // If it's successful return the port
            if ( $response and !$response->isFault() )
            {
                $returnPort = $port;
            }
        }

        return $returnPort;
    }

    /**!
     \static

      Translate defined field names (columns).

     \param $valueArray array Received row
     \return array Translated row
    */
    static function translateFieldNames( $valueArray = false )
    {
        // List of columns to translate (due to name change)
        // key is server's columns name, value is local column name
        $translationList = array (
            'mode' => 'fmode',
            'offset' => 'data_offset',
            );

        foreach ( $valueArray as $field => $value )
        {
            // Translate field if needed, by extending the array
            if ( array_key_exists( $field, $translationList ) )
            {
                $translatedFieldName = $translationList[ $field ];
                $valueArray[ $translatedFieldName ] = $valueArray[ $field ];
            }
        }
        return $valueArray;
    }

    var $RemoteHost;
    var $RemoteTable;
    var $LocalTable;
    var $Fields;
    var $Keys;
    var $ClassName;
    var $ClassDefinition;
    var $OverrideKeys = array();
}

?>
