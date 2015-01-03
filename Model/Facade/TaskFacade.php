<?php
namespace Model\Facade;

use Model\Entity\Status;
use Model\Entity\User;
use Model\Entity\Task;

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
}
