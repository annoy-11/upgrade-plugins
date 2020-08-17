<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approve.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Admin_Payment_Approve extends Engine_Form {
  protected $_userId ;
  public function getUserId() {
    return $this->_userId;
  }
  public function setUserId($user_id) {
    $this->_userId = $user_id;
    return $this;
  }
 public function init() {
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Approve Payment Request')
            ->setAttrib('id','sescrowdfunding_ppayment_request')
						->setAttrib('description','Below, enter the payment to be release in response to this payment request.')
            ->setMethod("POST");

		$this->addElement('Text', 'total_amount', array(
          'label' => 'Total Amount',
					'readonly'=>'readonly',
    ));

		$this->addElement('Text', 'remaining_amount', array(
          'label' => 'Total Remaining Amount',
					'readonly'=>'readonly',
    ));
		$this->addElement('Text', 'requested_amount', array(
          'label' => 'Requested Amount',
					'readonly'=>'readonly',
    ));
		$this->addElement('Textarea', 'user_message', array(
          'label' => 'Requested Message',
					'readonly'=>'readonly',
    ));
		$this->addElement('Text', 'release_amount', array(
          'label' => 'Amount to Release',
					'allowEmpty' => false,
					'required' => true,
					'validators' => array(
								array('GreaterThan', true, array(0)),
						)
    ));
		$this->addElement('Textarea', 'admin_message', array(
          'label' => 'Response Message',
    ));
    $givenSymbol = Engine_Api::_()->sesbasic()->getCurrentCurrency();
     $gateways = Engine_Api::_()->getDbtable('usergateways', 'sesbasic')->getUserGateway(array("enabled"=>true,'user_id'=>$this->getUserId(),'fetchAll'=>true));
    foreach($gateways as $gateway) {
        $gatewayObject = $gateway->getGateway(array(''));
        $supportedCurrencies = $gatewayObject->getSupportedCurrencies();
        if(!in_array($givenSymbol,$supportedCurrencies))
          continue;
        $options[strtolower($gateway->title)] = $gateway->title;
    }
    $this->addElement('Radio', 'gateway_type', array(
        'label' => 'Gateway Type',
        'required' => true,
        'multiOptions' => $options,
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Approve',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
				'onclick'=>'parent.Smoothbox.close();',
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
 }
}
