<?php
/**
 * Common Oauth client consumer persistent object code
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 *
 * @see sql/mysql/oauth_client.sql
 *
 */
class eznetOAuthClientConsumerUser extends eZPersistentObject
{
    /**
     * Definition of the persistent object.
     *
     * @return array
    */
    public static function definition()
    {
        static $def = array( 'fields' => array(
                                         'user_remote_id' => array(
                                                        'name' => 'USER_REMOTE_ID',
                                                        'datatype' => 'string',
                                                        'default' => '',
                                                        'required' => true ),
                                         'access_token' => array(
                                                        'name' => 'TOKEN',
                                                        'datatype' => 'string',
                                                        'default' => '',
                                                        'required' => true ),
                                         'access_token_secret' => array(
                                                        'name' => 'TOKEN_SECRET',
                                                        'datatype' => 'string',
                                                        'default' => '',
                                                        'required' => true ),
                                         'access_token_ttl' => array(
                                                        'name' => 'TOKEN_TTL',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         'verifier' => array(
                                                        'name' => 'VERIFIER',
                                                        'datatype' => 'string',
                                                        'default' => '',
                                                        'required' => true ),
                                         'ts' => array(
                                                        'name' => 'TIMESTAMP',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => false ),
                                                ),
                      'keys' => array( 'user_remote_id' ),
                      'function_attributes' => array(  ),
                      'class_name' => 'eznetOAuthClientConsumerUser',
                      'name' => 'ezx_oauth_client_consumer_user' );
        return $def;
    }

    /**
     * Fetch server consumer by id
     *
     * @param string $accessToken
     * @param bool $asObject
     * @return eznetOAuthClientConsumerUser|null
     */
    public static function fetchByAccessToken( $accessToken, $asObject = true )
    {
        $list = eZPersistentObject::fetchObjectList(
                                    self::definition(),
                                    null,
                                    array( 'access_token' => $accessToken ),
                                    null,
                                    null,
                                    $asObject
                );
        if ( isset( $list[0] ) )
            return $list[0];
        return null;
    }

    /**
     * Fetch server consumer users by remote id
     *
     * @param string $userRemoteID
     * @param bool $asObject
     * @return eznetOAuthClientConsumerUser|null
     */
    public static function fetchByRemoteId( $userRemoteID, $asObject = true )
    {
        $list = eZPersistentObject::fetchObjectList(
                                    self::definition(),
                                    null,
                                    array( 'user_remote_id' => $userRemoteID ),
                                    null,
                                    null,
                                    $asObject
                );
        if ( isset( $list[0] ) )
            return $list[0];
        return null;
    }

    /**
     * Fetch server consumer users by consumer key
     *
     * @return eZUser|null
     */
    public function getUser()
    {
        if ( !$this->attribute('user_remote_id') )
            return null;

        $contentObject = eZContentObject::fetchByRemoteID( $this->attribute('user_remote_id') );
        if ( !$contentObject instanceof eZContentObject )
            return null;

        $user = eZUser::fetch( $contentObject->attribute('id') );
        if ( !$user instanceof eZUser )
            return null;

        return $user;
    }

    /**
     * Redirect to an Oauth service on Service portal
     * Note: Make sure you have called oauthVerifyToken() first so token is renewed if it has expired
     *
     * @param string $relativeEndpoint Relative url on service portal, like 'oauth/server/login_redirect'
     * @param array $params Optional parameters to send to server, make sure url's are url encode
     */
    public function oauthRedirect( $relativeEndpoint, array $params = array() )
    {
        $tokenConsumer = new OAuthConsumer( $this->attribute('access_token'), $this->attribute('access_token_secret') );
        $request = self::createSignedOauthRequest( $relativeEndpoint, $this->attribute('user_remote_id'), $params, $tokenConsumer );

        Header( "Location: $request" );
        //echo "Server redirect: <a href='$request'>link</a>";

        eZDB::checkTransactionCounter();
        eZExecution::cleanExit();
    }

    /**
     * Call to an Oauth service on Service portal
     * Note: Make sure you have called oauthVerifyToken() first so token is renewed if it has expired
     * Note2: Only use against services that are embed-able (don't use redirect and is state less aka discards session )
     *
     * @param string $relativeEndpoint Relative url on service portal, like 'oauth/server/login_redirect'
     * @param array $params Optional parameters to send to server, make sure url's are url encode
     * @exception OAuthPhpException Thrown when response is not possible to parse or oauth code stops on something
     * @return string
     */
    public function oauthCall( $relativeEndpoint, array $params = array() )
    {
        $tokenConsumer = new OAuthConsumer( $this->attribute('access_token'), $this->attribute('access_token_secret') );
        $request = self::createSignedOauthRequest( $relativeEndpoint, $this->attribute('user_remote_id'), $params, $tokenConsumer );

        $body     = false;
        $header   = false;
        $response = eZHTTPTool::sendHTTPRequest( $request, $request->get_port(), false, 'eZ Publish', false );

        if ( !eZHTTPTool::parseHTTPResponse( $response, $header, $body ) )
        {
            throw new OAuthPhpException('Could not parse response from server: ' . var_export( $response, true ) );
        }

        return $body;
    }

    /**
     * Renew access token if it has expired
     *
     * @exception OAuthPhpException Thrown when response is not possible to parse on renewal
     */
    public function oauthVerifyToken()
    {
        if ( $this->attribute( 'access_token_ttl' ) <= time() )
        {
            $jsonString = $this->oauthCall( 'oauth/server/access_token_renew', array( 'oauth_verifier' => $this->attribute('verifier') ) );
            $data = self::jsonDecode( $jsonString );
            if ( $data !== null )
            {
                $this->setAttribute('access_token', $data['oauth_token'] );
                $this->setAttribute('access_token_secret', $data['oauth_token_secret'] );
                $this->setAttribute('access_token_ttl', time() + $data['oauth_token_ttl'] -2 );
                $this->setAttribute('ts', time() );
                $this->store();
            }
            else
                throw new OAuthJsonException( $jsonString, json_last_error() );
        }
    }

    /**
     * Create a signed oauth request optionally using tokens
     *
     * @uses getNetworkKey() To get network key
     * @uses getNetworkSecret() To get network secret
     * @param string $relativeEndpoint Relative url on service portal, like 'oauth/server/login_redirect'
     * @param string $userRemoteId For use as part of consumer key
     * @param array $params Optional parameters to send to server, make sure url's are url encode
     * @param OAuthConsumer|null $tokenConsumer Optional provide a token consumer
     * @return OAuthRequest
     */
    static public function createSignedOauthRequest( $relativeEndpoint, $userRemoteId, array $params = array(), OAuthConsumer $tokenConsumer = null )
    {
        $endPoint      = self::getServerUrl() . $relativeEndpoint;
        $key           = self::getNetworkKey() . '-' . $userRemoteId;
        $consumer      = new OAuthConsumer( $key, self::getNetworkSecret() );
        $request       = OAuthRequest::from_consumer_and_token( $consumer, $tokenConsumer, 'GET', $endPoint, $params );

        $hmacMethod = new OAuthSignatureMethod_HMAC_SHA1();
        $request->sign_request( $hmacMethod, $consumer, $tokenConsumer );

        return $request;
    }

    /**
     * Get server url to service portal
     *
     * @return string
     */
    public static function getServerUrl()
    {
        static $url = null;
        if ( $url === null )
        {
            $url = eZINI::instance( 'network.ini' )->variable( 'NetworkSettings', 'Server' );
        }
        return $url;
    }

    /**
     * Json decode a json string and strip out some garbage sent by support servers
     *
     * @param string $jsonString
     * @return array
     */
    public static function jsonDecode( $jsonString )
    {
        $endChar = '}';
        $firstPos  = strpos( $jsonString, '{' );
        $firstPos2 = strpos( $jsonString, '[' );
        if ( $firstPos === false && $firstPos2 === false )
        {
            return null;
        }

        if ( $firstPos === false || ( $firstPos2 !== false && $firstPos > $firstPos2 ) )
        {
            $firstPos = $firstPos2;
            $endChar = ']';
        }

        $lastPos = strrpos( $jsonString, $endChar );
        if ( $lastPos === false )
        {
            return null;
        }

        $jsonString = substr( $jsonString , $firstPos, ( $lastPos - $firstPos + 1 ) );

        return json_decode( $jsonString, true );
    }

    /**
     * Get network key
     *
     * @uses getNetInstallation() Gets network key by fetching network object
     * @return string
     */
    protected static function getNetworkKey()
    {
        return self::getNetInstallation()->attribute('remote_id');
    }

    /**
     * Get network secret
     * @todo Look into using something else then customer id
     *
     * @uses getNetInstallation() Gets network secret by fetching network object
     * @return string
     */
    protected static function getNetworkSecret()
    {
        return self::getNetInstallation()->attribute('customer_id');
    }

    /**
     * Get network installation object
     *
     * @return eZNetInstallation
     * @throws eznetInstallException When install is missing a network key
     * @throws eznetSyncException When there is no eZNetInstallation
     * @throws eznetAgreementException When eZNetInstallation object is not published or not enabled
     *
     * All exceptions inherit from eznetException.
     */
    protected static function getNetInstallation()
    {
        static $networkInstall = null;
        if ( $networkInstall === null )
        {
            $nwRemoteId = eZDB::instance()->arrayQuery( 'SELECT value FROM ezsite_data WHERE name=\'ezpublish_site_id\'' );
            if ( count( $nwRemoteId ) != 1 )
            {
                throw new eznetInstallException( 'Could not fetch network key, extension/ez_network/scripts/initialize.php needs to be executed.' );
            }

            $networkInstall = eZPersistentObject::fetchObject( eZNetInstallation::definition(),
                                                               null,
                                                               array( 'remote_id' => $nwRemoteId[0]['value'] ),
                                                               true );
            if ( !$networkInstall instanceof eZNetInstallation )
            {
                throw new eznetSyncException( 'Could not fetch eZNetInstallation object, have you executed sync_network cronjob?' );
            }
            elseif ( $networkInstall->attribute('status') != eZNetInstallation::StatusPublished )
            {
                throw new eznetAgreementException( 'eZNetInstallation object was not published, contact your eZ sales representative to renew your contract.' );
            }
            elseif ( $networkInstall->attribute('is_enabled') != eZNetInstallation::IsEnabledTrue )
            {
                throw new eznetAgreementException( 'eZNetInstallation object was not enabled, contact your eZ sales representative to renew your contract.' );
            }

        }
        return $networkInstall;
    }
}

class eznetException extends Exception { }
class eznetInstallException extends eznetException { }
class eznetSyncException extends eznetException { }
class eznetAgreementException extends eznetException { }

?>
