<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Donate.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Donate extends Engine_Form {

  public function init() {

    $crowdfunding_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('crowdfunding_id', null);
    $gateway_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('gateway_id', null);
    $paymentGateways = Engine_Api::_()->sescrowdfunding()->checkPaymentGatewayEnable();
    $this->setTitle('Crowdfunding Donation')
          ->setDescription('Enter your Donation Amount.')
          ->setAttrib('name', 'sescrowdfundings_donate')
          ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
          ->setMethod('POST');

    $this->addElement('Text', 'price', array(
      'label' => 'Donation Amount',
      'description' => "Enter your Donation Amount which you want to donate in this crowdfunding.",
      'allowEmpty' => false,
      'required' => true,
      'placeholder' => "0.00",
    ));
    if(!$paymentGateways['noPaymentGatewayEnableByAdmin']) {
        $this->addElement('Radio', 'payment_type', array(
            'label' => 'Pay with',
            'description' => "Select Gateway",
            'multiOptions' =>$paymentGateways['methods'],
        ));
    }
    $this->addElement('Button', 'submit', array(
      'label' => 'Donate',
      'type' => 'submit',
      'onclick' => 'this.form.submit();',
    ));

  }
}
