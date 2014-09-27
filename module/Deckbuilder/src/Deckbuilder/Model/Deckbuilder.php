<?php
 namespace Deckbuilder\Model;

 class Deckbuilder
 {
     public $deck_id;
     public $name;
     public $author_id;
	   public $description;
	   public $slots;

     public function exchangeArray($data)
     {
         $this->deck_id     = (!empty($data['deck_id'])) ? $data['deck_id'] : null;
         $this->name = (!empty($data['name'])) ? $data['name'] : null;
         $this->author_id = (!empty($data['author_id'])) ? $data['author_id'] : null;
         $this->description = (!empty($data['description'])) ? $data['description'] : null;
         $this->slots = (!empty($data['slots'])) ? $data['slots'] : null;
     }
 }
