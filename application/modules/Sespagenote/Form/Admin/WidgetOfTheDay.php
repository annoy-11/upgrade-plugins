<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WidgetOfTheDay.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Form_Admin_WidgetOfTheDay extends Engine_Form {

  public function init() {

    $this->setTitle('SES - Page Note of the Day')
            ->setDescription('Displays the Page Note of The day as selected by the admin from the edit setting of this widget.');

    $this->addElement('MultiCheckbox', 'show_criteria', array(
        'label' => 'Choose from below the details that you want to show in this widget.',
        'multiOptions' => array(
            "title" => "Title",
            "by" => "Created By",
            'posteddate' => "Created On",
            'pagename' => "Page Name",
            "viewcount" => "Views Count",
            "likecount" => "Likes Count",
            'griddescription' => "Description",
            "commentcount" => "Comments Count",
            "favouritecount" => "Favorite Count",
            "featured" => "Featured Label",
            "sponsored" => "Sponsored Label",
            'socialSharing' => 'Social Share Buttons <a class="smoothbox" href="admin/sesbasic/settings/faqwidget">[FAQ]</a>',
            "likeButton" => "Like Button",
            "favouriteButton" => "Favorite Button",
        ),
        'escape' => false,
    ));

    $this->addElement('Text', 'height_grid', array(
        'label' => 'Enter the height of image block.',
        'value' => '160',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', 'width_grid', array(
        'label' => 'Enter the width of image block.',
        'value' => '160',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', 'grid_title_truncation', array(
        'label' => 'Title truncation limit.',
        'value' => 45,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));

    $this->addElement('Text', 'grid_description_truncation', array(
        'label' => 'Description truncation limit.',
        'value' => 60,
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
