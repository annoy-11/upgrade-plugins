<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Searchdonationreport.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Dashboard_Searchdonationreport extends Engine_Form {

 public function init() {

    if (Engine_Api::_()->core()->hasSubject('crowdfunding'))
      $crowdfunding = Engine_Api::_()->core()->getSubject();

    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('')
            ->setAttrib('id', 'sescrowdfunding_search_form_sale_report')
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
        'label' => 'Search Report',
        'type' => 'submit',
        'ignore' => true
    ));
 }
}
