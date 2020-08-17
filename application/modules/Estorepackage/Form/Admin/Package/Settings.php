<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Settings.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_Form_Admin_Package_Settings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Packages for Allowing Store Creation Extension Settings')
            ->setDescription('From this “Packages for Allowing Store Creation Extension” settings you can choose to enable creation of stores cased on the Package selected. You can create multiple package - both Free and Paid, with various features such that members can choose the packages which suits their requirements. Note: When you enable the store creation based on packages on your website, then the similar settings will not work from the member level settings.')
            ->setAttrib('class', 'global_form_popup');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)', $supportTicket, $sesSite);
    $this->addElement('Text', "estorepackage_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('estorepackage.licensekey'),
    ));
    $this->getElement('estorepackage_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('estorepackage.pluginactivated')) {


      $this->addElement('Select', 'estorepackage_enable_package', array(
          'label' => 'Enable Package',
          'description' => 'Do you want to enable packages for creating Stores on your website? (If you enable Packages, then users will always redirect to the Package selection store, even you have chosen to open the Page Creation form in Popup.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'enable_package(this.value)',
          'value' => $settings->getSetting('estorepackage.enable.package', 0),
      ));

      $information = array('description' => 'Package Description', 'featured' => 'Featured (You can choose to auto-featured stores in each package.)', 'sponsored' => 'Sponsored (You can choose to auto-sponsored stores in each package.)', 'verified' => 'Verified (You can choose to auto-verified stores in each package.)', 'hot' => 'Hot (You can choose to auto-hot stores in each package.)', 'custom_fields' => 'Custom Profile Fields');

      $this->addElement('MultiCheckbox', 'estorepackage_package_info', array(
          'label' => 'Package Inclusions',
          'description' => 'Select from below the features that you want to include in the Packages for creating stores on your website. If you select any option, then that option will be displayed to your users when they try to create a store. If you simply do not want to show any feature in the package at user end, then do not select it from here.',
          'multiOptions' => $information,
          'value' => $settings->getSetting('estorepackage.package.info', array_keys($information)),
      ));

      $this->addElement('Radio', 'estorepackage_payment_mod_enable', array(
          'label' => 'Activate Stores',
          'description' => "Do you want to enable stores immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Store immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has completed successfully.'
          ),
          'value' => $settings->getSetting('estorepackage.payment.mod.enable', 'all'),
      ));

      $this->addElement('Radio', 'estorepackage_payment_mod_enable', array(
          'label' => 'Activate Stores',
          'description' => "Do you want to enable stores immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Store immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has completed successfully.'
          ),
          'value' => $settings->getSetting('estorepackage.payment.mod.enable', 'all'),
      ));
      $this->addElement('Text', 'estorepackage_admin_bank1_name', array(
          'label' => 'Bank Name 1',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.bank1.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account1_name', array(
          'label' => 'Account Name',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account1.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account1_no', array(
          'label' => 'Account No',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account1.no', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account1_ifsccode', array(
          'label' => 'Branch Code',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account1.ifsccode', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account1_swiftcode', array(
          'label' => 'Iban No',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account1.swiftcode', ''),
      ));

      $this->addElement('Text', 'estorepackage_admin_bank2_name', array(
          'label' => 'Bank Name 2',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.bank2.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account2_name', array(
          'label' => 'Account Name',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account2.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account2_no', array(
          'label' => 'Account No',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account2.no', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account2_ifsccode', array(
          'label' => 'Branch Code',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account2.ifsccode', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account2_swiftcode', array(
          'label' => 'Iban No',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account2.swiftcode', ''),
      ));

      $this->addElement('Text', 'estorepackage_admin_bank3_name', array(
          'label' => 'Bank Name 3',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.bank3.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account3_name', array(
          'label' => 'Account Name',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account3.name', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account3_no', array(
          'label' => 'Account No',
          'description' => "",
          'allowEmpty' => true,
          'required' => false,
          'value' => $settings->getSetting('estorepackage.admin.account3.no', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account3_ifsccode', array(
          'label' => 'Branch Code',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account3.ifsccode', ''),
      ));
      $this->addElement('Text', 'estorepackage_admin_account3_swiftcode', array(
          'label' => 'Iban No',
          'description' => "",
          'value' => $settings->getSetting('estorepackage.admin.account3.swiftcode', ''),
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
