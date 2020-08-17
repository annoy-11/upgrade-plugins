<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-10-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

class Sessiteiframe_Form_Admin_Global extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		
		$this->addElement('Text', "sessiteiframe_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sessiteiframe.licensekey'),
		));
		$this->getElement('sessiteiframe_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
    if ($settings->getSetting('sessiteiframe.pluginactivated')) {
      //Add submit button
      $this->addElement('Button', 'submit', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true
      ));
    } else {
      
      $this->addElement('Radio', "sessiteiframe_updatecode", array(
      'label' => 'Automatically Add Code',
      'description' => 'This plugin requires a small change in 1 SE file at path: ‘application/modules/Core/layouts/scripts/default.tpl’ . Do you want this plugin to automatically add the code to the SE file or will you add the code later manually in the file yourself?',
      'allowEmpty' => true,
      'required' => false,
      'multiOptions'=>array('1'=>'Yes, automatically add the code.','0'=>'No, I will add the code manually later.'),
      'value' => $settings->getSetting('sessiteiframe.updatecode',1),
		));
		$this->getElement('sessiteiframe_updatecode')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
       
      //Add submit button
      $this->addElement('Button', 'submit', array(
        'label' => 'Activate Your Plugin',
        'type' => 'submit',
        'ignore' => true
      ));
    }
  }
}
