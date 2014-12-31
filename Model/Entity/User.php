<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
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

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="users_groups",
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="OAuthAccessTokens", mappedBy="user")
     */
    protected $accessTokens;

    public function __construct()
    {
        $this->assignedTasks = new ArrayCollection();
        $this->reportedTasks = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    /**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * 
     * @param int $roleId
     * @return boolean
     */
    public function hasRole($roleId)
    {
        return $this->getRole()->getID() == $roleId;
    }
}
