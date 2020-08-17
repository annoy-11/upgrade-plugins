<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Peopleacted.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Form_Admin_Peopleacted extends Engine_Form
{
  public function init()
  {	
				
		$this->addElement('MultiCheckbox', "search_type", array(
			 'label' => "Choose from below the action that you want to show in this widget.",
			'multiOptions' => array(
					'Like' => 'People who Liked this Question',
					'Fav' => 'People who added this Question as Favourite',
					'Follow' => 'People who Followed this Question',
			),
    ));
		
	
	$this->addElement('Dummy', "dummy4", array(
			 'label' => "<span style='font-weight:bold;'>\"People Who Liked the current Question\" Block</span>",
    ));
	
		$this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
	
		$this->addElement('Text', "Like_order", array(
		 'label' => "Order of this Block.",
			'value' => '1',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "Like_label", array(
			'label' => 'Title of this Block.',
			'value' => 'People Who Liked This Question',
    ));
		$this->addElement('Text', "Like_limitdata", array(
			'label' => 'Enter the number of user\'s to be shown. After this number option to view more user\'s in popup will be shown.',
			'value' => '10',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
	
		$this->addElement('Dummy', "dummy5", array(
			 'label' => "<span style='font-weight:bold;'>\"People who are Follow in current Question\" Block</span>",
    ));
	
		$this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
		$this->addElement('Text', "Follow_order", array(
			'label' =>'Order of this Block.',
			'value' => '2',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "Follow_label", array(
			'label' => 'Title of this Block.',
			'value' => 'People who are Follow This Question',
    ));
		$this->addElement('Text', "Follow_limitdata", array(
			'label' => 'Enter the number of user\'s to be shown. After this number option to view more user\'s in popup will be shown.',
			'value' => '10',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
	
		$this->addElement('Dummy', "dummy6", array(
			 'label' => "<span style='font-weight:bold;'>\"People who added This Question as Favourite\" Block</span>",
    ));
	
		$this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
		$this->addElement('Text', "Fav_order", array(
			'label' =>'Order of this Block.',
			'value' => '3',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
		$this->addElement('Text', "Fav_label", array(
			'label' => 'Title of this Block.',
			'value' => 'People Who Favourite This',
    ));
		$this->addElement('Text', "Fav_limitdata", array(
			'label' => 'Enter the number of user\'s to be shown. After this number option to view more user\'s in popup will be shown.',
			'value' => '10',
			'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    
    
    
  }
}
?>