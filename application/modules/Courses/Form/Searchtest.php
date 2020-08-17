<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Searchtest.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Searchtest extends Engine_Form {
  public function init() {
    $this->setMethod('POST')
          ->setAction($_SERVER['REQUEST_URI'])
          ->setAttribs(array(
                'id' => 'manage_test_search_form',
                'class' => 'global_form_box',
          ));
    $this->addElement('Text', 'title', array(
        'label'=>'Test Title',
    ));
		//date
		$subform = new Engine_Form(array(
			'description' => 'Given Date Ex (yyyy-mm-dd)',
			'elementsBelongTo'=> 'date',
			'decorators' => array(
				'FormElements',
				array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
				array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
			)
		));
		$subform->addElement('Text', 'date_to', array('placeholder'=>'to'));
		$subform->addElement('Text', 'date_from', array('placeholder'=>'from'));
		$this->addSubForm($subform, 'date');
		//order total
		$this->addElement('Select', 'is_passed', array(
        'label'=>'Status',
				'MultiOptions'=>array('1'=>'pass','fail'=>'fail'),
        ));
		$this->addElement('Button', 'search', array(
      'label' => 'Search',
      'type' => 'submit',
    ));
    $this->addElement('Dummy','#loadingimgecourse', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="courses-search-order-img" style="display:none;" alt="Loading" />',
   ));
  }

}
