<?php
namespace Model\Facade;

use Model\Entity\OAuthClient;
use Model\Entity\OAuthUser;
use Model\Entity\User;
use Model\Entity\OAuthAccessTokens;
use Model\Entity\OAuthRefreshTokens;

class OAuthFacade extends AbstractFacade
{

    /**
     *
     * @param string $clientId            
     * @return boolean
     */
    public function isPublicClient($clientId)
    {
        /* @var $client OAuthClient */
        $client = $this->em->find(OAuthClient::class, $clientId);
        
        if (empty($client)) {
            return false;
        }
        
        return empty($client->getClientSecret());
    }

    public function getUser($username)
    {
        /* @var $user OAuthUser */
        $user = $this->em->getRepository(User::class)->findOneBy([
            "username" => $username
        ]);
        if (empty($user)) {
            return false;
        }
        
        return array(
            'user_id' => $user->getId(),
            'password' => $user->getPassword()
        );
    }

    /**
     *
     * @param int $clientId            
     * @return \Model\Entity\OAuthClient|boolean
     */
    public function getClientById($clientId)
    {
        /* @var $client OAuthClient */
        $client = $this->em->find(OAuthClient::class, $clientId);
        
        if (! empty($client)) {
            
            return $client;
        }
        return false;
    }

    public function getAccessToken($accessToken)
    {
        /* @var $res OAuthAccessTokens */
        $res = $this->em->getRepository(OAuthAccessTokens::class)->findOneBy(array(
            "accessToken" => $accessToken
        ));
        
        if (! empty($res)) {
            
            /* @var $date \DateTime */
            $date = $res->getExpires();
            
            return array(
                "access_token" => $res->getAccessToken(),
                "client_id" => $res->getClient()->getClientId(),
                "user_id" => $res->getUser()->getId(),
                "expires" => $date->getTimestamp(),
                "scope" => $res->getScope()
            );
        }
        
        return false;
    }

    /**
     *
     * @param unknown $accessToken            
     * @param unknown $clientId            
     * @param unknown $userId            
     * @param unknown $expires            
     * @param string $scope            
     */
    public function createAccessToken($accessToken, $clientId, $userId, $expires, $scope = null)
    {
        $client = $this->em->getPartialReference(OAuthClient::class, $clientId);
        $user = $this->em->getPartialReference(User::class, $userId);
        $expiresTime = new \DateTime($expires);
        
        $token = new OAuthAccessTokens();
        $token->setAccessToken($accessToken)
            ->setClient($client)
            ->setUser($user)
            ->setExpires($expiresTime)
            ->setScope($scope);
        
        $this->em->persist($token);
        $this->em->flush();
    }

    /**
     *
     * @param unknown $refresh_token            
     * @param unknown $clientId            
     * @param unknown $userId            
     * @param unknown $expires            
     * @param string $scope            
     */
    public function setRefreshToken($refresh_token, $clientId, $userId, $expires, $scope = null)
    {
        $client = $this->em->getPartialReference(OAuthClient::class, $clientId);
        $user = $this->em->getPartialReference(User::class, $userId);
        
        $expiresTime = new \DateTime($expires);
        
        $refreshToken = new OAuthRefreshTokens();
        $refreshToken->setRefreshToken($refresh_token)
            ->setClient($client)
            ->setUser($user)
            ->setExpires($expiresTime)
            ->setScope($scope);
        
        $this->em->persist($refreshToken);
        $this->em->flush();
    }

    /**
     * 
     * @param string $refreshToken
     * @return \Model\Facade\OAuthRefreshTokens|boolean
     */
    public function getRefreshToken($refreshToken)
    {
        /* @var $refreshTokenEntity OAuthRefreshTokens */
        $refreshTokenEntity = $this->em->getRepository(OAuthRefreshTokens::class)->findOneBy(array(
            "refreshToken" => $refreshToken
        ));
        
        if ($refreshTokenEntity) {
            
            return $refreshTokenEntity;
        }
        
        return false;
    }
}

