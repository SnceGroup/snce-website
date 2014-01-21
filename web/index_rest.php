<?php
/**
 * File containing the wrapper around the legacy index_rest.php file
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/Resources/Software/Licenses/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1 eZ Business Use License Agreement eZ BUL Version 2.1
 */
$legacyRoot = '/var/www/html/ezpublish/../ezpublish_legacy';
chdir( $legacyRoot );
require $legacyRoot . '/index_rest.php';

