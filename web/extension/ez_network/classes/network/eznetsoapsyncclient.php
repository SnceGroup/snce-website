<?php
/**
 * File containing eZNetSOAPSyncClient class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPSyncClient eznetsoapsyncclient.php
  \brief The class eZNetSOAPSyncClient does

*/
class eZNetSOAPSyncClient extends eZNetSOAPSync
{
    /*!
     Constructor

     \param eZPersistenceObject definition
    */
    function eZNetSOAPSyncClient( $definition = false , $remoteHost = false )
    {
        $this->eZNetSOAPSync( $definition, $remoteHost );
    }

    /*!
     Syncronize - push. Push client data to server.
    */
    function syncronizePushClient( $soapClient )
    {
        $sendCount = 0;

        // 1. Get remote eZ Publish hostID
        $request = new eZSOAPRequest( 'hostID', eZNetSOAPSync::SYNC_NAMESPACE );
        $response = $soapClient->send( $request );

        if( !$request ||
            $response->isFault() )
        {
            eZDebug::writeError( 'Did not get valid result running SOAP method : hostID, on class : ' . $this->ClassName );
            return false;
        }

        $this->RemoteHost = $response->value(); // Missing message IDs

        if ( !$this->RemoteHost )
        {
            eZDebug::writeError( 'RemoteHost not set: ' . var_export( $this->RemoteHost, 1 ),
                                 'eZNetSOAPSync::syncronize()' );
            return false;
        }

        $sendList = $this->createSendArrayList( $soapClient );

        while( $sendList &&
               count( $sendList  ) > 0 )
        {
            $request = new eZSOAPRequest( 'importElements', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'data', $sendList );
            $response = $soapClient->send( $request );

            if( $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : importElements, on class : ' . $this->ClassName );
                return false;
            }

            $sendCount += count( $sendList );

            $sendList = $this->createSendArrayList( $soapClient );
        }

        return array( 'class_name' => $this->ClassName,
                      'export_count' => $sendCount );
    }

    /*!
     Get list of objects to send.

     \param soap client.

     \return list of objects to send.
    */
    function createSendArrayList( $soapClient )
    {
        $useModified = isset( $this->Fields['modified'] );

        if ( $useModified )
        {
            $request = new eZSOAPRequest( 'getLatestModified', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $response = $soapClient->send( $request );

            if( $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : getLatestModified, on class : ' . $this->ClassName );
                return false;
            }

            $latestModified = $response->value();

            $latestList = $this->fetchListByLatestModified( $latestModified );
        }
        else
        {
            $request = new eZSOAPRequest( 'getLatestID', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $response = $soapClient->send( $request );

            if( $response->isFault() )
            {
                eZDebug::writeNotice( 'Did not get valid result running SOAP method : getLatestID, on class : ' . $this->ClassName );
                return false;
            }

            $latestID = $response->value(); // Missing message IDs

            $latestList = $this->fetchListByLatestID( $latestID );
        }

        return $latestList;
    }

    /*!
     Create standard soap request for "Fetch by latest"

     \param optional number of objects to be fetched at one time, default 100

     \return Soap request
    */
    function createFetchListSoapRequest( $limit = 100, $cli = null )
    {
        $useModified = isset( $this->Fields['modified'] );
        $cli = $cli === null ? eZCLI::instance() : $cli;

        if ( $useModified )
        {
            $request = new eZSOAPRequest( 'fetchListByHostIDLatestModified', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'latestModified', $this->getLatestModified() );
            $cli->output( 'Synchronizing: ' . $this->ClassName . ', latest updated: ' . $this->getLatestModified() );
        }
        else
        {
            $request = new eZSOAPRequest( 'fetchListByHostIDLatestID', eZNetSOAPSync::SYNC_NAMESPACE );
            $request->addParameter( 'className', $this->ClassName );
            $request->addParameter( 'hostID', eZNetUtils::hostID() );
            $request->addParameter( 'latestID', $this->getLatestID() );
            $cli->output( 'Synchronizing: ' . $this->ClassName . ', id: ' . $this->getLatestID() );
        }

        return $request;
    }

}

?>
