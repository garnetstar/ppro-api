<?php
namespace Tasks\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Model\Facade\UserFacade;
use Model\Entity\User;
use Model\Entity\Role;
use Model\Facade\GroupFacade;

class UserResource extends AbstractResourceListener
{

    /**
     *
     * @var UserFacade
     */
    private $facade;

    /**
     *
     * @var GroupFacade
     */
    private $groupFacade;

    public function __construct(UserFacade $facade, GroupFacade $groupFacade)
    {
        $this->facade = $facade;
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
        $user = $this->facade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            
            $groupIDs = array_map(function ($piece)
            {
                return (int) trim($piece);
            }, explode(",", $data->groups));
            
            $groups = $this->groupFacade->getGroupsByIDs($groupIDs);
            
            if (! $groups) {
                return new ApiProblem(400, sprintf('Nepodařilo se najít odpovídající Group podle \'%s\'', $data->groups));
            }
            
            switch ($data->role) {
                case "admin":
                    $roleID = 1;
                    break;
                case "user":
                    $roleID = 2;
                    break;
                default:
                    return new ApiProblem(400, sprintf('Nepodařilo se najít odpovídající Roli podle \'%s\'', $data->role));
            }
            
            $user = $this->facade->addUser($data->username, sha1($data->password), $data->name, $data->surname, $roleID, $groups);
            
            return array(
                "id" => $user->getId()
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
        $user = $this->facade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            return $this->facade->deleteUser($id);
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
        $user = $this->facade->getUserByIdentity($this->getIdentity());
        if ($user->hasRole(Role::ADMIN) || $id == $user->getId()) {
            $returnUser = $this->facade->getUserByID($id);
            if ($returnUser) {
                return $returnUser->toArray();
            }
            return false;
        } else {
            return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param array $params            
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $user = $this->facade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            $users = $this->facade->getAll();
            $usersArray = [];
            foreach ($users as $user) {
                $usersArray[] = $user->toArray();
            }
            
            return $usersArray;
        } else {
            return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
        }
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
