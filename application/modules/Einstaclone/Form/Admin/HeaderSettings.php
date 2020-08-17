<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: HeaderSettings.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Einstaclone_Form_Admin_HeaderSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $einstaclone_adminmenu = Zend_Registry::isRegistered('einstaclone_adminmenu') ? Zend_Registry::get('einstaclone_adminmenu') : null;
    $this->setTitle('Header Footer Settings')
            ->setDescription('From here you can configure below mentioned settings for your header.');
    
    if($einstaclone_adminmenu) {
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';
      //New File System Code
      $banner_options = array('' => '');
      $files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
      foreach( $files as $file ) {
        $banner_options[$file->storage_path] = $file->name;
      }
      
      $this->addElement('Select', 'einstaclone_headerlogo', array(
          'label' => 'Header Logo',
          'description' => 'Choose from below the header logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show header logo.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => $settings->getSetting('einstaclone.headerlogo', ''),
      ));
      $this->einstaclone_headerlogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Radio', 'einstaclone_sidepaneldesign', array(
        'label' => 'Vertical Sidebar Opening Effects',
        'description' => 'Choose vertical sidebar menus opening effect design for the header of your website.',
        'multiOptions' => array(
          1 => 'Slide Effect',
          2 => 'Overlay Effect',
        ),
        'value' => $settings->getSetting('einstaclone.sidepaneldesign',1),
      ));

      $this->addElement('MultiCheckbox', 'einstaclone_headerloggedinoptions', array(
        'label' => 'Show Header Options to Logged-in members',
        'description' => 'Choose from below the header options that you want to be shown to Logged-in members on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Mini Menu',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
        ),
        'value' => unserialize($settings->getSetting('einstaclone.headerloggedinoptions', 'a:4:{i:0;s:6:"search";i:1;s:8:"miniMenu";i:2;s:8:"mainMenu";i:3;s:4:"logo";}')),
      ));

      $this->addElement('MultiCheckbox', 'einstaclone_headernonloggedinoptions', array(
        'label' => 'Show Header Options to Non Logged-in users',
        'description' => 'Choose from below the header options that you want to be shown to Non Logged-in users on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Login & Singup',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
        ),
        'value' => unserialize($settings->getSetting('einstaclone.headernonloggedinoptions', 'a:3:{i:0;s:8:"miniMenu";i:2;s:4:"logo";}')),
      ));

      $this->addElement('Radio', 'einstaclone_footersidepanel', array(
        'label' => 'Show Footer in Vertical Sidebar',
        'description' => 'Do you want to show footer in vertical sidebar menu with header?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('einstaclone.footersidepanel',1),
      ));
      
      $this->addElement('Select', 'einstaclone_searchleftoption', array(
        'label' => 'Module Option in Search',
        'description' => 'Do you want to enable users to search on the basis of various modules installed on your website via AJAX? [If you choose Yes, then manage various modules from the "Manage Modules for Search" section.]',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'showLimitOption(this.value);',
        'value' => $settings->getSetting('einstaclone.searchleftoption', 1),
      ));

      $this->addElement('Text', 'einstaclone_search_limit', array(
        'label' => 'Module Options Limit',
        'description' => 'Enter the number of various modules to be shown with Search field.',
        'value' => $settings->getSetting('einstaclone.search.limit', '8'),
      ));
    }
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
