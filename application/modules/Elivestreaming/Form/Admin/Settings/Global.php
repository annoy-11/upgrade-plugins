<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Elivestreaming
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Global.php 2019-10-01 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Elivestreaming_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->setTitle('Global Settings')
        ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "elivestreaming_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('elivestreaming.licensekey'),
    ));
    $this->getElement('elivestreaming_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('elivestreaming.pluginactivated')) {
        $this->addElement('Text', "elivestreaming_agoraappid", array(
            'label' => 'Agora App ID',
            'description' => "",
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('elivestreaming.agoraappid'),
        ));
        $this->getElement('elivestreaming_agoraappid')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
      $this->addElement('Radio', 'elivestreaming_showliveimage', array(
        'label' => 'Show image in stories?',
        'description' => 'Select below image when user goes live? If no, then user profile is shown.',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => $settings->getSetting('elivestreaming.showliveimage', 1),
      ));

      $this->addElement('Text', 'elivestreaming_linux_base_url', array(
        'label' => 'Stream base URL',
        'description' => 'Stream base URL.',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('elivestreaming.linux.base.url',""),
      ));

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
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
      if (count($banner_options) > 1) {
        $this->addElement('Select', 'elivestreaming_storieslivedefaultimage', array(
          'label' => 'Stories Live Default Image',
          'description' => 'Choose a default photo for the stories when user goes live on mobile app. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to change default photo.]',
          'multiOptions' => $banner_options,
          'value' => $settings->getSetting('elivestreaming.storieslivedefaultimage'),
        ));
        $this->elivestreaming_storieslivedefaultimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("There are currently no photos added in the File & Media Manager. Please upload a photo from here: <a href='" . $fileLink . "' target='_blank'>File & Media Manager</a> and refresh the page to display new files.") . "</span></div>";

        //Add Element: Dummy
        $this->addElement('Dummy', 'elivestreaming_storieslivedefaultimage', array(
          'label' => 'Playlist Default Photo',
          'description' => $description,
        ));
        $this->elivestreaming_storieslivedefaultimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }

      // Add submit button
      $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
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
