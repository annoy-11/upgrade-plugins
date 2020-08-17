<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: TeamPageSettings.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Form_Admin_TeamPageSettings extends Engine_Form {

  public function init() {

    $this->addElement('Textarea', "sesteam_teampage_description", array(
        'label' => 'Enter the description for team page.',
        'value' => 'Meet Team',
    ));

    $this->addElement('Select', 'sesteam_type', array(
        'label' => 'Choose Member Type to be shown in this widget.',
        'multiOptions' => array(
            'teammember' => 'Site Team',
            'nonsitemember' => 'Non Site Team',
        ),
        'value' => 'teammember',
    ));

    $tempalte1 = 'http://demo.socialenginesolutions.com/pages/teamdesigns';

    $this->addElement('Radio', 'sesteam_template', array(
        'label' => 'Choose the design for team page.',
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

    $designations = Engine_Api::_()->getDbtable('designations', 'sesteam')->getDesignations(array('type' => 'TeamPageWidget'));
    if (count($designations) > 1) {
      $this->addElement('MultiCheckbox', 'designation_id', array(
          'label' => 'Choose the Designation belonging to which team members will be shown in this widget.',
          'multiOptions' => $designations,
      ));
    }

    $this->addElement('Select', 'popularity', array(
        'label' => 'Display Members',
        'multiOptions' => array(
            '' => '',
            'featured' => 'Only Featured Members',
            'sponsored' => 'Only Sponsored Members',
        ),
        'value' => '',
    ));

    $this->addElement('MultiCheckbox', 'sesteam_contentshow', array(
        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
        'multiOptions' => array(
            'featured' => 'Featured Label',
            'sponsored' => 'Sponsored Label',
            'displayname' => 'Display Name',
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

    $this->addElement('Select', 'center_heading', array(
        'label' => 'Do you want to center align the Heading of this widget?',
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


    $this->addElement('Text', 'limit', array(
        'label' => 'Enter limit of team you want to show in this widget.',
        'value' => 1,
    ));

    $this->addElement('Select', 'paginationType', array(
        'label' => 'Do you want the team to be auto-loaded when users scroll down the page?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No, show \'View More\''
        ),
        'value' => 1,
    ));
  }

}
