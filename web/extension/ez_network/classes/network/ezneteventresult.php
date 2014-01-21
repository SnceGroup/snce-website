<?php
/**
 * File containing eZNetEventResult class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetEventResult ezneteventresult.php
  \brief The class eZNetEventResult does

*/
class eZNetEventResult extends eZPersistentObject
{
    /// Consts
    const Success = 1;
    const Failed = 0;


    /*!
     Constructor
    */
    function eZNetEventResult( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "event_id" => array( 'name' => 'EventID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true,
                                                              'foreign_class' => 'eZNetEvent',
                                                              'foreign_attribute' => 'id',
                                                              'multiplicity' => '0..*' ),
                                         "run_id" => array( 'name' => 'MonitorItemID',
                                                            'datatype' => 'string',
                                                            'default' => 0,
                                                            'required' => true ),
                                         'value' => array( 'name' => 'Value',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                         'success' => array( 'name' => 'Success',
                                                             'datatype' => 'integer',
                                                             'default' => 1,
                                                             'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'description' => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ) ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'event' => 'event' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetEventResult",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_event_result" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'event':
            {
                $retVal = eZNetEvent::fetch( $this->attribute( 'event_id' ) );
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

     Fetch result item value by ID
    */
    static function fetch( $id, $asObject = true )
    {
        return eZNetEventResult::fetchObject( eZNetEventResult::definition(),
                                              null,
                                              array( 'id' => $id ),
                                              $asObject );
    }

    /*!
     \static

     Fetch list by event id
    */
    static function fetchListByEventID( $eventID,
                                        $offset = 0,
                                        $limit = 10,
                                        $asObject = true )
    {
        return eZNetEventResult::fetchObjectList( eZNetEventResult::definition(),
                                                  null,
                                                  array( 'event_id' => $eventID ),
                                                  array( 'created' => 'desc' ),
                                                  null,
                                                  $asObject );
    }

    /*!
     \static

     Fetch list by event id
    */
    static function fetchListByRunID( $runID,
                                      $offset = 0,
                                      $limit = 10,
                                      $asObject = true )
    {
        return eZNetEventResult::fetchObjectList( eZNetEventResult::definition(),
                                                  null,
                                                  array( 'run_id' => $runID ),
                                                  array( 'created' => 'desc' ),
                                                  null,
                                                  $asObject );
    }

    /*!
     \abstract

     Event function. This function is called each time the event is run

     \param $cli object
     \param $script object

     \return true if event should be spawned, false if not.
    */
    function run( $cli, $script )
    {
    }

}

?>
