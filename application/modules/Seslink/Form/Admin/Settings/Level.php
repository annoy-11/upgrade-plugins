<?php

class Seslink_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
  
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied as per member level. Start by selecting the member level you want to modify, then adjust the settings for that level from below.");

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Links?',
      'description' => 'Do you want to let members view links? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow viewing of all links, even private ones.',
        1 => 'Yes, allow viewing of links.',
        0 => 'No, do not allow links to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }


    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Links?',
        'description' => 'Do you want to let members create links? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view links, but only want certain levels to be able to create links.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of links.',
          0 => 'No, do not allow links to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Links?',
        'description' => 'Do you want to let members edit links? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all links.',
          1 => 'Yes, allow members to edit their own links.',
          0 => 'No, do not allow members to edit their links.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Links?',
        'description' => 'Do you want to let members delete links? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all links.',
          1 => 'Yes, allow members to delete their own links.',
          0 => 'No, do not allow members to delete their links.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }
      
      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Links?',
        'description' => 'Do you want to let members of this level comment on links?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all links, including private ones.',
          1 => 'Yes, allow members to comment on links.',
          0 => 'No, do not allow members to comment on links.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }
      
    }
  }
}