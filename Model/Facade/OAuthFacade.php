<?php
namespace Model\Facade;

use Model\Entity\OAuthClient;

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
        
    }
}

?>