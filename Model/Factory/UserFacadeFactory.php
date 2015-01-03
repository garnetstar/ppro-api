<?php
namespace Model\Factory;

use Zend\ServiceManager\FactoryInterface;
use Model\Facade\UserFacade;

/**
 *
 * @author Jan Macháček
 *        
 */
class UserFacadeFactory implements FactoryInterface
{
    /*
     * (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $f = new UserFacade($em);
        return $f;
    }
}

