<?php
namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="role")
     */
    protected $users;
    
    public function __construct(){
        $this->users = new ArrayCollection();
    }
}

?>