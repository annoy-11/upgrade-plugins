<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Wishes?',
      'description' => 'Do you want to let members view wishes? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        //2 => 'Yes, allow viewing of all wishes, even private ones.',
        1 => 'Yes, allow viewing of wishes.',
        0 => 'No, do not allow wishes to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }
    
    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Wishes?',
        'description' => 'Do you want to let members create wishes? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view wishes, but only want certain levels to be able to create wishes.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of wishes.',
          0 => 'No, do not allow wishes to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Wishes?',
        'description' => 'Do you want to let members edit wishes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all wishes.',
          1 => 'Yes, allow members to edit their own wishes.',
          0 => 'No, do not allow members to edit their wishes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Wishes?',
        'description' => 'Do you want to let members delete wishes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all wishes.',
          1 => 'Yes, allow members to delete their own wishes.',
          0 => 'No, do not allow members to delete their wishes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }
      
      
      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Wishes?',
        'description' => 'Do you want to let members of this level comment on wishes?',
        'multiOptions' => array(
          //2 => 'Yes, allow members to comment on all wishes, including private ones.',
          1 => 'Yes, allow members to comment on wishes.',
          0 => 'No, do not allow members to comment on wishes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }
    }
  }
}