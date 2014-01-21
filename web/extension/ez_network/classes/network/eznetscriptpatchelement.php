<?php 
/**
 * File containing eZNetScriptPatchElement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetScriptPatchElement class implementation
 * 
 */
class eZNetScriptPatchElement extends eZNetPatchElement
{
    /**
     * Holds SimpleXMLElement object
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
     * Returns XML data as an array
     * 
     * @return array
     */
    protected function parse()
    {
        $data = array();
                
        $patchContent = base64_decode( (string)$this->xml->Script );

        $data['patch_content'] = $patchContent;

        return $data;
    }

    /**
     * Returns a patch installation instruction text
     * 
     * @return string
     */
    protected function asText()
    {
        $data = $this->data();
        $text = '';

        if ( $data['patch_content'] == '' )
            return $text;

        $patchContent = $this->stripComments( $data['patch_content'] );

        $text .= "Execute the following update script (from the eZ Publish root directory * ):\n";
        $text .= "$ php -d memory_limit=512M -d safe_mode=0 -d disable_functions=0 ./bin/php/ezexec.php /path/to/the/update/"  . $this->storePatchContent( $patchContent );
        $text .= "\n\n";

        $text .= "* Please note that if you are using eZ Publish 5.0 or newer, the 'eZ Publish root directory' ";
        $text .= "is the top level of eZ Publish, not the legacy directory in 'ezpublish_legacy'.\n";

        return $text;
    }

    /**
     * Stores a patch file content
     * 
     * @return string
     */
    private function storePatchContent( $patchContent )
    {
        $filename = uniqid( 'script_' ) . '.php';
        $path = $this->cacheDir . '/' . $filename;

        if ( !file_put_contents( $path, $patchContent ) )
            return false;

        return $filename;
    }

    /**
     * Removes PHP comments for opening and closing tag from patch content
     * 
     * @return string
     */
     private function stripComments( $patchContent )
     {
         $lines = explode( "\n", $patchContent );

         $firstLine =& $lines[0];
         $lastLine =& $lines[count( $lines ) - 1];

         if ( $firstLine[0] === '/' )
             $firstLine = substr( $firstLine, 2, strlen( $firstLine ) );

         if ( $lastLine[0] === '/' )
             $lastLine = substr( $lastLine, 2, strlen( $lastLine ) );

         $patchContent = implode( "\n", $lines );

         return $patchContent;
     }
}

?>
