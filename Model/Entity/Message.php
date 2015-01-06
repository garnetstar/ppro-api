<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Model\Repository\MessageRepository")
 * @ORM\Table(name="message")
 */
class Message
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $processed;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="messages")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id", nullable=false)
     */
    protected $task;

    /**
     * @ORM\ManyToOne(targetEntity="MessageType")
     * @ORM\JoinColumn(name="messageType_id", referencedColumnName="id", nullable=false)
     */
    protected $messageType;

    public function getID()
    {
        return $this->id;
    }

    /**
     *
     * @param \DateTime $dateTime            
     * @return \Model\Entity\Message
     */
    public function setCreated(\DateTime $dateTime)
    {
        $this->created = $dateTime;
        return $this;
    }

    /**
     *
     * @param \DateTime $dateTime            
     * @return \Model\Entity\Message
     */
    public function setProcessed(\DateTime $dateTime)
    {
        $this->processed = $dateTime;
        return $this;
    }

    /**
     *
     * @param Task $task            
     * @return \Model\Entity\Message
     */
    public function setTask(Task $task)
    {
        $this->task = $task;
        return $this;
    }

    /**
     *
     * @param MessageType $messageType            
     * @return \Model\Entity\Message
     */
    public function setMessageType(MessageType $messageType)
    {
        $this->messageType = $messageType;
        return $this;
    }

    /**
     *
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     *
     * @return MessageType
     */
    public function getMessageType()
    {
        return $this->messageType;
    }
}
