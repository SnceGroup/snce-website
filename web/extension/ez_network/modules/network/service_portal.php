<?php
/**
 * service_portal/ View
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

$db                  = eZDB::instance();
$tpl                 = eZTemplate::factory();
$currentUser         = eZUser::currentUser();
$currentUserRemoteID = $currentUser->attribute('contentobject')->attribute('remote_id');

if ( !in_array( 'ezx_oauth_client_consumer_user', $db->relationList() ) )
{
    return $Module->redirectTo( "network/install" );
}

$clientConsumer = eznetOAuthClientConsumerUser::fetchByRemoteId( $currentUserRemoteID );
if ( $clientConsumer instanceof eznetOAuthClientConsumerUser )
{
    $Result = array();
    $Result['content'] = $tpl->fetch( 'design:network/service_portal.tpl' );// iframe
    $Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Network' ),
                                    'url' => false ),
                             array( 'text' => ezpI18n::tr( 'kernel/content', 'Service Portal' ),
                                    'url' => false ) );
    $Result['content_info'] = array('persistent_variable' => array( 'extra_menu' => false,
                                                                    'left_menu'  => false ));
    return $Result;
}
elseif ( count( eZDB::instance()->arrayQuery( 'SELECT value FROM ezsite_data WHERE name=\'ezpublish_site_id\'' ) ) != 1 )
{
    return $Module->redirectTo( "network/install" );
}

$tpl->setVariable( 'user', $currentUser );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:network/login.tpl' );// login
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Network' ),
                                    'url' => false ),
                             array( 'text' => ezpI18n::tr( 'kernel/content', 'Login' ),
                                    'url' => false ) );

$Result['content_info'] = array('persistent_variable' => array( 'extra_menu' => false,
                                                                'left_menu'  => false ));

?>
