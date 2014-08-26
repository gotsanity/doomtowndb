<?php
namespace Carddb\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class CarddbTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false)
    {
        if($paginated) {
            // create a new Select object for the table carddb
            $select = new Select('carddb');
            // create a new result set based on the Carddb entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Carddb());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                // our configured select object
                $select,
                // the adapter to run it against
                $this->tableGateway->getAdapter(),
                // the result set to hydrate
                $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCarddb($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCarddb(Carddb $carddb)
    {
        $data = array(
        		'set_name' => $carddb->set_name,
        		'card_number' => $carddb->card_number,
            'name' => $carddb->name,
            'rank' => $carddb->rank,
            'suit' => $carddb->suit,
            'type' => $carddb->type,
            'cost' => $carddb->cost,
            'upkeep' => $carddb->upkeep,
            'production' => $carddb->production,
            'bullets' => $carddb->bullets,
            'bullet_bonus' => $carddb->bullet_bonus,
            'draw_type' => $carddb->draw_type,
            'influence' => $carddb->influence,
            'control' => $carddb->control,
            'outfit' => $carddb->outfit,
            'keywords' => $carddb->keywords,
            'text' => $carddb->text,
            'flavor_text' => $carddb->flavor_text,
            'card_image' => $carddb->card_image,
        );

        $id = (int)$carddb->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCarddb($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCarddb($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}
