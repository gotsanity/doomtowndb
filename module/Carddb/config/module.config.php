<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Carddb\Controller\Carddb' => 'Carddb\Controller\CarddbController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'carddb' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/carddb[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Carddb\Controller\Carddb',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'carddb' => __DIR__ . '/../view',
        ),
    ),
);
