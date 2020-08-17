<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Orders.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Admin_Orders extends Engine_Form {
  public function init() {

    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'orders_form', 'class' => 'global_form_box'))->setMethod('GET');

    $this->addElement('Text', 'order_id', array(
        'label' => 'Order Id',
        'placeholder' => 'Enter Order Id',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

    $this->addElement('Text', 'buyer_name', array(
        'label' => 'Buyer Name',
        'placeholder' => 'Enter Buyer Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

    $this->addElement('Text', 'order_date', array(
        'placeholder' => 'Enter Order Date',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
/*
    $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategory(array('column_name' => '*'));
		$data[''] = 'Choose a Category';
      foreach ($categories as $category) {
        $data[$category['category_id']] = $category['category_name'];
				$categoryId = $category['category_id'];
      }
    if (count($categories) > 1) {
      $this->addElement('Select', 'category_id', array(
          'label' => "Category",
          'required' => true,
          'multiOptions' => $data,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
          'onchange' => "showSubCategory(this.value)",
      ));

    }
*/
    $this->addElement('Text', 'total_order', array(
        'label' => "Total Orders",
    ));

    $this->addElement('Text', 'commision', array(
        'label' => "Commission",
    ));
   	$mutiOption[''] = 'Select';
    $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
    $paymentGateways['methods'];
    $payArray = array('0'=>'Cash on Delivery', '1'=>'Cheque');
    foreach($paymentGateways['methods'] as $key => $paymentmethod){
        $paymentType = isset($payArray[$paymentmethod]) ? $payArray[$paymentmethod] : $paymentmethod;
        $mutiOption[$paymentType] = $paymentType;
    }
    $this->addElement('Select', 'gateway', array(
        'label' => "Gateway",
        'required' => true,
        'multiOptions' => $mutiOption,
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

    $this->addElement('Button', 'manage_product_search_form', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));


    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
