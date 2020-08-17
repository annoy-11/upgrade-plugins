<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Categorywidget.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_Categorywidget extends Engine_Form {

  public function init() {
    $this->addElement('textarea', "description", array(
        'label' => "Enter category description."
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
    if (count($banner_options) > 1) {
      $this->addElement('Select', 'sesgroup_categorycover_photo', array(
          'label' => 'Group Category Default Cover Photo',
          'description' => 'Choose a default cover photo for the group categories on your website. [Note: Add a new photo from the "File & Media Manager" section. For default cover photo, leave the field blank.]',
          'multiOptions' => $banner_options,
      ));
    } else {
      $description = "<div class='tip'><span>" . 'There are currently no photo to add for category cover. Image to be chosen for category cover should be first uploaded from the "Layout" >> "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section.' . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'category_cover', array(
          'label' => 'Group Category Default Cover Photo',
          'description' => $description,
      ));
      $this->category_cover->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }
    $this->addElement('Select', "show_popular_groups", array(
        'label' => "Do you want to show popular groups in this widget",
        'multiOptions' => array('1' => 'Yes,want to show popular group', 0 => 'No,don\'t want to show popular groups'),
        'value' => 1,
    ));
    $this->addElement('Text', "title_pop", array(
        'label' => "Enter the title for groups section.",
        'value' => 'Popular Groups',
    ));
    $this->addElement('Select', 'order', array(
        'label' => "Choose criteria for groups to be show in this widget.",
        'multiOptions' => array(
            '' => 'All Groups',
            'open' => 'Open',
            'close' => 'Close',
        ),
        'value' => '',
    ));
    $this->addElement('Select', 'info', array(
        'label' => "Choose Popularity Criteria for Groups.",
        'multiOptions' => array(
            "creation_date" => "Most Recent",
            "most_liked" => "Most Liked",
            "most_viewed" => "Most Viewed",
            "most_commented" => "Most Commented",
            "favourite_count" => "Most Favorited",
            "follow_count" => "Most Followed",
            'most_joined' => 'Most Joined',
        ),
        'value' => 'creation_date',
            )
    );
    $this->addElement('Text', 'height', array(
        'label' => 'Enter the height of banner (in pixels)',
        'value' => '180',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
            )
    );
    $this->addElement('Text', 'height_advgrid', array(
        'label' => 'Enter the height of group (in pixels)',
        'value' => '180',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
            )
    );
    $this->addElement('Text', "width", array(
        'label' => 'Enter the width of Advanced List View if banner is not applicable (in pixels).',
        'value' => '260',
    ));
    $this->addElement('Select', 'isfullwidth', array(
        'label' => 'Show this widget in full width?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 1,
            )
    );
    $this->addElement('Text', 'margin_top', array(
        'label' => 'Enter the value of the Margin Top for this widget (in pixels). (This setting will only work if the widget is chosen to be placed in full width.)',
        'value' => 30,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        ),
            )
    );
  }

}
