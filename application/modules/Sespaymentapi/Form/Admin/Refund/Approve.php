<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approve.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespaymentapi_Form_Admin_Refund_Approve extends Engine_Form {

 public function init() {
 
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Approve Refund Request')
            ->setAttrib('id','sespaymentapi_ppayment_request')
						->setAttrib('description','Below, enter the payment to be release in response to this refund request.')
            ->setMethod("POST");
		
		$this->addElement('Text', 'total_amount', array(
      'label' => 'Total Amount',
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
      ),
      'readonly'=>'readonly',
    ));
    
		$this->addElement('Textarea', 'admin_message', array(
      'label' => 'Response Message',
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