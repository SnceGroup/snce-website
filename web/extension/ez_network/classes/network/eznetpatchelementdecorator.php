<?php
/**
 * File containing eZNetPatchElementDecorator class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/**
 * eZNetPatchElementDecorator class implementation
 * 
 */
class eZNetPatchElementDecorator
{
    /**
     * Holds eZNetPatchElement object
     * 
     * @var eZNetPatchElement
     */
    protected $patchElement;

    /**
     * Constructor
     * 
     * @param eZNetPatchElement $patchElement
     */
    public function __construct( eZNetPatchElement $patchElement )
    {
        $this->patchElement = $patchElement;
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
     * Returns patch installation text instructions
     * 
     * @return string
     */
    public function instructions()
    {
        return $this->patchElement->instructions();
    }
}

?>
