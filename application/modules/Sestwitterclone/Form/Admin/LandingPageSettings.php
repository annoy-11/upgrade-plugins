<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: LandingPageSettings.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestwitterclone_Form_Admin_LandingPageSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Landing Page Settings')
            ->setDescription('From here you can configure below mentioned settings for the landing page of this theme.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
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
    $this->addElement('Select', 'sestwitterclone_landingpagelogo', array(
        'label' => 'Landing Page Logo',
        'description' => 'Choose Logo image for the landing page of this theme. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show Logo at the landing page.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sestwitterclone.landingpagelogo', ''),
    ));
    $this->sestwitterclone_landingpagelogo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Text', "sestwitterclone_textblock1", array(
      'label' => 'Text For Block 1',
      'description' => 'Enter Text for Block 1',
      'value' => $settings->getSetting('sestwitterclone.textblock1', 'Search your Interests.'),
    ));
    $this->addElement('Select', 'sestwitterclone_block1icon', array(
        'label' => 'Choose Icon for Text Block 1',
        'description' => 'Choose Icon for the Text Block 1 at Landing Page. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show Icon for this Text Block.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sestwitterclone.block1icon', ''),
    ));
    $this->sestwitterclone_block1icon->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Text', "sestwitterclone_textblock2", array(
      'label' => 'Text For Block 2',
      'description' => 'Enter Text for Block 2',
      'value' => $settings->getSetting('sestwitterclone.textblock2', 'Share your Ideas with others.'),
    ));
    $this->addElement('Select', 'sestwitterclone_block2icon', array(
        'label' => 'Choose Icon for Text Block 2',
        'description' => 'Choose Icon for the Text Block 2 at Landing Page. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.  Leave the field blank if you do not want to show Icon for this Text Block.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sestwitterclone.block2icon', ''),
    ));
    $this->sestwitterclone_block2icon->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Text', "sestwitterclone_textblock3", array(
      'label' => 'Text For Block 3',
      'description' => 'Enter Text for Block 3',
      'value' => $settings->getSetting('sestwitterclone.textblock3', 'Join & Communicate with people.'),
    ));
    $this->addElement('Select', 'sestwitterclone_block3icon', array(
        'label' => 'Choose Icon for Text Block 3',
        'description' => 'Choose Icon for the Text Block 3 at Landing Page. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>. Leave the field blank if you do not want to show Icon for this Text Block.]',
        'multiOptions' => $banner_optionss,
        'escape' => false,
        'value' => $settings->getSetting('sestwitterclone.block3icon', ''),
    ));
    $this->sestwitterclone_block3icon->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $this->addElement('Select','sestwitterclonetheme_loginform',array(
        'label' => 'Show Login Fields',
        'description' => 'Do you want to enable login fields at landing page?',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value'=>$settings->getSetting('sestwitterclonetheme.loginform',1),
    ));
    $this->addElement('Text', "sestwitterclone_rightheading", array(
      'label' => 'Right Side Heading',
      'description' => 'Enter text to be displayed in the right side heading.',
      'value' => $settings->getSetting('sestwitterclone.rightheading', 'Explore what’s going on around in the outside world!'),
    ));
    $this->addElement('Text', "sestwitterclone_rightdes", array(
      'label' => 'Right Side Description',
      'description' => 'Enter text to be displayed in the right side description.',
      'value' => $settings->getSetting('sestwitterclone.rightdes', 'Start your first tweet'),
    ));

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
