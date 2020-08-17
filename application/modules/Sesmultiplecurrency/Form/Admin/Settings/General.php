<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: General.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmultiplecurrency_Form_Admin_Settings_General extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmultiplecurrency_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmultiplecurrency.licensekey'),
    ));
    $this->getElement('sesmultiplecurrency_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (!$settings->getSetting('sesmultiplecurrency.defaultcurrency', 0)) {
       $this->addElement('Select', 'sesmultiplecurrency_defaultcurrency', array(
        'label' => 'Default Currency',
        'description' => 'Choose the default currency on your website. (Note: This is a one time setting, so you would not be able to change that later. If you wish to change the default currency in future, then please contact our support team.)',
        'multiOptions' => Engine_Api::_()->sesmultiplecurrency()->getSupportedCurrency(),
        'value' => $settings->getSetting('sesmultiplecurrency.defaultcurrency','USD'),
			));
    }

    if ($settings->getSetting('sesmultiplecurrency.pluginactivated')) {
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
