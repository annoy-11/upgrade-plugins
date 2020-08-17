<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesletteravatar_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

	if ($settings->getSetting('sesletteravatar.pluginactivated')) {

      $this->addElement('Radio', 'sesletteravatar_replacephoto', array(
        'label' => 'Replace Default Photos with Letter Avatars',
        'description' => 'Do you want to replace the default member profile photo (SocialEngine or any other plugin) and replace that with the letter avatars from this plugin? If you choose yes, then if a user remove its profile photo, then also he will see the letter avatar as default photo on your website. If you choose No, then you can manually create letter avatars for users without photo from the Tip shown on the top of this page.',
        'multiOptions' => array(
            '1' => 'Yes',
            0 => "No",
        ),
        'value' => $settings->getSetting('sesletteravatar.replacephoto', 1),
      ));

      $this->addElement('Radio', 'sesletteravatar_letters', array(
        'label' => 'Letter Avatar Creation',
        'description' => 'Choose from below how many letters you want in the avatars of members on your website.',
        'multiOptions' => array(
            '1' => 'First Letter of First Name and Last Name',
            '2' => 'First Letter of First Name only',
            '3' => "Few letters of First Name or Username"
        ),
        'onchange' => "showHide(this.value)",
        'value' => $settings->getSetting('sesletteravatar.letters', 1),
      ));

      $this->addElement('Text', "sesletteravatar_countchar", array(
        'label' => 'Letter Avatar Count',
        'description' => 'Enter the number of letters you want in the letter avatars of members on your website. This setting will affect the First Name of a member, but if he does not have the First Name than letter from Username will be taken.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesletteravatar.countchar', 1),
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
