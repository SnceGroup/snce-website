<?php
/**
 * File containing the the view for atom
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 */

/**
 * View providing atomfeed of the output
 */
class ezpRestAtomView extends ezcMvcView
{
    public function __construct( ezcMvcRequest $request, ezcMvcResult $result )
    {
        parent::__construct( $request, $result );

        $result->content = new ezcMvcResultContent();
        $result->content->type = "application/atom+xml";
        $result->content->charset = "UTF-8";
    }

    public function createZones( $layout )
    {
        return array(
            new ezcMvcFeedViewHandler( "content", new ezpRestAtomDecorator, "atom" )
        );
    }
}
