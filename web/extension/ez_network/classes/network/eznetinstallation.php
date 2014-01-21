<?php
/**
 * File containing eZNetInstallation class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetInstallation eznetinstallation.php
  \brief The class eZNetInstallation does

*/
include_once( 'kernel/common/i18n.php' );

class eZNetInstallation extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    const IsEnabledFalse = 0;
    const IsEnabledTrue = 1;

    const MultiDBEnabledFalse = 0;
    const MultiDBEnabledTrue = 1;

    const ModeAutomatic = 0;
    const ModeSemi = 1;
    const ModeManual = 2;

    /*!
     Constructor
    */
    function eZNetInstallation( $row = array() )
    {
        $this->NetUtils = new eZNetUtils();
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
                                         "name" => array( 'name' => 'Name',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "branch_id" => array( 'name' => 'eZNetBranchID',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true,
                                                               'foreign_class' => 'eZNetBranch',
                                                               'foreign_attribute' => 'id',
                                                               'multiplicity' => '1..*' ),
                                         "customer_id" => array( 'name' => 'CustomerID',
                                                                 'datatype' => 'integer',
                                                                 'default' => 0,
                                                                 'required' => true,
                                                                 'foreign_override_class' => 'eZContentObject',
                                                                 'foreign_override_attribute' => 'id',
                                                                 'multiplicity' => '1..*' ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         "remote_id" => array( 'name' => 'RemoteID',
                                                               'datatype' => 'string',
                                                               'default' => '',
                                                               'required' => true ),
                                         'is_enabled' => array( 'name' => 'IsEnabled',
                                                                'datatype' => 'integer',
                                                                'default' => eZNetInstallation::IsEnabledTrue,
                                                                'required' => true ),
                                         'multi_db_enabled' => array( 'name' => 'MultipleDBEnabled',
                                                                      'datatype' => 'integer',
                                                                      'default' => eZNetInstallation::MultiDBEnabledFalse,
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
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => false ),
                                         'object_count' => array( 'name' => 'ObjectCount',
                                                                  'datatype' => 'string',
                                                                  'default' => '',
                                                                  'required' => false ),
                                         'patch_mode' => array( 'name' => 'PatchMode',
                                                                'datatype' => 'integer',
                                                                'default' => self::ModeManual,
                                                                'required' => true ),
                                         'email_notifications' => array( 'name' => 'EmailNotificationList',
                                                                         'datatype' => 'string',
                                                                         'default' => '',
                                                                         'required' => false ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'creator_object' => 'creator_object',
                                                      'branch' => 'branch',
                                                      'php_version' => 'phpVersion',
                                                      'patch_mode_name' => 'patchModeName',
                                                      'monitor_group_list' => 'monitorGroupList',
                                                      'customer' => 'customer',
                                                      'is_multi_db_enabled' => 'isMultiDBEnabled',
                                                      'result_success' => 'resultSuccess',
                                                      'awaiting_patch_count' => 'awaitingPatchCount',
                                                      'agreement_link_list' => 'agreementLinkList',
                                                      'agreement_link_count' => 'agreementLinkCount',
                                                      'installation_info' => 'installationInfo',
                                                      'email_notification_list' => 'emailNotificationList', // deprecated
                                                      'valid_agreement_link_list' => 'validAgreementLinkList',
                                                      'last_agreement' => false,
                                                      'is_cluster' => 'isCluster',
                                                      'top_level_agreement_link' => 'topLevelAgreementLink',
                                                      'module_branch_list' => 'moduleBranchList',
                                                      'update_status' => 'updateStatus',
                                                      'system_info' => 'monitorList' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetInstallation",
                      "sort" => array( "name" => "asc" ),
                      "name" => "ezx_ezpnet_installation" );
    }

    /*!
     \static
     Fetch installation object for current installation

     \return eZNetInstallation object
    */
    static function fetchCurrent()
    {
        return eZNetInstallation::fetchBySiteID( eZNetUtils::hostID() );
    }

    /*!
     \static
     Get installation count by status

     \param status ( optional )

     \return total installation count.
    */
    static function countByStatus( $status = eZNetInstallation::StatusPublished,
                           $isEnbled = eZNetInstallation::IsEnabledTrue )
    {
        $condArray = array( 'status' => $status,
                            'is_enabled' => $isEnbled );
        $resultSet = eZNetInstallation::fetchObjectList( eZNetInstallation::definition(),
                                                         array(),
                                                         $condArray,
                                                         null,
                                                         null,
                                                         false,
                                                         false,
                                                         array( array( 'operation' => 'count(id)',
                                                                       'name' => 'count' ) ) );
        return $resultSet[0]['count'];
    }

    /*!
     Add module installation

     \param Module branch id
    */
    function addModule( $moduleBranchID )
    {
        // republishing branch to make sure it's updated, and distributed to the client.
        $branch = eZNetModuleBranch::fetch( $moduleBranchID );
        $branch->publish();

        // Create new module installation, or enabled if it is already existing
        $moduleInstallation = eZNetModuleInstallation::fetchByModuleInstallationID( $moduleBranchID,
                                                                                    $this->attribute( 'id' ),
                                                                                    eZNetModuleInstallation::EnabledTrue );
        if ( $moduleInstallation )
        {
            $moduleInstallation->setAttribute( 'enabled', eZNetModuleInstallation::EnabledTrue );
            $moduleInstallation->setAttribute( 'modified', time() );
            $moduleInstallation->publish();
        }
        else
        {
            $moduleInstallation = eZNetModuleInstallation::create( $moduleBranchID,
                                                                   $this->attribute( 'id' ) );
            $moduleInstallation->publish();
        }
    }

    /*!
     Remove all modules from installation
    */
    function disableAllModules()
    {
        $offset = 0;
        $limit = 10;
        while( $moduleInstallationList = eZNetModuleInstallation::fetchListByInstallationID( $this->attribute( 'id' ),
                                                                                             $offset,
                                                                                             $limit,
                                                                                             array( array( eZNetModuleInstallation::StatusDraft,
                                                                                                           eZNetModuleInstallation::StatusPublished ) ) ) )
        {
            $offset += $limit;
            foreach( $moduleInstallationList as $moduleInstallation )
            {
                $moduleInstallation->setAttribute( 'enabled', eZNetModuleInstallation::EnabledFalse );
                $moduleInstallation->setAttribute( 'modified', time() );
                $moduleInstallation->sync();
            }
        }

    }

    /*!
     \static
     Fetch item by customer ID

     \param $customerID Customer id
    */
    static function fetchByCustomerID ( $customerID,
                                        $status = eZNetInstallation::StatusPublished,
                                        $isEnbled = eZNetInstallation::IsEnabledTrue,
                                        $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                null,
                                                array( 'status' => $status,
                                                       'customer_id' => $customerID,
                                                       'is_enabled' => $isEnbled ),
                                                $asObject );
    }

    /*!
     \static

     Fetch list of latest items, based on host ID, and latest ID provided.
    */
    static function fetchListByRemoteIDAndLatestID( $remoteID,
                                                    $latestID,
                                                    $offset = 0,
                                                    $limit = 20,
                                                    $asObject = true,
                                                    $status = eZNetInstallation::StatusPublished,
                                                    $isEnabled = eZNetInstallation::IsEnabledTrue )
    {
        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    array( 'id' ),
                                                    array( 'remote_id' => $remoteID,
                                                           'status' => $status,
                                                           'is_enabled' => $isEnabled,
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
                                                          $status = eZNetInstallation::StatusPublished,
                                                          $isEnabled = eZNetInstallation::IsEnabledTrue )
    {
        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    array( 'id' ),
                                                    array( 'remote_id' => $installationSiteID,
                                                           'modified' => array( '>', $latestModified ),
                                                           'is_enabled' => $isEnabled,
                                                           'status' => $status ),
                                                    array( 'modified' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch item by Site ID ( Remote ID )
    */
    static function fetchBySiteID( $remoteID,
                                   $status = eZNetInstallation::StatusPublished,
                                   $isEnabled = eZNetInstallation::IsEnabledTrue,
                                   $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetInstallation::definition(),
                                                null,
                                                array( 'status' => $status,
                                                       'is_enabled' => $isEnabled,
                                                       'remote_id' => $remoteID ),
                                                $asObject );
    }

    /*!
     \static

     Fetch installation ID list by customer ID
    */
    static function fetchIDListByCustomerID( $customerID,
                                             $status = eZNetInstallation::StatusPublished,
                                             $isEnabled = eZNetInstallation::IsEnabledTrue )
    {
        $installationList = eZNetInstallation::fetchListByCustomerID( $customerID,
                                                                      $status,
                                                                      $isEnabled,
                                                                      false );
        $installationIDList = array();
        foreach( $installationList as $installation )
        {
            $installationIDList[] = $installation['id'];
        }

        return $installationIDList;
    }

    /*!
     \static

     \param $installationID
     \param $customerID
    */
    static function belongsToCustomer( $installationID,
                                       $customerID,
                                       $status = eZNetInstallation::StatusPublished,
                                       $isEnabled = eZNetInstallation::IsEnabledTrue )
    {
        return eZPersistentObject::fetchObject( eZNetInstallation::definition(),
                                                null,
                                                array( 'id' => $installationID,
                                                       'is_enabled' => $isEnabled,
                                                       'customer_id' => $customerID,
                                                       'status' => $status ),
                                                true );
    }


    /*!
     \static

     Fetch installation list by customer ID
    */
    static function fetchListByCustomerID( $customerID,
                                           $status = eZNetInstallation::StatusPublished,
                                           $isEnabled = eZNetInstallation::IsEnabledTrue,
                                           $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    null,
                                                    array( 'status' => $status,
                                                           'is_enabled' => $isEnabled,
                                                           'customer_id' => $customerID ),
                                                    null,
                                                    null,
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
            case 'php_version':
            {
                $branch = $this->attribute( 'branch' );
                // Set default php_version
                $retVal = 'PHP4';
                // If branch exists try to fetch version from it
                if ( $branch )
                {
                    $branchName = $branch->attribute( 'name' );

                    if ( preg_match( '/^.*(4\.[0-9]).*/', $branchName ) )
                    {
                        $retVal = 'PHP5';
                    }
                    if ( preg_match( '/^.*(3\.[0-9]).*/', $branchName ) )
                    {
                        $retVal = 'PHP4';
                    }
                }

            } break;

            case 'email_notification_list':
            {
                // DEPRECATED: options of installation_info is used for this
                $retVal = array();
                $emailArray = explode( ',', $this->attribute( 'email_notifications' ) );
                foreach( $emailArray as $email )
                {
                    $retVal[] = trim( $email );
                }
            } break;

            case 'top_level_agreement_link':
            {
                // Calculate agreement priority
                $networkAgreementPlacement = eZINI::instance( 'network.ini' )->variable( 'AgreementSettings', 'AgreementPlacement' );
                $params = array( 'ClassFilter' => array( 'network_agreement' ),
                                 'ClassFilterType' => array( 'include' ),
                                 'SortBy' => array( 'priority', true ),
                                 );

                $agreementPriorityList = array();
                $agreements = eZContentObjectTreeNode::subTreeByNodeID( $params, $networkAgreementPlacement );
                if ( is_array( $agreements ) )
                {
                    foreach( $agreements as $agreement )
                    {
                        $dataMap = $agreement->dataMap();
                        $agreementPriorityList[ $dataMap[ 'identifier']->content() ] = $agreement->Priority;
                    }
                }

                // Find most prioritized agreement
                $topAgreementLink = false;
                $topLevel = false;
                foreach( $this->attribute( 'valid_agreement_link_list' ) as $agreementLink )
                {
                    $agreementObject = $agreementLink->attribute( 'agreement' );
                    if ( $agreementObject instanceOf eZContentObject )
                    {
                        $agreementDataMap = $agreementObject->attribute( 'data_map' );
                        if ( isset( $agreementDataMap['identifier'] ) )
                        {
                            $agreementLevel = $agreementPriorityList[$agreementDataMap['identifier']->attribute( 'value' )];
                        }
                    }
                    else
                    {
                        continue;
                    }
                    if ( $topLevel === false ||
                         $topLevel > $agreementLevel )

                    {
                        $topLevel = $agreementLevel;
                        $topAgreementLink = $agreementLink;
                    }
                }

                $retVal = $topAgreementLink;
            } break;

            case 'is_cluster':
            {
                $retVal = false;

                $installationInfo = $this->attribute( 'installation_info' );
                if ( $installationInfo )
                {
                    $retVal = ( count( $installationInfo->attribute( 'additional_ip_list' ) ) > 0 );
                }
            } break;

            case 'valid_agreement_link_list':
            {
                $retVal = eZNetInstallationAgreement::fetchList( $this->attribute( 'id' ),
                                                                 0,
                                                                 100,
                                                                 eZNetInstallationAgreement::STAUS_PUBLISHED,
                                                                 array( 'start_ts' => array( '<', time() ),
                                                                        'end_ts' => array( '>', time() ) ) );
            } break;

            case 'patch_mode_name':
            {
                $patchModeNameMap = eZNetInstallation::patchModeNameMap();
                $retVal = $patchModeNameMap[$this->attribute( 'patch_mode' )];
            } break;

            case 'installation_info':
            {
                switch( $this->attribute( 'status' ) )
                {
                    case eZNetInstallation::StatusDraft:
                    {
                        $retVal = eZNetInstallationInfo::fetchDraftByInstallationID( $this->attribute( 'id' ) );
                    } break;

                    case eZNetInstallation::StatusPublished:
                    {
                        $retVal = eZNetInstallationInfo::fetchByInstallationID( $this->attribute( 'id' ) );
                    } break;
                }

                if ( !$retVal )
                {
                    $retVal = eZNetInstallationInfo::create( $this->attribute( 'id' ) );
                    $retVal->setAttribute( 'status', $this->attribute( 'status' ) );
                    $retVal->store();
                }
            } break;

            case 'agreement_link_count':
            {
                $retVal = eZNetInstallationAgreement::countByInstallationID( $this->attribute( 'id' ) );
            } break;

            case 'agreement_link_list':
            {
                $retVal = eZNetInstallationAgreement::fetchList( $this->attribute( 'id' ) );
            } break;

            case 'last_agreement':
            {
                $condArray = array();
                $condArray['installation_id'] = $this->attribute( 'id' );

                $resultSet = eZPersistentObject::fetchObjectList( eZNetInstallationAgreement::definition(),
                                                                  null,
                                                                  $condArray,
                                                                  array( 'end_ts' => 'desc' ),
                                                                  array( 'limit' => 1,
                                                                         'offset' => 0 ),
                                                                  true
                                                                  );
                return isset( $resultSet[0] ) ? $resultSet[0] : null;
            } break;

            case 'awaiting_patch_count':
            {
                $retVal = eZNetPatchItem::countByInstallationID( $this->attribute( 'id' ),
                                                                 array( array( eZNetPatchItemBase::StatusNone,
                                                                               eZNetPatchItemBase::StatusNotApproved ) ) );
            } break;

            case 'result_success':
            {
                $result = eZNetMonitorResult::fetchLatestByInstallationID( $this->attribute( 'id' ) );
                if ( $result )
                {
                    $retVal = $result->attribute( 'value_list' );
                }
            } break;

            case 'monitor_group_list':
            {
                $retVal = eZNetMonitorGroup::fetchListByBranchID( $this->attribute( 'branch_id' ) );
            } break;

            case 'customer':
            {
                $retVal = eZContentObject::fetch( $this->attribute( 'customer_id' ) );
            } break;

            case 'branch':
            {
                $retVal = eZNetBranch::fetch( $this->attribute( 'branch_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;
            case 'creator_object':
            {
                $retVal = eZContentObject::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'is_multi_db_enabled':
            {
                $retVal = ( $this->attribute( 'multi_db_enabled' ) == eZNetInstallation::MultiDBEnabledTrue );
            } break;

            case 'module_branch_list':
            {
                $retVal = eZNetModuleBranch::fetchListBySiteID( $this->attribute( 'remote_id' ) );
            } break;

            case 'system_info':
            {
                $retVal = $this->monitorList();
            } break;

            case 'updateStatus':
            case 'update_status':
            {
                //$db = eZDB::instance();
                //$query = 'select count( id ) as to_install from ezx_ezpnet_patch_item where installation_id = ' . $this->attribute( 'id' ) . ' and status < 4';
                //$result = $db->arrayQuery( $query );
                //eZDebug::writeError( $result[0]['to_install'], 'jh result' );


                /**
                 * -1 = no updates available
                 * 0  = all updates installed
                 * 1  = updates pending
                 */
                $updateStatus = 0;
                $totalInstalled = 0;
                $totalNotInstalled = 0;

                $patchItemList = eZNetPatchItem::fetchListByInstallationID( $this->attribute( 'id' ),
                                                                      '', // fetch only patchitems of main node
                                                                      $offset,
                                                                      $limit );
                    //eZDebug::writeDebug( $patchItemList, 'JH PATCHLISTITEM' );

                $countInstalled = 0;
                $countNotInstalled = 0;
                foreach( $patchItemList as $patchItem )
                {
                    if( $patchItem->attribute( 'status' ) == eZNetPatchItemBase::StatusInstalled )
                    {
                        $countInstalled++;
                    }
                    else
                    { 
                        $countNotInstalled++;
                        $updateStatus++;
                    }
                }
                $totalInstalled += $countInstalled;
                $totalNotInstalled += $countNotInstalled;
                $result[] = array( 'type' => 'branch',
                    'id' => $this->attribute( 'id' ),
                    'name' => $this->attribute( 'branch' )->attribute( 'name' ),
                    'branch_id' => $this->attribute( 'branch' )->attribute( 'id' ),
                    'installed' => $countInstalled,
                    'notInstalled' => $countNotInstalled,
                    'total' => $countInstalled + $countNotInstalled,
                );
                //eZDebug::writeDebug( $result, 'JH branch_patch result' );

                $moduleBranchList = $this->attribute( 'module_branch_list' );
                foreach( $moduleBranchList as $moduleBranch)
                {
                    $patchItemList = eZNetModulePatchItem::fetchListByInstallationID( $this->attribute( 'id' ),
                                                                      '', // fetch only patchitems of main node
                                                                      $moduleBranch->attribute( 'id' ),
                                                                      $offset,
                                                                      $limit );
                    //eZDebug::writeError( $patchItemList, 'jh patchItemList' );

                    $countInstalled = 0;
                    $countNotInstalled = 0;
                    foreach( $patchItemList as $patchItem )
                    {
                        if( $patchItem->attribute( 'status' ) == eZNetPatchItemBase::StatusInstalled )
                        {
                            $countInstalled++;
                        }
                        else
                        { 
                            $countNotInstalled++;
                            $updateStatus++;
                        }
                    }
                    $totalInstalled += $countInstalled;
                    $totalNotInstalled += $countNotInstalled;
                    $result[] = array( 'type' => 'module_branch',
                        'id' => $moduleBranch->attribute( 'id' ),
                        'name' => $moduleBranch->attribute( 'name' ),
                        'installed' => $countInstalled,
                        'notInstalled' => $countNotInstalled,
                        'total' => $countInstalled + $countNotInstalled,
                    );
                }
                eZDebug::writeDebug( $totalInstalled, 'jh totalInstalled iteration' );
                eZDebug::writeDebug( $totalNotInstalled, 'jh totalNotInstalled iteration' );
                if( $totalNotInstalled == 71 )
                {
                    eZDebug::writeDebug( $result, 'JH module_branch result' );
                    eZDebug::writeError( $patchItemList, 'jh patchItemList' );
                }

                if( $totalInstalled > 0 && $totalNotInstalled == 0 )
                {
                    $updateStatus = 'All installed';
                }
                else if( $totalNotInstalled > 0 )
                {
                    $updateStatus = 'Updates pending';
                }
                else if( $totalInstalled == 0 && $totalNotInstalled == 0 )
                {
                    $updateStatus = 'No updates available';
                }

                $retVal = array( 'installation_id' => $this->attribute( 'id' ),
                                 'patch_info' => $result,
                                 'installation_update_status' => $updateStatus,
                                 'installation_total_installed' => $totalInstalled,
                                 'installation_total_not_installed' => $totalNotInstalled,
                                 'installation_total' => $totalInstalled + $totalNotInstalled,
                );
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

     Create new eZNetInstallation item
    */
    static function create( $customerID )
    {
        $installationKey = md5( mt_rand() . '.' . time() . '.' . mt_rand() );

        return new eZNetInstallation( array( 'status' => eZNetInstallation::StatusDraft,
                                             'customer_id' => $customerID,
                                             'created' => time(),
                                             'remote_id' => $installationKey,
                                             'is_enabled' => eZNetInstallation::IsEnabledTrue,
                                             'creator_id' => eZUser::currentUserID() ) );
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraft( $id,
                                $force = true,
                                $isEnabled = eZNetInstallation::IsEnabledTrue,
                                $asObject = true )
    {
        $draft = eZNetInstallation::fetch( $id,
                                           eZNetInstallation::StatusDraft,
                                           $isEnabled,
                                           $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetInstallation::fetch( $id,
                                               eZNetInstallation::StatusPublished,
                                               $isEnabled,
                                               $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetInstallation::StatusDraft );
                $draft->sync();
            }
        }

        return $draft;
    }

    /*!
     Publish current object
    */
    function unPublish()
    {
        $this->setAttribute( 'is_enabled', eZNetInstallation::IsEnabledFalse );
        $this->setAttribute( 'modified', time() );
        $this->sync();
        $this->removeDraft();
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetInstallation::StatusPublished );
        $this->setAttribute( 'is_enabled', eZNetInstallation::IsEnabledTrue );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetInstallation::fetchDraft( $this->attribute( 'id' ),
                                                false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static
     Fetch list by branch ID

     \param Branch ID
     \param offset
     \param limit
     \param status
     \param is enabled
     \param $asObject

     \return eZNetInstallation list
    */
    static function fetchListByBranchID( $branchID,
                                         $offset = 0,
                                         $limit = 10,
                                         $status = eZNetInstallation::StatusPublished,
                                         $isEnabled = eZNetInstallation::IsEnabledTrue,
                                         $asObject = true )
    {
        $condArray = array( 'branch_id' => $branchID,
                            'status' => $status,
                            'is_enabled' => $isEnabled );

        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'id' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch list of Network installations.

     \param Customer ID
    */
    static function fetchList( $customerID = false,
                               $offset = 0,
                               $limit = 10,
                               $isEnabled = eZNetInstallation::IsEnabledTrue,
                               $asObject = true,
                               array $sortBy = array( 'id' => 'desc' ) )
    {
        $condArray = array( 'status' => eZNetInstallation::StatusPublished,
                            'is_enabled' => $isEnabled );
        if ( $customerID !== false )
        {
            $condArray['customer_id'] = $customerID;
        }

        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    null,
                                                    $condArray,
                                                    $sortBy,
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch list of Network installations.

     \param Customer ID
    */
    static function fetchListOrderedByName( $offset = 0,
                                            $limit = 10,
                                            $isEnabled = eZNetInstallation::IsEnabledTrue,
                                            $asObject = true )
    {
        $condArray = array( 'status' => eZNetInstallation::StatusPublished,
                            'is_enabled' => $isEnabled );

        return eZPersistentObject::fetchObjectList( eZNetInstallation::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'name' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetInstallation::StatusPublished,
                           $isEnabled = eZNetInstallation::IsEnabledTrue,
                           $asObject = true )
    {
        return eZNetInstallation::fetchObject( eZNetInstallation::definition(),
                                               null,
                                               array( 'id' => $id,
                                                      'is_enabled' => $isEnabled,
                                                      'status' => $status ),
                                               $asObject );
    }

    /*!
     \static

     Get patch mode name map
    */
    static function patchModeNameMap()
    {
        return array( eZNetInstallation::ModeManual => ezi18n( 'crm', 'Manual' ),
                      eZNetInstallation::ModeSemi => ezi18n( 'crm', 'Semi manual' ),
                      eZNetInstallation::ModeAutomatic => ezi18n( 'crm', 'Automatic' ) );
    }

    /*!
     \static

     Get multi site/DB name map.
    */
    static function multiDBNameMap()
    {
        return array( eZNetInstallation::MultiDBEnabledFalse => ezi18n( 'crm', 'Disabled' ),
                      eZNetInstallation::MultiDBEnabledTrue => ezi18n( 'crm', 'Enabled' ) );
    }

    /*!
     Fetches list of all monitor result values with monitor items belongs to this installation.

     \return List of monitor result value, monitor item names as keys without using the network cache
    */
    function systemData()
    {
        $globalName = 'eZNetInstallation_systemData_' . $this->attribute( 'id' );
        if ( isset( $GLOBALS[$globalName] ) )
        {
            return $GLOBALS[$globalName];
        }

        $monitorsArray = array();
        $monitorGroupList = $this->attribute( 'monitor_group_list' );

        foreach ( $monitorGroupList as $monitorGroup )
        {
            $itemList = $monitorGroup->attribute( 'item_list' );
            foreach ( $itemList as $item )
            {
                $valueList = eZNetMonitorResultValue::fetchListByInstallationAndItemID( $this->attribute( 'id' ),
                                                                                        $item->attribute( 'id' ),
                                                                                        0, // offset
                                                                                        1, // limit
                                                                                        false, // allNodes
                                                                                        false // $asObject
                                                                                       );
                if ( isset( $valueList[0] ) )
                {
                    $key = strtolower( str_replace( ' ', '_', $item->attribute( 'name' ) ) );
                    $monitorsArray[$key] = $valueList[0];
                }
            }
        }

        $GLOBALS[$globalName] = $monitorsArray;

        return $monitorsArray;
    }

    /*!
     Fetches list of all monitor result values with monitor items belongs to this installation.

     \return List of monitor result value, monitor item names as keys using the network cache
    */
    function monitorList()
    {
        // We should try to fetch data from the cache first
        $cacheKey = eZCrmCache::generateKey( array( 'function' => 'monitorList', 'installation_id' =>  $this->attribute( 'id' ) ) );
        $cachedData = eZCrmCache::restoreCache( $cacheKey );
        // If we find the cached list, just return it
        if ( $cachedData !== false )
        {
            return $cachedData;
        }

        return $this->systemData();
    }

    /*!
     \static

     Changes the branch on a installation. Existing patch items are set to obsolete.
    */
    static function changeBranch( $installationId, $branchId )
    {
        $db = eZDB::instance();

        $db->begin();
        $installation = eZNetInstallation::fetchDraft( $installationId );

        if ( !$installation )
        {
            return false;
        }

        $installationId = $installation->attribute( 'id' );
        $installationInfo = $installation->attribute( 'installation_info' );

        if ( !$installationInfo )
        {
            return false;
        }

        // Change branch on the installation
        $installation->setAttribute( 'branch_id', $branchId );
        $installation->store();

        // Remove old patch items by changing the status to Obsolete
        // This change will be synchronized to EZNO
        $patchItems = eZNetPatchItem::fetchListByInstallationID( $installationId, false, 0, 99999999 );
        foreach ( $patchItems as $patchItem )
        {
            $patchItem->setAttribute( 'status', eZNetPatchItemBase::StatusObsolete );
            $patchItem->setAttribute( 'modified', time() );
            $patchItem->store();
        }

        $db->commit();

        return true;
    }

}


?>
