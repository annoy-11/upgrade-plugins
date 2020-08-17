<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $seslinkedinApi = Engine_Api::_()->seslinkedin();
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "seslinkedin_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('seslinkedin.licensekey'),
    ));
    $this->getElement('seslinkedin_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  
    if (!$settings->getSetting('seslinkedin.changelanding', 0)) {
      $this->addElement('Radio', 'seslinkedin_changelanding', array(
          'label' => 'Set Landing Page',
          'description' => 'Do you want to set the Default Landing Page of this theme as Landing page of your website?  [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name "LP backup from SES - Professional Linkedin Clone".]  ',
          'onclick' => 'confirmChangeLandingPage(this.value)',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('seslinkedin.changelanding', 0),
      ));
    }

    if ($settings->getSetting('seslinkedin.pluginactivated')) {

    $this->addElement('Select', "seslinkedin_header_fixed_layout", array(
        'label' => 'Header Fixed?',
		'description' => 'Do you want Header fixed on your website?',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '2' => "No",
        ),
        'value' => Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_header_fixed_layout'),
    ));

    $this->addElement('Select', 'seslinkedin_popupsign', array(
            'label' => 'Enable Popup for Sign In & Sign Up',
            'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
                'onclick' => 'showPopup(this.value);',
            'value' => $settings->getSetting('seslinkedin.popupsign', '1'),
    ));

    $this->addElement('Select', 'seslinkedin_popup_enable', array(
            'label' => 'Open Sign In Popup Automatically',
            'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
            'multiOptions' => array(
                    1 => 'Yes',
                    0 => 'No'
            ),
            'onclick' => 'loginsignupvisiablity(this.value);',
            'value' => $settings->getSetting('seslinkedin.popup.enable', 1),
    ));

    $this->addElement('Text', 'seslinkedin_popup_day', array(
            'label' => 'Sign In Popup Visibility',
            'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
            'value' => $settings->getSetting('seslinkedin.popup.day', 5),
    ));

    $this->addElement('Select', 'seslinkedin_popupfixed', array(
        'label' => 'Allow to Close Sign In Popup',
        'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
        'multiOptions' => array(
            1 => 'No, do not allow to close popup',
            0 => 'Yes, allow to close popup'
        ),
        'value' => $settings->getSetting('seslinkedin.popupfixed', 0),
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
          'label' => 'Activate Your Theme',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
