<?php
/**
 * File containing eZNetTrigger class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetTrigger eznettrigger.php
  \brief The class eZNetTrigger does

*/
class eZNetTrigger extends eZNetLargeObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    /*!
     Constructor
    */
    function eZNetTrigger( $rows = array() )
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
                                                      'option_array' => 'optionArray',
                                                      'has_events' => 'hasEvents',
                                                      'event_list' => 'eventList' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetTrigger",
                      "sort" => array( "name" => "asc" ),
                      "name" => "ezx_ezpnet_trigger" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'has_events':
            {
                $retVal = ( count( $this->attribute( 'has_events' ) ) != 0 );
            } break;

            case 'event_list':
            {
                $retVal = eZNetTriggerEvent::fetchListByTriggerID( $this->attribute( 'id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'modifier':
            {
                $retVal = eZUser::fetch( $this->attribute( 'modifier_id' ) );
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

     Create new trigger item
    */
    static function create()
    {
        $trigger = new eZNetTrigger( array( 'status' => eZNetTrigger::StatusDraft,
                                            'created' => time(),
                                            'creator_id' => eZUser::currentUserID() ) );
        return $trigger;
    }

    /*!
     \static

     Fetch list of Network triggers.
    */
    static function fetchList( $offset = 0,
                               $limit = 10,
                               $status = eZNetTrigger::StatusPublished,
                               $asObject = true )
    {
        return eZNetTrigger::fetchObjectList( eZNetTrigger::definition(),
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
                           $status = eZNetTrigger::StatusPublished,
                           $asObject = true )
    {
        return eZNetTrigger::fetchObject( eZNetTrigger::definition(),
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
        $draft = eZNetTrigger::fetch( $id,
                                      eZNetTrigger::StatusDraft,
                                      $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetTrigger::fetch( $id,
                                          eZNetTrigger::StatusPublished,
                                          $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetTrigger::StatusDraft );
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
        $this->setAttribute( 'status', eZNetTrigger::StatusPublished );
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
        $draft = eZNetTrigger::fetchDraft( $this->attribute( 'id' ),
                                           false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static
     Run all triggers, and spawn events where triggers are activated.

     \param RunID, unique for this execution.

     \return number of events triggered
    */
    static function executeAllTriggers( $runID )
    {
        $eventCount = 0;

        $offset = 0;
        $limit = 5;
        while( $triggerList = eZNetTrigger::fetchList( $offset,
                                                       $limit ) )
        {
            foreach( $triggerList as $trigger )
            {
                $functionData = substr( trim( base64_decode( $trigger->attribute( 'filedata' ) ) ), 5, -2 );
                if ( !$functionData )
                {
                    continue;
                }

                if ( $triggerResult = eval( $functionData ) )
                {
                    $triggerResult->setAttribute( 'trigger_id', $trigger->attribute( 'id' ) );
                    $triggerResult->setAttribute( 'created', time() );
                    $triggerResult->setAttribute( 'run_id', $runID );
                    $result = $triggerResult->run( $cli, $script );
                    $triggerResult->setAttribute( 'success', $result ? eZNetTriggerResult::Success : eZNetTriggerResult::Failed );
                    $triggerResult->store();
                    if ( !$result )
                    {
                        $innerOffset = 0;
                        while( $eventLinkList = eZNetTriggerEvent::fetchListByTriggerID( $trigger->attribute( 'id' ),
                                                                                         $innerOffset,
                                                                                         $limit ) )
                        {
                            foreach( $eventLinkList as $eventLink )
                            {
                                if ( $event = $eventLink->attribute( 'event' ) )
                                {
                                    $event->execute( $triggerResult );
                                    ++$eventCount;
                                }
                            }
                            $innerOffset += $limit;
                        }
                    }
                }
            }
            $offset += $limit;
        }

        return $eventCount;
    }
}

?>
