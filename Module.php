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
        
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'setLayout'), 100);
 
    }
    
    public function setLayout(MvcEvent $e)
    {
        $controller = $e->getTarget();
        $config = $e->getApplication()->getServiceManager()->get('config');
        $controllerClass = get_class($controller);
        $moduleNamespace = strtolower(substr($controllerClass, 0, strpos($controllerClass, '\\')));
        
        if (isset($config['view_manager']['template_map']['layout/'.$moduleNamespace])) {
            $controller->layout('layout/'.$moduleNamespace);
        }
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
                'Auth\Adapter\Mongo' => function($sm) {
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
