<?php
/**
 * File containing eZNetUtils class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetUtils eznetutils.php
  \brief The class eZNetUtils contains several helper functions

*/
class eZNetUtils
{
    /// Consts
    const MD5_SUM_KEY = 'MD5SumFileList';
    const SETTINGS_KEY = 'TS_SettingArray';
    const ROLE_KEY = 'RoleDefinitionList';
    const OBJECT_CREATION_COUNT = 'ObjectCreationCount';
    const MaxLogRotate = 100;

    /*!
     Constructor
    */
    function eZNetUtils()
    {
    }

    /*!
     \static
     Check if specified file has correct MD5 sum

     \param filename
     \param MD5Sum
    */
    static function checkMD5( $filename, $md5 )
    {
        return md5_file( $filename ) == $md5;
    }

    /*!
     \static
     Create human readable diff from specified content

     \param $content1
     \param $content2

     \return $diff
    */
    static function diffContent( $content1, $content2 )
    {
        // Store content to 2 temporary files.
        $cacheDir = eZSys::cacheDirectory();
        $rnd = substr( md5( mt_rand() ), 0, 5 );
        $filename1 = 'old_file_' . $rnd;
        $filename2 = 'new_file_' . $rnd;
        eZFile::create( $filename1, $cacheDir, $content1 );
        eZFile::create( $filename2, $cacheDir, $content2 );

        $filename1 = $cacheDir . '/' . $filename1;
        $filename2 = $cacheDir . '/' . $filename2;

        // Perform diff
        $result = eZNetUtils::diffFiles( $filename1, $filename2 );

        // Remove temporary files.
        @unlink( $filename1 );
        @unlink( $filename2 );

        return $result;
    }

    /*!
     \static
     Create diff of 2 files.

     \param filename 1
     \param filename 2

     \return diff
    */
    static function diffFiles( $filename1, $filename2 )
    {
        if ( !eZNetUtils::checkAccessToExecutables( 'diff' ) )
        {
            return false;
        }

        $output = array();
        exec( 'diff -u ' . $filename1 . ' ' . $filename2, $output );
        return implode( "\n", $output );
    }

    /*!
     \static
     Generate MD5 sum of eZ Publish source files, excluding the license header

     \param filename
     \param content, if provided, filename will be ignored.
     \param fuzzy, if provided, integer describing how to alter end license string.
            ( default false, optional: -3, -2, -1, 1, 2, 3, 4, etc. )

     \return md5sum
    */
    static function eZPmd5( $filename,
                            $content = false,
                            $fuzzy = false )
    {
        if ( !$content )
        {
            if ( file_exists( $filename ) )
            {
                $content = file_get_contents( $filename );
            }
            else
            {
                return false;
            }

            if ( !$content )
            {
                return false;
            }
        }

        // First look for new type of license header (PHPDoc)
        if ( strpos( $content, '@'.'license ' ) !== false )
        {
            $content = preg_replace( "/@"."license (?:.*)/", '', $content );
        }

        // Secondly try to match old license headers
        $licenseList = array( "// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##\n",
                              "// Contact licence@ez.no if any conditions of this licencing isn't clear to\n// you.\n",
                              "//   Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,\n//   MA 02110-1301, USA.\n//\n",
                              // Copyright strings are in two parts to avoid being changed by build scripts
                              "// Copyright (C) 1999-" . "2018 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2017 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2016 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2015 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2014 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2013 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2012 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2011 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2010 eZ Systems AS. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2009 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2008 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2007 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2006 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2005 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2004 eZ systems as. All rights reserved.\n",
                              "// Copyright (C) 1999-" . "2003 eZ systems as. All rights reserved.\n" );
        $endLicenseList = array( "//\n\n",
                                 "\n",
                                 "//\n" );

        // Check for license header, and ignore if exists.
        $pos = false;
        $searchContent = substr( $content, 0, 4096 );
        foreach( $endLicenseList as $endLicense )
        {
            if ( $fuzzy )
            {
                if ( $fuzzy > 0 )
                {
                    $endLicense .= str_repeat( "\n", $fuzzy );
                }
                else if ( $fuzzy < 0 )
                {
                    $endLicense = substr( $endLicense, 0, $fuzzy );
                }
            }
            foreach( $licenseList as $license )
            {
                $pos = strpos( $searchContent, $license . $endLicense );
                if ( $pos !== false )
                {
                    $pos += strlen( $license . $endLicense );
                    break;
                }
            }
            if ( $pos !== false )
            {
                break;
            }
        }
        if ( $pos !== false )
        {
            $content = substr( $content, $pos );
        }

        return md5( $content );
    }

    /*!
     Return list of eZ Publish ini filenames
    */
    static function iniFileNameList()
    {
        return array( 'admininterface.ini',
                      'contentstructuremenu.ini',
                      'error.ini',
                      'image.ini',
                      'override.ini',
                      'site.ini',
                      'transform.ini',
                      'binaryfile.ini',
                      'cronjob.ini',
                      'extendedattributefilter.ini',
                      'layout.ini',
                      'package.ini',
                      'soap.ini',
                      'units.ini',
                      'browse.ini',
                      'datatype.ini',
                      'ezxml.ini',
                      'ldap.ini',
                      'paymentgateways.ini',
                      'staticcache.ini',
                      'upload.ini',
                      'codetemplate.ini',
                      'datetime.ini',
                      'fetchalias.ini',
                      'logfile.ini',
                      'pdf.ini',
                      'template.ini',
                      'viewcache.ini',
                      'collaboration.ini',
                      'dbschema.ini',
                      'file.ini',
                      'menu.ini',
                      'setup.ini',
                      'textfile.ini',
                      'webdav.ini',
                      'collect.ini',
                      'debug.ini',
                      'i18n.ini',
                      'module.ini',
                      'shopaccount.ini',
                      'texttoimage.ini',
                      'wordtoimage.ini',
                      'content.ini',
                      'design.ini',
                      'icon.ini',
                      'notification.ini',
                      'toolbar.ini',
                      'workflow.ini' );
    }

    /*!
     \static
     Set file MD5 sum.

     \param filename
     \param md5sum, if false, it'll caclulate the MD5 sum using the eZPmd5 function.
     \param $nodeID ( optional )
     */
    static function setFileMD5( $filename, $md5 = false, $nodeID = false )
    {
        if ( !$md5 )
        {
            $md5 = eZNetUtils::eZPmd5( $filename );
        }
        if ( $nodeID === false )
        {
            $nodeID = eZNetUtils::nodeID();
        }

        eZNetStorage::set( $filename, $md5, 'eZNetUtils_FileMD5' . $nodeID );
    }

    /*!
     \static
     Get getMD5.

     \param filename
     \param $nodeID ( optional )

     \return md5 sum
    */
    static function fileMD5( $filename, $nodeID = false )
    {
        if ( $nodeID === false )
        {
            $nodeID = eZNetUtils::nodeID();
        }

        return eZNetStorage::get( $filename, 'eZNetUtils_FileMD5' . $nodeID );
    }

    /*!
     \static

     eZ Network storage directory

     \return Network storage directory
    */
    static function storageDirectory()
    {
        return eZSys::storageDirectory() . '/ez_network';
    }

    /*!
     \static

     Return unecrypted content of specified file.

     \param filename

     \return decrypted data
    */
    static function readFile( $filename )
    {
        $contents = file_get_contents( $filename );
        if ( !$contents )
        {
            return false;
        }

        return eZNetCrypt::decrypt( $contents );
    }

    /*!
     \static

     Write and encrypt data to specified file

     \param filename
     \param directory
     \param data
    */
    static function writeFile( $filename, $dir, $data )
    {
        eZFile::create( $filename, $dir, eZNetCrypt::encrypt( $data ) );
    }

    /*!
     Add settings entry to storage

     \param Filename
     \param Siteaccess
    */
    static function addSettingsFile( $filename, $siteAccess )
    {
        eZNetStorage::set( array( 'Filename' => $filename ),
                           array( 'Content' => file_get_contents( $filename ),
                                  'MD5' => md5_file( $filename ),
                                  'FileTimestamp' => filemtime( $filename ),
                                  'AddedTimestamp' => time() ),
                           array( 'SiteAccess' => $siteAccess,
                                  'NodeID' => eZNetUtils::nodeID() ) );

    }

    /*!
     Get list of all role ID, policy IDs, policylimitation IDs, etc. in recursive array
    */
    static function getRoleIDList()
    {
        $returnArray = array();
        $roleList = eZRole::fetchList();

        foreach( $roleList as $role )
        {
            $returnArray[(string)$role->attribute( 'id' )] = eZNetUtils::getPolicyIDList( $role );
        }

        return $returnArray;
    }

    static function getPolicyIDList( $role )
    {
        $returnArray = array();

        foreach( $role->policyList() as $policy )
        {
            $returnArray[(string)$policy->attribute( 'id' )] = eZNetUtils::getLimitationList( $policy );
        }

        return $returnArray;
    }

    static function getLimitationList( $policy )
    {
        $returnArray = array();

        foreach( $policy->limitationList( false ) as $limitation )
        {
            $returnArray[(string)$limitation->attribute( 'id' )] = $limitation->allValues();
        }

        return $returnArray;
    }

    /*!
     Recursive array diff
    */
    static function arrayDiffRecursive( $array1,
                                        $array2,
                                        $path = array() )
    {
        $returnArray = array();
        if ( is_array( $array1 ) )
        {
            foreach( $array1 as $key => $value )
            {
                if ( !array_key_exists( $key, $array2 ) )
                {
                    $returnArray['deleted'][$key] = $value;
                }
                else
                {
                    $subDiff = eZNetUtils::arrayDiffRecursive( $array1[$key], $array2[$key] );
                    if ( isset( $subDiff['deleted'] ) &&
                         count( $subDiff['deleted'] ) )
                    {
                        $returnArray['deleted'][$key] = $subDiff['deleted'];
                    }
                    if ( isset( $subDiff['added'] ) &&
                         count( $subDiff['added'] ) )
                    {
                        $returnArray['added'][$key] = $subDiff['added'];
                    }
                }
            }
        }
        else if ( $array1 !== $array2 )
        {
            $returnArray['deleted'] = $array1;
            $returnArray['added'] = $array2;
        }
        if ( is_array( $array2 ) )
        {
            foreach( $array2 as $key => $value )
            {
                if ( !array_key_exists( $key, $array1 ) )
                {
                    $returnArray['added'][$key] = $value;
                }
            }
        }
        return $returnArray;
    }

    /*!
     Generate human readable disk space data

     \param bytes - Input value
     \param $min - minimum value to convert
    */
    static function si( $bytes, $unit = 'bytes', $min = 0 )
    {
        if ( $bytes < $min )
        {
            return $bytes;
        }

        switch( $unit )
        {
            case 'bytes':
            {
                $units = array( 'bytes',
                                'KB',
                                'MB',
                                'GB',
                                'TB' );
            } break;

            default:
            {
                $units = array( '',
                                'K',
                                'M',
                                'G',
                                'T' );
            } break;
        }

        foreach ( $units as $unit )
        {
            if ( $bytes < 1024 )
            {
                break;
            }
            $bytes = round( $bytes/1024, 2 );
        }

        return $bytes . ' ' . $unit;
    }

    /*!
     \static
     Get unique host ID
    */
    static function hostID()
    {
        $db = eZDB::instance();

        $resultSet = $db->arrayQuery( 'SELECT value FROM ezsite_data WHERE name=\'ezpublish_site_id\'' );

        if ( count( $resultSet ) == 1 )
        {
            return $resultSet[0]['value'];
        }

        $siteID = md5( time() . '-' . mt_rand() );
        $db->query( 'INSERT INTO ezsite_data ( name, value ) values( \'ezpublish_site_id\', \'' . $siteID . '\' )' );

        return $siteID;
    }

    /*!
     \static
     Generate DB schema from eZPersistentObject

     \param eZPersistentObject class name
    */
    static function generateDBSchema( $className )
    {
        $definition = call_user_func( array( $className, 'definition' ) );

        $schema = array();
        $fields = array();
        $indexes = array();

        $tableName = $definition['name'];

        foreach( $definition['fields'] as $fieldName => $fieldDefinition )
        {
            $field = array();

            if ( $definition['increment_key'] == $fieldName )
            {
                $field['type'] = 'auto_increment';
                $field['default'] = false;

                $indexes['PRIMARY'] = array( 'type' => 'primary',
                                             'fields' => array( 0 => $fieldName ) );
            }
            else
            {
                $length = false;
                $default = $fieldDefinition['default'];
                $notNull = $fieldDefinition['required'] ? '1' : '0';
                switch( $fieldDefinition['datatype'] )
                {
                    case 'integer':
                    {
                        $type = 'int';
                        $length = 11;
                    } break;
                    case 'string':
                    {
                        $type = 'varchar';
                        $length = 255;
                    } break;

                    default:
                    {
                        $type = $fieldDefinition['datatype'];
                    } break;
                }
                $field['type'] = $type;
                if ( $length )
                    $field['length'] = $length;
                $field['not_null'] = $notNull;
                $field['default'] = $default;
            }

            $fields[$fieldName] = $field;
        }

        return array( $tableName => array( 'name' => $tableName,
                                           'fields' => $fields,
                                           'indexes' => $indexes ) );
    }

    /*!
     \static
     If current db instance is oracle this func can insert long text to db.

     \param oracle connection
     \param db table
     \param list of fields
     \param list of field values
     \param list of clob data: key is a name of field and value is its value

     \return true if successful
    */
    static function insertOracleCLOBData( $conn, $table, $filedList, $values, $clobData )
    {
        $query = "INSERT INTO $table ($filedList) VALUES($values)";

        $stmt = OCIParse( $conn, $query );

        $descriptorList = array();
        foreach ( $clobData as $clobField => $clobValue )
        {
            $descriptorList[$clobField] = OCINewDescriptor( $conn, OCI_D_LOB );

            OCIBindByName( $stmt, ":$clobField", $descriptorList[$clobField], -1, OCI_B_CLOB );
            $descriptorList[$clobField]->WriteTemporary( $clobValue );
        }

        $result = OCIExecute( $stmt, OCI_DEFAULT );

        if ( $result )
        {
            OCICommit( $conn );
        }

        foreach ( $descriptorList as $dClob )
        {
            $dClob->close();
            $dClob->free();
        }

        OCIFreeStatement( $stmt );

        return $result;
   }

    /*!
     \static
     If current db instance is oracle this func can update long text.

     \param oracle connection
     \param db table
     \param list of fields with values
     \param list of conditions
     \param list of clob data: key is a name of field and value is its value

     \return true if successful
    */
    static function updateOracleCLOBData( $conn, $table, $filedText, $condText, $clobData )
    {
        $query = "UPDATE $table\nSET $filedText$condText";

        $stmt = OCIParse( $conn, $query );

        $descriptorList = array();
        foreach ( $clobData as $clobField => $clobValue )
        {
            $descriptorList[$clobField] = OCINewDescriptor( $conn, OCI_D_LOB );

            OCIBindByName( $stmt, ":$clobField", $descriptorList[$clobField], -1, OCI_B_CLOB );
            $descriptorList[$clobField]->WriteTemporary( $clobValue );
        }

        $result = OCIExecute( $stmt, OCI_DEFAULT );

        if ( $result )
        {
            OCICommit( $conn );
        }

        foreach ( $descriptorList as $dClob )
        {
            $dClob->close();
            $dClob->free();
        }

        OCIFreeStatement( $stmt );

        return $result;
   }

    /*!
     \static
     Find files defined by rule

     \param start path
     \param pattern
     \return array
    */
    static function findFiles( $dir, $pattern )
    {
        if ( !is_dir ( $dir ) )
        {
            return array( $dir );
        }
        return eZNetUtils::findFilesPrvt( $dir, $pattern );
    }

    /*!
     \static
     \private
      Helper function for finding files
    */
    static function findFilesPrvt( $dir, $pattern )
    {
        $files = array();
        $dh = opendir( $dir );
        while ( ( $file = readdir( $dh ) ) !== false )
        {
            if ( $file == '.' ||
                 $file == '..' )
            {
                continue;
            }
            if ( is_dir( $dir . '/' . $file ) )
            {
                $files = array_merge( $files, glob( $dir . '/' . $pattern ) );
                $files = array_merge( $files, eZNetUtils::findFilesPrvt( $dir . '/' . $file, $pattern ) );
            }
        }

        return array_unique( $files );
    }

    /*!
     \static
     Network storage path
    */
    static function storagePath()
    {
        return eZDir::path( array( eZSys::storageDirectory(), 'network' ) );
    }

    /*!
     \static
     Check if it has access to create log file
    */
    static function canCreateLog( $logname = 'network.log' )
    {
        eZNetUtils::log( 'Check log write access.' );
        return is_writable( eZDir::path( array( 'var/log/network', $logname ) ) );
    }

    /*!
     \static
     Append message to eZ network log
    */
    static function log( $message, $logname = 'network.log' )
    {
        $maxLogrotateFiles = eZLog::maxLogrotateFiles();
        eZLog::setLogrotateFiles( eZNetUtils::MaxLogRotate );
        eZLog::write( $message, $logname, 'var/log/network' );
        eZLog::maxLogrotateFiles( $maxLogrotateFiles );
    }

    /*!
     \static

     \return Updated field name for BC
     \param field name
     \param direction to use, local is true it means we need to parse all request regarding on current table defenition
            otherwise remote table defenition.
     \note Oracle doesn't support field name like 'mode', now we changed it but for servers we don't.
    */
    static function updateFieldName( $fieldName, $local = true )
    {
        $updateFieldList = array( true => array( 'mode' => 'fmode', 'offset' => 'data_offset' ),
                                  false => array( 'fmode' => 'mode', 'data_offset' => 'offset'  ) );

        return isset( $updateFieldList[$local][$fieldName] ) ? $updateFieldList[$local][$fieldName] : $fieldName;
    }

    /*!
     \static

     Create custom DB table or update to schema defined in customTableDefinition().
     \sa customTableDefinition

     \param object implementing function customTableDefinition().
            Or table schema array
    */
    static function createTable( $input )
    {
        $tableSchema = false;
        if ( $input instanceOf eZPersistentObject )
        {
            // If no custom table schema exists, return.
            $tableSchema = $input->customTableDefinition();
        }
        else if ( is_array( $input ) )
        {
            $tableSchema = $input;
        }

        if ( !$tableSchema )
        {
            return;
        }

        $dbSchema = eZDbSchema::instance();
        $db = eZDB::instance();
        $isOracle = $db->databaseName() == 'oracle';
        $params = array( 'sort_columns' => false, 'sort_indexes' => false );

        // 1. Generate Schema diff for custom table in case of updates.
        $existingTableList = $db->eZTableList();
        $existingDefinition = array();
        $missingTableList = array();
        $dbSchema->transformSchema( $tableSchema, true );
        foreach( $tableSchema as $key => $definition )
        {
            // Do not loop over meta data
            // Name keys starting with _
            if ( strpos( $key, '_' ) === 0 )
                continue;

            $tableName = $definition['name'];
            if ( !in_array( $tableName, array_keys( $existingTableList ) ) )
            {
                $missingTableList[] = $tableName;
            }
            else
            {
                // In oracle all table names are in upper case
                $lookingTableName = $isOracle ? strtoupper( $tableName ) : $tableName;
                $tableFieldsParams = $params;
                // if oracle we should pass autoinc fields to get proper defenition from db
                if ( $isOracle )
                {
                    $tableFieldsParams['autoIncrementColumns'] = array();
                    foreach ( $definition['fields'] as $field => $fieldData )
                    {
                        if ( $fieldData['type'] == 'auto_increment' )
                        {
                            $tableFieldsParams['autoIncrementColumns'][$tableName . '.' . $field] = 'auto_increment';
                        }
                    }
                }

                $fields = $dbSchema->fetchTableFields( $lookingTableName, $tableFieldsParams );
                $existingDefinition[$tableName] = array( 'name' => $tableName,
                                                         'fields' => $fields,
                                                         'indexes' => $dbSchema->fetchTableIndexes( $lookingTableName, $params ) );
            }
        }

        $insertNewSchema = array();
        foreach( $missingTableList as $tableName )
        {
            $insertNewSchema[$tableName] = $tableSchema[$tableName];
            unset( $tableSchema[$tableName] );
            unset( $existingDefinition[$tableName] );
        }

        // 2. Insert new schema tables.
        // This will insert the schema, then the data and
        $db->begin();

        $params = array( 'schema' => true,
                         'data' => false );
        // Force innodb on MySQL
        if ( $db->databaseName() == 'mysql' )
        {
            $params['table_type'] = 'innodb';
        }

        unset( $dbSchema );
        $dbSchema = eZDbSchema::instance( array( 'schema' => $insertNewSchema,
                                                 'type' => $db->databaseName(),
                                                 'instance' => $db ) );
        $dbSchema->insertSchema( $params );

        // 3. Perform schema updates.
        $differences = eZDbSchemaChecker::diff( $existingDefinition, $tableSchema );
        $sqlDiff = $dbSchema->generateUpgradeFile( $differences );
        $splitter = $isOracle ? ";\n" : "\n"; // for oracle ';' is not needed at the end

        foreach( explode( $splitter, $sqlDiff ) as $sql )
        {
            if ( strlen( trim( $sql ) ) )
            {
                $db->query( trim( $sql ) );
            }
        }

        $db->commit();
    }

    /*!
     \static

     Check if current extension is master extension
    */
    static function isMaster()
    {
        return ( eZINI::instance( 'network.ini' )->variable( 'ClusterSettings', 'Mode' ) == 'master' );
    }

    /*!
     \static

     Get installation node ID
    */
    static function nodeID()
    {
        $nINI = eZINI::instance( 'network.ini' );
        $nodeID = $nINI->hasVariable( 'ClusterSettings', 'NodeID' ) ? trim( $nINI->variable( 'ClusterSettings', 'NodeID' ) ) : '';
        return $nodeID;
    }

    /*!
     \static
     Check PHP syntax of specified file

     \param filename

     \return true if syntax is OK.
    */
    static function checkPHPSyntax( $filename )
    {
        $phpExec = eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'PHPCLI' );
        $command = $phpExec . ' -l ' . $filename;
        $output = array();
        exec( $command, $output );
        return ( strpos( $output[0], 'Errors parsing' ) !== 0 );
    }

    /*!
     \static
     Check if DB table has specified index.

     \param table name
     \param index name

     \return true if index exists.
    */
    static function dbTableIndexExists( $tableName, $indexName )
    {
        $dbSchema = eZDbSchema::instance();
        $params = array();
        return in_array( $indexName, array_keys( $dbSchema->fetchTableIndexes( $tableName, $params ) ) );
    }

    /*!
     \static
     Read extension information. Returns extension information array
     specified in feature request 9371. ( http://issues.ez.no/9371 )

     \param extension name

     \return Extension information array. null if extension is not found,
             or does not contain extension information.
    */
    static function extensionInfo( $extension )
    {
        if ( class_exists( 'ezpExtension') )// since 4.4
        {
            $result = ezpExtension::getInstance( $extension )->getInfo();
            if ( is_array( $result ) )
                return array_change_key_case( $result, CASE_LOWER );
            else
                return null;
        }

        $infoFileName = eZDir::path( array( eZExtension::baseDirectory(), $extension, 'ezinfo.php' ) );
        if ( file_exists( $infoFileName ) )
        {
            // Try to determine does info class of current extension have unique class name?
            // This regExp is used for searching strings like "class some_class {"
            $classNameRegexp = '/(?<=class\s)[a-zA-Z0-9_\s\-]*(?={)/';
            $fileContent = file_get_contents( $infoFileName );
            $originalClassName = ( preg_match( $classNameRegexp, $fileContent, $match ) and isset( $match[0] ) ) ? trim( $match[0] ) : false;
            // If the original class already exists we should not include current file to prevent Fatal error: Cannot redeclare class ...
            if ( !$originalClassName or !class_exists( $originalClassName ) )
            {
                include_once( $infoFileName );
            }

            $className = $extension . 'Info';
            if ( is_callable( array( $className, 'info' ) ) )
            {
                $result = call_user_func_array( array( $className, 'info' ), array() );
                if ( is_array( $result ) )
                {
                    return array_change_key_case( $result, CASE_LOWER );
                }
            }
        }

        return null;
    }

    /*!
     \static
     Get a list of all databases used by this installation of eZ Publish.
     This function loops through every site access, and reads DB settings.

     \return array of database settings, db name as key. Empty array if none exists.
             The array also caintains name of the site access.
    */
    static function dbList()
    {
        $siteAccessArray = eZNetUtils::siteAccessList();
        $currentSiteAccess = $GLOBALS['eZCurrentAccess']['name'];
        $currentDB = eZDB::instance();

        $dbParameterList = array();
        foreach( $siteAccessArray as $siteAccess )
        {
            eZNetUtils::changeAccess( $siteAccess );
            $emptyDB = null;
            eZDB::setInstance( $emptyDB );

            $siteAccessDB = eZDB::instance( false, false, true );
            if ( $siteAccessDB->isConnected() )
            {
                $dbParameterList[$siteAccessDB->DB] = array( 'site_access' => $siteAccess,
                                                             'database' => $siteAccessDB->DB );
            }
        }

        eZNetUtils::changeAccess( $currentSiteAccess );
        eZDB::setInstance( $currentDB );

        return $dbParameterList;
    }

    /*!
     \static

     Change to specified siteaccess
     \param siteaccess name
    */
    static function changeAccess( $siteAccess )
    {
        $GLOBALS['eZCurrentAccess']['name'] = $siteAccess;
        if ( method_exists('eZSiteAccess','load') )// since 4.4
        {
            $access = $GLOBALS['eZCurrentAccess'];
            if ( isset( $access['uri_part'] ) )
            {
                unset( $access['uri_part'] );
            }
            return eZSiteAccess::load( $access );
        }

        changeAccess( array( 'name' => $siteAccess ) );

        if( isset( $GLOBALS['eZCurrentAccess']['type'] ) && $GLOBALS['eZCurrentAccess']['type'] == EZ_ACCESS_TYPE_URI )
        {
            eZSys::clearAccessPath();
            eZSys::addAccessPath( $siteAccess );
        }
        // Load the siteaccess extensions
        eZExtension::activateExtensions('access');
    }

    /*!
     \static

     Get list of available siteaccesses.

     \return list of siteaccesses.
    */
    static function siteAccessList()
    {
        $ini = eZINI::instance();
        $siteAccessArray = $ini->variable( 'SiteAccessSettings', 'AvailableSiteAccessList' );
        $siteAccessArray = array_unique( $siteAccessArray );
        foreach( $siteAccessArray as $key => $siteAccess )
        {
            if ( !file_exists( eZSiteAccess::findPathToSiteAccess( $siteAccess ) ) )
            {
                unset( $siteAccessArray[$key] );
            }
        }

        return $siteAccessArray;
    }

    /*!
     Get opearting system name.

     \return operating system. ( Windows, Linux ( default ) or Solaris ( also SunOS ) )
    */
    static function getOSName()
    {
        if ( strtolower( substr( PHP_OS, 0, 3 ) ) == 'win' )
        {
            return 'Windows';
        }
        else if ( strtolower( substr( PHP_OS, 0, 5 ) ) == 'sunos' ||
                  strtolower( substr( PHP_OS, 0, 7 ) ) == 'solaris' )
        {
            return 'Solaris';
        }
                else if ( strtolower( PHP_OS ) == 'freebsd' )
                {
                        return 'FreeBSD';
                }
        return 'Linux';
    }

    /*!
     \static

     Checks all needed executable commands for accessibility.
     \note that in the case of FreeBSD and Solaris, where gpatch is required,
           a special case is required because "gpatch -v" returns, eg, "patch 2.5.4"

     \param \a $executableArray list of executables or just string like 'gpatch'
     \return true if all executable commands are ok, false otherwise.
    */
    static function checkAccessToExecutables( $executableArray = false )
    {
        $OSName = eZNetUtils::getOSName();

        // Check access to execute executables
        $disabledFunctions = ini_get( 'disable_functions' );
        $disabledFunctions = str_replace( ' ', ',', $disabledFunctions );
        $disabledFunctions = explode( ',', $disabledFunctions );

        if ( in_array( 'exec', $disabledFunctions ) )
        {
            $message = "No access to PHP's 'exec' command which is disabled by the 'disable_functions' directive in php.ini. ";
            $message .= "Start php with '-d disable_functions=0' to solve this.";
            eZNetUtils::log( $message );
            return false;
        }

        // Initialize default values
        if ( $executableArray === false )
        {
            switch ( $OSName )
            {
                case 'Solaris':
                case 'FreeBSD':
                {
                    $executableArray = array( 'gpatch' );
                } break;

                default:
                {
                    $executableArray = array( 'patch' );
                } break;
            }
        }
        elseif ( !is_array( $executableArray ) )
        {
            $executableArray = array( $executableArray );
        }

        $countExecArray = count( $executableArray );
        $okCommands = $countExecArray;

        foreach ( $executableArray as $executable )
        {
            $command = $executable . ' -v';
            $output = array();
            exec( $command, $output );
            $firstLine = explode( ' ', $output[0] );
            $actualExecutable = strtolower( $firstLine[0] === 'GNU' ? $firstLine[1] : $firstLine[0] );

            // Special case because 'gpatch -v' returns, e.g. 'patch 2.5[.4]'
            $executableStr = $executable == 'gpatch' ? 'patch' : strtolower( $executable );
            if ( $executableStr != $actualExecutable )
            {
                $message = "OS: '$OSName' \n";
                $message .= "The command: '$executable' is missing.";
                --$okCommands;
                eZNetUtils::log( $message );
            }
        }

        return $countExecArray == $okCommands;
    }

    /*!
     \static
     Path list to ignore while generating patches.

     \return path list.
    */
    static function patchPathIgnoreList()
    {
        return array( 'kernel/sql',
                      'settings/siteaccess',
                      'bin/modfix.sh',
                      'doc/features',
                      'share/translation',
                      'doc/changelogs',
                      'packages/addons',
//                      'lib/version.php',
                      'extension',
                      'autoload/ezp_extension.php',
                      'support',
                      'var',
                      'kernel/setup/steps/ezstep_create_sites.php',
                      'bin/shell/extensionscommon.sh',
                      );
    }

    /*!
     \static
     Patch suffix ignore list

     \return patch suffix ignore list
    */
    static function patchIgnoreSuffixList()
    {
        return array( '.gif' );
    }

    /*!
     \static
     Patch ini filter file list

     \return ini Filter file list
    */
    static function patchIniFilterFileList()
    {
        return array( 'settings/site.ini',
                      'settings/content.ini',
                      'settings/setup.ini',
                      'settings/i18n.ini',
                      'settings/layout.ini',
                      'settings/template.ini',
                      'settings/texttoimage.ini',
                      'settings/units.ini',
                      'settings/webdav.ini',
                      'settings/image.ini' );
    }

    /**
     * Get callback class name
     *
     * @return string Callback class name
     */
    static function callbackClassName( $backtrace = false )
    {
        if ( $backtrace === false )
        {
            $backtrace = debug_backtrace();

            // The 2 first stack hits are uninteresting.
            array_shift( $backtrace );
            array_shift( $backtrace );
        }
        if ( empty( $backtrace ) )
        {
            return null;
        }
        $item = array_shift( $backtrace );
        if ( isset( $item['function'] ) &&
             $item['function'] === 'call_user_func_array' )
        {
            return $item['args'][0][0];
        }
        else if ( isset( $item['class'] ) )
        {
            return $item['class'];
        }
        else if ( isset( $item['object'] ) )
        {
            return get_class( $item['object'] );
        }

        return eZNetUtils::callbackClassName( $backtrace );
    }

    /*!
     \static
     Generate MD5 sum of file from specified file and revision

     \param dist path ( path to where ez files are exported )
     \param rev. number
     \param destination ( from or to )

     \return md5 sum
    */
    static function patchGenerateMd5( $distPath, $filename, $destination, $iniFilterFileList )
    {
        $filePath = eZDir::path( array( $distPath, $destination, $filename ) );

        // Check ini file filter list
        if ( in_array( $filename, $iniFilterFileList ) )
        {
            $cli = eZCLI::instance();
            $cli->output( 'Preprocessing ini file: ' . $filename );
            exec( 'cat ' . $filePath . " | sed 's,^#!\\(.*\\)$,\\1,' | grep -v '^..*##!' > " . $filePath . '.tmp && mv -f ' . $filePath . '.tmp ' . $filePath );
        }

        // Clean up newlines
        if ( in_array( eZFile::suffix( $filePath ), eZNetUtils::newlineSuffixList() ) )
        {
            eZFile::create( $filePath, false, eZNetUtils::nativeToUnixNewline( file_get_contents( $filePath ) ) );
        }

        return eZNetUtils::eZPmd5( $filePath );
    }

    /*!
     \static
     Get eZ Publish tar.gz URL

     \param version

     \return eZ Publish url
    */
    static function eZPublishURL( $version )
    {
        $list = array( '3.7.0' => 'http://auth.ez.no/content/download/100043/410622/file/ezpublish-3.7.0.tar.gz',
                       '3.7.1' => 'http://auth.ez.no/content/download/101152/438577/file/ezpublish-3.7.1.tar.gz',
                       '3.7.2' => 'http://auth.ez.no/content/download/101834/442122/file/ezpublish-3.7.2.tar.gz',
                       '3.7.3' => 'http://auth.ez.no/content/download/110474/491498/file/ezpublish-3.7.3.tar.gz',
                       '3.7.4' => 'http://auth.ez.no/content/download/117941/621534/file/ezpublish-3.7.4-gpl.tar.gz',
                       '3.7.5' => 'http://auth.ez.no/content/download/120044/635116/file/ezpublish-3.7.5-gpl.tar.gz',
                       '3.7.6' => 'http://auth.ez.no/content/download/125967/755219/version/1/file/ezpublish-3.7.6-gpl.tar.gz',
                       '3.7.7' => 'http://auth.ez.no/content/download/136434/870919/file/ezpublish-3.7.7-gpl.tar.gz',
                       '3.7.8' => 'http://auth.ez.no/content/download/137349/877501/file/ezpublish-3.7.8-gpl.tar.gz',
                       '3.7.9' => 'http://auth.ez.no/content/download/143597/925353/file/ezpublish-3.7.9-gpl.tar.gz',
                       '3.7.10' => 'http://auth.ez.no/content/download/171161/1160789/file/ezpublish-3.7.10-gpl.tar.gz',

                       '3.8.0' => 'http://auth.ez.no/content/download/125392/751199/version/1/file/ezpublish-3.8.0-gpl.tar.gz',
                       '3.8.1' => 'http://auth.ez.no/content/download/132651/842225/file/ezpublish-3.8.1-gpl.tar.gz',
                       '3.8.2' => 'http://auth.ez.no/content/download/136427/870883/file/ezpublish-3.8.2-gpl.tar.gz',
                       '3.8.3' => 'http://auth.ez.no/content/download/137355/877522/file/ezpublish-3.8.3-gpl.tar.gz',
                       '3.8.4' => 'http://auth.ez.no/content/download/143591/925318/file/ezpublish-3.8.4-gpl.tar.gz',
                       '3.8.5' => 'http://auth.ez.no/content/download/151295/988968/file/ezpublish-3.8.5-gpl.tar.gz',
                       '3.8.6' => 'http://auth.ez.no/content/download/152158/995731/file/ezpublish-3.8.6-gpl.tar.gz',
                       '3.8.7' => 'http://auth.ez.no/content/download/171154/1160752/file/ezpublish-3.8.7-gpl.tar.gz',
                       '3.8.8' => 'http://auth.ez.no/content/download/177257/1199282/file/ezpublish-3.8.8-gpl.tar.gz',
                       '3.8.9' => 'http://auth.ez.no/content/download/206242/1364183/file/ezpublish-3.8.9-gpl.tar.gz',

                       '3.9.0' => 'http://auth.ez.no/content/download/158740/1056058/file/ezpublish-3.9.0-gpl.tar.gz',
                       '3.9.1' => 'http://auth.ez.no/content/download/170277/1153631/file/ezpublish-3.9.1-gpl.tar.gz',
                       '3.9.2' => 'http://auth.ez.no/content/download/177162/1198595/file/ezpublish-3.9.2-gpl.tar.gz',
                       '3.9.3' => 'http://auth.ez.no/content/download/206288/1364340/file/ezpublish-3.9.3-gpl.tar.gz',
                       '3.9.4' => 'http://auth.ez.no/content/download/212698/1414496/file/ezpublish-3.9.4-gpl.tar.gz',

                       '4.0.0alpha1' => 'http://auth.ez.no/content/download/212932/1416319/version/1/file/ezpublish-4.0.0alpha1-gpl.tar.gz',
                       '4.0.0beta1' => 'http://auth.ez.no/content/download/217635/1459235/version/1/file/ezpublish-4.0.0beta1-gpl.tar.gz',
                       '4.0.0rc1' => 'http://auth.ez.no/content/download/218433/1465088/version/1/file/ezpublish-4.0.0rc1-gpl.tar.gz',
                       '4.0.0' => 'http://auth.ez.no/content/download/218812/1467959/file/ezpublish-4.0.0-gpl.tar.gz',
                       '4.0.1' => 'http://auth.ez.no/content/download/242355/1643191/version/2/file/ezpublish-4.0.1-gpl.tar.gz',
                       '4.0.2' => 'http://auth.ez.no/content/download/256736/1795052/version/2/file/ezpublish-4.0.2-gpl.tar.gz',
                       '4.0.3' => 'http://auth.ez.no/content/download/258337/1807151/version/3/file/ezpublish-4.0.3-gpl.tar.gz',
                       '4.0.4' => 'http://auth.ez.no/content/download/266130/1872354/version/1/file/ezpublish-4.0.4-gpl.tar.gz',
                       '4.0.5' => 'http://auth.ez.no/content/download/268458/2455628/version/2/file/ezpublish-4.0.5-gpl.tar.gz',
                       '4.0.6' => 'http://auth.ez.no/content/download/270159/2473884/version/2/file/ezpublish-4.0.6-gpl.tar.gz',
                       '4.0.7' => 'http://auth.ez.no/content/download/282774/2618753/version/1/file/ezpublish-4.0.7-gpl.tar.gz',

                       '4.1.0' => 'http://auth.ez.no/content/download/261295/1832505/version/5/file/ezpublish-4.1.0-gpl.tar.gz',
                       '4.1.1' => 'http://auth.ez.no/content/download/266143/1872452/version/2/file/ezpublish-4.1.1-gpl.tar.gz',
                       '4.1.2' => 'http://auth.ez.no/content/download/268440/2455510/version/2/file/ezpublish-4.1.2-gpl.tar.gz',
                       '4.1.3' => 'http://auth.ez.no/content/download/270151/2473827/version/3/file/ezpublish-4.1.3-gpl.tar.gz',
                       '4.1.4' => 'http://auth.ez.no/content/download/282767/2618711/version/1/file/ezpublish-4.1.4-gpl.tar.gz',

                       '4.2.0' => 'http://auth.ez.no/content/download/282755/2618624/version/3/file/ezpublish-4.2.0-light-gpl.tar.gz',

                       '4.3.0' => 'http://auth.ez.no/content/download/322719/3215295/version/2/file/ezpublish-4.3.0-light-gpl.tar.gz',

                       '4.4.0' => 'http://ez.no/content/download/618/7468/file/ezpublishenterprise-4.4.0.tar.gz',

                       '4.5.0beta2' => 'http://cleverti.ez.no/snapshot.45beta2/ezpublish-4.5.0-beta2-with_ezc-ee_build-186-full.tar.gz',
                       '4.5.0' => 'http://one.support.ec2.ez.no/var/support_site/storage/ezp45ezc_pul_build_20.tar.gz',

                       '4.6.0beta1' => 'http://cleverti.ez.no/snapshot.460beta1/ezpublish-4.6.0-beta1-with_ezc-ee_build-143-full.tar.gz',
                       //'4.6.0beta2' => 'http://cleverti.ez.no/snapshot.45beta2/ezpublish-4.5.0-beta2-with_ezc-ee_build-186-full.tar.gz',
                       '4.6.0' => 'http://one.support.ec2.ez.no/content/download/41155/319517/version/1/file/ezpublish-4.6.0-ee-bul_with_ezc.tar.gz',
                     );

        return ( isset( $list[$version] ) ? $list[$version] : null );
    }

    /*!
     \static
     Recursivly find all files.

     \param path
     \param subPath

     \return unique file list
    */
    static function recursiveFindFiles( $path, $subPath = '' )
    {
        $returnList = array();
        foreach( eZDir::findSubitems( $path . '/' . $subPath, 'dl', $subPath ) as $subPathElement )
        {
            $returnList = array_merge( $returnList, eZNetUtils::recursiveFindFiles( $path, $subPathElement ) );
        }
        foreach( eZDir::findSubitems( $path . '/' . $subPath, 'f', $subPath ) as $filename )
        {
            $returnList[] = $filename;
        }

        return array_unique( $returnList );
    }

    /*!
     Download file from specific URL, and store it in the specified path

     \param URL
     \param destination path

     \return true if successfull
    */
    static function downloadAndStore( $url, $path )
    {
        // Make sure path exists
        eZDir::mkdir( $path, false, true );

        $command = 'cd ' . $path . ' && wget ' . $url;
        exec( $command, $output );

        return true;
    }

    /*!
     Convert line changes from native to unix new lines.

     \param content

     \return content
    */
    static function nativeToUnixNewline( $text )
    {
        switch( eZNetUtils::getOSName() )
        {
            case 'Windows':
            {
                return str_replace( "\r\n", "\n", $text );
            } break;

            default:
            {
                return $text;
            } break;
        }
    }

    /*!
     List of file suffixes which needs to get their new-lines fixed while
     Creating patches.

     \return suffix list
    */
    static function newlineSuffixList()
    {
        return array( 'php',
                      'txt',
                      'ini',
                      'js',
                      'cpp',
                      'java',
                      'h',
                      'hpp',
                      'cc' );
    }

    /*!
     List of supported databases

     \return supported database list
    */
    static function supportedDatabaseList()
    {
        return array( 'mysql',
                      'oracle',
                      'postgresql',
                    );
    }

    /*!
     Create lock file.

     \param  name of file where pid is located
     \return false if the process should be stopped
             path to lock file otherwise.
     \note   Lock file should be unlinked after finnish of process.
    */
    static function createLockFile( $fileName )
    {
        $maxRunTime = 3600; // in sec

        // Create lock, to make sure the script is only run once at a time.
        $lockFile = eZDir::path( array( eZSys::cacheDirectory(),
                                        $fileName ) );
        $myPID = getmypid();

        // Check existing lock file
        if ( file_exists( $lockFile ) )
        {
            if ( $mTime = filemtime( $lockFile ) )
            {
                // Return, process is younger than $maxRunTime
                if ( time() - $mTime < $maxRunTime )
                {
                    return false;
                }
                else // Kill old process
                {
                    $existingPID = file_get_contents( $lockFile );
                    shell_exec( 'kill ' . $existingPID );
                    $count = 0;
                    while ( eZNetUtils::pidInfo( $existingPID ) )
                    {
                        if ( ++$count > 10 )
                        {
                            return false;
                        }
                        shell_exec( 'kill -9 ' . $existingPID );
                    }
                }
            }
        }

        // Create lock file
        eZFile::create( $lockFile, false, $myPID );

        return $lockFile;
    }

    /*!
     \static

     Get PID information.

     \return Process information array, return false id PID does not exists.
    */
    static function pidInfo( $pid )
    {
        $ps = shell_exec( 'ps -p ' . $pid );
        $psArray = explode( "\n", $ps );

        if( count( $psArray ) < 2 ||
            $psArray[1] == '' )
        {
            return false;
        }

        foreach( $psArray as $key => $val )
        {
            $psArray[$key] = explode( ' ',
                                      preg_replace( "/\s+/",
                                                    ' ',
                                                    trim( $psArray[$key] ) ) );
        }

        $pidInfo = array();
        foreach( $psArray[0] as $key => $val )
        {
            $pidInfo[$val] = $psArray[1][$key];
            unset( $psArray[1][$key] );
        }

        if( is_array( $psArray[1] ) )
        {
            $pidInfo[$val] .= ' ' . implode( ' ', $psArray[1] );
        }

        return $pidInfo;
    }

    /*!
     \static

     Get PHP memory limit in bytes.

     \return PHP memory limit in bytes..
    */
    static function memoryLimit()
    {
        $memoryLimit = ini_get( 'memory_limit' );

        // Value is in bytes
        if ( is_numeric( $memoryLimit ) )
        {
            return $memoryLimit;
        }

        $size = substr( $memoryLimit, 0, strlen( $memoryLimit )-1 );

        // Get notation
        $type = substr( $memoryLimit, strlen( $memoryLimit )-1, strlen( $memoryLimit ) );

        if ( $type == 'M' )
        {
            $memoryLimit = $memoryLimit * 1048576;
        }
        else if ( $type == 'K' )
        {
            $memoryLimit = $memoryLimit * 1024;
        }
        else if ( $type == 'G' )
        {
                $memoryLimit = $memoryLimit * 1024 * 1048576;
        }
        return $memoryLimit;
    }

}

?>
