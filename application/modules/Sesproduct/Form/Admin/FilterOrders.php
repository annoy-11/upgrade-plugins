<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FilterOrders.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_FilterOrders extends Engine_Form {

  public function init() {

    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

      $this->addElement('Text', 'owner_name', array(
          'label' => 'Owner Name',
          'placeholder' => 'Enter Owner Name',
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
      ));

      $this->addElement('Text', 'store_name', array(
        'label' => 'Store Name',
        'placeholder' => 'Enter Store Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));

      $subform = new Engine_Form(array(
          'description' => 'Order Date Ex (yyyy-mm-dd)',
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


      $this->addElement('Text', 'billing_name', array(
        'label' => 'Billing Name',
        'placeholder' => 'Billing Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Text', 'shipping_name', array(
        'label' => 'Shipping Name',
        'placeholder' => 'Shipping Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
      $subformAmount = new Engine_Form(array(
          'description' => 'Order Amount',
          'elementsBelongTo'=> 'amount',
          'decorators' => array(
              'FormElements',
              array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
              array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
          )
      ));
      $subformAmount->addElement('Text', 'order_min', array('placeholder'=>'min'));
      $subformAmount->addElement('Text', 'order_max', array('placeholder'=>'max'));
      $this->addSubForm($subformAmount, 'amount');

      $subformCommission = new Engine_Form(array(
          'description' => 'Commission Amount',
          'elementsBelongTo'=> 'commission',
          'decorators' => array(
              'FormElements',
              array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
              array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
          )
      ));
      $subformCommission->addElement('Text', 'commission_min', array('placeholder'=>'min'));
      $subformCommission->addElement('Text', 'commission_max', array('placeholder'=>'max'));
      $this->addSubForm($subformCommission, 'amount');


       $this->addElement('Select', 'status', array(
        'label' => 'Status',
        'multiOptions' => array(
            ''=>'',
          'approval_pending'=>'Approval Pending',
            'pending'=>'Payment Pending',
            'prcessing'=>'Processing',
            'hold'=>'On Hold',
            'fraud'=>'Fraud',
            'complete'=>'Completed',
            'cancelled'=>'Cancelled',

        ),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    // Gateways
     $gatewayOptions = array();
     $gatewayOptions[] = '';
    $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
    foreach($paymentGateways['methods'] as $gateway ) {
        if($gateway == 0) {
            $gatewayOptions['Cash On Deleivery'] = 'Cash On Deleivery';
        } if($gateway == 1) {
             $gatewayOptions['Check'] = 'Cheque';
        }if( $gateway == 'paypal') {
            $gatewayOptions['Paypal'] = 'Paypal';
        }if($gateway == 'stripe') {
            $gatewayOptions['stripe'] = 'Stripe';
        }
    }
    $this->addElement('Select', 'gateway', array(
          'label' => 'gateway',
          'multiOptions' => $gatewayOptions,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
      ));
    $this->addElement('Text', 'cheque_number', array(
        'label' => 'Cheque Number',
        'placeholder' => 'Enter Cheque Number',
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

    $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));
    $this->addElement('Hidden', 'order_direction', array(
        'order' => 10002,
    ));

    $this->addElement('Hidden', 'order_id', array(
        'order' => 10003,
    ));

    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
