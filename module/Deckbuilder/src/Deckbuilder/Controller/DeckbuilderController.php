<?php
namespace Deckbuilder\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeckbuilderController extends AbstractActionController
{

	protected $DeckbuilderTable;

   public function getDeckbuilderTable()
   {
       if (!$this->DeckbuilderTable) {
           $sm = $this->getServiceLocator();
           $this->DeckbuilderTable = $sm->get('Deckbuilder\Model\DeckbuilderTable');
       }
       return $this->DeckbuilderTable;
   }

   public function indexAction()
   {
   	return new ViewModel(array(
 	    'deckbuilders' => $this->getDeckbuilderTable()->fetchAll(),
    ));
   }
   
   public function viewAction()
   {
   $id = (int) $this->params()->fromRoute('deck_id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('deckbuilder');
        }
   	return new ViewModel(array(
 	    'deckbuilders' => $this->getDeckbuilderTable()->fetchDeck($this->params()->fromRoute('deck_id', 0)),
    ));
   }

   public function addAction()
   {
   }

   public function editAction()
   {
   }

   public function deleteAction()
   {
   }
}
