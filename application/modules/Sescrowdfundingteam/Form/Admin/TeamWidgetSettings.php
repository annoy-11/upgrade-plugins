<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: TeamWidgetSettings.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingteam_Form_Admin_TeamWidgetSettings extends Engine_Form {

  public function init() {

    $tempalte1 = 'http://demo.socialenginesolutions.com/pages/teamdesigns';

    $this->addElement('Radio', 'sesteam_template', array(
        'label' => 'Choose the design for team crowdfunding.',
        'multiOptions' => array(
            1 => '<a href="' . $tempalte1 . '" target="_blank">Design - 1</a>',
            2 => '<a href="' . $tempalte1 . '" target="_blank">Design - 2</a>',
            3 => '<a href="' . $tempalte1 . '" target="_blank">Design - 3</a>',
            4 => '<a href="' . $tempalte1 . '" target="_blank">Design - 4</a>',
            5 => '<a href="' . $tempalte1 . '" target="_blank">Design - 5</a>',
            6 => '<a href="' . $tempalte1 . '" target="_blank">Design - 6</a>',
        ),
        'escape' => false,
        'value' => 1,
    ));

    $this->addElement('MultiCheckbox', 'sesteam_contentshow', array(
        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
        'multiOptions' => array(
            'displayname' => 'Display Name',
            'photo' => 'Photo',
            'designation' => 'Designation',
            'description' => 'Short Description',
            'email' => 'Email',
            'phone' => 'Phone',
            'location' => 'Location',
            'website' => 'Website',
            'facebook' => 'Facebook Icon',
            'linkdin' => 'LinkedIn Icon',
            'twitter' => 'Twitter Icon',
            'googleplus' => 'Google Plus Icon',
            'viewMore' => 'more'
        ),
        'value' => '',
    ));

    $this->addElement('Text', "deslimit", array(
        'label' => 'Enter the limit of description.',
        'value' => 150,
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

    $this->addElement('Select', 'center_block', array(
        'label' => 'Do you want to center align team member’s blocks in this widget?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Select', 'center_description', array(
        'label' => 'Do you want to center align the Description of this widget?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));
  }
}
