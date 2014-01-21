<?php
/**
 * File containing eZNetPatchSQLStatus class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetPatchSQLStatus eznetpatchsqlstatus.php
  \brief The class eZNetPatchSQLStatus does

  This object is only stored on the clients main database, and contain status of SQL updates.

  A new instance is created for each DB the client installation has got installed. The DBs
  are fetched using the eZNetUtils::dbList() function.
*/
class eZNetPatchSQLStatus extends eZPersistentObject
{
    /// Consts
    const IsEnabledFalse = 0;
    const IsEnabledTrue = 1;

    /*!
     Constructor
    */
    function eZNetPatchSQLStatus( $row = array() )
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
                                         "installation_id" => array( 'name' => 'eZNetInstallationID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetInstallation',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*' ),
                                         'is_enabled' => array( 'name' => 'IsEnabled',
                                                                'datatype' => 'integer',
                                                                'default' => eZNetInstallation::IsEnabledTrue,
                                                                'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'db_name' => array( 'name' => 'DBName',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => '' ),
                                         'site_access' => array( 'name' => 'SiteAccess',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => '' ),
                                         'base_patch_id' => array( 'name' => 'BasePatchID',
                                                                   'datatype' => 'integer',
                                                                   'default' => 0,
                                                                   'required' => true,
                                                                   'foreign_class' => 'eZNetPatch',
                                                                   'foreign_attribute' => 'id',
                                                                   'multiplicity' => '1..*'),
                                         'latest_patch_id' => array( 'name' => 'LatestPatchID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetPatch',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*') ),
                      "keys" => array( "id" ),
                      "function_attributes" => array( 'installation' => 'installation',
                                                      'base_patch' => 'basePatch',
                                                      'latest_patch' => 'latestPatch' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetPatchSQLStatus",
                      "sort" => array( "id" => "asc" ),
                      "name" => "ezx_ezpnet_patch_sql_st" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'installation':
            {
                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
            } break;

            case 'base_patch':
            {
                if ( !$this->attribute( 'base_patch_id' ) )
                {
                    if ( $basePatch = eZNetPatchSQLStatus::fetchBasePatch() )
                    {
                        $this->setAttribute( 'base_patch_id', $basePatch->attribute( 'id' ) );
                        $this->sync();
                    }
                }
                if ( $this->attribute( 'base_patch_id' ) )
                {
                    $retVal = eZNetPatch::fetch( $this->attribute( 'base_patch_id' ) );
                }
            } break;

            case 'latest_patch':
            {
                if ( $this->attribute( 'latest_patch_id' ) == 0 )
                {
                    $retVal = null;
                }
                else
                {
                    $retVal = eZNetPatch::fetch( $this->attribute( 'latest_patch_id' ) );
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
     Create new instance of eZNetPatchSQLStatus.

     \param DB name.
     \param SiteAccess.

     \return eZNetPatchSQLStatus object.
    */
    public static function create( $dbName,
                     $siteAccess )
    {
        $installation = eZNetInstallation::fetchCurrent();
        return new eZNetPatchSQLStatus( array( 'db_name' => $dbName,
                                               'site_access' => $siteAccess,
                                               'installation_id' => $installation->attribute( 'id' ),
                                               'created' => time(),
                                               'modified' => time(),
                                               'is_enabled' => eZNetInstallation::IsEnabledTrue ) );
    }

    /*!
     \reimp
    */
    function setAttribute( $attr, $val )
    {
        eZPersistentObject::setAttribute( 'modified', time() );

        switch( $attr )
        {
            default:
            {
                eZPersistentObject::setAttribute( $attr, $val );
            } break;
        }
    }

    /*!
     \static

     Fetch eZNetPatchSQLStatus item list by Installation.

     \param eZNetInstallation object
     \param offset
     \param limit
     \param $asObject ( optional )

     \return eZNetPatchSQLStatus item list, empty array if none exists.
    */
    static function fetchListByInstallation( $installation,
                                             $offset,
                                             $limit,
                                             $asObject = true )
    {
        return eZNetPatchSQLStatus::fetchObjectList( eZNetPatchSQLStatus::definition(),
                                                     null,
                                                     array( 'installation_id' => $installation->attribute( 'id' ),
                                                            'is_enabled' => eZNetPatchSQLStatus::IsEnabledTrue ),
                                                     false,
                                                     array( 'limit' => $limit,
                                                            'offset' => $offset ),
                                                     $asObject );
    }

    /*!
     \static

     Fetch eZNetPatchSQLStatus item by DB name. If no entry exists, return null.

     \param DB name
     \param eZNetInstallation ID ( optional )

     \return eZNetPatchSQLStatus item, null if none exists.
    */
    static function fetchByDBName( $dbName,
                                   $installationID = false,
                                   $asObject = true )
    {
        if ( $installationID === false )
        {
            if ( $installation = eZNetInstallation::fetchCurrent() )
            {
                $installationID = $installation->attribute( 'id' );
            }
            else
            {
                eZDebug::writeError( 'Could not fetch current eZNetInstallation.' );
                return null;
            }
        }

        return eZNetPatchSQLStatus::fetchObject( eZNetPatchSQLStatus::definition(),
                                                 null,
                                                 array( 'db_name' => $dbName,
                                                        'installation_id' => $installationID ),
                                                 $asObject );
    }

    /*!
     \private

     Fetch base patch.

     \return base patch. Null if none is found.
    */
    function fetchBasePatch()
    {
        $patchItemList = eZNetPatchItem::fetchListByInstallationID( $this->attribute( 'installation_id' ),
                                                                    false,
                                                                    0,
                                                                    10,
                                                                    eZNetPatchItemBase::StatusInstalled,
                                                                    array( 'finnished' => 'asc' ) );
        $minFinnished = -1;
        $equalList = array();
        foreach( $patchItemList as $patchItem )
        {
            if ( $patchItem->attribute( 'finnished' ) == $minFinnished )
            {
                $equalList[] = $patchItem;
            }
            if ( $patchItem->attribute( 'finnished' ) < $minFinnished ||
                 $minFinnished == -1 )
            {
                $minFinnished = $patchItem->attribute( 'finnished' );
                $equalList = array( $patchItem );
            }
        }

        if ( count( $equalList ) == 1 )
        {
            $patchItem = $equalList[0];
            return $patchItem->attribute( 'patch' );
        }
        if ( count( $equalList ) > 1 )
        {
            $patchIDList = array();
            $removePatchIDList = array();
            foreach( $equalList as $patchItem )
            {
                $patchIDList[] = $patchItem->attribute( 'patch_id' );
            }
            foreach( $equalList as $patchItem )
            {
                $patch = $patchItem->attribute( 'patch' );
                $requiredPatchID = $patch->attribute( 'required_patch_id' );
                if ( $requiredPatchID == -1 )
                {
                    return $patch;
                }
                if ( in_array( $requiredPatchID, $patchIDList ) )
                {
                    $removePatchIDList[] = $patch->attribute( 'id' );
                }
            }
            $patchIDDiffList = array_diff( $patchIDList, $removePatchIDList );

            if ( count( $patchIDDiffList ) > 1 )
            {
                eZDebug::writeError( 'eZNetPatchSQLStatus::fetchBasePatch() - Could not load correct base patch' .
                                     ', count( $patchIDDiffList ) > 1 ' );
            }
            if ( count( $patchIDDiffList ) == 1 )
            {
                return eZNetPatch::fetch( $patchIDDiffList[0] );
            }
        }

        return null;
    }

    /*!
     Install missing patches up to current patch item.

     \param eZNetPatchItemBase object.
     \param eZNetInstallation object
     \param $cli, optional ( default false ), set to
            eZCLI object for interactive installation.
     \param execute automaticly.
     */
    function installPatches( $patchItem,
                             $installation,
                             $cli = false,
                             $executeAll = false )
    {
        if ( !eZNetUtils::isMaster() )
        {
            return;
        }

        $latestPatch = $this->attribute( 'latest_patch' );
        $installPatch = null;
        if ( !$latestPatch )
        {
            $basePatch = $this->attribute( 'base_patch' );
            $installPatch = $basePatch;
        }
        else
        {
            $installPatch = $latestPatch->nextPatch();
        }

        if ( !$installPatch )
        {
            eZNetUtils::log( 'eZNetPatchSQLStatus::installPatches()[DB:' . $this->attribute( 'db_name' ) . ']:' .
                             'Could not determine correct patch to install' );
            return;
        }

        $currentPatch = $patchItem->attribute( 'patch' );

        while( $installPatch )
        {
            $installPatchItem = eZNetPatchItem::fetchByPatchID( $installPatch->attribute( 'id' ),
                                                                $installation->attribute( 'id' ) );

            // Check if installPatchItem is later than current patch item.
            if ( $requiredPatch = $installPatch->attribute( 'required_patch' ) )
            {
                if ( $requiredPatch->attribute( 'id' ) == $currentPatch->attribute( 'id' ) )
                {
                    // installPatchItem is of later version than current patch.
                    break;
                }
            }

            $patchDomDocument = $installPatchItem->loadPatchFile();
            $rootNode = $patchDomDocument->get_root();
            $patchElementNodeList = $rootNode->getElementsByTagName( 'PatchElement' );
            foreach( $patchElementNodeList as $patchElement )
            {
                switch( $patchElement->get_attribute( 'type' ) )
                {
                    case 'sql':
                    {
                        $currentSiteAccess = $GLOBALS['eZCurrentAccess']['name'];
                        $currentDB = eZDB::instance();
                        $resetInstance = null;
                        eZDB::setInstance( $resetInstance );
                        eZNetUtils::changeAccess( $this->attribute( 'site_access' ) );
                        $siteAccessDB = eZDB::instance( false, false, true );
                        eZNetUtils::log( 'eZNetPatchSQLStatus::installPatches()[DB:' . $siteAccessDB->DB . ']: ' .
                                         'Installing SQL patch: ' . $installPatch->attribute( 'id' ) );

                        $result = $installPatchItem->applySQL( $patchElement,
                                                               $cli,
                                                               $executeAll );

                        $siteAccessDB->close();

                        eZNetUtils::changeAccess( $currentSiteAccess );
                        eZDB::setInstance( $currentDB );
                    } break;
                }
            }

            $db = eZDB::instance( false, false, true );

            $this->setAttribute( 'latest_patch_id', $installPatch->attribute( 'id' ) );

            $installPatch = $installPatch->nextPatch();
        }

        $this->sync();
    }
}
?>
