<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Admin_Memberroles extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Group Roles')
            ->setDescription('Select different access levels for different group roles, the group creator will be able to assign these group roles to their members according to their requirements. You can also create new group role if required.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','sesgroup')->getLevels();
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
    /*$groupRoles['allow_post'] = 'Allow to Post. (If a member is not allowed to post from Member Level, but his Group role is allowed to post in a Group, then he will be able to post on that Group.)';*/
    $groupRoles['allow_edit_delete'] = 'Allow to Edit and Delete Group Posts.';
    $groupRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
    $groupRoles['allow_delete_comment'] = 'Allow to Edit and Delete Group Comments.';
    $groupRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
    $groupRoles['approve_disapprove_member'] = 'Allow to Moderate Posts for approval.';
    $groupRoles['post_behalf_group'] = 'Allow to Create Associated Sub Groups.';
    $groupRoles['allow_schedult_post'] = 'Allow to Schedule Posts.';
    //$groupRoles['manage_dashboard'] = 'Allow to View Dashboard and Manage Group Settings';
    $groupRoles['manage_promotions'] = 'Allow to View Dashboard and Manage Group Promotions.';
    $groupRoles['manage_apps'] = 'Allow to View Dashboard and Manage Group Apps.';
    $groupRoles['manage_styling'] = 'Allow to View Dashboard and Manage Group Styling.';
    $groupRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';
    
    
     $this->addElement('MultiCheckbox', 'grouproles', array(
        'label' => 'Allow member of this role to Invite other members to join this group',
        'description' => '',
        'multiOptions' => $groupRoles,
    ));
    
     $this->addElement('Radio', 'active', array(
          'label' => ' Enable Group Role',
          'description' => 'Yes, enable this Group Role. This Group Role will be displayed to admins in Group Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Group Admin role will have all the authorizations as the Group Owner has.',
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
