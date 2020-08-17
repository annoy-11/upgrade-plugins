<?php

class Sesvideosell_Form_Admin_Payment_Approve extends Engine_Form {

  public function init() {
 
    $this->setTitle('Make Payment')
        ->setDescription('Click on the "Make Payment" button below to release the payment of this video sales to the owner of this video.')
        ->setAttrib('description','Click on the "Make Payment" button below to release the payment of this video sales to the owner of this video.')
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