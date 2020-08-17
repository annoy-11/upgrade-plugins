<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approveform.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Admin_Claim_Approveform extends Engine_Form {

  public function init() {

    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('POST');
    $this->addElement('textarea', 'admin_comment', array(
			'label' => 'Message',
			'allowEmpty' => false,
			'required' => true,
    ));
    $this->addElement('Radio', 'approve_decline', array(
			'label' => 'Choose action for this request',
			'multiOptions'=>array(
				'accept'=>'Accept this claim request.',
				'decline'=>'Decline this claim request.',
			),
			'value'=>'accept',
    ));
    
				
       $this->addElement('Button', 'submit', array(
        'label' => 'Submit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

     $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		
		
  }

}