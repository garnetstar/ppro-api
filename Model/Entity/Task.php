<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Model\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedTasks")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id")
     */
    protected $assignee;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reportedTasks")
     * @ORM\JoinColumn(name="reporter_id", referencedColumnName="id", nullable=false)
     */
    protected $reporter;

    /**
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="tasks")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param unknown $title            
     * @return \Model\Entity\Task
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @param unknown $description            
     * @return \Model\Entity\Task
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param User $assignee            
     * @return \Model\Entity\Task
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;
        return $this;
    }

    /**
     *
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     *
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     *
     * @param User $reporter            
     * @return \Model\Entity\Task
     */
    public function setReporter(User $reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

    /**
     *
     * @param unknown $status            
     * @return \Model\Entity\Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function toArray()
    {
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "asignee" => $this->getAssignee()->getID(),
            "reporter" => $this->getReporter()->getID(),
            "created" => $this->getCreated()->getTimestamp(),
            "status" => $this->getStatus()->getID(),
        )
        ;
    }
}
