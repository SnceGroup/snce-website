<?php 
/**
 * File containing eZNetFilePatchElement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetFilePatchElement class implementation
 * 
 */
class eZNetFilePatchElement extends eZNetPatchElement
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
        
        $patchContent = (string)$this->xml->PatchContent;
        
        if ( (bool)$this->xml->PatchContent['encoded'] )
        {
            $patchContent = base64_decode( (string)$this->xml->PatchContent );
        }

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

        $patchFileStr = $this->storePatchContent( $data['patch_content'] );

        $text .= "If you are using eZ Publish in cluster mode, with multiple webservers where the eZ Publish ";
        $text .= "files are installed, then you need to repeat this step on each server.\n\n";

        $text .= "In order to successfully install patches you need to follow the sequence in which they are ";
        $text .= "listed in the Service Portal, starting with the first one at the bottom of the list.\n\n";

        $text .= "Requires GNU Patch utility. Unix/BSD/MacOS Patch utility is not compatible.\n\n";

        $text .= "Test the patch using the --dry-run parameter (from eZ Publish root directory * ):\n";
        $text .= "$ patch -p0 --dry-run < /path/to/the/update/$patchFileStr\n\n";

        $text .= "If the test does not apply cleanly and you have installed all the previous patches listed in ";
        $text .= "the Service Portal, you may have other patches installed, that should be reverted or else ";
        $text .= "you will need to adapt the official patches from eZ Systems to fit with your customized ";
        $text .= "installation. If you have not installed any other patches than the ones available in the ";
        $text .= "Service Portal, please contact eZ Support for further assistance.\n\n";

        $text .= "If the test runs without problems, apply the patch (from eZ Publish root directory * ):\n";
        $text .= "$ patch -p0 < /path/to/the/update/$patchFileStr";
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
        $filename = uniqid( 'patch_' ) . '.diff';
        $path = $this->cacheDir . '/' . $filename;

        if ( !file_put_contents( $path, $patchContent ) )
            return false;

        return $filename;
    }
}

?>
