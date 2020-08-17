<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspoll_Form_Admin_Settings_Global extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
      ->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesbusinesspoll_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbusinesspoll.licensekey'),
    ));
    $this->getElement('sesbusinesspoll_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.pluginactivated')) {
	
		 $this->addElement('Text', 'polls_manifest', array(
          'label' => 'Plural "businesspolls" Text in URL',
          'description' => 'Enter the text which you want to show in place of "businesspolls" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesbusinesspoll.polls.manifest', 'businesspolls'),
      ));
      $this->addElement('Text', 'poll_manifest', array(
          'label' => 'Singular "businesspoll" Text in URL',
          'description' => 'Enter the text which you want to show in place of "businesspoll" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesbusinesspoll.poll.manifest', 'businesspoll'),
      ));
    $this->addElement('Text', 'maxoptions', array(
      'label' => 'Maximum Options',
      'description' => 'How many possible poll answers do you want to permit?',
      'value' => 15,
      'validators' => array(
        array('Int', true),
        array('LessThan', true, 100),
        new Engine_Validate_AtLeast(2),
      ),
    ));

    $this->addElement('Radio', 'canchangevote', array(
      'label' => 'Change Vote?',
      'description' => 'Do you want to permit your members to change their vote?',
      'multiOptions' => array(
        1 => 'Yes, members can change their vote.',
        0 => 'No, members cannot change their vote.',
      ),
      'value' =>  Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.canchangevote', 1),
    ));
      $this->addElement('Select', 'allow_favourite', array(
          'label' => 'Allow Favourite for Polls',
          'description' => 'Do you want to allow users to favourite Polls on your website?',
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.favourite', 1),
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
      ));
      $this->addElement('Radio', "allow_share", array(
          'label' => 'Allow to Share Polls',
          'description' => "Do you want to allow users to share Polls of your website inside on your website and outside on other social networking sites?",
          'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => ' Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Polls.',
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.share', 1),
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
