<?php
namespace Tasks\V1\Rest\Task;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Model\Facade\TaskFacade;
use Model\Facade\UserFacade;
use Model\Entity\Role;
use Model\Entity\User;

class TaskResource extends AbstractResourceListener
{

    /**
     *
     * @var TaskFacade
     */
    private $taskFacade;

    /**
     *
     * @var UserFacade
     */
    private $userFacade;

    public function __construct($taskFacade, $userFacade)
    {
        $this->taskFacade = $taskFacade;
        $this->userFacade = $userFacade;
    }

    /**
     * Vytvoří nový task
     * ADMIN může vytvořit a přidělit task komukoliv
     * USER může task přidělit pouze userovi který je ve stejné group
     * USER musí figurovate jako reporter
     *
     * metoda POST
     *
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        
        /* @var $user User */
        $user = $this->userFacade->getUserByIdentity($this->getIdentity());
        
        $reporter = $this->userFacade->getUserByID($data->reporter);
        $assignee = $this->userFacade->getUserByID($data->assignee);
        
        if (! $assignee) {
            return new ApiProblem(400, sprintf('Uživatel (assignee) s id=%s neexistuje.', $data->assignee));
        }
        
        if (! $user->hasRole(Role::ADMIN)) {
            // user musí být reporter
            if ($user->getID() != $data->reporter) {
                return new ApiProblem(403, 'Uživatel musí být reporter.');
            }
            // user může přidělit task pouze uživatelům ve své skupině
            // @todo
        }
        
        if (! $reporter) {
            return new ApiProblem(400, sprintf('Uživatel (reporter) s id=%s neexistuje.', $data->reporter));
        }
        
        $task = $this->taskFacade->addTask($data->title, $data->description, $data->reporter, $data->assignee, $data->status);
        
        return $task->toArray();
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
