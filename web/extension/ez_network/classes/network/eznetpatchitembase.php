<?php
/**
 * File containing eZNetPatchItemBase class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetPatchItemBase eznetpatchitembase.php
  \brief The class eZNetPatchItemBase does

*/
include_once( 'kernel/common/i18n.php' );

class eZNetPatchItemBase extends eZPersistentObject
{
    /// Consts
    const StatusNone = 0;
    const StatusNotApproved = 1;
    const StatusPending = 2;
    const StatusInstalling = 3;
    const StatusInstalled = 4;
    const StatusFailed = 5;
    const StatusObsolete = 6;

    const PatchBackupPath = 'backup';
    const PatchFilePath = 'files';

    /*!
     Constructor
    */
    function eZNetPatchItemBase( $row = array() )
    {
        $this->NetUtils = new eZNetUtils();
        $this->eZPersistentObject( $row );
    }

    /*!
     \abstract
    */
    static function definition()
    {
    }

    /*!
     \static
     Update all modified timestamps.

     \param \a $diffTS ( optional ).
     \param name of subclass
    */
    static function updateModifiedAllByClass( $diffTS = 0, $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $offset = 0;
        $limit = 50;

        while( $itemList = call_user_func_array( array( $className, 'fetchObjectList' ),
                                                 array( call_user_func_array( array( $className, 'definition' ), array() ),
                                                        null,
                                                        null,
                                                        null,
                                                        array( 'offset' => $offset,
                                                               'limit' => $limit ) ) ) )
        {
            foreach( $itemList as $item )
            {
                $item->setAttribute( 'modified', time() + $diffTS );
                $item->sync();
            }
            $offset += $limit;
        }
    }

    /*!
     \static
     Fetch eZNetPatchItemBase by patch item ID

     \param patch item ID
     \param $asObject
     \param name of subclass

     \return eZNetPatchItem
    */
    static function fetchByClass( $id, $asObject = true, $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        return call_user_func_array( array( $className, 'fetchObject' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            array( 'id' => $id ),
                                            $asObject ) );
    }

    /*!
     \static
     Fetch eZNetPatchItem by patch and installation ID
    */
    static function fetchByPatchIDAndClass( $patchID,
                                    $installationID,
                                    $nodeID = false,
                                    $asObject = true,
                                    $className = false )
    {
        if ( !$className )
        {
            $className = eZNetUtils::callbackClassName();
        }

        $condArray = array( call_user_func_array( array( $className, 'patchIDFieldName' ), array() ) => $patchID,
                            'installation_id' => $installationID );

        if ( $nodeID === false )
        {
            $nodeID = eZNetUtils::nodeID();
        }

        $customConds = null;
        if ( $nodeID == '' )
        {
            $customConds = " AND ( node_id = '' OR node_id is null )";
        }
        else
        {
            $condArray['node_id'] = $nodeID;
        }

       // $customConds = null;
        $rows = call_user_func_array( array( $className, 'fetchObjectList' ),
                                     array( call_user_func_array( array( $className, 'definition' ), array() ),
                                            null,
                                            $condArray,
                                            array(),
                                            null,
                                            $asObject,
                                            false,
                                            null,
                                            null,
                                            $customConds ) );
        if ( $rows )
            return $rows[0];
        return null;
    }

    /*!
     Get next patch in dependency list

     \return eZNetPatch
    */
    function nextPatch( $asObject = true )
    {
        $patchClassName = $this->patchClassName();
        $patchIDFieldName = $this->patchIDFieldName();

        return call_user_func_array( array( $patchClassName, 'fetchObject' ),
                                     array( call_user_func_array( array( $patchClassName, 'definition' ), array() ),
                                            null,
                                            array( 'required_patch_id' => $this->attribute( $patchIDFieldName ) ),
                                            $asObject ) );
    }

    /*!
     Get next patch item in dependency list

     \return eZNetPatchItem
    */
    function nextPatchItem( $asObject = true )
    {
        $className = get_class( $this );

        $patch = $this->nextPatch( $asObject );
        if ( $patch )
        {
            $patchItem = call_user_func_array( array( $className, 'fetchByPatchID' ),
                                               array( $patch->attribute( 'id' ),
                                                      $this->attribute( 'installation_id' ) ) );
            if ( $patchItem &&
                 $patchItem->attribute( 'status' ) == eZNetPatchItemBase::StatusPending )
            {
                return $patchItem;
            }
        }

        return null;
    }

    /*!
     Get next patch item in dependency list
     Do not care about state

     \return eZNetPatchItem
    */
    function nextPatchItemAnyStatus( $asObject = true )
    {
        $className = get_class( $this );

        $patch = $this->nextPatch( $asObject );
        if ( $patch )
        {
            $patchItem = call_user_func_array( array( $className, 'fetchByPatchID' ),
                                               array( $patch->attribute( 'id' ),
                                                      $this->attribute( 'installation_id' ) ) );
            if ( $patchItem )
            {
                return $patchItem;
            }
        }

        return null;
    }

    /*!
     \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'required_patch_item':
            {
                $patch = $this->attribute( 'patch' );
                if ( !$patch )
                {
                    $retVal = null;
                }
                else
                {
                    $retVal = call_user_func_array( array( get_class( $this ), 'fetchByPatchID' ),
                                                    array( $patch->attribute( 'required_patch_id' ),
                                                           $this->attribute( 'installation_id' ) ) );
                }
            } break;

            case 'node_name':
            {
                $retVal = '';
                if ( $installation = $this->attribute( 'installation' ) )
                {
                    if ( $installationInfo = $installation->attribute( 'installation_info' ) )
                    {
                        $retVal = $installationInfo->nodeName( $this->attribute( 'node_id' ) );
                    }
                }
            } break;

            case 'branch_id':
            {
                if( $patch = $this->attribute( 'patch' ) )
                {
                    $retVal = $patch->attribute( 'branch_id' );
                }
            } break;

            case 'installation':
            {
                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
            } break;

            case 'module_patch':
            case 'patch':
            {
                $patchClassName = $this->patchClassName();
                $patchIDFieldName = $this->patchIDFieldName();
                $retVal = call_user_func_array( array( $patchClassName, 'fetch' ),
                                                array( $this->attribute( $patchIDFieldName ) ) );
            } break;

            case 'patch_exists':
            {
                $patchClassName = $this->patchClassName();
                $patchIDFieldName = $this->patchIDFieldName();
                $retVal = call_user_func_array( array( $patchClassName, 'exists' ),
                                                array( $this->attribute( $patchIDFieldName ) ) );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     Install patch onto system.

     Install procedure:

     1. Check if required patch is installed, if not install it.
     2. Check if other patches are in installation mode, if it's less than 4 hours old, wait.
        I not, uninstall other, then install it again.
     3. Set status and started timestamp.
     4. Load XML patch definition
     6. ( Take site offline if nessesary ) // TODO
     7. Update in using list from XML file.
     10. Set finnished status and installed timestamp.

    */
    function install( $options = array() )
    {
        $className = get_class( $this );
        $nodeID = eZNetUtils::nodeID();

        if ( !$this->requiredPatchInstalled() ) // Step 1 and 2
        {
            $patch = $this->attribute( 'patch' );
            eZNetUtils::log( $className . '::install()[' . $nodeID . ']: Installing patch, ID: ' .
                             $patch->attribute( 'required_patch_id' ) .
                             ', Name: ' . $patch->attribute( 'name' ) );
            $requiredPatchItem = $this->attribute( 'required_patch_item' );
            if ( !$requiredPatchItem )
            {
                eZNetUtils::log( $className . '::install()[' . $nodeID . ']: Could not load required patch, ID: ' .
                                 $patch->attribute( 'required_patch_id' ) .
                                 ', Name: ' . $patch->attribute( 'name' ) .
                                 ', installation ID: ' . $this->attribute( 'installation_id' ) ); // TODO : add installation_id as function identifier.
                return false;
            }
            switch( $requiredPatchItem->attribute( 'status' ) )
            {
                case eZNetPatchItemBase::StatusInstalled:
                {
                    // Should never end up here.
                } break;

                case eZNetPatchItemBase::StatusPending:
                {
                    return $requiredPatchItem->install();
                } break;

                case eZNetPatchItemBase::StatusInstalling:
                {
                    eZNetUtils::log( $className . '::install()[' . $nodeID . ']: Required patch is currently beeing installed, required patch ID: ' . $requiredPatchItem->attribute( 'id' ) );
                    $currentTime = time() + $this->DiffTS;
                    if ( $requiredPatchItem->attribute( 'started' ) > $currentTime + 4*3600 ) // patch upgrade run for over 4 hours
                    {
                        $requiredPatchItem->uninstall();
                        return false; // Perform patch upgrade in next cronjob.
                    }
                    // Exit, and wait for patch installation to finnish
                    return false;
                } break;
            }
            return false; // Install this patch next cronjob.
        }

        $patch = $this->attribute( 'patch' );

        /* Step 3 */
        $this->begin();

        /* Step 4 */
        $patchDomDocument = $this->loadPatchFile();
        if ( !$patchDomDocument )
        {
            $this->abort();
            return false;
        }

        $rootNode = $patchDomDocument->documentElement;

        if ( !$rootNode )
        {
            eZNetUtils::log( $className . '::install()[' . $nodeID . ']: Unable to get patch root' );
            $this->abort();
            return false;
        }

        if ( !$this->installPatch( $rootNode ) )
        {
            return false;
        }

        $this->setAttribute( 'status', eZNetPatchItemBase::StatusInstalled );
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        $this->sync();

        // Update additional databases, up to the current patch.
        $this->updateSQLStatus();


        $this->commit();

        // Sleep 1.5s to delay next patch's finished time
        usleep(1500000);

        return true;
    }

    /*!
     Go through each patch step, and install the patch

     Make sure to abort() if returning false ( to end DB transaction )

     \param Patch Root XML DOM Document
     \param Set if installation should be interactive
    */
    function installPatch( DOMElement $rootNode,
                           $cli = false )
    {
        $className = get_class( $this );
        $patchElementNodeList = $rootNode->getElementsByTagName( 'PatchElement' );

        if ( !eZNetUtils::canCreateLog() )
        {
            $this->abort();
            if ( $cli )
            {
                $cli->output( $cli->stylize( 'error', 'ERROR 20: ' ) .
                              'Could not create log file.' );
            }
            return false;
        }

        // Check executable commands for accessibility.
        $checkAccessToExec = eZNetUtils::checkAccessToExecutables();
        if ( !$checkAccessToExec )
        {
            $this->abort();
            if ( $cli )
            {
                $cli->output( "Not able to execute executables. Check network.log for more information." );
            }

            return false;
        }

        foreach( $patchElementNodeList as $patchElement )
        {
            eZNetUtils::log( $className . '::installPatch()[' . eZNetUtils::nodeID() . ']: Installing patch of type: ' . $patchElement->getAttribute( 'type' ) );

            switch( $patchElement->getAttribute( 'type' ) )
            {
                case 'script':
                {
                    if ( eZNetUtils::isMaster() )
                    {
                        $fileNodeList = $patchElement->getElementsByTagName( 'Script' );
                        foreach( $fileNodeList as $fileNode )
                        {
                            $result = $this->applyScript( $fileNode, $cli );
                        }
                    }
                    else
                    {
                        $result = true;
                    }
                } break;

                case 'patch':
                {
                    $result = $this->applyPatch( $patchElement, $cli );
                } break;

                case 'sql':
                {
                    if ( eZNetUtils::isMaster() )
                    {
                        $result = $this->applySQL( $patchElement, $cli );
                    }
                    else
                    {
                        $result = true;
                    }
                } break;
            }

            if ( !$result )
            {
                $this->rollbackInstallPatch();
                return false;
            }
        }

        return true;
    }

    /*!
     Rollback copy of files to patch. Failing this is not critical.
    */
    function applyPatchRollbackPreCopy()
    {
        eZDir::recursiveDelete( eZDir::path( array( $this->storagePath(),
                                                    eZNetPatchItemBase::PatchFilePath ) ) );

        return true;
    }

    /*!
     Rollback copy of backup files. Deletes backup directory.
     Failing this is not critical.
     */
    function applyPatchRollbackBackup()
    {
        eZDir::recursiveDelete( eZDir::path( array( $this->storagePath(),
                                                    eZNetPatchItemBase::PatchBackupPath ) ) );

        return true;
    }

    /*!
     Rollback patching of copied files. Nothing needed here yet.
     */
    function applyPatchRollbackPostPatch()
    {
        return true;
    }

    /*!
     Rullback installation using the patch execution stack.

     \return true if rollback successfull, false if not.
    */
    function rollbackInstallPatch()
    {
        $className = get_class( $this );
        $nodeID = eZNetUtils::nodeID();

        $result = true;
        while( $executionElement = $this->popExecutionStack() )
        {
            $functionName = $executionElement['function'];
            eZNetUtils::log( $className . '::rollbackInstallPatch()[' . $nodeID . ']: Rollbacking: ' . $functionName . ' : Start' );
            $result = call_user_func_array( array( $this, $functionName ), $executionElement['parameterList'] );
            if ( !$result )
            {
                eZNetUtils::log( $className . '::rollbackInstallPatch()[' . $nodeID . ']: Rollback function: ' . $functionName . ' FAILED' );
                return false;
            }
            eZNetUtils::log( $className . '::rollbackInstallPatch()[' . $nodeID . ']: Rollbacking: ' . $functionName . ' : End' );
        }

        $this->abort();

        return $result;
    }

        /*!
     Rollback copying of patched files ( restore backup )

     \return true, false if fails.
    */
    function applyPatchRollbackPostCopy( $newMD5SumList, $existingMD5SumList )
    {
        $className = get_class( $this );
        $nodeID = eZNetUtils::nodeID();
        $result = $this->copyPatchFiles( $existingMD5SumList,
                                         eZDir::path( array( $this->storagePath(),
                                                             eZNetPatchItemBase::PatchBackupPath ) ),
                                         './' );
        if ( !$result )
        {
            eZNetUtils::log( $className . '::applyPatchRollbackPostCopy()[' . $nodeID . ']: The system was unable to restore the backup. This may not be critical.');
        }

        eZNetUtils::log( $className . '::applyPatchRollbackPostCopy()[' . $nodeID . ']: Checking MD5 sum of restored files: Start' );
        $result = $this->applyPatchPreCheckMD5( $existingMD5SumList );
        eZNetUtils::log( $className . '::applyPatchRollbackPostCopy()[' . $nodeID . ']: Checking MD5 sum of restored files: End' );

        return $result;

    }

    /*!
     Apply SQL to installation

    \param $elementNode
    \param $cli ( optional )
    \param execute automaticly.
    */
    function applySQL( DOMElement $elementNode,
                       $cli = false,
                       $executeAll = false )
    {
        $className = get_class( $this );
        $db = eZDB::instance();
        $db->begin();
        $result = true;
        $databaseName = $db->databaseName();

        if ( !in_array( $databaseName, eZNetUtils::supportedDatabaseList() ) )
        {
            eZNetUtils::log( $className . '::applySQL()[DB:' . $db->DB . '][NodeID:' . eZNetUtils::nodeID() . ']: This database is not supported by eZ Network: ' . $databaseName );
            return false;
        }

        $sqlTagName = false;
        if ( $databaseName == 'mysql' )
        {
            $sqlTagName = 'SQL';
        }
        else
        {
            $sqlTagName = strtoupper( $databaseName ) . 'SQL';
        }

        $sqlNodeList = $elementNode->getElementsByTagName( $sqlTagName );


        foreach( $sqlNodeList as $sqlNode )
        {
            $query = $sqlNode->nodeValue;

            // Check if query is index creation, and if the index already exists.
            if ( strpos( strtolower( trim( $query ) ), 'create index ' ) === 0 )
            {
                $tmpQuery = strtolower( trim( $query ) );
                $createIndexLen = strlen( 'create index ' );
                $nameOffset = strpos( $tmpQuery, ' ', $createIndexLen + 1 );
                $indexName = substr( $tmpQuery, $createIndexLen, $nameOffset - $createIndexLen );

                $tableNameOffset = strpos( $tmpQuery, ' on ' ) + strlen( ' on ' );
                $endTableNameOffset = strpos( $tmpQuery, ' ', $tableNameOffset + 1 );
                $tableName = substr( $tmpQuery, $tableNameOffset, $endTableNameOffset - $tableNameOffset );
                $tableName = trim( $tableName, '( ' );

                if ( eZNetUtils::dbTableIndexExists( $tableName, $indexName ) )
                {
                    eZNetUtils::log( $className . '::applySQL()[DB:' . $db->DB . '][NodeID:' . eZNetUtils::nodeID() . ']: Index ' . $indexName . ' allready exists on table ' . $tableName );
                    continue;
                }
            }

            if ( $cli )
            {
                if ( $executeAll )
                {
                    $cli->output( 'Executing SQL (' . $db->DB . '): "' . $cli->stylize( 'italic', $query ) );
                }
                else
                {
                    $input = getUserInput( 'Execute SQL (' . $db->DB . '): "' . $cli->stylize( 'italic', $query ) . ' [y/n/all] ?',
                                           array( 'y',
                                                  'n',
                                                  'a',
                                                  'all' ) );
                    if ( $input == 'a' ||
                         $input == 'all' )
                    {
                        $executeAll = true;
                    }
                    if ( $input == 'n' )
                    {
                        continue;
                    }
                }
            }
            $result = $db->query( $query );
            eZNetUtils::log( $className . '::applySQL()[' . $db->DB . '][' . eZNetUtils::nodeID() . ']: Executing query ( result: ' . $result . ' ): ' . $query );
            if ( !$result )
            {
                break;
            }
        }

        if ( $cli )
        {
            $input = getUserInput( 'Commit selected SQLs [y/n] ?',
                                   array( 'y', 'n' ) );
            if ( $input == 'n' )
            {
                $db->rollback();
                return $result;
            }
        }
        if ( $result )
        {
            $db->commit();
        }
        else
        {
            $db->rollback();
        }
        return $result;
    }

    /*!
     Apply patch to eZ Publish installation.

     \param $patchNode, describing patch settings
    */
    function applyPatch( DOMElement $patchNode,
                         $cli = false )
    {
        $className = get_class( $this );
        $nodeID = eZNetUtils::nodeID();

        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Starting file patch handling:' );
        $tmpFileDirectory = eZDir::path( array( $this->patchDirectory(), 'tmp' ) );
        eZDir::mkdir( $tmpFileDirectory, false, true );
        $existingMD5Sum = $patchNode->getElementsByTagName( 'MD5SumOldList' )->item( 0 );
        $existingMD5SumList = $existingMD5Sum->getElementsByTagName( 'MD5Sum' );
        $newMD5Sum = $patchNode->getElementsByTagName( 'MD5SumNewList' )->item( 0 );
        $newMD5SumList = $newMD5Sum->getElementsByTagName( 'MD5Sum' );

        // No need for Rollback if this fails.
        if ( $cli )
        {
            $cli->output( 'Checking existing MD5 sums.' );
        }
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPreCheckMD5" : Start' );
        $result = $this->applyPatchPreCheckMD5( $existingMD5SumList, $cli );
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPreCheckMD5" : End' );
        if ( !$result )
        {
            $return = true;
            if ( $cli )
            {
                $input = getUserInput( $cli->stylize( 'warning', 'Warning: ' ) . 'Mismatching MD5 sums indicate changes to the eZ Publish system files . Do you wish to proceed [y/n] ?',
                                       array( 'y', 'n' ) );
                if ( $input == 'y' )
                {
                    $return = false;
                }
            }
            if ( $return )
            {
                return $result;
            }
        }

        // Copy old fils to network path
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPreCopy" : Start' );
        $result = $this->applyPatchPreCopy( $existingMD5SumList );
        $this->pushExecutionStack( 'applyPatchRollbackPreCopy' );
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPreCopy" : End' );
        if ( !$result )
        {
            if ( $cli )
            {
                $cli->output( $cli->stylize( 'error', 'ERROR 32: ' ) . 'Unable to copy files to: ' .
                              $cli->stylize( 'file', eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchFilePath ) ) ) );
            }
            return $result;
        }

        // Create backup of existing files
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchBackupFiles" : Start' );
        $result = $this->applyPatchBackupFiles( $existingMD5SumList );
        $this->pushExecutionStack( 'applyPatchRollbackBackup' );
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchBackupFiles" : End' );
        if ( !$result )
        {
            if ( $cli )
            {
                $cli->output( $cli->stylize( 'error', 'ERROR 32: ' ) . 'Unable to copy files to: ' .
                              $cli->stylize( 'file', eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchBackupPath ) ) ) );
            }
            return $result;
        }

        // Apply patch to copied files
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchApplyPatch" : Start' );
        $result = $this->applyPatchApplyPatch( $patchNode, $cli );
        $this->pushExecutionStack( 'applyPatchRollbackPostPatch' );
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchApplyPatch" : End' );

        $skipPostCopy = false;
        $repeat = true;
        while( $repeat )
        {
            $repeat = false;
            // Check MD5 sums of patched files
            eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPostCheckMD5" : Start' );
            $resultArray = $this->applyPatchPostCheckMD5( $newMD5SumList, $cli );
            eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPostCheckMD5" : End' );
            if ( !empty( $resultArray ) )
            {
                $return = true;
                if ( $cli )
                {
                    $input = getUserInput( $cli->stylize( 'warning', 'Warning: ' ) .
                                           'The file(s) above does not match with the distribution files.' . "\n" .
                                           'You can correct the files above now, and redo the test by pressing [r]epeat.' . "\n" .
                                           'To diff the files listed, enter the number beside the file. [1..' . count( $resultArray ) . ']' . "\n" .
                                           'If you wish to copy patched files over the existing eZ Publish files, press ? ( [y]es, [s]kip copying, [a]bort, [r]epeat, [1..' . count( $resultArray ) . '] ) ?',
                                           array_merge( array( 'y', 's', 'a', 'r' ),
                                                        array_keys( $resultArray ) ) );
                    switch( $input )
                    {
                        case 'y':
                        {
                            $return = false;
                        } break;

                        case 's':
                        {
                            $return = false;
                            $skipPostCopy = true;
                        } break;

                        case 'r':
                        {
                            $return = false;
                            $repeat = true;
                        } break;

                        case 'a':
                        {
                        } break;

                        default:
                        {
                            $diffInput = 'r';
                            while( $diffInput == 'r' )
                            {
                                $cli->output( "\n" . 'Difference between your file, and standard file:' );
                                $cli->output( 'You may edit the file here: ' .
                                              eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchFilePath ) )
                                              . '/' . $resultArray[$input] );
                                $diff = $this->diffFile( $resultArray[$input], $cli );
                                $diffArray = explode( "\n", $diff );
                                if ( count( $diffArray ) > 2 )
                                {
                                    $diffArray[0] = '--- Original file  : ' . $resultArray[$input];
                                    $diffArray[1] = '+++ Your file      : ' . $resultArray[$input];
                                }
                                $cli->output( implode( "\n", $diffArray ) );
                                $diffInput = getUserInput( 'Press [c] to continue, or [r] to repeat test.',
                                                       array( 'c', 'r' ) );
                            }
                            $repeat = true;
                            $return = false;
                        } break;
                    }
                }
                if ( $return )
                {
                    return false;
                }
            }
        }


        if ( !$skipPostCopy )
        {

            if ( $cli )
            {
                $input = getUserInput( $cli->stylize( 'waring', 'Warning: ' ) . "You're about to overwrite your eZ Publish files\n" .
                                       'Do not proceed unless you are absolutely sure of what you are doing.' . "\n" .
                                       'Do you wish to proceed ? [y/n]: ',
                                       array( 'y', 'n' ) );
                if ( $input == 'n' )
                {
                    return false;
                }
            }

            // Copy patched files to new location
            eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPostCopy" : Start' );
            $result = $this->applyPatchPostCopy( $newMD5SumList );
            $this->pushExecutionStack( 'applyPatchRollbackPostCopy', array( $newMD5SumList, $existingMD5SumList ) );
            eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchPostCopy" : End' );
            if ( !$result )
            {
                $return = true;
                if ( $cli )
                {
                    $input = getUserInput( $cli->stylize( 'warning', 'Warning: ' ) . 'Failed to copy file from ' .
                                           $cli->stylize( 'file', eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchFilePath ) ) ) .
                                           ' to eZ Publish installation. Do you wish to proceed [y/n] ?',
                                           array( 'y', 'n' ) );
                    if ( $input == 'y' )
                    {
                        $return = false;
                    }
                }
                if ( $return )
                {
                    return $result;
                }
            }
        }

        // Update eZ Publish MD5 sums ( used for checking file consistency )
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchUpdateMD5Sums" : Start' );
        $result = $this->applyPatchUpdateMD5Sums( $newMD5SumList );
        eZNetUtils::log( $className . '::applyPatch()[' . $nodeID . ']: Executing "applyPatch" step "applyPatchUpdateMD5Sums" : End' );

        return true;
    }

    /*!
     Pop the execution rollback stack

     \return array with function and parameter list: array( 'function' => '<function_name>',
                                                            'parameterList' => '<parameter_list>' )
    */
    function popExecutionStack()
    {
        return array_pop( $this->PatchExecuteStack );
    }

    /*!
     Push function and function parameters for execution rollback stack

     \param function name
     \param parameter array ( optional, default false )
    */
    function pushExecutionStack( $function, $parameterList = false )
    {
        $this->PatchExecuteStack[] = array( 'function' => $function,
                                            'parameterList' => $parameterList );
    }

    /*!
     Update eZ Publish MD5 sums ( used for checking file consistency )
    */
    static function applyPatchUpdateMD5Sums( DOMNodeList $newMD5SumList )
    {
        foreach( $newMD5SumList as $newMD5SumNode )
        {
            eZNetUtils::setFileMD5( $newMD5SumNode->getAttribute( 'file' ),
                                    $newMD5SumNode->getAttribute( 'md5sum' ) );
        }

        return true;
    }

    /*!
     Set TS offset from global TS

     \param \a $diffTS
    */
    function setDiffTS( $diffTS )
    {
        $this->DiffTS = $diffTS;
    }

    /*!
     Go through patched files, and copy them back to original location.
    */
    function applyPatchPostCopy( DOMNodeList $newMD5SumList )
    {
        return $this->copyPatchFiles( $newMD5SumList,
                                      eZDir::path( array( $this->storagePath(),
                                                          eZNetPatchItemBase::PatchFilePath ) ),
                                      './' );
    }

    /*!
     Go through existing files, and check that all MD5 sums are OK
     Returns empty array if all files are OK.

     \return Assosiative array with files missmatching.
    */
    function applyPatchPostCheckMD5( DOMNodeList $newMD5SumList,
                                     $cli = false )
    {
        $className = get_class( $this );
        $patchPath = eZDir::path( array( $this->storagePath(),
                                         eZNetPatchItemBase::PatchFilePath ) );
        $filesOK = true;
        $returnArray = array();
        $count = 0;

        foreach( $newMD5SumList as $newMD5SumNode )
        {
            $newFile = eZDir::path( array( $patchPath,
                                           $newMD5SumNode->getAttribute( 'file' ) ) );
            $newMD5 = $newMD5SumNode->getAttribute( 'md5sum' );
            $fuzzyMatchArray = array( false, -1, 1, -2, 2 );
            $match = false;
            foreach( $fuzzyMatchArray as $fuzzyMatch )
            {
                if ( $newMD5 == eZNetUtils::eZPmd5( $newFile,
                                                    false,
                                                    $fuzzyMatch ) )
                {
                    $match = true;
                    break;
                }
            }
            if ( !$match )
            {
                eZNetUtils::log( $className . '::applyPatchPostCheckMD5()[' . eZNetUtils::nodeID() . ']:' .
                                 ' MD5 checksum mismatch ( fileMD5: ' . $newMD5 . ',' .
                                 ' correctMD5: ' . eZNetUtils::eZPmd5( $newFile ) . '): ' . $newFile );

                $returnArray[++$count] = $newMD5SumNode->getAttribute( 'file' );
                $filesOK = false;
                if ( $cli )
                {
                    $cli->output( $cli->stylize( 'warning', 'Warning, ' ) . '[' . $cli->stylize( 'green', $count ) . ']: MD5 sum mismatch: ' . $newFile );
                    if ( !eZNetUtils::checkPHPSyntax( $newFile ) )
                    {
                        $cli->output( $cli->stylize( 'error', 'Error: ' ) . 'Syntax error in file: ' . $newFile );
                    }
                }
                else
                {
                    break;
                }
            }
        }
        if ( !$filesOK && !$this->ExistingFileChangeAllowed )
        {
            eZNetUtils::log( $className . '::applyPatchPostCheckMD5()[' . eZNetUtils::nodeID() . ']: Returning due to mismatch in post MD5 sum check.' );
            return $returnArray;
        }
        return $returnArray;
    }

    /*!
     Apply patch to copied files
    */
    function applyPatchApplyPatch( DOMNode $patchNode,
                                   $cli = false )
    {
        $className = get_class( $this );
        $patchContent = eZNetPatchBase::patchNodeContent( $patchNode );

        $filePath = eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchFilePath ) );
        $patchDir = eZDir::path( array( $this->storagePath(), 'patch' ) );
        $patchIDFieldName = call_user_func_array( array( $className, 'patchIDFieldName' ), array() );
        $patchFile = 'patch_' . $this->attribute( $patchIDFieldName ) . '.diff';
        $relativePath = eZDir::path( array( '..', 'patch', $patchFile ) );
        eZFile::create( $patchFile,
                        $patchDir,
                        $patchContent );
        $patchPath = eZDir::path( array( $patchDir, $patchFile ) );
        $output = array();
        if ( $cli )
        {
            getUserInput( 'The system is now ready to patch the files in: ' . $cli->stylize( 'file', $filePath ) . '.' . "\n" .
                          'You may inspect the catalogue to check and modify the files before you continue.' . "\n" .
                          'Press ' . $cli->stylize( 'input', 'c' ) . ' to continue [c]:',
                          array( 'c' ) );
        }
        switch( eZNetUtils::getOSName() )
        {
            case 'Solaris':
            {
                // Check for existance 'gpatch' firstly
                if ( eZNetUtils::checkAccessToExecutables( 'gpatch' ) )
                {
                    exec( 'gpatch -s -f -d "' . $filePath .'" -p0 < "' . eZDir::path( array( $filePath, $relativePath ) ) . '"', $output );
                }
                else
                {
                    // If gpatch doesn't exist we try to use 'patch' instead
                    eZNetUtils::log('Solaris installation detected. GNU patch command not found. Attempting to use Solaris/Unix patch instead...');
                    exec( 'patch -d "' . $filePath . '" -p0 < "' . eZDir::path( array( $filePath, $relativePath ) ) . '"', $output );
                }
            } break;

            case 'FreeBSD':
            {
                if ( eZNetUtils::checkAccessToExecutables( 'gpatch' ) )
                {
                    exec( 'gpatch -s -f -d "' . $filePath .'" -p0 < "' . eZDir::path( array( $filePath, $relativePath ) ) . '"', $output );
                }
                else
                {
                    // If gpatch doesn't exist we try to use 'patch' instead
                    eZNetUtils::log('FreeBSD installation detected. GNU patch command not found. Attempting to use BSD/Unix patch instead...');
                    exec( 'patch -d "' . $filePath . '" -p0 < "' . eZDir::path( array( $filePath, $relativePath ) ) . '"', $output );
                }
            } break;

            default:
            {
                exec( 'patch -s -f -d "' . $filePath . '" -p0 < "' . eZDir::path( array( $filePath, $relativePath ) ) . '"', $output );
            } break;
        }
        if ( $cli )
        {
            $cli->output( 'Patch result:' . "\n" .
                          $cli->stylize( 'text', implode( "\n", $output ) ) );
            getUserInput( $cli->stylize( 'notice', 'NOTICE: '  ) .
                          'Please check the output above. ' . "\n" .
                          'The next step will check the patched files, and look for changes compared to how they should be accoring to the information provided in the patch.' . "\n" .
                          'Press [c] to continue:',
                          array( 'c' ) );
        }
        return true;
    }

        /*!
     Go through existing files, and copy them to patch dir
    */
    function applyPatchBackupFiles( DOMNodeList $existingMD5SumList )
    {
        return $this->copyPatchFiles( $existingMD5SumList,
                                      '',
                                      eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchBackupPath ) ) );
    }

    /*!
     Go through existing files, and copy them to patch dir
    */
    function applyPatchPreCopy( DOMNodeList $existingMD5SumList )
    {
        return $this->copyPatchFiles( $existingMD5SumList,
                                      '',
                                      eZDir::path( array( $this->storagePath(), eZNetPatchItemBase::PatchFilePath ) ) );
    }

    /*!
     Copy files specified in files list to specified location

     \param File list
     \param source
     \param destination
    */
    function copyPatchFiles( DOMNodeList $md5SumList, $source, $destination )
    {
        $className = get_class( $this );

        // Create destination directory
        if ( !is_dir( $destination ) )
        {
            if ( !eZDir::mkdir( $destination, false, true ) )
            {
                eZNetUtils::log( $className . '::copyPatchFiles()[' . eZNetUtils::nodeID() . ']: Unable to create path(1): ' . $destination );
                return false;
            }
        }

        foreach( $md5SumList as $md5SumNode )
        {
            // If no md5 sum, the file does not exist in before the patch.
            if ( !$md5SumNode->getAttribute( 'md5sum' ) )
            {
                continue;
            }
            $file = $md5SumNode->getAttribute( 'file' );
            $sourceFile = $source ? eZDir::path( array( $source, $file ) ) : $file;

            $destinationFile = $destination ? eZDir::path( array( $destination, $file ) ) : $file;
            $destinationPath = eZDir::dirPath( $destinationFile );

            if ( $destinationFile == $destinationPath )
            {
                $destinationPath = false;
            }

            if ( $destinationPath )
            {
                if ( !is_dir( $destinationPath ) )
                {
                    if ( !eZDir::mkdir( $destinationPath, false, true ) )
                    {
                        eZNetUtils::log( $className . '::copyPatchFiles()[' . eZNetUtils::nodeID() . ']: Unable to create path(2): ' . $destinationPath );
                        return false;
                    }
                }
            }
            else
            {
                // Remove paths possibly created by older network clients.
                if ( @is_file( $sourceFile ) &&
                     @is_dir( $destinationFile ) )
                {
                    $backupDestination = $destinationPath . '_old';
                    eZDir::copy( $destinationFile, $backupDestination );
                    eZDir::recursiveDelete( $destinationFile );
                }
            }

            if ( !copy( $sourceFile, $destinationFile ) )
            {
                eZNetUtils::log( $className . '::copyPatchFiles()[' . eZNetUtils::nodeID() . ']: Unable to copy file(3): ' . $sourceFile . ' to: ' . $destinationFile );
                return false;
            }
        }

        return true;
    }

    /*!
     Go through existing files, and check that all MD5 sums are OK
    */
    function applyPatchPreCheckMD5( DOMNodeList $existingMD5SumList,
                                    $cli = false )
    {
        $className = get_class( $this );

        $filesOK = true;
        foreach( $existingMD5SumList as $existingMD5SumNode )
        {
            $existingFile = $existingMD5SumNode->getAttribute( 'file' );
            $existingMD5 = $existingMD5SumNode->getAttribute( 'md5sum' );
            $fuzzyMatchArray = array( false, -1, 1, -2, 2 );
            $match = false;
            foreach( $fuzzyMatchArray as $fuzzyMatch )
            {
                if ( $existingMD5 == eZNetUtils::eZPmd5( $existingFile,
                                                         false,
                                                         $fuzzyMatch ) )
                {
                    $match = true;
                    break;
                }
            }
            if ( !$match )
            {
                eZNetUtils::log( $className . '::applyPatchPreCheckMD5()[' . eZNetUtils::nodeID() . ']:' .
                                 ' MD5 checksum mismatch ( storedMD5: ' . $existingMD5 . ',' .
                                 ' fileMD5: ' . eZNetUtils::eZPmd5( $existingFile ) . '): ' . $existingFile );
                $filesOK = false;
                if ( $cli )
                {
                    $cli->output( $cli->stylize( 'warning', 'Warning: ' ) . 'MD5 sum mismatch: ' . $existingFile );
                }
                else
                {
                    break;
                }
            }
        }
        if ( !$filesOK && !$this->ExistingFileChangeAllowed )
        {
            eZNetUtils::log( $className . '::applyPatchPreCheckMD5()[' . eZNetUtils::nodeID() . ']: Returning due to mismatch in existing MD5 sum.' );
            return false;
        }
        return true;
    }

    /*!
     Apply script to eZ Publish installation

     \param $fileNode
    */
    static function applyScript( DOMElement $scriptNode,
                                 $cli = false )
    {
        $script = base64_decode( $scriptNode->nodeValue );

        if ( $cli )
        {
            $input = getUserInput( 'Do you want to run this script: ' . "\n" .
                                   $cli->stylize( 'exe', $script ) . "\n" .
                                   '[y/n]',
                                   array( 'y', 'n' ) );
            if ( $input == 'n' )
            {
                $cli->output( 'Aborting...' );
                return false;
            }
        }
        return eval( $script );
    }

    /*!
     \private
     Set abort, reset patch properties
    */
    function abort()
    {
        $className = get_class( $this );
        eZNetUtils::log( $className . '::abort()[' . eZNetUtils::nodeID() . ']: Installing patch item, ID: ' . $this->attribute( 'id' ) );

        // In case we're not running in an transaction.
        $this->setAttribute( 'status', $this->oldState() );
        $this->setAttribute( 'started', 0 );
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        $this->sync();

        $db = eZDB::instance();
        $db->rollback();
    }

    /*!
     \private
     Set start patch parameters
    */
    function begin()
    {
        $className = get_class( $this );
        eZNetUtils::log( $className . '::begin()[' . eZNetUtils::nodeID() . ']: Installing patch item, ID: ' . $this->attribute( 'id' ) );

        $db = eZDB::instance();
        $db->begin();

        $this->storeOldState();

        $this->setAttribute( 'status', eZNetPatchItemBase::StatusInstalling );
        $this->setAttribute( 'started', time() + $this->DiffTS );
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        $this->sync();
    }

    /*!
     \private
     Set status as finnished
    */
    function commit()
    {
        $className = get_class( $this );
        eZNetUtils::log( $className . '::commit()[' . eZNetUtils::nodeID() . ']: Installing patch item, ID: ' . $this->attribute( 'id' ) );

        $this->setAttribute( 'status', eZNetPatchItemBase::StatusInstalled );
        $this->setAttribute( 'finnished', time() + $this->DiffTS );
        $this->setAttribute( 'modified', time() + $this->DiffTS );
        $this->sync();

        $db = eZDB::instance();
        $db->commit();
    }

    /*!
     Load patch file

     \return root of XML structure, false if non existing
    */
    function loadPatchFile()
    {
        $domDocument = new DOMDocument( '1.0', 'utf-8' );
        $success = false;
        $patch = $this->attribute( 'patch' );
        if ( $patch )
        {
            $success = $domDocument->loadXML( $patch->attribute( 'ez_patch' ), LIBXML_PARSEHUGE );
        }
        if ( !$success )
        {
            $className = get_class( $this );
            eZNetUtils::log( $className . '::loadPatchFile()[' . eZNetUtils::nodeID() . ']: Could not load patch data, patch ID: ' . $patch->attribute( 'id' ) );
        }
        return $domDocument;
    }

    /*!
     Uninstall patch currently beeing installed.
    */
    function uninstall()
    {
    }

    /*!
     \static
     List of statuses users are allowed to change from ez.no
    */
    static function changeAllowList()
    {
        return array( eZNetPatchItemBase::StatusNone,
                      eZNetPatchItemBase::StatusNotApproved );
    }

    /*!
     \static
     List of statuses users are allowed to change to.
    */
    static function changeToAllowList()
    {
        return array( eZNetPatchItemBase::StatusNone,
                      eZNetPatchItemBase::StatusPending,
                      eZNetPatchItemBase::StatusNotApproved );
    }

    /*!
     \static
     Status name map

     return status name map
    */
    static function activeStatusNameMap()
    {
        return array( eZNetPatchItemBase::StatusNone => ezi18n( 'ez_network', 'None' ),
                      eZNetPatchItemBase::StatusNotApproved => ezi18n( 'ez_network', 'Do not install' ),
                      eZNetPatchItemBase::StatusPending => ezi18n( 'ez_network', 'Install' ),
                      eZNetPatchItemBase::StatusInstalling => ezi18n( 'ez_network', 'Installing' ),
                      eZNetPatchItemBase::StatusInstalled => ezi18n( 'ez_network', 'Installed' ),
                      eZNetPatchItemBase::StatusFailed => ezi18n( 'ez_network', 'Failed' ),
                      eZNetPatchItemBase::StatusObsolete => ezi18n( 'ez_network', 'Obsolete' ) );
    }

    /*!
     \static
     Status name map

     return status name map
    */
    static function passiveStatusNameMap()
    {
        return array( eZNetPatchItemBase::StatusNone => ezi18n( 'ez_network', 'None' ),
                      eZNetPatchItemBase::StatusNotApproved => ezi18n( 'ez_network', 'Discarded by user' ),
                      eZNetPatchItemBase::StatusPending => ezi18n( 'ez_network', 'Pending' ),
                      eZNetPatchItemBase::StatusInstalling => ezi18n( 'ez_network', 'Installing' ),
                      eZNetPatchItemBase::StatusInstalled => ezi18n( 'ez_network', 'Installed' ),
                      eZNetPatchItemBase::StatusFailed => ezi18n( 'ez_network', 'Failed' ),
                      eZNetPatchItemBase::StatusObsolete => ezi18n( 'ez_network', 'Obsolete' ) );
    }

    /*!
     Set old state
    */
    function storeOldState()
    {
        $this->OldState = $this->attribute( 'status' );
    }

    /*!
     Get old state
    */
    function oldState()
    {
        return $this->OldState;
    }

    /*!
     \static
     \abstract
    */
    static function patchIDFieldName()
    {
        return false;
    }

    /*!
     \static
     \abstract
    */
    static function patchClassName()
    {
        return false;
    }

    /*!
     \recursive

     Make all patches leading up to the base installation obsolete.

     Only make obsolete if version != false and $version <= SDK version
     Set version if "To release tag" <= SDK version

     \param $version "To release tag" from previous patch
    */
    function makePreviousObsolete( $version = false )
    {
        if ( $requiredPatchItem = $this->attribute( 'required_patch_item' )  )
        {
            if ( in_array( $requiredPatchItem->attribute( 'status' ),
                           array( eZNetPatchItemBase::StatusNone,
                                  eZNetPatchItemBase::StatusNotApproved,
                                  eZNetPatchItemBase::StatusPending ) ) )
            {
                // Set version if "To release tag" is <= SDK version (next patch)
                $requiredPatch = $requiredPatchItem->attribute( 'patch' );
                if ( $requiredPatch->option( 'to_release_tag' ) != null && $requiredPatch->option( 'to_release_tag' ) <= eZPublishSDK::version( true, false, false ) )
                {
                    $version = $requiredPatch->option( 'to_release_tag' );
                }

                // Mark as obsolete if version != false AND $version is <= than SDK version
                if ( $version != false && $version <= eZPublishSDK::version( true, false, false ) )
                {
                    $requiredPatchItem->setAttribute( 'status', eZNetPatchItemBase::StatusObsolete );
                    $requiredPatchItem->setAttribute( 'modified', time() + $this->DiffTS );
                    $requiredPatchItem->sync();
                }
            }
            $requiredPatchItem->makePreviousObsolete( $version );
        }
    }

    /*!
     This functions chekcs if all SQL patches has been performed on all installations.

     If the installation does not have multi_db_enabled, the function will return true,
     without doing anything.

     The function will check for new databases as well, and perform the updates there as
     well if needed.

     The function does status logging itself.

     \param $cli, optional ( default false ), set to
            eZCLI object for interactive installation.

     \return true if everything is successfull, false if not.
    */
    function updateSQLStatus( $cli = false )
    {
        $className = get_class( $this );
        $executeAll = false;

        $installation = eZNetInstallation::fetchCurrent();
        if ( !$installation->attribute( 'is_multi_db_enabled' ) )
        {
            if ( count( eZNetUtils::dbList() ) > 1 )
            {
                eZNetUtils::log( $className . '::updateSQLStatus(), Multiple sites detected, but not enabled for installation.' );
            }
            return true;
        }

        // Get DB list, and remove mail DB.
        $db = eZDB::instance();
        $dbList = eZNetUtils::dbList();
        unset( $dbList[$db->DB] );

        foreach( $dbList as $dbName => $dbSettings )
        {
            $sqlPatchStatus = $this->sqlPatchStatus( $dbName );
            if ( !$sqlPatchStatus )
            {
                $sqlPatchStatus = $this->createSqlPatchStatus( $dbName,
                                                               $dbSettings['site_access'] );
                $sqlPatchStatus->store();
            }

            if ( $cli )
            {
                if ( $executeAll )
                {
                    $cli->output( 'Executing updates for DB: ' . $dbName );
                }
                else
                {
                    $input = getUserInput( 'Install patches for database: "' . $cli->stylize( 'italic', $dbName ) . '" [y/n/all] ?',
                                           array( 'y',
                                                  'n',
                                                  'a', 'all' ) );
                    if ( $input == 'n' )
                    {
                        continue;
                    }
                    if ( $input == 'a' ||
                         $input == 'all' )
                    {
                        $executeAll = true;
                    }
                }
            }

            $sqlPatchStatus->installPatches( $this,
                                             $installation,
                                             $cli,
                                             $executeAll );
        }
    }

    /*!
     \abstract

     Get SQL Patch status item

     \param $dbName

     \return SQL Patch status item
    */
    static function sqlPatchStatus( $dbName )
    {
    }

    /*!
     \abstract

     Create SQL Patch status item

     \param $dbName
     \param $siteAccess name

     \return SQL Patch status item
    */
    static function createSQLPatchStatus( $dbName, $siteAccessName )
    {
    }

    /*!
     Diff files with distribution files.

     \param Filename
     \param pre pr post check. ( default post )

     \return diff
    */
    function diffFile( $filename, $cli, $postCheck = false )
    {
        $syncINI = eZINI::instance( 'sync.ini' );
        $Server = $syncINI->variable( 'NetworkSettings', 'Server' );
        $Port = $syncINI->variable( 'NetworkSettings', 'Port' );
        $Path = $syncINI->variable( 'NetworkSettings', 'Path' );

        // If use of SSL fails the client must attempt to use HTTP
        $Port = eZNetSOAPSync::getPort( $Server, $Path, $Port );

        $soapClient = new eZSOAPClient( $Server, $Path, $Port );

        $request = new eZSOAPRequest( 'eZNetMonSOAPTools__diffFile', 'eZNetNS' );
        $request->addParameter( 'version', eZPublishSDK::version( false, false, false ) );
        $request->addParameter( 'patchID', $this->originalPatchID() );
        $request->addParameter( 'filename', $filename );
        $request->addParameter( 'data', file_get_contents( eZDir::path( array( $this->storagePath(),
                                                                                 eZNetPatchItemBase::PatchFilePath,
                                                                                 $filename ) ) ) );
        $request->addParameter( 'postCompare', $postCheck );
        $request->addParameter( 'installationKey', eZNetUtils::hostID() );

        $response = $soapClient->send( $request );

        if( $response->isFault() )
        {
            $cli->output( "Failed connecting to eZ Systems servers ($Server:$Port$Path) to calculate differnces." );
            return '';
        }

        return $response->value();
    }

    /*!
     Set original patch ID
     This ID is used by Patch diffing.

     \param Original patch ID
    */
    function setOriginalPatchID( $id )
    {
        $this->OriginalPatchID = $id;
    }

    /*!
     Get original patch ID.

     \return original patch ID
    */
    function originalPatchID()
    {
        if ( $this->OriginalPatchID )
        {
            return $this->OriginalPatchID;
        }
        $patch = $this->attribute( 'patch' );
        return $patch->attribute( 'original_patch_id' );
    }

    /// Private final variables
    var $NetUtils = null;

    var $OldState = null;

    var $ExistingFileChangeAllowed = false;

    /// Patch execute stack. Used for rollbacking patch installations.
    var $PatchExecuteStack = array();

    var $OriginalPatchID = null;

    var $DiffTS = 0;
}

?>
