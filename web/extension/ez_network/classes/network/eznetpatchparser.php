<?php
/**
 * File containing eZNetPatchParser class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetPatchParser class implementation
 * 
 */
class eZNetPatchParser
{
    /**
     * Holds patch content as a string
     * 
     * @var string
     */
    private $patch;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds a SimpleXMLElement object
     * 
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * Constructor
     * 
     * @param string $patch
     */
    public function __construct( $patch )
    {
        $this->patch = $patch;
        $this->xml = simplexml_load_string( $patch );
        
        $this->cache_dir = eZDir::path( array( eZSys::cacheDirectory(), 'serviceportal', uniqid( 'package_' ) ) );

        eZDir::mkdir( $this->cache_dir, false, true );
    }

    /**
     * Returns an array with eZNetPatchInstruction objects
     * 
     * @return array
     */
    public function getPatchInstructions()
    {
        $instructions = array();
        
        foreach( $this->xml->xpath('//PatchElement') as $patchElement )
        {
            switch ( $patchElement['type'] )
            {
                case 'sql':
                    $instructions[] =  new eZNetPatchInstruction( 'text', new eZNetSQLPatchElement(  $this->cache_dir, $patchElement ) );
                    break;
                case 'patch':
                    $instructions[] =  new eZNetPatchInstruction( 'text', new eZNetFilePatchElement(  $this->cache_dir, $patchElement ) );
                    break;
                case 'binaryfile':
                    $instructions[] =  new eZNetPatchInstruction( 'text', new eZNetBinaryPatchElement(  $this->cache_dir, $patchElement ) );
                    break;
                case 'script':
                    $instructions[] =  new eZNetPatchInstruction( 'text', new eZNetScriptPatchElement(  $this->cache_dir, $patchElement ) );
                    break;
            }
        }
        
        return $instructions;
    }

    /**
     * Creates install.txt file with patch installation instructions
     * 
     * @return bool
     */
    public function createTextInstructions()
    {
        $patchElements = $this->getPatchInstructions();

        $text = "Update Installation Guide\n";
        $text .= "========================\n";

        $text .= "IMPORTANT NOTE:\n";
        $text .= "These instructions are aimed at technical personnel like system administrators and developers, and assumes the reader has relevant experience with patching running systems. If you do not have access to technical staff please contact your account manager in eZ Systems or eZ Support, and we may help you find a solution to this.\n\n";

        $text .= "Update name:\n{$this->patch_name}\n";
        $text .= "\nUpdate description:\n{$this->patch_description}\n";
        $text .= "\nRequired Update:\n";
        $text .= "Update ID: {$this->required_patch_id}\n";
        $text .= "Update name: {$this->required_patch_name}\n\n";

        $text .= "Reference to the issue tracker:\n";

        if ( trim( $this->issue_number ) != '' )
        {
            $issueNumderList = explode( ' ', $this->issue_number );

            foreach ( $issueNumderList as $issueNumber )
            {
                $issueNumber = str_replace( '#', '', $issueNumber );
                $text .= "http://issues.ez.no/{$issueNumber}\n";
            }
        }
        else
        {
            $text .= "None.\n";
        }

        $text .= "\n";

        $step = 1;
        foreach ( $patchElements as $patchElement )
        {
            if ( !$instructions = $patchElement->instructions() )
                continue;

            $text .= "Step {$step}\n";
            $text .= "******\n\n";
            $text .= $instructions;
            $text .= "\n";
            
            $step++;
        }

        $text .= "\nOnce you have successfully followed all steps your update should now be properly installed.\n\n";

        $path = $this->cache_dir . '/' . 'install.txt';
        
        if ( !file_put_contents( $path, $text ) )
            return false;

        return true;
    }

    /**
     * Creates a zip archive with patch content
     * 
     * @return string
     */
    public function createZipArchive()
    {
        $tempExportPath = eZDir::path( array( eZSys::cacheDirectory(), 'serviceportal' ) );

        $zipArchivePath = $tempExportPath . '/'. uniqid( 'archive_' ) . '.tmp';
        $zipArchive = ezcArchive::open( $zipArchivePath, ezcArchive::ZIP );
        $zipArchive->truncate();

        $prefix = $this->cache_dir . '/';
        $fileList = array();
        eZDir::recursiveList( $this->cache_dir, $this->cache_dir, $fileList );

        foreach ( $fileList as $fileInfo )
        {
            $path = $fileInfo['type'] === 'dir' ?
                $fileInfo['path'] . '/' . $fileInfo['name'] . '/' :
                $fileInfo['path'] . '/' . $fileInfo['name'];
            $zipArchive->append( array( $path ), $prefix );
        }

        $zipArchive->close();

        return $zipArchivePath;
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'patch_name':
            case 'patch_description':
            case 'required_patch_id':
            case 'required_patch_name':
            case 'cache_dir':
            case 'issue_number':
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns the value of the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'patch_name':
            case 'patch_description':
            case 'required_patch_id':
            case 'required_patch_name':
            case 'cache_dir':
            case 'issue_number':
                return $this->properties[$name];
        }
        throw new ezcBasePropertyNotFoundException( $name );
    }
}

?>
