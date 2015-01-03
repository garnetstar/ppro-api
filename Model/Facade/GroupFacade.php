<?php
namespace Model\Facade;

use Model\Entity\Group;
use Zend\Crypt\PublicKey\Rsa\PublicKey;
use Doctrine\Common\Collections\ArrayCollection;
use Model\Entity\User;
use Model\Repository\GroupRepository;

/**
 *
 * @author Jan Macháček
 *        
 */
class GroupFacade extends AbstractFacade
{

    /**
     *
     * @param string $name            
     * @return Group
     */
    public function addGroup($name)
    {
        $group = new Group();
        $group->setName($name);
        
        $this->em->persist($group);
        $this->em->flush();
        return $group;
    }

    /**
     *
     * @param int $groupID            
     * @return boolean
     */
    public function delete($groupID)
    {
        $group = $this->em->find(Group::class, $groupID);
        
        if ($group) {
            $this->em->remove($group);
            $this->em->flush();
            return true;
        }
        
        return false;
    }

    /**
     *
     * @param int $groupID            
     * @return Group|boolean
     */
    public function getGroup($groupID)
    {
        $group = $this->em->find(Group::class, $groupID);
        if ($group) {
            return $group;
        }
        return false;
    }

    /**
     *
     * @return array
     */
    public function getAll()
    {
        return $this->em->getRepository(Group::class)->findAll();
    }

    /**
     *
     * @param array $groupIds            
     * @return Group[]
     */
    public function getGroupsByIDs(array $groupIds)
    {
        $groups = [];
        foreach ($groupIds as $groupID) {
            $group = $this->em->find(Group::class, $groupID);
            if (! $group) {
                return false;
            }
            $groups[] = $group;
        }
        return $groups;
    }

    /**
     * Zkontroluje zda jsou uživatelé ve stejné skupině
     * 
     * @param User $firstUser
     * @param User $secondUser
     * @return boolean
     */
    public function isInGroup(User $firstUser, User $secondUser)
    {
        $firstGroups = $this->getGroupsByUserID($firstUser);
        $secondGroups = $this->getGroupsByUserID($secondUser);
        
        $intersec = array_intersect($firstGroups, $secondGroups);
        
        return ! empty($intersec);
    }

    /**
     * 
     * @param User $user
     * @return multitype:
     */
    public function getGroupsByUserID(User $user)
    {
        $groups = $user->getGroups()->toArray();
        
        $groupIDs = array_map(function (Group $group)
        {
            return $group->getID();
        }, $groups);
        
        return $groupIDs;
    }
}
