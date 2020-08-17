<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("BLOG_FORM_ADMIN_LEVEL_DESCRIPTION");
    // Element: level_id
    $multiOptions = array();
    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
      if( $level->type == 'public') {
        continue;
      }
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    $this->addElement('Select', 'level_id', array(
      'label' => 'Member Level',
      //'required' => true,
      //'allowEmpty' => false,
      'description' => 'Choose the Member Level to which you want to assign the below settings.',
          'multiOptions' => $multiOptions,
          'onchange' => 'fetchLevelSettings(this.value);',
    ));
    if( !$this->isPublic() ) {

      $this->addElement('MultiCheckbox', 'allowprofile', array(
        'label' => 'Enable Profile Information Field',
        'description' => 'Select from below profile information field that you want the members of this Member level can fill.',
        'multiOptions' => array(
          'experience' => 'Work Experience',
          'education' => 'Education',
          'skills' => 'Skills',
          'certificate' => 'Certification',
          'awards' => 'Honors & Awards',
          'organization' => 'Organizations',
          'course' => 'Courses',
          'project' => 'Projects',
          'language' => 'Languages',
        ),
        'value' => array('experience', 'education', 'skills', 'certificate', 'awards', 'organization', 'course', 'project', 'language'),
      ));

      $this->addElement('Text', 'exper_count', array(
        'label' => 'Maximum Allowed Work Experience Entries?',
        'description' => 'Enter the maximum number of allowed work experience entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'edution_count', array(
        'label' => 'Maximum Allowed Education Entries?',
        'description' => 'Enter the maximum number of allowed education entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'skill_count', array(
        'label' => 'Maximum Allowed Work Skills Entries?',
        'description' => 'Enter the maximum number of allowed work skills entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'cer_count', array(
        'label' => 'Maximum Allowed Certificate Entries?',
        'description' => 'Enter the maximum number of allowed certificate entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'awards_count', array(
        'label' => 'Maximum Allowed Awards Entries?',
        'description' => 'Enter the maximum number of allowed awards entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'org_count', array(
        'label' => 'Maximum Allowed Organization Entries?',
        'description' => 'Enter the maximum number of allowed work organizations entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'course_count', array(
        'label' => 'Maximum Allowed Course Entries?',
        'description' => 'Enter the maximum number of allowed course entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));

      $this->addElement('Text', 'project_count', array(
        'label' => 'Maximum Allowed Project Entries?',
        'description' => 'Enter the maximum number of allowed project entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));


      $this->addElement('Text', 'lng_count', array(
        'label' => 'Maximum Allowed Language Entries?',
        'description' => 'Enter the maximum number of allowed language entries. The field must contain an integer between 1 and 999.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
        'value' => 5,
      ));
    }
  }
}
