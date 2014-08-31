<?php
namespace Carddb\Form;

use Zend\Form\Form;

class CarddbSearch extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('carddb');
        $this->setAttribute('method', 'get');
        $this->add(array(
            'name' => 'set_name',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Set',
                'empty_option' => 'Choose a Set',
                'value_options' => array(
                		'Core Set' => 'Core Set'
            		),
            ),
        ));
        $this->add(array(
            'name' => 'card_number',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Card Number',
            ),
            'attributes' => array(
            		'min' => '0',
            		'max' => '500',
            		'step' => '1',
            )
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Card Name',
            ),
        ));
        $this->add(array(
            'name' => 'rank',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Rank',
                'empty_option' => 'Choose a Rank',
                'value_options' => array(
                		'A' => 'A',
                		'1' => '1',
                		'2' => '2',
                		'3' => '3',
                		'4' => '4',
                		'5' => '5',
                		'6' => '6',
                		'7' => '7',
                		'8' => '8',
                		'9' => '9',
                		'10' => '10',
                		'J' => 'J',
                		'Q' => 'Q',
                		'K' => 'K',
                		'*' => 'Joker',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'suit',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Suit',
                'value_options' => array(
                		'' => 'No Suit',
                		'Hearts' => 'Hearts',
                		'Spades' => 'Spades',
                		'Clubs' => 'Clubs',
                		'Diamonds' => 'Diamonds',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Card Type',
                'empty_option' => 'Card Type',
                'value_options' => array(
                		'Action' => 'Action',
                		'Deed' => 'Deed',
                		'Dude' => 'Dude',
                		'Goods' => 'Goods',
                		'Spell' => 'Spell',
                		'Outfit' => 'Outfit',
                		'Joker' => 'Joker',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'cost',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'cost',
            ),
            'attributes' => array(
            		'min' => '0',
            		'max' => '20',
            		'step' => '1',
            )
        ));
        $this->add(array(
            'name' => 'upkeep',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Upkeep',
            ),
            'attributes' => array(
            		'min' => '0',
            		'max' => '10',
            		'step' => '1',
            )
        ));
        $this->add(array(
            'name' => 'production',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Ghost Rock Production',
            ),
            'attributes' => array(
            		'min' => '0',
            		'max' => '10',
            		'step' => '1',
            )
        ));
        $this->add(array(
            'name' => 'bullets',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Bullets',
                'value_options' => array(
                		'' => 'None',
                		'0' => '0',
                		'1' => '1',
                		'2' => '2',
                		'3' => '3',
                		'4' => '4',
                		'5' => '5',
                		'?' => '?',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'bullet_bonus',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Bonus Bullets',
                'value_options' => array(
                		'' => 'None',
                		'1' => '1',
                		'2' => '2',
                		'3' => '3',
                		'4' => '4',
                		'5' => '5',
                		'?' => '?',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'draw_type',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Draw Type',
                'value_options' => array(
                		'' => 'No Bullets',
                		'Draw' => 'Draw',
                		'Stud' => 'Stud',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'influence',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Influence',
                'value_options' => array(
                		'' => 'None',
                		'1' => '1',
                		'2' => '2',
                		'3' => '3',
                		'4' => '4',
                		'5' => '5',
                		'?' => '?',
            		),
            ),
        ));
        $this->add(array(
            'name' => 'control',
            'type' => 'Zend\Form\Element\Number',
            'options' => array(
                'label' => 'Control Points',
            ),
            'attributes' => array(
            		'min' => '0',
            		'max' => '10',
            		'step' => '1',
            )
        ));
        $this->add(array(
            'name' => 'outfit',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Outfit',
                'empty_option' => 'Choose a faction',
                'value_options' => array(
										'' => 'No Faction',
										'Drifter' => 'Drifter',
                		'Law Dogs' => 'Law Dogs',
                		'The Sloane Gang' => 'The Sloane Gang',
                		'Morgan Cattle Co.' => 'Morgan Cattle Co.',
                		'The Fourth Ring' => 'The Fourth Ring',
            		),
            ),
        ));
         // submit button
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
       ));
    }
}
