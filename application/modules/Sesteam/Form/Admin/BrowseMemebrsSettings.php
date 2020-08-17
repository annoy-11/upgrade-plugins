<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: BrowseMemebrsSettings.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Form_Admin_BrowseMemebrsSettings extends Engine_Form {

  public function init() {

    $tempalte1 = 'http://demo.socialenginesolutions.com/pages/teamdesigns';

    $this->addElement('Radio', 'sesteam_template', array(
        'label' => 'Choose the design for the members to be displayed in this widget.',
        'multiOptions' => array(
            1 => '<a href="' . $tempalte1 . '" target="_blank">Design - 1</a>',
            2 => '<a href="' . $tempalte1 . '" target="_blank">Design - 2</a>',
            3 => '<a href="' . $tempalte1 . '" target="_blank">Design - 3</a>',
            4 => '<a href="' . $tempalte1 . '" target="_blank">Design - 4</a>',
            5 => '<a href="' . $tempalte1 . '" target="_blank">Design - 5</a>',
            6 => '<a href="' . $tempalte1 . '" target="_blank">Design - 6 [Profile Fields will not be shown in this template]</a>',
        ),
        'escape' => false,
        'value' => 1,
    ));

    $this->addElement('Select', 'popularity', array(
        'label' => 'Display Criteria',
        'multiOptions' => array(
            'creation_date' => 'Most Recent Member',
            'modified_date' => 'Recently Updated',
            'alphabetic' => "Alphabetic [A-Z]",
        ),
        'value' => 1,
    ));

    $this->addElement('MultiCheckbox', 'sesteam_contentshow', array(
        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
        'multiOptions' => array(
            'displayname' => 'Display Name',
            'profileType' => 'Profile Type',
            'status' => 'Status',
            'email' => 'Email',
            'message' => 'Message',
            'addFriend' => 'Add Friend / Cancel Request and etc..',
            'profileField' => 'Profile Field',
            'heading' => "Profile Field Heading [This setting only work if you choose 'Profile Field']",
            'viewMore' => 'more'
        ),
        'value' => '',
    ));

    $this->addElement('Select', 'labelBold', array(
        'label' => 'Show Profile Field Label in Bold.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Select', 'age', array(
        'label' => 'Show Member’s Age [Age will show even if any member has hide their "Birth Date"].',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', "profileFieldCount", array(
        'label' => 'Enter number of "Profile Fields" to be shown in this widget.',
        'value' => 5,
    ));

    $this->addElement('Text', "viewMoreText", array(
        'label' => 'Enter the text for "more" link.',
        'value' => 'View Details',
    ));

    $this->addElement('Text', "height", array(
        'label' => 'Enter the height of member photo (in pixels).',
        'value' => 200,
    ));

    $this->addElement('Text', "width", array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => 200,
    ));

    $this->addElement('Select', 'sesteam_social_border', array(
        'label' => 'Show border around Social Share Icons.',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Select', 'center_block', array(
        'label' => 'Do you want to center align team member’s blocks in this widget?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', "limitMembers", array(
        'label' => 'Count (number of members to show)',
        'value' => 10,
    ));
  }

}
