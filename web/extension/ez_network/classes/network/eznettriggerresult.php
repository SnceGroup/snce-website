<?php
/**
 * File containing eZNetTriggerResult class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetTriggerResult eznettriggerresult.php
  \brief The class eZNetTriggerResult does

*/
class eZNetTriggerResult extends eZPersistentObject
{
    /// Consts
    const Success = 1;
    const Failed = 0;


    /*!
     Constructor
    */
    function eZNetTriggerResult( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

        static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "trigger_id" => array( 'name' => 'TriggerID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true,
                                                                'foreign_class' => 'eZNetTrigger',
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
                      "function_attributes" => array( 'trigger' => 'trigger' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetTriggerResult",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_trigger_result" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'trigger':
            {
                $retVal = eZNetTrigger::fetch( $this->attribute( 'trigger_id' ) );
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
        return eZNetTriggerResult::fetchObject( eZNetTriggerResult::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject );
    }

    /*!
     \static

     Fetch list by trigger id
    */
    static function fetchListByTriggerID( $triggerID,
                                          $offset = 0,
                                          $limit = 10,
                                          $asObject = true )
    {
        return eZNetTriggerResult::fetchObjectList( eZNetTriggerResult::definition(),
                                                    null,
                                                    array( 'trigger_id' => $triggerID ),
                                                    array( 'created' => 'desc' ),
                                                    null,
                                                    $asObject );
    }

    /*!
     \static

     Fetch list by trigger id
    */
    static function fetchListByRunID( $runID,
                                      $offset = 0,
                                      $limit = 10,
                                      $asObject = true )
    {
        return eZNetTriggerResult::fetchObjectList( eZNetTriggerResult::definition(),
                                                    null,
                                                    array( 'run_id' => $runID ),
                                                    array( 'created' => 'desc' ),
                                                    null,
                                                    $asObject );
    }

    /*!
     \abstract

     Trigger function. This function is called each time the trigger is run

     \param $cli object
     \param $script object

     \return true if event should be spawned, false if not.
    */
    function run( $cli, $script )
    {
    }

}

?>
