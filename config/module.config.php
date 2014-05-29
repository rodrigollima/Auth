<?php

namespace Auth;

return array(
    'router' => array(
        'routes' => array(
            'auth-login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/AuthServiceLogin',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Authentication',
                        'action'     => 'login',
                    ),
                ),
            ),
            'auth-logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/AuthServiceLogout',
                    'defaults' => array(
                        'controller' => 'Auth\Controller\Authentication',
                        'action'     => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Auth\Controller\Authentication' => 'Auth\Controller\AuthenticationController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/auth'          => __DIR__ . '/../view/layout/auth.phtml',
            'auth/index/index'     => __DIR__ . '/../view/auth/index/index.phtml',
            'error/404'            => __DIR__ . '/../view/error/404.phtml',
            'error/index'          => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Document')
            ),
            'odm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Document' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'Auth\Config' => array(
        //Implementa configurações padrão para busca de dados e validacao
        'Authentication\Adapter' => array(
            'type' => 'mongo',
        ),
        //Implementa o modo como será salvo os dados da sessão
        'Session\Storage' => array(
            'type'  => 'redis',//redis,memcahced
            'redis' => array(
                'phpSaveHandler' => 'redis',
                'savePath' => 'tcp://127.0.0.1:6379?weight=1&timeout=1',  
            ),
            'memcached' => array(
                'phpSaveHandler' => 'memcached',
                'savePath' => 'tcp://127.0.0.1:11211',
            ),
        ),
    ),
);
