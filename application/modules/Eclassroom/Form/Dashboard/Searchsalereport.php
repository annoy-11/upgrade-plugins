<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Searchsalesreport.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_Searchsalereport extends Engine_Form {
 public function init() {
    if (Engine_Api::_()->core()->hasSubject('classroom'))
      $classroom = Engine_Api::_()->core()->getSubject();
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('')
            ->setAttrib('id', 'eclassroom_search_form_sale_report')
						->setAttrib('class', 'global_form_box')
            ->setMethod("GET")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
		$this->addElement('Select', 'type', array(
          'label' => 'Duration',
          'multiOptions' => array('month'=>'Month Wise','day'=>'Day Wise'),
					'value'=>'day',
    ));
		$this->addElement('Hidden', 'csv', array(
          'value'=>'',
					'order'=>10000
    ));
		$this->addElement('Hidden', 'excel', array(
          'value'=>'',
					'order'=>10001
    ));
		$this->addElement('Text', 'startdate', array(
        'label'=>'Start Date',
				'style'=>'width:70px;'
    ));
		$this->addElement('Text', 'enddate', array(
        'label'=>'End Date',
				'style'=>'width:70px;'
    ));
		// Buttons
    $this->addElement('Button', 'submit_form_sales_report', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
 }
}
