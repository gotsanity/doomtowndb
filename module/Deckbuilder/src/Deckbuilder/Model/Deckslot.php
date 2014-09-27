<?php
 namespace Deckbuilder\Model;
 
 use Carddb\Model\Carddb;

 class Deckslot extends Carddb
 {
     public $slot_id;
     public $deck_id;
     public $card_id;
	   public $quantity;
	   public $slots = array();

     public function exchangeArray($data)
     {
     	   $this->slot_id     = (!empty($data['slot_id'])) ? $data['slot_id'] : null;
         $this->deck_id     = (!empty($data['deck_id'])) ? $data['deck_id'] : null;
         $this->card_id     = (!empty($data['card_id'])) ? $data['card_id'] : null;
         $this->quantity     = (!empty($data['quantity'])) ? $data['quantity'] : null;
     }
     
 }
