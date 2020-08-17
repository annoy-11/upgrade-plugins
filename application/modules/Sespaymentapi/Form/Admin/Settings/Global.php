<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespaymentapi
 * @package    Sespaymentapi
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespaymentapi_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
		
		if ($settings->getSetting('sespaymentapi.pluginactivated')) {
		
      $this->addElement('Text', 'sespaymentapi_refundduration', array(
        'label' => 'Request Refund Duration (Member subscription)',
        'description' => 'Enter number of days until which users on your website can request for refund after subscribing to other members’ profiles. (Note: The requested amount will be transferred to the users’ accounts and will be deducted from the member’s account whose profile was subscribed, so please make sure you transfer the amount after this number of days.)',
        'allowEmpty' => false,
        'required' => true,
        'validators' => array(
          array('GreaterThan', true, array(0)),
        ),
        'value' => $settings->getSetting('sespaymentapi.refundduration', 10),
      ));
      
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {

      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}