<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Settings.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Form_Admin_Package_Settings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
        ->setTitle('Packages for Allowing Business Creation Extension Settings')
        ->setDescription('From this “Packages for Allowing Business Creation Extension” settings you can choose to enable creation of businesses cased on the Package selected. You can create multiple package - both Free and Paid, with various features such that members can choose the packages which suits their requirements. Note: When you enable the business creation based on packages on your website, then the similar settings will not work from the member level settings.')
        ->setAttrib('class', 'global_form_popup');

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "sesbusinesspackage_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('sesbusinesspackage.licensekey'),
		));
		$this->getElement('sesbusinesspackage_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesbusinesspackage.pluginactivated')) {


      $this->addElement('Select', 'sesbusinesspackage_enable_package', array(
          'label' => 'Enable Package',
          'description' => 'Do you want to enable packages for creating Businesses on your website? (If you enable Packages, then users will always redirect to the Package selection business, even you have chosen to open the Business Creation form in Popup.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'enable_package(this.value)',
          'value' => $settings->getSetting('sesbusinesspackage.enable.package', 0),
      ));

      $information = array('description' => 'Package Description', 'featured' => 'Featured (You can choose to auto-featured businesses in each package.)', 'sponsored' => 'Sponsored (You can choose to auto-sponsored businesses in each package.)', 'verified' => 'Verified (You can choose to auto-verified businesses in each package.)', 'hot' => 'Hot (You can choose to auto-hot businesses in each package.)', 'custom_fields' => 'Custom Profile Fields');

      $this->addElement('MultiCheckbox', 'sesbusinesspackage_package_info', array(
          'label' => 'Package Inclusions',
          'description' => 'Select from below the features that you want to include in the Packages for creating businesses on your website. If you select any option, then that option will be displayed to your users when they try to create a business. If you simply do not want to show any feature in the package at user end, then do not select it from here.',
          'multiOptions' => $information,
          'value' => $settings->getSetting('sesbusinesspackage.package.info', array_keys($information)),
      ));

      $this->addElement('Radio', 'sesbusinesspackage_payment_mod_enable', array(
          'label' => 'Activate Businesses',
          'description' => "Do you want to enable businesses immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Business immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has completed successfully.'
          ),
          'value' => $settings->getSetting('sesbusinesspackage.payment.mod.enable', 'all'),
      ));

      $this->addElement('Radio', 'sesbusinesspackage_package_style', array(
          'label' => 'Package Alignment',
          'description' => "Choose the alignment for packages on Package Selection page. This setting will only effect the new packages. Existing package will show in Horizontal View only.",
          'multiOptions' => array(
              '0' => 'Horizontal',
              '1' => 'Vertical',
          ),
          'value' => $settings->getSetting('sesbusinesspackage.package.style', 1),
      ));

      // Buttons
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Settings',
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array('ViewHelper')
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
