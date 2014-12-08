<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class User
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="assignee")
     */
    protected $assignedTasks;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="reporter")
     */
    protected $reportedTasks;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $surname;

    public function __construct()
    {
        $this->assignedTasks = new ArrayCollection();
        $this->reportedTasks = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
}
?>