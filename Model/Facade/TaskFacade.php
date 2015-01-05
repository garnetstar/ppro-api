<?php
namespace Model\Facade;

use Model\Entity\Status;
use Model\Entity\User;
use Model\Entity\Task;
use Model\Repository\TaskRepository;

/**
 *
 * @author Jan Macháček
 *        
 */
class TaskFacade extends AbstractFacade
{

    /**
     *
     * @param unknown $title            
     * @param unknown $description            
     * @param unknown $reporter            
     * @param unknown $assignee            
     * @param unknown $status            
     * @return \Model\Entity\Task
     */
    public function addTask($title, $description, $reporter, $assignee, $status)
    {
        $status = $this->em->getPartialReference(Status::class, $status);
        $reporter = $this->em->getPartialReference(User::class, $reporter);
        $assignee = $this->em->getPartialReference(User::class, $assignee);
        
        $task = new Task();
        $task->setTitle($title)
            ->setDescription($description)
            ->setAssignee($assignee)
            ->setReporter($reporter)
            ->setStatus($status);
        
        $this->em->persist($task);
        $this->em->flush();
        
        return $task;
    }

    /**
     *
     * @param string $sort            
     * @param string $statusID            
     * @param string $assigneeID            
     * @param array $groupIDs            
     * @return Task[]
     */
    public function getAll($sort = "asc", $statusID = null, $assigneeID = null, $groupIDs = array())
    {
        /* @var $repo TaskRepository */
        $repo = $this->em->getRepository(Task::class);
        
        $res = $repo->getAll($sort, $statusID, $assigneeID, $groupIDs);
        
        return $res;
    }

    /**
     *
     * @param int $taskID            
     * @return Task|null
     */
    public function getTaskByID($taskID)
    {
        return $this->em->find(Task::class, $taskID);
    }

    /**
     *
     * @param id $taskID            
     * @return boolean
     */
    public function deleteTask($taskID)
    {
        $task = $this->em->find(Task::class, $taskID);
        
        if (! $task) {
            return false;
        }
        
        $this->em->remove($task);
        $this->em->flush();
        return true;
    }
}
