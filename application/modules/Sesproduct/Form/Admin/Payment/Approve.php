<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approve.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_Payment_Approve extends Engine_Form {


  protected $_storeId ;
  public function getStoreId() {
    return $this->_storeId;
  }

  public function setStoreId($store_id) {
    $this->_storeId = $store_id;
    return $this;
  }
 public function init() {
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Approve Payment Request')
            ->setAttrib('id','sesproduct_ppayment_request')
						->setAttrib('description','Below, enter the payment to be release in response to this payment request.')
            ->setMethod("POST");

		$this->addElement('Text', 'total_amount', array(
          'label' => 'Total Amount',
					'readonly'=>'readonly',
    ));
		$this->addElement('Text', 'total_tax_amount', array(
          'label' => 'Total Store Tax Amount',
					'readonly'=>'readonly',
    ));
		$this->addElement('Text', 'total_commission_amount', array(
          'label' => 'Total Commission Amount',
					'readonly'=>'readonly',
    ));
     $this->addElement('Text', 'total_shipping_amount', array(
         'label' => 'Total Shipping Amount',
         'readonly'=>'readonly',
     ));
     $this->addElement('Text', 'total_admintax_amount', array(
         'label' => 'Total Admin Tax Amount',
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
    $gateways = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array("enabled"=>true,'store_id'=>$this->getStoreId(),'fetchAll'=>true));
    foreach($gateways as $gateway) {
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
