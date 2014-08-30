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
                    'route'    => '/carddb[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
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

