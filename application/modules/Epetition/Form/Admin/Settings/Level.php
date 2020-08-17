<?php  include APPLICATION_PATH .  '/application/modules/Epetition/views/scriptfile.tpl';?>
<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Level.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Epetition_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
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
      'label' => 'Allow Viewing of Petition?',
      'description' => 'Do you want to let members view Petition? If set to no, some other settings on this page may not apply.',
      'multiOptions' => array(
        2 => 'Yes, allow members to view all Petitions, even private ones.',
        1 => 'Yes, allow members to view their own Petitions.',
        0 => 'No, do not allow Petitions to be viewed.',
      ),
      'value' => ( $this->isModerator() ? 2 : 1 ),
    ));
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {

      // Element: create
      $this->addElement('Radio', 'create', array(
        'label' => 'Allow Creation of Petitions?',
        'description' => 'Do you want to let members create Petitions? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view petitions, but only want certain levels to be able to create Petitions.',
        'multiOptions' => array(
          1 => 'Yes, allow creation of Petitions.',
          0 => 'No, do not allow Petitions to be created.'
        ),
        'value' => 1,
      ));

      // Element: edit
      $this->addElement('Radio', 'edit', array(
        'label' => 'Allow Editing of Petitions?',
        'description' => 'Do you want to let members edit Petitions? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to edit all Petitions.',
          1 => 'Yes, allow members to edit their own Petitions.',
          0 => 'No, do not allow members to edit their Petitions.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->edit->options[2]);
      }

      // Element: delete
      $this->addElement('Radio', 'delete', array(
        'label' => 'Allow Deletion of Petitions?',
        'description' => 'Do you want to let members delete petitions? If set to no, some other settings on this page may not apply.',
        'multiOptions' => array(
          2 => 'Yes, allow members to delete all petitions.',
          1 => 'Yes, allow members to delete their own petitions.',
          0 => 'No, do not allow members to delete their petitions.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->delete->options[2]);
      }

      // Element: comment
      $this->addElement('Radio', 'comment', array(
        'label' => 'Allow Commenting on Petitions?',
        'description' => 'Do you want to let members of this level comment on petitions?',
        'multiOptions' => array(
          2 => 'Yes, allow members to comment on all petitions, including private ones.',
          1 => 'Yes, allow members to comment on petitions.',
          0 => 'No, do not allow members to comment on petitions.',
        ),
        'value' => ( $this->isModerator() ? 2 : 1 ),
      ));
      if( !$this->isModerator() ) {
        unset($this->comment->options[2]);
      }


      //element for event approve
      $this->addElement('Radio', 'petition_approve', array(
        'description' => 'Do you want petitions created by members of this level to be auto-approved?',
        'label' => 'Auto Approve Petitions',
        'multiOptions' => array(
            1=>'Yes, auto-approve petitions.',
            0=>'No, do not auto-approve petitions.'
        ),
        'value' => 1,
       ));


      // Element: auth_view
      $this->addElement('MultiCheckbox', 'auth_view', array(
        'label' => 'Petition Privacy',
        'description' => 'Your members can choose from any of the options checked below when they decide who can see their petition entries. These options appear on your members\' "Add Entry" and "Edit Entry" pages. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));

      // Element: auth_comment
      $this->addElement('MultiCheckbox', 'auth_comment', array(
        'label' => 'Petition Comment Options',
        'description' => 'Your members can choose from any of the options checked below when they decide who can post comments on their entries. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
        'multiOptions' => array(
          'everyone'            => 'Everyone',
          'registered'          => 'All Registered Members',
          'owner_network'       => 'Friends and Networks',
          'owner_member_member' => 'Friends of Friends',
          'owner_member'        => 'Friends Only',
          'owner'               => 'Just Me'
        ),
        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
      ));


      // Element: auth_comment
//      $this->addElement('MultiCheckbox', 'sig_pri', array(
//        'label' => 'Signature Privacy',
//        'description' => 'Your members can choose from any of the options checked below when they decide who can give signatures on the petitions created by the members of this level. If you do not check any options, settings will default to the last saved configuration. If you select only one option, members of this level will not have a choice.',
//        'multiOptions' => array(
//          'everyone'            => 'Everyone',
//          'registered'          => 'All Registered Members',
//          'owner_network'       => 'Friends and Networks',
//          'owner_member_member' => 'Friends of Friends',
//          'owner_member'        => 'Friends Only',
//          'owner'               => 'Just Me'
//        ),
//        'value' => array('everyone', 'owner_network', 'owner_member_member', 'owner_member', 'owner','registered'),
//      ));




      // Element: style
      $this->addElement('Radio', 'style', array(
        'label' => 'Allow Custom CSS Styles?',
        'description' => 'If you enable this feature, your members will be able to customize the colors and fonts of their petitions by altering their CSS styles.',
        'multiOptions' => array(
          1 => 'Yes, enable custom CSS styles.',
          0 => 'No, disable custom CSS styles.',
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'allow_levels', array(
          'label' => 'Allow to choose "Petition View Privacy Based on Member Levels"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Pages based on Member Levels on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members of selected member levels only.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));

      $this->addElement('Radio', 'allow_network', array(
          'label' => 'Allow to choose "Petition Page View Privacy Based on Networks"',
          'description' => 'Do you want to allow the members of this level to choose View privacy of their Pages based on Networks on your website? If you choose Yes, then users will be able to choose the visibility of their Pages to members who have joined selected networks only.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No',
          ),
          'value' => 1,
      ));



      // Element: max
      $this->addElement('Text', 'max', array(
        'label' => 'Maximum Allowed Petitions Entries?',
        'description' => 'Enter the maximum number of allowed petition entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
        'onkeypress'=>'return allowOnlyNumbers(event);',
        'required'=>true,
        'validators' => array(
          array('Int', true),
          new Engine_Validate_AtLeast(0),
        ),
      ));
    }
  }
}
?>
