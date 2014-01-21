<?php
/**
 * File containing eZNetIssue class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetIssue eznetissue.php
  \brief The class eZNetIssue does

*/
class eZNetIssue extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;

    /*!
     Constructor
    */
    function eZNetIssue( $row )
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
                                         'title' => array( 'name' => 'Title',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                         'public_wit_id' => array( 'name' => 'PublicWITID',
                                                                   'datatype' => 'integer',
                                                                   'default' => 0,
                                                                   'required' => true ),
                                         'private_wit_ids' => array( 'name' => 'PrivateWITIDs',
                                                                     'datatype' => 'string',
                                                                     'default' => '',
                                                                     'required' => true ),
                                         'jira_id' => array( 'name' => 'JiraID',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ),
                                         'description' => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'approver_id' => array( 'name' => 'ApproverID',
                                                                 'datatype' => 'integer',
                                                                 'default' => 0,
                                                                 'required' => true ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'status' => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ) ),
                      'keys' => array( 'id', 'status' ),
                      'function_attributes' => array( 'creator' => 'creator',
                                                      'approver' => 'approver',
                                                      'branches' => 'branches',
                                                      'module_branches' => 'module_branches',
                                                      'branches_converted' => 'branches_converted',
                                                      'branches_mixed' => 'branches_mixed',
                                                      'patches' => 'patches',
                                                      'module_patches' => 'module_patches',
                                                      'patches_mixed' => 'patches_mixed',
                                                      'issue_items' => 'issue_items' ),
                      'increment_key' => 'id',
                      'class_name' => 'eZNetIssue',
                      'sort' => array( 'created' => 'desc' ),
                      'name' => 'ezx_ezpnet_issue' );
    }

    /*!
     \static

     Create issue element
    */
    static function create()
    {
        $issue = new eZNetIssue( array( 'status' => self::StatusDraft,
                                        'created' => time(),
                                        'creator_id' => eZUser::currentUserID() ) );
        $issue->store();

        return $issue;
    }

    /*!
     \reimp

     Make sure issue items are removed before the issue itself
    */
    function remove( $conditions = null, $extraConditions = null )
    {
        $issueItems = eZNetIssueItem::fetchListByIssueID( $this->attribute( 'id' ), $this->attribute( 'status' ) );
        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem instanceof eZNetIssueItem )
            {
                $issueItem->remove();
            }
        }

        parent::remove( $conditions, $extraConditions );
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

     Fetch draft

     \param Issue ID
     \param force, if force creation of draft.
     \param $asObject
    */
    static function fetchDraft( $id, $force = true, $asObject = true )
    {
        $issue = self::fetch( $id, self::StatusDraft, $asObject );
        if ( !$issue &&
             $force )
        {
            $issue = self::fetch( $id, self::StatusPublished, $asObject );
            if ( $issue )
            {
                $issue->setAttribute( 'status', self::StatusDraft );
                $issue->store();
            }
        }

        if ( !$issue )
        {
            return false;
        }
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
            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'approver':
            {
                $retVal = eZUser::fetch( $this->attribute( 'approver_id' ) );
            } break;

            case 'branches': // Branches only
            {
                $retVal = eZNetIssueItem::fetchBranchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchBranchesOnly );
            } break;

            case 'module_branches': // Module branches only
            {
                $retVal = eZNetIssueItem::fetchBranchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchModuleBranchesOnly );
            } break;

            case 'branches_converted': // Branches only, fetch branches for module branches
            {
                $retVal = eZNetIssueItem::fetchBranchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchBranchesConverted );
            } break;

            case 'branches_mixed': // Branches and module branches
            {
                $retVal = eZNetIssueItem::fetchBranchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchBranchesMixed );
            } break;

            case 'patches': // Patches only
            {
                $retVal = eZNetIssueItem::fetchPatchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchPatchesOnly );
            } break;

            case 'module_patches': // Module patches only
            {
                $retVal = eZNetIssueItem::fetchPatchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchModulePatchesOnly );
            } break;

            case 'patches_mixed': // Patches and module patches
            {
                $retVal = eZNetIssueItem::fetchPatchesByIssueID( $this->attribute( 'id' ), eZNetIssueItem::FetchPatchesMixed );
            } break;

            case 'issue_items':
            {
                $retVal = eZNetIssueItem::fetchListByIssueID( $this->attribute( 'id' ) );
            } break;

            default:
            {
                $retVal = parent::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \reimp
    */
    function setAttribute( $attr, $value )
    {
        switch( $attr )
        {
            case 'branches':
            {
                $selectedBranches = ( is_array( $value ) ) ? $value : array();
                $hasBranches = array();
                $currentBranchList = $this->attribute( 'branches' );
                foreach ( $currentBranchList as $currentBranch )
                {
                    $hasBranches[] = $currentBranch->attribute( 'id' );
                }

                $addBranches = array_diff( $selectedBranches, $hasBranches );
                $removeBranches = array_diff( $hasBranches, $selectedBranches );

                foreach ( $addBranches as $branchID )
                {
                    $this->connectToBranch( $branchID );
                }

                foreach ( $removeBranches as $branchID )
                {
                    $issueItems = eZNetIssueItem::fetchListByBranchID( $branchID, $this->attribute( 'id' ) );
                    foreach ( $issueItems as $issueItem )
                    {
                        $issueItem->remove();
                    }
                }
            } break;

            case 'module_branches':
            {
                $selectedBranches = ( is_array( $value ) ) ? $value : array();
                $hasBranches = array();
                $currentBranchList = $this->attribute( 'module_branches' );
                foreach ( $currentBranchList as $currentBranch )
                {
                    $hasBranches[] = $currentBranch->attribute( 'id' );
                }

                $addBranches = array_diff( $selectedBranches, $hasBranches );
                $removeBranches = array_diff( $hasBranches, $selectedBranches );

                foreach ( $addBranches as $branchID )
                {
                    $this->connectToModuleBranch( $branchID );
                }

                foreach ( $removeBranches as $branchID )
                {
                    $issueItems = eZNetIssueItem::fetchListByModuleBranchID( $branchID, $this->attribute( 'id' ) );
                    foreach ( $issueItems as $issueItem )
                    {
                        $issueItem->remove();
                    }
                }
            } break;

            default:
            {
                parent::setAttribute( $attr, $value );
            } break;
        }
    }

    /*!
     Approve issue
    */
    function approve()
    {
        $this->setAttribute( 'approver_id', eZUser::currentUserID() );
        $this->setAttribute( 'modified', time() );
        $this->publish();
    }

    /*!
     Reject issue
    */
    function reject()
    {
        $this->setAttribute( 'approver_id', false );
        $this->setAttribute( 'modified', time() );
        $this->publish();
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
     Add issue item that links this issue to the given branch ID
    */
    function connectToBranch( $branchID )
    {
        $issueItem = eZNetIssueItem::create( $this->attribute( 'id' ) );
        $issueItem->setAttribute( 'branch_id', $branchID );
        $issueItem->publish();
    }

    /*!
     Add issue item that links this issue to the given module branch ID
    */
    function connectToModuleBranch( $branchID )
    {
        $issueItem = eZNetIssueItem::create( $this->attribute( 'id' ) );
        $issueItem->setAttribute( 'module_branch_id', $branchID );
        $issueItem->publish();
    }

    /*!
     Add issue item that links this issue to the given patch ID
    */
    function connectToPatch( $patchID )
    {
        $patch = eZNetPatch::fetch( $patchID );
        if ( !( $patch instanceof eZNetPatch ) )
            return false;

        $issueID = $this->attribute( 'id' );
        $branchID = $patch->attribute( 'branch_id' );

        // If there already is an issue item for the branch id given by the patch id, then use that, else create a new one.
        $existingIssueItems = eZNetIssueItem::fetchListByBranchID( $branchID, $issueID );
        foreach ( $existingIssueItems as $item )
        {
            if ( $item->attribute( 'patch_id' ) == 0 )
            {
                $item->setAttribute( 'patch_id', $patchID );
                $item->store();
                return true;
            }
        }

        $issueItem = eZNetIssueItem::create( $issueID );
        $issueItem->setAttribute( 'patch_id', $patchID );
        $issueItem->setAttribute( 'branch_id', $branchID );
        $issueItem->publish();
        return true;
    }

    /*!
     Add issue item that links this issue to the given module patch ID
    */
    function connectToModulePatch( $patchID )
    {
        $patch = eZNetModulePatch::fetch( $patchID );
        if ( !( $patch instanceof eZNetModulePatch ) )
            return false;

        $issueID = $this->attribute( 'id' );
        $branchID = $patch->attribute( 'module_branch_id' );

        // If there already is an issue item for the branch id given by the patch id, then use that, else create a new one.
        $existingIssueItems = eZNetIssueItem::fetchListByModuleBranchID( $branchID, $issueID );
        foreach ( $existingIssueItems as $item )
        {
            if ( $item->attribute( 'module_patch_id' ) == 0 )
            {
                $item->setAttribute( 'module_patch_id', $patchID );
                $item->store();
                return true;
            }
        }

        $issueItem = eZNetIssueItem::create( $issueID );
        $issueItem->setAttribute( 'module_patch_id', $patchID );
        $issueItem->setAttribute( 'module_branch_id', $branchID );
        $issueItem->publish();

        return true;
    }

    /*!
     Unlink this issue from the given patch ID
    */
    function disconnectFromPatch( $patchID )
    {
        $patch = eZNetPatch::fetch( $patchID );
        if ( !( $patch instanceof eZNetPatch ) )
            return false;

        // Only allow unlinking of issues before the patch is published
        if ( in_array( $patch->attribute( 'status' ), array( eZNetPatch::StatusFinal, eZNetPatch::StatusSecurity ) ) )
            return false;

        $issueID = $this->attribute( 'id' );
        $branchID = $patch->attribute( 'branch_id' );

        $existingIssueItems = eZNetIssueItem::fetchListByBranchID( $branchID, $issueID );
        foreach ( $existingIssueItems as $item )
        {
            if ( $item->attribute( 'patch_id' ) == $patchID )
            {
                $item->setAttribute( 'patch_id', 0 );
                $item->store();
                break;
            }
        }

        return true;
    }

    /*!
     Unlink this issue from the given module patch ID
    */
    function disconnectFromModulePatch( $patchID )
    {
        $patch = eZNetModulePatch::fetch( $patchID );
        if ( !( $patch instanceof eZNetModulePatch ) )
            return false;

        // Only allow unlinking of issues before the patch is published
        if ( in_array( $patch->attribute( 'status' ), array( eZNetModulePatch::StatusFinal, eZNetModulePatch::StatusSecurity ) ) )
            return false;

        $issueID = $this->attribute( 'id' );
        $branchID = $patch->attribute( 'module_branch_id' );

        $existingIssueItems = eZNetIssueItem::fetchListByModuleBranchID( $branchID, $issueID );
        foreach ( $existingIssueItems as $item )
        {
            if ( $item->attribute( 'module_patch_id' ) == $patchID )
            {
                $item->setAttribute( 'module_patch_id', 0 );
                $item->store();
                break;
            }
        }

        return true;
    }

    /*!
     \static

     Fetch issue list
    */
    static function fetchList( $offset = 0,
                               $limit = 20,
                               $status = self::StatusPublished,
                               $asObject = true,
                               array $sort = array( 'created' => 'desc' ) )
    {
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        array( 'status' => $status ),
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
    static function fetchListCount( $status = self::StatusPublished )
    {
        return (integer) parent::count( self::definition(), array( 'status' => $status ) );
    }

    /*!
     \static

     Fetch issue list by branch ID (single ID or array of IDs)
    */
    static function fetchListByBranch( $branchID,
                                       $distributionStatus = null,
                                       $offset = 0,
                                       $limit = 20,
                                       $status = self::StatusPublished,
                                       $asObject = true,
                                       array $sort = array( 'created' => 'desc' ) )
    {
        if ( is_array( $branchID ) )
        {
            $branchID = implode( ',', $branchID );
        }

        if ( is_array( $distributionStatus ) )
        {
            $distributionStatus = array_shift( $distributionStatus ); // There can be only one
        }

        // Match distribution statuses to patch statuses
        if ( $distributionStatus == 'ok' ) // Distributed
        {
            $distributionStatus = '3,5'; // Final or Security
        }
        else if ( $distributionStatus == 's' ) // Scheduled
        {
            $distributionStatus = '0,1,2'; // Alpha, Beta, or RC
        }
        else if ( $distributionStatus != 'x' ) // We don't care about distribution status
        {
            $distributionStatus = '';
        }
        // else: $distributionStatus == 'x' - Affects branch, but no patch exists

        $issueDef = eZNetIssue::definition();
        $issueItemDef = eZNetIssueItem::definition();
        $patchDef = eZNetPatch::definition();

        $field_filters = array( 'ezx_ezpnet_issue.*' );
        $conds = array( $issueDef['name'] . '.status' => $status );
        $limit = array( 'limit' => $limit,
                        'offset' => $offset );
        // Workaround for column name ambiguity issue: Enter every needed field of the second table specifically.
        $custom_fields = array( $issueDef['name'] . '.*',
                                $issueItemDef['name'] . '.id AS issue_item_id',
                                $issueItemDef['name'] . '.branch_id',
                                $issueItemDef['name'] . '.module_branch_id',
                                $issueItemDef['name'] . '.patch_id',
                                $issueItemDef['name'] . '.module_patch_id',
                                $issueItemDef['name'] . '.status  AS issue_item_status' );
        $custom_tables = array( $issueItemDef['name'] );
        $custom_conds = ' AND ' . $issueDef['name'] . '.id = ' . $issueItemDef['name'] . '.issue_id';

        if ( $distributionStatus === '' ) // If not filtering by distribution status, select branch from issue item, since there is no patch
        {
            $custom_conds .= ' AND ' . $issueItemDef['name'] . ".branch_id IN ( $branchID )";
        }
        else if ( $distributionStatus === 'x' ) // Affects branch, but no patch exists
        {
            $custom_conds .= ' AND ' . $issueItemDef['name'] . ".branch_id IN ( $branchID )" .
                             ' AND ' . $issueItemDef['name'] . '.patch_id = 0';
        }
        else // Otherwise, select branch from patch, since we can't use issue item links to branch and patch simultaneously
        {
            $custom_tables[] = $patchDef['name'];
            $custom_conds .= ' AND ' . $issueItemDef['name'] . '.patch_id = ' . $patchDef['name'] . '.id' .
                             ' AND ' . $patchDef['name'] . ".branch_id IN ( $branchID )" .
                             ' AND ' . $patchDef['name'] . ".status IN ( $distributionStatus )" .
                             ' AND ' . $patchDef['name'] . ".version_status = $status";
        }

        return parent::fetchObjectList( self::definition(),
                                        $field_filters,
                                        $conds,
                                        $sort,
                                        $limit,
                                        $asObject,
                                        false,
                                        $custom_fields,
                                        $custom_tables,
                                        $custom_conds );
    }

    /**
     * Fetch issue list count by branch ID (single ID or array of IDs)
     *
     * @param int $branchID
     * @param int $distributionStatus
     * @param int $status
     * @return int
     */
    static function fetchListCountByBranch( $branchID = null,
                                            $distributionStatus = null,
                                            $status = self::StatusPublished )
    {
        // This is not efficient, but necessary since eZPersistentObject::count() doesn't support custom conditions
        return count( self::fetchListByBranch( $branchID, $distributionStatus, 0, false, $status, false ) );
    }

    /*!
     \static

     Fetch issue list by module branch ID (single ID or array of IDs)
    */
    static function fetchListByModuleBranch( $branchID,
                                             $offset = 0,
                                             $limit = 20,
                                             $status = self::StatusPublished,
                                             $asObject = true,
                                             array $sort = array( 'created' => 'desc' ) )
    {
        if ( is_array( $branchID ) )
        {
            $branchID = implode( ',', $branchID );
        }

        $issueDef = eZNetIssue::definition();
        $issueItemDef = eZNetIssueItem::definition();

        return parent::fetchObjectList( self::definition(),
                                        array( 'ezx_ezpnet_issue.*' ),
                                        array( $issueDef['name'] . '.status' => $status ),
                                        $sort,
                                        array( 'limit' => $limit,
                                               'offset' => $offset ),
                                        $asObject,
                                        false,
                                        // Workaround for column name ambiguity issue
                                        // array( $issueDef['name'] . '.*', $issueItemDef['name'] . '.*' ),
                                        array( $issueDef['name'] . '.*',
                                               $issueItemDef['name'] . '.id AS issue_item_id',
                                               $issueItemDef['name'] . '.branch_id',
                                               $issueItemDef['name'] . '.module_branch_id',
                                               $issueItemDef['name'] . '.patch_id',
                                               $issueItemDef['name'] . '.module_patch_id',
                                               $issueItemDef['name'] . '.status  AS issue_item_status' ),
                                        array( $issueItemDef['name'] ),
                                        ' AND ' . $issueDef['name'] . '.id = ' . $issueItemDef['name'] . '.issue_id AND ' . $issueItemDef['name'] . ".module_branch_id IN ( $branchID )" );
    }

    /**
     \static

     Fetch issue list count by branch ID (single ID or array of IDs)

     @param int $branchID
     @param int $status
     @return int
     */
    static function fetchListCountByModuleBranch( $branchID = null,
                                                  $status = self::StatusPublished )
    {
        // This is not efficient, but necessary since eZPersistentObject::count() doesn't support custom conditions
        return count( self::fetchListByModuleBranch( $branchID, 0, false, $status, false ) );
    }

    /*!
     \static

     Search by certain criteria.

     $params = array( 'jira_id' => $http->postVariable( 'JiraID' ),
                      'public_wit_id' => $http->postVariable( 'PublicWITID' ),
                      'private_wit_ids' => $http->postVariable( 'PrivateWITIDs' ),
                      'title' => $http->postVariable( 'Title' ) );

    'jira_id' must be an exact match.
    'public_wit_id' must be an exact match.
    'private_wit_ids' can be a partial match.
    'title' can be a partial match.

     @param int $params
     @param int $offset
     @param int $limit
     @return array
    */
    static function search( $params,
                            $offset = 0,
                            $limit = 20,
                            $asObject = true )
    {
        $conds = array();
        if ( isset( $params['jira_id'] ) && $params['jira_id'] != '' )
        {
            $conds['jira_id'] = $params['jira_id'];
        }
        if ( isset( $params['public_wit_id'] ) && is_numeric( $params['public_wit_id'] ) )
        {
            $conds['public_wit_id'] = $params['public_wit_id'];
        }

        $custom_conds = '';
        if ( isset( $params['private_wit_ids'] ) && $params['private_wit_ids'] != '' )
        {
            if ( count( $conds ) == 0 )
                $custom_conds .= ' WHERE ';
            else
                $custom_conds .= ' AND ';
            $custom_conds .= 'private_wit_ids LIKE "%' . $params['private_wit_ids'] . '%"';
        }
        if ( isset( $params['title'] ) && $params['title'] != '' )
        {
            if ( count( $conds ) == 0 && $custom_conds == '' )
                $custom_conds .= ' WHERE ';
            else
                $custom_conds .= ' AND ';
            $custom_conds .= 'title LIKE "%' . $params['title'] . '%"';
        }

        return parent::fetchObjectList( self::definition(),
                                        null,
                                        $conds,
                                        array( 'created' => 'desc' ),
                                        array( 'limit' => $limit,
                                               'offset' => $offset ),
                                        $asObject,
                                        false,
                                        null,
                                        null,
                                        $custom_conds );
    }

    /**
     \static

     Search by certain criteria, and return the count. See search().

     @param int $params
     @return int
     */
    static function searchCount( $params )
    {
        return count( self::search( $params, 0, false, false ) );
    }

    /*!
     \static

     Fetch issue list by public wIT ID
    */
    static function fetchListByPublicWITID( $publicWITID,
                                            $status = self::StatusPublished,
                                            $asObject = true,
                                            array $sort = array( 'created' => 'desc' ) )
    {
        return parent::fetchObjectList( self::definition(),
                                        null,
                                        array( 'public_wit_id' => $publicWITID ),
                                        $sort,
                                        false,
                                        $asObject );
    }

    /*!
     \static
    */
    static function fetchListByPatchID( $patchID,
                                        $status = self::StatusPublished,
                                        $asObject = true )
    {
        $issues = array();
        $issueItems = eZNetIssueItem::fetchListByPatchID( $patchID, null, $status, $asObject );
        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem instanceof eZNetIssueItem )
            {
                $issueID = $issueItem->attribute( 'issue_id' );
            }
            else
            {
                $issueID = $issueItem['issue_id'];
            }

            $issues[] = self::fetch( $issueID, $status, $asObject );
        }

        return $issues;
    }

    /*!
     \static
    */
    static function fetchListCountByPatchID( $patchID,
                                             $status = self::StatusPublished )
    {
        return eZNetIssueItem::fetchListCountByPatchID( $patchID, $status );
    }

    /*!
     \static
    */
    static function fetchListByModulePatchID( $modulePatchID,
                                              $status = self::StatusPublished,
                                              $asObject = true )
    {
        $issues = array();
        $issueItems = eZNetIssueItem::fetchListByModulePatchID( $modulePatchID, null, $status, $asObject );
        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem instanceof eZNetIssueItem )
            {
                $issueID = $issueItem->attribute( 'issue_id' );
            }
            else
            {
                $issueID = $issueItem['issue_id'];
            }

            $issues[] = self::fetch( $issueID, $status, $asObject );
        }

        return $issues;
    }

    /*!
     \static
    */
    static function fetchListCountByModulePatchID( $modulePatchID,
                                                   $status = self::StatusPublished )
    {
        return eZNetIssueItem::fetchListCountByModulePatchID( $modulePatchID, $status );
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
        $issues = array();
        $issueItems = eZNetIssueItem::fetchListByExtension( $extension, $offset, $limit, $status, $asObject );

        foreach ( $issueItems as $issueItem )
        {
            if ( $issueItem instanceof eZNetIssueItem )
            {
                $issueID = $issueItem->attribute( 'issue_id' );
            }
            else
            {
                $issueID = $issueItem['issue_id'];
            }

            $issues[] = self::fetch( $issueID, $status, $asObject );
        }

        return $issues;
    }

    /*!
     \static
    */
    static function fetchListCountByExtension( $extension,
                                               $status = self::StatusPublished )
    {
        return eZNetIssueItem::fetchListCountByExtension( $extension, $status );
    }
}

?>
