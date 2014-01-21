<?php
/**
 * File containing eZNetLargeObject class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetLargeObject eznetlargeobject.php
  \brief The class eZNetLargeObject does

*/
class eZNetLargeObject extends eZPersistentObject
{
    /// Consts
    const MaxPacketSize = 64000;
    const LargeObjectStore = '*********eZNetLargeObject::LargeObjectStore*********';
    const LargeObjectStoreBC = '*********eZNetLargeObject_LargeObjectStore*********';

    // Need to override eZPersistentObject::store() and eZPersistentObject::storeObject() to handle large inserts

    /*!
     \reimp
    */
    function eZNetLargeObject( $rows = array() )
    {
        $this->eZPersistentObject( $rows );
        foreach( $rows as $field => $row )
        {
            // The magic key which identifies a eZNetLargeObject changed during PHP 5 port ( _ => :: )
            // - BC must be added so upgraded databases still identifies these objects
            if ( $row == eZNetLargeObject::LargeObjectStore || $row == eZNetLargeObject::LargeObjectStoreBC )
            {
                $this->setAttribute( $field, eZNetLargeObjectStorage::data( $this, $field ) );
            }
        }
        $this->setHasDirtyData( false );
    }

    /*!
     \reimp
    */
    function store( $fieldFilters = null )
    {
        eZNetLargeObject::storeObject( $this, $fieldFilters );
    }

    /*!
     \reimp
    */
    function remove( $conditions = null, $extraConditions = null )
    {
        $def = $this->definition();
        $keys = $def["keys"];
        if ( !is_array( $conditions ) )
        {
            $conditions = array();
            foreach ( $keys as $key )
            {
                $conditions[$key] = $this->attribute( $key );
            }
            eZNetLargeObjectStorage::removeData( $this, array_keys( $def['fields'] ) );
        }
        eZNetLargeObject::removeObject( $def, $conditions, $extraConditions );
    }

    /*!
     \reimp
    */
    static function fetchObjectList( $def,
                                     $field_filters = null,
                                     $conds = null,
                                     $sorts = null,
                                     $limit = null,
                                     $asObject = true,
                                     $grouping = false,
                                     $custom_fields = null,
                                     $custom_tables = null,
                                     $custom_conds = null )
    {
        $resultSet = eZPersistentObject::fetchObjectList( $def,
                                                          $field_filters,
                                                          $conds,
                                                          $sorts,
                                                          $limit,
                                                          $asObject,
                                                          $grouping,
                                                          $custom_fields,
                                                          $custom_tables,
                                                          $custom_conds );
        if ( !$asObject &&
             $resultSet )
        {
            foreach( $resultSet as $idx => $result )
            {
                foreach( $result as $field => $row )
                {
                    if ( $row == eZNetLargeObject::LargeObjectStore )
                    {
                        $resultSet[$idx][$field] = eZNetLargeObjectStorage::dataByRows( $def, $result, $field );
                    }
                }
            }
        }

        return $resultSet;
    }

    /*!
     \private
     Stores the data in \a $obj to database.
     \param fieldFilters If specified only certain fields will be stored.
     \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     the calls within a db transaction; thus within db->begin and db->commit.
    */
    static function storeObject( $obj, $fieldFilters = null )
    {
        $db = eZDB::instance();
        $useFieldFilters = ( isset( $fieldFilters ) && is_array( $fieldFilters ) && $fieldFilters );

        $def = $obj->definition();
        $fields = $def["fields"];
        $keys = $def["keys"];
        $table = $def["name"];
        $relations = isset( $def['relations'] ) ? $def['relations'] : null;
        $insert_object = false;
        $exclude_fields = array();
        foreach ( $keys as $key )
        {
            $value = $obj->attribute( $key );
            if ( is_null( $value ) )
            {
                $insert_object = true;
                $exclude_fields[] = $key;
            }
        }

        if ( $useFieldFilters )
            $insert_object = false;

        $use_fields = array_diff( array_keys( $fields ), $exclude_fields );
        // If we filter out some of the fields we need to intersect it with $use_fields
        if ( is_array( $fieldFilters ) )
            $use_fields = array_intersect( $use_fields, $fieldFilters );
        $doNotEscapeFields = array();
        $changedValueFields = array();
        $numericDataTypes = array( 'integer', 'float', 'double' );

        foreach ( $use_fields as $field_name  )
        {
            $field_def = $fields[$field_name];
            $value = $obj->attribute( $field_name );

            if ( is_null( $value ) )
            {
                if ( ! is_array( $field_def ) )
                {
                    $exclude_fields[] = $field_name;
                }
                else
                {
                    if ( array_key_exists( 'default', $field_def ) &&
                         (! is_null( $field_def['default'] ) ||
                          ( $field_name == 'data_int' &&
                            array_key_exists( 'required', $field_def ) &&
                            $field_def[ 'required' ] == false ) ) )
                    {
                        $obj->setAttribute( $field_name, $field_def[ 'default' ] );
                    }
                    else
                    {
                        //if ( in_array( $field_def['datatype'], $numericDataTypes )
                        $exclude_fields[] = $field_name;
                    }
                }
            }

            if ( strlen( $value ) == 0 &&
                 is_array( $field_def ) &&
                 in_array( $field_def['datatype'], $numericDataTypes  ) &&
                 array_key_exists( 'default', $field_def ) &&
                 !is_null( $field_def[ 'default' ] ) )
            {
                $obj->setAttribute( $field_name, $field_def[ 'default' ] );
            }

            if ( !is_null( $value )                             &&
                 $field_def['datatype'] === 'string'            &&
                 array_key_exists( 'max_length', $field_def )   &&
                 $field_def['max_length'] > 0                   &&
                 strlen( $value ) > $field_def['max_length'] )
            {
                $obj->setAttribute( $field_name, substr( $value, 0, $field_def['max_length'] ) );
                eZDebug::writeDebug( $value, "truncation of $field_name to max_length=". $field_def['max_length'] );
            }
            $bindDataTypes = array( 'text' );
            if ( $db->bindingType() != eZDBInterface::BINDING_NO &&
                 strlen( $value ) > 2000 &&
                 is_array( $field_def ) &&
                 in_array( $field_def['datatype'], $bindDataTypes  )
                 )
            {
                $boundValue = $db->bindVariable( $value, $field_def );
                $doNotEscapeFields[] = $field_name;
                $changedValueFields[$field_name] = $boundValue;
            }

        }
        $key_conds = array();
        foreach ( $keys as $key )
        {
            $key_conds[$key] = $obj->attribute( $key );
        }

        $important_keys = $keys;
        if ( is_array( $relations ) )
        {
            foreach( $relations as $relation => $relation_data )
            {
                if ( !in_array( $relation, $keys ) )
                    $important_keys[] = $relation;
            }
        }
        if ( empty( $important_keys ) && !$useFieldFilters )
        {
            $insert_object = true;
        }
        else if ( !$insert_object )
        {
            $rows = eZPersistentObject::fetchObjectList( $def, $keys, $key_conds,
                                                         array(), null, false,
                                                         null, null );
            if ( empty( $rows ) )
            {
                /* If we only want to update some fields in a record
                 * and that records does not exist, then we should do nothing, only return.
                 */
                if ( $useFieldFilters )
                    return;

                $insert_object = true;
            }
        }

        $isOracle = $db->databaseName() == 'oracle';
        // List of oracle clob fields
        $clobData = array(); // key is a clob field, value is its value

        $splitStoreFieldList = array();
        $splitInsert = false;

        if ( $insert_object )
        {
            // We include compat.php here because of the ezsprintf function call below

            // Note: When inserting we cannot hone the $fieldFilters parameters

            $use_fields = array_diff( array_keys( $fields ), $exclude_fields );
            $use_field_names = $use_fields;

            $use_values_hash = array();
            $escapeFields = array_diff( $use_fields, $doNotEscapeFields );

            foreach ( $escapeFields as $key )
            {
                $value = $obj->attribute( $key );
                $field_def = $fields[$key];

                $isCLOB = $field_def['datatype'] == 'longtext';
                // Check for oracle instance and for a clob field. If we found that field need to update db by special query
                if ( $isOracle && $isCLOB )
                {
                    $clobData[$key] = $value;
                    $value = ":$key";
                }

                if ( $field_def['datatype'] == 'float' )
                {
                    $value = ezsprintf( '%F', $value );
                }
                if ( is_null( $value ) &&
                     $key == 'data_int' )
                {
                    $use_values_hash[$key] = 'NULL';
                }
                else
                {
                    if ( $db->bindingType() == eZDBInterface::BINDING_NO &&
                         strlen( $value ) > eZNetLargeObject::MaxPacketSize && !$isOracle )
                    {
                        $splitInsert = true;
                        $splitStoreFieldList[] = $key;
                        $use_values_hash[$key] = "'" . $db->escapeString( eZNetLargeObject::LargeObjectStore ) . "'";
                    }
                    else
                    {
                        // CLOB field marked as ':' + name of it to following binding e.g. :value and it should not be quoted
                        $quote = !$isOracle ? "'" : ( $isCLOB ? '' : "'" );
                        $use_values_hash[$key] = "$quote" . $db->escapeString( $value ) . "$quote";
                    }
                }
            }
            foreach ( $doNotEscapeFields as $key )
            {
                $value = $changedValueFields[$key];
                $use_values_hash[$key] = $value;
            }
            $use_values = array();

            if ( $db->useShortNames() )
            {
                $use_short_field_names = $use_field_names;
                eZPersistentObject::replaceFieldsWithShortNames( $db, $fields, $use_short_field_names );
                $field_text = implode( ', ', $use_short_field_names );
                unset( $use_short_field_names );
            }
            else
            {
                $field_text = implode( ', ', $use_field_names );
            }

            foreach ( $use_field_names as $field )
            {
                $use_values[] = $use_values_hash[$field];
            }
            unset( $use_values_hash );
            $value_text = implode( ", ", $use_values );

            // If it's oracle and there is at least one clob field, need to use special method to insert data
            if ( $isOracle && count( $clobData ) )
            {
                eZNetUtils::insertOracleCLOBData( $db->DBConnection, $table, $field_text, $value_text, $clobData );
            }
            else
            {
                $sql = "INSERT INTO $table ($field_text) VALUES($value_text)";
                $db->query( $sql );
            }

            if ( isset( $def["increment_key"] ) && !($obj->attribute( $def["increment_key"]) > 0) )
            {
                $inc = $def["increment_key"];
                $id = $db->lastSerialID( $table, $inc );
                if ( $id !== false )
                    $obj->setAttribute( $inc, $id );
            }
        }
        else
        {
            $use_fields = array_diff( array_keys( $fields ), array_merge( $keys, $exclude_fields ) );
            if ( !empty( $use_fields ) )
            {
                // We include compat.php here because of the ezsprintf function call below

                // If we filter out some of the fields we need to intersect it with $use_fields
                if ( is_array( $fieldFilters ) )
                    $use_fields = array_intersect( $use_fields, $fieldFilters );
                $use_field_names = array();
                foreach ( $use_fields as $key )
                {
                    if ( $db->useShortNames() && is_array( $fields[$key] ) && array_key_exists( 'short_name', $fields[$key] ) && strlen( $fields[$key]['short_name'] ) > 0 )
                        $use_field_names[$key] = $fields[$key]['short_name'];
                    else
                        $use_field_names[$key] = $key;
                }

                $field_text = "";
                $field_text_len = 0;
                $i = 0;


                foreach ( $use_fields as $key )
                {
                    $value = $obj->attribute( $key );
                    $isCLOB = $fields[$key]['datatype'] == 'longtext';
                    // Check for oracle instance and for a clob field. If we found that field need to update db by special query
                    if ( $isOracle && $isCLOB )
                    {
                        $clobData[$key] = $value;
                        $value = ":$key";
                    }

                    if ( $fields[$key]['datatype'] == 'float' )
                    {
                        $value = ezsprintf( '%F', $value );
                    }

                    if (is_null($value) && $key == 'data_int' )
                    {
                        $field_text_entry = $use_field_names[$key] . '=NULL';
                    }
                    else if ( in_array( $use_field_names[$key], $doNotEscapeFields ) )
                    {
                        $field_text_entry = $use_field_names[$key] . "=" .  $changedValueFields[$key];
                    }
                    else
                    {
                        if ( $db->bindingType() == eZDBInterface::BINDING_NO &&
                             strlen( $value ) > eZNetLargeObject::MaxPacketSize && !$isOracle )
                        {
                            $splitInsert = true;
                            $splitStoreFieldList[] = $key;
                            $field_text_entry = $use_field_names[$key] . "='" . $db->escapeString( eZNetLargeObject::LargeObjectStore ) . "'";
                        }
                        else
                        {
                            // CLOB field marked as ':' + name of it to following binding e.g. :value and it should not be quoted
                            $quote = !$isOracle ? "'" : ( $isCLOB ? '' : "'" );
                            $field_text_entry = $use_field_names[$key] . "=$quote" . $db->escapeString( $value ) . "$quote";
                        }
                    }

                    $field_text_len += strlen( $field_text_entry );
                    $needNewline = false;
                    if ( $field_text_len > 60 )
                    {
                        $needNewline = true;
                        $field_text_len = 0;
                    }
                    if ( $i > 0 )
                        $field_text .= "," . ($needNewline ? "\n    " : ' ');
                    $field_text .= $field_text_entry;
                    ++$i;
                }
                $cond_text = eZPersistentObject::conditionText( $key_conds );

                // If it's oracle and there is at least one clob field, need to use special method to update data
                if ( $isOracle && count( $clobData ) )
                {
                    eZNetUtils::updateOracleCLOBData( $db->DBConnection, $table, $field_text, $cond_text, $clobData );
                }
                else
                {
                    $sql = "UPDATE $table\nSET $field_text$cond_text";
                    $db->query( $sql );
                }
            }
        }

        if ( $splitInsert )
        {
            foreach( $splitStoreFieldList as $field )
            {
                eZNetLargeObjectStorage::storeData( $obj, $field, $sql );
            }
        }
        $obj->setHasDirtyData( false );
    }
}

?>
