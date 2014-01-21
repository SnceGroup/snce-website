<?php
/**
 * File containing eZNetPatch class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetPatch eznetpatch.php
  \brief The class eZNetPatch does

*/
class eZNetPatch extends eZNetPatchBase
{
    /*!
     Constructor
    */
    function eZNetPatch( $rows )
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
                                         "branch_id" => array( 'name' => 'eZNetBranchID',
                                                               'datatype' => 'integer',
                                                               'default' => 0,
                                                               'required' => true,
                                                               'foreign_class' => 'eZNetBranch',
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
                                                                       'foreign_class' => 'eZNetPatch',
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
                                                      'original_patch_id' => 'originalPatchID',
                                                      'branch' => 'branch',
                                                      'issues' => 'issues',
                                                      'issue_count' => 'issue_count' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetPatch",
                      "sort" => array( "created" => "asc" ),
                      "name" => "ezx_ezpnet_patch" );
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'original_patch_id':
            {
                $domDocument = new DOMDocument( '1.0', 'utf-8' );
                if ( $domDocument->loadXML( base64_decode( $this->attribute( 'filedata' ) ), LIBXML_PARSEHUGE ) )
                {
                    $retVal = $domDocument->documentElement->getAttribute( 'id' );
                }
            } break;

            case 'branch':
            {
                $retVal = eZNetBranch::fetch( $this->attribute( 'branch_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'issues':
            {
                $retVal = eZNetIssue::fetchListByPatchID( $this->attribute( 'id' ) );
            } break;

            case 'issue_count':
            {
                $retVal = eZNetIssue::fetchListCountByPatchID( $this->attribute( 'id' ) );
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

     Fetch a list of patches based on installation remote ID.

    */
    static function fetchListByRemoteIDAndLatestID( $installationSiteID,
                                                    $latestID,
                                                    $offset = 0,
                                                    $limit = 100,
                                                    $asObject = true,
                                                    $status = eZNetPatchBase::VersionStatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );

        return eZNetLargeObject::fetchObjectList( eZNetPatch::definition(),
                                                  array( 'id' ),
                                                  array( 'branch_id' => $installation->attribute( 'branch_id' ),
                                                         'version_status' => $status,
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
                                                          $status = eZNetPatchBase::VersionStatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        if ( !$installation )
        {
            return false;
        }

        return eZNetLargeObject::fetchObjectList( eZNetPatch::definition(),
                                                  array( 'id' ),
                                                  array( 'branch_id' => $installation->attribute( 'branch_id' ),
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
        return 'branch_id';
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
                               $status = array( array( eZNetPatchBase::StatusFinal,
                                                       eZNetPatchBase::StatusSecurity ) ),
                               $asObject = true,
                               array $sort = null )
    {
        return parent::fetchListByClass( $offset, $limit, $status, $asObject, get_class(), $sort );
    }

    /*!
     \reimp
    */
    static function fetch( $id, $version = eZNetPatchBase::VersionStatusPublished, $asObject = true )
    {
        return parent::fetchByClass( $id, $version, $asObject, get_class() );
    }

    /*!
     \static
     Get eZNetPatch count

     \param eZPersistenObject conds
    */
    static function fetchListCount( $conds = array() )
    {
        return parent::fetchListCountByClass( $conds, get_class() );
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
