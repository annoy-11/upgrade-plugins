<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filter.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Admin_Filter extends Engine_Form
 {

 	public function init() 
 	{
      $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');


    $this->addElement('Text', 'name', array(
        'label' => 'Petition Title',
        'placeholder' => 'Enter Petition Title',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

     $this->addElement('Text', 'owner_name', array(
        'label' => 'Owner Name',
        'placeholder' => 'Enter Owner Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

      $this->addElement('Text', 'creation_date', array(
        'label' => 'Creation Date Ex(2015-03-02)',
        'placeholder' => 'Enter Creation Date',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
          //after uncomment this line

         $categories = Engine_Api::_()->getDbtable('categories', 'epetition')->getCategory(array('column_name' => '*'));
		$data[''] = 'Choose a Category';
      foreach ($categories as $category) {
        $data[$category['category_id']] = $category['category_name'];
				$categoryId = $category['category_id'];
      }
  
      $this->addElement('Select', 'category_id', array(
          'label' => "Category",
          'required' => true,
          'multiOptions' => $data,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
      ));

         $this->addElement('Select', 'offtheday', array(
        'label' => "Of the Day",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

           $this->addElement('Select', 'sponsored', array(
        'label' => "Sponsored",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

             $this->addElement('Select', 'featured', array(
        'label' => "Featured",
        'required' => true,      'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

         $this->addElement('Select', 'status', array(
        'label' => "Status",
        'required' => true,
        'multiOptions' => array("" => 'Select', "0" => "Published", "1" => "Draft"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

          $this->addElement('Select', 'verified', array(
        'label' => "Verified",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));


		$this->addElement('Select', 'is_approved', array(
			'label' => "Approved",
			'required' => true,
			'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
			'decorators' => array(
			'ViewHelper',
				array('Label', array('tag' => null, 'placement' => 'PREPEND')),
				array('HtmlTag', array('tag' => 'div'))
			),
		));

		 $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));

		


 	}
}

?>