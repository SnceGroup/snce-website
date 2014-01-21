<?php
/**
 * File containing eZNetModuleBranch class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetModuleBranch eznetmodulebranch.php
  \brief The class eZNetModuleBranch does

*/
class eZNetModuleBranch extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;


    /*!
     Constructor
    */
    function eZNetModuleBranch($row )
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
                                         "name" => array( 'name' => 'Name',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'version_identifier' => array( 'name' => 'VersionIdentifier',
                                                                        'datatype' => 'string',
                                                                        'default' => '',
                                                                        'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         "url" => array( 'name' => 'Url',
                                                         'datatype' => 'string',
                                                         'default' => '',
                                                         'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         'is_certified' => array( 'name' => 'IsCertified' ,
                                                                  'datatype' => 'boolean',
                                                                  'default' => true,
                                                                  'required' => false ),
                                         'branch_id' => array( 'name' => 'BranchID',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true,
                                                               'foreign_class' => 'eZNetBranch',
                                                               'foreign_attribute' => 'id',
                                                               'multiplicity' => '0..*' ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'branch' => 'branch',
                                                      'version_value' => 'versionValue',
                                                      'possible_dependencies' => 'possibleDependencies',
                                                      'uncertified_dependencies' => 'fetchUncertifiedDependencies' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetModuleBranch",
                      "sort" => array( "name" => "asc" ),
                      "name" => "ezx_ezpnet_module_branch" );
    }

    /*!
     \static
     Fetch eZNetModuleBranch list by installation site ID

     \param installation site ID
     \param asObject

     \return eZNetModuleBranch list
    */
    static function fetchListBySiteID( $siteID,
                                       $asObject = true )
    {
        $moduleInstallationList = eZNetModuleInstallation::fetchListBySiteID( $siteID );
        $moduleBranchList = array();

        foreach( $moduleInstallationList as $moduleInstallation )
        {
            $moduleBranchList[] = $moduleInstallation->attribute( 'module_branch' );
        }

        return $moduleBranchList;
    }

    /*!
     \static
     Fetch eZNetModuleBranch list by eZNetBranch ID

     \param eZNetBranch ID
     \param asObject

     \return eZNetModuleBranch list
    */
    static function fetchListByBranchID( $branchID,
                                         $asObject = true )
    {
        return eZNetModuleBranch::fetchObjectList( eZNetModuleBranch::definition(),
                                                   null,
                                                   array( 'branch_id' => $branchID ),
                                                   array( 'modified' => 'asc' ),
                                                   null,
                                                   $asObject );
    }

    /*!
     \static
     Fetch eZNetModuleBranch ID list by eZNetBranch ID

     \param eZNetBranch ID

     \return eZNetModuleBranch ID list
    */
    static function fetchIDListByBranchID( $branchID )
    {
        $moduleBranchList = self::fetchListByBranchID( $branchID, false );
        $moduleBranchIDList = array();
        foreach( $moduleBranchList as $moduleBranch )
        {
            $moduleBranchIDList[] = $moduleBranch['id'];
        }
        return $moduleBranchIDList;
    }

    /*!
     \static
     Fetch list of version identifiers (extension names)

     \return array
    */
    static function fetchVersionIdentifierList()
    {
        $db = eZDB::instance();
        $sql = 'SELECT DISTINCT version_identifier FROM ezx_ezpnet_module_branch WHERE version_identifier LIKE \'ez%\' ORDER BY version_identifier';
        $rows = $db->arrayQuery( $sql );

        $extensions = array();
        foreach( $rows as $row )
        {
            $extensions[] = $row['version_identifier'];
        }
        return $extensions;
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
                                                          $status = eZNetModuleBranch::StatusPublished )
    {
        $moduleList = eZNetModuleInstallation::fetchListBySiteID( $installationSiteID );
        $moduleBranchIDList = array();
        foreach( $moduleList as $module )
        {
            $moduleBranchIDList[] = $module->attribute( 'module_branch_id' );
        }

        return eZNetModuleBranch::fetchObjectList( eZNetModuleBranch::definition(),
                                                   array( 'id' ),
                                                   array( 'id' => array( $moduleBranchIDList ),
                                                          'modified' => array( '>', $latestModified ),
                                                          'status' => $status ),
                                                   array( 'modified' => 'asc' ),
                                                   array( 'limit' => $limit,
                                                          'offset' => $offset ),
                                                   $asObject );
    }

    /*!
     \static

     Create branch element
    */
    static function create()
    {
        $branch = new eZNetModuleBranch( array( 'status' => eZNetModuleBranch::StatusDraft,
                                                'created' => time(),
                                                'creator_id' => eZUser::currentUserID() ) );
        $branch->store();

        return $branch;
    }

    /*!
     \static
    */
    static function fetch( $id,
                           $status = eZNetModuleBranch::StatusPublished,
                           $asObject = true )
    {
        return eZNetModuleBranch::fetchObject( eZNetModuleBranch::definition(),
                                               null,
                                               array( 'id' => $id,
                                                      'status' => $status ),
                                               $asObject );
    }

    /*!
     \static

     Fetch draft

     \param Branch ID
     \param force, if force creation of draft.
     \param $asObject
    */
    static function fetchDraft( $id, $force = true, $asObject = true )
    {
        $branch = eZNetModuleBranch::fetch( $id, eZNetModuleBranch::StatusDraft, $asObject );
        if ( !$branch &&
             $force )
        {
            $branch = eZNetModuleBranch::fetch( $id, eZNetModuleBranch::StatusPublished, $asObject );
            if ( $branch )
            {
                $branch->setAttribute( 'status', eZNetModuleBranch::StatusDraft );
                $branch->store();
            }
        }

        if ( !$branch )
        {
            return false;
        }
        return $branch;

    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'version_value':
            {
                // First check extension for version information
                $extensionInfo = eZNetUtils::extensionInfo( $this->attribute( 'version_identifier' ) );
                if ( $extensionInfo !== null )
                {
                    $retVal = $extensionInfo['version'];
                }
                // If it does not exsist, check extension for information.
                else
                {
                    $db = eZDB::instance();
                    $sql = 'SELECT value FROM ezsite_data WHERE name=\'' . $db->escapeString( $this->attribute( 'version_identifier' ) ) . '\'';
                    $result = $db->arrayQuery( $sql );
                    if ( count( $result ) )
                    {
                        $retVal = $result[0]['value'];
                    }
                }
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'branch':
            {
                if ( $this->attribute( 'branch_id' ) )
                {
                    $retVal = eZNetBranch::fetch( $this->attribute( 'branch_id' ) );
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
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetModuleBranch::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetModuleBranch::fetchDraft( $this->attribute( 'id' ),
                                                false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
      \static
      Remove all objects of \a id
    */
    static function removeAll( $id )
    {
        eZNetModuleBranch::removeObject( eZNetModuleBranch::definition(),
                                         array( 'id' => $id ) );
    }

    /*!
     \static

     Fetch branch list
    */
    static function fetchList( $offset = 0,
                               $limit = 20,
                               $status = self::StatusPublished,
                               $asObject = true,
                               array $sort = array( 'id' => 'asc' ) )
    {
        return eZNetModuleBranch::fetchObjectList( self::definition(),
                                                   null,
                                                   array( 'status' => $status ),
                                                   $sort,
                                                   array( 'limit' => $limit,
                                                          'offset' => $offset ),
                                                   $asObject );
    }

    /**
     * Fetch branch list count
     *
     * @param int $status
     * @return int
     */
    static function fetchListCount( $status = self::StatusPublished )
    {
        return eZPersistentObject::count( self::definition(), array( 'status' => $status ) );
    }

    /**
     * Fetches the eZNetModuleBranch items the current module branch depends on
     * @return array( eZNetModuleBranchDependency )
    */
    public function fetchUncertifiedDependencies()
    {
        return eZNetModuleBranchDependency::fetchUncertifiedDependencies( $this );
    }

    /**
     * Fetches the eZNetModuleBranch objects that the current module can depend on
     * This excludes branches of the same module and belonging to a different eZNetBranch
     */
    public function possibleDependencies()
    {
        return eZNetModuleBranch::fetchObjectList(
            eZNetModuleBranch::definition(),
            null,
            array(
                'version_identifier' => array( '<>', $this->attribute( 'version_identifier' ) ),
                'status' => eZNetModuleBranch::StatusPublished,
                'branch_id' => $this->attribute( 'branch_id' )
            )
        );
    }

    /*
     Fetches the array of this module dependencies IDs
    */
    public function dependenciesIDArray()
    {
        $return = array();

        $list = eZNetModuleBranchDependency::fetchDependsModulesList( $this, $asObject = false );
        eZDebug::writeDebug( $list, __METHOD__ );
        foreach( $list as $item )
        {
            $return[] = $item['depends_on_module_branch_id'];
        }
        return $return;
    }
}

?>
