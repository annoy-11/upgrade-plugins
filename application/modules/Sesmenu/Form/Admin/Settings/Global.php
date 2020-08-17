<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
			
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmenu_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesmenu.licensekey'),
    ));
    $this->getElement('sesmenu_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesmenu.pluginactivated')) {

      $this->addElement('Text', 'sesmenu_plugin_more_content', array(
          'label' => 'Menu Items Count in Main Navigation',
          'description' => 'How many menu items do you want to show in the Main Navigation Menu of this plugin?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
                array('Int', true),
          ),
          'value' => $settings->getSetting('sesmenu.plugin.more.content',7),
      ));

      $this->addElement('Radio', 'sesmenu_plugin_enable', array(
          'label' => 'Enable Ultimate Menu Plugin?',
          'description' => 'Do you want to enable this plugin for Main Navigation Menu?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesmenu.plugin.enable', 1),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
	
    } else {
      $this->addElement('Button', 'submit', array(
        'label' => 'Activate Your Plugin',
        'type' => 'submit',
        'ignore' => true
      ));
    }
  }
}
