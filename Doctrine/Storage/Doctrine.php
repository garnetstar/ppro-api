<?php
namespace Doctrine\Storage;

use OAuth2\OpenID\Storage\UserClaimsInterface;
use OAuth2\OpenID\Storage\AuthorizationCodeInterface as OpenIDAuthorizationCodeInterface;
use OAuth2\Storage\AuthorizationCodeInterface;
use OAuth2\Storage\AccessTokenInterface;
use OAuth2\Storage\ClientCredentialsInterface;
use OAuth2\Storage\UserCredentialsInterface;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\JwtBearerInterface;
use OAuth2\Storage\ScopeInterface;
use OAuth2\Storage\PublicKeyInterface;
use OAuth2;
use Model\Facade\OAuthFacade;

/**
 * @author Jan Macháček
 */
class Doctrine implements AuthorizationCodeInterface, AccessTokenInterface, ClientCredentialsInterface, UserCredentialsInterface, RefreshTokenInterface, JwtBearerInterface, ScopeInterface, PublicKeyInterface, UserClaimsInterface, OpenIDAuthorizationCodeInterface
{

    protected $db;

    protected $config;

    /**
     *
     * @var OAuthFacade
     */
    protected $facade;

    public function __construct(OAuthFacade $facade)
    {        
        $this->facade = $facade;
    }

    public function isPublicClient($client_id)
    {
        return $this->facade->isPublicClient($client_id);
        
    }
    
    /* OAuth2\Storage\ClientInterface */
    public function getClientDetails($clientId)
    {
        $client = $this->facade->getClientById($clientId);
        
        if ($client) {
            
            return array(
                "client_id" => $client->getClientId()
            );
        }
        
        return false;
        
    }

    public function checkRestrictedGrantType($client_id, $grant_type)
    {
        $details = $this->getClientDetails($client_id);
        if (isset($details['grant_types'])) {
            $grant_types = explode(' ', $details['grant_types']);
            
            return in_array($grant_type, (array) $grant_types);
        }
        
        // if grant_types are not defined, then none are restricted
        return true;
    }
    
    /* OAuth2\Storage\AccessTokenInterface */
    public function getAccessToken($access_token)
    {
        return $this->facade->getAccessToken($access_token);
    }

    public function setAccessToken($access_token, $client_id, $user_id, $expires, $scope = null)
    {
        // convert expires to datestring
        $expires = date('Y-m-d H:i:s', $expires);
        
        // if it exists, update it.
        if ($this->getAccessToken($access_token)) {
            
        } else {
            $this->facade->createAccessToken($access_token, $client_id, $user_id, $expires, $scope);
        }
        
        return true;
    }
    
    /* OAuth2\Storage\UserCredentialsInterface */
    public function checkUserCredentials($username, $password)
    {
        if ($user = $this->getUser($username)) {
            return $this->checkPassword($user, $password);
        }
        
        return false;
    }

    public function getUserDetails($username)
    {
        return $this->getUser($username);
    }
    
    /* UserClaimsInterface */
    public function getUserClaims($user_id, $claims)
    {
        if (! $userDetails = $this->getUserDetails($user_id)) {
            return false;
        }
        
        $claims = explode(' ', trim($claims));
        $userClaims = array();
        
        // for each requested claim, if the user has the claim, set it in the response
        $validClaims = explode(' ', self::VALID_CLAIMS);
        foreach ($validClaims as $validClaim) {
            if (in_array($validClaim, $claims)) {
                if ($validClaim == 'address') {
                    // address is an object with subfields
                    $userClaims['address'] = $this->getUserClaim($validClaim, $userDetails['address'] ?  : $userDetails);
                } else {
                    $userClaims = array_merge($userClaims, $this->getUserClaim($validClaim, $userDetails));
                }
            }
        }
        
        return $userClaims;
    }

    protected function getUserClaim($claim, $userDetails)
    {
        $userClaims = array();
        $claimValuesString = constant(sprintf('self::%s_CLAIM_VALUES', strtoupper($claim)));
        $claimValues = explode(' ', $claimValuesString);
        
        foreach ($claimValues as $value) {
            $userClaims[$value] = isset($userDetails[$value]) ? $userDetails[$value] : null;
        }
        
        return $userClaims;
    }
    
    /* OAuth2\Storage\RefreshTokenInterface */
    public function getRefreshToken($refresh_token)
    {
        $refreshToken = $this->facade->getRefreshToken($refresh_token);
        
        if ($refreshToken) {
            return array("expires" => $refreshToken->getExpires()->getTimestamp(),
                "client_id" => $refreshToken->getClient()->getClientId(),
                "user_id" => $refreshToken->getUser()->getId(),
                "scope" => $refreshToken->getScope(),
            );
        }
        return false;
        
    }

    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
    {
        // convert expires to datestring
        $expires = date('Y-m-d H:i:s', $expires);
        
        $this->facade->setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope);
        
        return true;
        
    }

    // plaintext passwords are bad! Override this for your application
    protected function checkPassword($user, $password)
    {
        return $user['password'] == sha1($password);
    }

    public function getUser($username)
    {
        return $this->facade->getUser($username);
 
    }
	/* (non-PHPdoc)
     * @see \OAuth2\Storage\ScopeInterface::scopeExists()
     */
    public function scopeExists($scope)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\ScopeInterface::getDefaultScope()
     */
    public function getDefaultScope($client_id = null)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\AuthorizationCodeInterface::getAuthorizationCode()
     */
    public function getAuthorizationCode($code)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\AuthorizationCodeInterface::setAuthorizationCode()
     */
    public function setAuthorizationCode($code, $client_id, $user_id, $redirect_uri, $expires, $scope = null, $idToken = null)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\AuthorizationCodeInterface::expireAuthorizationCode()
     */
    public function expireAuthorizationCode($code)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\ClientInterface::getClientScope()
     */
    public function getClientScope($client_id)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\JwtBearerInterface::getClientKey()
     */
    public function getClientKey($client_id, $subject)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\JwtBearerInterface::getJti()
     */
    public function getJti($client_id, $subject, $audience, $expiration, $jti)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\JwtBearerInterface::setJti()
     */
    public function setJti($client_id, $subject, $audience, $expiration, $jti)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\PublicKeyInterface::getPublicKey()
     */
    public function getPublicKey($client_id = null)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\PublicKeyInterface::getPrivateKey()
     */
    public function getPrivateKey($client_id = null)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\PublicKeyInterface::getEncryptionAlgorithm()
     */
    public function getEncryptionAlgorithm($client_id = null)
    {
        // TODO Auto-generated method stub
        
    }
	/* (non-PHPdoc)
     * @see \OAuth2\Storage\ClientCredentialsInterface::checkClientCredentials()
     */
    public function checkClientCredentials($client_id, $client_secret = null)
    {
        // TODO Auto-generated method stub
        
    }

	/* (non-PHPdoc)
     * @see \OAuth2\Storage\RefreshTokenInterface::unsetRefreshToken()
     */
    public function unsetRefreshToken($refresh_token)
    {
        // TODO Auto-generated method stub
        
    }
}
