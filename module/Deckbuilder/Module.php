<?php
namespace Deckbuilder;

use Deckbuilder\Model\Deckbuilder;
use Deckbuilder\Model\Deckslot;
use Carddb\Model\Carddb;
use Deckbuilder\Model\DeckbuilderTable;
use Carddb\Model\CarddbTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
               'Deckbuilder\Model\DeckbuilderTable' =>  function($sm) {
                   $tableGateway = $sm->get('DeckbuilderTableGateway');
                   $slotGateway = $sm->get('DeckslotTableGateway');
                   $carddbTableGateway = $sm->get('CarddbTableGateway');
                   $table = new DeckbuilderTable($tableGateway, $slotGateway, $carddbTableGateway);
                   return $table;
               },
               'DeckbuilderTableGateway' => function ($sm) {
                   $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                   $resultSetPrototype = new ResultSet();
                   $resultSetPrototype->setArrayObjectPrototype(new Deckbuilder());
                   return new TableGateway('decks', $dbAdapter, null, $resultSetPrototype);
               },
               'DeckslotTableGateway' => function ($sm) {
                   $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                   $resultSetPrototype = new ResultSet();
                   $resultSetPrototype->setArrayObjectPrototype(new Deckslot());
                   return new TableGateway('deckslot', $dbAdapter, null, $resultSetPrototype);
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
