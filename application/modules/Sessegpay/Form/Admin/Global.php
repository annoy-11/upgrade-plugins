<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessegpay
 * @package    Sessegpay
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessegpay_Form_Admin_Global extends Engine_Form {

  public function init() {

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sessegpay_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sessegpay.licensekey'),
    ));
    $this->getElement('sessegpay_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sessegpay.pluginactivated')) {

      $this->addElement('Radio', 'sessegpay_enable', array(
          'label' => 'Enable SegPay',
          'description' => 'Do you want to enable SegPay Gateway',
          'allowEmpty' => false,
          'required' => true,
          'multiOptions'=>array(1=>'Yes',0=>'No'),
          'value' => $settings->getSetting('sessegpay_enable', '1'),
      ));


      $this->addElement('Text', 'sessegpay_username', array(
          'label' => 'Username',
          'description' => 'Your Username from Segpay',
          'allowEmpty' => false,
          'required'  => true,
          'value' => $settings->getSetting('sessegpay_username', ''),
      ));

      $this->addElement('Text', 'sessegpay_password', array(
          'label' => 'Password',
          'description' => 'Your Password from Segpay',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sessegpay_password', ''),
      ));

    $this->addElement('Text', 'sessegpay_successText', array(
          'label' => 'Success Text',
          'description' => 'Enter the sucess text to show in SegPay gateway',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sessegpay_successText', 'Transaction Successful'),
      ));

    $this->addElement('Text', 'sessegpay_failedText', array(
          'label' => 'Failed Text',
          'description' => 'Enter the failed text to show in SegPay gateway',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sessegpay_failedText', 'Transaction Failed'),
      ));


      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
