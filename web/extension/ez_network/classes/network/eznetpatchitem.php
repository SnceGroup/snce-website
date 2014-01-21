<?php
/**
 * File containing eZNetPatchItem class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetPatchItem eznetpatchlogitem.php
  \brief The class eZNetPatchLogItem does

*/
class eZNetPatchItem extends eZNetPatchItemBase
{
    /*!
     Constructor
    */
    function eZNetPatchItem( $row )
    {
        $this->eZNetPatchItemBase( $row );
    }

    /*!
     \reimp
    */
    static function definition()
    {
        return array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'installation_id' => array( 'name' => 'InstallationID',
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
                                         'patch_id' => array( 'name' => 'PatchID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true,
                                                              'foreign_class' => 'eZNetPatch',
                                                              'foreign_attribute' => 'id',
                                                              'multiplicity' => '1..*' ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true ),
                                         'fmode' => array( 'name' => 'Mode',
                                                           'datatype' => 'integer',
                                                           'default' => 0,
                                                           'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'started' => array( 'name' => 'Started',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'finnished' => array( 'name' => 'Finnished',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true ) ),
                      'keys' => array( 'id' ),
                      'function_attributes' => array( 'patch' => 'patch',
                                                      'branch_id' => 'branchID',
                                                      'patch_exists' => 'patchExists',
                                                      'node_name' => 'nodeName',
                                                      'required_patch_item' => 'requiredPatchItem',
                                                      'installation' => 'installation' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZNetPatchItem',
                      'sort' => array( 'patch_id' => 'desc' ),
                      'name' => 'ezx_ezpnet_patch_item' );
    }

    /*!
     \static

     logs some info about the status of ezpublish patches

    */
    static function logeZPublishPatchsStatus( $sIntroMsg='' )
    {
        $sMsg = $sIntroMsg . '--';
        $aStatuses = array ( eZNetPatchItemBase::StatusNone,
                             eZNetPatchItemBase::StatusNotApproved,
                             eZNetPatchItemBase::StatusPending,
                             eZNetPatchItemBase::StatusInstalling,
                             eZNetPatchItemBase::StatusInstalled,
                             eZNetPatchItemBase::StatusFailed,
                             eZNetPatchItemBase::StatusObsolete, );

        $aStatusNames[eZNetPatchItemBase::StatusNone] = 'Status None';
        $aStatusNames[eZNetPatchItemBase::StatusNotApproved] = 'Status NotApproved';
        $aStatusNames[eZNetPatchItemBase::StatusPending] = 'Status Pending';
        $aStatusNames[eZNetPatchItemBase::StatusInstalling] = 'Status Installing';
        $aStatusNames[eZNetPatchItemBase::StatusInstalled] = 'Status Installed';
        $aStatusNames[eZNetPatchItemBase::StatusFailed] = 'Status Failed';
        $aStatusNames[eZNetPatchItemBase::StatusObsolete] = 'Status Obsolete';

        foreach( $aStatuses as $status )
        {
            $resultSet = eZNetPatchItem::fetchObjectList( eZNetPatchItem::definition(),
                                                          null,
                                                          array( 'status' => $status ),
                                                          null,
                                                          array( 'offset' => 0, 'limit' => 100 ),
                                                          true );
            if( 0 < count( $resultSet ) )
            {
                $sMsg = $sIntroMsg . '--' . $aStatusNames[ $status ] . ':[' .  count( $resultSet ) . ']';
                foreach( $resultSet as $patch )
                {
                    $sMsg .= ' ID[' . $patch->attribute( 'id' ) . ']';

                    if( $patch->attribute( 'finnished' ) < $patch->attribute( 'started' ) )
                    {
                        $sMsg .= '-BADINSTALL';
                    }
                }
                eZNetUtils::log( $sMsg );
            }
        }
        $NextItem = eZNetPatchItem::fetchNextPatchItem();
        if( $NextItem )
        {
            $patch = $NextItem->attribute( 'patch' );
            eZNetUtils::log( $sIntroMsg . '--Next patch item ID:[' . $NextItem->attribute( 'id' ) . '] ' .
                             'Patch ID:[' . $patch->attribute( 'patch_id' ) . '] Name:[' . $patch->attribute( 'name' ) . ']' );
        }
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

        return eZNetPatchItem::fetchObjectList( eZNetPatchItem::definition(),
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

     \param installation ID

     Get total issue count
    */
    static function countByInstallationID( $installationID = false,
                                           $status = array( array( eZNetPatchItemBase::StatusNone,
                                                                   eZNetPatchItemBase::StatusNotApproved,
                                                                   eZNetPatchItemBase::StatusPending,
                                                                   eZNetPatchItemBase::StatusInstalling,
                                                                   eZNetPatchItemBase::StatusInstalled,
                                                                   eZNetPatchItemBase::StatusFailed ) ),
                                           $nodeID = false,
                                           $patchStatus = array( eZNetPatchBase::StatusFinal, eZNetPatchBase::StatusSecurity ) )
    {
        // Define default value
        $status = $status === true ? array( array( eZNetPatchItemBase::StatusNone,
                                                   eZNetPatchItemBase::StatusNotApproved,
                                                   eZNetPatchItemBase::StatusPending,
                                                   eZNetPatchItemBase::StatusInstalling,
                                                   eZNetPatchItemBase::StatusInstalled,
                                                   eZNetPatchItemBase::StatusFailed ) ) : $status;
        $installation = eZNetInstallation::fetch( $installationID );
        $patchDef = eZNetPatch::definition();
        $patchItemDef = eZNetPatchItem::definition();

        $condArray = array( $patchItemDef['name'] . '.status' => $status );
        if ( $installationID )
        {
            $condArray['installation_id'] = $installationID;
        }
        if ( $nodeID !== false )
        {
            $condArray['node_id'] = $nodeID;
        }

        $customTables = array( $patchDef['name'] );
        $customConds = ' AND ' . $patchDef['name'] . '.id = ' . $patchItemDef['name'] . '.patch_id AND ' . $patchDef['name'] . '.branch_id = ' . $installation->attribute( 'branch_id' );
        $customConds .= ' AND ' . $patchDef['name'] . '.status IN (' . implode( ',', $patchStatus ) . ')';

        $resultSet = eZPersistentObject::fetchObjectList( eZNetPatchItem::definition(),
                                                          array(),
                                                          $condArray,
                                                          null,
                                                          null,
                                                          false,
                                                          false,
                                                          array( array( 'operation' => 'count(' .$patchItemDef['name'] . '.id)',
                                                                        'name' => 'count' ) ),
                                                          $customTables,
                                                          $customConds );
        return $resultSet[0]['count'];
    }

    /*!
     \static

     Fetch a list of branches based on installation remote ID.

    */
    static function fetchListByRemoteIDAndLatestID( $installationSiteID,
                                                    $latestID,
                                                    $offset = 0,
                                                    $limit = 100,
                                                    $asObject = true )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        if ( !$installation )
        {
            return false;
        }

        return eZPersistentObject::fetchObjectList( eZNetPatchItem::definition(),
                                                    array( 'id' ),
                                                    array( 'installation_id' => $installation->attribute( 'id' ),
                                                           'id' => array( '>', $latestID ) ),
                                                    array( 'id' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch list by installation ID
    */
    static function fetchListByInstallationID( $installationID = false,
                                               $nodeID = false,
                                               $offset = 0,
                                               $limit = 10,
                                               $status = array( array( eZNetPatchItemBase::StatusNone,
                                                                       eZNetPatchItemBase::StatusNotApproved,
                                                                       eZNetPatchItemBase::StatusPending,
                                                                       eZNetPatchItemBase::StatusInstalling,
                                                                       eZNetPatchItemBase::StatusInstalled,
                                                                       eZNetPatchItemBase::StatusFailed ) ),
                                               $orderBy = null,
                                               $asObject = true,
                                               $branchID = false,
                                               $patchStatus = array( eZNetPatchBase::StatusFinal, eZNetPatchBase::StatusSecurity ) )
    {
        $patchDef = eZNetPatch::definition();
        $patchItemDef = eZNetPatchItem::definition();

        $condArray = array( $patchItemDef['name'] . '.status' => $status );
        if ( $installationID )
        {
            $condArray['installation_id'] = $installationID;
        }

        $customConds = null;
        if ( $nodeID !== false )
        {
            if ( $nodeID == '' )
            {
                $customConds = " AND ( node_id = '' OR node_id is null )";
            }
            else
            {
                $condArray['node_id'] = $nodeID;
            }
        }

        $fields = array();
        $customFields = array( $patchItemDef['name'] . '.*' );
        $customTables = array( $patchDef['name'] );
        $customConds .= ' AND ' . $patchDef['name'] . '.id = ' . $patchItemDef['name'] . '.patch_id';
        $customConds .= ' AND ' . $patchDef['name'] . '.version_status = ' . eZNetPatchBase::VersionStatusPublished;
        $customConds .= ' AND ' . $patchDef['name'] . '.status IN (' . implode( ',', $patchStatus ) . ')';
        if ( $branchID !== false && is_numeric( $branchID ) )
        {
            $customConds .= ' AND ' . $patchDef['name'] . '.branch_id = ' . $branchID;
        }

        return eZPersistentObject::fetchObjectList( eZNetPatchItem::definition(),
                                                    $fields,
                                                    $condArray,
                                                    $orderBy,
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject,
                                                    false,
                                                    $customFields,
                                                    $customTables,
                                                    $customConds );
    }

    /*!
     \static

     Fetch list by installation ID
    */
    static function fetchListByCustomerID( $customerID = false,
                                           $nodeID = false,
                                           $offset = 0,
                                           $limit = 10,
                                           $status = array( array( eZNetPatchItemBase::StatusNone,
                                                                   eZNetPatchItemBase::StatusNotApproved,
                                                                   eZNetPatchItemBase::StatusPending,
                                                                   eZNetPatchItemBase::StatusInstalling,
                                                                   eZNetPatchItemBase::StatusInstalled,
                                                                   eZNetPatchItemBase::StatusFailed ) ),
                                           $asObject = true )
    {
        return eZNetPatchItem::fetchListByInstallationID( array( eZNetInstallation::fetchIDListByCustomerID( $customerID ) ),
                                                          $nodeID,
                                                          $offset,
                                                          $limit,
                                                          $status,
                                                          $asObject );
    }

    /*!
     \static

     \param customer ID

     Get total issue count
    */
    static function countByCustomerID( $customerID = false,
                                       $status = array( array( eZNetPatchItemBase::StatusNone,
                                                               eZNetPatchItemBase::StatusNotApproved,
                                                               eZNetPatchItemBase::StatusPending,
                                                               eZNetPatchItemBase::StatusInstalling,
                                                               eZNetPatchItemBase::StatusInstalled,
                                                               eZNetPatchItemBase::StatusFailed ) ),
                                       $nodeID = false )
    {
        return eZNetPatchItem::countByInstallationID( array( eZNetInstallation::fetchIDListByCustomerID( $customerID ) ),
                                                      $status,
                                                      $nodeID );
    }

    /*!
     \static

     Create new PatchItem object

    */
    static function create( $patchID,
                            $installationID,
                            $nodeID = false )
    {
        if ( $nodeID === false )
        {
            $nodeID = '';
        }

        // Get patch installation mode
        $status = eZNetPatchItemBase::StatusNone;
        $installation = eZNetInstallation::fetch( $installationID );
        if ( $installation )
        {
            switch( $installation->attribute( 'patch_mode' ) )
            {
                case eZNetInstallation::ModeAutomatic:
                {
                    $status = eZNetPatchItemBase::StatusPending;
                } break;

                default:
                case eZNetInstallation::ModeManual:
                case eZNetInstallation::ModeSemi:
                {
                    $status = eZNetPatchItemBase::StatusNone;
                } break;
            }
        }

        // Create new patch item
        $patchItem = new eZNetPatchItem( array( 'patch_id' => $patchID,
                                                'installation_id' => $installationID,
                                                'node_id' => $nodeID,
                                                'status' => $status,
                                                'modified' => time() ) );
        $patchItem->store();
        return $patchItem;
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            default:
            {
                $retVal = eZNetPatchItemBase::attribute( eZNetUtils::updateFieldName( $attr ) );
            } break;
        }

        return $retVal;
    }

    /*!
     \reimp
    */
    function setAttribute( $attr, $val )
    {
        switch( $attr )
        {
            default:
            {
                parent::setAttribute( eZNetUtils::updateFieldName( $attr ), $val );
            } break;
        }
    }

    /*!
     Fetch list of not installed patches.
    */
    function fetchNonInstalled()
    {
        //TODO
    }


    /*!
     Get patch storage dir.

     \return patch storage dir.
    */
    function patchDirectory()
    {
        return eZDir::path( array( eZNetUtils::storageDirectory() ,
                                   'patch' ,
                                   md5( '-' . eZNetUtils::nodeID() . '-' ),
                                   $this->attribute( 'patch_id' ) ,
                                   substr( eZNetUtils::nodeID(), 0, 8 ) ) );
    }

    /*!
     Get patch storage path. Used for storing files related to patch.
    */
    function storagePath()
    {
        return eZDir::path( array( eZNetUtils::storagePath(),
                                   'patch',
                                   md5( '-' . eZNetUtils::nodeID() . '-' ),
                                   $this->attribute( 'patch_id' ) ? $this->attribute( 'patch_id' ) : '_tmp' ) );
    }

    /*!
     \static
     Fetch latest installed patch.

    \param $asObject
    */
    static function fetchLatestInstalled( $asObject = true )
    {
        $nodeIDPart = '';
        $nodeID = eZNetUtils::nodeID();
        if ( $nodeID == '' )
        {
            $nodeIDPart = "       AND ( ITEM.node_id = '' OR ITEM.node_id is null )\n";
        }
        else
        {
            $nodeIDPart = "       AND ITEM.node_id = '" . eZNetUtils::nodeID() . "'\n";
        }

        $sql = "SELECT ITEM.*\n" .
               "FROM   ezx_ezpnet_patch_item ITEM,\n" .
               "       ezx_ezpnet_patch PATCH\n" .
               "WHERE  ITEM.patch_id = PATCH.id\n" .
               $nodeIDPart .
               "       AND ITEM.finnished > 0\n" .
               "       AND ITEM.status = " . eZNetPatchItemBase::StatusInstalled . "\n" .
               "ORDER BY ITEM.finnished DESC, ITEM.patch_id DESC";

        $db = eZDB::instance();
        $resultSet = $db->arrayQuery( $sql, array( 'offset' => 0, 'limit' => 1 ) );

        if ( $resultSet )
        {
            if ( $asObject )
            {
                return new eZNetPatchItem( $resultSet[0] );
            }

            return $resultSet[0];
        }

        return null;
    }

    /*!
     \static
     Fetch by from release tag.

     \param release tag
     \param installation ID
     \param $asObject
    */
    static function fetchByFromReleaseTag( $releaseTag, $installationID, $asObject = true )
    {
        $offset = 0;
        $limit = 10;

        while( $patchItemList = eZNetPatchItem::fetchListByInstallationID( $installationID,
                                                                           eZNetUtils::nodeID(),
                                                                           $offset,
                                                                           $limit,
                                                                           eZNetPatchItemBase::StatusPending ) )
        {
            foreach( $patchItemList as $patchItem )
            {
                if ( $patch = $patchItem->attribute( 'patch' ) )
                {
                    if ( $patch->option( 'from_release_tag' ) == $releaseTag )
                    {
                        return eZNetPatchItem::fetchByPatchID( $patch->attribute( 'id' ), $installationID );
                    }
                }
            }
            $offset += $limit;
        }

        return null;
    }

    /*!
     \reimp
    */
    static function patchIDFieldName()
    {
        return 'patch_id';
    }

    /*!
     Check if required patch is properly installed

     \return true if required patch is installed, false if not.
    */
    function requiredPatchInstalled()
    {
        $patch = $this->attribute( 'patch' );

        switch( $patch->attribute( 'required_patch_id' ) )
        {
            case eZNetPatchBase::RequiredNone:
            {
                if ( $patch->isBaseRelease() )
                {
                    return true;
                }
            } break;

            default:
            {
                if ( $patch->option( 'from_release_tag' ) == eZPublishSDK::version( true, false, false ) )
                {
                    return true;
                }

                $requiredPatchItem = $this->attribute( 'required_patch_item' );
                if ( !$requiredPatchItem )
                {
                    return false;
                }
                if ( $requiredPatchItem->attribute( 'status' ) == eZNetPatchItemBase::StatusInstalled )
                {
                    return true;
                }
            } break;
        }

        return false;
    }

    /*!
     \static
     Get next patch item to install
    */
    static function fetchNextPatchItem()
    {
        $nextItem = false;
        $latestInstalled = eZNetPatchItem::fetchLatestInstalled();

        if ( !$latestInstalled )
        {
            if ( $currentInstallation = eZNetInstallation::fetchCurrent() )
            {
                $nextItem = eZNetPatchItem::fetchByFromReleaseTag( eZPublishSDK::version( true, false, false ),
                                                                   $currentInstallation->attribute( 'id' ) );
            }
        }
        else
        {
            $nextItem = $latestInstalled->nextPatchItem();
        }

        return $nextItem;
    }

    /*!
     \reimp
    */
    static function patchClassName()
    {
        return 'eZNetPatch';
    }

    /*!
     \reimp
    */
    static function sqlPatchStatus( $dbName )
    {
        return eZNetPatchSQLStatus::fetchByDBName( $dbName );
    }

    /*!
     \reimp
    */
    static function createSqlPatchStatus( $dbName, $siteAccess )
    {
        return eZNetPatchSQLStatus::create( $dbName, $siteAccess );
    }

    /*!
     \reimp
     \static

     Update all modified timestamps.

     \param \a $diffTS ( optional ).
    */
    static function updateModifiedAll( $diffTS = 0 )
    {
        parent::updateModifiedAllByClass( $diffTS, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch eZNetPatchItemBase by patch item ID

     \param patch item ID
     \param $asObject

     \return eZNetPatchItem
    */
    static function fetch( $id, $asObject = true )
    {
        return parent::fetchByClass( $id, $asObject, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch eZNetPatchItem by patch and installation ID
    */
    static function fetchByPatchID( $patchID,
                                    $installationID,
                                    $nodeID = false,
                                    $asObject = true )
    {
        return parent::fetchByPatchIDAndClass( $patchID, $installationID, $nodeID, $asObject, get_class() );
    }


    /*!
     \static
     Fetch latest installed patch.

    \param $asObject
    */
    function fetchLatestInstalledWithinThisPatchItemInstallation( $asObject = true )
    {
        $nodeIDPart = '';
        $nodeID = eZNetUtils::nodeID();
        if ( $nodeID == '' )
        {
            $nodeIDPart = "       AND ( ITEM.node_id = '' OR ITEM.node_id is null )\n";
        }
        else
        {
            $nodeIDPart = "       AND ITEM.node_id = '" . eZNetUtils::nodeID() . "'\n";
        }

        $sql = "SELECT ITEM.*\n" .
               "FROM   ezx_ezpnet_patch_item ITEM,\n" .
               "       ezx_ezpnet_patch PATCH\n" .
               "WHERE  ITEM.patch_id = PATCH.id\n" .
               $nodeIDPart .
               //"       AND ITEM.finnished > 0\n" .
               "       AND ITEM.status = " . eZNetPatchItemBase::StatusInstalled . "\n" .
               "       AND ITEM.installation_id = " . $this->attribute( 'installation_id' ) . "\n" .
               "ORDER BY ITEM.finnished DESC, ITEM.patch_id DESC";

        $db = eZDB::instance();
        $resultSet = $db->arrayQuery( $sql, array( 'offset' => 0, 'limit' => 1 ) );

        if ( $resultSet )
        {
            if ( $asObject )
            {
                return new eZNetPatchItem( $resultSet[0] );
            }

            return $resultSet[0];
        }

        return null;
    }
}

?>
