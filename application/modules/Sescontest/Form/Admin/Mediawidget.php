<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Mediawidget.php  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescontest_Form_Admin_Mediawidget extends Engine_Form {

  public function init() {
    $this->addElement('Text', 'banner_title', array(
        'label' => 'Enter the Title.',
        'value' => 'Explore Contests by Media Types',
    ));
    $this->addElement('Textarea', 'description', array(
        'label' => 'Enter the Description.',
        'value' => 'We have contests in all possible Media Types with various categories & subcategories. Create or Join contests.',
    ));
    $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Select the Media Types you want to show in this widget.",
        'multiOptions' => array(
            'photo' => 'Photo',
            'video' => 'Video',
            'music' => 'Music / Audio',
            'text' => 'Text',
        ),
    ));
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
    $this->addElement('Text', 'photo_text', array(
        'label' => 'Enter Text.',
        'value' => 'PHOTOS',
    ));
    $this->addElement('Select', 'photo_image', array(
        'label' => '',
        'description' => 'Choose Image [Note: Add a new photo from the "File & Media Manager" section.]
',
        'multiOptions' => $banner_options,
    ));
    $this->addElement('Text', 'video_text', array(
        'label' => 'Enter Text.',
        'value' => 'VIDEOS',
    ));
    $this->addElement('Select', 'video_image', array(
        'label' => '',
        'description' => 'Choose Image [Note: Add a new photo from the "File & Media Manager" section.]
',
        'multiOptions' => $banner_options,
    ));
    $this->addElement('Text', 'audio_text', array(
        'label' => 'Enter Text.',
        'value' => 'MUSIC',
    ));
    $this->addElement('Select', 'audio_image', array(
        'label' => '',
        'description' => 'Choose Image [Note: Add a new photo from the "File & Media Manager" section.]
',
        'multiOptions' => $banner_options,
    ));
    $this->addElement('Text', 'blog_text', array(
        'label' => 'Enter Text.',
        'value' => 'TEXT',
    ));
    $this->addElement('Select', 'text_image', array(
        'label' => '',
        'description' => 'Choose Image [Note: Add a new photo from the "File & Media Manager" section.]
',
        'multiOptions' => $banner_options,
    ));
  }

}
