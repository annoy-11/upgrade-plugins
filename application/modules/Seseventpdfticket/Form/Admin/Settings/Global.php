<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventpdfticket
 * @package    Seseventpdfticket
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventpdfticket_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		
		$this->addElement('Text', "seseventpdfticket_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('seseventpdfticket.licensekey'),
		));
		$this->getElement('seseventpdfticket_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
		if ($settings->getSetting('seseventpdfticket.pluginactivated')) {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}