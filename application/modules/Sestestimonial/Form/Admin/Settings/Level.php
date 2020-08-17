<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Testimonials?',
        'description' => 'Do you want to let users to view testimonials? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow members to view all testimonials, even private ones.',
            1 => 'Yes, allow members to view their own testimonials.',
            0 => 'No, do not allow testimonials to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Testimonials?',
        'description' => 'Do you want to let members create testimonials? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view testimonials, but only want certain levels to be able to create testimonials.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of testimonials.',
          0 => 'No, do not allow testimonials to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Testimonials?',
        'description' => 'Do you want to let members edit testimonials? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all testimonials.',
          1 => 'Yes, allow members to edit their own testimonials.',
          0 => 'No, do not allow members to edit their testimonials.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Testimonials?',
        'description' => 'Do you want to let members delete testimonials? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all testimonials.',
          1 => 'Yes, allow members to delete their own testimonials.',
          0 => 'No, do not allow members to delete their testimonials.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Testimonials?',
        'description' => 'Do you want to let members of this level comment on testimonials?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all testimonials, including private ones.',
          1 => 'Yes, allow members to comment on testimonials.',
          0 => 'No, do not allow members to comment on testimonials.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }


      $this->addElement('Radio', 'approve', array(
          'description' => 'Do you want Testimonials created by members of this level to be auto-approved? If you choose No, then you can manually approve Testimonials from Manage Testimonials section of this plugin.',
          'label' => 'Auto Approve Testimonials',
          'multiOptions' => array(
              1 => 'Yes, auto-approve Testimonials.',
              0 => 'No, do not auto-approve Testimonials.'
          ),
          'value' => 1,
      ));

      // Element: rating
      $this->addElement('Radio', 'helpful', array(
        'label' => 'Allow to Select Testimonial as Helpful?',
        'description' => 'Do you want to let members of this level select Testimonial as helpful?',
        'multiOptions' => array(
          1 => 'Yes, allow members to helpful on Testimonial.',
          0 => 'No, do not allow members to helpful on Testimonial.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->helpful->options[2]);
      }

      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Testimonial Entries?',
        'description' => 'Enter the maximum number of allowed testimonial entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
      ));
    }
  }
}
