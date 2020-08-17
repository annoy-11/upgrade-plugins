<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesfooter_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesfooter.licensekey'),
    ));
    $this->getElement('sesfooter_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		if ($settings->getSetting('sesfooter.pluginactivated')) {

	    //Start Footer Styling
	    $this->addElement('Dummy', 'footer_settings', array(
	        'label' => 'Footer Styling Settings',
	    ));

	    $this->addElement('Text', "ses_footer_width", array(
	        'label' => 'Footer Width',
	        'allowEmpty' => false,
	        'required' => true,
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_width'),
	    ));

	    $this->addElement('Text', "ses_footer_background_color", array(
	        'label' => 'Footer Background Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_background_color'),
	    ));

	    $this->addElement('Text', "ses_footer_border_color", array(
	        'label' => 'Footer Border Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_border_color'),
	    ));

	    $this->addElement('Text', "ses_footer_headings_color", array(
	        'label' => 'Footer Heading Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_headings_color'),
	    ));

	    $this->addElement('Text', "ses_footer_text_color", array(
	        'label' => 'Footer Text Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_text_color'),
	    ));

	    $this->addElement('Text', "ses_footer_link_color", array(
	        'label' => 'Footer Link Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_link_color'),
	    ));

	    $this->addElement('Text', "ses_footer_link_hover_color", array(
	        'label' => 'Footer Link Hover Color',
	        'allowEmpty' => false,
	        'required' => true,
	        'class' => 'SEScolor',
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_link_hover_color'),
	    ));

	    $this->addElement('Text', "ses_footer_button_color", array(
	      'label' => 'Footer Button Color',
	      'allowEmpty' => false,
	      'required' => true,
	      'class' => 'SEScolor',
	      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_button_color'),
	    ));

	    $this->addElement('Text', "ses_footer_button_hover_color", array(
	      'label' => 'Footer Button Hover Color',
	      'allowEmpty' => false,
	      'required' => true,
	      'class' => 'SEScolor',
	      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_button_hover_color'),
	    ));

	    $this->addElement('Text', "ses_footer_button_text_color", array(
	      'label' => 'Footer Button Text Color',
	      'allowEmpty' => false,
	      'required' => true,
	      'class' => 'SEScolor',
	      'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_button_text_color'),
	    ));

	    $this->addDisplayGroup(array('ses_footer_width', 'ses_footer_background_color','ses_footer_border_color', 'ses_footer_headings_color', 'ses_footer_text_color', 'ses_footer_link_color', 'ses_footer_link_hover_color', 'ses_footer_button_color', 'ses_footer_button_hover_color', 'ses_footer_button_text_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
	    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
	    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
	    //End Footer Styling


	    //$banner_options[] = '';
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
	    $this->addElement('Select', 'ses_footer_background_image', array(
	        'label' => 'Footer Background Image',
	        'description' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want any footer background image.]',
	        'multiOptions' => $banner_options,
	        'escape' => false,
	        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_background_image'),
	    ));
	    $this->ses_footer_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

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
	    $this->addElement('Select', 'sesfooter_footerlogo', array(
	        'label' => 'Choose Footer Logo',
	        'description' => 'Choose from below the footer logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show footer logo.]',
	        'multiOptions' => $banner_optionss,
	        'escape' => false,
	        'value' => $settings->getSetting('sesfooter.footerlogo', ''),
	    ));
	    $this->sesfooter_footerlogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


	    $this->addElement('Select', "sesfooter_logintext", array(
	        'label' => 'Show "Join, Share and Connect" text for Non-Loggined User in Footer',
	        'description' => 'Do you want to show "Join, Share and Connect" text for non-loggined user?',
	        'multiOptions' => array(
	            '1' => "Yes",
	            '0' => 'No',
	        ),
	        'onchange' => 'hideLanguage(this.value);',
	        'value' => $settings->getSetting('sesfooter.logintext', 1),
	    ));


			$contentText = '<p><img src="application/modules/Sesfooter/externals/images/bottom-text.png" alt=""></p><p><a href="sgnup">Join Now</a></p>';

	    //UPLOAD PHOTO URL
	    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesfooter', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
	      $coulmnName = 'sesfooter_footertext_' . $language;
	      $this->addElement('TinyMce', "sesfooter_footertext_$language", array(
	          'label' => 'Footer Image Text for ' . @$languages[@$key],
	          'Description' => 'Enter or modify the footer image text to be displayed in the "Footer" of your site.',
	          'required' => false,
	          'allowEmpty' => true,
	          'editorOptions' => $editorOptions,
	          'value' => $settings->getSetting("sesfooter.footertext.$language", $contentText),
	      ));
	    }

			//Add submit button
			$this->addElement('Button', 'submit', array(
				'label' => 'Save Changes',
				'type' => 'submit',
				'ignore' => true
			));
	  } else {
			if (APPLICATION_ENV == 'production') {
				$this->addElement('Checkbox', 'system_mode', array(
					'label' => 'Please make sure that you change the mode of your website from "Production Mode" to "Development Mode" before activating the plugin and again to "Production Mode" after successfully activating the plugin to reflect CSS changes from this plugin on user side.',
					'description' => 'System Mode',
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
