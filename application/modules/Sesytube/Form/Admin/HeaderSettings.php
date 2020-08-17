<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderSettings.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_HeaderSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('Here, you can configure the settings for the Header, Main and Mini navigation menus of your website. Below, you can choose to place the Main Navigation menu vertically or horizontally.');

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
    $this->addElement('Select', 'sesytube_logo', array(
        'label' => 'Logo in Header',
        'description' => 'Choose from below the logo image for the header of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesytube.logo', ''),
    ));
    $this->sesytube_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('MultiCheckbox', 'sesytube_header_loggedin_options', array(
        'label' => 'Header Options for Logged In Members',
        'description' => 'Choose from below the options to be available in header to the logged in members on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Mini Menu',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
        ),
        'value' => $settings->getSetting('sesytube.header.loggedin.options',array('search','miniMenu','mainMenu','logo')),
    ));

    $this->addElement('MultiCheckbox', 'sesytube_header_nonloggedin_options', array(
        'label' => 'Header Options for Non-Logged In Members',
        'description' => 'Choose from below the options to be available in header to the non-logged in members on your website.',
        'multiOptions' => array(
            'search' => 'Search Bar',
            'miniMenu' => 'Mini Menu Items',
            'mainMenu' =>'Main Menu Items',
            'logo' =>'Website Logo',
        ),
        'value' => $settings->getSetting('sesytube.header.nonloggedin.options', array('search','miniMenu','mainMenu','logo')),
    ));
    $this->addElement('Select', 'sesytube_submenu', array(
        'label' => 'Show Plugin Navigation Menu',
        'description' => 'Do you want to show plugin navigation menu for the Main Menus?',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('sesytube.submenu', '1'),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
