<?php
namespace Carddb;

// import statements
use Carddb\Model\Carddb;
use Carddb\Model\CarddbTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'query_string' => function($sm) {
                    $helper = new View\Helper\QueryString ;
                    return $helper;
                }
            )
        );   
   }
   
    // start service config
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Carddb\Model\CarddbTable' =>  function($sm) {
                    $tableGateway = $sm->get('CarddbTableGateway');
                    $table = new CarddbTable($tableGateway);
                    return $table;
                },
                'CarddbTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Carddb());
                    return new TableGateway('carddb', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
?>
