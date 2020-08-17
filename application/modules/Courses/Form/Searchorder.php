<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Searchorder.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Searchorder extends Engine_Form {
  public function init() {
    $this->setMethod('POST')
          ->setAction($_SERVER['REQUEST_URI'])
          ->setAttribs(array(
                'id' => 'manage_order_search_form',
                'class' => 'global_form_box',
          ));
    $this->addElement('Text', 'order_id', array(
        'label'=>'Order Id',
    ));
    $this->addElement('Text', 'buyer_name', array(
        'label'=>'Buyer Name',
    ));
		//date
		$subform = new Engine_Form(array(
			'description' => 'Order Date Ex (yyyy-mm-dd)',
			'elementsBelongTo'=> 'date',
			'decorators' => array(
				'FormElements',
				array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
				array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
			)
		));
		$subform->addElement('Text', 'date_to', array('placeholder'=>'to','autocomplete'=>'off'));
		$subform->addElement('Text', 'date_from', array('placeholder'=>'from','autocomplete'=>'off'));
		$this->addSubForm($subform, 'date');
		//order total
		$orderform = new Engine_Form(array(
			'description' => 'Price',
			'elementsBelongTo'=> 'order',
			'decorators' => array(
				'FormElements',
				array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
				array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
			)
		));
		$orderform->addElement('Text', 'order_min', array('placeholder'=>'min'));
		$orderform->addElement('Text', 'order_max', array('placeholder'=>'max'));
		$this->addSubForm($orderform, 'order');

		//commission
		$subform = new Engine_Form(array(
			'description' => 'Commission',
			'elementsBelongTo'=> 'commision',
			'decorators' => array(
				'FormElements',
				array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
				array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
			)
		));
		$subform->addElement('Text', 'commision_min', array('placeholder'=>'min'));
		$subform->addElement('Text', 'commision_max', array('placeholder'=>'max'));
		$this->addSubForm($subform, 'commision');

		$mutiOption[''] = 'Select';
    $paymentGateways = Engine_Api::_()->courses()->checkPaymentGatewayEnable();
      foreach($paymentGateways['methods'] as $key => $paymentmethod){
          $mutiOption[$paymentmethod] = $paymentmethod;
      }

		$this->addElement('Select', 'gateway', array(
        'label'=>'Gateway Type',
				'MultiOptions'=>$mutiOption,
        ));
		$this->addElement('Button', 'search', array(
      'label' => 'Search',
      'type' => 'submit',
    ));
    $this->addElement('Dummy','#loadingimgecourse', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" style="display:none;" id="courses-search-order-img" alt="Loading" />',
   ));
  }

}
