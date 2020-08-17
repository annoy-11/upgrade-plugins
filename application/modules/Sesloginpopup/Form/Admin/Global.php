<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesloginpopup_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community. You can choose other configurable settings for this plugin from "Sigin Page" Widget and "Signin Signup Popup" widget in Layout Editor.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesloginpopup_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesloginpopup.licensekey'),
    ));
    $this->getElement('sesloginpopup_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesloginpopup.pluginactivated')) {
    
      //default photos
      $default_photos_main = array();
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
        $default_photos_main['public/admin/' . $base_name] = $base_name;
      }
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';
      //event main photo
      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array(''=>''),$default_photos_main);
        $this->addElement('Select', 'sesloginpoup_popup_photo', array(
            'label' => 'Signin Signup Popup Photo',
            'description' => 'Choose photo for the signin & signup popup on your website. [Note:This Setting will only work in Popup design 2,4,7,9 and 10. You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesloginpoup_popup_photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for login popup photo. Photo to be chosen for photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the main photo. Please upload the Photo to be chosen for login popup photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesloginpoup_popup_photo', array(
            'label' => 'Login Popup Photo',
            'description' => $description,
        ));
      }
      $this->sesloginpoup_popup_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      if (count($default_photos_main) > 0) {
        $default_photos = array_merge(array(''=>''),$default_photos_main);
        $this->addElement('Select', 'sesloginpoup_page_photo', array(
            'label' => 'Signin Page Photo',
            'description' => 'Choose photo for the signin page on your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>.]',
            'multiOptions' => $default_photos,
            'value' => $settings->getSetting('sesloginpoup_page_photo'),
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('There are currently no photo for login page photo. Photo to be chosen for photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section. => There are currently no photo in the File & Media Manager for the page photo. Please upload the Photo to be chosen for login page photo from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.') . "</span></div>";
        //Add Element: Dummy
        $this->addElement('Dummy', 'sesloginpoup_page_photo', array(
            'label' => 'Login Page Photo',
            'description' => $description,
        ));
      }
      $this->sesloginpoup_page_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Dummy', 'popup_settings', array(
          'label' => 'Sign In & Sign Up Popup Settings',
      ));
      $this->addElement('Select', 'sesloginpopup_popupsign', array(
          'label' => 'Enable Popup for Sign In & Sign Up',
          'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
              'onclick' => 'showPopup(this.value);',
          'value' => $settings->getSetting('sesloginpopup.popupsign', '1'),
      ));

      $this->addElement('Select', 'sesloginpopup_popup_enable', array(
          'label' => 'Open Sign In Popup Automatically',
          'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
          'multiOptions' => array(
                  1 => 'Yes',
                  0 => 'No'
          ),
          'onclick' => 'loginsignupvisiablity(this.value);',
          'value' => $settings->getSetting('sesloginpopup.popup.enable', 1),
      ));

      $this->addElement('Text', 'sesloginpopup_popup_day', array(
          'label' => 'Sign In Popup Visibility',
          'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
          'value' => $settings->getSetting('sesloginpopup.popup.day', 5),
      ));

      $this->addElement('Select', 'sesloginpopup_popupfixed', array(
          'label' => 'Allow to Close Sign In Popup',
          'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
          'multiOptions' => array(
              1 => 'No, do not allow to close popup',
              0 => 'Yes, allow to close popup'
          ),
          'value' => $settings->getSetting('sesloginpopup.popupfixed', 0),
      ));

      //Add submit button
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
