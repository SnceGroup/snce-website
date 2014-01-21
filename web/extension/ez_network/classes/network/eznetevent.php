<?php
/**
 * File containing eZNetEvent class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetEvent eznetevent.php
  \brief The class eZNetEvent does

*/
class eZNetEvent extends eZNetLargeObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    /*!
     Constructor
    */
    function eZNetEvent( $rows = array() )
    {
        $this->eZNetLargeObject( $rows );
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
                                         'status' => array( 'name' => 'VersionStatus',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         "name" => array( 'name' => 'Name',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         'options' => array( 'name' => 'Options',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         'original_filename' => array( 'name' => 'OriginalFilename',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ),
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
                                                              'required' => true ),
                                         'modifier_id' => array( 'name' => 'ModifierID',
                                                                 'datatype' => 'integer',
                                                                 'default' => 0,
                                                                 'required' => true ),
                                         "filedata" => array( 'name' => 'Filedata',
                                                              'datatype' => 'string',
                                                              'default' => '',
                                                              'required' => true ),
                                         "emails" => array( 'name' => 'Emails',
                                                            'datatype' => 'string',
                                                            'default' => '',
                                                            'required' => true ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         'enabled' => array( 'name' => 'Enabled',
                                                             'datatype' => 'integer',
                                                             'default' => 1,
                                                             'required' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'modifier' => 'modifier',
                                                      'email_list' => 'emailList',
                                                      'trigger_draft_list' => 'triggerDraftList',
                                                      'option_array' => 'optionArray' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetEvent",
                      "sort" => array( "name" => "asc" ),
                      "name" => "ezx_ezpnet_event" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'modifier':
            {
                $retVal = eZUser::fetch( $this->attribute( 'modifier_id' ) );
            } break;

            case 'email_list':
            {
                $retVal = explode( ',', $this->attribute( 'emails' ) );
            } break;

            case 'trigger_draft_list':
            {
                $retVal = eZNetTriggerEvent::fetchDraftList( $this->attribute( 'id' ) );
            } break;

            case 'option_array':
            {
                $optionDef = $this->attribute( 'options' );
                $retVal = $optionDef == '' ? array() : unserialize( $optionDef );
            } break;

            default:
            {
                $retVal = eZNetLargeObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \static

     Fetch event list by trigger id

     \param trigger ID
     \param $asObject ( default true )

     \return Event list
    */
    static function fetchListByTriggerID( $triggerID,
                                          $isEnabled = 1,
                                          $asObject = true )
    {
        return eZNetEvent::fetchObjectList( eZNetEvent::definition(),
                                            null,
                                            array( 'trigger_id' => $triggerID,
                                                   'enabled' => $isEnabled ),
                                            null,
                                            null,
                                            $asObject );
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

     Create new event item
    */
    static function create()
    {
        $event = new eZNetEvent( array( 'status' => eZNetEvent::StatusDraft,
                                        'created' => time(),
                                        'creator_id' => eZUser::currentUserID() ) );
        return $event;
    }

    /*!
     \static

     Fetch list of Network events.
    */
    static function fetchList( $offset = 0,
                               $limit = 10,
                               $status = eZNetEvent::StatusPublished,
                               $asObject = true )
    {
        return eZNetEvent::fetchObjectList( eZNetEvent::definition(),
                                            null,
                                            array( 'status' => $status ),
                                            array( 'id' => 'desc' ),
                                            array( 'limit' => $limit,
                                                   'offset' => $offset ),
                                            $asObject );
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetEvent::StatusPublished,
                           $asObject = true )
    {
        return eZNetEvent::fetchObject( eZNetEvent::definition(),
                                        null,
                                        array( 'id' => $id,
                                               'status' => $status ),
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
        $draft = eZNetEvent::fetch( $id,
                                      eZNetEvent::StatusDraft,
                                      $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetEvent::fetch( $id,
                                          eZNetEvent::StatusPublished,
                                          $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetEvent::StatusDraft );
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
        foreach( $this->attribute( 'trigger_draft_list' ) as $triggerLink )
        {
            $triggerLink->publish();
        }

        $this->setAttribute( 'status', eZNetEvent::StatusPublished );
        $this->setAttribute( 'modifier_id', eZUser::currentUserID() );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetEvent::fetchDraft( $this->attribute( 'id' ),
                                           false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     Execute event

     \param trigger result
    */
    function execute( $triggerResult )
    {
        // Create possible notification event.
        $event = eZNotificationEvent::create( 'eznettriggerevent',
                                              array( 'event_id' => $this->attribute( 'id' ),
                                                     'trigger_result_id' => $triggerResult->attribute( 'id' ) ) );
        $event->store();

        if ( $functionData = substr( trim( $this->attribute( 'filedata' ) ), 5, -2 ) )
        {
            if ( $eventResult = eval( $functionData ) )
            {
                $eventResult->setAttribute( 'event_id', $event->attribute( 'id' ) );
                $eventResult->setAttribute( 'created', time() );
                $eventResult->setAttribute( 'run_id', $triggerResult->attribute( 'run_id' ) );
                $result = $eventResult->run( $cli, $script );
                $eventResult->store();
                if ( $result )
                {
                    $innerOffset = 0;
                    while( $eventList = eZNetEvent::fetchListByTriggerID() )
                    {
                        foreach( $eventList as $event )
                        {
                            $event->execute( $triggerResult );
                        }
                        $innerOffset += $limit;
                    }
                }
            }
        }
    }
}

?>
