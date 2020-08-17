<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Memberroles.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Admin_Classroom_Memberroles extends Engine_Form {

  public function init() {
    parent::init();
    // My stuff
    $this->setTitle('Classroom Roles')
            ->setDescription('Select different access levels for different Classroom roles, the Classroom creator will be able to assign these Classroom roles to their members according to their requirements. You can also create new Classroom role if required.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','eclassroom')->getLevels();
    $rolesArray = array();
    foreach($roles as $role){
      $rolesArray[$role->getIdentity()] = $role->getTitle();
    }
    $this->addElement('Select', 'memberrole_id', array(
        'label' => 'Member Roles',
        'description' => '',
        'multiOptions' => $rolesArray,
    ));
    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => '',
    ));
    if($member_roles != 1 && $member_roles){
      $classroomRoles['allow_edit_delete'] = 'Allow to Edit and Delete Classroom Posts.';
      $classroomRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
      $classroomRoles['allow_delete_comment'] = 'Allow to Edit and Delete Classroom Comments.';
      $classroomRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
      $classroomRoles['approve_disapprove_member'] = 'Allow to Moderate Posts for approval.';
      $classroomRoles['auth_subclassroom'] = 'Allow to Create Sub Classrooms.';
      $classroomRoles['allow_schedult_post'] = 'Allow to Schedule Posts.';
      $classroomRoles['manage_apps'] = 'Allow to View Dashboard and Manage Classroom Apps.';
      $classroomRoles['manage_styling'] = 'Allow to View Dashboard and Manage Classroom Styling.';
      $classroomRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';
      $this->addElement('MultiCheckbox', 'classroomroles', array(
          'label' => 'Allow member of this role to Invite other members to join this Classroom.',
          'description' => '',
          'multiOptions' => $classroomRoles,
      ));
      $this->addElement('Radio', 'active', array(
          'label' => 'Enable Classroom Role',
          'description' => 'This Classroom Role will be displayed to admins in Classroom Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Classroom Admin role will have all the authorizations as the Classroom Owner has.',
      ));
      $this->addElement('Hidden','active',array('value'=>1,'order'=>998));
    }
     // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
