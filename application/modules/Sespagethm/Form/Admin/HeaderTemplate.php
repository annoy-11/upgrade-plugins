<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: HeaderTemplate.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagethm_Form_Admin_HeaderTemplate extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Header Settings')
            ->setDescription('These settings will affect the header of your website.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $headerLink = $view->baseUrl() . '/admin/sespagethm/manage/manage-photos';
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
    $this->addElement('Select', 'sespagethm_logo', array(
        'label' => 'Choose Logo',
        'description' => 'Choose from below the logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sespagethm.logo', ''),
    ));
    $this->sespagethm_logo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Text', "sespagethm_menu_logo_top_space", array(
        'label' => 'Logo Top Margin',
        'description' => 'Enter the top margin for the logo of your website to be displayed in this header.',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_menu_logo_top_space'),
    ));

    $this->addElement('Text', "sespagethm_header_height", array(
	'label' => 'Header Height',
	'description' => 'Enter the height of the header of your website.',
	'allowEmpty' => false,
	'required' => true,
	'value' => $settings->getSetting('sm.header.height', '130px'),
    ));

    $this->addElement('Radio', 'sespagethm_navigation_position', array(
      'label' => 'Main Navigation Position',
      'description' => 'Choose the main navigation position from below options.',
      'multiOptions' => array(
	0 => 'Right',
	1 => 'Left'
      ),
      'value' => $settings->getSetting('sm.navigation.position', 1),
    ));

    $this->addElement('Text', 'sespagethm_limit', array(
        'label' => 'Menu Count',
        'description' => 'Choose number of menu items to be displayed before â€œMoreâ€? dropdown menu occurs?',
        'value' => $settings->getSetting('sespagethm.limit', 4),
    ));

    $this->addElement('Text', 'sespagethm_moretext', array(
        'label' => '"More" Button Text',
        'description' => 'Enter "More" Button Text',
        'value' => $settings->getSetting('sespagethm.moretext', 'More'),
    ));

// 		$this->addElement('Radio', 'sespagethm_popup_design', array(
// 		'label' => 'Sign in & Sign up Popup Design',
// 		'description' => 'Choose the design of the sign in & sign up popup from below options.',
// 		'multiOptions' => array(
// 		    1 => 'Design - 1',
// 		    2 => 'Design - 2'
// 		),
// 		'value' => Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_popup_design'),
// 		));

    $this->addElement('Select', 'sespagethm_searchleftoption', array(
        'label' => 'Module Option in Search',
        'description' => 'Do you want to enable users to search on the basis of various modules installed on your website via AJAX? [If you choose Yes, then manage various modules from the "Manage Modules for Search" section.]',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'showLimitOption(this.value);',
        'value' => $settings->getSetting('sespagethm.searchleftoption', 1),
    ));

    $this->addElement('Text', 'sespagethm_search_limit', array(
        'label' => 'Module Options Limit',
        'description' => 'Enter the number of various modules to be shown with Search field.',
        'value' => $settings->getSetting('sespagethm.search.limit', '8'),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
