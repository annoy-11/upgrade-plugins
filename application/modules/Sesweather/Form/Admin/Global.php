<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesweather_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesweather.licensekey'),
    ));
    $this->getElement('sesweather_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesweather.pluginactivated')) {

      $this->addElement('Text', "sesweather_apikey", array(
          'label' => 'API Key',
          'description' => 'Enter the API key below to display weather on your website. (How to get API Key? Read the FAQ here.)',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sesweather.apikey'),
      ));
      $this->getElement('sesweather_apikey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', 'sesweather_tempunit', array(
          'label' => 'Unit for Temperature',
          'description' => 'Choose from below the unit for Temperature to be shown in various widgets of this plugin.',
          'multiOptions' => array(
              1 => 'Celsius',
              0 => 'Fahrenheit'
          ),
          'value' => $settings->getSetting('sesweather.tempunit', 1),
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
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
