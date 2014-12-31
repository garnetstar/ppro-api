<?php
namespace Model\Facade;

use Doctrine\ORM\EntityManager;

class AbstractFacade
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}

?>