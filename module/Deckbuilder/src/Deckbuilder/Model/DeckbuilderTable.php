<?php
namespace Deckbuilder\Model;

use Zend\Db\TableGateway\TableGateway;
use Carddb\Model\CarddbTable;

class DeckbuilderTable
{
   protected $tableGateway;
   protected $slotGateway;
   protected $carddbGateway;

   public function __construct(TableGateway $tableGateway, TableGateway $slotGateway, TableGateway $carddbGateway)
   {
       $this->tableGateway = $tableGateway;
       $this->slotGateway = $slotGateway;
       $this->carddbGateway = $carddbGateway;
   }

   public function fetchAll()
   {
       $resultSet = $this->tableGateway->select();
       return $resultSet;
   }

   public function fetchDeck($id)
   {
       $id  = (int) $id;
       $rowset = $this->tableGateway->select(array('deck_id' => $id));
       $row = $rowset->current();
       $deckslots = $this->slotGateway->select(array('deck_id' => $id));
       $row->slots = $deckslots->toArray();
       
			$fields = array(
				'set_name' => false,
				'card_number' => false,
				'name' => true,
				'rank' => false,
				'suit' => false,
				'type' => false,
				'cost' => false,
				'upkeep' => false,
				'production' => false,
				'bullets' => false,
				'bullet_bonus' => false,
				'draw_type' => false,
				'influence' => false,
				'control' => false,
				'outfit' => false,
				'keywords' => true,
				'text' => true,
				'flavor_text' => true,
				'card_image' => false,
			);
       
       foreach ($row->slots as $slot => $value) {
       		$card = $this->getCarddb($row->slots[$slot]['card_id']);
					foreach ($fields as $k => $v)
					{
						$row->slots[$slot][$k] = $card->$k;
					}
						$row->slots[$slot]['id'] = $row->slots[$slot]['card_id'];
       }
       
       if (!$row) {
           throw new \Exception("Could not find row $id");
       }
       return $row;
   }
   
    public function getCarddb($id)
    {
        $id  = (int) $id;
        $rowset = $this->carddbGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

   public function getDeckbuilder($id)
   {
       $id  = (int) $id;
       $rowset = $this->tableGateway->select(array('deck_id' => $id));
       $row = $rowset->current();
       if (!$row) {
           throw new \Exception("Could not find row $id");
       }
       return $row;
   }

   public function saveDeckbuilder(Deckbuilder $Deckbuilder)
   {
       $data = array(
           'name' => $Deckbuilder->name,
           'author_id'  => $Deckbuilder->author_id,
           'description' => $Deckbuilder->description,
       );

       $id = (int) $Deckbuilder->id;
       if ($id == 0) {
           $this->tableGateway->insert($data);
       } else {
           if ($this->getDeckbuilder($id)) {
               $this->tableGateway->update($data, array('deck_id' => $id));
           } else {
               throw new \Exception('Deckbuilder id does not exist');
           }
       }
   }

   public function deleteDeckbuilder($id)
   {
       $this->tableGateway->delete(array('deck_id' => (int) $id));
   }
}
