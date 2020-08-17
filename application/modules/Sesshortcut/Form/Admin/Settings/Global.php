<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshortcut_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesshortcut_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesshortcut.licensekey'),
    ));
    $this->getElement('sesshortcut_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
	if ($settings->getSetting('sesshortcut.pluginactivated')) {

      $this->addElement('Radio', 'sesshortcut_enableshortcut', array(
        'label' => 'Enable "Add to Shortcuts"',
        'description' => 'Do you want to enable members on your website to add different content, another member profiles and activity feeds (dependent on "Advanced News & Activity Feeds Plugin") to their Shortcuts? If you choose Yes, then members on your website will see an "Add to Shortcuts" button on the profile pages of various content as configured by you from the Admin Panel >> Layout Editor.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1),
      ));

      $this->addElement('Radio', 'sesshortcut_enablepintotop', array(
        'label' => 'Enable "Pin To Top"',
        'description' => 'Do you want to enable members on your website to be able to pin the shortcuts to the top of shortcuts menu? If you choose Yes, then the "Pin to Top" option will be shown in Shortcuts widget and the pinned shortcut will show on top of this widget.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enablepintotop', 1),
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
