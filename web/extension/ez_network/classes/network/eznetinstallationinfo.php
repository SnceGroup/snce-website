<?php
/**
 * File containing eZNetInstallationInfo class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetInstallationInfo eznetinstallationinfo.php
  \brief The class eZNetInstallationInfo does

*/
include_once( 'kernel/common/i18n.php' );

class eZNetInstallationInfo extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    const CreateProjectDisbled = 0;
    const CreateProjectEnabled = 1;

    const ProjectCreatedFalse = 0;
    const ProjectCreatedTrue = 1;

    const PatchRetrievalModeAuto = 0;
    const PatchRetrievalModeeZPatch = 1;
    const PatchRetrievalModeTextDiff = 2;


    /*!
     Constructor
    */
    function eZNetInstallationInfo( $row = array() )
    {
        $this->NetUtils = new eZNetUtils();
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "installation_id" => array( 'name' => 'Name',
                                                                     'datatype' => 'string',
                                                                     'default' => '',
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetInstallation',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*' ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         "local_ip" => array( 'name' => 'LocalIP',
                                                              'datatype' => 'string',
                                                              'default' => '',
                                                              'required' => true ),
                                         "public_ip" => array( 'name' => 'PublicIP',
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
                                         "modifier_id" => array( 'name' => 'ModifierID',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         'options' => array( 'name' => 'Options',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         "extension_version" => array( 'name' => 'ExtensionVersion',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'modifier' => 'modifier',
                                                      'additional_ip_list' => 'additionalIPList',
                                                      'node_ip_map' => 'nodeIPMap',
                                                      'option_array' => 'optionArray',
                                                      'node_id_list' => 'nodeIDList',
                                                      'installation' => 'installation' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetInstallationInfo",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_installation_info" );
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'node_ip_map':
            {
                $retVal = array( '' => $this->attribute( 'local_ip' ) );
                foreach( $this->attribute( 'additional_ip_list' ) as $additionalIP )
                {
                    $retVal[$this->nodeID( $additionalIP )] = $additionalIP;
                }
            } break;

            case 'installation':
            {
                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
            } break;

            case 'node_id_list':
            {
                $retVal = array( $this->nodeID( $this->attribute( 'local_ip' ) ) );
                foreach( $this->attribute( 'additional_ip_list' ) as $extraIP )
                {
                    $retVal[] = $this->nodeID( $extraIP );
                }
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

            case 'additional_ip_list':
            {
                $retVal = explode( ';', $this->option( 'additional_ip_list' ) );
                foreach( $retVal as $key => $value )
                {
                    if ( !$value )
                    {
                        unset( $retVal[$key] );
                    }
                }
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

     Create new eZNetInstallationInfo info
    */
    static function create( $installationID )
    {
        $installationInfo = new eZNetInstallationInfo( array( 'status' => eZNetInstallationInfo::StatusDraft,
                                                              'installation_id' => $installationID,
                                                              'created' => time(),
                                                              'creator_id' => eZUser::currentUserID() ) );
        $installationInfo->setOption( 'create_project', eZNetInstallationInfo::CreateProjectEnabled );
        $installationInfo->setOption( 'patch_retrieval_mode', eZNetInstallationInfo::PatchRetrievalModeeZPatch );
        return $installationInfo;
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetInstallationInfo::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->setAttribute( 'modifier_id', eZUser::currentUserID() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Fetch by installation ID
    */
    static function fetchByInstallationID( $installationID,
                                           $status = eZNetInstallationInfo::StatusPublished,
                                           $modifierSet = false,
                                           $asObject = true )
    {
        $condArray = array( 'installation_id' => $installationID,
                            'status' => $status );
        if ( $modifierSet )
        {
            $condArray['modifier_id'] = array( '!=', 0 );
        }

        return eZNetInstallationInfo::fetchObject( eZNetInstallationInfo::definition(),
                                                   null,
                                                   $condArray,
                                                   $asObject );
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraftByInstallationID( $installationID,
                                                $force = true,
                                                $asObject = true )
    {
        $draft = eZNetInstallationInfo::fetchByInstallationID( $installationID,
                                                               eZNetInstallationInfo::StatusDraft,
                                                               false,
                                                               $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetInstallationInfo::fetchByInstallationID( $installationID,
                                                                   eZNetInstallationInfo::StatusPublished,
                                                                   true,
                                                                   $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetInstallationInfo::StatusDraft );
                $draft->sync();
            }
        }

        return $draft;
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetInstallationInfo::fetchDraft( $this->attribute( 'id' ),
                                                    false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetInstallationInfo::StatusPublished,
                           $asObject = true )
    {
        return eZNetInstallationInfo::fetchObject( eZNetInstallationInfo::definition(),
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
        $draft = eZNetInstallationInfo::fetch( $id,
                                               eZNetInstallationInfo::StatusDraft,
                                               $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetInstallationInfo::fetch( $id,
                                                   eZNetInstallationInfo::StatusPublished,
                                                   $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetInstallationInfo::StatusDraft );
                $draft->sync();
            }
        }

        return $draft;
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
     Get node name from node id

     \param node ID

     \return node name
    */
    function nodeIP( $nodeID )
    {
        $nodeIPMap = $this->attribute( 'node_ip_map' );
        return $nodeIPMap[$nodeID];
    }

    /*!
     Get node name from node id

     \param node ID

     \return node name
    */
    function nodeName( $nodeID )
    {
        if ( $this->option( 'server_name_map' ) )
        {
            $nodeIPMap = $this->attribute( 'node_ip_map' );
            if ( $nodeIP = $this->nodeIP( $nodeID ) )
            {
                foreach( explode( ';', $this->option( 'server_name_map' ) ) as $nameMap )
                {
                    list( $ip, $name ) = explode( ':', $nameMap );
                    if ( $ip == $nodeIP )
                    {
                        return $name;
                    }
                }
            }
        }

        if ( $nodeID == '' )
        {
            return 'Main - ' . $this->attribute( 'local_ip' );
        }
        foreach( $this->attribute( 'additional_ip_list' ) as $additionalIP )
        {
            if ( $nodeID == $this->nodeID( $additionalIP ) )
            {
                return 'Node - ' . $additionalIP;
            }
        }

        return 'Unknown';
    }

    /*!
     Generate NodeID. Node ID for main local ip widll be an empty string.
     For additional IPs, it'll be the md5sum of the additional IP.

     \param local IP

     \return NodeID ( md5 hash )
    */
    function nodeID( $localIP )
    {
        if ( !in_array( $localIP, $this->attribute( 'additional_ip_list' ) ) )
        {
            return '';
        }

        return md5( $localIP );
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
                                                          $status = eZNetInstallation::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        if ( !$installation )
        {
            return false;
        }

        return eZNetInstallationInfo::fetchObjectList( eZNetInstallationInfo::definition(),
                                                       array( 'id' ),
                                                       array( 'installation_id' => $installation->attribute( 'id' ),
                                                              'modified' => array( '>', $latestModified ) ),
                                                       array( 'modified' => 'asc' ),
                                                       array( 'limit' => $limit,
                                                              'offset' => $offset ),
                                                       $asObject );
    }

    /*!
     \static
     \deprecated

     Get patch mode name map
    */
    static function createProjectNameMap()
    {
        return array( eZNetInstallationInfo::CreateProjectDisbled => ezi18n( 'crm', 'No' ),
                      eZNetInstallationInfo::CreateProjectEnabled => ezi18n( 'crm', 'Yes' ) );
    }

    /*!
     \static
     Retrieval mode name map

     \return retrieval mode name map.
    */
    static function patchRetrievalModeNameMap()
    {
        return array( eZNetInstallationInfo::PatchRetrievalModeAuto => ezi18n( 'crm', 'Automatic' ),
                      eZNetInstallationInfo::PatchRetrievalModeeZPatch => ezi18n( 'crm', 'Manual - eZ Patch' ),
                      eZNetInstallationInfo::PatchRetrievalModeTextDiff => ezi18n( 'crm', 'Manual - Text diff' ) );
    }

    /**
     * Sends subscription notification to user
     *
     * @param int $installationID
     * @param int $userID
     * @param bool $status true for subscribed and false for unsubscribed status
     */
    static function sendSubscriptionNotification( $installationID, $userID ,$status )
    {
        require_once( 'kernel/common/template.php' );
        $tpl = templateInit();
        $ini = eZINI::instance( 'network.ini' );

        $mail = new eZMail();
        $emailSender = $ini->variable( 'NotificationSettings', 'Sender' );
        eZMail::extractEmail( $emailSender, $emailSenderAddress, $emailSenderName );
        $mail->setSender( $emailSenderAddress, $emailSenderName );

        $user = eZUser::fetch( $userID );
        $manager = eZUser::currentUser();
        $installation = eZNetInstallation::fetch( $installationID );

        $receiver = null;
        if ( $user instanceof eZUser )
            $receiver = $user->attribute( 'email' );

        $tpl->setVariable( 'installation', $installation );
        $tpl->setVariable( 'status', $status );
        $tpl->setVariable( 'user', $user );
        $tpl->setVariable( 'manager', $manager );

        $body = $tpl->fetch( 'design:crm/subscription_notification_mail.tpl' );
        $subject = $tpl->variable( 'subject' );

        $mail->setSubject( $subject );
        $mail->setBody( $body );

        $mail->setReceiver( $receiver );
        eZMailTransport::send( $mail );
    }

    /*!
     \static
     Send email notification to branch/patch subscribers.

     \param eZNetPatch object
    */
    static function sendPatchNotification( $patch )
    {
        require_once( 'kernel/common/template.php' );
        $tpl = templateInit();
        $ini = eZINI::instance( 'network.ini' );

        $mail = new eZMail();
        $emailSender = $ini->variable( 'NotificationSettings', 'Sender' );
        eZMail::extractEmail( $emailSender, $emailSenderAddress, $emailSenderName );
        $mail->setSender( $emailSenderAddress, $emailSenderName );

        $offset = 0;
        $limit = 50;
        // Fetch patch list or module patch list depending on what $patch is
        while ( $installationList =
                  ( $patch instanceof eZNetPatch ?
                      eZNetInstallation::fetchListByBranchID( $patch->attribute( 'branch_id' ), $offset, $limit ) :
                      ( $patch instanceof eZNetModulePatch ?
                          eZNetModuleInstallation::fetchListByModuleBranchID( $patch->attribute( 'module_branch_id' ), $offset, $limit ) :
                          false
                      )
                  )
              )
        {
            foreach( $installationList as $installation )
            {
                // For module installation objects, fetch the installation object instead since it has all the info we need
                if ( $installation instanceof eZNetModuleInstallation )
                {
                    $installationID = $installation->attribute( 'installation_id' );
                    $installation = eZNetInstallation::fetch( $installationID );
                    if ( !($installation instanceof eZNetInstallation) )
                    {
                        eZDebug::writeError( "No eZNetInstallation object found for ID: $installationID", __METHOD__ );
                        continue;
                    }

                    $branch = $patch->attribute( 'module_branch' );
                    if ( !($branch instanceof eZNetModuleBranch) )
                    {
                        eZDebug::writeError( 'No eZNetModuleBranch object found for module patch ID: ' . $patch->attribute( 'id' ), __METHOD__ );
                        continue;
                    }
                }
                else
                {
                    $branch = $patch->attribute( 'branch' );
                }

                $tpl->setVariable( 'installation', $installation );
                $tpl->setVariable( 'patch', $patch );
                $tpl->setVariable( 'branch', $branch );

                $body = $tpl->fetch( 'design:crm/patch_notification_mail.tpl' );
                $subject = $tpl->variable( 'subject' );

                $mail->setSubject( $subject );
                $mail->setBody( $body );

                // Get portal users associated with installation
                foreach ( eZSPAccessManager::portalUsers( $installation->attribute('id') ) as $portalUser )
                {
                    // Check if portal user can recieve notifications
                    if ( !eZSPAccessManager::hasAccessTo( 'updatenotifications', $installation->attribute('id'), $portalUser->attribute( 'contentobject_id' ) ) )
                        continue;

                    $receiver = $portalUser->attribute( 'email' );

                    eZDebug::writeNotice( 'Sending email ( ' . $subject . ' ) to: ' . $receiver, 'eZNetInstallationInfo::sendPatchNotification()' );

                    $mail->setReceiver( $receiver );
                    eZMailTransport::send( $mail );
                }
            }
            $offset += $limit;
        }
    }
}

?>
