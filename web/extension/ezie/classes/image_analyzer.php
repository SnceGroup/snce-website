<?php
/**
 * File containing the eZIEImageAnalyzer class
 * This class overrides ezcImageAnalyzer in order to support the ezpublish cluster constraints
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 5.2.0
 * @package ezie
 */
class eZIEImageAnalyzer extends ezcImageAnalyzer
{
    protected $deleteLocal = true;

    /**
     * Constructor overload
     * Creates a local copy of the image so that it can be analyzed
     *
     * @param string $file
     */
    public function __construct( $file, $deleteLocal = true )
    {
        $clusterHandler = eZClusterFileHandler::instance( $file );
        $clusterHandler->fetch();

        parent::__construct( $file );

        $this->deleteLocal = $deleteLocal;
        if( $this->deleteLocal )
        {
            $clusterHandler->deleteLocal();
        }
    }

    /**
     * Overload of ezcImageAnalyzer::analyzeImage()
     * Creates a temporary local copy of the image file so that it can be analyzed
     *
     * @return void
     */
    public function analyzeImage()
    {
        $clusterHandler = eZClusterFileHandler::instance( $this->filePath );
        $clusterHandler->fetch();

        parent::analyzeImage();

        if( $this->deleteLocal )
        {
            $clusterHandler->deleteLocal();
        }
    }
}

?>
