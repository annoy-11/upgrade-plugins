<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestweet_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sestweet_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sestweet.licensekey'),
    ));
    $this->getElement('sestweet_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
		
    if (!$settings->getSetting('sestweet.pluginactivated')) {
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('To activate this plugin, we need to update code in 2 files of SocialEngine’s "Libraries" in application >> libraries >> Engine >> View >> Helper folder: TinyMce.php and FormTinyMce.php. So, if you have done any custom work in these files, then please take a backup of these files and replace the backup files with the files after the activation of this plugin and follow the FAQs after replacing the files to make this plugin work. <br /><br />If you need assistance from us in activating the plugin, then please contact our team from our ticket section: <a href="https://www.socialenginesolutions.com/tickets/" target="_blank">https://www.socialenginesolutions.com/tickets/</a>') . "</span></div>";
      $this->addElement('Dummy', 'activation_tip', array(
          'description' => $description,
      ));
      $this->activation_tip->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }

    if ($settings->getSetting('sestweet.pluginactivated')) {
    
      
      $this->addElement('Text', "sestweet_bordercolor", array(
          'label' => 'Border Color',
          'description' => "Choose and enter the border color of “Click To Tweet” Box which will come inside the TinyMCE content.",
          'allowEmpty' => false,
          'required' => true,
          'class' => 'SEScolor',
          'value' => $settings->getSetting('sestweet.bordercolor', '1da1f2'),
      ));
      
      $this->addElement('Text', "sestweet_borderwidth", array(
          'label' => 'Border Width',
          'description' => "Choose width of the border of “Click To Tweet” Box which will come inside the TinyMCE content.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sestweet.borderwidth', '1px'),
      ));
      
      $this->addElement('Text', "sestweet_text", array(
          'label' => 'Click To Tweet',
          'description' => "Enter the text which you want to show in place of “Click To Tweet” in the Box which will come inside the TinyMCE content.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sestweet.text', 'Click To Tweet'),
      ));
      
      $this->addElement('Text', "sestweet_fontsize", array(
          'label' => 'Font Size',
          'description' => "Choose the font size for the text to be shown in the “Click To Tweet” Box which will come inside the TinyMCE content.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sestweet.fontsize', '20px'),
      ));
      
      $this->addElement('Text', "sestweet_widgthinper", array(
          'label' => 'Tweetable box Width',
          'description' => "Enter the width of the Tweetable Content Box (in percentage [%]) below which will come inside the TinyMCE content.",
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('sestweet.widgthinper', '70%'),
      ));

      
      $this->addElement('Radio', 'sestweet_textselection', array(
          'label' => 'Enable Share on Text Selection',
          'description' => 'Do you want to enable the share to Twitter and Facebook box when users select any text from your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'enableSelection(this.value)',
          'value' => $settings->getSetting('sestweet_textselection', 1),
      ));
      
      $this->addElement('Text', "sestweet_twitterhandler", array(
          'label' => 'Twitter Handle',
          'description' => 'Enter your Twitter handle to add "via @yourhandle" to your tweets. Do not include the @ symbol.',
          //'allowEmpty' => false,
         // 'required' => true,
          'value' => $settings->getSetting('sestweet.twitterhandler', 'yourname'),
      ));
      
      $this->addElement('Radio', 'sestweet_enabletwitter', array(
          'label' => 'Enable Share on Twitter',
          'description' => 'Do you want to enable the sharing on Twitter in the share box?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sestweet.enabletwitter', 1),
      ));
      
      $this->addElement('Radio', 'sestweet_enablefacebook', array(
          'label' => 'Enable Share on Facebook',
          'description' => 'Do you want to enable the sharing on Facebook in the share box?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sestweet.enablefacebook', 1),
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
