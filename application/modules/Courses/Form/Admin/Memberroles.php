<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Memberroles.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Admin_Memberroles extends Engine_Form {

  public function init() {
    parent::init();
    // My stuff
    $this->setTitle('Course Roles')
            ->setDescription('Select different access levels for different Course roles, the Course creator will be able to assign these Course roles to their members according to their requirements. You can also create new Classroom role if required. Create roles like Instructor, Student, Parent, Expert etc.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','courses')->getLevels();
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
      $courseRoles['upload_lecture_video'] = 'Allow to Upload videos in Course Lectures.';
      $courseRoles['create_test'] = 'Allow to Create Test.';
      $courseRoles['test_edit_delete'] = 'Allow to Edit & Delete Test';
      $courseRoles['allow_edit_delete'] = 'Allow to Edit and Delete Course Posts.';
      $courseRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
      $courseRoles['allow_delete_comment'] = 'Allow to Edit and Delete Course Comments.';
      $courseRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
      $courseRoles['manage_apps'] = 'Allow to View Dashboard and Manage Course Apps.';
      $courseRoles['manage_styling'] = 'Allow to View Dashboard and Manage Course Styling.';
      $courseRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';
      $this->addElement('MultiCheckbox', 'courseroles', array(
          'label' => 'Allow member of this role to Invite other members to join this Course.',
          'description' => '',
          'multiOptions' => $courseRoles,
      ));
      $this->addElement('Radio', 'active', array(
          'label' => 'Enable Course Role',
          'description' => 'This Course Role will be displayed to admins in Course Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Course Admin role will have all the authorizations as the Course Owner has.',
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
