<?php
/**
 * File containing the ezpAjaxUploaderHandlerInterface interface.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 5.2.0
 * @package ezjscore
 * @subpackage ajaxuploader
 */

/**
 * Interface of the AJAX uploader handler
 *
 * @package ezjscore
 * @subpackage ajaxuploader
 */
interface ezpAjaxUploaderHandlerInterface
{
    /**
     * Checks if a file can be uploaded
     *
     * @return boolean
     */
    public function canUpload();

    /**
     * Returns infos on the uploaded file
     *
     * @return array( 'mime' => array(), 'file' => eZHTTPFile )
     */
    public function getFileInfo();

    /**
     * Returns the content class to use when creating the content object from
     * the file
     *
     * @param array $mimeData
     * @return eZContentClass
     */
    public function getContentClass( array $mimeData );

    /**
     * Returns the node id of the default location of the future object
     *
     * @param eZContentClass $class
     * @return int
     */
    public function getDefaultParentNodeId( eZContentClass $class );

    /**
     * Creates the eZContentObject from the uploaded file
     *
     * @param eZHTTPFile $file
     * @param eZContentObjectTreeNode $location
     * @param string $name
     * @return eZContentObject
     */
    public function createObject( $file, $location, $name = '' );

    /**
     * Serialize the eZContentObject to be used to build the result in
     * JavaScript
     *
     * @param eZContentObject $object
     * @return array
     */
    public function serializeObject( eZContentObject $object );
}

?>
