<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {

    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Discussions?',
      'description' => 'Do you want to let members view discussions? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        //2 => 'Yes, allow viewing of all discussions, even private ones.',
        1 => 'Yes, allow viewing of discussions.',
        0 => 'No, do not allow discussions to be viewed.',
      ),
      'value' => 1,
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Discussions?',
        'description' => 'Do you want to let members create discussions? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view discussions, but only want certain levels to be able to create discussions.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of discussions.',
          0 => 'No, do not allow discussions to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Discussions?',
        'description' => 'Do you want to let members edit discussions? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all discussions.',
          1 => 'Yes, allow members to edit their own discussions.',
          0 => 'No, do not allow members to edit their discussions.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Discussions?',
        'description' => 'Do you want to let members delete discussions? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all discussions.',
          1 => 'Yes, allow members to delete their own discussions.',
          0 => 'No, do not allow members to delete their discussions.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }


      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Discussions?',
        'description' => 'Do you want to let members of this level comment on discussions?',
        'multiOptions' => array(
          //2 => 'Yes, allow members to comment on all discussions, including private ones.',
          1 => 'Yes, allow members to comment on discussions.',
          0 => 'No, do not allow members to comment on discussions.',
        ),
        'value' => 1,
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }
    }
  }
}
