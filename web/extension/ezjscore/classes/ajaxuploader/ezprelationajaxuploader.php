<?php
/**
 * File containing the ezpRelationAjaxUploader class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 * @version 5.2.0
 * @package ezjscore
 * @subpackage ajaxuploader
 */

/**
 * This class handles AJAX Upload for eZObjectRelation attributes
 *
 * @package ezjscore
 * @subpackage ajaxuploader
 */
class ezpRelationAjaxUploader extends ezpRelationListAjaxUploader
{
    /**
     * Checks if a file can be uploaded.
     *
     * @return boolean
     */
    public function canUpload()
    {
        $access = eZUser::instance()->hasAccessTo( 'content', 'create' );
        if ( $access['accessWord'] === 'no' )
        {
            return false;
        }
        return true;
    }

}

?>
