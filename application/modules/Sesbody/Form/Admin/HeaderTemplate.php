<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderTemplate.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbody_Form_Admin_HeaderTemplate extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('These settings will affect the header of your website.');


    $this->addElement('Radio', 'sesbody_header_design', array(
        'label' => 'Header Design',
        'description' => 'Choose the design of the header from below options.',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesbody/externals/images/design/header-1.jpg" alt="Header Design - 1" />',
            2 => '<img src="./application/modules/Sesbody/externals/images/design/header-2.jpg" alt="Header Design - 2" />',
            3 => '<img src="./application/modules/Sesbody/externals/images/design/header-3.jpg" alt="Header Design - 3" />',
            4 => '<img src="./application/modules/Sesbody/externals/images/design/header-4.jpg" alt="Header Design - 4" />',
            5 => '<img src="./application/modules/Sesbody/externals/images/design/header-5.jpg" alt="Header Design - 5" />',
						// 6 => '<img src="./application/modules/Sesbody/externals/images/design/header-5.jpg" alt="Header Design - 6" />',
        ),
        'escape' => false,
        'onchange' => 'show_headerdesign(this.value)',
        'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_header_design'),
    ));
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $headerLink = $view->baseUrl() . '/admin/sesbody/manage/manage-photos';
    $this->addElement('Dummy', 'header_five', array(
      'content' => '<div class="tip"><span>Note: You can upload the background images for header banner from here: <a href="' . $headerLink . '" target="_blank">Click Here</a>. The uploaded banner images will be shown randomly 1 at a time on page refresh.</span></div>',
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
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sesbody_logo', array(
        'label' => 'Choose Logo',
        'description' => 'Choose from below the logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesbody.logo', ''),
    ));
    $this->sesbody_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $this->addElement('Text', "sesbody_menu_logo_top_space", array(
        'label' => 'Logo Top Margin',
        'description' => 'Enter the top margin for the logo of your website to be displayed in this header.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_menu_logo_top_space'),
    ));
    
    $this->addElement('Text', "sesbody_header_height", array(
	'label' => 'Header Height',
	'description' => 'Enter the height of the header of your website.',
	'allowEmpty' => false,
	'required' => true,
	'value' => $settings->getSetting('sesbody.header.height', '130px'),
    ));
    
    $this->addElement('Radio', 'sesbody_navigation_position', array(
      'label' => 'Main Navigation Position',
      'description' => 'Choose the main navigation position from below options.',
      'multiOptions' => array(
	0 => 'Right',
	1 => 'Left'
      ),
      'value' => $settings->getSetting('sesbody.navigation.position', 1),
    ));

    $this->addElement('Text', 'sesbody_limit', array(
        'label' => 'Menu Count',
        'description' => 'Choose number of menu items to be displayed before â€œMoreâ€? dropdown menu occurs?',
        'value' => $settings->getSetting('sesbody.limit', 4),
    ));

    $this->addElement('Text', 'sesbody_moretext', array(
        'label' => '"More" Button Text',
        'description' => 'Enter "More" Button Text',
        'value' => $settings->getSetting('sesbody.moretext', 'More'),
    ));
    
		$this->addElement('Radio', 'sesbody_popup_design', array(
		'label' => 'Sign in & Sign up Popup Design',
		'description' => 'Choose the design of the sign in & sign up popup from below options.',
		'multiOptions' => array(
		    1 => 'Design - 1',
		    2 => 'Design - 2'
		),
		'value' => Engine_Api::_()->sesbody()->getContantValueXML('sesbody_popup_design'),
		));

    $this->addElement('Select', 'sesbody_searchleftoption', array(
        'label' => 'Module Option in Search',
        'description' => 'Do you want to enable users to search on the basis of various modules installed on your website via AJAX? [If you choose Yes, then manage various modules from the "Manage Modules for Search" section.]',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'showLimitOption(this.value);',
        'value' => $settings->getSetting('sesbody.searchleftoption', 1),
    ));

    $this->addElement('Text', 'sesbody_search_limit', array(
        'label' => 'Module Options Limit',
        'description' => 'Enter the number of various modules to be shown with Search field.',
        'value' => $settings->getSetting('sesbody.search.limit', '8'),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
