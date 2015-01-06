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
    private $userFacade;

    /**
     *
     * @var GroupFacade
     */
    private $groupFacade;

    public function __construct(UserFacade $facade, GroupFacade $groupFacade)
    {
        $this->userFacade = $facade;
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
            
            $user = $this->userFacade->addUser($data->username, sha1($data->password), $data->name, $data->surname, $roleID, $groups);
            
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
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            return $this->userFacade->deleteUser($id);
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
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        if ($user->hasRole(Role::ADMIN) || $id == $user->getId()) {
            $returnUser = $this->userFacade->getUserByID($id);
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
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        
        if ($user->hasRole(Role::ADMIN)) {
            $users = $this->userFacade->getAll();
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
     * metoda PATCH
     * 
     * role USER může updatovat pouze sama sebe
     *
     * @param mixed $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $name = $this->getParameter("name", $data);
        $surname = $this->getParameter("surname", $data);
        $username = $this->getParameter("username", $data);
        $password = sha1($this->getParameter("password", $data));
        
        $user = $this->getUser();
        
        if (! $user->hasRole(Role::ADMIN)) {
            if ($user->getID() != $id) {
                return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
            }
        }
        
        $res = $this->userFacade->updateUser($id, $name, $surname, $username, $password);
        
        return $res;
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

    private function getParameter($paramName, $data)
    {
        if (isset($data->$paramName)) {
            return $data->$paramName;
        }
        
        return null;
    }

    /**
     *
     * @return User
     */
    private function getUser()
    {
        /* @var $user User */
        return $this->userFacade->getUserByIdentity($this->getIdentity());
    }
}
