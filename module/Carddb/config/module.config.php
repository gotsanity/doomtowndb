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
                    'route'    => '/carddb[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:query][set_name:set_name][card_number:card_number][name:name][rank:rank][suit:suit][type:type][cost:cost][upkeep:upkeep][production:production][bullets:bullets][draw_type:draw_type][influence:influence][outfit:outfit][keywords:keywords][text:text][flavor_text:flavor_text][card_image:card_image]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                        'set_name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'card_number' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'rank' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'suit' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'cost' => '[0-9]+',
                        'upkeep' => '[0-9]+',
                        'production' => '[0-9]+',
                        'bullets' => '[0-9]+',
                        'bullet_bonus' => '[0-9]+',
                        'draw_type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'influence' => '[0-9]+',
                        'control' => '[0-9]+',
                        'outfit' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'keywords' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'text' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'flavor_text' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'card_image' => '[a-zA-Z][a-zA-Z0-9_-]*',
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

