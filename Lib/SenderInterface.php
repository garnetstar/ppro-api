<?php
namespace Lib;

use Model\Entity\Task;
use Model\Entity\MessageType;

interface SenderInterface
{

    /**
     *
     * @param Task $task            
     * @param MessageType $messageType            
     * @return bool
     */
    public function sendMessage(Task $task, MessageType $messageType);
}

