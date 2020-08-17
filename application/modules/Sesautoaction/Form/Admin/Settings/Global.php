<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesautoaction_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesautoaction.licensekey'),
    ));
    $this->getElement('sesautoaction_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesautoaction.pluginactivated')) {

        $this->addElement('Radio', 'sesautoaction_enbouautoaction', array(
            'label' => 'Enable Bot Auto Actions',
            'description' => 'Do you want to enable Bots to perform various actions on your website? If you choose Yes, then you can configure Bots from "Manage Bots" section and actions to be performed from "Manage Bot AUto Actions" section of this plugin.',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.enbouautoaction', 1),
        ));

        $this->addElement('Radio', 'sesautoaction_ennewsignupaction', array(
            'label' => 'Enable New Signup Actions',
            'description' => 'Do you want to enable Newly Signed up Users to perform various actions on your website? If you choose Yes, then you can configure actions to be performed from "Manage New Signup Actions" section of this plugin.',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.ennewsignupaction', 1),
        ));

        $this->addElement('Radio', 'sesautoaction_enautofriendship', array(
            'label' => 'Enable Auto Friendships',
            'description' => 'Do you want to enable auto friendship on your website? If you choose Yes, then you can configure bots/users who will be auto friends with the new signed up users from "Manage Auto Friendships" section of this plugin.',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesautoaction.enautofriendship', 1),
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
