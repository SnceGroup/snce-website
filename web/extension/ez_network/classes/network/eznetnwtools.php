<?php
/**
 * File containing eZNetNWTools class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetNWTools eznetnwtools.php
  \brief The class eZNetNWTools does

*/
class eZNetNWTools
{

    /*!
     \constructor
    */
    function eZNetNWTools()
    {
        $this->DB = eZDB::instance();
        $this->CLI = eZCLI::instance();
    }

    /*!
     Fetch SOAPLog for patch item

     \param eZNetPatchItem
     \param $remoteHost ( optional )

     \return eZNetSOAPLog
     */
    static function fetchSoapLogForPatchItem( $patchItem, $remoteHost = false )
    {
        $condArray = array( 'class_name' => 'eZNetPatchItem',
                            'key_name' => 'id',
                            'local_value' => $patchItem->attribute( 'id' ) );

        if ( $remoteHost )
        {
            $condArray['remote_host'] = $remoteHost;
        }
        return eZNetSOAPLog::fetchObject( eZNetSOAPLog::definition(),
                                          null,
                                          $condArray,
                                          true );
    }

    /*!
     Fetch SOAPLog for module patch item

     \param eZNetModulePatchItem
     \param $remoteHost ( optional )

     \return eZNetSOAPLog
     */
    static function fetchSoapLogForModulePatchItem( $modulePatchItem, $remoteHost = false )
    {
        $condArray = array( 'class_name' => 'eZNetModulePatchItem',
                            'key_name' => 'id',
                            'local_value' => $modulePatchItem->attribute( 'id' ) );

        if ( $remoteHost )
        {
            $condArray['remote_host'] = $remoteHost;
        }
        return eZNetSOAPLog::fetchObject( eZNetSOAPLog::definition(),
                                          null,
                                          $condArray,
                                          true );
    }

    /*!
     Check if patch item belongs to installation by connecting to the
     intranet, and check it's status there.

     \param patchItemID
     \param installationID

     \return TRUE if patch item belongs to installtion.
    */
    function patchItemBelongsToInstallation( $patchItemID, $installationID, $remoteHostID = false )
    {
        $installation = eZNetInstallation::fetch( $installationID );
        if ( !$installation )
        {
            return array( 'success' => false,
                          'description' => 'Could not fetch eZNetInstallation( ' . $installationID . ' )' );
        }

        $patchItem = eZNetPatchItem::fetch( $patchItemID);
        if ( !$patchItem )
        {
            return array( 'success' => false,
                          'description' => 'Could not fetch eZNetPatchItem( ' . $patchItemID . ' )' );
        }

        $soapLog = $this->fetchSoapLogForPatchItem( $patchItem, $remoteHostID );
        // If it can not find the eZNetSOAPLog, remove the item.
        if ( !$soapLog )
        {
            $this->removePatchItem( $patchItem );
            return array( 'success' => true,
                          'operation' => $this->opRemove );
        }

        // Ask server if eZNetPatchItem belongs to installation.
        $ini = eZINI::instance( 'sync.ini' );
        $Server = $ini->variable( 'NetworkSettings', 'Server' );
        $Port = $ini->variable( 'NetworkSettings', 'Port' );
        $Path = $ini->variable( 'NetworkSettings', 'Path' );

        $request = $this->createPatchItemBelongsToSOAPRequest( $soapLog->attribute( 'remote_value' ),
                                                               $installation->attribute( 'remote_id' ) );
        // If use of SSL fails the client must attempt to use HTTP
        $Port = eZNetSOAPSync::getPort( $Server, $Path, $Port );

        $client = new eZSOAPClient( $Server, $Path, $Port );
        $response = $client->send( $request );

        if ( !$response ||
             $response->isFault() )
        {
            return array( 'success' => false,
                          'description' => 'Could not send SOAP request for eZNetPatchItem ( ' . $patchItem->attribute( 'id' ) . ' )' );
        }

        // Check server responce if the eZNetPatchItem belongs to the installation.
        if ( !$response->value() )
        {
            $this->removePatchItem( $patchItem );
            return array( 'success' => true,
                          'operation' => $this->opRemove );
        }

        return array( 'success' => true,
                      'operation' => $this->opKeep );

    }

    /*!
     Check if module patch item belongs to installation by connecting to the
     intranet, and check it's status there.

     \param patchItemID
     \param installationID

     \return TRUE if patch item belongs to installtion.
    */
    function modulePatchItemBelongsToInstallation( $modulePatchItemID, $installationID, $remoteHostID = false )
    {
        $installation = eZNetInstallation::fetch( $installationID );
        if ( !$installation )
        {
            return array( 'success' => false,
                          'description' => 'Could not fetch eZNetInstallation( ' . $installationID . ' )' );
        }

        $patchItem = eZNetModulePatchItem::fetch( $modulePatchItemID );
        if ( !$patchItem )
        {
            return array( 'success' => false,
                          'description' => 'Could not fetch eZNetModulePatchItem( ' . $modulePatchItemID . ' )' );
        }

        $soapLog = $this->fetchSoapLogForModulePatchItem( $patchItem, $remoteHostID );
        // If it can not find the eZNetSOAPLog, remove the item.
        if ( !$soapLog )
        {
            $this->removePatchItem( $patchItem );
            return array( 'success' => true,
                          'operation' => $this->opRemove );
        }

        // Ask server if eZNetPatchItem belongs to installation.
        $ini = eZINI::instance( 'sync.ini' );
        $Server = $ini->variable( 'NetworkSettings', 'Server' );
        $Port = $ini->variable( 'NetworkSettings', 'Port' );
        $Path = $ini->variable( 'NetworkSettings', 'Path' );

        $request = $this->createModulePatchItemBelongsToSOAPRequest( $soapLog->attribute( 'remote_value' ),
                                                                     $installation->attribute( 'remote_id' ) );
        $client = new eZSOAPClient( $Server, $Path, $Port );
        $response = $client->send( $request );

        if ( !$response ||
             $response->isFault() )
        {
            return array( 'success' => false,
                          'description' => 'Could not send SOAP request for eZNetModulePatchItem ( ' . $patchItem->attribute( 'id' ) . ' )' );
        }

        // Check server responce if the eZNetModulePatchItem belongs to the installation.
        if ( !$response->value() )
        {
            $this->removePatchItem( $patchItem );
            return array( 'success' => true,
                          'operation' => $this->opRemove );
        }

        return array( 'success' => true,
                      'operation' => $this->opKeep );

    }


    /*!
     Remove persistentObject result
    */
    function removePatchItem( $persistentObject )
    {
        echo '.';
        $this->DB->begin();
        $this->cleanupSOAPLog( $persistentObject );
        $persistentObject->remove();
        $this->DB->commit();
    }

    /*!
     Clean up eZNetSOAPLog
    */
    static function cleanupSOAPLog( $persistentObject )
    {
        $definition = $persistentObject->definition();
        foreach ( eZNetSOAPLog::fetchObjectList( eZNetSOAPLog::definition(),
                                                 null,
                                                 array( 'class_name' => $definition['class_name'],
                                                        'key_name' => $definition['keys'][0],
                                                        'local_value' => $persistentObject->attribute( $definition['keys'][0] ) ) )
                  as $soapLog )
        {
            $soapLog->remove();
        }
    }

    /*!
     Clean up obsolete patch items from previous bug in syncronization.
     This function will remove all patch items with missing patches.
     ( patch_id in eZNetPatchItem does not match any eZNetPatch entries )
    */
    function cleanupPatchItem()
    {
        $this->CLI->output( 'Cleaning up eZNetPatchItem missing patches or installation.' );
        $sql = 'DELETE FROM ezx_ezpnet_patch_item ' .
            'WHERE ezx_ezpnet_patch_item.patch_id <> ALL ( SELECT id FROM ezx_ezpnet_patch )';
        $this->DB->query( $sql );
        $sql = 'DELETE FROM ezx_ezpnet_patch_item ' .
            'WHERE ezx_ezpnet_patch_item.installation_id <> ALL ( SELECT id FROM ezx_ezpnet_installation )';
        $this->DB->query( $sql );
    }

    /*!
     Remove patch items where patch branch does not match installation branch
    */
    function cleanupInvalidPatchItems()
    {
        $this->CLI->output( 'Remove patch items with invalid branch ID' );
        $installationOffset = 0;
        $installationLimit = 20;
        while( $installationList = eZNetInstallation::fetchList( false,
                                                                 $installationOffset,
                                                                 $installationLimit ) )
        {
            foreach( $installationList as $installation )
            {
                $patchItemOffset = 0;
                $patchItemLimit = 50;
                while( $patchItemList = eZNetPatchItem::fetchListByInstallationID( $installation->attribute( 'id' ),
                                                                                   false,
                                                                                   $patchItemOffset,
                                                                                   $patchItemLimit ) )
                {
                    foreach( $patchItemList as $patchItem )
                    {
                        if ( $patchItem->attribute( 'branch_id' ) != $installation->attribute( 'branch_id' ) )
                        {
                            $this->removePatchItem( $patchItem );
                            --$patchItemOffset;
                        }
                    }
                    $patchItemOffset += $patchItemLimit;
                }
            }
            $installationOffset += $installationLimit;
        }
        echo "\n";
    }

    //// Vars

    var $DB;
    var $CLI;

    var $opRemove = 1;
    var $opKeep = 2;
}

?>
