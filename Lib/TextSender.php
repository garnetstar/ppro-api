<?php
namespace Lib;

use Model\Entity\MessageType;

class TextSender implements SenderInterface
{

    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    /*
     * (non-PHPdoc)
     * @see \Lib\SenderInterface::sendMessage()
     */
    public function sendMessage(\Model\Entity\Task $task, \Model\Entity\MessageType $messageType)
    {
        $message = array();
        
        if ($messageType->getID() == MessageType::CREATE) {
            $message[] = "zpráva\tByl vytvořen nový task: " . $task->getTitle();
            $message[] = "adresát\t" . $task->getAssignee()->getEmail();
        }
        
        if ($messageType->getID() == MessageType::CHANGE_STATUS) {
            $message[] = "zpráva\tU tasku \"" . $task->getTitle(). "\" byl změněn status na ".$task->getStatus()->getName();
            $message[] = "adresát\t" . $task->getReporter()->getEmail();
        }
        
        $toSave = implode("\n", $message)."\n\n";
        file_put_contents($this->filename, $toSave, FILE_APPEND);
        
        return true;
    }
}

