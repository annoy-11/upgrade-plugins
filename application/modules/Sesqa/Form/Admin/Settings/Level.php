<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Level.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract {

  public function init() {
		
    parent::init();
$this->loadDefaultDecorators();
    // My stuff
    $this->setTitle('Member Level Settings')
            ->setDescription('These settings are applied as per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level from below.');

    // Element: view
    $this->addElement('Radio', 'view', array(
        'label' => 'Allow Viewing of Questions?',
        'description' => 'Do you want to let users to view Questions? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
            2 => 'Yes, allow viewing of all questions, even private ones.',
            1 => 'Yes, allow viewing of questions.',
            0 => 'No, do not allow questions to be viewed.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if (!$this->isModerator()) {
      unset($this->view->options[2]);
    }

    if (!$this->isPublic()) {

      // Element: create
      $this->addElement('Radio', 'create', array(
          'label' => 'Allow Creation of Questions?',
          'description' => 'Do you want to allow users to create Questions? If set to no, some other settings on this page may not apply. This is useful when you want certain levels only to be able to create Questions.',
          'multiOptions' => array(
              1 => 'Yes, allow creation of Questions.',
              0 => 'No, do not allow Questions to be created.'
          ),
          'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
          'label' => 'Allow Editing of Questions?',
          'description' => 'Do you want to let members edit Questions? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to edit all questions.',
              1 => 'Yes, allow members to edit their own questions.',
              0 => 'No, do not allow members to edit their questions.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
          'label' => 'Allow Deletion of Questions?',
          'description' => 'Do you want to let members delete Questions? If set to no, some other settings on this page may not apply.',
          'multiOptions' => array(
              2 => 'Yes, allow members to delete all questions.',
              1 => 'Yes, allow members to delete their own questions.',
              0 => 'No, do not allow members to delete their questions.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
          'label' => 'Allow Commenting on Questions?',
          'description' => 'Do you want to let members of this level comment on questions?',
          'multiOptions' => array(
              2 => 'Yes, allow members to comment on all questions, including private ones.',
              1 => 'Yes, allow members to comment on questions.',
              0 => 'No, do not allow members to comment on questions.',
          ),
          'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if (!$this->isModerator()) {
        unset($this->comment->options[2]);
      }
      $this->addElement('Radio', 'vote_question', array(
          'label' => 'Allow Voting on Questions?',
          'description' => 'Do you want to let members of this level Vote on Questions?',
          'multiOptions' => array(
              1 => 'Yes, allow members to Vote on Questions.',
              0 => 'No, do not allow members to Vote on Questions.',
          ),
          'value' => 1,
      ));
      // Element: upload
      $this->addElement('Radio', 'answer', array(
          'label' => 'Allow Answers on Questions?',
          'description' => 'Do you want to let members of this level to Answer on Questions?',
          'multiOptions' => array(
              1 => 'Yes, allow members to Answer on Questions.',
              0 => 'No, do not allow members to Answer on Questions.',
          ),
          'value' => 1,
      ));
      
      $this->addElement('Radio', 'vote_answer', array(
          'label' => 'Allow Voting on Answers?',
          'description' => 'Do you want to let members of this level Vote Answer on Questions?',
          'multiOptions' => array(
              1 => 'Yes, allow members to Vote Answer on Questions.',
              0 => 'No, do not allow members to Vote Answer on Questions.',
          ),
          'value' => 1,
      ));

      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
          'label' => 'Question View Privacy',
          'description' => 'Your users can choose any of the options from below, whom they want can see their Questions. If you do not check any option, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'All Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Just Me',
          ),
          'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_answer', array(
          'label' => 'Answer Options',
          'description' => 'Your users can choose any of the options from below whom they want can post the answer to their Question discussions. If you do not check any options, settings will set default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'All Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Just Me',
          ),
          'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
          'label' => 'Question Comment Options',
          'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their question. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice. ',
          'multiOptions' => array(
              'everyone' => 'Everyone',
              'registered' => 'All Registered Members',
              'owner_network' => 'Friends and Networks',
              'owner_member_member' => 'Friends of Friends',
              'owner_member' => 'Friends Only',
              'owner' => 'Just Me',
          ),
          'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));
        $this->addElement('Radio', 'sesqa_autoapp', array(
            'label' => 'Auto Approve Questions',
            'description' => 'Do you want questions created by members to be auto-approved?',
            'multiOptions' => array(
                '1' => 'Yes, auto-approve questions.',
                '0' => 'No, do not auto-approve questions.',
            ),
            'value' => ($this->isModerator() ? 1 : 0),
        ));

      //Element: max
      $this->addElement('Text', 'max', array(
          'label' => 'Maximum Allowed Questions',
          'description' => 'Enter the maximum number of questions a member can create. The field must contain an integer, use zero for unlimited.',
          'validators' => array(
              array('Int', true),
              new Engine_Validate_AtLeast(0),
          ),
          'value'=>0,
      ));
			
    }
		
  }

}
