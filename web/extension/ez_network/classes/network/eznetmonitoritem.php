<?php
/**
 * File containing eZNetMonitorItem class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetmonitorResultItem eznetmonitorresultitem.php
  \brief The class eZNetmonitorResultItem does

*/
include_once( 'kernel/common/i18n.php' );

class eZNetMonitorItem extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    const EnabledTrue = 1;
    const EnabledFalse = 0;

    const PerDatabaseFalse = 0;
    const PerDatabaseTrue = 1;

    const SeverityOne = 1;
    const SeverityTwo = 2;
    const SeverityThree = 3;
    const SeverityFour = 4;
    const SeverityFive = 5;

    /*!
     Constructor
    */
    function eZNetMonitorItem( $row )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "name" => array( 'name' => 'Started',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         'monitor_group_id' => array( 'name' => 'MonitorGroupID',
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true,
                                                                      'foreign_class' => 'eZNetMonitorGroup',
                                                                      'foreign_attribute' => 'id',
                                                                      'multiplicity' => '0..*' ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         'original_filename' => array( 'name' => 'OriginalFilename',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ),
                                         "function_data" => array( 'name' => 'FunctionData',
                                                                   'datatype' => 'longtext',
                                                                   'default' => '',
                                                                   'required' => true ),
                                         'enabled' => array( 'name' => 'Enabled',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'per_database' => array( 'name' => 'PerDatabase',
                                                                  'datatype' => 'integer',
                                                                  'default' => 0,
                                                                  'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'severity' => array( 'name' => 'Severity',
                                                              'datatype' => 'integer',
                                                              'default' => 3,
                                                              'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'graph_type' => array( 'name' => 'GraphType',
                                                                'datatype' => 'string',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'monitorgroup' => 'monitorgroup',
                                                      'creator' => 'creator' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetMonitorItem",
                      "sort" => array( "id" => "desc" ),
                      "name" => "ezx_ezpnet_mon_item" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'monitorgroup':
            {
                $retVal = eZNetMonitorGroup::fetch( $this->attribute( 'monitor_group_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'function_data':
            {
                $retVal = eZNetCrypt::decrypt( eZPersistentObject::attribute( 'function_data' ) );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \reimp
    */
    function setAttribute( $attr, $value )
    {
        switch( $attr )
        {
            case 'function_data':
            {
                eZPersistentObject::setAttribute( 'function_data', eZNetCrypt::encrypt( $value ) );
            } break;

            default:
            {
                eZPersistentObject::setAttribute( $attr, $value );
            } break;
        }
    }

    /*!
     \reimp
    */
    function store( $fieldFilters = null )
    {
        $db = eZDB::instance();
        if ( $db->databaseName() == 'oracle' )
        {
            eZNetLargeObject::storeObject( $this, $fieldFilters );
        }
        else
        {
            parent::store( $fieldFilters );
        }
    }

    /*!
     \static

     Create monitor result item  element
    */
    static function create()
    {
        $resultItem = new eZNetMonitorItem( array( 'status' => eZNetMonitorItem::StatusDraft,
                                                   'created' => time(),
                                                   'creator_id' => eZUser::currentUserID() ) );
        $resultItem->store();

        return $resultItem;
    }

    /**
     * Magic function to handle cloning the object
     */
    public function __clone()
    {
        $this->setAttribute( 'id', 0 );
        $this->setAttribute( 'status', eZNetMonitorItem::StatusDraft );
        $this->setAttribute( 'created', time() );
        $this->setAttribute( 'creator_id', eZUser::currentUserID() );
    }

    /*!
     \static
    */
    static function fetch( $id,
                           $status = eZNetMonitorItem::StatusPublished,
                           $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetMonitorItem::definition(),
                                                null,
                                                array( 'id' => $id,
                                                       'status' => $status ),
                                                $asObject );
    }

    /*!
     \static

     Fetch draft

     \param Monitor result item  ID
     \param force, if force creation of draft.
     \param $asObject
    */
    static function fetchDraft( $id, $force = true, $asObject = true )
    {
        $resultItem = eZNetMonitorItem::fetch( $id,
                                               eZNetMonitorItem::StatusDraft,
                                               $asObject );
        if ( !$resultItem &&
             $force )
        {
            $resultItem = eZNetMonitorItem::fetch( $id,
                                                   eZNetMonitorItem::StatusPublished,
                                                   $asObject );
            if ( $resultItem )
            {
                $resultItem->setAttribute( 'status', eZNetMonitorItem::StatusDraft );
                $resultItem->store();
            }
        }

        if ( !$resultItem )
        {
            return false;
        }

        return $resultItem;
    }

    /*!
     \static

     Fetch a list of branches based on installation remote ID.

    */
    static function fetchListByRemoteIDAndLatestID( $installationSiteID,
                                                    $latestID,
                                                    $offset = 0,
                                                    $limit = 100,
                                                    $asObject = true,
                                                    $status = eZNetMonitorItem::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        $monitorGroupList = eZNetMonitorGroup::fetchConditionalList( array( 'branch_id' => $installation->attribute( 'branch_id' ) ),
                                                                     array( 'id' ),
                                                                     0,
                                                                     100,
                                                                     eZNetMonitorGroup::StatusPublished,
                                                                     false );

        $monitorGroupIDList = array();
        foreach( $monitorGroupList as $resultSet )
        {
            $monitorGroupIDList[] = $resultSet['id'];
        }

        return eZPersistentObject::fetchObjectList( eZNetMonitorItem::definition(),
                                                    array( 'id' ),
                                                    array( 'monitor_group_id' => array( $monitorGroupIDList ),
                                                           'status' => $status,
                                                           'id' => array( '>', $latestID ) ),
                                                    array( 'id' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch a list of branches based on installation remote ID.

    */
    static function fetchListByRemoteIDAndLatestModified( $installationSiteID,
                                                          $latestModified,
                                                          $offset = 0,
                                                          $limit = 100,
                                                          $asObject = true,
                                                          $status = eZNetMonitorItem::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        if ( !$installation )
        {
            return false;
        }

        $monitorGroupList = eZNetMonitorGroup::fetchConditionalList( array( 'branch_id' => $installation->attribute( 'branch_id' ) ),
                                                                     array( 'id' ),
                                                                     0,
                                                                     100,
                                                                     eZNetMonitorGroup::StatusPublished,
                                                                     false );

        $monitorGroupIDList = array();
        foreach( $monitorGroupList as $resultSet )
        {
            $monitorGroupIDList[] = $resultSet['id'];
        }

        return eZPersistentObject::fetchObjectList( eZNetMonitorItem::definition(),
                                                    array( 'id' ),
                                                    array( 'monitor_group_id' => array( $monitorGroupIDList ),
                                                           'status' => $status,
                                                           'modified' => array( '>', $latestModified ) ),
                                                    array( 'modified' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetMonitorItem::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetMonitorItem::fetchDraft( $this->attribute( 'id' ),
                                                     false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static

     \param $groupID - optional, default -1 ( all )
     \param $enabled - optional, default eZNetMonitorItem::EnabledTrue
     \param $status - optional, default eZNetMonitorItem::StatusPublished

     Fetch monitor result item count
    */
    static function countByGroup( $groupID = -1,
                                  $enabled = self::EnabledTrue,
                                  $status  = self::StatusPublished )
    {
        $condArray = array( 'status' => $status );
        if ( $enabled != -1 )
        {
            $condArray['enabled'] = $enabled;
        }
        if ( $groupID != -1 )
        {
            $condArray['monitor_group_id'] = $groupID;
        }
        return eZPersistentObject::count( self::definition(), $condArray, 'id' );
    }

    /*!
     \static

     Fetch monitor result item list
    */
    static function fetchList( $groupID = -1,
                               $enabled = eZNetMonitorItem::EnabledTrue,
                               $offset = 0,
                               $limit = 40,
                               $status = eZNetMonitorItem::StatusPublished,
                               $asObject = true )
    {
        $condArray = array( 'status' => $status );
        if ( $groupID != -1 )
        {
            $condArray['monitor_group_id'] = $groupID;
        }
        if ( $enabled != -1 )
        {
            $condArray['enabled'] = $enabled;
        }

        return eZPersistentObject::fetchObjectList( eZNetMonitorItem::definition(),
                                                    null,
                                                    $condArray,
                                                    null,
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static
     \return Enabled name map
    */
    static function enabledNameMap()
    {
        return array( eZNetMonitorItem::EnabledTrue => ezi18n( 'crm', 'Enabled' ),
                      eZNetMonitorItem::EnabledFalse => ezi18n( 'crm', 'Disabled' ) );
    }

    /*!
     \static
     \return Enabled name map
    */
    static function perDatabaseNameMap()
    {
        return array( eZNetMonitorItem::PerDatabaseTrue => ezi18n( 'crm', 'Yes' ),
                      eZNetMonitorItem::PerDatabaseFalse => ezi18n( 'crm', 'No' ) );
    }

    /*!
     \static

     \return Severity name map
    */
    static function severityNameMap()
    {
        return array( eZNetMonitorItem::SeverityOne   => ezi18n( 'crm', '1 - Critical' ),
                      eZNetMonitorItem::SeverityTwo   => ezi18n( 'crm', '2' ),
                      eZNetMonitorItem::SeverityThree => ezi18n( 'crm', '3 - Medium' ),
                      eZNetMonitorItem::SeverityFour  => ezi18n( 'crm', '4' ),
                      eZNetMonitorItem::SeverityFive  => ezi18n( 'crm', '5 - Low' ) );
    }
}
?>
