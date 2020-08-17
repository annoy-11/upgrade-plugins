<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderTemplate.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Form_Admin_HeaderTemplate extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('These settings will affect the header of your website.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $headerLink = $view->baseUrl() . '/admin/sessportz/manage/manage-photos';
    $this->addElement('Dummy', 'header_five', array(
      'content' => '<div class="tip"><span>Note: You can upload the background images for header banner from here: <a href="' . $headerLink . '" target="_blank">Click Here</a>. The uploaded banner images will be shown randomly 1 at a time on page refresh.</span></div>',
    ));

    //New File System Code
    $banner_options = array('' => '');
    $files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
    foreach( $files as $file ) {
      $banner_options[$file->storage_path] = $file->name;
    }
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sessportz_logo', array(
        'label' => 'Choose Logo',
        'description' => 'Choose from below the logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sessportz.logo', ''),
    ));
    $this->sessportz_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Text', "sessportz_menu_logo_top_space", array(
        'label' => 'Logo Top Margin',
        'description' => 'Enter the top margin for the logo of your website to be displayed in this header.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_menu_logo_top_space'),
    ));

    $this->addElement('Text', "sessportz_header_height", array(
	'label' => 'Header Height',
	'description' => 'Enter the height of the header of your website.',
	'allowEmpty' => false,
	'required' => true,
	'value' => $settings->getSetting('sessportz.header.height', '130px'),
    ));

    $this->addElement('Radio', 'sessportz_navigation_position', array(
      'label' => 'Main Navigation Position',
      'description' => 'Choose the main navigation position from below options.',
      'multiOptions' => array(
	0 => 'Right',
	1 => 'Left'
      ),
      'value' => $settings->getSetting('sm.navigation.position', 1),
    ));

    $this->addElement('Text', 'sessportz_limit', array(
        'label' => 'Menu Count',
        'description' => 'Choose number of menu items to be displayed before “More�? dropdown menu occurs?',
        'value' => $settings->getSetting('sessportz.limit', 4),
    ));

    $this->addElement('Text', 'sessportz_moretext', array(
        'label' => '"More" Button Text',
        'description' => 'Enter "More" Button Text',
        'value' => $settings->getSetting('sessportz.moretext', 'More'),
    ));

    $this->addElement('Select', 'sessportz_searchleftoption', array(
        'label' => 'Module Option in Search',
        'description' => 'Do you want to enable users to search on the basis of various modules installed on your website via AJAX? [If you choose Yes, then manage various modules from the "Manage Modules for Search" section.]',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'showLimitOption(this.value);',
        'value' => $settings->getSetting('sessportz.searchleftoption', 1),
    ));

    $this->addElement('Text', 'sessportz_search_limit', array(
        'label' => 'Module Options Limit',
        'description' => 'Enter the number of various modules to be shown with Search field.',
        'value' => $settings->getSetting('sessportz.search.limit', '8'),
    ));

    $this->addElement('Text', 'sessportz_he_email', array(
        'label' => 'Email',
        'description' => 'Enter the email.',
        'value' => $settings->getSetting('sessportz.he.email', 'info@abc.com'),
    ));


    $this->addElement('Text', 'sessportz_he_phone', array(
        'label' => 'Phone Number',
        'description' => 'Enter the phone number.',
        'value' => $settings->getSetting('sessportz.he.phone', '+91-1234567890'),
    ));

    $this->addElement('Select', 'sessportz_he_ads', array(
        'label' => 'Choose Ads',
        'description' => 'Choose from below the ads image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sessportz.he.ads', ''),
    ));
    $this->sessportz_he_ads->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
