<?php
namespace Model\Facade;

use Model\Entity\OAuthClient;
use Model\Entity\OAuthUser;
use Model\Entity\User;
use ZF\MvcAuth\Identity\AuthenticatedIdentity;

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
        
        // $stmt = $this->db->prepare($sql = sprintf('SELECT * from %s where username=:username', $this->config['user_table']));
        // $stmt->execute(array(
        // 'username' => $username
        // ));
        
        // if (! $userInfo = $stmt->fetch()) {
        // return false;
        // }
        
        // the default behavior is to use "username" as the user_id
        // return array_merge(array(
        // 'user_id' => $username
        // ), $userInfo);
    }

    public function getClientDetails($clientId)
    {
        /* @var $client OAuthClient */
        $client = $this->em->find(OAuthClient::class, $clientId);
        
        return array(
            "client_id" => $client->getClientId()
        );
    }
    

}

