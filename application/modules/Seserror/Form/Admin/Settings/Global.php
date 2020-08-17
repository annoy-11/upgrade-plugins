<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "seserror_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('seserror.licensekey'),
    ));
    $this->getElement('seserror_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('seserror.pluginactivated')) {

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $banner_options[] = '';
      $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
      foreach ($path as $file) {
        if ($file->isDot() || !$file->isFile())
          continue;
        $base_name = basename($file->getFilename());
        if (!($pos = strrpos($base_name, '.')))
          continue;
        $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
        if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
          continue;
        $banner_options['public/admin/' . $base_name] = $base_name;
      }
      $fileLink = $view->baseUrl() . '/admin/files/';
      $this->addElement('Select', 'seserror_authpagebgimage', array(
          'label' => 'Sign-in Required Page Image',
          'description' => 'Choose from below the background image for the “Sign-in Required Page” of your website. This is a SocialEngine page which opens when sign is required to access any content of your website. For example: Open <a href="http://demo.socialenginesolutions.com/events/create" target="_blank">this link</a> from non-non-logged in user. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="'.$fileLink.'" target="_blank">File & Media Manager</a>.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => $settings->getSetting('seserror.authpagebgimage', ''),
      ));
      $this->seserror_authpagebgimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Dummy', 'seserror_sociallinks', array(
          'label' => 'Social Links',
      ));

      $this->addElement('Text', 'seserror_facebook', array(
          'label' => 'Facebook URL',
          'description' => '',
          'value' => $settings->getSetting('seserror.facebook', ''),
      ));
      $this->addElement('Text', 'seserror_googleplus', array(
          'label' => 'Google Plus URL',
          'description' => '',
          'value' => $settings->getSetting('seserror.googleplus',''),
      ));
      $this->addElement('Text', 'seserror_twitter', array(
          'label' => 'Twitter URL',
          'description' => '',
          'value' => $settings->getSetting('seserror.twitter', ''),
      ));
      $this->addElement('Text', 'seserror_youtube', array(
          'label' => 'YouTube URL',
          'description' => '',
          'value' => $settings->getSetting('seserror.youtube', ''),
      ));
      $this->addElement('Text', 'seserror_linkedin', array(
          'label' => 'LinkedIn URL',
          'description' => '',
          'value' => $settings->getSetting('seserror.linkedin', ''),
      ));

      $this->addElement('Radio', 'seserror_maintenanceenablesocial', array(
        'label' => 'Enable Social links in Maintenance Mode',
        'description' => 'Do you want to enable the Social Links in Maintenance Mode page on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('seserror.maintenanceenablesocial', 1),
      ));

      $this->addElement('Radio', 'seserror_comingsoonenablesocial', array(
        'label' => 'Enable Social links in Coming Soon',
        'description' => 'Do you want to enable the Social Links in Coming Soon page on your website?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => $settings->getSetting('seserror.comingsoonenablesocial', 1),
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
