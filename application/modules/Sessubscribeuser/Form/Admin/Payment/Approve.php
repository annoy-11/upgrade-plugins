<?php

class Sessubscribeuser_Form_Admin_Payment_Approve extends Engine_Form {

 public function init() {
 
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('Approve Payment Request')
						->setAttrib('description','Below, enter the payment to be release in response to this payment request.')
            ->setMethod("POST");
		
		$this->addElement('Text', 'remaining_payment', array(
          'label' => 'Total Amount',
					'readonly'=>'readonly',
    ));

// 		$this->addElement('Text', 'release_amount', array(
//           'label' => 'Amount to Release',
// 					'allowEmpty' => false,
// 					'required' => true,
// 					'validators' => array(
// 								array('GreaterThan', true, array(0)),
// 						)
//     ));
		$this->addElement('Button', 'submit', array(
        'label' => 'Make Payment',
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