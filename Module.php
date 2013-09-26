<?php

namespace Auth;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {   
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', $callback, $priority);
        
        $app->getEventManager()->attach('dispatch', array($this, 'setLayout'));
        
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e)
        {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
            $config = $e->getApplication()->getServiceManager()->get('config');
            
            if (isset($config['view_manager']['template_map']['layout/'.$moduleNamespace])) {
                $controller->layout('layout/'.$moduleNamespace);
            }
        }, 100);
    }
    
    public function setLayout()
    {
        
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Auth\Adapter\Mongo\Authenticate' => function($sm) {
                    return new \Auth\Adapter\MongoAuthenticate($sm->get('doctrine.documentmanager.odm_default'));
                },
                'Auth\Adapter\Session\StorageManager' => function ($sm) {
                    $config = $sm->get('config');
                    $config = $config['Auth\Session\Config'];
                    if (isset($config) && $config['type'] == 'redis') {
                        $sessionConfig = new SessionConfig();
                        $sessionConfig->setOptions($config['redis']);
                        return new SessionManager($sessionConfig);
                    } 
                    
                    return null;
                },
                'Auth\GetIdentity' => function ($sm) {
                     $auth = new AuthenticationService;
                     $auth->setStorage(new SessionStorage("Auth", null, $sm->get('Auth\Adapter\Session\StorageManager')));
                     return $auth->getIdentity();
                },
            ),
        );
    }
}
