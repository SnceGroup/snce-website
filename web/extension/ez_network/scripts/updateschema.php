<?php

// Check schema file
$schemaFilePath = eZExtension::baseDirectory() . '/'
    . eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'ExtensionPath' )
    . '/share/db_schema.dba';
print( "Schema file path: $schemaFilePath\n" );

$dbContents = eZDbSchema::read( $schemaFilePath, true );
if ( $dbContents === false || !isset( $dbContents['schema'] ) )
{
    print( "Could not read schema information from: $schemaFilePath\n" );
    exit( 1 );
}

// Update the schema
eZNetUtils::createTable( $dbContents['schema'] );

print( "Done\n" );

?>
