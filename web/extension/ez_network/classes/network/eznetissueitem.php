<?php
/**
 * File containing eZNetIssueItem class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetIssueItem eznetissueitem.php
  \brief The class eZNetIssueItem does

*/
class eZNetIssueItem extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    const FetchBranchesOnly = 0;
    const FetchModuleBranchesOnly = 1;
    const FetchBranchesConverted = 2;
    const FetchBranchesMixed = 3;

    const FetchPatchesOnly = 0;
    const FetchModulePatchesOnly = 1;
    const FetchPatchesMixed = 2;

    /*!
     Constructor
    */
    function eZNetIssueItem( $row )
    {
        $this->NetUtils = new eZNetUtils();
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( 'fields' => array( 'id' => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'issue_id' => array( 'name' => 'IssueID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'branch_id' => array( 'name' => 'BranchID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'module_branch_id' => array( 'name' => 'ModuleBranchID',
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true ),
                                         'patch_id' => array( 'name' => 'PatchID',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'module_patch_id' => array( 'name' => 'ModulePatchID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ) ),
                      'keys' => array( 'id' ),
                      'function_attributes' => array( 'issue' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZNetIssueItem',
                      'sort' => array( 'id' => 'asc' ),
                      'name' => 'ezx_ezpnet_issue_item' );
    }

    /*!
     \static

     Create issue item element
    */
    static function create( $issueID )
    {
        $issue = new eZNetIssueItem( array( 'status' => self::StatusDraft,
                                            'issue_id' => $issueID ) );
        $issue->store();

        return $issue;
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'issue':
            {
                $retVal = eZNetIssue::fetch( $this->attribute( 'issue_id' ) );
            } break;

            default:
            {
                $retVal = parent::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \static
    */
    static function fetch( $id,
                           $status = self::StatusPublished,
                           $asObject = true )
    {
        return parent::fetchObject( self::definition(),
                                    null,
                                    array( 'id' => $id,
                                           'status' => $status ),
                                    $asObject );
    }

    /*!
     \static
    */
    static function fetchListByIssueID( $issueID,
                                        $status = self::StatusPublished,
                                        $asObject = true )
    {
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        array( 'issue_id' => $issueID,
                                               'status' => $status ),
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListByBranchID( $branchID,
                                         $issueID = null,
                                         $status = self::StatusPublished,
                                         $asObject = true )
    {
        $filter = array( 'branch_id' => $branchID,
                         'status' => $status );
        if ( $issueID )
        {
            $filter['issue_id'] = $issueID;
        }
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $filter,
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListByModuleBranchID( $moduleBranchID,
                                               $issueID = null,
                                               $status = self::StatusPublished,
                                               $asObject = true )
    {
        $filter = array( 'module_branch_id' => $moduleBranchID,
                         'status' => $status );
        if ( $issueID )
        {
            $filter['issue_id'] = $issueID;
        }
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $filter,
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListByPatchID( $patchID,
                                        $issueID = null,
                                        $status = self::StatusPublished,
                                        $asObject = true )
    {
        $filter = array( 'patch_id' => $patchID,
                         'status' => $status );
        if ( $issueID )
        {
            $filter['issue_id'] = $issueID;
        }
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $filter,
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListCountByPatchID( $patchID,
                                             $status = self::StatusPublished )
    {
        $filter = array( 'patch_id' => $patchID,
                         'status' => $status );
        $custom = array( array( 'operation' => 'count( id )',
                                'name' => 'count' ) );
        $rows = parent::fetchObjectList( self::definition(),
                                         array(),
                                         $filter,
                                         null,
                                         null,
                                         false,
                                         false,
                                         $custom );
        return $rows[0]['count'];
    }

    /*!
     \static
    */
    static function fetchListByModulePatchID( $modulePatchID,
                                              $issueID = null,
                                              $status = self::StatusPublished,
                                              $asObject = true )
    {
        $filter = array( 'module_patch_id' => $modulePatchID,
                         'status' => $status );
        if ( $issueID )
        {
            $filter['issue_id'] = $issueID;
        }
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $filter,
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListCountByModulePatchID( $modulePatchID,
                                                   $status = self::StatusPublished )
    {
        $filter = array( 'module_patch_id' => $modulePatchID,
                         'status' => $status );
        $custom = array( array( 'operation' => 'count( id )',
                                'name' => 'count' ) );
        $rows = parent::fetchObjectList( self::definition(),
                                         array(),
                                         $filter,
                                         null,
                                         null,
                                         false,
                                         false,
                                         $custom );
        return $rows[0]['count'];
    }

    /*!
     \static
    */
    static function fetchListByExtension( $extension,
                                          $offset = 0,
                                          $limit = 20,
                                          $status = self::StatusPublished,
                                          $asObject = true )
    {
        $db = eZDB::instance();

        $query = "SELECT ezx_ezpnet_issue_item.*
                  FROM ezx_ezpnet_issue_item, ezx_ezpnet_module_branch
                  WHERE ezx_ezpnet_issue_item.status = $status
                    AND ezx_ezpnet_issue_item.module_branch_id = ezx_ezpnet_module_branch.id
                    AND ezx_ezpnet_module_branch.version_identifier IN ('" . implode( "','", $extension ) . "')
                  ORDER BY ezx_ezpnet_issue_item.id ASC
                  LIMIT $offset, $limit";

        $rows = $db->arrayQuery( $query );

        if ( $asObject )
        {
            $objectList = array();
            foreach ( $rows as $row )
            {
                $objectList[] = self::fetch( $row['id'] );
            }
            return $objectList;
        }
        else
        {
            return $rows;
        }
    }

    /*!
     \static
    */
    static function fetchListCountByExtension( $extension,
                                               $status = self::StatusPublished )
    {
        $db = eZDB::instance();

        $query = "SELECT count(ezx_ezpnet_issue_item.id) AS count
                  FROM ezx_ezpnet_issue_item, ezx_ezpnet_module_branch
                  WHERE ezx_ezpnet_issue_item.status = $status
                    AND ezx_ezpnet_issue_item.module_branch_id = ezx_ezpnet_module_branch.id
                    AND ezx_ezpnet_module_branch.version_identifier IN ('" . implode( "','", $extension ) . "')";

        $rows = $db->arrayQuery( $query );

        return $rows[0]['count'];
    }

    /*!
     \static

     Fetch branches and/or module branches, by issue ID

     \param issueID issue ID
     \param fetchType fetch type, see consts
     \param $status
     \param $asObject
    */
    static function fetchBranchesByIssueID( $issueID,
                                            $fetchType,
                                            $status = self::StatusPublished,
                                            $asObject = true )
    {
        $issueItems = parent::fetchObjectList( self::definition(),
                                               null,
                                               array( 'issue_id' => $issueID,
                                                      'status' => $status ),
                                               null,
                                               null,
                                               false ); // No need to fetch these as objects

        $branches = array();
        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem['branch_id'] != 0 )
            {
                if ( $fetchType == self::FetchModuleBranchesOnly ) // Module branches only, ignore branches
                    continue;

                $branch = eZNetBranch::fetch( $issueItem['branch_id'] );
                if ( $branch instanceof eZNetBranch )
                    $branches[] = $branch;
            }
            else if ( $issueItem['module_branch_id'] != 0 )
            {
                if ( $fetchType == self::FetchBranchesOnly ) // Branches only, ignore module branches
                    continue;

                $moduleBranch = eZNetModuleBranch::fetch( $issueItem['module_branch_id'] );
                if ( $moduleBranch instanceof eZNetModuleBranch )
                {
                    if ( $fetchType == self::FetchBranchesConverted ) // Fetch branches for module branches (convert)
                    {
                        $branch = $moduleBranch->attribute( 'branch' );
                        if ( $branch instanceof eZNetBranch )
                        {
                            $branches[] = $branch;
                        }
                    }
                    else // self::FetchBranchesMixed, return branches and module branches in the same array
                    {
                        $branches[] = $moduleBranch;
                    }
                }
            }
        }

        return $branches;
    }

    /*!
     \static

     Fetch patches and/or module patches, by issue ID

     \param issueID issue ID
     \param fetchType fetch type, see consts
     \param $status
     \param $asObject
    */
    static function fetchPatchesByIssueID( $issueID,
                                           $fetchType,
                                           $status = self::StatusPublished,
                                           $asObject = true )
    {
        $issueItems = parent::fetchObjectList( self::definition(),
                                               null,
                                               array( 'issue_id' => $issueID,
                                                      'status' => $status ),
                                               null,
                                               null,
                                               false ); // No need to fetch these as objects

        $patches = array();
        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem['patch_id'] != 0 )
            {
                if ( $fetchType == self::FetchModulePatchesOnly ) // Module patches only, ignore patches
                    continue;

                $patch = eZNetPatch::fetch( $issueItem['patch_id'] );
                if ( $patch instanceof eZNetPatch &&
                     $patch->attribute( 'status' ) != eZNetPatchBase::StatusRemoved )
                    $patches[] = $patch;
            }
            else if ( $issueItem['module_patch_id'] != 0 )
            {
                if ( $fetchType == self::FetchPatchesOnly ) // Patches only, ignore module patches
                    continue;

                $modulePatch = eZNetModulePatch::fetch( $issueItem['module_patch_id'] );
                if ( $modulePatch instanceof eZNetModulePatch &&
                     $modulePatch->attribute( 'status' ) != eZNetPatchBase::StatusRemoved )
                    $patches[] = $modulePatch;
            }
        }

        return $patches;
    }

    /*!
     \static

     Fetch draft

     \param ID issue item ID
     \param force, if force creation of draft.
     \param $asObject
    */
    static function fetchDraft( $id, $force = true, $asObject = true )
    {
        $issueItem = self::fetch( $id, self::StatusDraft, $asObject );
        if ( !($issueItem instanceof eZNetIssueItem) && $force )
        {
            $issueItem = self::fetch( $id, self::StatusPublished, $asObject );
            if ( ($issueItem instanceof eZNetIssueItem) )
            {
                $issueItem->setAttribute( 'status', self::StatusDraft );
                $issueItem->store();
            }
        }

        if ( !($issueItem instanceof eZNetIssueItem) )
        {
            return false;
        }
        return $issueItem;
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', self::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = self::fetchDraft( $this->attribute( 'id' ), 
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
        parent::removeObject( self::definition(),
                              array( 'id' => $id ) );
    }

    /*!
     \static

     Fetch issue list
    */
    static function fetchList( $offset = 0,
                               $limit = 20,
                               $branchID = null,
                               $status = self::StatusPublished,
                               $asObject = true,
                               array $sort = array( 'created' => 'desc' ) )
    {
        $filter = array( 'status' => $status );
        if ( $branchID )
            $filter['branch_id'] = $branchID;
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $filter,
                                        $sort,
                                        array( 'limit' => $limit,
                                               'offset' => $offset ),
                                        $asObject );
    }

    /**
     * Fetch issue list count
     *
     * @param int $status
     * @return int
     */
    static function fetchListCount( $branchID = null,
                                    $status = self::StatusPublished )
    {
        $filter = array( 'status' => $status );
        if ( $branchID )
            $filter['branch_id'] = $branchID;
        return parent::count( self::definition(), $filter );
    }
}

?>
