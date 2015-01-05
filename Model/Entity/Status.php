<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="status")
 */
class Status
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="status")
     */
    protected $tasks;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name            
     * @return \Model\Entity\Status
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}

