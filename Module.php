<?php
namespace Auth;

class Module
{
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
                'Auth\Adapter\Redis\Authenticate' => function($sm) {
                    //em breve
                },
                'Auth\Adapter\Table\Authenticate' => function($sm) {
                    //em breve
                },
            ),
        );
    }
}
