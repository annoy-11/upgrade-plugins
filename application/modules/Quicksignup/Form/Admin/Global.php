<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Quicksignup_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "quicksignup_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('quicksignup.licensekey'),
    ));
    $this->getElement('quicksignup_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('quicksignup.pluginactivated')) {

      $this->addElement('Radio','quicksignup_enable',array(
          'label' => 'Enable Quick & One Step Signup',
          'description' => 'Do you want to enable the Quick & One Step Signup Plugin on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_enable',1)
      ));

      $this->addElement('Radio','quicksignup_title',array(
          'label' => 'Enable Signup Form Title',
          'description' => 'Do you want to enable the Signup Form Title on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_title',0)
      ));

      $this->addElement('Text','quicksignup_titletext',array(
          'label' => 'Signup Form Title Text',
          'description' => 'Enter Signup Form Title text.',
          'allowEmpty'=>true,
          'required' => false,
          'class'=>'hideField',
          'value' => $settings->getSetting('quicksignup_titletext','Create Account'),

        ));

      $this->addElement('Radio','quicksignup_description',array(
          'label' => 'Enable Signup Form Description',
          'description' => 'Do you want to enable the Signup Form Description on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_description','You can signup!!')
      ));

      $this->addElement('Text','quicksignup_descriptiontext',array(
          'label' => 'Signup Form Description Text',
          'description' => 'Enter Signup Form Description text.',
          'allowEmpty'=>true,
          'required' => false,
          'class'=>'hideField',
          'value' => $settings->getSetting('quicksignup_descriptiontext',''),
      ));
      $this->addElement('Radio','quicksignup_field_descriptions',array(
          'label' => 'Enable Descriptions of Fields',
          'description' => 'Do you want to enable the description of all the fields which comes in signup form?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_field_descriptions',0)
      ));
      $this->addElement('Radio','quicksignup_email_conformation',array(
          'label' => 'Enable Email Confirmation Field',
          'description' => 'Do you want to enable the Email Confirmation field in the signup form on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_email_conformation',0)
      ));
      $this->addElement('Radio','quicksignup_password_conformation',array(
          'label' => 'Enable Password Confirmation Field',
          'description' => 'Do you want to enable the Password Confirmation field in the signup form on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_password_conformation',1)
      ));
      $this->addElement('Radio','quicksignup_subscriptionplan',array(
          'label' => 'Enable Membership Plan Subscription',
          'description' => 'Do you want to enable users on your website to be able to choose membership subscription plans which signing up on your website?',
          'allowEmpty'=>false,
          'required' => true,
          'class'=>'hideField',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'value' => $settings->getSetting('quicksignup_subscriptionplan',0)
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
