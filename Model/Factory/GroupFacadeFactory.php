<?php
namespace Model\Factory;

use Zend\ServiceManager\FactoryInterface;
use Model\Facade\GroupFacade;

/**
 *
 * @author Jan Macháček
 *        
 */
class GroupFacadeFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $f = new GroupFacade($em);
        return $f;
    }
}

