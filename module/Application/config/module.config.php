<?php

namespace Application;

return array(
    # definir e gerenciar controllers
    'controllers' => array(
        'factories' => array(
            'Application\Controller\Index' => 'Application\Controller\Factory\IndexControllerFactory',
            'Application\Controller\Pub' => 'Application\Controller\Factory\PubControllerFactory',
            'Application\Controller\Adm' => 'Application\Controller\Factory\AdmControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'pub' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/pub[:action][/:token]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'token' => '[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Pub',
                        'action' => 'login',
                    ),
                ),
            ),
            'adm' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/adm[:action][/:token]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'token' => '[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Adm',
                        'action' => 'index',
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
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/adm' => __DIR__ . '/../view/layout/layout-adm.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    # definir driver, classes anotadas para o doctrine e quem faz autenticação
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/Model/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Model\Entity' => 'application_entities'
                )
            )
        ),
       'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Model\Entity\Responsavel',
                'identity_property' => 'email',
                'credential_property' => 'senha',
            ),
        ),
    ),
);
