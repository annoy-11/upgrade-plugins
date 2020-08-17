<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmembershipcard_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
          ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesmembershipcard_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('sesmembershipcard.licensekey'),
    ));
    $this->getElement('sesmembershipcard_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesmembershipcard.pluginactivated')) {
    
        $this->addElement('Radio', "sesmembershipcard_visibility", array(
        'label' => 'Membership Cards Visibility',
        'description' => '',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>array(
          '1'=>'only owner can see membership cards',
          '2'=>'only member can see membership cards',
          '3'=>'everyone can see membership cards',
        ),
        'value' => $settings->getSetting('sesmembershipcard_visibility',3),
      ));
      $this->getElement('sesmembershipcard_visibility')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $this->addElement('Radio', "sesmembershipcard_print", array(
        'label' => 'Print Membership Cards',
        'description' => '',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>array(
        '0'=>'Nobody can print membership cards',
          '1'=>' only owner can print membership cards',
          '2'=>'only member can print membership cards',
          '3'=>'everyone can print membership cards',
        ),
        'value' => $settings->getSetting('sesmembershipcard_print',3),
      ));
      $this->getElement('sesmembershipcard_print')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
