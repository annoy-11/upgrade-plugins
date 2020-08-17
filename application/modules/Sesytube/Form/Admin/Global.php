<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesytube_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesytube.licensekey'),
    ));
    $this->getElement('sesytube_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    if ($settings->getSetting('sesytube.pluginactivated')) {

        if (!$settings->getSetting('sesytube.changememberhomepage', 0)) {
            $this->addElement('Radio', 'sesytube_changememberhomepage', array(
                'label' => 'Set Landing Page as Member Home Page',
                'description' => 'Do you want to set the Landing Page of this theme as Member Home Page of your website? [This is a one time setting, so if you choose ‘Yes’ and save changes, then later you can manually make changes in the Member Home page from Layout Editor. Back up page of your current member home page will get created with the name "Member Home backup from SES - UTube Clone Theme".]',
                'onclick' => 'confirmChangeMemberHomePage(this.value)',
                'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No',
                ),
                'value' => $settings->getSetting('sesytube.changememberhomepage', 0),
            ));
        }
			//UPLOAD PHOTO URL
			$upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesytube', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
			if (!$settings->getSetting('sesytube.layout.enable', 0)) {
				$this->addElement('Radio', 'sesytube_layout_enable', array(
						'label' => 'Set YouTube Theme Landing Page',
						'description' => 'Do you want to set YouTube Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the YouTube Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesytube.layout.enable', 0),
				));
			}

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
			$this->addElement('Select', 'sesytube_body_background_image', array(
					'label' => 'Body Background Image',
					'description' => 'Choose from below the body background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
					'multiOptions' => $banner_options,
					'escape' => false,
					'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_body_background_image'),
			));
			$this->sesytube_body_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $this->addElement('Select', 'sesytube_user_photo_round', array(
          'label' => 'Thumbs Images Shape',
          'description' => 'Choose from below the shape of the thumb icons of members’ profile pictures and content profile photos.',
          'multiOptions' => array(
              1 => 'Yes',
              2 => 'No'
          ),
          'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_user_photo_round'),
      ));

      $this->addElement('Radio', 'sesytube_miniuserphotoround', array(
          'label' => 'Member Avatar Shape in Mini Menu',
          'description' => 'Choose from below the shape of the member avatar which is shown in Mini Navigation menu.',
          'multiOptions' => array(
              1 => 'Circle',
              0 => 'Square'
          ),
          'value' => $settings->getSetting('sesytube.miniuserphotoround',1),
      ));

		 $this->addElement('Text', "sesytube_left_columns_width", array(
						'label' => 'Left Column Width',
						'description' => "Enter the left column width of the website. This will affect all the pages on your website.",
						'allowEmpty' => false,
						'required' => true,
						'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_left_columns_width'),
				));

				$this->addElement('Text', "sesytube_right_columns_width", array(
						'label' => 'Right Column Width',
						'description' => 'Enter the right column width of the website. This will affect all the pages on your website.',
						'allowEmpty' => false,
						'required' => true,
						'value' => Engine_Api::_()->sesytube()->getContantValueXML('sesytube_right_columns_width'),
				));
			if (!$settings->getSetting('sesytube.layout.enable', 0)) {
				$this->addElement('Radio', 'sesytube_layout_enable', array(
						'label' => 'Set YouTube Theme Landing Page',
						'description' => 'Do you want to set YouTube Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the YouTube Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesytube.layout.enable', 0),
				));
			}

      $this->addElement('Select', 'sesytube_landingpage_style', array(
          'label' => 'Show Landing Page in Full Width',
          'description' => 'Do you want to show the Landing Page of your website in Full width?',
          'multiOptions' => array(
              1 => 'Yes, show in Full width',
              0 => 'No, show in Boxed style'
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.landingpage.style', 1),
      ));

			$this->addElement('Dummy', 'popup_settings', array(
					'label' => 'Sign In & Sign Up Popup Settings',
			));
			$this->addElement('Select', 'sesytube_popupsign', array(
					'label' => 'Enable Popup for Sign In & Sign Up',
					'description' => 'Do you want to enable popup for Sign In and Sign Up? If you select No, then users will be redirected to the login and signup pages when they will click respective options in the Mini Menu.',
					'multiOptions'=>array('1'=>'Yes','0'=>'No'),
						'onclick' => 'showPopup(this.value);',
					'value' => $settings->getSetting('sesytube.popupsign', '1'),
			));

			$this->addElement('Select', 'sesytube_popup_enable', array(
					'label' => 'Open Sign In Popup Automatically',
					'description' => 'Do you want the login popup to be displayed automatically when non-logged in users visit your website?',
					'multiOptions' => array(
							1 => 'Yes',
							0 => 'No'
					),
					'onclick' => 'loginsignupvisiablity(this.value);',
					'value' => $settings->getSetting('sesytube.popup.enable', 1),
			));

			$this->addElement('Text', 'sesytube_popup_day', array(
					'label' => 'Sign In Popup Visibility',
					'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
					'value' => $settings->getSetting('sesytube.popup.day', 5),
			));

      $this->addElement('Select', 'sesytube_popupfixed', array(
          'label' => 'Allow to Close Sign In Popup',
          'description' => 'Do you want to allow users to close the sign in and sign up popup? If you choose No, then users will not able to close the popup once opened and they have to forcefully login / signup to get into your community.',
          'multiOptions' => array(
              1 => 'No, do not allow to close popup',
              0 => 'Yes, allow to close popup'
          ),
          'value' => $settings->getSetting('sesytube.popupfixed', 0),
      ));


			// Add submit button
			$this->addElement('Button', 'submit', array(
					'label' => 'Save Changes',
					'type' => 'submit',
					'ignore' => true
			));
    } else {

			if (!$settings->getSetting('sesytube.layout.enable', 0)) {
				$this->addElement('Radio', 'sesytube_layout_enable', array(
						'label' => 'Set YouTube Theme Landing Page',
						'description' => 'Do you want to set YouTube Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the YouTube Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('sesytube.layout.enable', 0),
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
