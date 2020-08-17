<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Admin_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();
    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

      $this->addElement('Radio','verification',array(
        'label'=>'Allow to enable "Two Step Verification"',
        'description' => 'Do you want to allow users of your website to enable "Two Step verification" to login into your website?',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value'=>1
      ));
      
      $this->addElement('Text','resend',array(
        'label'=>'Resend Attempt Limit',
        'description' => 'Below, enter the limit which your user would be able to request to resend the OTP verification code. [Enter 0 if you want users to resend OTP code for unlimited times.]',
        'value' => 0,
        'validators' => array(
           array('Int', true),
        ),
      ));
      
      $this->addElement('Text','black_duration',array(
        'label'=>'Duration for Blocking Users',
        'description' => 'Enter the duration time (in seconds) after which users will be blocked when they reach the resend attempt limit. [For ex: 24 hours = 86400 seconds.]',
        'value' => 86400,
        'validators' => array(
           array('Int', true),
        ),
      ));
	  
	  $this->addElement('Text','reset_attempt',array(
        'label'=>'Duration for Reseting OTP Attempts',
        'description' => 'Enter the duration time (in seconds) after which the OTP resend limit is reseted. This setting will rest the number of attempts to resend OTP verification in setting "Resend Attempt Limit" above. [For ex: 24 hours = 86400 seconds.]',
        'value' => 86400,
        'validators' => array(
           array('Int', true),
        ),
      ));
      
    
  }
}
