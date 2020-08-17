<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Admin_Memberroles extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Page Roles')
            ->setDescription('Select different access levels for different page roles, the page creator will be able to assign these page roles to their members according to their requirements. You can also create new page role if required.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','sespage')->getLevels();
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
    /*$pageRoles['allow_post'] = 'Allow to Post. (If a member is not allowed to post from Member Level, but his Page role is allowed to post in a Page, then he will be able to post on that Page.)';*/
    $pageRoles['allow_edit_delete'] = 'Allow to Edit and Delete Page Posts.';
    $pageRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
    $pageRoles['allow_delete_comment'] = 'Allow to Edit and Delete Page Comments.';
    $pageRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
    $pageRoles['approve_disapprove_member'] = 'Allow to Moderate Posts for approval.';
    $pageRoles['post_behalf_page'] = 'Allow to Create Associated Sub Pages.';
    $pageRoles['allow_schedult_post'] = 'Allow to Schedule Posts.';
    //$pageRoles['manage_dashboard'] = 'Allow to View Dashboard and Manage Page Settings';
    $pageRoles['manage_promotions'] = 'Allow to View Dashboard and Manage Page Promotions.';
    $pageRoles['manage_apps'] = 'Allow to View Dashboard and Manage Page Apps.';
    $pageRoles['manage_styling'] = 'Allow to View Dashboard and Manage Page Styling.';
    $pageRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';
    
    
     $this->addElement('MultiCheckbox', 'pageroles', array(
        'label' => 'Allow member of this role to Invite other members to join this page',
        'description' => '',
        'multiOptions' => $pageRoles,
    ));
    
     $this->addElement('Radio', 'active', array(
          'label' => ' Enable Page Role',
          'description' => 'Yes, enable this Page Role. This Page Role will be displayed to admins in Page Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Page Admin role will have all the authorizations as the Page Owner has.',
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
