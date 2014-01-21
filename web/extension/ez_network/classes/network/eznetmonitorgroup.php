<?php
/**
 * File containing eZNetMonitorGroup class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetMonitorGroup eznetmonitorgroup.php
  \brief The class eZNetMonitorGroup does

*/
class eZNetMonitorGroup extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    /*!
     Constructor
    */
    function eZNetMonitorGroup( $row )
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
                                         "name" => array( 'name' => 'Started',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "branch_id" => array( 'name' => 'eZNetBranchID',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true,
                                                               'foreign_class' => 'eZNetBranch',
                                                               'foreign_attribute' => 'id',
                                                               'multiplicity' => '0..*' ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'max_frequency' => array( 'name' => 'MaxFrequency',
                                                                   'datatype' => 'integer',
                                                                   'default' => 0,
                                                                   'required' => true ),
                                         'show_result' => array( 'name' => 'ShowResult',
                                                                 'datatype' => 'integer',
                                                                 'default' => 1,
                                                                 'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'item_list' => 'itemList',
                                                      'branch' => 'branch',
                                                      'last_run_ts' => 'lastRun',
                                                      'type_setting' => 'typeSetting' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetMonitorGroup",
                      "sort" => array( "id" => "desc" ),
                      "name" => "ezx_ezpnet_mon_group" );
    }

    /*!
     \static

     Fetch monitor group list by branch ID

     \param Branch ID
     \param offset
     \param limit
     \param Status

     \return array of Branches.
    */
    static function fetchListByBranchID( $branchID,
                                         $offset = 0,
                                         $limit = 100,
                                         $status = eZNetMonitorGroup::StatusPublished,
                                         $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetMonitorGroup::definition(),
                                                    null,
                                                    array( 'branch_id' => $branchID,
                                                           'status' => $status ),
                                                    null,
                                                    array( 'offset' => $offset,
                                                           'limit' => $limit ),
                                                    $asObject );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'item_list':
            {
                $retVal = eZNetMonitorItem::fetchList( $this->attribute( 'id' ),
                                                       eZNetMonitorItem::EnabledTrue,
                                                       0,
                                                       100 );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'last_run_ts':
            {
                $retVal = $this->lastRunTS();
            } break;

            case 'branch':
            {
                $retVal = eZNetBranch::fetch( $this->attribute( 'branch_id' ) );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
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
                                                    $status = eZNetMonitorGroup::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        return eZPersistentObject::fetchObjectList( eZNetMonitorGroup::definition(),
                                                    array( 'id' ),
                                                    array( 'branch_id' => $installation->attribute( 'branch_id' ),
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
                                                          $status = eZNetMonitorGroup::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );

        if ( !$installation )
        {
            return $installation;
        }

        return eZPersistentObject::fetchObjectList( eZNetMonitorGroup::definition(),
                                                    array( 'id' ),
                                                    array( 'branch_id' => $installation->attribute( 'branch_id' ),
                                                           'modified' => array( '>', $latestModified ),
                                                           'status' => $status ),
                                                    array( 'modified' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Create monitor result group element
    */
    static function create()
    {
        $resultGroup = new eZNetMonitorGroup( array( 'status' => eZNetMonitorGroup::StatusDraft,
                                                     'created' => time(),
                                                     'creator_id' => eZUser::currentUserID() ) );
        $resultGroup->store();

        return $resultGroup;
    }

    /**
     * Magic function to handle cloning the object
     */
    public function __clone()
    {
        $this->setAttribute( 'id', 0 );
        $this->setAttribute( 'status', eZNetMonitorGroup::StatusDraft );
        $this->setAttribute( 'created', time() );
        $this->setAttribute( 'creator_id', eZUser::currentUserID() );
    }

    /*!
     Get previous time a monitor item from this monitor group was run.

     \return run time timestamp.
     */
    function lastRunTS()
    {
        $db = eZDB::instance();

        $sql = 'SELECT MAX( result.finnished ) as last_run_ts
                FROM ezx_ezpnet_mon_result result,
                     ezx_ezpnet_mon_value value,
                     ezx_ezpnet_mon_item item
                WHERE
                     value.monitor_result_id=result.id AND
                     result.node_id=\'' . $db->escapeString( eZNetUtils::nodeID() ) . '\' AND
                     value.monitor_item_id=item.id AND
                     item.monitor_group_id=\'' . $db->escapeString( $this->attribute( 'id' ) ) . '\'';
        $resultSet = $db->arrayQuery( $sql );

        if ( count( $resultSet ) == 1 )
        {
            $retVal = $resultSet[0]['last_run_ts'];
            if ( $retVal !== null )
            {
                return $retVal;
            }
        }

        return 0;
    }

    /*!
     Fetch list of monitor items to run. If the previous run of this
     monitor group was less than "frequency" ago, return empty array.

     \param offset
     \param limit
     \param lastRunTS, override last run TS. Set to 0 to always fetch monitor items.

     \return array of monitor items.
    */
    function fetchMonitorItemList( $offset = 0,
                                   $limit = 10,
                                   $lastRunTS = false )
    {
        if ( $lastRunTS === false )
        {
            $lastRunTS = $this->lastRunTS();
        }

        // Check if monitors where run within frequency.
        if ( $this->attribute( 'max_frequency' ) != 0 )
        {
            $minDeltaTS = (int)( 3600 / (int) $this->attribute( 'max_frequency' ) );
            $deltaTS = time() - $lastRunTS + $this->DiffTS;
            if ( $deltaTS < $minDeltaTS )
            {
                return array();
            }
        }

        return eZNetMonitorItem::fetchList( $this->attribute( 'id' ),
                                            eZNetMonitorItem::EnabledTrue,
                                            $offset,
                                            $limit );
    }


    /*!
     \static
    */
    static function fetch( $id,
                           $status = eZNetMonitorGroup::StatusPublished,
                           $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetMonitorGroup::definition(),
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
        $resultGroup = eZNetMonitorGroup::fetch( $id,
                                                 eZNetMonitorGroup::StatusDraft,
                                                 $asObject );
        if ( !$resultGroup &&
             $force )
        {
            $resultGroup = eZNetMonitorGroup::fetch( $id,
                                                     eZNetMonitorGroup::StatusPublished,
                                                     $asObject );
            if ( $resultGroup )
            {
                $resultGroup->setAttribute( 'status', eZNetMonitorGroup::StatusDraft );
                $resultGroup->store();
            }
        }

        if ( !$resultGroup )
        {
            return false;
        }
        return $resultGroup;

    }

    /*!
     Fetch latest result by installation ID

     \param installation id

     \return eZNetMonitorResult object
    */
    function fetchLatestResultByInstallationID( $installationID )
    {
        return eZNetMonitorResult::fetchLatestByInstallationGroupID( $installationID,
                                                                     $this->attribute( 'id' ) );
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetMonitorGroup::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetMonitorGroup::fetchDraft( $this->attribute( 'id' ),
                                                     false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static

     Fetch monitor result item count
    */
    static function countByStatus( $status = self::StatusPublished )
    {
        return eZPersistentObject::count( self::definition(), array( 'status' => $status ), 'id' );
    }

    /*!
     \static

     Fetch monitor result item list
    */
    static function fetchList( $offset = 0,
                               $limit = 40,
                               $status = self::StatusPublished,
                               $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( self::definition(),
                                                    null,
                                                    array( 'status' => $status ),
                                                    null,
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch monitor result item list
    */
    static function fetchConditionalList( $condition = false,
                                          $filter = null,
                                          $offset = 0,
                                          $limit = 40,
                                          $status = self::StatusPublished,
                                          $asObject = true )
    {
        $condArray = array( 'status' => $status );
        if ( $condition )
        {
            $condArray = array_merge( $condArray, $condition );
        }

        return eZPersistentObject::fetchObjectList( self::definition(),
                                                    $filter,
                                                    $condArray,
                                                    null,
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     Set TS offset from global TS

     \param \a $diffTS
    */
    function setDiffTS( $diffTS )
    {
        $this->DiffTS = $diffTS;
    }

    var $DiffTS = 0;
}

?>
