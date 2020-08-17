<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');


    $this->addElement('Text', "sessocialtube_licensekey", array(
        'label' => 'Enter License key',
        'description' => "Enter the your license key that is provided to you when you purchased this theme plugin. If you do not know your license key, please drop us a line from the Support Ticket section on SocialEngineSolutions website. (Key Format: XXXX-XXXX-XXXX-XXXX)",
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sessocialtube.licensekey'),
    ));
    if ($settings->getSetting('sessocialtube.pluginactivated')) {

    $this->addElement('Dummy', 'layout_settings', array(
        'label' => 'Layout Settings',
        'description' => 'Choose from below the settings for the Layout of the theme. These settings will affect all the existing Color Schemes of the theme including the custom color scheme made by you.',
    ));
    
    
    $this->addElement('Text', "socialtube_main_width", array(
        'label' => 'Theme Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_main_width'),
    ));

    $this->addElement('Text', "socialtube_left_columns_width", array(
        'label' => 'Left Column Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_left_columns_width'),
    ));

    $this->addElement('Text', "socialtube_right_columns_width", array(
        'label' => 'Right Column Width',
        'allowEmpty' => false,
        'required' => true,
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_right_columns_width'),
    ));

    $this->addElement('Select', "socialtube_header_fixed_layout", array(
        'label' => 'Header Fixed?',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '2' => "No",
        ),
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_header_fixed_layout'),
    ));

    $this->addElement('Select', "socialtube_responsive_layout", array(
        'label' => 'Enable Responsive CSS',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
            '1' => 'Yes',
            '2' => "No",
        ),
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_responsive_layout'),
    ));
    $this->addDisplayGroup(array('socialtube_main_width', 'socialtube_left_columns_width', 'socialtube_right_columns_width', 'socialtube_header_fixed_layout', 'socialtube_responsive_layout'), 'general_settings_group', array('disableLoadDefaultDecorators' => true));
    $general_settings_group = $this->getDisplayGroup('general_settings_group');
    $general_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'general_settings_group'))));
    
        
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
    $this->addElement('Select', 'socialtube_body_background_image', array(
        'label' => 'Body Background Image',
        'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want any body background image.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_body_background_image'),
    ));
    $this->socialtube_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
   
    
    $this->addElement('Select', 'socialtube_popup_heading_background_image', array(
        'label' => '"Smoothbox" Header Background Image',
        'description' => 'Choose from below the smoothbox header background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want any smoothbox header background image.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_popup_heading_background_image'),
    ));
    $this->socialtube_popup_heading_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Radio', 'socialtube_loading_image', array(
      'label' => 'Smoothbox Loading Image',
      'description' => 'Choose from below the loading image for smoothbox which will come on your website. (Note: This setting will not affect any other plugin loading image on your website.)',
      'multiOptions' => array(
          1 => "Image 1 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading1.gif" alt="Loading 1" height="16" />',
          2 => "Image 2 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading2.gif" alt="Loading 2" height="16" />',
          3 => "Image 3 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading3.gif" alt="Loading 3" height="16" />',
          4 => "Image 4 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading4.gif" alt="Loading 4" height="16" />',
          5 => "Image 5 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading5.gif" alt="Loading 5" height="16" />',
          6 => "Image 6 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading6.gif" alt="Loading 6" height="16" />',
          7 => "Image 7 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading7.gif" alt="Loading 7" height="16" />',
          8 => "Image 8 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading8.gif" alt="Loading 8" height="16" />',
          9 => "Image 9 " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading9.gif" alt="Loading 9" height="16" />',
          10 => "Default " . '<img src="application/modules/Sessocialtube/externals/images/loading/loading10.gif" alt="Default" height="16" />',
      ),
      'escape' => false,
      'value' => $settings->getSetting('socialtube.loading.image', 10),
    ));

    $this->addElement('Radio', 'socialtube_user_photo_round', array(
        'label' => 'Show Thumb Icons in Round?',
        'description' => 'Do you want to show the “thumb icons” of members’ photos and images of content from various plugins in round shape?',
        'multiOptions' => array(
            1 => 'Yes',
            2 => 'No'
        ),
        'value' => Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_user_photo_round'),
    ));
    
    $this->addElement('Radio', 'socialtube_mini_user_photo_round', array(
        'label' => 'Member Avatar Shape in Mini Menu',
        'description' => 'Choose from below the shape of the member avatar to be shown in Mini Navigation menu.',
        'multiOptions' => array(
            1 => 'Circle',
            0 => 'Square'
        ),
        'value' => $settings->getSetting('socialtube.mini.user.photo.round',1),
    ));
    
    /*$this->addElement('Radio', 'socialtube_header_show_nologin', array(
        'label' => 'Show Main Menu to Non Logged-in users?',
        'description' => 'Do you want to show the “Main Menu” of website to non logged-in users?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('socialtube.header.show.nologin', 1),
    ));*/

    $this->addElement('MultiCheckbox', 'socialtube_header_loggedin_options', array(
        'label' => 'Show Header Options to Logged-in members?',
        'description' => 'Choose from below the header options that you want to be shown to Logged-in members on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Mini Menu',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
        ),
        'value' => $settings->getSetting('socialtube.header.loggedin.options',array('search','miniMenu','mainMenu','logo')),
    ));
    
    $this->addElement('MultiCheckbox', 'socialtube_header_nonloggedin_options', array(
        'label' => 'Show Header Options to Non Logged-in users?',
        'description' => 'Choose from below the header options that you want to be shown to Non Logged-in users on your website.',
        'multiOptions' => array(
            'search' => 'Search',
            'miniMenu' => 'Mini Menu',
            'mainMenu' =>'Main Menu',
            'logo' =>'Logo',
        ),
        'value' => $settings->getSetting('socialtube.header.nonloggedin.options', array('search','miniMenu','mainMenu','logo')),
    ));
    
    $this->addElement('Radio', 'sessocialtube_popupshow', array(
        'label' => 'Show Login / Signup Popup',
        'description' => 'Do you want show Login and Signup Popups or do you want the uses to be redirected to users to login and signup pages when non-logged in users clicks on Sign and Signup links respectively?',
        'multiOptions' => array(
            1 => 'Yes, show Login / Signup popups.',
            0 => 'No, redirect users to login and signup pages.'
        ),
        'onclick' => 'showLoginPopup(this.value);',
        'value' => $settings->getSetting('sessocialtube.popupshow', 1),
    ));

    
    $this->addElement('Radio', 'sessocialtube_popup_enable', array(
        'label' => 'Display Automatic Login Popup?',
        'description' => 'Do you want the Login Popup to be displayed automatically when non-logged in users visit your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('sessocialtube.popup.enable', 1),
    ));

    $this->addElement('Text', 'sessocialtube_popup_day', array(
        'label' => 'Login Popup Visibility',
        'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
        'value' => $settings->getSetting('sessocialtube.popup.day', 5),
    ));

      $contentText = '<div class="socialtube_lp_text_block">
	<div style="margin:0 auto;text-align:center;">
  	<h2 style="font-size:30px;font-weight:normal;margin-bottom:20px;text-transform:uppercase;">HELP US MAKE VIDEO BETTER</h2>
    <p style="padding:0 100px;font-size:20px;margin-bottom:20px;">You can help us make Videos even better by uploading your own content. Simply register for an account, select which content you want to contribute and then use our handy upload tool to add them to our library.</p>
    <ul>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/media.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 1) Select a Media</p>
      </li>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/media-upload.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 1) Upload to video</p>
      </li>
    	<li style="display:inline-block;width:30%;">
      	<div style="background-position:center center;background-repeat:no-repeat;display:block;margin:0 auto;height:200px;width:200px;background-image: url(application/modules/Sessocialtube/externals/images/thumbsup.png);"></div>
        <p style="font-size:20px;font-weight:bold;">Step 3) Feel Awesome</p>
      </li>
    </ul>
  </div>
</div>';

      //UPLOAD PHOTO URL
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sessocialtube', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

      $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

      $editorOptions = array(
          'upload_url' => $upload_url,
          'html' => (bool) $allowed_html,
      );

      if (!empty($upload_url)) {
        $editorOptions['plugins'] = array(
            'table', 'fullscreen', 'media', 'preview', 'paste',
            'code', 'image', 'textcolor', 'jbimages', 'link'
        );

        $editorOptions['toolbar1'] = array(
            'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
            'media', 'image', 'jbimages', 'link', 'fullscreen',
            'preview'
        );
      }
      
	    $languages = Zend_Locale::getTranslationList('language', Zend_Registry::get('Locale'));
	    $languageList = Zend_Registry::get('Zend_Translate')->getList();

	    foreach ($languageList as $key => $language) { 
	      $lan = explode('_', $language);
	      if($lan[0] && $lan[1]) {
		      $lan = $lan[0] . $lan[1];
	      } else {
		      $lan = $lan[0];
	      }
	      
        $coulmnName = 'sessocialtube_landinapagetext_' . $lan;

	      $this->addElement('TinyMce', "sessocialtube_landinapagetext_$lan", array(
	          'label' => 'Text and Feature Blocks for ' . $languages[$key],
	          'Description' => 'Enter or modify the text and feature blocks to displayed in the "Text and Feature Blocks" widget placed on the Landing page of your site. [If you want, you can place the widget anywhere on your site.]',
	        //  'required' => true,
	         // 'allowEmpty' => false,
	          'editorOptions' => $editorOptions,
	          'value' => $settings->getSetting("sessocialtube.landinapagetext.$lan", $contentText),
	      ));
	    }

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
    
      $header_set = $settings->getSetting('sessocialtube.header.set');
	    if(empty($header_set)) {
		    $this->addElement('Checkbox', 'sessocialtube_header_set', array(
		      'description' => 'Enable Advanced Header',
		      'label' => 'Do you want to enable Advanced Header from this theme? (Note: If you select No, then the Advanced Header will not be set from this theme and the current header of your website will continue to work. You can anytime easily use the Advanced Header from this theme by placing the “Advanced Header” widget in the header of your website from Layout Editor.)',
		      'value' => 1,
		    ));
	    }
	    
	    $footer_set = $settings->getSetting('sessocialtube.footer.set');
	    if(empty($footer_set)) {
		    $this->addElement('Checkbox', 'sessocialtube_footer_set', array(
		      'description' => 'Enable Advanced Footer',
		      'label' => 'Do you want to enable Advanced Footer from this theme? (Note: If you select No, then the Advanced Footer will not be set from this theme and the current footer of your website will continue to work. You can anytime easily use the Advanced Footer from this theme by placing the “Advanced Footer” widget in the footer of your website from Layout Editor.)',
		      'value' => 1,
		    ));
	    }
	    
	    $landingpage_set = $settings->getSetting('sessocialtube.landingpage.set');
	    if(empty($landingpage_set)) {
		    $this->addElement('Checkbox', 'sessocialtube_landingpage_set', array(
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
