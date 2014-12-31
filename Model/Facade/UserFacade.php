<?php
namespace Model\Facade;

use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use Model\Entity\User;

/**
 *
 * @author Jan Macháček
 *        
 */
class UserFacade extends AbstractFacade
{

    public function getUserByIdentity(AuthenticatedIdentity $identity)
    {
        $userId = $identity->getAuthenticationIdentity()["user_id"];
        
        return $this->em->find(User::class, $userId);
    }
}

