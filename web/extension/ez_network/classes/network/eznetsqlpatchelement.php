<?php 
/**
 * File containing eZNetSQLPatchElement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetSQLPatchElement class implementation
 * 
 */
class eZNetSQLPatchElement extends eZNetPatchElement
{
    /**
     * Holds a SimpleXMLElement object
     * 
     * @var SimpleXMLElement
     */
    private $xml;
 
    /**
     * Constructor
     * 
     * @param string $cacheDir
     * @param SimpleXMLElement $patchElement
     */
    public function __construct( $cacheDir, SimpleXMLElement $patchElement )
    {
        parent::__construct( $cacheDir );
        $this->xml = $patchElement;
    }

    /**
     * Translates XML data to array
     * 
     * @return array
     */
    protected function parse()
    {
        $data = array();

        foreach ( $this->xml->SQL as $element )
        {
            $data[] = (string)$element;
        }

        return $data;
    }

    /**
     * Returns SQL patch element text instruction
     * 
     * @return string
     */
    protected function asText()
    {
        $text = '';

        if ( count( $this->data() ) == 0 )
            return $text;

        $text .= "SQL update script has to be executed for every database used by eZ Publish.\n\n";
        $text .= "Execute following SQL commands depending on RDBMS you are using:\n";

        $patchContent = "";
        foreach ( $this->data() as $sql )
        {
            $patchContent .= "{$sql};\n";
        }

        $filename = $this->storePatchContent( $patchContent );

        $text .= "\nMySQL\n";
        $text .= "-----\n\n";
        $text .= "$ mysql --host=<mysql_host> --port=<port> -u <mysql_user> -p <database> < /path/to/the/update/{$filename}\n";
        $text .= "\n\nPostgreSQL\n";
        $text .= "----------\n\n";
        $text .= "$ psql -h <psql_host> -p <port> -U <psql_user> -W\n\n";
        $text .= "The PostgreSQL client will ask you to specify the password that belongs to the <psql_user>. ";
        $text .= "If the password is correct, the client should display a \"<psql_user>=#\" prompt.\n\n";
        $text .= "postgres=# \c <database>\n";
        $text .= "<database>=# \i /path/to/the/update/{$filename}";
        $text .= "\n\nOracle\n";
        $text .= "------\n\n";
        $text .= "$ sqlplus <oracle_user>/<password>@<instance> < /path/to/the/update/{$filename}\n";

        return $text;
    }

    /**
     * Stores SQL file patch content
     * 
     * @param string $patchContent
     * @return string
     */
    private function storePatchContent( $patchContent )
    {
        $filename = uniqid( 'sql_' ) . '.sql';
        $path = $this->cacheDir . '/' . $filename;

        if ( !file_put_contents( $path, $patchContent ) )
            return false;

        return $filename;
    }
}

?>
