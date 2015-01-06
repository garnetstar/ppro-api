<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user", options={"type"="InnoDB","charset"="utf8","collate"="utf8_czech_ci"})
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
    protected $email;

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
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     * inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id", unique=false)}
     * )
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="OAuthAccessTokens", mappedBy="user", cascade={"remove"})
     */
    protected $accessTokens;

    /**
     * @ORM\OneToMany(targetEntity="OAuthRefreshTokens", mappedBy="user", cascade={"remove"})
     */
    protected $refreshTokens;

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
    public function getID()
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

    /**
     *
     * @param Role $role            
     * @return \Model\Entity\User
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     *
     * @param string $name            
     * @return \Model\Entity\User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @param string $surname            
     * @return \Model\Entity\User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     *
     * @param string $username            
     * @return \Model\Entity\User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     *
     * @param string $password            
     * @return \Model\Entity\User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     *
     * @param array $groups            
     * @return \Model\Entity\User
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;
        return $this;
    }
    

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @param string $email
     * @return \Model\Entity\User
     */
	public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

	/**
     *
     * @param string $accessTokens            
     * @return \Model\Entity\User
     */
    public function setAccessTokens($accessTokens)
    {
        $this->accessTokens = $accessTokens;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     *
     * @return Group[]
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     *
     * @return array
     */
    public function toArray()
    {
        $groupIDs = [];
        $groupNames = [];
        
        foreach ($this->getGroups() as $group) {
            $groupIDs[] = $group->getID();
            $groupNames[] = $group->getName();
        }
        
        return array(
            "id" => $this->getID(),
            "name" => $this->name,
            "surname" => $this->surname,
            "roleID" => $this->role->getID(),
            "role" => $this->role->getName(),
            "groupIDs" => $groupIDs,
            "groups" => $groupNames
        );
    }
}
