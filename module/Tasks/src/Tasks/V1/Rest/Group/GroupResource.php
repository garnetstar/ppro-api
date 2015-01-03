<?php
namespace Tasks\V1\Rest\Group;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Model\Facade\UserFacade;
use Model\Facade\GroupFacade;
use Model\Entity\Role;
use Model\Entity\Group;

class GroupResource extends AbstractResourceListener
{

    /**
     *
     * @var UserFacade
     */
    private $userFacade;

    /**
     *
     * @var GroupFacade
     */
    private $groupFacade;

    public function __construct(UserFacade $userFacade, GroupFacade $groupFacade)
    {
        $this->userFacade = $userFacade;
        $this->groupFacade = $groupFacade;
    }

    /**
     * Create a resource
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        /* @var $user User */
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            
            $group = $this->groupFacade->addGroup($data->name);
            
            return array(
                "id" => $group->getID(),
                "name" => $group->getName()
            );
        } else {
            return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
        }
    }

    /**
     * Delete a resource
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        /* @var $user User */
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        if ($user->hasRole(Role::ADMIN)) {
            return $this->groupFacade->delete($id);
        } else {
            return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $group = $this->groupFacade->getGroup($id);
        
        if ($group) {
            return array(
                "id" => $group->getID(),
                "name" => $group->getName()
            );
        }
        return false;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param array $params            
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $groups = $this->groupFacade->getAll();
        $groupsArray = [];
        
        /* @var $group Group */
        foreach ($groups as $group) {
            $groupsArray[] = array(
                "id" => $group->getID(),
                "name" => $group->getName()
            );
        }
        
        return $groupsArray;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param mixed $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param mixed $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
