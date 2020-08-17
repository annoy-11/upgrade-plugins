<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Searchorder.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Searchorder extends Engine_Form {

  public function init() {

    $this
            ->setMethod('POST')
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
		$this->addElement('Text', 'email', array(
        'label'=>'Email',
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
		$subform->addElement('Text', 'date_to', array('placeholder'=>'to','autocomplete' => 'off'));
		$subform->addElement('Text', 'date_from', array('placeholder'=>'from','autocomplete' => 'off'));
		$this->addSubForm($subform, 'date');

		//order total
		$orderform = new Engine_Form(array(
			'description' => 'Order Total',
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
        $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
        $paymentGateways['methods'];
        $payArray = array('0'=>'Cash on Delivery', '1'=>'Cheque');
        foreach($paymentGateways['methods'] as $key => $paymentmethod){
            $paymentType = isset($payArray[$paymentmethod]) ? $payArray[$paymentmethod] : $paymentmethod;
            $mutiOption[$paymentType] = $paymentType;
        }

		$this->addElement('Select', 'gateway', array(
        'label'=>'Gateway',
				'MultiOptions'=>$mutiOption
        ));
		$this->addElement('Button', 'search', array(
      'label' => 'Search',
      'type' => 'submit',
    ));
    $this->addElement('Dummy','loading-img-sesproduct', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="sesproduct-search-order-img" style="display:none;" alt="Loading" />',
   ));
  }

}
