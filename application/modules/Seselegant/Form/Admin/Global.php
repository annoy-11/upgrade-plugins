<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "seselegant_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('seselegant.licensekey'),
    ));
    $this->getElement('seselegant_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('seselegant.pluginactivated')) {
			//UPLOAD PHOTO URL
			$upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'seselegant', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
			if (!$settings->getSetting('seselegant.layout.enable', 0)) {
				$this->addElement('Radio', 'seselegant_layout_enable', array(
						'label' => 'Set Elegant Theme Landing Page',
						'description' => 'Do you want to set Elegant Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Elegant Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('seselegant.layout.enable', 0),
				));
			}
			//percent || px setting for layout
// 			$this->addElement('Select', 'seselegant_layout_settingcss', array(
// 					'label' => 'Site Width Unit',
// 					'description' => 'Choose from below the unit for the width of your website.',
// 					'multiOptions' => array(
// 							'per' => 'Percentage',
// 							'px' => 'Pixel'
// 					),
// 					'value' => $settings->getSetting('seselegant.layout.settingcss', 'per'),
// 			));
// 			//layout height
// 			$this->addElement('Text', 'seselegant_layout_width', array(
// 					'label' => 'Site Width',
// 					'description' => 'Enter the width of your website.',
// 					'value' => $settings->getSetting('seselegant.layout.width', 95),
// 							)
// 			);
//
// 			//percent || px setting for left column layout
// 			$this->addElement('Select', 'seselegant_left_settingcss', array(
// 					'label' => 'Site Left Width Unit',
// 					'description' => 'Choose from below the unit for the left column width of your website.',
// 					'multiOptions' => array(
// 							'per' => 'Percentage',
// 							'px' => 'Pixel'
// 					),
// 					'value' => $settings->getSetting('seselegant.left.settingcss', 'per'),
// 			));
// 			//layout left
// 			$this->addElement('Text', 'seselegant_left_width', array(
// 					'label' => 'Site Left Width',
// 					'description' => 'Enter the left width of your website.',
// 					'value' => $settings->getSetting('seselegant.left.width', 25),
// 							)
// 			);
//
// 			//percent || px setting for right column layout
// 			$this->addElement('Select', 'seselegant_right_settingcss', array(
// 					'label' => 'Site Right Width Unit',
// 					'description' => 'Choose from below the unit for the right column width of your website.',
// 					'multiOptions' => array(
// 							'per' => 'Percentage',
// 							'px' => 'Pixel'
// 					),
// 					'value' => $settings->getSetting('seselegant.right.settingcss', 'per'),
// 			));
// 			//layout right
// 			$this->addElement('Text', 'seselegant_right_width', array(
// 					'label' => 'Site Right Width',
// 					'description' => 'Enter the right width of your website.',
// 					'value' => $settings->getSetting('seselegant.right.width', 25),
// 							)
// 			);
			$this->addElement('Radio', 'seselegant_popup_enable', array(
					'label' => 'Display Automatic Login Popup?',
					'description' => 'Do you want the Login Popup to be displayed automatically when non-logged in users visit your website?',
					'multiOptions' => array(
							1 => 'Yes',
							0 => 'No'
					),
					'onclick' => 'showPopup(this.value);',
					'value' => $settings->getSetting('seselegant.popup.enable', 1),
			));

			$this->addElement('Text', 'seselegant_popup_day', array(
					'label' => 'Login Popup Visibility',
					'description' => 'After how many days will the login popup be visible to non-logged in users once closed? [Enter ‘0’, if you want login popup to be visible each time non-logged in users visit your website.]',
					'value' => $settings->getSetting('seselegant.popup.day', 5),
			));

			$textblockcontent = '<div class="elegant_home_content_block sesbasic_bxs"><div class="elegant_home_content_block_inner"><div class="elegant_home_content_block_top"><h3 class="elegant_home_content_block_title">Share Photos, Videos and Music on your Community!</h3><p class="elegant_home_content_block_des">Videos are more engaging as compared to the static content on your website. Photos are capture your memory. Music Songs are refresh your mind.</p></div><div class="elegant_home_content_features"><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img1.png" alt=""> <span class="elegant_home_content_feature_head">Share Your Photos</span><p class="elegant_home_content_feature_des">Share your photos with your friends &amp; family and Upload pictures.</p><a class="elegant_home_content_feature_more" href="albums">Explore</a></div><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img2.png" alt=""> <span class="elegant_home_content_feature_head">Watch Videos</span><p class="elegant_home_content_feature_des">Simply register for an account and watch ultimate videos.</p> <a class="elegant_home_content_feature_more" href="videos">Explore</a></div><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img3.png" alt=""> <span class="elegant_home_content_feature_head">Play Music</span><p class="elegant_home_content_feature_des">Play music from your favorites artists and share and connect to songs.</p><a class="elegant_home_content_feature_more" href="music/album/home">Explore</a></div> </div></div></div>';

			$this->addElement('TinyMce', 'seselegant_block_1', array(
					'label' => 'Text and Feature Blocks',
					'Description' => 'Enter or modify the text and feature blocks to displayed in the "Text and Feature Blocks" widget placed on the Landing page of your site. [If you want, you can place the widget anywhere on your site.]',
					'required' => true,
					'allowEmpty' => false,
					'editorOptions' => $editorOptions,
					'value' => $settings->getSetting('seselegant.block.1', $textblockcontent),
			));

			if (!$settings->getSetting('seselegant.layout.enable', 0)) {
				$this->addElement('Radio', 'seselegant_layout_enable', array(
						'label' => 'Set Elegant Theme Landing Page',
						'description' => 'Do you want to set Elegant Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Elegant Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('seselegant.layout.enable', 0),
				));
			}
			// Add submit button
			$this->addElement('Button', 'submit', array(
					'label' => 'Save Changes',
					'type' => 'submit',
					'ignore' => true
			));
    } else {

			if (!$settings->getSetting('seselegant.layout.enable', 0)) {
				$this->addElement('Radio', 'seselegant_layout_enable', array(
						'label' => 'Set Elegant Theme Landing Page',
						'description' => 'Do you want to set Elegant Landing page for your site? [Note: If you choose Yes, then your current settings will be overwritten by the Elegant Landing page and changes will not be recoverable.]',
						'multiOptions' => array(
								1 => 'Yes',
								0 => 'No'
						),
						'value' => $settings->getSetting('seselegant.layout.enable', 0),
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
