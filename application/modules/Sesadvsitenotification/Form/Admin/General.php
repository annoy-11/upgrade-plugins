<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: General.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvsitenotification_Form_Admin_General extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Notification Popup Settings')
            ->setDescription('These settings affect all members in your community. Here, you can configure the popup in which website notifications will be shown. The popups will display on website when the widget "Display Website Notifications in Popup" is placed in the header of your website in the Layout Editor.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesadvsitenotification_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesadvsitenotification.licensekey'),
    ));
    $this->getElement('sesadvsitenotification_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesadvsitenotification.pluginactivated')) {

      $this->addElement('Radio', "sesadvsitenotification_notification", array(
        'label' => 'Enable Notification Popups',
        'description' => 'Do you want to enable the default website notifications to be shown in popups on your website?',
        'allowEmpty' => true,
        'required' => false,
        'onclick'=>'notification(this.value)',
        'multiOptions'=>array(1=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesadvsitenotification.notification',1),
      ));

      $this->addElement('Radio', "sesadvsitenotification_position", array(
        'label' => 'Choose Notification Popup Position',
        'description' => 'Choose from below the position of the popup in which website notifications will be shown.',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions'=>  array('sesadvnotification-top-right'=>'Top Right','sesadvnotification-bottom-right'=>'Bottom Right','sesadvnotification-bottom-left'=>'Bottom Left','sesadvnotification-top-left'=>'Top Left','sesadvnotification-top-full-width'=>'Top Full Width','sesadvnotification-bottom-full-width'=>'Bottom Full Width','sesadvnotification-top-center'=>'Top Center','sesadvnotification-bottom-center'=>'Bottom Center'),
        'value' => $settings->getSetting('sesadvsitenotification.position','sesadvnotification-bottom-left'),
      ));

      $this->addElement('Radio', "sesadvsitenotification_autohide", array(
        'label' => 'Auto Hide Notification Popups',
        'description' => 'Do you want to auto hide the notification popups?',
        'allowEmpty' => true,
        'required' => false,
        'onclick'=>'duration(this.value)',
        'multiOptions'=>array('0'=>'No',1=>'Yes'),
        'value' => $settings->getSetting('sesadvsitenotification.autohide',1),
      ));

      $this->addElement('Text', "sesadvsitenotification_autohideduration", array(
        'label' => 'Duration for Auto Hiding',
        'description' => 'Enter the duration after which the notification popups will be automatically hidden. ( Enter duration in milliseconds where 1000ms = 1 second)',
        'allowEmpty' => true,
        'required' => false,
        'value' => $settings->getSetting('sesadvsitenotification.autohideduration',10000),
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
