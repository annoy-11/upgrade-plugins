<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: TeamMembersSettings.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Form_Admin_TeamMembersSettings extends Engine_Form {

  public function init() {

    $this->addElement('Select', 'sesteam_type', array(
        'label' => 'Choose Member Type to be shown in this widget.',
        'multiOptions' => array(
            'teammember' => 'Site Team',
            'nonsitemember' => 'Non Site Team',
        ),
        'value' => 'teammember',
    ));

    $designations = Engine_Api::_()->getDbtable('designations', 'sesteam')->getDesignations();
    if (count($designations) > 1) {
      $this->addElement('Select', 'designation_id', array(
          'label' => 'Choose the Designation belonging to which team members will be shown in this widget.',
          'multiOptions' => $designations,
      ));
    }

    $this->addElement('Radio', 'viewType', array(
        'label' => 'Choose the shape of Member Photo',
        'multiOptions' => array(
            1 => 'Square',
            0 => 'Round',
        ),
        'value' => 1,
    ));

    $this->addElement('Select', 'popularity', array(
        'label' => 'Popularity Criteria',
        'multiOptions' => array(
            '' => '',
            'featured' => 'Featured',
            'sponsored' => 'Sponsored',
        ),
        'value' => '',
    ));
    
    $this->addElement('MultiCheckbox', 'infoshow', array(
        'label' => 'Choose from below the details that you want to show in this widget. [Display of below options will depend on the Design chosen from above setting.]',
        'multiOptions' => array(
            'displayname' => 'Display Name',
            'designation' => 'Designation',
            'email' => 'Email',
            'phone' => 'Phone',
            'location' => 'Location',
            'website' => 'Website',
            'facebook' => 'Facebook Icon',
            'linkdin' => 'LinkedIn Icon',
            'twitter' => 'Twitter Icon',
            'googleplus' => 'Google Plus Icon',
            //'viewMore' => 'more'
        ),
        'value' => '',
    ));

    $this->addElement('Radio', 'nonloggined', array(
        'label' => 'Do you want to show this widget to non-logged in users?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => 1,
    ));

    $this->addElement('Text', "viewMoreText", array(
        'label' => 'Enter the text for "More as Team Member"',
        'value' => 'View Details',
    ));

    $this->addElement('Text', "limit", array(
        'label' => 'Count (number of members to show.)',
        'value' => 3,
    ));
  }

}
