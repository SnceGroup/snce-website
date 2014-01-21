<?php
/**
 * File containing eZNetSOAPLog class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPLog eznetsoaplog.php
  \brief The class eZNetSOAPLog does

*/
class eZNetSOAPLog extends eZPersistentObject
{
    /// Consts
    const STATUS_PENDING = 1;
    const STATUS_DONE = 2;

    const OriginatingSiteIDKey = 'eZNetSOAPLog_FromSiteID';

    /*!
     Constructor
    */
    function eZNetSOAPLog( $row )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'remote_host' => array( 'name' => 'RemoteHost',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'remote_host' => true ),
                                         "remote_value" => array( 'name' => 'RemoteValue',
                                                                  'datatype' => 'integer',
                                                                  'default' => 0,
                                                                  'required' => true ),
                                         'class_name' => array( 'name' => 'ClassName',
                                                                'datatype' => 'string',
                                                                'default' => '',
                                                                'remote_host' => true ),
                                         'key_name' => array( 'name' => 'KeyName',
                                                              'datatype' => 'string',
                                                              'default' => '',
                                                              'remote_host' => true ),
                                         "local_value" => array( 'name' => 'LocalValue',
                                                                 'datatype' => 'integer',
                                                                 'default' => 0,
                                                                 'required' => true ),
                                         "timestamp" => array( 'name' => 'Timestamp',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ),
                                         "remote_modified" => array( 'name' => 'RemoteModified',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true ),
                                         "extended_filter" => array( 'name' => 'ExtendedFilter',
                                                                     'datatype' => 'string',
                                                                     'default' => '',
                                                                     'required' => false ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array(),
                      "increment_key" => "id",
                      "class_name" => "eZNetSOAPLog",
                      "sort" => array( "timestamp" => "desc" ),
                      "name" => "ezx_ezpnet_soap_log" );
    }

    /*!
     Fetch SOAP Log entry
    */
    static function fetchByConds( $conds = array(), $filter = null, $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetSOAPLog::definition(),
                                                    $filter,
                                                    $conds,
                                                    null,
                                                    null,
                                                    $asObject );
    }

    /*!
     \static

     \param Remote host
     \param Classname
     \param Keys
     \param Value array
    */
    static function fetchExistingEntryList( $remoteHost,
                                            $classname,
                                            $keys,
                                            $valueArray,
                                            $extendedFilter = false,
                                            $asObject = true )
    {
        $exists = true;
        $entryList = array();
        foreach( $keys as $key )
        {
            $condArray = array( 'remote_host' => $remoteHost,
                                'class_name' => $classname,
                                'remote_value' => $valueArray[$key],
                                'key_name' => $key );
            if ( $extendedFilter )
            {
                $condArray['extended_filter'] = $extendedFilter;
            }

            $existingEntry = eZPersistentObject::fetchObject( eZNetSOAPLog::definition(),
                                                              null,
                                                              $condArray,
                                                              $asObject );
            if ( !$existingEntry )
            {
                return false;
            }
            $entryList[] = $existingEntry;
        }

        return $entryList;
    }


    /*!
     Create new SOAP log entry

     \return new eZNetSOAPLog
    */
    static function create( $remoteHost,
                            $remoteValue,
                            $localValue,
                            $className,
                            $keyName,
                            $extendedFilter = false )
    {
        $soapLog = new eZNetSOAPLog( array( 'remote_host' => $remoteHost,
                                            'remote_value' => $remoteValue,
                                            'local_value' => $localValue,
                                            'class_name' => $className,
                                            'key_name' => $keyName,
                                            'extended_filter' => $extendedFilter,
                                            'timestamp' => time() ) );
        if ( $extendedFilter )
        {
            $soapLog->setAttribute( 'extended_filter', $extendedFilter );
        }

        return $soapLog;
    }

    /*!
     \static
     Translate remote foreign ID to local ID value

     \Param Remote Host
     \param remote foreign ID
     \param Foreign ClassName

     \return local foreign ID
    */
    static function translateForeignKey( $remoteHost,
                                         $remoteValue,
                                         $className,
                                         $keyName )
    {
        $resultSet = eZPersistentObject::fetchObject( eZNetSOAPLog::definition(),
                                                      array( 'local_value' ),
                                                      array( 'remote_host' => $remoteHost,
                                                             'remote_value' => $remoteValue,
                                                             'class_name' => $className,
                                                             'key_name' => $keyName ),
                                                      false );
        if ( !$resultSet )
        {
            eZDebug::writeNotice( 'Could not find translation for ( host, remote ID ) : ' . $className . '::' . $keyName . ' ( ' .  $remoteHost . ', ' . $remoteValue . ' )' );
            return false;
        }

        return $resultSet['local_value'];
    }

    /*!
     \static

     Fixup return array by reverting remove keys and appned originating remote host ID

     \param className
     \param keyName
     \param RemoteHostID
     \param fieldList
     \param valueList

     \return modified value list
    */
    static function fixupReturnArray( $className,
                                      $keyList,
                                      $remoteHostID,
                                      $fieldList,
                                      $valueList )
    {
        if ( !is_array( $valueList ) )
        {
            return $valueList;
        }

        foreach( $valueList as $idx => $entry )
        {
            // Some fields have been changed, we need to revert it to old values to keep BC
            foreach ( $entry as $fieldName => $value )
            {
                $newFieldName = eZNetUtils::updateFieldName( $fieldName, false );
                if ( $newFieldName != $fieldName )
                {
                    $valueList[$idx][$newFieldName] = $value;
                    unset( $valueList[$idx][$fieldName] );
                }
            }

            $valueList[$idx][eZNetSOAPLog::OriginatingSiteIDKey] = eZNetSOAPLog::remoteHostByLocalValue( $className,
                                                                                                        $entry[$keyList[0]],
                                                                                                        $keyList[0] );
        }

        $valueList = eZNetSOAPLog::revertKeys( $className,
                                               $remoteHostID,
                                               $keyList,
                                               $valueList );

        $valueList = eZNetSOAPLog::revertRemoteKeys( $remoteHostID,
                                                     $fieldList,
                                                     $valueList );
        return $valueList;
    }

    /*!
     \static

     Convert remote IDs on export of objects.

     *Description: If any of the remote ID's originates from external server, revert to original value on export.
                   Adds originating SiteID the dataentry originates from.

     \param $remoteHostID
     \param $fieldList
     \param $valueList

     \return $valueArray
    */
    static function revertRemoteKeys( $remoteHostID,
                                      $fieldList,
                                      $valueList )
    {
        $foreignFieldList = eZNetSOAPLog::foreignFieldList( $fieldList );

        // Loop through foreign keys
        foreach( $foreignFieldList as $name => $definition )
        {
            foreach( $valueList as $idx => $entry )
            {
                if ( isset( $entry[$name] ) )
                {
                    $foreignValue = eZNetSOAPLog::foreignValue( $remoteHostID,
                                                                $definition['foreign_class'],
                                                                $definition['foreign_attribute'],
                                                                $entry[$name] );
                    if ( $foreignValue !== false )
                    {
                        $valueList[$idx][$name] = $foreignValue;
                    }
                }
            }
        }

        return $valueList;
    }

    /*!
     \static

     Convert IDs on export of objects.

     *Description: Revert ID's to their original values.

     \param $className
     \param $remoteHostID
     \param $keyList
     \param $valueList

     \return $valueArray
    */
    static function revertKeys( $className,
                                $remoteHostID,
                                $keyList,
                                $valueList )
    {
        // Loop through keys
        foreach( $keyList as $key )
        {
            foreach( $valueList as $idx => $entry )
            {
                if ( isset( $entry[$key] ) )
                {
                    $foreignValue = eZNetSOAPLog::foreignValue( $remoteHostID,
                                                                $className,
                                                                $key,
                                                                $entry[$key] );
                    if ( $foreignValue !== false )
                    {
                        $valueList[$idx][$key] = $foreignValue;
                    }
                }
            }
        }

        return $valueList;
    }

    /*!
     \static

     Get remote host ID by local values.

     \param class name
     \param key name
     \param local value

     \return HostID of the value.
    */
    static function remoteHostByLocalValue( $className, $localValue, $keyName )
    {
        $retVal = eZNetSOAPLog::fetchObject( eZNetSOAPLog::definition(),
                                             array( 'remote_host' ),
                                             array( 'class_name' => $className,
                                                    'key_name' => $keyName,
                                                    'local_value' => $localValue ),
                                             false );

        if ( !isset( $retVal['remote_host'] ) ||
             !$retVal['remote_host'] )
        {
            return eZNetUtils::hostID();
        }

        return $retVal['remote_host'];
    }

    /*!
     \static
     Check if foreign key is imported from specified host

     \param $hostID
     \param $className
     \param $keyName
     \param $localValue

     \return $remoteValue if exists, false if not
    */
    static function foreignValue( $hostID,
                                  $className,
                                  $keyName,
                                  $localValue )
    {
        $retVal = eZNetSOAPLog::fetchObject( eZNetSOAPLog::definition(),
                                             array( 'remote_value' ),
                                             array( 'remote_host' => $hostID,
                                                    'class_name' => $className,
                                                    'key_name' => $keyName,
                                                    'local_value' => $localValue ),
                                             false );
        if ( !isset( $retVal['remote_value'] ) ||
             !$retVal['remote_value'] )
        {
            return false;
        }

        return $retVal['remote_value'];
    }

    /*!
     \static

     Get list of foreign keys from fields definition

     \param Fields list, $fieldList

     \return Elements containing foreign key definitions
    */
    static function foreignFieldList( $fieldList )
    {
        $returnArray = array();
        foreach( $fieldList as $name => $definition )
        {
            if ( isset( $definition['foreign_attribute'] ) &&
                 isset( $definition['foreign_class'] ) )
            {
                $returnArray[$name] = $definition;
            }
        }

        return $returnArray;
    }
}

?>
