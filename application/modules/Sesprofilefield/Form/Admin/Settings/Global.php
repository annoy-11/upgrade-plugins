<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesprofilefield_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesprofilefield.licensekey'),
    ));
    $this->getElement('sesprofilefield_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesprofilefield.pluginactivated')) {

        $this->addElement('Radio', 'sesprofilefield_school', array(
            'label' => 'Show School Autocomplete',
            'description' => 'Choose from below option wich you want to populate autocomplete when member type school name.',
            'multiOptions' => array(
                1 => 'Using Google Autocomplete',
                0 => 'Using Admin and User added Schools'
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.school',1),
        ));

        $this->addElement('Radio', 'sesprofilefield_company', array(
            'label' => 'Show Company Autocomplete',
            'description' => 'Choose from below option wich you want to populate autocomplete when member type company name.',
            'multiOptions' => array(
                1 => 'Using Google Autocomplete',
                0 => 'Using Admin and User added Schools'
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.company',1),
        ));

        $this->addElement('Radio', 'sesprofilefield_authority', array(
            'label' => 'Show Authority Autocomplete',
            'description' => 'Choose from below option wich you want to populate autocomplete when member type authority name.',
            'multiOptions' => array(
                1 => 'Using Google Autocomplete',
                0 => 'Using Admin and User added Schools'
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.authority',1),
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
