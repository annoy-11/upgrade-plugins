<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvpoll_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();

    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription('These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.');

    // Element: view
    $this->addElement('Radio', 'view', array(
      'label' => 'Allow Viewing of Polls?',
      'description' => 'Do you want to let members view polls? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow viewing of all polls, even private ones.',
        1 => 'Yes, allow viewing of polls.',
        0 => 'No, do not allow polls to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Polls?',
        'description' => 'Do you want to allow members to create polls?',
        'multiOptions' => array(
          1 => 'Yes, allow this member level to create polls',
          0 => 'No, do not allow this member level to create polls',
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Polls?',
        'description' => 'Do you want to let members edit polls? If set to no, some other setting on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit setting of all the polls.',
          1 => 'Yes, allow members to edit settings of their own polls.',
          0 => 'No, do not allow members to edit settings of their polls.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Polls?',
        'description' => 'Do you want to let members delete polls? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all polls.',
          1 => 'Yes, allow members to delete their own polls.',
          0 => 'No, do not allow members to delete their polls.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      $this->addElement('Radio', 'vote', array(
            'label' => 'Allow Vote to Polls?',
            'description' => 'Do you want to let members vote to polls? If set to no, some other settings on this page may not apply.',
            'multiOptions' => array(
                1 => 'Yes, allow members to voting polls.',
                0 => 'No, do not allow members to voting polls.'
            ),
          'value' => 1,
      ));

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Polls?',
        'description' => 'Do you want to let members of this level comment on polls?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all polls, including private ones.',
          1 => 'Yes, allow members to comment on polls.',
          0 => 'No, do not allow members to comment on polls.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }

      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Poll Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their poll. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone','registered', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));
      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
        'label' => 'Poll Comment Options',
        'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their poll. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone','registered', 'owner_network', 'owner_member_member', 'owner_member', 'owner'),
      ));
    }

  }

}
