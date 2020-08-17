<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sespagenote_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.licensekey'),
    ));
    $this->getElement('sespagenote_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.pluginactivated')) {

        $this->addElement('Text', 'sespagenote_notes_manifest', array(
            'label' => 'Plural "pagenotes" Text in URL',
            'description' => 'Enter the text which you want to show in place of "pagenotes" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.notes.manifest', 'pagenotes'),
        ));
        $this->addElement('Text', 'sespagenote_note_manifest', array(
            'label' => 'Singular "pagenote" Text in URL',
            'description' => 'Enter the text which you want to show in place of "pagenote" in the URLs of this plugin.',
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.note.manifest', 'pagenote'),
        ));

        $this->addElement('Select', 'sespagenote_enable_report', array(
          'label' => 'Allow Report for Notes',
          'description' => 'Do you want to allow users to report notes on your website?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.enable.report', '1'),
        ));

        $this->addElement('Select', 'sespagenote_enable_favourite', array(
            'label' => 'Allow Favourite for Notes',
            'description' => 'Do you want to allow users to favourite notes on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.enable.favourite', '1'),
        ));

        $this->addElement('Select', 'sespagenote_enable_like', array(
            'label' => 'Allow Like for Notes',
            'description' => 'Do you want to allow users to like notes on your website?',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.enable.like', '1'),
        ));

        $this->addElement('Radio', "sespagenote_allow_share", array(
            'label' => 'Allow to Share Notes',
            'description' => "Do you want to allow users to share Notes of your website inside on your website and outside on other social networking sites?",
            'multiOptions' => array(
                '2' => 'Yes, allow sharing on this site and on social networking sites both.',
                '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
                '0' => 'No, do not allow sharing of Notes.',
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.allow.share', '1'),
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
