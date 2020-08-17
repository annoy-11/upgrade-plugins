<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesspectromedia_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Footer Settings')
            ->setDescription('These settings will affect the footer of your website.');

    $this->addElement('Radio', 'sm_footer_design', array(
        'label' => 'Footer Design',
        'description' => 'Choose Footer Design',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesspectromedia/externals/images/design/footer-1.jpg" alt="Footer Design - 1" />',
            2 => '<img src="./application/modules/Sesspectromedia/externals/images/design/footer-2.jpg" alt="Footer Design - 2" />',
            3 => '<img src="./application/modules/Sesspectromedia/externals/images/design/footer-3.jpg" alt="Footer Design - 3" />',
            4 => '<img src="./application/modules/Sesspectromedia/externals/images/design/footer-4.jpg" alt="Footer Design - 4" />',
        ),
				'escape' => false,
        'onchange' => 'show_settings(this.value)',
        'value' => Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_footer_design'),
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
    $this->addElement('Select', 'sm_footer_background_image', array(
        'label' => 'Footer Background Image',
        'description' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_footer_background_image'),
    ));
    $this->sm_footer_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


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
    $this->addElement('Select', 'sesspectromedia_footerlogo', array(
        'label' => 'Choose Footer Logo',
        'description' => 'Choose from below the footer logo image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show footer logo.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sesspectromedia.footerlogo', ''),
    ));
    $this->sesspectromedia_footerlogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Text', 'sesspectromedia_footer_aboutheading', array(
        'label' => 'About Heading',
        'description' => 'Enter About Heading',
        'value' => $settings->getSetting('sesspectromedia.footer.aboutheading', 'About Us'),
    ));

    $this->addElement('Text', 'sesspectromedia_footer_aboutdes', array(
        'label' => 'About Description',
        'description' => 'Enter About Description',
        'value' => $settings->getSetting('sesspectromedia.footer.aboutdes', ''),
    ));

		$this->addElement('Select', "sesspectromedia_logintext", array(
        'label' => 'Show "Join, Share and Connect" text for Non-Loggined User in Footer',
        'description' => 'Do you want to show "Join, Share and Connect" text for non-loggined user?',
        'multiOptions' => array(
            '1' => "Yes",
            '0' => 'No',
        ),
        'value' => $settings->getSetting('sesspectromedia.logintext', 1),
    ));

    $contentText = '<div class="sm_footer_top_section sesbasic_clearfix sesbasic_bxs">
  	<p><img src="application/modules/Sesspectromedia/externals/images/bottom-text.png" alt=""></p>
    <p><a id="popup-signup" data-effect="signup-link mfp-zoom-in" class="popup-with-move-anim" href="#user_signup_form">Join Now</a></p>
  </div>';

    //UPLOAD PHOTO URL
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesspectromedia', 'controller' => 'manage', 'action' => "upload-photo"), 'admin_default', true);

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
      if(@$lan[0] && @$lan[1]) {
	      $lan = @$lan[0] . @$lan[1];
      } else {
	      $lan = @$lan[0];
      }
      $coulmnName = 'sesspectromedia_footertext_' . $lan;

      $this->addElement('TinyMce', "sesspectromedia_footertext_$lan", array(
          'label' => 'Footer Image Text for ' . $languages[$key],
          'Description' => 'Enter or modify the footer image text to be displayed in the "Footer" of your site.',
          'required' => true,
          'allowEmpty' => false,
          'editorOptions' => $editorOptions,
          'value' => $settings->getSetting("sesspectromedia.footertext.$lan", $contentText),
      ));
    }

//     $this->addElement('TinyMce', 'sesspectromedia_footertext', array(
//         'label' => 'Footer Image Text',
//         'Description' => 'Enter or modify the text and feature blocks to be displayed in the "Footer" of your site.',
//         'required' => true,
//         'allowEmpty' => false,
//         'editorOptions' => $editorOptions,
//         'value' => $settings->getSetting('sesspectromedia.footertext', $contentText),
//     ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
