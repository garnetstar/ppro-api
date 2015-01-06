<?php
namespace Model\Facade;

use Model\Entity\Message;
use Model\Entity\MessageType;
use Model\Entity\Task;
use Model\Repository\MessageRepository;

/**
 *
 * @author Jan Macháček
 *        
 */
class MessageFacade extends AbstractFacade
{

    /**
     *
     * @param int $taskID            
     * @param int $typeID            
     * @return boolean|unknown
     */
    public function createMessage($taskID, $typeID)
    {
        $messageType = $this->em->getPartialReference(MessageType::class, $typeID);
        
        $task = $this->em->find(Task::class, $taskID);
        
        if (! $task) {
            return false;
        }
        
        $message = new Message();
        $message->setCreated(new \DateTime())
            ->setMessageType($messageType)
            ->setTask($task);
        
        $this->em->persist($message);
        $this->em->flush();
        
        return $task;
    }

    /**
     *
     * @return Message[]
     */
    public function getMessagesToSend()
    {
        /* @var $rep MessageRepository */
        $rep = $this->em->getRepository(Message::class);
        
        return $rep->getMessagesToSend();
    }

    /**
     * 
     * @param Message $message
     */
    public function updateProcesset(Message $message)
    {
        $message->setProcessed(new \DateTime());
        $this->em->persist($message);
        $this->em->flush();
    }
}
