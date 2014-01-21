<?php
/**
 * File containing eZNetMonitorResultValue class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetMonitorResultValue eznetmonitorresultvalue.php
  \brief The class eZNetMonitorResultValue does

*/
class eZNetMonitorResultValue extends eZPersistentObject
{
    /// Consts
    const SuccessFalse = 0;
    const SuccessTrue = 1;

    /*!
     Constructor
    */
    function eZNetMonitorResultValue( $row = array() )
    {
        $this->eZPersistentObject( $row );

        // Initialize custom table
        eZNetUtils::createTable( $this );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "monitor_result_id" => array( 'name' => 'MonitorResultID',
                                                                       'datatype' => 'integer',
                                                                       'default' => 0,
                                                                       'required' => true,
                                                                       'foreign_class' => 'eZNetMonitorResult',
                                                                       'foreign_attribute' => 'id',
                                                                       'multiplicity' => '0..*' ),
                                         "monitor_item_id" => array( 'name' => 'MonitorItemID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetMonitorItem',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '0..*' ),
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
                                         'value' => array( 'name' => 'Value',
                                                           'datatype' => 'string', // NB! 255 limit enforced in ->store()
                                                           'default' => '',
                                                           'required' => true ),
                                         'success' => array( 'name' => 'Success',
                                                             'datatype' => 'integer',
                                                             'default' => eZNetMonitorResultValue::SuccessTrue,
                                                             'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         "modified" => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'description' => array( 'name' => 'Description',
                                                                 'datatype' => 'longtext',
                                                                 'default' => '',
                                                                 'required' => false ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'monitor_item' => 'monitorItem',
                                                      'monitor_result' => 'monitorResult' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetMonitorResultValue",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_mon_value" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'monitor_item':
            {
                $retVal = eZNetMonitorItem::fetch( $this->attribute( 'monitor_item_id' ) );
            } break;

            case 'monitor_result':
            {
                $retVal = eZNetMonitorResult::fetch( $this->attribute( 'monitor_result_id' ) );
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

     Check if value array is correct for specified installation

     \param $valueArray
     \param $installation object
     \param $remoteHostID

     \return true if it's OK.
    */
    static function belongsToInstallation( $valueArray, $installation, $remoteHostID )
    {
        $localResultID = eZNetSOAPLog::translateForeignKey( $remoteHostID,
                                                            $valueArray['monitor_result_id'],
                                                            'eZNetMonitorResult',
                                                            'id' );
        return ( $valueArray['monitor_result_id'] == $localResultID );
    }

    /*!
     \static

     Fetch result item value by ID
    */
    static function fetch( $id, $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetMonitorResultValue::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject );
    }

    /*!
     \static

     Fetch list by installation and item id
    */
    static function fetchListByInstallationAndItemID( $installationID,
                                                      $itemID,
                                                      $offset = 0,
                                                      $limit = 10,
                                                      $allNodes = false,
                                                      $asObject = true )
    {
        $nodeID = false;
        if ( $allNodes === false )
        {
            $nodeID = '';
        }
        else if ( $allNodes !== true )
        {
            $nodeID = $allNodes;
        }

        $condArray = array( 'installation_id' => $installationID,
                            'monitor_item_id' => $itemID );

        if ( $nodeID !== false )
        {
            $condArray['node_id'] = $nodeID;
        }

        return eZNetMonitorResultValue::fetchObjectList( eZNetMonitorResultValue::definition(),
                                                         null,
                                                         $condArray,
                                                         array( 'created' => 'desc' ),
                                                         array( 'limit' => $limit,
                                                                'offset' => $offset ),
                                                         $asObject );
    }

    /*!
     \static

     Fetch count by installation and item id
    */
    static function fetchCountByInstallationAndItemID( $installationID,
                                                       $itemID )
    {
        $resultSet = eZNetMonitorResultValue::fetchObjectList( eZNetMonitorResultValue::definition(),
                                                               array(),
                                                               array( 'monitor_item_id' => $itemID,
                                                                      'installation_id' => $installationID ),
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

     Fetch list by result id.

     \param result id.

     \return list of result values
    */
    static function fetchListByResultID( $resultID,
                                         $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetMonitorResultValue::definition(),
                                                    null,
                                                    array( 'monitor_result_id' => $resultID ),
                                                    null,
                                                    null,
                                                    $asObject );
    }

    /*!
     \abstract

     Monitor function. This function is called each time the monitor is run

     \param $cli object
     \param $script object
    */
    function run( $cli, $script )
    {
    }

    /**** Custom table used by monitor result value to store monitor values. ****/

    /* customTableDefinition() must return arrays corrosponding to the eZDbSchema
     * format.
     *
     * Example:
     * array ( 'ezx_ezpnet_monitem_oc' => array ( 'name' => 'ezx_ezpnet_monitem_oc',
     *                                            'fields' => array ( 'id' => array ( 'type' => 'auto_increment',
     *                                                                                'default' => 'false' ),
     *                                                                'count' => array ( 'length' => 11,
     *                                                                                   'type' => 'int',
     *                                                                                   'not_null' => '1',
     *                                                                                   'default' => 0 ) ),
     *                                            'indexes' => array ( 'PRIMARY' => array ( 'type' => 'primary',
     *                                                                                      'fields' => array ( 0 => 'id' ) ) ) ) )
     *
     *
     */

    /*!
     Return custom table definition. False if no table exists.
    */
    function customTableDefinition()
    {
        return false;
    }

    /*!
     \reimp
    */
    function store( $fieldFilters = null )
    {
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        if ( !$this->attribute( 'installation_id' ) )
        {
            if ( $monitorResult = $this->attribute( 'monitor_result' ) )
            {
                $this->setAttribute( 'installation_id', $monitorResult->attribute( 'installation_id' ) );
                $this->setAttribute( 'node_id', $monitorResult->attribute( 'node_id' ) );
            }
        }

        // Enforce 255 length limit on value
        if ( strlen( $this->attribute( 'value' ) ) >= 255 )
            $this->setAttribute( 'value', substr( $this->attribute( 'value' ), 0, 254 ) );

        eZNetLargeObject::storeObject( $this, $fieldFilters );
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
