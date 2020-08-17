<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesariana_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesariana.licensekey'),
    ));
    $this->getElement('sesariana_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesariana.pluginactivated')) {
			//UPLOAD PHOTO URL
			$upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesariana', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
			if (!$settings->getSetting('sesariana.layout.enable', 0)) {
				$this->addElement('Radio', 'sesariana_layout_enable', array(
						'label' => 'Set Ariana Theme Landing Page',
						'description' => 'Do you want to set Ariana Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Ariana Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesariana.layout.enable', 0),
				));
			}

  		$this->addElement('Select', "sesariana_responsive_layout", array(
					'label' => 'Enable Responsive CSS',
					'description' => 'Do you want to enable the responsive css for your website? If you select Yes, then the website will automatically adopt the device screen size.',
					'allowEmpty' => false,
					'required' => true,
					'multiOptions' => array(
							'1' => 'Yes',
							'2' => "No",
					),
					'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_responsive_layout'),
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
			$this->addElement('Select', 'sesariana_body_background_image', array(
					'label' => 'Body Background Image',
					'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
					'multiOptions' => $banner_options,
					'escape' => false,
					'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_body_background_image'),
			));
			$this->sesariana_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sesariana_user_photo_round', array(
          'label' => 'Thumbs Images Shape',
          'description' => 'Choose from below the shape of the thumb icons of members’ profile pictures and content profile photos.',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_user_photo_round'),
      ));

      $this->addElement('Radio', 'sesariana_miniuserphotoround', array(
          'label' => 'Member Avatar Shape in Mini Menu',
          'description' => 'Choose from below the shape of the member avatar which is shown in Mini Navigation menu.',
          'multiOptions' => array(
              1 => 'Circle',
              0 => 'Square'
          ),
          'value' => $settings->getSetting('sesariana.miniuserphotoround',1),
      ));

		 $this->addElement('Text', "sesariana_left_columns_width", array(
						'label' => 'Left Column Width',
						'description' => "Enter the left column width of the website. This will affect all the pages on your website.",
						'allowEmpty' => false,
						'required' => true,
						'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_left_columns_width'),
				));

				$this->addElement('Text', "sesariana_right_columns_width", array(
						'label' => 'Right Column Width',
						'description' => 'Enter the right column width of the website. This will affect all the pages on your website.',
						'allowEmpty' => false,
						'required' => true,
						'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_right_columns_width'),
				));

      $this->addElement('Select', 'sesariana_feed_style', array(
        'label' => 'Activity Feed Style',
        'description' => 'Below, choose the style for displaying activity feeds on your website.',
        'multiOptions'=>array('1'=>'Simple Style','2'=>'Designed Block'),
        'value' => $settings->getSetting('sesariana.feed.style', '2'),
    ));

			if (!$settings->getSetting('sesariana.layout.enable', 0)) {
				$this->addElement('Radio', 'sesariana_layout_enable', array(
						'label' => 'Set Ariana Theme Landing Page',
						'description' => 'Do you want to set Ariana Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Ariana Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesariana.layout.enable', 0),
				));
			}

      $this->addElement('Select', 'sesariana_landingpage_style', array(
          'label' => 'Show Landing Page in Full Width',
          'description' => 'Do you want to show the Landing Page of your website in Full width?',
          'multiOptions' => array(
              1 => 'Yes, show in Full width',
              0 => 'No, show in Boxed style'
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.landingpage.style', 1),
      ));

			$this->addElement('Dummy', 'popup_settings', array(
					'label' => 'Sign In & Sign Up Popup Settings',
			));
			$this->addElement('Select', 'sesariana_popupsign', array(
					'label' => 'Enable Popup for Sign In & Sign Up',
					'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
					'multiOptions'=>array('1'=>'Yes','0'=>'No'),
						'onclick' => 'showPopup(this.value);',
					'value' => $settings->getSetting('sesariana.popupsign', '1'),
			));

			$this->addElement('Select', 'sesariana_popup_enable', array(
					'label' => 'Open Sign In Popup Automatically',
					'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
					'multiOptions' => array(
							1 => 'Yes',
							0 => 'No'
					),
					'onclick' => 'loginsignupvisiablity(this.value);',
					'value' => $settings->getSetting('sesariana.popup.enable', 1),
			));

			$this->addElement('Text', 'sesariana_popup_day', array(
					'label' => 'Sign In Popup Visibility',
					'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
					'value' => $settings->getSetting('sesariana.popup.day', 5),
			));

      $this->addElement('Select', 'sesariana_popupfixed', array(
          'label' => 'Allow to Close Sign In Popup',
          'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
          'multiOptions' => array(
              1 => 'No, do not allow to close popup',
              0 => 'Yes, allow to close popup'
          ),
          'value' => $settings->getSetting('sesariana.popupfixed', 0),
      ));

			$this->addElement('Select', 'sesariana_loginsignuplogo', array(
					'label' => 'Logo for Sign In & Sign Up Popup',
					'description' => 'Choose from below logo image for the sign in and signup popup of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
					'multiOptions' => $banner_options,
					'escape' => false,
					'value' => $settings->getSetting('sesariana.loginsignuplogo', ''),
			));
			$this->sesariana_loginsignuplogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

			$this->addElement('Select', 'sesariana_loginsignupbgimage', array(
					'label' => 'Background Image for Sign In & Sign Up Popup',
					'description' => 'Choose from below the background image for the sign in and sign up popup of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
					'multiOptions' => $banner_options,
					'escape' => false,
					'value' => $settings->getSetting('sesariana.loginsignupbgimage', 'public/admin/popup-bg.png'),
			));
			$this->sesariana_loginsignupbgimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


			// Add submit button
			$this->addElement('Button', 'submit', array(
					'label' => 'Save Changes',
					'type' => 'submit',
					'ignore' => true
			));
    } else {

			if (!$settings->getSetting('sesariana.layout.enable', 0)) {
				$this->addElement('Radio', 'sesariana_layout_enable', array(
						'label' => 'Set Ariana Theme Landing Page',
						'description' => 'Do you want to set Ariana Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Ariana Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesariana.layout.enable', 0),
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
