<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesexpose_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesexpose_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesexpose.licensekey'),
    ));
    $this->getElement('sesexpose_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('sesexpose.pluginactivated')) {
			//UPLOAD PHOTO URL
			$upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesexpose', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
			if (!$settings->getSetting('sesexpose.layout.enable', 0)) {
				$this->addElement('Radio', 'sesexpose_layout_enable', array(
						'label' => 'Set Expose Theme Landing Page',
						'description' => 'Do you want to set Expose Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Expose Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesexpose.layout.enable', 0),
				));
			}

// 			$this->addElement('Radio', 'sesexpose_popup_enable', array(
// 					'label' => 'Display Automatic Login Popup?',
// 					'description' => 'Do you want the Login Popup to be displayed automatically when non-logged in users visit your website?',
// 					'multiOptions' => array(
// 							1 => 'Yes',
// 							0 => 'No'
// 					),
// 					'onclick' => 'showPopup(this.value);',
// 					'value' => $settings->getSetting('sesexpose.popup.enable', 1),
// 			));

// 			$this->addElement('Text', 'sesexpose_popup_day', array(
// 					'label' => 'Login Popup Visibility',
// 					'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
// 					'value' => $settings->getSetting('sesexpose.popup.day', 5),
// 			));


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
      $this->addElement('Select', 'exp_body_background_image', array(
          'label' => 'Body Background Image',
          'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
          'multiOptions' => $banner_options,
          'escape' => false,
          'value' => Engine_Api::_()->sesexpose()->getContantValueXML('exp_body_background_image'),
      ));
      $this->exp_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', "sesexpose_responsive_layout", array(
          'label' => 'Enable Responsive CSS',
          'description' => 'Do you want to enable the responsive css for your website? If you select Yes, then the website will automatically adopt the device screen size.',
          'allowEmpty' => false,
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes',
              '2' => "No",
          ),
          'value' => $settings->getSetting('sesexpose.responsive.layout', 1),
      ));


			$this->addElement('Dummy', 'popup_settings', array(
					'label' => 'Sign In & Sign Up Popup Settings',
			));
			$this->addElement('Select', 'sesexpose_popupsign', array(
					'label' => 'Enable Popup for Sign In & Sign Up',
					'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
					'multiOptions'=>array('1'=>'Yes','0'=>'No'),
						'onclick' => 'showPopup(this.value);',
					'value' => $settings->getSetting('sesexpose.popupsign', '1'),
			));

			$this->addElement('Select', 'sesexpose_popup_enable', array(
					'label' => 'Open Sign In Popup Automatically',
					'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
					'multiOptions' => array(
							1 => 'Yes',
							0 => 'No'
					),
					'onclick' => 'loginsignupvisiablity(this.value);',
					'value' => $settings->getSetting('sesexpose.popup.enable', 1),
			));

			$this->addElement('Text', 'sesexpose_popup_day', array(
					'label' => 'Sign In Popup Visibility',
					'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
					'value' => $settings->getSetting('sesexpose.popup.day', 5),
			));

      $this->addElement('Select', 'sesexpose_popupfixed', array(
          'label' => 'Allow to Close Sign In Popup',
          'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
          'multiOptions' => array(
              1 => 'No, do not allow to close popup',
              0 => 'Yes, allow to close popup'
          ),
          'value' => $settings->getSetting('sesexpose.popupfixed', 0),
      ));



			if (!$settings->getSetting('sesexpose.layout.enable', 0)) {
				$this->addElement('Radio', 'sesexpose_layout_enable', array(
						'label' => 'Set Expose Theme Landing Page',
						'description' => 'Do you want to set Expose Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Expose Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesexpose.layout.enable', 0),
				));
			}

			// Add submit button
			$this->addElement('Button', 'submit', array(
					'label' => 'Save Changes',
					'type' => 'submit',
					'ignore' => true
			));
    } else {

			if (!$settings->getSetting('sesexpose.layout.enable', 0)) {
				$this->addElement('Radio', 'sesexpose_layout_enable', array(
						'label' => 'Set Expose Theme Landing Page',
						'description' => 'Do you want to set Expose Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Expose Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesexpose.layout.enable', 0),
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
