<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Footer Settings')
            ->setDescription('Here, you can configure the settings for the Footer of your website.');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		
		
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
    $this->addElement('Select', 'sesariana_footer_background_image', array(
        'label' => 'Footer Background Image',
        'description' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sesariana()->getContantValueXML('sesariana_footer_background_image'),
    ));
    $this->sesariana_footer_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sesariana_footerlogo', array(
        'label' => 'Logo in Footer',
        'description' => 'Choose from below the logo image for the footer of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sesariana.footerlogo', ''),
    ));
    $this->sesariana_footerlogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $fileLink = $view->baseUrl() . '/admin/menus/index/name/sesariana_quicklinks_footer';
    $this->addElement('Radio',
      'sesariana_quicklinksenable',
      array(
          'label' => 'Enable Quick Links',
          'description' => 'Do you want to enable quick links to your preferred links in the footer? If you choose Yes, the the menu items will display which have been configured from <a href="' . $fileLink . '" target="_blank">Click Here</a>.',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>$settings->getSetting('sesariana.quicklinksenable', '1'),
    ));
    $this->sesariana_quicklinksenable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Radio',
      'sesariana_helpenable',
      array(
          'label' => 'Enable Footer Menu Links',
          'description' => 'Do you want to enable the SocialEngine default <a href="admin/menus?name=core_footer" target="_blank">Footer Menu links in the footer</a>?',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>$settings->getSetting('sesariana.helpenable', '1'),
    ));
    $this->sesariana_helpenable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Radio',
    'sesariana_socialenable',
    array(
      'label' => 'Enable Social Site Links',
      'description' => 'Do you want to enable the social links in the footer?',
      'multiOptions' => array('1'=>'Yes','0'=>'No'),
      'onchange'=>'socialmedialinks(this.value)',
      'value'=>$settings->getSetting('sesariana.socialenable', '1'),
    ));

    $this->addElement(
      'Text',
      'sesariana_facebookurl',
      array(
        'label' => 'Facebook Page URL',
        'description' => 'Enter the URL of your Facebook Page.',
        'class'=>'socialclass',
        'value' => $settings->getSetting('sesariana.facebookurl', 'http://www.facebook.com/'),
      )
    );
    
    $this->addElement(
      'Text',
      'sesariana_googleplusurl',
        array(
          'label' => 'Google Plus URL',
          'description' => 'Enter the URL of your Google Plus account.',
          'class'=>'socialclass',
          'value' => $settings->getSetting('sesariana.googleplusurl', 'http://plus.google.com/'),
        )
    );
    
    $this->addElement(
      'Text',
      'sesariana_twitterurl',
      array(
        'label' => 'Twiiter URL',
        'description' => 'Enter the URL of your Twitter account.',
        'class'=>'socialclass',
        'value' => $settings->getSetting('sesariana.twitterurl', 'https://www.twitter.com/'),
      )
    );
    
    $this->addElement(
      'Text',
      'sesariana_pinteresturl',
      array(
        'label' => 'Pinterest URL',
        'description' => 'Enter the URL of your Pinterest account.',
        'class'=>'socialclass',
        'value' => $settings->getSetting('sesariana.pinteresturl', 'https://www.pinterest.com/'),
      )
    );
    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}