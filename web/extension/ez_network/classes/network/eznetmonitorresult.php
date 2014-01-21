<?php
/**
 * File containing eZNetMonitorResult class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetMonitorResult eznetmonitorresult.php
  \brief The class eZNetMonitorResult does

*/
class eZNetMonitorResult extends eZPersistentObject
{
    /// Consts
    const PeriodOneWeek = 5;
    const PeriodTwoWeeks = 10;
    const PeriodOneMonth = 15;
    const PeriodTwoMonths = 20;
    const PeriodThreeMonths = 25;
    const PeriodSixMonths = 30;
    const PeriodOneYear = 35;

    /*!
     Constructor
    */
    function eZNetMonitorResult( $row )
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
                                         "installation_id" => array( 'name' => 'InstallationID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetInstallation',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*' ),
                                         'node_id' => array( 'name' => 'NodeID',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => false ),
                                         "started" => array( 'name' => 'Started',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         "modified" => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         "finnished" => array( 'name' => 'Finnished',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'installation' => 'installation',
                                                      'node_name' => 'nodeName',
                                                      'node_ip' => 'nodeIP',
                                                      'value_list' => 'valueList' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetMonitorResult",
                      "sort" => array( "finnished" => "desc" ),
                      "name" => "ezx_ezpnet_mon_result" );
    }

    /*!
     \static

     Check if value array is correct for specified installation

     \param $valueArray
     \param $installation object
     \param $remoteHostID

     \return true if it's OK.
    */
    static function belongsToInstallation( $valueArray, $installation, $remoteHostID )
    {
        return ( $valueArray['installation_id'] == $installation->attribute( 'id' ) );
    }

    /*!
     \static

     Fetch monitor result by ID
    */
    static function fetch( $id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetMonitorResult::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject );
    }

    /*!
     \static
     Fetch latest result by installation and group ID

     \param installation ID
     \param monitor group ID

     \return eZNetMonitorResult
    */
    static function fetchLatestByInstallationGroupID( $installationID,
                                                      $monitorGroupID )
    {
        $db = eZDB::instance();

        $sql = 'SELECT result.* FROM
        ezx_ezpnet_mon_value value,
        ezx_ezpnet_mon_result result,
        ezx_ezpnet_mon_item item
    WHERE result.id = value.monitor_result_id AND
          item.monitor_group_id = \'' . $db->escapeString( $monitorGroupID ) . '\' AND
          value.monitor_item_id = item.id AND
          value.installation_id = \'' . $db->escapeString( $installationID ) . '\'
    ORDER BY result.finnished DESC';

        $resultSet = $db->arrayQuery( $sql,
                                      array( 'limit' => 1,
                                             'offset' => 0 ) );
        if ( $resultSet )
        {
            return new eZNetMonitorResult( $resultSet[0] );
        }

        return false;
    }

    /*!
     \static

     Fetch the latest result.

     \param installation ID

     \return Object of latest result.
     */
    static function fetchLatestByInstallationID( $installationID,
                                                 $asObject = true )
    {
        $result = eZNetMonitorResult::fetchListByInstallationID( $installationID,
                                                                 0,
                                                                 1,
                                                                 $asObject );
        if ( $result )
        {
            return $result[0];
        }
        return false;
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'value_list':
            {
                $retVal = eZNetMonitorResultValue::fetchListByResultID( $this->attribute( 'id' ) );
            } break;

            case 'node_name':
            {
                $retVal = '';
                if ( $installation = $this->attribute( 'installation' ) )
                {
                    if ( $installationInfo = $installation->attribute( 'installation_info' ) )
                    {
                        $retVal = $installationInfo->nodeName( $this->attribute( 'node_id' ) );
                    }
                }
            } break;

            case 'node_ip':
            {
                $retVal = '';
                if ( $installation = $this->attribute( 'installation' ) )
                {
                    if ( $installationInfo = $installation->attribute( 'installation_info' ) )
                    {
                        $retVal = $installationInfo->nodeIP( $this->attribute( 'node_id' ) );
                    }
                }
            } break;

            case 'installation':
            {
                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
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
     Fetch list by installation id

     \param Installation ID
     \param offset
     \param limit
    */
    static function fetchListByInstallationID( $installationID,
                                               $offset = 0,
                                               $limit = 10,
                                               $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetMonitorResult::definition(),
                                                    null,
                                                    array( 'installation_id' => $installationID ),
                                                    array( 'started' => 'desc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Create new result Item.

     \param \a $diffTS ( optional )
    */
    public static function create( $diffTS = 0 )
    {

        $installation = eZNetInstallation::fetchBySiteID( eZNetSOAPSync::hostID() );
        if ( !$installation )
        {
            return false;
        }
        return new eZNetMonitorResult( array( 'installation_id' => $installation->attribute( 'id' ),
                                              'node_id' => eZNetUtils::nodeID(),
                                              'started' => time() + $diffTS ) );
    }

    /*!
     \static

     Removes result (ezx_ezpnet_mon_result) data and its value (ezx_ezpnet_mon_value)
     if it's older than \a $ts

     \param \a $ts Data will be removed if 'finnished' of result less than this $ts
     \param \a $datasetRate This number decides how many old monitor datasets are removed each time the func is run.
               If it's false no limits to remove

     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
           the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function cleanup( $ts, $datasetRate = false )
    {
        $datasetRate = ( ( $datasetRate !== false and !is_numeric( $datasetRate ) ) or ( is_numeric( $datasetRate ) and $datasetRate <= 0 ) ) ? false : $datasetRate;

        $db = eZDB::instance();

        $limit = 50;

        $monitorResultSQL = 'SELECT id
                             FROM   ezx_ezpnet_mon_result
                             WHERE  finnished <= \'' .(int) $ts . '\'';

        // Number of deleted result datasets
        $removedCount = 0;
        $breakRemoving = false;

        // Remove result data and its value, fetching them by $limit to avoid memory overflow.
        while ( 1 )
        {
            $resultSet = $db->arrayQuery( $monitorResultSQL,  array( 'offset' => 0, 'limit' => $limit ) );

            if ( !$resultSet )
            {
                break;
            }

            // Create array for further implode
            $resultArray = array();
            foreach ( $resultSet as $resultItem )
            {
                $resultArray[] = $resultItem['id'];

                if ( $datasetRate !== false )
                {
                    ++$removedCount;
                    // If it exceeded $datasetRate stop removing
                    if ( $removedCount >= $datasetRate )
                    {
                        // We should remove the last portion of data
                        $breakRemoving = true;
                        break;
                    }
                }
            }

            eZNetMonitorResult::removeResultDataByIDList( $resultArray );

            if ( $breakRemoving )
            {
                break;
            }
        }
    }

    /*!
     \static

     Removes result (ezx_ezpnet_mon_result) data and its value (ezx_ezpnet_mon_value) by condition
     By default data that is older than six months only need to store the monitor data from 1 time of the day,
                and data older than 1 year only need to store data 1 time each week.

     \param \a $datasetRate This number decides how many old monitor datasets are removed each time the func is run.
               If it's false no limits to remove

     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
           the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function cleanupOldDataByCondition( $condTSArray = false, $datasetRate = false )
    {
        $datasetRate = ( ( $datasetRate !== false and !is_numeric( $datasetRate ) ) or ( is_numeric( $datasetRate ) and $datasetRate <= 0 ) ) ? false : $datasetRate;

        $db = eZDB::instance();

        $limit = 50;

        $todayTS = time();
        $condTSArray = $condTSArray === false ? array( 'half_year' => array( 'from_ts' => mktime( date( 'H', $todayTS ),
                                                                                                  date( 'i', $todayTS ),
                                                                                                  0,
                                                                                                  date( 'm', $todayTS ) - 12 ),
                                                                             'to_ts'   => mktime( date( 'H', $todayTS ),
                                                                                                  date( 'i', $todayTS ),
                                                                                                  0,
                                                                                                  date( 'm', $todayTS ) - 6 ),
                                                                             'cond'    => array( 'keep_count' => 1,
                                                                                                 'per'        => 60 * 60 * 24 ) ),
                                                       'year'      => array( 'from_ts' => 0,
                                                                             'to_ts'   => mktime( date( 'H', $todayTS ),
                                                                                                  date( 'i', $todayTS ),
                                                                                                  0,
                                                                                                  date( 'm', $todayTS ) - 12 ),
                                                                             'cond'    => array( 'keep_count' => 1,
                                                                                                 'per'        => 60 * 60 * 24 * 7 ) ) )
                                              : $condTSArray ;

        foreach ( $condTSArray as $cond )
        {
            $fromTS     = $cond['from_ts'];
            $toTS       = $cond['to_ts'];
            $keepCount  = $cond['cond']['keep_count'];
            $per        = $cond['cond']['per'];

            /* 1. Fetch monitor data within one period defined in current condition */

            $monitorResultSQL = 'SELECT id, finnished, installation_id
                                 FROM   ezx_ezpnet_mon_result
                                 WHERE finnished <= \'' . $toTS . '\' AND finnished >= \'' . $fromTS . '\'
                                 ORDER BY installation_id, finnished';

            $offset = 0;
            // Create array for further imploding and purging
            $purgeResultArray = array();
            // List if 'finnished' values for each installation
            $previousFinnishedList = array();
            // Number of stored items for each installation
            $storedCountList = array();
            // Number of deleted result datasets
            $removedCount = 0;
            $breakRemoving = false;

            // Remove result data and its value, fetching them by $limit to avoid memory overflow.
            while ( 1 )
            {
                $resultSet = $db->arrayQuery( $monitorResultSQL ,  array( 'offset' => $offset, 'limit' => $limit ) );

                if ( !$resultSet )
                {
                    break;
                }

                /* 2. Go through all fetched datasets and create list of monitor result id which should be purged */

                $resultArray = array();

                foreach ( $resultSet as $resultItem )
                {
                    $itemFinnished = $resultItem['finnished'];
                    $installationID = $resultItem['installation_id'];

                    // Check if current item is not older than $per from previous item
                    if ( isset( $previousFinnishedList[$installationID] ) and $itemFinnished < $previousFinnishedList[$installationID] + $per )
                    {
                        // Check if we should keep current item
                        if ( $storedCountList[$installationID] >= $keepCount )
                        {
                            // Set to remove
                            $resultArray[] = $resultItem['id'];

                            if ( $datasetRate !== false )
                            {
                                ++$removedCount;
                                // If it exceeded the $datasetRate stop removing
                                if ( $removedCount >= $datasetRate )
                                {
                                    // We should remove the last portion of data
                                    $breakRemoving = true;
                                    break;
                                }
                            }
                        }
                        else
                        {
                            // Keep item in DB and increase count of stored items
                            $storedCountList[$installationID] = $storedCountList[$installationID] + 1;
                        }
                    }
                    else
                    {
                        // Store previous value for comparing
                        $previousFinnishedList[$installationID] = $itemFinnished;
                        $storedCountList[$installationID] = 1;
                    }
                }

                $offset += $limit;
                $purgeResultArray[] = $resultArray;

                if ( $breakRemoving )
                {
                    break;
                }
            }

            /* 3. Remove result data and its value from DB by portions */

            foreach ( $purgeResultArray as $purgeArray )
            {
                eZNetMonitorResult::removeResultDataByIDList( $purgeArray );
            }
        }
    }

    /*!
     \private
     \static

     Removes data from (ezx_ezpnet_mon_result) data and its value (ezx_ezpnet_mon_value) by array of monitor result ID
     \param array of monitor result IDs

     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
           the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function removeResultDataByIDList( $purgeResultArray )
    {
        if ( empty( $purgeResultArray ) )
        {
            return;
        }

        $removeResultSQL = "DELETE\n" .
                           "FROM ezx_ezpnet_mon_result\n";

        $removeValueSQL = "DELETE\n" .
                          "FROM ezx_ezpnet_mon_value\n";

        $removeValueSQLFromLog = "DELETE\n" .
                                 "FROM ezx_ezpnet_soap_log\n";

        $db = eZDB::instance();

        $implodedResultID = implode( ', ', $purgeResultArray );

        /* We need to remove data seperately (from 2 tables by 2 sqls) because sometimes result data can be without relation to monitor values.
         * Thus if we try to remove data by one sql, no dataset will be removed and we will get infinite loop.
         */

        // Remove data from monitor result table
        $purgeSQL = $removeResultSQL . 'WHERE id IN ( ' . $implodedResultID . ' )';
        $db->query( $purgeSQL );

        // Remove data from monitor value table
        $purgeSQL = $removeValueSQL . 'WHERE monitor_result_id IN ( ' . $implodedResultID . ' )';
        $db->query( $purgeSQL );

        // Remove value data from soap log
        $purgeSQL = $removeValueSQLFromLog . "WHERE class_name = 'eZNetMonitorResultValue' AND\n" .
                                             "      key_name = 'id' AND\n" .
                                             "      local_value IN ( $implodedResultID )";
        $db->query( $purgeSQL );
    }

    /*!
     \reimp
    */
    function store( $fieldFilters = null )
    {
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        eZPersistentObject::store( $fieldFilters );
    }

    /*!
     \static

     Get period name map
    */
    static function periodNameMap()
    {
        return array( eZNetMonitorResult::PeriodOneWeek => ezi18n( 'crm', '1 week' ),
                      eZNetMonitorResult::PeriodTwoWeeks => ezi18n( 'crm', '2 weeks' ),
                      eZNetMonitorResult::PeriodOneMonth => ezi18n( 'crm', '1 month' ),
                      eZNetMonitorResult::PeriodTwoMonths => ezi18n( 'crm', '2 months' ),
                      eZNetMonitorResult::PeriodThreeMonths => ezi18n( 'crm', '3 months' ),
                      eZNetMonitorResult::PeriodSixMonths => ezi18n( 'crm', '6 months' ),
                      eZNetMonitorResult::PeriodOneYear => ezi18n( 'crm', '1 year' ) );
    }

    /*!
     \static

     Get from TS based on period.

     \param Perdiod

     \return Timestamp
    */
    static function periodTS( $perdiod = eZNetMonitorResult::PeriodOneWeek )
    {
        $oneDay = 24*60*60;
        $ts = time();

        switch( $perdiod )
        {
            case eZNetMonitorResult::PeriodOneWeek:
            default:
            {
                return $ts - ( 7 * $oneDay );
            } break;

            case eZNetMonitorResult::PeriodTwoWeeks:
            {
                return $ts - ( 14 * $oneDay );
            }break;

            case eZNetMonitorResult::PeriodSixMonths:
            case eZNetMonitorResult::PeriodThreeMonths:
            case eZNetMonitorResult::PeriodTwoMonths:
            case eZNetMonitorResult::PeriodOneYear:
            case eZNetMonitorResult::PeriodOneMonth:
            {
                $dateArray = getdate( $ts );
                $dateArray['hours'] = 0;
                $dateArray['minutes'] = 0;
                $dateArray['seconds'] = 0;

                switch( $perdiod )
                {
                    case eZNetMonitorResult::PeriodOneYear:
                    {
                        $monthCount = 12;
                    } break;

                    case eZNetMonitorResult::PeriodSixMonths:
                    {
                        $monthCount = 6;
                    } break;

                    case eZNetMonitorResult::PeriodThreeMonths:
                    {
                        $monthCount = 3;
                    } break;

                    case eZNetMonitorResult::PeriodTwoMonths:
                    {
                        $monthCount = 2;
                    } break;

                    case eZNetMonitorResult::PeriodOneMonth:
                    default:
                    {
                        $monthCount = 1;
                    } break;
                }

                if ( $dateArray['mon'] <= $monthCount )
                {
                    $dateArray['year'] -= 1;
                }
                $dateArray['mon'] = ( $dateArray['mon'] - $monthCount + 11 ) % 12 + 1;

                return mktime( $dateArray['hours'],
                               $dateArray['minutes'],
                               $dateArray['seconds'],
                               $dateArray['mon'],
                               $dateArray['mday'],
                               $dateArray['year'] );
            } break;
        }
    }

    /*!
     Check if all monitor tests was successfull.

     \return true if all where successfull
    */
    function successfull()
    {
        foreach( $this->attribute( 'value_list' ) as $value )
        {
            if ( $value->attribute( 'success' ) == eZNetMonitorResultValue::SuccessFalse )
            {
                return false;
            }
        }

        return true;
    }

    /*!
     Fetch monitor value count

     \return monitor value count
    */
    function valueCount()
    {
        $resultSet = eZNetMonitorResultValue::fetchObjectList( eZNetMonitorResultValue::definition(),
                                                               array(),
                                                               array( 'monitor_result_id' => $this->attribute( 'id' ) ),
                                                               null,
                                                               null,
                                                               false,
                                                               false,
                                                               array( array( 'operation' => 'count(id)',
                                                                             'name' => 'count' ) ) );
        return $resultSet[0]['count'];
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
