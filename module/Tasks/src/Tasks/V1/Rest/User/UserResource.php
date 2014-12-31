<?php
namespace Tasks\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Model\Facade\UserFacade;
use Model\Entity\User;
use Model\Entity\Role;

class UserResource extends AbstractResourceListener
{

    /**
     *
     * @var UserFacade
     */
    private $facade;

    public function __construct(UserFacade $facade)
    {
        $this->facade = $facade;
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
            echo "creae new user";
        } else {
            echo "nejste admin";
        }
        die("asdf");
        
        return true;
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param array $params            
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
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
