<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

/**
 * @category   Application_Extensions
 * @package    Sespagenote
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Sespagenote_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
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
      'label' => 'Allow Viewing of Notes?',
      'description' => 'Do you want to let members view notes? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow viewing of all notes, even private ones.',
        1 => 'Yes, allow viewing of notes.',
        0 => 'No, do not allow notes to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Notes?',
        'description' => 'Do you want to let members create notes? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view notes, but only want certain levels to be able to create notes.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of notes.',
          0 => 'No, do not allow notes to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Notes?',
        'description' => 'Do you want to let members edit notes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all notes.',
          1 => 'Yes, allow members to edit their own notes.',
          0 => 'No, do not allow members to edit their notes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Notes?',
        'description' => 'Do you want to let members delete notes? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all notes.',
          1 => 'Yes, allow members to delete their own notes.',
          0 => 'No, do not allow members to delete their notes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Notes?',
        'description' => 'Do you want to let members of this level comment on notes?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all notes, including private ones.',
          1 => 'Yes, allow members to comment on notes.',
          0 => 'No, do not allow members to comment on notes.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }

      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Note View Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their note entries. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
        'label' => 'Note Comment Options',
        'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));

      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Note Entries?',
        'description' => 'Enter the maximum number of allowed note entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
      ));
    }
  }
}
