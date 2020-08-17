<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Paymentrequest.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespaymentapi_Form_Refundrequest extends Engine_Form {

  public function init() {
 
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    
    $this->setTitle('Refund Payment Request')
        ->setDescription('Enter the your message below form and click on "Send" button to send the refund request to website administrators. If you have subscribe any recurring profile, then it will cancel after website administrators complte your request.')
            ->setAttrib('id','sespaymentapi_ppayment_request')
            ->setMethod("POST");
		
		$this->addElement('Text', 'total_amount', array(
      'label' => 'Total Amount',
      'readonly'=>'readonly',
    ));

		$this->addElement('Textarea', 'user_message', array(
          'label' => 'Message',
    ));
		$this->addElement('Button', 'submit', array(
        'label' => 'Send',
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