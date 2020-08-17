<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Settings.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Coursespackage_Form_Admin_Package_Settings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Package settings and Configuration')->setDescription('From this “Packages settings and Configuration” settings you can choose to enable creation of courses based on the Package selected. You can create multiple package - both Free and Paid, with various features such that members can choose the packages which suits their requirements');

      $this->addElement('Select', 'courses_enable_package', array(
          'label' => 'Enable Package',
          'description' => 'Do you want to enable packages for creating Courses on your website? (If you enable Packages, then users will always redirect to the Package selection page, even if you have chosen to open the Course Creation form in Popup.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'enable_package(this.value)',
          'value' => $settings->getSetting('courses.enable.package', 0),
      ));

      $information = array('description' => 'Package Description', 'featured' => 'Featured (You can choose to auto-featured Courses in each package.)', 'sponsored' => 'Sponsored (You can choose to auto-sponsored Courses in each package.)', 'verified' => 'Verified (You can choose to auto-verified Courses in each package.)', 'hot' => 'Hot (You can choose to auto-hot Courses in each package.)', 'custom_fields' => 'Custom Profile Fields');

      $this->addElement('MultiCheckbox', 'courses_package_info', array(
          'label' => 'Package Composition',
          'description' => 'Select from below the features that you want to include in the Packages for creating Courses on your website. If you select any option, then that option will be displayed to your users when they try to create a Course. If you simply do not want to show any feature in the package at user end, then do not select it from here.',
          'multiOptions' => $information,
          'value' => $settings->getSetting('courses.package.info', array_keys($information)),
      ));

      $this->addElement('Radio', 'courses_payment_mod_enable', array(
          'label' => 'Active Packages',
          'description' => "Do you want to enable Packages immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Package immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has been completed successfully.'
          ),
          'value' => $settings->getSetting('courses.payment.mod.enable', 'all'),
      ));

      $this->addElement('Text', 'courses_admin_bank1_name', array(
          'label' => 'Bank Name',
          'description' => "Enter your Bank Name in the box.",
          //'allowEmpty' => false,
          //  'required' => true,
          'value' => $settings->getSetting('courses.admin.bank1.name', ''),
      ));
      $this->addElement('Text', 'courses_admin_account1_name', array(
          'label' => 'Account Name',
          'description' => "Enter your Account Name.",
          //  'allowEmpty' => false,
          // 'required' => true,
          'value' => $settings->getSetting('courses.admin.account1.name', ''),
      ));
      $this->addElement('Text', 'courses_admin_account1_no', array(
          'label' => 'Account No',
          'description' => "Enter Your Account Number",
          // 'allowEmpty' => false,
          //  'required' => true,
          'value' => $settings->getSetting('courses.admin.account1.no', ''),
      ));
      $this->addElement('Text', 'courses_admin_account1_ifsccode', array(
          'label' => 'Branch Code',
          'description' => "Enter your Branch Code",
          'value' => $settings->getSetting('courses.admin.account1.ifsccode', ''),
      ));
      $this->addElement('Text', 'courses_admin_account1_swiftcode', array(
          'label' => 'IBAN Account No(International Bank Account NumberIban No)',
          'description' => "Enter IBAN Account Number",
          'value' => $settings->getSetting('courses.admin.account1.swiftcode', ''),
      ));

      // Buttons
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Settings',
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array('ViewHelper')
      ));
  }

}
