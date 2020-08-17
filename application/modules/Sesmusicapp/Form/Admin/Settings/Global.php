<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmusicapp_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmusicapp_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesmusicapp.licensekey'),
    ));
    $this->getElement('sesmusicapp_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		if ($settings->getSetting('sesmusicapp.pluginactivated')) {
			/*if (!$settings->getSetting('sesmusicapp.changewelcome', 0)) {
				$this->addElement('Radio', 'sesmusicapp_changewelcome', array(
					'label' => 'Set Music App Page as Music Plugin\'s Welcome Page',
					'description' => 'Do you want to set the Music App page of this extension as the Welcome page of Professional Music Plugin on your site?',
					'onclick' => 'confirmChangeWelcomePage(this.value)',
					'multiOptions' => array(
							'1' => 'Yes',
							'0' => 'No',
					),
					'value' => $settings->getSetting('sesmusicapp.changewelcome', 0),
        ));
			}*/
			if (!$settings->getSetting('sesmusicapp.changelanding', 0)) {
				$this->addElement('Radio', 'sesmusicapp_changelanding', array(
            'label' => 'Set Music App Page as Landing Page',
            'description' => 'Do you want to set the Music App page of this extension as the Landing page of your site?',
            'onclick' => 'confirmChangeLandingPage(this.value)',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesmusicapp.changelanding', 0),
        ));
			}
			if (!$settings->getSetting('sesmusicapp.changememberhome', 0)) {
				$this->addElement('Radio', 'sesmusicapp_changememberhome', array(
            'label' => 'Set Music App Page as Member Home Page',
            'description' => 'Do you want to set the Music App page of this extension as the Member Home Page of your site?',
            'onclick' => 'confirmChangeHomePage(this.value)',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => $settings->getSetting('sesmusicapp.changememberhome', 0),
        ));
			}
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
