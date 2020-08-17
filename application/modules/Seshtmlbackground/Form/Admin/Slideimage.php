<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Banner.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seshtmlbackground_Form_Admin_Slideimage extends Engine_Form {

  public function init() {

//New File System Code
$banner_options = array('' => '');
$files = Engine_Api::_()->getDbTable('files', 'core')->getFiles(array('fetchAll' => 1, 'extension' => array('gif', 'jpg', 'jpeg', 'png')));
foreach( $files as $file ) {
  $banner_options[$file->storage_path] = $file->name;
}
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';

   
    $this->addElement('Select', 'bannervideo', array(
        'description' => 'Choose from below the banner video for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show video.]',
        'multiOptions' => $banner_options,
        'escape' => false,
    ));
    $this->bannervideo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $contentText = '<h2 style="font-size: 35px; font-weight: normal; margin-bottom: 20px; text-transform: uppercase;">HELP US MAKE VIDEO BETTER</h2>
			<p style="padding: 0 100px; font-size: 17px; margin-bottom: 20px;">You can help us make Videos even better by uploading your own content. Simply register for an account, select which content you want to contribute and then use our handy upload tool to add them to our library.</p>
			<ul>
				<li style="display: inline-block; width: 30%;">
					<h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
					<span style="font-size:17px;">HAPPY CLIENTS</span>
					<p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
				</li>
				<li style="display: inline-block; width: 30%;">
					<h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
					<span style="font-size:17px;">HAPPY CLIENTS</span>
					<p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
				</li>
				<li style="display: inline-block; width: 30%;">
					<h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
					<span style="font-size:17px;">HAPPY CLIENTS</span>
					<p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
				</li>
			</ul>';

      //UPLOAD PHOTO URL
     $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

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
      
      $this->addElement('TinyMce', 'paralextitle', array(
          'label' => 'Content',
          'Description' => 'Enter Content',
          'required' => true,
          'allowEmpty' => false,
          'editorOptions' => $editorOptions, 
					'value' => $contentText
      ));

    $this->addElement('Text', 'height', array(
        'label' => "Enter the height of this widget(in pixels).",
        'value' => '400',
    ));
  }

}
