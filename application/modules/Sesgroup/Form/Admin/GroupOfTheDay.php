<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: GroupOfTheDay.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_GroupOfTheDay extends Engine_Form {

  public function init() {

    $this->setTitle('Group of the Day')
            ->setDescription('Displays the Group of The day as selected by the admin from the edit setting of this widget.');

    if (1) {
      $categories = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getCategoriesAssoc();
      $categories = array('' => '') + $categories;
      // category field
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => true,
          'required' => false,
      ));
    }
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('seslocation')) {
      $this->addElement('Radio', 'locationEnable', array(
          'label' => 'Do you want to show content in this widget based on the Location chosen by users on your website? (This is dependent on the “Location Based Member & Content Display Plugin”. Also, make sure location is enabled and entered for the content in this plugin. If setting is enabled and the content does not have a location, then such content will not be shown in this widget.)
',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => 0
      ));
    }
    $this->addElement('MultiCheckbox', 'information', array(
        'label' => 'Choose from below the details that you want to show in this widget.',
        'multiOptions' => array(
            "title" => "Title",
            "postedby" => "Created By",
            'category' => "Category",
            'creationDate' => "Created On",
            'location' => "Location",
            'socialSharing' => 'Social Share Button <a href="">[FAQ]</a> ',
            "likeButton" => "Like Button",
            "favouriteButton" => "Favorite Button",
            "followButton" => "Follow Button",
            'joinButton' => 'Join Button',
            'contactButton' => 'Contact Button',
            "like" => "Likes Count",
            "comment" => "Comments Count",
            "view" => "Views Count",
            "favourite" => "Favorite Count",
            "follow" => "Follow Count",
            'member' => 'Member Count',
            "featuredLabel" => "Featured Label",
            "sponsoredLabel" => "Sponsored Label",
            "hotLabel" => "Hot Label",
            "verifiedLabel" => "Verified Label",
        ),
        'escape' => false,
    ));

    $this->addElement('Text', 'imageheight', array(
        'label' => 'Enter the height of image block.',
        'value' => '180',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', 'title_truncation', array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    //Social Share Plugin work
    $this->addElement('Select', "socialshare_enable_plusicon", array(
        'label' => "Enable More Icon for social share buttons?",
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', "socialshare_icon_limit", array(
        'label' => 'Count (number of social sites to show). If you enable More Icon, then other social sharing icons will display on clicking this plus icon.',
        'value' => 2,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    //Social Share Plugin work
  }

}
