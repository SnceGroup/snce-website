<?php
/**
 * File containing the eZNetClientInfo class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetClientInfo eznetclientinfo.php
  \brief The class eZNetClientInfo does

  - Checks if DB Update is needed.
    - Creates cronjob lock if DB update is on progress. ( uses ezsite_data table for this operation )

  - Stores version information about the network client.
*/

class eZNetClientInfo
{
    /// Public constants
    const LOCK_TIMEOUT = 3600;
    const VERSION_NAME = 'ezxnet_version';
    const LOCK_NAME = 'ezxnet_lock';
    const EZNET_DB = 'ezxnet_db';
    const EMPTY_DB = 'empty';

    /**
     * @var null|eZDBInterface
     */
    private $DB = null;

    /**
     * @var array Array with functions to be executed pr version update
     */
    private $VersionArray = array( '0.1' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.0.1' => array( 'functionList' => array( 'clearDB' ) ),
                               '1.1.0' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.1.1' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.1.2' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.2.0' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.2.1' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '1.3.0' => array( 'functionList' => array( 'update130' ) ),
                               '1.4.0' => array( 'functionList' => array( 'update140' ) ),
                               '5.0.0' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '5.1.0' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               '5.2.0' => array( 'functionList' => array( 'updateSchema', 'clearDB' ) ),
                               );
    /*!
     Constructor
    */
    function __construct()
    {
        $this->DB = eZDB::instance();
    }

    /*!
     \static

     Get instance of the eZNetClientInfo class.
    */
    public static function instance()
    {
        return new eZNetClientInfo();
    }

    /*!
     Check if version is validated. This will check the installed Network version with the
     one indicated in the database. In case there is a missmatch, it'll check the version path
     for required DB updates, and perform them.

     While performing the updates, this function will act as a cronjob lock. If locked, the
     function will return false.

     If the lock has been present for more than 4 hours, the lock will be removed.

     \return true if everything is ok.
             false if locked.
    */
    public function validate()
    {
        if ( $this->locked() )
        {
            return false;
        }

        if ( !$this->correctVersion() )
        {
            if ( !$this->lock() )
            {
                eZNetUtils::log( 'ERROR : Could not create lock.' );
                return false;
            }

            eZNetUtils::log( 'Incorrect version. ' . $this->currentVersion() . ' should be: ' . max( array_keys( $this->VersionArray ) ) );

            $this->DB->begin();
            $this->upgrade();
            $this->updateVersion();
            $this->unLock();
            $this->DB->commit();

            eZNetUtils::log( 'Updated to version: ' . max( array_keys( $this->VersionArray ) ) );
        }

        return true;
    }

    /*!
     Update Network version
    */
    public function updateVersion()
    {
        if ( $this->currentVersion() )
        {
            $sql = 'UPDATE ezsite_data
                    SET value=\'' . $this->DB->escapeString( max( array_keys( $this->VersionArray ) ) ) . '\'
                    WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::VERSION_NAME ) . '\'';
        }
        else
        {
            $sql = 'INSERT INTO ezsite_data ( name, value )
                    VALUES ( \'' . $this->DB->escapeString( eZNetClientInfo::VERSION_NAME ) . '\',
                             \'' . $this->DB->escapeString( max( array_keys( $this->VersionArray ) ) ) . '\' )';
        }

        $this->DB->query( $sql );
    }

    /*!
     \public

     Checks if current execution is the first run after an update.

     \return true if DB has been cleared recently.
    */
    private function isFirstRun()
    {
        $sql = 'SELECT count(*) count FROM ezsite_data
                WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::EZNET_DB ) . '\'';

        $result = $this->DB->arrayQuery( $sql );

        return $result[0]['count'] > 0;
    }

    /*!
     \private

     Stores a value to DB it means DB has been cleared

    */
    function setEmptyDB()
    {
        // If empty DB value already exists
        if ( $this->isFirstRun() )
        {
            return;
        }

        $this->DB->begin();
        $sql = 'INSERT INTO ezsite_data ( name, value )
                VALUES ( \'' . $this->DB->escapeString( eZNetClientInfo::EZNET_DB ) . '\',
                         \'' . $this->DB->escapeString( eZNetClientInfo::EMPTY_DB ) . '\')';

        $this->DB->query( $sql );
        $this->DB->commit();
    }

    /*!
     \public

     Drops notice from DB. It means that the execution is not already the first.

    */
    function dropFirstRun()
    {
        $this->DB->begin();
        $sql = 'DELETE FROM ezsite_data
                WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::EZNET_DB ) . '\'';

        $this->DB->query( $sql );
        $this->DB->commit();
    }

    /*!
     Run functions required to upgrade to latest version.
     */
    private function upgrade()
    {
        foreach( $this->upgradeFunctionList() as $function )
        {
            call_user_func( array( $this, $function ) );
        }
    }

    /*!
     Generate list of functions required to run to upgrade version.

     \return array of functions to run
    */
    private function upgradeFunctionList()
    {
        $functionList = array();
        $currentVersion = $this->currentVersion();

        foreach( $this->VersionArray as $version => $upgradeDefinition )
        {
            if ( $version <= $currentVersion )
            {
                continue;
            }
            if ( isset( $upgradeDefinition['functionList'] ) )
            {
                $functionList = array_merge( $functionList, $upgradeDefinition['functionList'] );
            }
        }

        return $functionList;
    }

    /*!
     Check that the correct version is installed.

     \return true if the version is correct, false if not.
    */
    private function correctVersion()
    {
        $currentVersion = $this->currentVersion();

        if ( !$currentVersion )
        {
            return false;
        }

        $correctVersion = max( array_keys( $this->VersionArray ) );
        return ( $currentVersion == $correctVersion );
    }

    /*!
     Get currect version number

     \return current version, false if not set.
    */
    public function currentVersion()
    {
        $sql = 'SELECT value FROM ezsite_data
                WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::VERSION_NAME ) . '\'';
        $resultSet = $this->DB->arrayQuery( $sql );

        if ( empty( $resultSet ) )
        {
            return false;
        }

        return $resultSet[0]['value'];
    }

    /*!
     Check if installation is locked. If the installation is locked, check if the lock is oder than
     the specified lock time.

     \retrun true if locked, false if not locked.
     */
    private function locked()
    {
        $sql = 'SELECT value FROM ezsite_data
                WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::LOCK_NAME ) . '\'';
        $resultSet = $this->DB->arrayQuery( $sql );

        if ( empty( $resultSet ) )
        {
            return false;
        }

        if ( $resultSet[0]['value'] + eZNetClientInfo::LOCK_TIMEOUT < time() )
        {
            return $this->unLock();
        }

        return true;
    }

    /*!
     Remove lock.

     \return true if successfull.
     */
    private function unLock()
    {
        $this->DB->begin();
        $sql = 'DELETE FROM ezsite_data WHERE name=\'' . $this->DB->escapeString( eZNetClientInfo::LOCK_NAME ) . '\'';
        $this->DB->query( $sql );
        return $this->DB->commit();
    }

    /*!
     Create lock.

     \return true if successfull.
    */
    private function lock()
    {
        $this->DB->begin();
        $sql = 'INSERT INTO ezsite_data ( name, value )
                VALUES ( \'' . $this->DB->escapeString( eZNetClientInfo::LOCK_NAME ) . '\', \'' . time() . '\' )';
        $this->DB->query( $sql );
        return $this->DB->commit();
    }

    /**
     * Workaround for issues in eZDbSchema for ez_network 1.2.1 => 1.3.0 upgrade
     *
     * Renaming of column that is part of primary key is a bit more then what eZDBSchema can handle on oracle & postgres
     *
     * @return void
     */
    private function update130()
    {
        if ( $this->DB->databaseName() == 'postgresql' )
        {
            $this->DB->begin();
            $this->DB->query( 'ALTER TABLE ezx_ezpnet_large_store RENAME COLUMN "offset" TO data_offset' );
            $this->DB->commit();
            $this->updateSchema();
        }
        else if ( $this->DB->databaseName() == 'oracle' )
        {
            $this->DB->begin();
            $this->DB->query( 'ALTER TABLE ezx_ezpnet_large_store RENAME COLUMN offset TO data_offset' );
            $this->DB->commit();
            // skip updateSchema() as it seems to crash the upgrade
        }
        else
        {
            $this->DB->begin();
            $this->DB->query( "ALTER TABLE ezx_ezpnet_large_store CHANGE COLUMN `offset` `data_offset` int(11) NOT NULL DEFAULT '0'" );
            $this->DB->commit();
            $this->updateSchema();
        }
        $this->clearDB();
    }

    /**
     * Workaround for issues in eZDbSchema for ez_network 1.3.0 => 1.4.0 upgrade
     *
     * Adding a column is to much to ask for it seems.
     *
     * @return void
     */
    private function update140()
    {
        if ( $this->DB->databaseName() == 'postgresql' )
        {
            $this->DB->begin();
            $this->DB->query( 'ALTER TABLE ezx_ezpnet_module_branch ADD COLUMN branch_id INTEGER DEFAULT 0 NOT NULL' );
            $this->DB->commit();
            //$this->updateSchema(); Not needed and seems to crash the upgrade
        }
        else if ( $this->DB->databaseName() == 'oracle' )
        {
            $this->DB->begin();
            $this->DB->query( 'ALTER TABLE ezx_ezpnet_module_branch ADD branch_id INTEGER DEFAULT 0 NOT NULL' );
            $this->DB->commit();
            // skip updateSchema(); Not needed and seems to crash the upgrade
        }
        else
        {
            $this->updateSchema();
        }
        $this->clearDB();
    }

    /*!
     Update DB Schema
    */
    private function updateSchema()
    {
        $dbContents = $this->getSchema( $this->getSchemaFile() );
        $schema = isset( $dbContents['schema'] ) ? $dbContents['schema'] : false;
        $this->insertSchema( $schema );
    }

    /**
     * Get the $schemaFile
     *
     * @return string
     */
    public function getSchemaFile()
    {
        return eZExtension::baseDirectory() . '/' .
            eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'ExtensionPath' ) .
            '/share/db_schema.dba';
    }

    /**
     * Get schema defintion from $schemaFile
     *
     * @param $schemaFile
     * @return array|bool|mixed
     */
    public function getSchema( $schemaFile )
    {
        return eZDbSchema::read( $schemaFile, true );
    }

    /**
     * Insert or update schema
     *
     * @param $schema
     */
    public function insertSchema( $schema )
    {
        eZNetUtils::createTable( $schema );
    }

    /**
     * Clear DB
     *
     * @param bool|string $action
     */
    public function clearDB( $action = false )
    {
        $clearDBArray = array( 'ezx_ezpnet_branch',
                               'ezx_ezpnet_installation',
                               'ezx_ezpnet_mon_group',
                               'ezx_ezpnet_mon_item',
                               'ezx_ezpnet_mon_result',
                               'ezx_ezpnet_mon_value',
                               'ezx_ezpnet_soap_log',
                               'ezx_ezpnet_storage',
                               'ezx_ezpnet_patch',
                               'ezx_ezpnet_large_store',
                               'ezx_ezpnet_patch_item',
                               'ezx_ezpnet_module_branch',
                               'ezx_ezpnet_patch_sql_st',
                               'ezx_ezpnet_module_inst',
                               'ezx_ezpnet_module_patch',
                               'ezx_ezpnet_mod_patch_item',
                               //'ezx_oauth_client_consumer_user'  Will currently lead to server rejecting to setup new
                                                                // auth key since it already exists on server.
                               );

        $this->DB->begin();
        foreach( $clearDBArray as $dbName )
        {
            if ( $action === 'drop' )
                $this->DB->query( "DROP TABLE {$dbName}" );
            else
                $this->DB->query( "DELETE FROM {$dbName}" );
        }

        // We notice that it will be the first run after clearing of DB.
        $this->setEmptyDB();

        $this->DB->commit();
    }
}

?>
