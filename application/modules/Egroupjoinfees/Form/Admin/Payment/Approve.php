<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approve.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Egroupjoinfees_Form_Admin_Payment_Approve extends Engine_Form {
  protected $_groupId;
  public function getId() {
    return $this->_groupId;
  }
  public function setGroupId($group_id) {
    $this->_groupId = $group_id;
    return $this;
  }
  public function getGroupId() {
    return $this->_groupId;
  }
 public function init() {
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Approve Payment Request')
            ->setAttrib('id','sesgroup_ppayment_request')
						->setAttrib('description','Below, enter the payment to be release in response to this payment request.')
            ->setMethod("POST");
		
		$this->addElement('Text', 'total_amount', array(
          'label' => 'Total Amount',
					'readonly'=>'readonly',
    ));
		$this->addElement('Text', 'total_commission_amount', array(
          'label' => 'Total Commission Amount',
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
    $givenSymbol = Engine_Api::_()->egroupjoinfees()->getCurrentCurrency();
    $gateways = Engine_Api::_()->getDbtable('usergateways', 'egroupjoinfees')->getUserGateway(array("enabled"=>true,'group_id'=>$this->getGroupId(),'fetchAll'=>true));
    foreach($gateways as $gateway) {
      $gatewayObject = $gateway->getGateway();
      $supportedCurrencies = $gatewayObject->getSupportedCurrencies();
      if(!in_array($givenSymbol,$supportedCurrencies))
          continue;
        $options[$gateway->usergateway_id] = $gateway->title;
    }
    if(!empty($options) && count($options) > 0) {
      $this->addElement('Radio', 'gateway_id', array(
          'label' => 'Gateway Type',
          'required' => true,
          'multiOptions' => $options,
      ));
    }
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
