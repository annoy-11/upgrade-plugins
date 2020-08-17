<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: General.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_Form_Admin_Settings_General extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesminify_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesminify.licensekey'),
    ));
    $this->getElement('sesminify_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

	if ($settings->getSetting('sesminify.pluginactivated')) {

      $this->addElement('Radio', 'sesminify_enablejs', array(
          'label' => 'Enable Minification JS Files',
          'description' => 'Do you want to enable the minification & compression of JS files on your website. If you choose Yes, and you do not want any JS file to be minified, then you can enter the URL (path) of that file in the “Ignore JS” section of this plugin?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onChange'=>"disableDependednt(this.value,'js');",
          'value' => $settings->getSetting('sesminify.enablejs', 1),
      ));

      $this->addElement('Text', 'sesminify_jslength', array(
          'label' => 'Minify JS Count',
          'description' => 'Enter the number of JS files you want to minify in one request. The count must be greater than 1. We recommend you to minify 5 JS files in one request.',
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(1)),
          ),
          'value' => $settings->getSetting('sesminify.jslength', 5),
      ));

      $this->addElement('Radio', 'sesminify_enablecss', array(
          'label' => 'Enable Minification of CSS Files',
          'description' => 'Do you want to enable the minification & compression of CSS files on your website. If you choose Yes, and you do not want any CSS file to be minified, then you can enter the URL (path) of that file in the “Ignore CSS” section of this plugin?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onChange'=>"disableDependednt(this.value,'css');",
          'value' => $settings->getSetting('sesminify.enablecss', 1),
      ));

      $this->addElement('Text', 'sesminify_csslength', array(
          'label' => 'Minify CSS Count',
          'description' => 'Enter the number of CSS files you want to minify in one request. The count must be greater than 1. We recommend you to minify 5 CSS files in one request.',
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(1)),
          ),
          'value' => $settings->getSetting('sesminify.csslength', 5),
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
