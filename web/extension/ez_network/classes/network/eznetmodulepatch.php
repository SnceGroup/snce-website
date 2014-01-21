<?php
/**
 * File containing eZNetModulePatch class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetModulePatch eznetmodulepatch.php
  \brief The class eZNetModulePatch does

*/
class eZNetModulePatch extends eZNetPatchBase
{
    /*!
     Constructor
    */
    function eZNetModulePatch( $rows = array() )
    {
        $this->eZNetPatchBase( $rows );
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
                                         "module_branch_id" => array( 'name' => 'ModuleBranchID',
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true,
                                                                      'foreign_class' => 'eZNetModuleBranch',
                                                                      'foreign_attribute' => 'id',
                                                                      'multiplicity' => '1..*' ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true ),
                                         'options' => array( 'name' => 'Options',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         'original_filename' => array( 'name' => 'OriginalFilename',
                                                                       'datatype' => 'string',
                                                                       'default' => '',
                                                                       'required' => true ),
                                         "required_patch_id" => array( 'name' => 'RequiredPatch',
                                                                       'datatype' => 'integer',
                                                                       'default' => 0,
                                                                       'required' => true,
                                                                       'foreign_class' => 'eZNetModulePatch',
                                                                       'foreign_attribute' => 'id',
                                                                       'multiplicity' => '0..1' ),
                                         'created' => array( 'name' => 'Created', // This starts out as the patch creation date, but on publishing it becomes the publishing date
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
                                         "filedata" => array( 'name' => 'Filedata',
                                                              'datatype' => 'longtext',
                                                              'default' => '',
                                                              'required' => true ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => false ),
                                         'version_status' => array( 'name' => 'VersionStatus',
                                                                    'datatype' => 'integer',
                                                                    'default' => 0,
                                                                    'required' => true,
                                                                    'keep_key' => true ),
                                         'status_info' => array( 'name' => 'StatusInfo',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ) ),
                      "keys" => array( "id", 'version_status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'patch_text_diff' => 'PatchTextDiff',
                                                      'patch_scripts' => 'patchScripts',
                                                      'ez_patch' => 'eZPatch',
                                                      'option_array' => 'optionArray',
                                                      'required_patch' => 'requiredPatch',
                                                      'module_branch' => 'moduleBranch',
                                                      'issues' => 'issues',
                                                      'issue_count' => 'issue_count' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetModulePatch",
                      "sort" => array( "created" => "asc" ),
                      "name" => "ezx_ezpnet_module_patch" );
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'module_branch':
            {

                $retVal = eZNetModuleBranch::fetch( $this->attribute( 'module_branch_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'issues':
            {
                $retVal = eZNetIssue::fetchListByModulePatchID( $this->attribute( 'id' ) );
            } break;

            case 'issue_count':
            {
                $retVal = eZNetIssue::fetchListCountByModulePatchID( $this->attribute( 'id' ) );
            } break;

            default:
            {
                $retVal = eZNetPatchBase::attribute( $attr );
            } break;
        }

        return $retVal;
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
                                                          $status = eZNetPatchBase::VersionStatusPublished )
    {

        $moduleBranchList = eZNetModuleBranch::fetchListBySiteID( $installationSiteID );
        $moduleBranchIDList = array();
        foreach( $moduleBranchList as $moduleBranch )
        {
            $moduleBranchIDList[] = $moduleBranch->attribute( 'id' );
        }

        return eZNetModulePatch::fetchObjectList( eZNetModulePatch::definition(),
                                                  array( 'id' ),
                                                  array( 'module_branch_id' => array( $moduleBranchIDList ),
                                                         'modified' => array( '>', $latestModified ),
                                                         'version_status' => $status ),
                                                  array( 'modified' => 'asc' ),
                                                  array( 'limit' => $limit,
                                                         'offset' => $offset ),
                                                  $asObject );
    }

    /*!
     \static
    */
    static function branchIDField()
    {
        return 'module_branch_id';
    }

    /*!
     \reimp
     \static

     Get eZNetPatch count

     \param version status ( optional )
     \param patch status ( optional )
    */
    static function countByStatus( $versionStatus = eZNetPatchBase::VersionStatusPublished,
                           $patchStatus = array( array( eZNetPatchBase::StatusAlpha,
                                                        eZNetPatchBase::StatusBeta,
                                                        eZNetPatchBase::StatusRC,
                                                        eZNetPatchBase::StatusFinal,
                                                        eZNetPatchBase::StatusSecurity ) ) )
    {
        return parent::countByStatusAndClass( $versionStatus, $patchStatus, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraft( $id,
                                $force = true,
                                $asObject = true )
    {
        return parent::fetchDraftByClass( $id, $force, $asObject, get_class() );
    }

    /*!
     \reimp
     \static

     Create new patch item
    */
    static function create( $branchID )
    {
        return parent::createByClass( $branchID, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch list branch id

     \param branch ID ( can also be list, example : array( array( 1, 2, 3 ) )
     \param patch status
     \param version status
     \param $asObject
     \param additional condition array ( optional )
    */
    static function fetchListByBranchID( $branchID,
                                         $status = array( array( eZNetPatchBase::StatusFinal,
                                                                 eZNetPatchBase::StatusSecurity ) ),
                                         $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                         $asObject = true,
                                         $extraConditions = array() )
    {
        return parent::fetchListByBranchIDAndClass( $branchID, $status, $versionStatus, $asObject, $extraConditions, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch list by required patch id

     \param required patch ID
     \param patch status
     \param version status
     \param $asObject
    */
    static function fetchListByRequiredPatchID( $requiredPatchID,
                                                $status = array( array( eZNetPatchBase::StatusFinal,
                                                                        eZNetPatchBase::StatusSecurity ) ),
                                                $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                                $asObject = true )
    {
        return parent::fetchListByRequiredPatchIDAndClass( $requiredPatchID, $status, $versionStatus, $asObject, get_class() );
    }

    /*!
     \reimp
     \static

     Fetch list of Network patches.
    */
    static function fetchList( $offset = 0,
                               $limit = 10,
                               $conds = array( 'status' => array( eZNetPatchBase::StatusFinal,
                                                                  eZNetPatchBase::StatusSecurity ) ),
                               $asObject = true,
                               array $sort = null )
    {
        // Fetch module patches limited by branch id, so need to add module branch to the query
        if ( array_key_exists( 'branch_id', $conds ) )
        {
            $modulePatchDef = eZNetModulePatch::definition();
            $moduleBranchDef = eZNetModuleBranch::definition();

            $customFields = array( $modulePatchDef['name'] . '.*',
                                   array( 'operation' => $moduleBranchDef['name'] . '.id AS mod_bran_id' ),
                                   array( 'operation' => $moduleBranchDef['name'] . '.branch_id' ) );

            $customTables = array( $moduleBranchDef['name'] );

            $customConds = ' AND ' . $modulePatchDef['name'] . '.module_branch_id = ' . $moduleBranchDef['name'] . '.id' .
                           ' AND ' . $moduleBranchDef['name'] . '.branch_id IN (' . implode( ',', $conds['branch_id'][0] ) . ')';

            return eZNetModulePatch::fetchObjectList( $modulePatchDef,
                                                      array( $modulePatchDef['name'] . '.id' ),
                                                      array( $modulePatchDef['name'] . '.version_status' => eZNetPatchBase::VersionStatusPublished,
                                                             $modulePatchDef['name'] . '.status' => $conds['status'] ),
                                                      $sort,
                                                      array( 'limit' => $limit,
                                                             'offset' => $offset ),
                                                      $asObject,
                                                      false,
                                                      $customFields, $customTables, $customConds );
        }
        // Fetch module patches limited by module branch version identifier (extension name), so need to add module branch to the query
        else if ( array_key_exists( 'extension', $conds ) )
        {
            $modulePatchDef = eZNetModulePatch::definition();
            $moduleBranchDef = eZNetModuleBranch::definition();

            $customFields = array( $modulePatchDef['name'] . '.*',
                                   array( 'operation' => $moduleBranchDef['name'] . '.id AS mod_bran_id' ),
                                   array( 'operation' => $moduleBranchDef['name'] . '.branch_id' ) );

            $customTables = array( $moduleBranchDef['name'] );

            $customConds = ' AND ' . $modulePatchDef['name'] . '.module_branch_id = ' . $moduleBranchDef['name'] . '.id' .
                           ' AND ' . $moduleBranchDef['name'] . ".version_identifier IN ('" . implode( "','", $conds['extension'][0] ) . "')";

            return eZNetModulePatch::fetchObjectList( $modulePatchDef,
                                                      array( $modulePatchDef['name'] . '.id' ),
                                                      array( $modulePatchDef['name'] . '.version_status' => eZNetPatchBase::VersionStatusPublished,
                                                             $modulePatchDef['name'] . '.status' => $conds['status'] ),
                                                      $sort,
                                                      array( 'limit' => $limit,
                                                             'offset' => $offset ),
                                                      $asObject,
                                                      false,
                                                      $customFields, $customTables, $customConds );
        }
        else
        {
            return parent::fetchListByClass( $offset, $limit, $conds, $asObject, get_class(), $sort );
        }
    }

    /*!
     \static
     Get eZNetPatch count

     \param eZPersistenObject conds
    */
    static function fetchListCount( $conds = array() )
    {
        // Fetch module patches limited by branch id, so need to add module branch to the query
        if ( array_key_exists( 'branch_id', $conds ) )
        {
            $modulePatchDef = eZNetModulePatch::definition();
            $moduleBranchDef = eZNetModuleBranch::definition();

            $customFields = array( $modulePatchDef['name'] . '.id',
                                   $modulePatchDef['name'] . '.module_branch_id',
                                   array( 'operation' => $moduleBranchDef['name'] . '.id' ),
                                   array( 'operation' => $moduleBranchDef['name'] . '.branch_id' ),
                                   array( 'operation' => 'count(' . $modulePatchDef['name'] . '.id)',
                                          'name' => 'count' ) );

            $customTables = array( $moduleBranchDef['name'] );

            $customConds = ' AND ' . $modulePatchDef['name'] . '.module_branch_id = ' . $moduleBranchDef['name'] . '.id' .
                           ' AND ' . $moduleBranchDef['name'] . '.branch_id IN (' . implode( ',', $conds['branch_id'][0] ) . ')';

            $result = eZNetModulePatch::fetchObjectList( $modulePatchDef,
                                                         array( $modulePatchDef['name'] . '.id' ),
                                                         array( $modulePatchDef['name'] . '.version_status' => eZNetPatchBase::VersionStatusPublished,
                                                                $modulePatchDef['name'] . '.status' => $conds['status'] ),
                                                         array(),
                                                         null,
                                                         false,
                                                         false,
                                                         $customFields, $customTables, $customConds );
            return $result[0]['count'];
        }
        // Fetch module patches limited by module branch version identifier (extension name), so need to add module branch to the query
        else if ( array_key_exists( 'extension', $conds ) )
        {
            $modulePatchDef = eZNetModulePatch::definition();
            $moduleBranchDef = eZNetModuleBranch::definition();

            $customFields = array( $modulePatchDef['name'] . '.id',
                                   $modulePatchDef['name'] . '.module_branch_id',
                                   array( 'operation' => $moduleBranchDef['name'] . '.id' ),
                                   array( 'operation' => $moduleBranchDef['name'] . '.branch_id' ),
                                   array( 'operation' => 'count(' . $modulePatchDef['name'] . '.id)',
                                          'name' => 'count' ) );

            $customTables = array( $moduleBranchDef['name'] );

            $customConds = ' AND ' . $modulePatchDef['name'] . '.module_branch_id = ' . $moduleBranchDef['name'] . '.id' .
                           ' AND ' . $moduleBranchDef['name'] . ".version_identifier IN ('" . implode( "','", $conds['extension'][0] ) . "')";

            $result = eZNetModulePatch::fetchObjectList( $modulePatchDef,
                                                         array( $modulePatchDef['name'] . '.id' ),
                                                         array( $modulePatchDef['name'] . '.version_status' => eZNetPatchBase::VersionStatusPublished,
                                                                $modulePatchDef['name'] . '.status' => $conds['status'] ),
                                                         array(),
                                                         null,
                                                         false,
                                                         false,
                                                         $customFields, $customTables, $customConds );
            return $result[0]['count'];
        }
        else
        {
            return parent::fetchListCountByClass( $conds, get_class() );
        }
    }

    /*!
     \reimp
    */
    static function fetch( $id, $version = eZNetPatchBase::VersionStatusPublished, $asObject = true )
    {
        return parent::fetchByClass( $id, $version, $asObject, get_class() );
    }

    /*!
     \reimp
     \static

     Check if patch with given ID exists.

     \param patch ID
     \param patch status

     \return True if patch exists, false if not.
    */
    static function exists( $patchID, $versionStatus = eZNetPatchBase::VersionStatusPublished )
    {
        return parent::existsByClass( $patchID, $versionStatus, get_class() );
    }
}

?>
