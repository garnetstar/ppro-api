<?php
namespace Model\Facade;

use Model\Entity\Group;

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
     * @return boolean
     */
    public function addGroup($name)
    {
        $group = new Group();
        $group->setName($name);
        
        $this->em->persist($group);
        $this->em->flush();
        return true;
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
     * @return array
     */
    public function getAll()
    {
        return $this->em->getRepository(Group::class)->findAll();
    }
}
