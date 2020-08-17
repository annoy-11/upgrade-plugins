<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Emailtemplates_Form_Admin_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
		 
    $this->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "emailtemplates_licensekey", array(
      'label' => 'Enter License key',
      'description' => $descriptionLicense,
      'allowEmpty' => false,
      'required' => true,
      'value' => $settings->getSetting('emailtemplates.licensekey'),
    ));
    $this->getElement('emailtemplates_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    if ($settings->getSetting('emailtemplates.pluginactivated')) {
  
			//UPLOAD PHOTO URL
			$upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
			$allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
			$editorOptions = array(
					'upload_url' => $upload_url,
					'html' => (bool) $allowed_html,
			);
			
			if (!empty($upload_url)) {
			
				$editorOptions['editor_selector'] = 'tinymce';
				$editorOptions['mode'] = 'specific_textareas';
				$editorOptions['plugins'] = array(
						'table', 'fullscreen', 'media', 'preview', 'paste',
						'code', 'image', 'textcolor', 'jbimages', 'link'
				);
				$editorOptions['toolbar1'] = array(
						'undo', 'redo','format', 'pastetext', '|', 'code',
						'media', 'image', 'jbimages', 'link', 'fullscreen',
						'preview'
				);
			}
			if($settings->getSetting('emailtemplates.signature'))
				$tinymcevalue = $settings->getSetting('emailtemplates.signature');
			else
				$tinymcevalue = '<div style="text-align: center;">
								<p style="margin-top: 5px; font-weight: bold; color: #000; font-size: 13px; line-height: 26px;">This message was sent to you based on your interests and profile notification settings. If you do not want to receive these emails, please customize your <a style="color: #15a5dd;  text-decoration: none; text-transform: capitalize;" href="JavaScript:Void(0)">notification settings here.</a></p>
								</div>';
			
			$this->addElement('TinyMce', 'emailtemplates_signature', array(
				'label' => 'Make Signature',
				'description' => 'Make Signature from here which you want to show in Email Template.',
				'allowEmpty' => false,
				'required' => true,
				'class' => 'tinymce',
				'editorOptions' => $editorOptions,
				'value' => $tinymcevalue,
			));
			
			$this->addElement('Text', 'emailtemplates_facebook_url', array(
				'label' => 'Facebook URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.facebook.url'),
			));
			$this->addElement('Text', 'emailtemplates_twitter_url', array(
				'label' => 'Twitter URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.twitter.url'),
			));
			$this->addElement('Text', 'emailtemplates_linkedin_url', array(
				'label' => 'Linkedin URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.linkedin.url'),
			));
			$this->addElement('Text', 'emailtemplates_instagram_url', array(
				'label' => 'Instagram URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.instagram.url'),
			));
			$this->addElement('Text', 'emailtemplates_googleplus_url', array(
				'label' => 'Google Plus URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.googleplus.url'),
			));
			$this->addElement('Text', 'emailtemplates_pinterest_url', array(
				'label' => 'Pinterest URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.pinterest.url'),
			));
			$this->addElement('Text', 'emailtemplates_flickr_url', array(
				'label' => 'Flickr URL',
				'allowEmpty' => true,
				'required' => false,
				'value' => $settings->getSetting('emailtemplates.flickr.url'),
			));
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
