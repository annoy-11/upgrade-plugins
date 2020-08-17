<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Prayers?',
      'description' => 'Do you want to let members view prayers? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        //2 => 'Yes, allow viewing of all prayers, even private ones.',
        1 => 'Yes, allow viewing of prayers.',
        0 => 'No, do not allow prayers to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }
    
    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Prayers?',
        'description' => 'Do you want to let members create prayers? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view prayers, but only want certain levels to be able to create prayers.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of prayers.',
          0 => 'No, do not allow prayers to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Prayers?',
        'description' => 'Do you want to let members edit prayers? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all prayers.',
          1 => 'Yes, allow members to edit their own prayers.',
          0 => 'No, do not allow members to edit their prayers.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Prayers?',
        'description' => 'Do you want to let members delete prayers? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all prayers.',
          1 => 'Yes, allow members to delete their own prayers.',
          0 => 'No, do not allow members to delete their prayers.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }
      
      
      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Prayers?',
        'description' => 'Do you want to let members of this level comment on prayers?',
        'multiOptions' => array(
          //2 => 'Yes, allow members to comment on all prayers, including private ones.',
          1 => 'Yes, allow members to comment on prayers.',
          0 => 'No, do not allow members to comment on prayers.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }
    }
  }
}