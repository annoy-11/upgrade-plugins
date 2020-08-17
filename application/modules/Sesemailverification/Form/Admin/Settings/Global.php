<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesemailverification_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesemailverification.licensekey'),
    ));
    $this->getElement('sesemailverification_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesemailverification.pluginactivated')) {

	    $this->addElement('Text', 'sesemailverification_tipmessage', array(
        'label' => 'Tip Message',
        'description' => 'Enter the text for the tip which will be shown to users for getting their emails verified, until they verify their emails on your website.',
        'value' => $settings->getSetting('sesemailverification.tipmessage', 'We’re almost there! We just need you to verify and confirm your email address by clicking the link we sent. Go to Your inbox or %s.'),
	    ));

	    $this->addElement('Text', 'sesemailverification_tipmessage1', array(
        'label' => 'Text for %s in tip',
        'description' => 'Enter the text to be entered for %s in the tip. %s will be the text for link to resend the verification email.',
        'value' => $settings->getSetting('sesemailverification.tipmessage1', 'Resend the Verification Link.'),
	    ));


      $this->addElement('Radio', 'sesemailverification_show', array(
        'label' => 'Display Close Button?',
        'description' => 'Do you want to show close button on email verification tip enable users to see a close button on email verification tip using which they can close the verification reminder tip?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onclick' => 'showHideShow(this.value);',
        'value' => $settings->getSetting('sesemailverification.show', 1),
	    ));

	    $this->addElement('Text', 'sesemailverification_day', array(
        'label' => 'Email Verification Tip Visibility',
        'description' => 'After how many days will the email verification tip be visible to users once closed? [Enter ‘0’, if you want email verification tip to be visible each time to users visit your website.]',
        'value' => $settings->getSetting('sesemailverification.day', 5),
	    ));

      $this->addElement('Text', "sesemailverification_tipbgcolor", array(
        'label' => 'Tip Background Color',
        'description' => 'Enter the background color of the tip.',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $settings->getSetting('sesemailverification.tipbgcolor', '#fe2e26'),
      ));

      $this->addElement('Text', "sesemailverification_tipfontcolor", array(
        'label' => 'Tip Font Color',
        'description' => 'Enter the font color of the tip.',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $settings->getSetting('sesemailverification.tipfontcolor','#fff'),
      ));


      $this->addElement('Radio', 'sesemailverification_autoaccsuspend', array(
        'label' => 'Auto Account Suspend',
        'description' => 'Do you want to auto suspend the account of users who have not verified their email on your website? If you choose Yes, then you will be able to choose number of days after which their accounts will be suspended (Un-Approved) from the date of their signup on your website.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onclick' => 'showHideShowAcco(this.value);',
        'value' => $settings->getSetting('sesemailverification.autoaccsuspend', 0),
	    ));

	    $this->addElement('Text', 'sesemailverification_autoaccsuspendday', array(
        'label' => 'Auto Suspend Duration',
        'description' => 'Enter the number of days after which users accounts will be suspended (disabled) if they do not verify their emails from the date of their signup on your website. Once users are Un-Approved, you can Approve them from the Manage >> Members >> Edit Member >> Approve setting.',
        'value' => $settings->getSetting('sesemailverification.autoaccsuspendday', 20),
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
