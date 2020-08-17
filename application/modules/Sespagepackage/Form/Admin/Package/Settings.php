<?php

class Sespagepackage_Form_Admin_Package_Settings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Packages for Allowing Page Creation Extension Settings')
            ->setDescription('From this “Packages for Allowing Page Creation Extension” settings you can choose to enable creation of pages cased on the Package selected. You can create multiple package - both Free and Paid, with various features such that members can choose the packages which suits their requirements. Note: When you enable the page creation based on packages on your website, then the similar settings will not work from the member level settings.')
            ->setAttrib('class', 'global_form_popup');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)', $supportTicket, $sesSite);
    $this->addElement('Text', "sespagepackage_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sespagepackage.licensekey'),
    ));
    $this->getElement('sespagepackage_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sespagepackage.pluginactivated')) {


      $this->addElement('Select', 'sespagepackage_enable_package', array(
          'label' => 'Enable Package',
          'description' => 'Do you want to enable packages for creating Pages on your website? (If you enable Packages, then users will always redirect to the Package selection page, even you have chosen to open the Page Creation form in Popup.)',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'enable_package(this.value)',
          'value' => $settings->getSetting('sespagepackage.enable.package', 0),
      ));

      $information = array('description' => 'Package Description', 'featured' => 'Featured (You can choose to auto-featured pages in each package.)', 'sponsored' => 'Sponsored (You can choose to auto-sponsored pages in each package.)', 'verified' => 'Verified (You can choose to auto-verified pages in each package.)', 'hot' => 'Hot (You can choose to auto-hot pages in each package.)', 'custom_fields' => 'Custom Profile Fields');

      $this->addElement('MultiCheckbox', 'sespagepackage_package_info', array(
          'label' => 'Package Inclusions',
          'description' => 'Select from below the features that you want to include in the Packages for creating pages on your website. If you select any option, then that option will be displayed to your users when they try to create a page. If you simply do not want to show any feature in the package at user end, then do not select it from here.',
          'multiOptions' => $information,
          'value' => $settings->getSetting('sespagepackage.package.info', array_keys($information)),
      ));

      $this->addElement('Radio', 'sespagepackage_payment_mod_enable', array(
          'label' => 'Activate Pages',
          'description' => "Do you want to enable pages immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Page immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has completed successfully.'
          ),
          'value' => $settings->getSetting('sespagepackage.payment.mod.enable', 'all'),
      ));

      $this->addElement('Radio', 'sespagepackage_payment_mod_enable', array(
          'label' => 'Activate Pages',
          'description' => "Do you want to enable pages immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
          'multiOptions' => array(
              'all' => 'Enable Page immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has completed successfully.'
          ),
          'value' => $settings->getSetting('sespagepackage.payment.mod.enable', 'all'),
      ));
      $this->addElement('Text', 'sespagepackage_admin_bank1_name', array(
          'label' => 'Bank Name',
          'description' => "",
          //'allowEmpty' => false,
          //  'required' => true,
          'value' => $settings->getSetting('sespagepackage.admin.bank1.name', ''),
      ));
      $this->addElement('Text', 'sespagepackage_admin_account1_name', array(
          'label' => 'Account Name',
          'description' => "",
          //  'allowEmpty' => false,
          // 'required' => true,
          'value' => $settings->getSetting('sespagepackage.admin.account1.name', ''),
      ));
      $this->addElement('Text', 'sespagepackage_admin_account1_no', array(
          'label' => 'Account No',
          'description' => "",
          // 'allowEmpty' => false,
          //  'required' => true,
          'value' => $settings->getSetting('sespagepackage.admin.account1.no', ''),
      ));
      $this->addElement('Text', 'sespagepackage_admin_account1_ifsccode', array(
          'label' => 'Branch Code',
          'description' => "",
          'value' => $settings->getSetting('sespagepackage.admin.account1.ifsccode', ''),
      ));
      $this->addElement('Text', 'sespagepackage_admin_account1_swiftcode', array(
          'label' => 'Iban No',
          'description' => "",
          'value' => $settings->getSetting('sespagepackage.admin.account1.swiftcode', ''),
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
