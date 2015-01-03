<?php
namespace Model\Factory;

use Zend\ServiceManager\FactoryInterface;
use Model\Facade\TaskFacade;

/**
 *
 * @author Jan Macháček
 *        
 */
class TaskFacadeFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $f = new TaskFacade($em);
        return $f;
    }
}

