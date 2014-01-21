<?php
/**
 * File containing eZNetSOAPSyncManager class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPSyncManager eznetsoapsyncmanager.php
  \brief The class eZNetSOAPSyncManager manages SOAP syncronizations.
         The class is used by the client to handle SOAP syncronizations.

*/
class eZNetSOAPSyncManager
{
    /// Const
    const DefaultFetchLimit = 100;

    /*!
     Constructor

     \param eZSoapClient
     \param Class syncronization list
     \param CLI
    */
    function eZNetSOAPSyncManager( $soapClient,
                                   $classList,
                                   $cli )
    {
        $this->SOAPClient = $soapClient;
        $this->CLI = $cli;
        $this->ClassList = $classList;
    }

    /*!
     Syncronize the class list provided in the constructor, using the SOAP client provided.
     */
    function syncronize()
    {
        $orderedClassList = eZNetSOAPSyncAdvanced::orderClassListByDependencies( $this->ClassList );
        $reversedClassList = array_reverse( $orderedClassList );

        $db = eZDB::instance();
        $db->begin();

        // Fetch max modified/ID for all classes which should be syncronized.
        $this->CLI->output( 'Fetching max remote values' );
        $maxValueList = array();
        foreach( $reversedClassList as $className )
        {
            $soapSync = new eZNetSOAPSync( call_user_func( array( $className, 'definition' ) ) );
            $maxValueList[$className] = $soapSync->maxRemoteValue( $this->SOAPClient );
        }

        foreach( $orderedClassList as $className )
        {
            $transferCount = 0;
            $transferSuccess = false;

            while( !$transferSuccess &&
                   $transferCount < 3 )
            {
                $messageSync = new eZNetSOAPSync( call_user_func( array( $className, 'definition' ) ) );
                $result = $messageSync->syncronize( $this->SOAPClient,
                                                    $this->fetchLimit( $className ),
                                                    $maxValueList[$className],
                                                    $this->CLI );
                if ( $result )
                {
                    $transferSuccess = true;
                    $this->CLI->output( 'Imported : ' . $result['import_count'] . ' elements to Class : ' . $result['class_name'] );
                }
                else
                {
                    ++$transferCount;
                }
            }
            if ( !$transferSuccess )
            {
                $this->CLI->error( 'Syncronization of: ' . $className . ' failed. Aborting syncronization.' );
                break;
            }
        }

        $db->commit();
    }

    /*!
     Syncronize the client class list provided in the constructor, using the SOAP client provided.
     */
    function syncronizeClient()
    {
        $orderedClassList = eZNetSOAPSyncAdvanced::orderClassListByDependencies( $this->ClassList );
        $reversedClassList = array_reverse( $orderedClassList );

        $db = eZDB::instance();
        $db->begin();

        // Fetch max modified/ID for all classes which should be syncronized.
        $this->CLI->output( 'Fetching max remote values' );
        $maxValueList = array();
        foreach( $reversedClassList as $className )
        {
            $soapSync = new eZNetSOAPSyncClient( call_user_func( array( $className, 'definition' ) ) );
            $maxValueList[$className] = $soapSync->maxRemoteValue( $this->SOAPClient );
        }

        foreach( $orderedClassList as $className )
        {
            $transferCount = 0;
            $transferSuccess = false;

            while( !$transferSuccess &&
                   $transferCount < 3 )
            {
                $messageSync = new eZNetSOAPSyncClient( call_user_func( array( $className, 'definition' ) ) );
                $result = $messageSync->syncronize( $this->SOAPClient,
                                                    $this->fetchLimit( $className ),
                                                    $maxValueList[$className],
                                                    $this->CLI );
                if ( $result )
                {
                    $transferSuccess = true;
                    $this->CLI->output( 'Imported : ' . $result['import_count'] . ' elements to Class : ' . $result['class_name'] );
                }
                else
                {
                    ++$transferCount;
                }
            }
            if ( !$transferSuccess )
            {
                $this->CLI->error( 'Syncronization of: ' . $className . ' failed. Aborting syncronization.' );
                break;
            }
        }

        $db->commit();
    }

    /*!
     \private
     Get list of custom class fetch limits

     \return custom class fetch limits
     */
    static function customClassFetchLimit()
    {
        return array( 'eZNetPatch' => 1 );
    }

    /*!
     \private

     \param class name

     \return fetch limit
    */
    function fetchLimit( $className )
    {
        $customFetchList = $this->customClassFetchLimit();
        return isset( $customFetchList[$className] ) ?
            $customFetchList[$className] :
            eZNetSOAPSyncManager::DefaultFetchLimit;
    }

    /// Class variables
    var $SOAPClient;
    var $CLI;
    var $ClassList;
}

?>
