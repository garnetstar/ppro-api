<?php
namespace Model\Facade;

use ZF\MvcAuth\Identity\AuthenticatedIdentity;
use Model\Entity\User;
use Model\Entity\Role;

/**
 *
 * @author Jan Macháček
 *        
 */
class UserFacade extends AbstractFacade
{

    /**
     *
     * @param AuthenticatedIdentity $identity            
     * @return Ambigous <object, NULL, unknown>
     */
    public function getUserByIdentity(AuthenticatedIdentity $identity)
    {
        $userId = $identity->getAuthenticationIdentity()["user_id"];
        
        return $this->em->find(User::class, $userId);
    }

    /**
     *
     * @param unknown $username            
     * @param unknown $password            
     * @param unknown $name            
     * @param unknown $surname            
     * @param unknown $roleID            
     * @param array $groupIds            
     */
    public function addUser($username, $password, $name, $surname, $roleID, array $groups)
    {
        $role = $this->em->getPartialReference(Role::class, $roleID);
        
        $user = new User();
        $user->setUsername($username)
            ->setPassword($password)
            ->setName($name)
            ->setSurname($surname)
            ->setRole($role)
            ->setGroups($groups);
        
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     *
     * @param int $userID            
     * @return boolean
     */
    public function deleteUser($userID)
    {
        $user = $this->em->find(User::class, $userID);
        
        if (! $user) {
            return false;
        }
        
        $this->em->remove($user);
        $this->em->flush();
        return true;
    }

    /**
     *
     * @param unknown $userID            
     * @return User
     */
    public function getUserByID($userID)
    {
        return $this->em->find(User::class, $userID);
    }

    /**
     *
     * @return User[]
     */
    public function getAll()
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function updateUser($userID, $name = null, $surname = null, $username = null, $password = null, $groups = array())
    {
        /* @var $user User */
        $user = $this->em->find(User::class, $userID);
        
        if (! $user) {
            return false;
        }
        
        if ($name) {
            $user->setName($name);
        }
        
        if ($surname) {
            $user->setSurname($surname);
        }
        
        if ($username) {
            $user->setUsername($username);
        }
        
        if ($password) {
            $user->setPassword($password);
        }
        
        $this->em->persist($user);
        $this->em->flush();
        
        return true;
    }
}

