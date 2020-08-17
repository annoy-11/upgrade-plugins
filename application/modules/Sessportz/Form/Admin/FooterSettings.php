<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sessportz_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Footer Settings')
            ->setDescription('These settings will affect the footer of your website.');
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
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sessportz_footerbgimage', array(
        'label' => 'Footer Background Image',
        'description' => 'Choose from below the background image for footer of your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show logo.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => $settings->getSetting('sessportz.footerbgimage', ''),
    ));
    $this->sessportz_footerbgimage->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Textarea', 'sessportz_footer_aboutdes', array(
        'label' => 'About Description',
        'description' => 'Enter About Description',
        'value' => $settings->getSetting('sessportz.footer.aboutdes', ''),
    ));

    $this->addElement('Textarea', 'sessportz_twitter_embedcode', array(
        'label' => 'Twitter Embed Code',
        'description' => 'Enter the twitter embed code.',
        'value' => $settings->getSetting('sessportz.twitter.embedcode', ''),
    ));

    $this->addElement('Select', 'sessportz_foshow', array(
        'label' => 'Show News Section',
        'description' => 'Do you want to show news section?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'onchange' => 'show_settings(this.value)',
        'value' => $settings->getSetting('sessportz.foshow', 1),
    ));

    $moduleEnable = Engine_Api::_()->sessportz()->getModulesEnable();
    $this->addElement('Select', 'sessportz_fo_module', array(
        'label' => 'Choose the Module to be shown in footer.',
        'description' => 'Choose the Module to be shown in footer.',
        'multiOptions' => $moduleEnable,
        'value' => $settings->getSetting('sessportz.fo.module', 'album'),
    ));

    $this->addElement('Select', 'sessportz_fo_popularitycriteria', array(
        'label' => 'Choose the popularity criteria for footer.',
        'description' => 'Choose the popularity criteria for footer.',
        'multiOptions' => array(
            'creation_date' => 'Recently Created',
            'view_count' => 'View Count',
            'like_count' => 'Most Liked',
            'comment_count' => 'Most Commented',
            'modified_date' => 'Recently Modified'
        ),
        'value' => $settings->getSetting('sessportz.fo.popularitycriteria', 'creation_date'),
    ));



    $this->addElement('Text', 'sessportz_con_location', array(
        'label' => 'Contact Us Location',
        'description' => 'Enter Contact Us Location',
        'value' => $settings->getSetting('sessportz.con.location', ''),
    ));
    $this->addElement('Text', 'sessportz_con_phone', array(
        'label' => 'Contact Us Phone',
        'description' => 'Enter Contact Us Phone',
        'value' => $settings->getSetting('sessportz.con.phone', ''),
    ));
    $this->addElement('Text', 'sessportz_con_email', array(
        'label' => 'Contact Us Email',
        'description' => 'Enter Contact Us Email',
        'value' => $settings->getSetting('sessportz.con.email', ''),
    ));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
