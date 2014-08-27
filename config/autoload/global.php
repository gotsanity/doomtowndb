<?php
return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=dtrdb;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    
     'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Home',
                 'route' => 'home',
             ),
             array(
                 'label' => 'Cards',
                 'route' => 'carddb',
                 'pages' => array(
                     array(
                         'label' => 'Add',
                         'route' => 'carddb',
                         'action' => 'add',
                     ),
                     array(
						              'label' => 'Edit',
						              'route' => 'carddb',
						              'action' => 'edit',
						          ),
						          array(
						              'label' => 'Delete',
						              'route' => 'carddb',
						              'action' => 'delete',
						          ),
						          array(
						              'label' => 'Single',
						              'route' => 'carddb',
						              'action' => 'single',
						          ),
                 ),
             ),
         ),
     ),
    
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
	    			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
);
