<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Memberroles.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_Memberroles extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Store Roles')
            ->setDescription('Select different access levels for different store roles, the store creator will be able to assign these store roles to their members according to their requirements. You can also create new store role if required.');
    $class = '';
    $member_roles = Zend_Controller_Front::getInstance()->getRequest()->getParam('member_roles',0);
    $roles = Engine_Api::_()->getDbTable('memberroles','estore')->getLevels();
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
    /*$storeRoles['allow_post'] = 'Allow to Post. (If a member is not allowed to post from Member Level, but his Store role is allowed to post in a Store, then he will be able to post on that Store.)';*/
    $storeRoles['allow_edit_delete'] = 'Allow to Edit and Delete Store Posts.';
    
    $storeRoles['manage_product'] = 'Allow to Manage Products.';
    $storeRoles['manage_payments'] = 'Allow to Manage Product Payments.';
    
    
    $storeRoles['post_content'] = 'Allow to Post Content in other apps like Photos, etc.';
    $storeRoles['allow_delete_comment'] = 'Allow to Edit and Delete Store Comments.';
    $storeRoles['allow_plugin_content'] = 'Allow to Edit and Delete other apps Content like Photos, etc.';
    $storeRoles['approve_disapprove_member'] = 'Allow to Moderate Posts for approval.';
    $storeRoles['post_behalf_store'] = 'Allow to Create Associated Sub Stores.';
    $storeRoles['allow_schedult_post'] = 'Allow to Schedule Posts.';
    //$storeRoles['manage_dashboard'] = 'Allow to View Dashboard and Manage Store Settings';
    $storeRoles['manage_promotions'] = 'Allow to View Dashboard and Manage Store Promotions.';
    $storeRoles['manage_apps'] = 'Allow to View Dashboard and Manage Store Apps.';
    $storeRoles['manage_styling'] = 'Allow to View Dashboard and Manage Store Styling.';
    $storeRoles['manage_insight'] = 'Allow to View Dashboard and Manage Insights & Reports.';


     $this->addElement('MultiCheckbox', 'storeroles', array(
        'label' => 'Allow member of this role to Invite other members to join this store',
        'description' => '',
        'multiOptions' => $storeRoles,
    ));

     $this->addElement('Radio', 'active', array(
          'label' => ' Enable Store Role',
          'description' => 'Yes, enable this Store Role. This Store Role will be displayed to admins in Store Dashboards.',
          'multiOptions' => array(1=>'Yes',0=>'No'),
          'value'=>1
      ));
    }else{
      $this->addElement('Radio', 'descriptions', array(
        'description' => 'Members who will be given Store Admin role will have all the authorizations as the Store Owner has.',
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
