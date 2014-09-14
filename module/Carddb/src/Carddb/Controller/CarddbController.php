<?php
namespace Carddb\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Carddb\Model\Carddb;
use Carddb\Form\CarddbForm;
use Carddb\Form\CarddbSearch;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class CarddbController extends AbstractActionController
{

		protected $carddbTable;

    public function getCarddbTable()
    {
        if (!$this->carddbTable) {
            $sm = $this->getServiceLocator();
            $this->carddbTable = $sm->get('Carddb\Model\CarddbTable');
        }
        return $this->carddbTable;
    }
    
    public function indexAction()
    {
      $select = new Select();
      $order_by = $this->params()->fromRoute('order_by') ?
              $this->params()->fromRoute('order_by') : 'id';

      $order = $this->params()->fromRoute('order') ?
              $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
			$select->order($order_by . ' ' . $order);
			
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

                

		  // grab the paginator from the CarddbTable
		  $paginator = $this->getCarddbTable()->fetchAll(true, $order_by, $order);
		  // set the current page to what has been passed in query string, or to 1 if none set
		  $paginator->setCurrentPageNumber($page);
		  // set the number of items per page to 10
		  $paginator->setItemCountPerPage(15);

		  return new ViewModel(array(
		      'paginator' => $paginator,
		      'order_by' => $order_by,
		      'order' => $order,
		      'page' => $page,
		  ));
    }
    
    public function singleAction()
    {
    	// single display here
    	$id = $this->params()->fromRoute('id');
    	$paginator = $this->getCarddbTable()->getCarddb($id);
    	return new ViewModel(array(
				'paginator' => $paginator,
				'id' => $id,
    	));
    }
    
    public function resultsAction()
    {
      $select = new Select();
      $order_by = $this->params()->fromRoute('order_by') ?
              $this->params()->fromRoute('order_by') : 'id';

      $order = $this->params()->fromRoute('order') ?
              $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
			$select->order($order_by . ' ' . $order);
			
      $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;
        
			$fields = array(
				'set_name',
				'card_number',
				'name',
				'rank',
				'suit',
				'type',
				'cost',
				'upkeep',
				'production',
				'bullets',
				'bullet_bonus',
				'draw_type',
				'influence',
				'control',
				'outfit',
				'keywords',
				'text',
				'flavor_text',
				'card_image',
			);
			
			foreach ($fields as $k => $v)
			{
	      if (!empty($this->params()->fromQuery($v)))
	      {
					$searchFields[] = $v;
	      }
			}

			foreach ($searchFields as $k => $v)
			{
				if (!is_null($this->params()->fromQuery($v)))
				{
					if (strpos($this->params()->fromQuery($v), '>') === 0)
					{
						$query[] = $v.$this->params()->fromQuery($v);
					}
					elseif (strpos($this->params()->fromQuery($v), '<') === 0)
					{
						$query[] = $v.$this->params()->fromQuery($v);
					}
					else 
					{
						$query[$v] = $this->params()->fromQuery($v);
					}
				}
			}
			
			if (count($query) === 0)
			{
				$this->redirect()->toRoute('carddb', array('action' => 'missing'));
			}

		  // grab the paginator from the CarddbTable
		  $paginator = $this->getCarddbTable()->search($query, true, $order_by, $order);
		  // set the current page to what has been passed in query string, or to 1 if none set
		  $paginator->setCurrentPageNumber($page);
		  // set the number of items per page to 10
		  $paginator->setItemCountPerPage(25);

			// if returning a single row redirect to single card view
		  $numrows = $this->getCarddbTable()->search($query, true, $order_by, $order)->count();

		  if ($numrows === -1)
		  {
				foreach ($paginator as $row)
				{
					$id = $row->id;	
				}

			  $this->redirect()->toRoute('carddb', array('action' => 'single', 'id' => $id));
		  }
		  elseif ($numrows === 0)
		  {
		  	$this->redirect()->toRoute('carddb', array('action' => 'missing'));
		  }

			// display list
		  return new ViewModel(array(
		      'paginator' => $paginator,
		      'order_by' => $order_by,
		      'order' => $order,
		      'query' => $query,
		      'page' => $page,
		  ));
    }
    
    public function addAction()
    {
        $form = new CarddbForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $carddb = new Carddb();
            $form->setInputFilter($carddb->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $carddb->exchangeArray($form->getData());
                $this->getCarddbTable()->saveCarddb($carddb);

                // Redirect to list of carddbs
                return $this->redirect()->toRoute('carddb');
            }
        }
        return array('form' => $form);
    }

    public function searchAction()
    {
    		// initialize the form
        $form = new CarddbSearch();
        $form->get('submit')->setValue('Search');
        
        
        // return the form
        return array('form' => $form);
    }
    
    public function missingAction()
    {
    		// initialize the form
        $form = new CarddbSearch();
        $form->get('submit')->setValue('Search');
        
        
        // return the form
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('carddb', array(
                'action' => 'add'
            ));
        }

        // Get the Carddb with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $carddb = $this->getCarddbTable()->getCarddb($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('carddb', array(
                'action' => 'index'
            ));
        }

        $form  = new CarddbForm();
        $form->bind($carddb);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($carddb->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCarddbTable()->saveCarddb($form->getData());

                // Redirect to list of carddbs
                return $this->redirect()->toRoute('carddb');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('carddb');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCarddbTable()->deleteCarddb($id);
            }

            // Redirect to list of carddbs
            return $this->redirect()->toRoute('carddb');
        }

        return array(
            'id'    => $id,
            'carddb' => $this->getCarddbTable()->getCarddb($id)
        );
    }
}
