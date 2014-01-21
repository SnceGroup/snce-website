<?php
/**
 * Oauth/call server view
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

$module   = $Params['Module'];
$http     = eZHTTPTool::instance();
$currentUser         = eZUser::currentUser();
$currentUserRemoteID = $currentUser->attribute('contentobject')->attribute('remote_id');

if ( !$currentUser->isLoggedIn() )
{
    die('You need to login to be able to authenticate! If you see this, then someone has miss-configured user policies.');
}

// store redirect url in session
if ( isset( $_GET['RedirectURI'] ) && $_GET['RedirectURI'] && $_GET['RedirectURI'] !== '%2F' )
{
    $http->setSessionVariable( 'oauth_RedirectURI', urldecode( $_GET['RedirectURI'] ) );
}

// @link http://mojodna.net/2009/05/20/an-idiots-guide-to-oauth-10a.html

if ( isset( $_GET['oauth_callback_confirmed'] ) )// authorize
{
    $token         = $_GET['oauth_token'];
    $tokenSecret   = $_GET['oauth_token_secret'];
    $tokenConsumer = new OAuthConsumer( $token, $tokenSecret );
    $request = eznetOAuthClientConsumerUser::createSignedOauthRequest( 'oauth/authorize', $currentUserRemoteID, array(), $tokenConsumer );
}
else if ( isset( $_GET['oauth_verifier'] ) )// access_token
{
    $http->setSessionVariable( 'oauth_verifier', $_GET['oauth_verifier'] );
    $token         = $_GET['oauth_token'];
    $tokenSecret   = $_GET['oauth_token_secret'];
    $tokenConsumer = new OAuthConsumer( $token, $tokenSecret );
    $request = eznetOAuthClientConsumerUser::createSignedOauthRequest( 'oauth/server/access_token', $currentUserRemoteID, array( 'oauth_verifier' => $_GET['oauth_verifier'] ), $tokenConsumer );
}
else if ( isset( $_GET['type'] ) && $_GET['type'] === 'access' )
{
    // @todo Improve detection of this case so we don't need a custom 'type' get parameter
    if ( !eznetOAuthClientConsumerUser::fetchByRemoteId( $currentUserRemoteID ) )
    {
        $clientConsumer = new eznetOAuthClientConsumerUser(array(
            'user_remote_id' => $currentUserRemoteID,
            'access_token' => $_GET['oauth_token'],
            'access_token_secret' => $_GET['oauth_token_secret'],
            'access_token_ttl' => time() + 3000,
            'verifier' => $http->sessionVariable( 'oauth_verifier' ),
            'ts' => time(),
        ));
        try {
            $jsonString = $clientConsumer->oauthCall( 'oauth/server/access_token_ttl' );
        }
        catch (OAuthPhpException $e)
        {
            die( $e->getMessage() );
        }

        $data = eznetOAuthClientConsumerUser::jsonDecode( $jsonString );
        if ( $data !== null )
        {
            $clientConsumer->setAttribute('access_token_ttl', time() + $data['oauth_token_ttl'] -2 );
            $clientConsumer->store();
        }
        else
        {
            die( "Could not json decode response from server:\n<br />\n" . $jsonString );
        }
    }
    else
        die( 'Your user is already connected, aborting!' );

    $http->removeSessionVariable( 'oauth_verifier' );

    if ( $http->hasSessionVariable( 'oauth_RedirectURI' ) )
    {
        $redirectURI = $http->sessionVariable( 'oauth_RedirectURI' );
        $http->removeSessionVariable( 'oauth_RedirectURI' );
        return $module->redirectTo( $redirectURI );
    }
    else if ( $http->hasSessionVariable( 'LastAccessesURI' ) )
        return $module->redirectTo( $http->sessionVariable( 'LastAccessesURI' ) );
    else
        return $module->redirectTo( '/' );
}
else //request_token
{
    $domain    = $_SERVER['HTTP_HOST'];
    $base      = eZSys::indexDir();
    try
    {
        $request = eznetOAuthClientConsumerUser::createSignedOauthRequest( 'oauth/server/request_token', $currentUserRemoteID, array( 'oauth_callback' => urlencode( "http://$domain$base/network/oauth" ) ) );
    }
    catch ( eznetException $e )
    {
        $Result = array();
        $tpl    = eZTemplate::factory();
        $tpl->setVariable( 'message', $e->getMessage() );
        $Result['content'] = $tpl->fetch( 'design:network/invalid_agreement.tpl' );
        $Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Network' ),
                                        'url' => false ),
                                 array( 'text' => ezpI18n::tr( 'kernel/content', 'Oauth' ),
                                        'url' => false ) );
        $Result['content_info'] = array('persistent_variable' => array( 'extra_menu' => false,
                                                                        'left_menu'  => false ));
    }

}

if ( isset( $request ) )
{
    Header("Location: $request");
    echo "Server redirect: <a href='$request'>link</a>";
    eZDB::checkTransactionCounter();
    eZExecution::cleanExit();
}


?>
