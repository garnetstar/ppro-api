<?php
namespace Doctrine\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\OAuth2\Controller\Exception;
use Doctrine\DoctrineAdapter;

class DoctrineAdapterFactory implements FactoryInterface
{

    /**
     *
     * @param ServiceLocatorInterface $services            
     * @throws \ZF\OAuth2\Controller\Exception\RuntimeException
     * @return \ZF\OAuth2\Adapter\PdoAdapter
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('Config');
        
//         if (! isset($config['zf-oauth2']['db']) || empty($config['zf-oauth2']['db'])) {
//             throw new Exception\RuntimeException('The database configuration [\'zf-oauth2\'][\'db\'] for OAuth2 is missing');
//         }
        
//         $username = isset($config['zf-oauth2']['db']['username']) ? $config['zf-oauth2']['db']['username'] : null;
//         $password = isset($config['zf-oauth2']['db']['password']) ? $config['zf-oauth2']['db']['password'] : null;
//         $options = isset($config['zf-oauth2']['db']['options']) ? $config['zf-oauth2']['db']['options'] : array();
        
//         $oauth2ServerConfig = array();
//         if (isset($config['zf-oauth2']['storage_settings']) && is_array($config['zf-oauth2']['storage_settings'])) {
//             $oauth2ServerConfig = $config['zf-oauth2']['storage_settings'];
//         }
        
        $facade = $services->get('Model\Facade\OAuthFacade');
        
        return new DoctrineAdapter($facade);
    }
}
