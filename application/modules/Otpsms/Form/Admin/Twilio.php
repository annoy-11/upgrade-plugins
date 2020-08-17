<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Twilio.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Admin_Twilio extends Engine_Form
{
  public function init()
  {
    parent::init();
    // My stuff
    $this
      ->setTitle('Integration with Twilio')
      ->setDescription('Fill up the form below to integrate twilio services to enable OTP on your site.');
      
       $this->addElement('Text','clientId',array(
          'label'=>'Account SID',
		  'description'=> 'Enter the Account SID below.',
          'required'=>true,
          'allowEmpty'=>false,
        ));
       $this->addElement('Text','clientSecret',array(
            'label'=>'Auth Token',
			'description'=> 'Enter the Auth Token below.',
            'required'=>true,
            'allowEmpty'=>false,
          ));
        $this->addElement('Text','phoneNumber',array(
              'label'=>'Phone Number',
              'description' => 'Enter the phone number that you have purchased from Twilio. [Note: The number should start with country code & should not have any space or any other special character anywhere in the number. For Example: +3456XXXXXXX.]',
              'required'=>true,
              'allowEmpty'=>false,
            ));
        $this->addElement('Radio','enabled',array(
              'label'=>'Enable',
			  'description'=> 'Do you want to enable Twilio Services?',
              'multiOptions'=>array('1'=>'Yes','0'=>'No'),
              'required'=>true,
              'allowEmpty'=>false,
              'value'=>0
            ));
        $this->addElement('Button','submit',array(
              'label'=>'Save Changes',
              'type'=>'submit',
              'ignore'=>true
            ));
    
  }
}
