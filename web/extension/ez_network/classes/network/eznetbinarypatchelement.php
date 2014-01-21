<?php
/**
 * File containing eZNetBinaryPatchElement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetBinaryPatchElement class implementation
 *
 */
class eZNetBinaryPatchElement extends eZNetPatchElement
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
     * @return array;
     */
    protected function parse()
    {
        $data = array();

        $data['md5_sum_old'] = array();
        foreach ( $this->xml->MD5SumOldList->MD5Sum as $element )
        {
           $data['md5_sum_old'][] = array( 'file' => (string)$element['file'], 'md5sum' => (string)$element['md5sum'] );
        }

        $data['md5_sum_new'] = array();
        foreach ( $this->xml->MD5SumNewList->MD5Sum as $element )
        {
           $data['md5_sum_new'][] = array( 'file' => (string)$element['file'], 'md5sum' => (string)$element['md5sum'] );
        }
        
        $data['patch_content'] = array();
        foreach ( $this->xml->PatchContent->File as $file )
        {
             $data['patch_content'][] = array( 'filename' => (string)$file['filename'], 'content' => (string)$file );
        }

        if ( (bool)$this->xml->PatchContent['encoded'] )
        {
            $data['patch_content'] = array();
            foreach ( $this->xml->PatchContent->File as $file )
            {
                 $data['patch_content'][] = array( 'filename' => (string)$file['filename'], 'content' => base64_decode( (string)$file ) );
            }
        }
 
        return $data;
    }

    /**
     * Returns binary file patch text instructions
     * 
     * @return string
     */
    protected function asText()
    {
        $data = $this->data();
        $text = '';

        if ( empty( $data['patch_content'] ) )
            return $text;

        $text .= "If you are using eZ Publish in a cluster mode, with multiple webservers where the eZ Publish ";
        $text .= "files are installed, then you need to repeat this step on each server.\n\n";

        $text .= "Replace original files with following:\n";
        foreach ( $data['patch_content'] as $file )
        {
            $this->storePatchContent( $file['filename'], $file['content'] );
            $text .= "$ cp /path/to/the/update/{$file['filename']} {$file['filename']}\n";
        }

        return $text;
    }

    /**
     * Stores binary patch file content
     * 
     * @return bool
     */
    private function storePatchContent( $filename, $patchContent )
    {
        $pathParts = pathinfo( $filename );
        $dirPath = $this->cacheDir . '/' . $pathParts['dirname'];

        eZDir::mkdir( $dirPath, false, true );

        $filePath = $this->cacheDir . '/' . $filename;
        if ( !file_put_contents( $filePath, $patchContent ) )
            return false;

        return true;
    }
}

?>
