<?php
/**
 * File containing eZNetPatchBase class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetPatchBase eznetpatchbase.php
  \brief The class eZNetPatchBase does

*/

/*! DEPRECATED, debug_backtrace() for php5 and php4 is different,
    class name will be incorrect if we use this solution.
    OBS - READ THIS !!!!
class A
{
    function kake()
    {
        $backtrace = debug_backtrace();
        echo $backtrace[0]['class'];
        echo " - ";
    }
}

class B extends A
{
}

A::kake();
B::kake();
// outputs : a - b -

The lines:
$backtrace = debug_backtrace();
$className = $backtrace[0]['class'];

all over the place is for getting the correct class called as static functions.

 */
include_once( 'kernel/common/i18n.php' );

class eZNetPatchBase extends eZNetLargeObject
{
    /// Consts
    const StatusAlpha = 0;
    const StatusBeta = 1;
    const StatusRC = 2;
    const StatusFinal = 3;
    const StatusRemoved = 4;
    const StatusSecurity = 5;

    const VersionStatusDraft = 0;
    const VersionStatusPublished = 1;

    const RequiredNone = -1;


   /*!
     Constructor
    */
    function eZNetPatchBase( $rows = array() )
    {
        $this->NetUtils = new eZNetUtils();
        $this->eZNetLargeObject( $rows );
    }

    /*!
     \abstract
     \reimp
    */
    static function definition()
    {
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'patch_text_diff':
            {
                $retVal = '';
                $domDocument = new DOMDocument( '1.0', 'utf-8' );
                if ( $domDocument->loadXML( $this->attribute( 'ez_patch' ), LIBXML_PARSEHUGE ) )
                {
                    if ( $rootNode = $domDocument->documentElement )
                    {
                        if ( $patchElementNodeList = $rootNode->getElementsByTagName( 'PatchElement' ) )
                        {
                            foreach( $patchElementNodeList as $patchElement )
                            {
                                if ( $patchElement->getAttribute( 'type' ) == 'patch' )
                                {
                                    $retVal = eZNetPatchBase::patchNodeContent( $patchElement );
                                    break;
                                }
                            }
                        }
                    }
                }
            } break;

            case 'ez_patch':
            {
                $retVal = base64_decode( $this->attribute( 'filedata' ) );
            } break;

            case 'patch_scripts':
            {
                $retVal = '';
                $domDocument = new DOMDocument( '1.0', 'utf-8' );
                if ( $domDocument->loadXML( $this->attribute( 'ez_patch' ), LIBXML_PARSEHUGE ) )
                {
                    if ( $rootNode = $domDocument->documentElement )
                    {
                        if ( $patchElementNodeList = $rootNode->getElementsByTagName( 'PatchElement' ) )
                        {
                            foreach( $patchElementNodeList as $patchElement )
                            {
                                if ( $patchElement->getAttribute( 'type' ) == 'script' )
                                {
                                    $retVal = eZNetPatchBase::patchScriptContent( $patchElement );
                                    break;
                                }
                            }
                        }
                    }
                }
            } break;

            case 'option_array':
            {
                $optionDef = $this->attribute( 'options' );
                $retVal = $optionDef == '' ? array() : unserialize( $optionDef );
            } break;

            case 'required_patch':
            {
                $className = get_class( $this );
                $retVal = call_user_func_array( array( $className, 'fetchObject' ),
                                                array( $this->definition(),
                                                       null,
                                                       array( 'id' => $this->attribute( 'required_patch_id' ),
                                                              'version_status' => $this->attribute( 'version_status' ) ),
                                                       true ) );
            } break;

            default:
            {
                $retVal = eZNetLargeObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \static
     Get patch node content from DOM Node

     \param Patch Element dom node

     \return patch content.
    */
    static function patchNodeContent( DOMElement $patchNode )
    {
        $patchContent = '';
        $encoded = false;

        $contentNode = $patchNode->getElementsByTagName( 'PatchContent' )->item( 0 );
        $patchContent = $contentNode->nodeValue;
        if ( $contentNode->hasAttribute( 'encoded' ) &&
             $contentNode->getAttribute( 'encoded' ) )
        {
            $encoded = true;
        }

        if ( $encoded )
        {
            $patchContent = base64_decode( $patchContent );
        }

        return $patchContent;
    }

    /*!
     \static
     Get script content from DOM Node

     \param Patch Element dom node

     \return patch content.
    */
    static function patchScriptContent( $patchNode )
    {
        $patchContent = '';

        $contentNode = $patchNode->getElementsByTagName( 'Script' )->item( 0 );
        $patchContent = $contentNode->nodeValue;

        // Always encoded
        $patchContent = base64_decode( $patchContent );

        return $patchContent;
    }
    /*!
     DEPRECATED
     It doesn't make sense to check from_release_tag anymore
     due to a bug: we cannot add a patch based on 4.2.3 release for newly created branch.
     Now the base release can be one of all release strings like 1.1.1 and so on.

     Check if current patch is base release

     \return true if base release, false if not
    */
    function isBaseRelease()
    {
        return true;
    }

    /*!
     \static
     Check if release tag is valid.

     \param release tag
     \param minNumDepth,  ex: 2 -> 3.4 , 4 -> 3.5.2.5

     \return True if release tag is valid.
    */
    static function validReleaseTag( $releaseTag, $minNumDepth = 3 )
    {
        $releaseTag = trim( $releaseTag );
        $matches = array();

        $matchExpr = "/" . substr( str_repeat( "[0-9]+\.", $minNumDepth ), 0, -2 ) . "(.*)" . "/";

        preg_match( $matchExpr, $releaseTag, $matches );

        return ( count( $matches ) >= 1 &&
                 $matches[0] === $releaseTag );
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
     \reimp
    */
    function setAttribute( $attr, $value )
    {
        switch( $attr )
        {
            case 'status':
            {
                $existingUserInfoString = $this->attribute( 'status_info' );
                $existingUserInfo = !$existingUserInfoString ? array() : unserialize( $existingUserInfoString );

                if ( isset( $existingUserInfo[(string)$value] ) )
                {
                    $existingUserInfo[(string)$value]['modifier_id'] = eZUser::currentUserID();
                    $existingUserInfo[(string)$value]['modified'] = time();
                }
                else
                {
                    $existingUserInfo[(string)$value] = array();
                    $existingUserInfo[(string)$value]['creator_id'] = eZUser::currentUserID();
                    $existingUserInfo[(string)$value]['created'] = time();
                }

                $this->setAttribute( 'status_info', serialize( $existingUserInfo ) );
                eZNetLargeObject::setAttribute( $attr, $value );
            } break;

            default:
            {
                eZNetLargeObject::setAttribute( $attr, $value );
            } break;
        }
    }

    /*!
     \static
     \deprecated fetchListCount is a more generic function for used for counting patches

     Get eZNetPatch count

     \param version status ( optional )
     \param patch status ( optional )
     \param name of subclass
    */
    static function countByStatusAndClass( $versionStatus = eZNetPatchBase::VersionStatusPublished,
                           $patchStatus = array( array( eZNetPatchBase::StatusAlpha,
                                                        eZNetPatchBase::StatusBeta,
                                                        eZNetPatchBase::StatusRC,
                                                        eZNetPatchBase::StatusFinal,
                                                        eZNetPatchBase::StatusSecurity ) ),
                           $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $resultSet = call_user_func_array( array( $className, 'fetchObjectList' ),
                                           array( call_user_func_array( array( $className, 'definition' ), array() ),
                                                  array(),
                                                  array( 'status' => $patchStatus,
                                                         'version_status' => $versionStatus ),
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => 'count(id)',
                                                                'name' => 'count' ) ) ) );
        return $resultSet[0]['count'];

    }

    /*!
     Fetch next patch ( according to required patch id )

     \param $asObject

     \return eZNetPatchBase object, null if not exists.
    */
    function nextPatch( $asObject = true )
    {
        $className = get_class( $this );
        return call_user_func_array( array( $className, 'fetchObject' ),
                                     array( call_user_func_array( array( $className, 'definition' ),
                                                                  array() ),
                                            null,
                                            array( 'required_patch_id' => $this->attribute( 'id' ) ),
                                            $asObject ) );
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraftByClass( $id,
                                $force = true,
                                $asObject = true,
                                $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $draft = call_user_func_array( array( $className, 'fetch' ),
                                       array( $id,
                                              eZNetPatchBase::VersionStatusDraft,
                                              $asObject ) );
        if ( !$draft &&
             $force )
        {
            $draft = call_user_func_array( array( $className, 'fetch' ),
                                           array( $id,
                                                  eZNetPatchBase::VersionStatusPublished,
                                                  $asObject ) );

            if ( $draft )
            {
                $draft->setAttribute( 'version_status', eZNetPatchBase::VersionStatusDraft );
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
        $this->setAttribute( 'version_status', eZNetPatchBase::VersionStatusPublished );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $className = get_class( $this );

        $draft = call_user_func_array( array( $className, 'fetchDraft' ),
                                       array( $this->attribute( 'id' ),
                                              false ) );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static

     Create new patch item
    */
    static function createByClass( $branchID, $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $patch = new $className( array( 'version_status' => eZNetPatchBase::VersionStatusDraft,
                                        call_user_func_array( array( $className, 'branchIDField' ), array() ) => $branchID,
                                        'created' => time(),
                                        'creator_id' => eZUser::currentUserID() ) );
        $patch->setAttribute( 'status', eZNetPatchBase::StatusAlpha );

        return $patch;
    }

    /*!
     Check if required patch is OK

     \param required patch ID

     \return error message if required patch ID is invalid. False if everything is OK.
    */
    function checkRequiredPatchID( $patchID )
    {
        $className = get_class( $this );

        if ( $patchID == eZNetPatchBase::RequiredNone  )
        {
            if ( $this->isBaseRelease() )
            {
                return false;
            }
            else
            {
                return "This patch is not a base release";
            }
        }
        $requiredPatch = call_user_func_array( array( $className, 'fetch' ),
                                               array( $patchID ) );
        // Check if required patch exists
        if ( !$requiredPatch )
        {
            return "Patch not found.";
        }

        // Check if required patch has required patch set ( required ).
        if ( !$requiredPatch->attribute( 'required_patch_id' ) )
        {
            return "Required patch does not have a required patch selected.";
        }

        // Check if required patch is in the same branch
        $branchIDField = call_user_func_array( array( $className, 'branchIDField' ), array() );
        if ( $this->attribute( $branchIDField ) != $requiredPatch->attribute( $branchIDField ) )
        {
            return "Required patch is of different branch.";
        }

        // Check if required patch is required by other patches as well ( not allowed ).
        $requiredByOther = false;
        foreach( call_user_func_array( array( $className, 'fetchListByRequiredPatchID' ),
                                       array( $patchID ) ) as $patch )
        {
            if ( $patch->attribute( 'id' ) != $this->attribute( 'id' ) )
            {
                $requiredByOther = true;
                break;
            }
        }
        if ( $requiredByOther )
        {
            return "Patch is required by other patch. This is not allowed.";
        }

        return false;
    }

    /*!
     \static

     Fetch list branch id

     \param branch ID ( can also be list, example : array( array( 1, 2, 3 ) )
     \param patch status
     \param version status
     \param $asObject
     \param additional condition array ( optional )
     \param name of subclass
    */
    static function fetchListByBranchIDAndClass( $branchID,
                                         $status = array( array( eZNetPatchBase::StatusFinal,
                                                                 eZNetPatchBase::StatusSecurity ) ),
                                         $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                         $asObject = true,
                                         $extraConditions = array(),
                                         $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $conditionList = array_merge( $extraConditions,
                                      array( call_user_func_array( array( $className, 'branchIDField' ), array() ) => $branchID,
                                             'status' => $status,
                                             'version_status' => $versionStatus ) );

        return call_user_func_array( array( $className, 'fetchObjectList' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            $conditionList,
                                            null,
                                            null,
                                            $asObject ) );
    }

    /*!
     \static

     Fetch list by required patch id

     \param required patch ID
     \param patch status
     \param version status
     \param $asObject
     \param name of subclass
    */
    static function fetchListByRequiredPatchIDAndClass( $requiredPatchID,
                                                $status = array( array( eZNetPatchBase::StatusFinal,
                                                                        eZNetPatchBase::StatusSecurity ) ),
                                                $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                                $asObject = true,
                                                $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        return call_user_func_array( array( $className, 'fetchObjectList' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            array( 'required_patch_id' => $requiredPatchID,
                                                   'status' => $status,
                                                   'version_status' => $versionStatus ),
                                            null,
                                            null,
                                            $asObject ) );
    }

    /*!
     \static

     Fetch list of Network patches.
    */
    static function fetchListByClass( $offset = 0,
                                      $limit = 10,
                                      $status = array( array( eZNetPatchBase::StatusFinal,
                                                              eZNetPatchBase::StatusSecurity ) ),
                                      $asObject = true,
                                      $className = false,
                                      array $sort = null )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        return call_user_func_array( array( $className, 'fetchObjectList' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            $status,
                                            $sort,
                                            array( 'limit' => $limit,
                                                   'offset' => $offset ),
                                            $asObject,
                                            ) );
    }

    /*!
     \static
     Get eZNetPatch count

     \param eZPersistenObject conds
    */
    static function fetchListCountByClass( $conds = array(), $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $resultSet = call_user_func_array( array( $className, 'fetchObjectList' ),
                                           array( call_user_func_array( array( $className, 'definition' ), array() ),
                                                  array(),
                                                  $conds,
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => 'count(id)',
                                                                'name' => 'count' ) )
                                                  ) );
        return $resultSet[0]['count'];
    }


    /*!
     \reimp
    */
    static function fetchByClass( $id, $version = eZNetPatchBase::VersionStatusPublished, $asObject = true, $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        return call_user_func_array( array( $className, 'fetchObject' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            array( 'id' => $id,
                                                   'version_status' => $version ),
                                            $asObject ) );
    }

    /*!
     \static

     Get status name map
    */
    static function statusNameMap()
    {
        return array( eZNetPatchBase::StatusAlpha => ezi18n( 'ez_network', 'Alpha' ),
                      eZNetPatchBase::StatusBeta => ezi18n( 'ez_network', 'Beta' ),
                      eZNetPatchBase::StatusRC => ezi18n( 'ez_network', 'RC' ),
                      eZNetPatchBase::StatusFinal => ezi18n( 'ez_network', 'Final' ),
                      eZNetPatchBase::StatusRemoved => ezi18n( 'ez_network', 'Removed' ),
                      eZNetPatchBase::StatusSecurity => ezi18n( 'ez_network', 'Security patch' ) );
    }

    /*!
     \static

     Status info map
    */
    static function statusInfoMap()
    {
        return array( eZNetPatchBase::StatusAlpha => 'alpha_info',
                      eZNetPatchBase::StatusBeta => 'beta_info',
                      eZNetPatchBase::StatusRC => 'rc_info',
                      eZNetPatchBase::StatusFinal => 'final_info' );
    }

    /*!
     \static

     Check if patch with given ID exists.

     \param patch ID
     \param patch status
     \param name of subclass

     \return True if patch exists, false if not.
    */
    static function existsByClass( $patchID, $versionStatus = eZNetPatchBase::VersionStatusPublished, $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $resultSet = call_user_func_array( array( $className, 'fetchObjectList' ),
                                           array( call_user_func_array( array( $className, 'definition' ), array() ),
                                                  array(),
                                                  array( 'id' => $patchID,
                                                         'version_status' => $versionStatus ),
                                                  null,
                                                  null,
                                                  false,
                                                  false,
                                                  array( array( 'operation' => '1' ) ) ) );
        return count( $resultSet ) == 1;
    }

    /*!
     \static
     \abstract
    */
    static function branchIDField()
    {
        return false;
    }

    /*!
        \static
        \private
     Generates query for fetchAllPatches and fetchAllPatchesCount functions.

     TODO: Please note that this query does not check if a module branch of given patch refers to an existing branch
     Current workaround is to check if branch_id for given patch in ezx_ezpnet_module_branch is != 0
     */
    private static function generateQueryForFetchAllPatches( $installationID = false,
                                     $branchID = false,
                                     $moduleBranchIDs = false,
                                     $offset = 0,
                                     $limit = 9999,
                                     $status = array( array( eZNetPatchBase::StatusFinal,
                                                             eZNetPatchBase::StatusSecurity ) ),
                                     $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                     $sort = array( "created" => "asc" )
                                 )
    {
        $query_branch = "SELECT DISTINCT ezx_ezpnet_patch.id
                                , ezx_ezpnet_patch.name 
                                , ezx_ezpnet_patch.description
                                , ezx_ezpnet_patch.created 
                                , null as module_branch_id
                         FROM   ezx_ezpnet_patch";
        $where_branch = "WHERE ";
        if( $installationID !== false && $branchID === false )
        {
            $query_branch .= ",ezx_ezpnet_installation";
            $where_branch .= " ezx_ezpnet_patch.branch_id = ezx_ezpnet_installation.branch_id
                               AND    ezx_ezpnet_installation.id = $installationID";
        }
        else 
        {
            if( $branchID !== false )
            {
                $where_branch .= " ezx_ezpnet_patch.branch_id = $branchID";
            }
        }

        if( trim( $where_branch ) != 'WHERE' )
        {
            $where_branch .= " AND "; 
        }
        $where_branch .= " ezx_ezpnet_patch.version_status = $versionStatus";

        $statusList = "";
        foreach( $status[0] as $st )
        {
            if( strlen( $statusList ) > 0 )
            {
                $statusList .= ",";
            }
            $statusList .= $st;
        }
        $where_branch .= " AND ezx_ezpnet_patch.status in ( $statusList )";


        $query_module_branch = "SELECT ezx_ezpnet_module_patch.id
                                        , ezx_ezpnet_module_patch.name
                                        , ezx_ezpnet_module_patch.description
                                        , ezx_ezpnet_module_patch.created
                                        , ezx_ezpnet_module_patch.module_branch_id as module_branch_id
                                FROM    ezx_ezpnet_module_patch";
        $where_mod_branch = " WHERE ";
        if( $moduleBranchIDs !== false || $installationID !== false )
        {

            if( $installationID !== false )
            {
                $query_module_branch .= " ,ezx_ezpnet_module_inst";
                $where_mod_branch .= " ezx_ezpnet_module_patch.module_branch_id = ezx_ezpnet_module_inst.module_branch_id
                                      AND     ezx_ezpnet_module_inst.installation_id = $installationID
                                      AND ezx_ezpnet_module_inst.enabled = 1";
            }
            else if( $moduleBranchIDs !== false )
            {
                if( is_array( $moduleBranchIDs ) )
                {
                    $moduleBranchIDList = "";
                    foreach( $moduleBranchIDs as $mb )
                    {
                        if( strlen( $moduleBranchIDList ) > 0 )
                        {
                            $moduleBranchIDList .= ",";
                        }
                        $moduleBranchIDList .= $mb;
                    }
                    $where_mod_branch .= " ezx_ezpnet_module_patch.module_branch_id in ($moduleBranchIDList)";
                }
            }


        }

        if( trim( $where_mod_branch ) != 'WHERE' )
        {
            $where_mod_branch .= " AND "; 
        }
        $where_mod_branch .= " ezx_ezpnet_module_patch.version_status = $versionStatus
                               AND ezx_ezpnet_module_patch.status in ( $statusList )";

        $query = "";
        if( $installationID !== false || $branchID !== false )
        {
            $query .= "( $query_branch $where_branch ) 
                  UNION ";
        }
        $query .= " ( $query_module_branch $where_mod_branch)";

        return $query;
    }

    static function fetchAllPatches( $installationID = false,
                                     $branchID = false,
                                     $moduleBranchIDs = false,
                                     $offset = 0,
                                     $limit = 9999,
                                     $status = array( array( eZNetPatchBase::StatusFinal,
                                                             eZNetPatchBase::StatusSecurity ) ),
                                     $asObject = true,
                                     $versionStatus = eZNetPatchBase::VersionStatusPublished,
                                     $sort = array( "created" => "desc" )
                                 )
    {
        $db = eZDB::instance();

        $query = eZNetPatchBase::generateQueryForFetchAllPatches( $installationID,
                                                                  $branchID,
                                                                  $moduleBranchIDs,
                                                                  $offset,
                                                                  $limit,
                                                                  $status,
                                                                  $versionStatus
                                                                  );

        $table = $db->generateUniqueTempTableName( 'ezpatchlist_tmp_%', 0 );
        $db->createTempTable( "CREATE TEMPORARY TABLE $table AS $query" );
        $tempTableQuery = "SELECT * FROM $table ";
        if( is_array( $sort ) )
        {
            $column = key( $sort );
            $direction = $sort[$column];
            $tempTableQuery .= "ORDER BY $column $direction";
        }
        $result = $db->arrayQuery( $tempTableQuery, array( "limit" => $limit, "offset" => $offset ) );
        $db->dropTempTable( "DROP TEMPORARY TABLE IF EXISTS $table" );

        if ( $asObject )
        {
            $objectList = array();
            foreach ( $result as $row )
            {
                if ( $row['module_branch_id'] === NULL )
                {
                    $objectList[] = eZNetPatch::fetch( $row['id'] );
                }
                else
                {
                    $objectList[] = eZNetModulePatch::fetch( $row['id'] );
                }
            }
            $result = $objectList;
        }

        return $result;

    }

    static function fetchAllPatchesCount( $installationID = false,
                                          $branchID = false,
                                          $moduleBranchIDs = false,
                                          $status = array( array( eZNetPatchBase::StatusFinal,
                                                                  eZNetPatchBase::StatusSecurity ) ),
                                          $versionStatus = eZNetPatchBase::VersionStatusPublished
                                      )
    {
        $db = eZDB::instance();

        $query = eZNetPatchBase::generateQueryForFetchAllPatches( $installationID,
                                                                  $branchID,
                                                                  $moduleBranchIDs,
                                                                  0,
                                                                  9999,
                                                                  $status,
                                                                  $versionStatus
                                                                  );
        $result = $db->arrayQuery( "SELECT count( name ) as count FROM ( $query ) x" );
        return $result[0]['count'];
    }
}

?>
