<?php
namespace Model\Factory;

use Zend\ServiceManager\FactoryInterface;
use Model\Facade\OAuthFacade;

class OAuthFacadeFactory implements FactoryInterface
{
	/* (non-PHPdoc)
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $f = new OAuthFacade($em);
        return $f;
    }

    
    
}

?>