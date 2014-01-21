<?php
/**
 * File containing eZNetTriggerEvent class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetTriggerEvent eznettriggerevent.php
  \brief Trigger - Event relation

*/
class eZNetTriggerEvent extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    /*!
     Constructor
    */
    function eZNetTriggerEvent( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         "trigger_id" => array( 'name' => 'TriggerID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true,
                                                                'foreign_class' => 'eZNetTrigger',
                                                                'foreign_attribute' => 'id',
                                                                'multiplicity' => '1..*' ),
                                         "event_id" => array( 'name' => 'EventID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true,
                                                              'foreign_override_class' => 'eZNetEvent',
                                                              'foreign_override_attribute' => 'id',
                                                              'multiplicity' => '1..*' ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'trigger' => 'trigger',
                                                      'event' => 'event' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetTriggerEvent",
                      "sort" => array( "created" => "asc" ),
                      "name" => "ezx_ezpnet_trigger_event" );
    }

    /*!
     \static
     Fetch list by trigger ID

     \param trigger ID
    */
    static function fetchListByTriggerID( $triggerID,
                                          $offset = 0,
                                          $limit = 10,
                                          $status = eZNetTriggerEvent::StatusPublished,
                                          $asObject = true )
    {
        return eZNetTriggerEvent::fetchObjectList( eZNetTriggerEvent::definition(),
                                                   null,
                                                   array( 'trigger_id' => $triggerID,
                                                          'status' => $status ),
                                                   null,
                                                   array( 'limit' => $limit,
                                                          'offset' => $offset ),
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
            case 'trigger':
            {
                $retVal = eZNetTrigger::fetch( $this->attribute( 'trigger_id' ) );
            } break;

            case 'event':
            {
                $retVal = eZNetEvent::fetch( $this->attribute( 'event_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
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

     Create new patch item

     \param Trigger ID
     \param Event ID

     \return Trigger Event relation
    */
    static function create( $triggerID,
                            $eventID )
    {

        $triggerEvent = new eZNetTriggerEvent( array( 'status' => eZNetTriggerEvent::StatusDraft,
                                                      'event_id' => $eventID,
                                                      'trigger_id' => $triggerID,
                                                      'created' => time(),
                                                      'creator_id' => eZUser::currentUserID() ) );
        $triggerEvent->store();
        return $triggerEvent;
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetTriggerEvent::StatusPublished,
                           $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetTriggerEvent::definition(),
                                                null,
                                                array( 'id' => $id,
                                                       'status' => $status ),
                                                $asObject );
    }

    /*!
     \static

     Fetch draft list. If no draft exist, create draft from existing published object

     \param Event ID
    */
    static function fetchDraftList( $eventID,
                                    $asObject = true )
    {
        $draftList = eZNetTriggerEvent::fetchList( $eventID,
                                                   0,
                                                   1000,
                                                   eZNetTriggerEvent::StatusDraft );
        $publishList = eZNetTriggerEvent::fetchList( $eventID,
                                                     0,
                                                     1000,
                                                     eZNetTriggerEvent::StatusPublished );
        $draftIDList = array();
        foreach( $draftList as $draft )
        {
            $draftIDList[] = $draft->attribute( 'id' );
        }

        // Create draft from published item, if draft does not exist. Ignore if draft already exists.
        foreach( $publishList as $published )
        {
            if ( !in_array( $published->attribute( 'id' ), $draftIDList ) )
            {
                $draftList[] = eZNetTriggerEvent::fetchDraft( $published->attribute( 'id' ) );
            }
        }

        return $draftList;
    }

    /*!
     \static

     Fetch eZNetTriggerEvent by trigger and event ID

     \param trigger ID
     \param event ID
     \param status
     \param asObject

     \return eZNetTriggerEvent object
    */
    static function fetchByTriggerEventID( $triggerID,
                                           $eventID,
                                           $status = eZNetTriggerEvent::StatusPublished,
                                           $asObject = true )
    {
        $condArray = array( 'trigger_id' => $triggerID,
                            'event_id' => $eventID );
        if ( $status !== false )
        {
            $condArray['status'] = $status;
        }

        return eZNetTriggerEvent::fetchObject( eZNetTriggerEvent::definition(),
                                               null,
                                               $condArray,
                                               $asObject );
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraft( $id,
                                $force = true,
                                $asObject = true )
    {
        $draft = eZNetTriggerEvent::fetch( $id,
                                           eZNetTriggerEvent::StatusDraft,
                                           $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetTriggerEvent::fetch( $id,
                                               eZNetTriggerEvent::StatusPublished,
                                               $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetTriggerEvent::StatusDraft );
                $draft->sync();
            }
        }

        return $draft;
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetTriggerEvent::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetTriggerEvent::fetchDraft( $this->attribute( 'id' ),
                                                false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static

     Fetch list of Network Event.

     \param Customer ID
    */
    static function fetchList( $eventID = false,
                               $offset = 0,
                               $limit = 100,
                               $status = eZNetTriggerEvent::StatusPublished,
                               $additionalConditions = array(),
                               $asObject = true )
    {
        $condArray = array( 'status' => $status );
        if ( $eventID !== false )
        {
            $condArray['event_id'] = $eventID;
        }

        $condArray = array_merge( $condArray, $additionalConditions );

        return eZPersistentObject::fetchObjectList( eZNetTriggerEvent::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'id' => 'desc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Remove link object

     \param Link ID
    */
    static function removeLink( $id )
    {
        eZPersistentObject::removeObject( eZNetTriggerEvent::definition(),
                                          array( 'id' => $id ) );
    }

    /*!
     \static

     Remove trigger event link by event id

     \param Event ID
    */
    static function removeByEventID( $eventID )
    {
        eZPersistentObject::removeObject( eZNetTriggerEvent::definition(),
                                          array( 'event_id' => $eventID ) );
    }

    /*!
     \static

     Remove trigger event link by trigger id

     \param Trigger ID
    */
    static function removeByTriggerID( $triggerID )
    {
        eZPersistentObject::removeObject( eZNetTriggerEvent::definition(),
                                          array( 'trigger_id' => $triggerID ) );
    }

    /*!
     \static

     Remove trigger event link by trigger and event id

     \param Trigger ID
     \param Event ID
    */
    static function removeByTriggerEventID( $triggerID,
                                            $eventID )
    {
        eZPersistentObject::removeObject( eZNetTriggerEvent::definition(),
                                          array( 'event_id' => $eventID,
                                                 'trigger_id' => $triggerID ) );
    }
}

?>
