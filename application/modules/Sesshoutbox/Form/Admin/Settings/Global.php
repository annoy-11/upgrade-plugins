<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesshoutbox_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesshoutbox.licensekey'),
    ));
    $this->getElement('sesshoutbox_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesshoutbox.pluginactivated')) {
      //Add submit button
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
