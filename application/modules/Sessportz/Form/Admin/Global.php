<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');
            
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sessportz_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sessportz.licensekey'),
    ));
    $this->getElement('sessportz_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    if ($settings->getSetting('sessportz.pluginactivated')) {

    $this->addElement('Dummy', 'layout_settings', array(
        'label' => 'Layout Settings',
        'description' => 'Choose from below the settings for the Layout of the theme. These settings will affect all the existing Color Schemes of the theme including the custom color scheme made by you.',
    ));


    $this->addElement('Text', "sessportz_main_width", array(
        'label' => 'Theme Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_main_width'),
    ));

    $this->addElement('Text', "sessportz_left_columns_width", array(
        'label' => 'Left Column Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_left_columns_width'),
    ));

    $this->addElement('Text', "sessportz_right_columns_width", array(
        'label' => 'Right Column Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_right_columns_width'),
    ));

    $this->addElement('Select', "sessportz_header_fixed_layout", array(
        'label' => 'Header Fixed?',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '2' => "No",
        ),
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_header_fixed_layout'),
    ));

    $this->addElement('Select', "sessportz_responsive_layout", array(
        'label' => 'Enable Responsive CSS',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '2' => "No",
        ),
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_responsive_layout'),
    ));
    $this->addDisplayGroup(array('sessportz_main_width', 'sessportz_left_columns_width', 'sessportz_right_columns_width', 'sessportz_header_fixed_layout', 'sessportz_responsive_layout'), 'general_settings_group', array('disableLoadDefaultDecorators' => true));
    $general_settings_group = $this->getDisplayGroup('general_settings_group');
    $general_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'general_settings_group'))));


     //New File System Code
    $banner_options = array('' => '');
    $files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
    foreach( $files as $file ) {
      $banner_options[$file->storage_path] = $file->name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sessportz_body_background_image', array(
        'label' => 'Body Background Image',
        'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_body_background_image'),
    ));
    $this->sessportz_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));




//       $this->addElement('Radio', 'sessportz_user_photo_round', array(
//           'label' => 'Show Thumb Icons in Round?',
//           'description' => 'Do you want to show the “thumb icons” of members’ photos and images of content from various plugins in round shape?',
//           'multiOptions' => array(
//               1 => 'Yes',
//               2 => 'No'
//           ),
//           'value' => Engine_Api::_()->sessportz()->getContantValueXML('sessportz_user_photo_round'),
//       ));

			$this->addElement('Radio', 'sessportz_mini_user_photo_round', array(
          'label' => 'Member Avatar Shape in Mini Menu.',
          'description' => 'Choose from below the shape of the member avatar to be shown in Mini Navigation menu.',
          'multiOptions' => array(
              1 => 'Circle',
              0 => 'Square'
          ),
          'value' => $settings->getSetting('sm.mini.user.photo.round',1),
      ));

      /*$this->addElement('Radio', 'sessportz_header_show_nologin', array(
          'label' => 'Show Main Menu to Non Logged-in users?',
          'description' => 'Do you want to show the “Main Menu” of website to non logged-in users?',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'value' => $settings->getSetting('sessportz.header.show.nologin', 1),
      ));*/

			$this->addElement('MultiCheckbox', 'sessportz_header_loggedin_options', array(
          'label' => 'Show Header Options to Logged-in members?',
          'description' => 'Choose from below the header options that you want to be shown to Logged-in members on your website.',
          'multiOptions' => array(
              'search' => 'Search',
              'miniMenu' => 'Mini Menu',
							'mainMenu' =>'Main Menu',
							'logo' =>'Logo',
          ),
          'value' => $settings->getSetting('sessportz.header.loggedin.options',array('search','miniMenu','mainMenu','logo')),
      ));

			$this->addElement('MultiCheckbox', 'sessportz_header_nonloggedin_options', array(
          'label' => 'Show Header Options to Non Logged-in users?',
          'description' => 'Choose from below the header options that you want to be shown to Non Logged-in users on your website.',
          'multiOptions' => array(
              'search' => 'Search',
              'miniMenu' => 'Mini Menu',
							'mainMenu' =>'Main Menu',
							'logo' =>'Logo',
          ),
          'value' => $settings->getSetting('sessportz.header.nonloggedin.options', array('search','miniMenu','mainMenu','logo')),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {

      $header_set = $settings->getSetting('sessportz.header.set');
	    if(empty($header_set)) {
		    $this->addElement('Checkbox', 'sessportz_header_set', array(
		      'description' => 'Enable Advanced Header',
		      'label' => 'Do you want to enable Advanced Header from this theme? (Note: If you select No, then the Advanced Header will not be set from this theme and the current header of your website will continue to work. You can anytime easily use the Advanced Header from this theme by placing the “Advanced Header” widget in the header of your website from Layout Editor.)',
		      'value' => 1,
		    ));
	    }

	    $footer_set = $settings->getSetting('sessportz.footer.set');
	    if(empty($footer_set)) {
		    $this->addElement('Checkbox', 'sessportz_footer_set', array(
		      'description' => 'Enable Advanced Footer',
		      'label' => 'Do you want to enable Advanced Footer from this theme? (Note: If you select No, then the Advanced Footer will not be set from this theme and the current footer of your website will continue to work. You can anytime easily use the Advanced Footer from this theme by placing the “Advanced Footer” widget in the footer of your website from Layout Editor.)',
		      'value' => 1,
		    ));
	    }

	    $landingpage_set = $settings->getSetting('sessportz.landingpage.set');
	    if(empty($landingpage_set)) {
		    $this->addElement('Checkbox', 'sessportz_landingpage_set', array(
		      'description' => 'Enable Landing Page',
		      'label' => 'Do you want to enable the Landing Page from this theme and replace the current Landing page with the one from this theme? (If you choose Yes, then we will make a backup page of your current "Landing Page" in the Layout Editor.)',
		      'value' => 0,
		    ));
	    }
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
