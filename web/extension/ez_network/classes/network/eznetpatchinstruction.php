<?php
/**
 * File containing eZNetPatchInstruction class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetPatchInstruction class implementation
 */
class eZNetPatchInstruction extends eZNetPatchElementDecorator
{
    /**
     * Holds instruction format
     * 
     * @var string
     */
    private $format;

    /**
     * Constructor
     * 
     * @param string $format
     * @param eZNetPatchElement $patchElement
     */
    public function __construct( $format, eZNetPatchElement $patchElement )
    {
        parent::__construct( $patchElement );
        
        $this->format = $format;
    }

    /**
     * Returns XML data as an array
     * 
     * @return array
     */
    public function data()
    {
        return $this->patchElement->data();
    }

    /**
     * Returns patch text installation instructions
     * 
     * @return string
     */
    public function instructions()
    {
        return $this->patchElement->instructions();
    }
}

?>
