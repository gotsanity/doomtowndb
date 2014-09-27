<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Deckbuilder\Controller\Deckbuilder' => 'Deckbuilder\Controller\DeckbuilderController',
         ),
     ),
     
    'router' => array(
        'routes' => array(
            'deckbuilder' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/deckbuilder[/:action][/:deck_id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Deckbuilder\Controller\Deckbuilder',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
     
     'view_manager' => array(
         'template_path_stack' => array(
             'Deckbuilder' => __DIR__ . '/../view',
         ),
     ),
);
