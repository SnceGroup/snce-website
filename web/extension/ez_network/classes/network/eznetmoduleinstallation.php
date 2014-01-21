<?php
/**
 * File containing eZNetModuleInstallation class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetModuleInstallation eznetinstallationmodule.php
  \brief The class eZNetModuleInstallation does

*/
class eZNetModuleInstallation extends eZPersistentObject
{
    /// Consts
    const StatusDraft = 0;
    const StatusPublished = 1;
    const StatusRemoved = 2;
    const EnabledFalse = 0;
    const EnabledTrue = 1;

    /*!
     Constructor
    */
    function eZNetModuleInstallation( $row = array() )
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
                                         "module_branch_id" => array( 'name' => 'ModuleBranchID',
                                                                      'datatype' => 'integer',
                                                                      'default' => 0,
                                                                      'required' => true,
                                                                      'foreign_class' => 'eZNetModuleBranch',
                                                                      'foreign_attribute' => 'id',
                                                                      'multiplicity' => '1..*' ),
                                         "installation_id" => array( 'name' => 'InstallationID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetInstallation',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*' ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         'enabled' => array( 'name' => 'Enabled',
                                                             'datatype' => 'integer',
                                                             'default' => 1,
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
                                                                 'required' => true ),
                                         'email_notifications' => array( 'name' => 'EmailNotificationList',
                                                                         'datatype' => 'string',
                                                                         'default' => '',
                                                                         'required' => true ) ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'module_branch' => 'moduleBranch',
                                                      'patch_mode_name' => 'patchModeName',
                                                      'installation' => 'installation' ),
                      "increment_key" => "id",
                      "class_name" => "eZNetModuleInstallation",
                      "sort" => array( "modified" => "asc" ),
                      "name" => "ezx_ezpnet_module_inst" );
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'patch_mode_name':
            {
                if ( $installation = $this->attribute( 'installation' ) )
                {
                    $patchModeNameMap = eZNetInstallation::patchModeNameMap();
                    $retVal = $patchModeNameMap[$installation->attribute( 'patch_mode' )];
                }
            } break;

            case 'installation':
            {

                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
            } break;

            case 'module_branch':
            {

                $retVal = eZNetModuleBranch::fetch( $this->attribute( 'module_branch_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     Fetch list by site ID
    */
    static function fetchListBySiteID( $siteID,
                                       $status = eZNetModuleInstallation::StatusPublished,
                                       $enabled = eZNetModuleInstallation::EnabledTrue,
                                       $asObject = true )
    {
        $installation = eZNetInstallation::fetchBySiteID( $siteID,
                                                          $status,
                                                          $asObject );

        if ( !$installation )
        {
            return array();
        }

        return eZNetModuleInstallation::fetchObjectList( eZNetModuleInstallation::definition(),
                                                         null,
                                                         array( 'installation_id' => $installation->attribute( 'id' ),
                                                                'status' => $status,
                                                                'enabled' => $enabled ),
                                                         null,
                                                         null,
                                                         $asObject );
    }

    /*!
     \static

     Fetch or create draft instance by installation ID

     \param module branch ID
     \param installation ID

     \return draft instance based on installation ID
    */
    static function draftInstanceByModuleInstallationID( $moduleBranchID, $installationID )
    {
        if ( $draft = eZNetModuleInstallation::fetchDraftByModuleInstallationID( $moduleBranchID, $installationID ) )
        {
            return $draft;
        }

        $draft = eZNetModuleInstallation::create( $moduleBranchID, $installationID );
        $draft->store();
        return $draft;
    }

    /*!
     \static

     Create new eZNetModuleInstallation

     \param $moduleBranchID
     \param $installationID
     \param status ( optional )

     \return new eZNetModuleInstallation
    */
    static function create( $moduleBranchID,
                            $installationID,
                            $status = eZNetModuleInstallation::StatusDraft )
    {
        return new eZNetModuleInstallation( array( 'installation_id' => $installationID,
                                                   'module_branch_id' => $moduleBranchID,
                                                   'status' => $status ) );
    }

    /*!
     \static
     Fetch draft by installation ID

     \param installation ID

     \return draft.
    */
    static function fetchDraftByModuleInstallationID( $moduleBranchID,
                                                      $installationID,
                                                      $force = true,
                                                      $asObject = true )
    {
        $draft = eZNetModuleInstallation::fetchByModuleInstallationID( $moduleBranchID,
                                                                       $installationID,
                                                                       eZNetModuleInstallation::StatusDraft,
                                                                       $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetModuleInstallation::fetchByModuleInstallationID( $moduleBranchID,
                                                                           $installationID,
                                                                           eZNetModuleInstallation::StatusPublished,
                                                                           $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetModuleInstallation::StatusDraft );
                $draft->sync();
            }
        }

        return $draft;
    }

    /*!
     \reimp
    */
    static function fetchByModuleInstallationID( $moduleBranchID,
                                                 $installationID,
                                                 $status = eZNetModuleInstallation::StatusPublished,
                                                 $asObject = true )
    {
        return eZNetModuleInstallation::fetchObject( eZNetModuleInstallation::definition(),
                                                     null,
                                                     array( 'module_branch_id' => $moduleBranchID,
                                                            'installation_id' => $installationID,
                                                            'status' => $status ),
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
                                                          $status = eZNetModuleInstallation::StatusPublished )
    {
        $installation = eZNetInstallation::fetchBySiteID( $installationSiteID );
        if ( !$installation )
        {
            return false;
        }

        return eZNetModuleInstallation::fetchObjectList( eZNetModuleInstallation::definition(),
                                                         array( 'id' ),
                                                         array( 'installation_id' => $installation->attribute( 'id' ),
                                                                'modified' => array( '>', $latestModified ),
                                                                'status' => $status ),
                                                         array( 'modified' => 'asc' ),
                                                         array( 'limit' => $limit,
                                                                'offset' => $offset ),
                                                         $asObject );
    }

    /*!
     \static

     Fetch draft list. If no draft exist, create draft from existing published object

     \param Installation ID
    */
    static function fetchDraftListByInstallationID( $installationID,
                                                    $enabled = eZNetModuleInstallation::EnabledTrue )
    {
        $draftList = eZNetModuleInstallation::fetchListByInstallationID( $installationID,
                                                                         0,
                                                                         1000,
                                                                         eZNetModuleInstallation::StatusDraft,
                                                                         $enabled );
        $publishList = eZNetModuleInstallation::fetchListByInstallationID( $installationID,
                                                                           0,
                                                                           1000,
                                                                           eZNetModuleInstallation::StatusPublished,
                                                                           $enabled );
        $draftIDList = array();
        if ( $draftList )
        {
            foreach( $draftList as $draft )
            {
                $draftIDList[] = $draft->attribute( 'id' );
            }
        }

        // Create draft from published item, if draft does not exist. Ignore if draft already exists.
        if ( $publishList )
        {
            foreach( $publishList as $published )
            {
                if ( !in_array( $published->attribute( 'id' ), $draftIDList ) )
                {
                    $draftList[] = eZNetModuleInstallation::fetchDraft( $published->attribute( 'id' ) );
                }
            }
        }

        return $draftList;
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraft( $id,
                                $force = true,
                                $asObject = true )
    {
        $draft = eZNetModuleInstallation::fetch( $id,
                                                 eZNetModuleInstallation::StatusDraft,
                                                 $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetModuleInstallation::fetch( $id,
                                                     eZNetModuleInstallation::StatusPublished,
                                                     $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetModuleInstallation::StatusDraft );
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
        $this->setAttribute( 'status', eZNetModuleInstallation::StatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetModuleInstallation::fetchDraft( $this->attribute( 'id' ),
                                                      false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static
     Fetch list by module branch ID

     \param Module branch ID
     \param offset
     \param limit
     \param status
     \param is enabled
     \param $asObject

     \return eZNetModuleInstallation list
    */
    static function fetchListByModuleBranchID( $moduleBranchID,
                                               $offset = 0,
                                               $limit = 10,
                                               $status = eZNetModuleInstallation::StatusPublished,
                                               $isEnabled = eZNetModuleInstallation::EnabledTrue,
                                               $asObject = true )
    {
        $condArray = array( 'module_branch_id' => $moduleBranchID,
                            'status' => $status,
                            'enabled' => $isEnabled );

        return eZPersistentObject::fetchObjectList( eZNetModuleInstallation::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'id' => 'asc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Fetch list by installation ID

     \param installationID
     \param offset
     \param limit
     \param published status
     \param enabled status
     \param asObject

     \return list of eZNetModuleInstallation objects
    */
    static function fetchListByInstallationID( $installationID,
                                               $offset = 0,
                                               $limit = 10,
                                               $status = eZNetModuleInstallation::StatusPublished,
                                               $enabled = eZNetModuleInstallation::EnabledTrue,
                                               $asObject = true )
    {
        return eZNetModuleInstallation::fetchObjectList( eZNetModuleInstallation::definition(),
                                                         null,
                                                         array( 'installation_id' => $installationID,
                                                                'status' => $status,
                                                                'enabled' => $enabled ),
                                                         null,
                                                         array( 'limit' => $limit,
                                                                'offset' => $offset ),
                                                         $asObject );

    }

    /*!
     \static

     Fetch list of Network installations.

     \param Customer ID
    */
    static function fetchList( $offset = 0,
                               $limit = 10,
                               $asObject = true )
    {
        return eZNetModuleInstallation::fetchObjectList( eZNetModuleInstallation::definition(),
                                                         null,
                                                         null,
                                                         array( 'id' => 'desc' ),
                                                         array( 'limit' => $limit,
                                                                'offset' => $offset ),
                                                         $asObject );
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetModuleInstallation::StatusPublished,
                           $asObject = true )
    {
        return eZNetModuleInstallation::fetchObject( eZNetModuleInstallation::definition(),
                                                     null,
                                                     array( 'id' => $id,
                                                            'status' => $status ),
                                                     $asObject );
    }
}

?>
