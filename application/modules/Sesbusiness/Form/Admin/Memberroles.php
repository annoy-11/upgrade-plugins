<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Admin_Memberroles extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Business Roles')
            ->setDescription('Select different access levels for different business roles, the business creator will be able to assign these business roles to their members according to their requirements. You can also create new business role if required.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','sesbusiness')->getLevels();
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
    /*$businessRoles['allow_post'] = 'Allow to Post. (If a member is not allowed to post from Member Level, but his Business role is allowed to post in a Business, then he will be able to post on that Business.)';*/
    $businessRoles['allow_edit_delete'] = 'Allow to Edit and Delete Business Posts.';
    $businessRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
    $businessRoles['allow_delete_comment'] = 'Allow to Edit and Delete Business Comments.';
    $businessRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
    $businessRoles['approve_disapprove_member'] = 'Allow to Moderate Posts for approval.';
    $businessRoles['post_behalf_business'] = 'Allow to Create Associated Sub Businesses.';
    $businessRoles['allow_schedult_post'] = 'Allow to Schedule Posts.';
    //$businessRoles['manage_dashboard'] = 'Allow to View Dashboard and Manage Business Settings';
    $businessRoles['manage_promotions'] = 'Allow to View Dashboard and Manage Business Promotions.';
    $businessRoles['manage_apps'] = 'Allow to View Dashboard and Manage Business Apps.';
    $businessRoles['manage_styling'] = 'Allow to View Dashboard and Manage Business Styling.';
    $businessRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';


     $this->addElement('MultiCheckbox', 'businessroles', array(
        'label' => 'Allow member of this role to Invite other members to join this business',
        'description' => '',
        'multiOptions' => $businessRoles,
    ));

     $this->addElement('Radio', 'active', array(
          'label' => ' Enable Business Role',
          'description' => 'Yes, enable this Business Role. This Business Role will be displayed to admins in Business Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Business Admin role will have all the authorizations as the Business Owner has.',
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
