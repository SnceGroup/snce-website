<?php
/**
 * service_portal/iframe View
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

$tpl         = eZTemplate::factory();
$currentUser = eZUser::currentUser();
$hasAccessToken      = false;
$currentUserRemoteID = $currentUser->attribute('contentobject')->attribute('remote_id');
$clientConsumer      = eznetOAuthClientConsumerUser::fetchByRemoteId( $currentUserRemoteID );

if ( $clientConsumer instanceof eznetOAuthClientConsumerUser )
{
    try
    {
        $clientConsumer->oauthVerifyToken();
        $clientConsumer->oauthRedirect( 'oauth/server/login_redirect', array( 'redirect' => urlencode( eznetOAuthClientConsumerUser::getServerUrl() ) ) );
    }
    catch ( OAuthPhpException $e )
    {
        print( "Got an oauth exception:\n<br />\n" );
        var_dump( $e->getMessage() );
    }
    catch ( OAuthJsonException $e )
    {
        print( "Could not json decode response from server:\n<br />\n" );
        var_dump( $e->getMessage() );
    }
    catch ( eznetException $e )
    {
        $tpl->setVariable( 'message', $e->getMessage() );
        echo $tpl->fetch( 'design:network/invalid_agreement.tpl' );
    }
}
else
{
    $tpl->setVariable( 'user', $currentUser );
    echo $tpl->fetch( 'design:network/login.tpl' );
}

eZDB::checkTransactionCounter();
eZExecution::cleanExit();

?>
