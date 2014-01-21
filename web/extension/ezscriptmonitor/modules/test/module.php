<?php
/**
 * File containing module definition
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 *
 */

$Module = array( 'name' => 'Test',
                 'variable_params' => true );

$ViewList = array();

$ViewList['timeout'] = array(
    'script' => 'timeout.php',
    );

$ViewList['antitimeout'] = array(
    'script' => 'antitimeout.php',
    );

?>
