<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesadvancedheader_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesadvancedheader.licensekey'),
    ));
    $this->getElement('sesadvancedheader_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  
    if ($settings->getSetting('sesadvancedheader.pluginactivated')) {

      $this->addElement('Select', 'sesadvancedheader_miniuserphotoround', array(
        'label' => 'Member Avatar Shape in Mini Menu',
        'description' => 'Choose from below the shape of the member avatar which is shown in Mini Navigation menu.',
        'multiOptions' => array(
          1 => 'Circle',
          0 => 'Square'
        ),
        'value' => $settings->getSetting('sesadvancedheader.miniuserphotoround',1),
      ));

      $this->addElement('Select', 'sesadvancedheader_popupsign', array(
          'label' => 'Enable Popup for Sign In & Sign Up',
          'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
          'multiOptions'=>array('1'=>'Yes','0'=>'No'),
          'onclick' => 'showPopup(this.value);',
          'value' => $settings->getSetting('sesadvancedheader.popupsign', '1'),
      ));

      $this->addElement('Select', 'sesadvancedheader_popup_enable', array(
          'label' => 'Open Sign In Popup Automatically',
          'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onclick' => 'loginsignupvisiablity(this.value);',
          'value' => $settings->getSetting('sesadvancedheader.popup.enable', 1),
      ));

      $this->addElement('Text', 'sesadvancedheader_popup_day', array(
          'label' => 'Sign In Popup Visibility',
          'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
          'value' => $settings->getSetting('sesadvancedheader.popup.day', 5),
      ));

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
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';

      $this->addElement('Select', 'sesadvancedheader_popupfixed', array(
          'label' => 'Allow to Close Sign In Popup',
          'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
          'multiOptions' => array(
              1 => 'No, do not allow to close popup',
              0 => 'Yes, allow to close popup'
          ),
          'value' => $settings->getSetting('sesadvancedheader.popupfixed', 0),
      ));

      $this->addElement('Select', 'sesadvancedheader_loginsignuplogo', array(
          'label' => 'Logo for Sign In & Sign Up Popup',
          'description' => 'Choose from below logo image for the sign in and signup popup of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => $settings->getSetting('sesadvancedheader.loginsignuplogo', ''),
      ));
      $this->sesadvancedheader_loginsignuplogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sesadvancedheader_loginsignupbgimage', array(
          'label' => 'Background Image for Sign In & Sign Up Popup',
          'description' => 'Choose from below the background image for the sign in and sign up popup of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => $settings->getSetting('sesadvancedheader.loginsignupbgimage', 'public/admin/popup-bg.png'),
      ));
      $this->sesadvancedheader_loginsignupbgimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


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
