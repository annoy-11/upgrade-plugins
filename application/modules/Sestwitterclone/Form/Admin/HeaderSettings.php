<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderSettings.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestwitterclone_Form_Admin_HeaderSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Header Settings')
            ->setDescription('From here you can configure below mentioned settings for your header.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    $banner_optionss[] = '';
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
      $banner_optionss['public/admin/' . $base_name] = $base_name;
    }
    $this->addElement('Select', 'sestwitterclone_headerlogo', array(
        'label' => 'Header Logo',
        'description' => 'Choose from below the header logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show header logo.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sestwitterclone.headerlogo', ''),
    ));
    $this->sestwitterclone_headerlogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Radio', 'sestwitterclone_sidepaneldesign', array(
      'label' => 'Vertical Sidebar Opening Effects',
      'description' => 'Choose vertical sidebar menus opening effect design for the header of your website.',
      'multiOptions' => array(
        1 => 'Slide Effect',
        2 => 'Overlay Effect',
      ),
      'value' => $settings->getSetting('sestwitterclone.sidepaneldesign',1),
    ));

    $this->addElement('MultiCheckbox', 'sestwitterclone_headerloggedinoptions', array(
      'label' => 'Show Header Options to Logged-in members',
      'description' => 'Choose from below the header options that you want to be shown to Logged-in members on your website.',
      'multiOptions' => array(
          'search' => 'Search',
          'miniMenu' => 'Mini Menu',
          'mainMenu' =>'Main Menu',
          'logo' =>'Logo',
      ),
      'value' => unserialize($settings->getSetting('sestwitterclone.headerloggedinoptions', 'a:4:{i:0;s:6:"search";i:1;s:8:"miniMenu";i:2;s:8:"mainMenu";i:3;s:4:"logo";}')),
    ));

    $this->addElement('MultiCheckbox', 'sestwitterclone_headernonloggedinoptions', array(
      'label' => 'Show Header Options to Non Logged-in users',
      'description' => 'Choose from below the header options that you want to be shown to Non Logged-in users on your website.',
      'multiOptions' => array(
          'search' => 'Search',
          'miniMenu' => 'Login & Singup',
          'mainMenu' =>'Main Menu',
          'logo' =>'Logo',
      ),
      'value' => unserialize($settings->getSetting('sestwitterclone.headernonloggedinoptions', 'a:3:{i:0;s:8:"miniMenu";i:2;s:4:"logo";}')),
    ));

    $this->addElement('Radio', 'sestwitterclone_footersidepanel', array(
      'label' => 'Show Footer in Vertical Sidebar',
      'description' => 'Do you want to show footer in vertical sidebar menu with header?',
      'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
      ),
      'value' => $settings->getSetting('sestwitterclone.footersidepanel',1),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
