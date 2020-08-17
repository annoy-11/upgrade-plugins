<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Quotes?',
      'description' => 'Do you want to let members view quotes? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        //2 => 'Yes, allow viewing of all quotes, even private ones.',
        1 => 'Yes, allow viewing of quotes.',
        0 => 'No, do not allow quotes to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }
    
    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Quotes?',
        'description' => 'Do you want to let members create quotes? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view quotes, but only want certain levels to be able to create quotes.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of quotes.',
          0 => 'No, do not allow quotes to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Quotes?',
        'description' => 'Do you want to let members edit quotes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all quotes.',
          1 => 'Yes, allow members to edit their own quotes.',
          0 => 'No, do not allow members to edit their quotes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Quotes?',
        'description' => 'Do you want to let members delete quotes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all quotes.',
          1 => 'Yes, allow members to delete their own quotes.',
          0 => 'No, do not allow members to delete their quotes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }
      
      
      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Quotes?',
        'description' => 'Do you want to let members of this level comment on quotes?',
        'multiOptions' => array(
          //2 => 'Yes, allow members to comment on all quotes, including private ones.',
          1 => 'Yes, allow members to comment on quotes.',
          0 => 'No, do not allow members to comment on quotes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }
    }
  }
}