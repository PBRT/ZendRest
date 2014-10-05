<?php

// module/Amounts/config/module.config.php:
return array(
    'controllers' => array(
        'invokables' => array(
            'Amounts\Controller\Amounts' => 'Amounts\Controller\AmountsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'amounts' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/amounts[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Amounts\Controller\Amounts',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        /*'template_path_stack' => array(
            'amounts' => __DIR__ . '/../view',
        ),*/
        'strategies' => array(
            'ViewJsonStrategy',
        ),

    ),
);
