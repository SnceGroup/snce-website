<?php 
/**
 * File containing eZNetPatchElement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetPatchElement class implementation
 * 
 */
class eZNetPatchElement
{
    /**
     * Holds a cache directory path
     * 
     * @var string
     */
    protected $cacheDir;

    /**
     * Constructor
     * 
     * @param string $cacheDir
     */
    public function __construct( $cacheDir )
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * Returns translated XML data to array
     * 
     * @return array
     */
    public function data()
    {
        return $this->parse();
    }

    /**
     * Returns text patch installation instructions
     * 
     * @return string
     */
    public function instructions()
    {
        return $this->asText();
    }
}

?>
