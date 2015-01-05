<?php
namespace Tasks\V1\Rest\Task;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Model\Facade\TaskFacade;
use Model\Facade\UserFacade;
use Model\Entity\Role;
use Model\Entity\User;
use Model\Facade\GroupFacade;
use Model\Entity\Group;

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

    /**
     *
     * @var GroupFacade
     */
    private $groupFacade;

    public function __construct($taskFacade, $userFacade, $groupFacade)
    {
        $this->taskFacade = $taskFacade;
        $this->userFacade = $userFacade;
        $this->groupFacade = $groupFacade;
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
        $user = $this->getUser();
        
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
            if (! $this->groupFacade->isInGroup($user, $assignee)) {
                return new ApiProblem(403, 'Uživatelé musí být ve stejné skupině.');
            }
        }
        
        if (! $reporter) {
            return new ApiProblem(400, sprintf('Uživatel (reporter) s id=%s neexistuje.', $data->reporter));
        }
        
        $task = $this->taskFacade->addTask($data->title, $data->description, $data->reporter, $data->assignee, $data->status);
        
        return $task->toArray();
    }

    /**
     * metoda DELETE
     *
     * USER smí mazat pouze tasky které sám vytvořil
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $user = $this->getUser();
        
        $task = $this->taskFacade->getTaskByID($id);
        
        if (empty($task)) {
            return false;
        }
        
        if (! $user->hasRole(Role::ADMIN)) {
            if ($task->getReporter() != $user) {
                return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
            }
        }
        
        return $this->taskFacade->deleteTask($id);
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
     * Vrací jeden task podle parametru
     * metoda GET
     *
     * User může dostat pouze tasky ze svých skupin
     *
     * @param mixed $id            
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $user = $this->getUser();
        
        $task = $this->taskFacade->getTaskByID($id);
        
        // User má právo dostat task jehož assignee nebo reporter jsou ve stejné skupině
        if (! $user->hasRole(Role::ADMIN)) {
            if (! ($this->groupFacade->isInGroup($user, $task->getAssignee()) || $this->groupFacade->isInGroup($user, $task->getReporter()))) {
                return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
            }
        }
        
        if (! empty($task)) {
            return $task->toArray();
        }
        
        return false;
    }

    /**
     * metoda GET bez parametru
     * Vrátí všechny tasky pouze pro roli ADMIN
     * Pro roli USER vrací pouze tasky z jeho skupin
     * povolené parametry:
     * sort[asc|desc]
     * status:statusID
     * assignee:userID uživatele kterému byl task přidělen
     * groups: groupID oddělené čárkou
     *
     * @param array $params            
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $user = $this->getUser();
        
        $sort = $params->sort == "desc" ? "desc" : "asc";
        
        $status = isset($params->status) ? (int) $params->status : null;
        
        $assignee = isset($params->assignee) ? (int) $params->assignee : null;
        
        $groups = isset($params->groups) ? array_map(function ($piece)
        {
            return (int) trim($piece);
        }, explode(",", $params->groups)) : array();
        
        // user může vidět jen tasky z vlastních skupin
        if (! $user->hasRole(Role::ADMIN)) {
            $userGroups = $user->getGroups();
            $userGroupIDs = array_map(function (Group $group)
            {
                return $group->getID();
            }, $userGroups->toArray());
            
            $groups = array_intersect($groups, $userGroupIDs);
        }
        
        $result = $this->taskFacade->getAll($sort, $status, $assignee, $groups);
        
        $tasks = array();
        
        if (! empty($result)) {
            foreach ($result as $task) {
                $tasks[] = $task->toArray();
            }
        }
        
        return $tasks;
    }

    /**
     * metoda PATCH
     *
     * role USER má právo editovat jen jím vytvořené tasky, status smí měnit i u tasků které jsou mu přiděleny
     *
     * @param int $id            
     * @param mixed $data            
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $title = $this->getParameter("title", $data);
        $description = $this->getParameter("description", $data);
        $assigneeID = $this->getParameter("assignee", $data);
        $reporterID = $this->getParameter("reporter", $data);
        $statusID = $this->getParameter("status", $data);
        
        $user = $this->getUser();
        
        if (! $user->hasRole(Role::ADMIN)) {
            
            $task = $this->taskFacade->getTaskByID($id);
            
            if ($task->getReporter() != $user) {
                
                if ($task->getAssignee() == $user) {
                    $title = $description = $assigneeID = $reporterID = null;
                } else {
                    return new ApiProblem(403, 'K provedení této akce nemáte dostatečná oprávnění');
                }
            }
        }
        
        $res = $this->taskFacade->updateTask($id, $title, $description, $assigneeID, $reporterID, $statusID);

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

    /**
     *
     * @return User
     */
    private function getUser()
    {
        /* @var $user User */
        return $this->userFacade->getUserByIdentity($this->getIdentity());
    }

    private function getParameter($paramName, $data)
    {
        if (isset($data->$paramName)) {
            return $data->$paramName;
        }
        
        return null;
    }
}
