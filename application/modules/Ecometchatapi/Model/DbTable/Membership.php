<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Membership.php 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecometchatapi_Model_DbTable_Membership extends Core_Model_DbTable_Membership
{
  protected $_type = 'user';
  protected $_name = "user_membership";
  public function getTable(){
      return Engine_Api::_()->getDbTable("membership",'user');
  }
  public function isReciprocal()
  {
    return (bool) Engine_Api::_()->getApi('settings', 'core')
        ->getSetting('user.friends.direction', 1);
  }

  public function isUserApprovalRequired()
  {
    return (bool) Engine_Api::_()->getApi('settings', 'core')
        ->getSetting('user.friends.verification', true);
  }

  public function isResourceApprovalRequired(Core_Model_Item_Abstract $resource)
  {
    return true;
  }


  // Implement reciprocal

  public function addMember(Core_Model_Item_Abstract $resource, User_Model_User $user)
  {

      $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
      $chatData['postData']['accepted'] = array($resource->getIdentity());
      Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);

    parent::addMember($resource, $user);
  
    if( $this->isReciprocal() ) {
      parent::addMember($user, $resource);
    }
    
//    parent::setResourceApproved($resource, $user);
//
//    if( $this->isReciprocal() ) {
//      parent::setUserApproved($user, $resource);
//    }

    return $this;
  }

  public function removeMember(Core_Model_Item_Abstract $resource, User_Model_User $user)
  {
    parent::removeMember($resource, $user);

    if( $this->isReciprocal() ) {
      parent::removeMember($user, $resource);
    }
      $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
      $chatData['postData']['friends'] = array($resource->getIdentity());
      $chatData['dataType'] = "DELETE";
      Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
    return $this;
  }

  public function setResourceApproved(Core_Model_Item_Abstract $resource, User_Model_User $user)
  {
    parent::setResourceApproved($resource, $user);

    if( $this->isReciprocal() ) {
      parent::setUserApproved($user, $resource);
    }

    if( !$this->isUserApprovalRequired() ) {
      parent::setUserApproved($resource, $user);

      if( $this->isReciprocal() ) {
        parent::setResourceApproved($user, $resource);
      }
    }
      if( !$user->membership()->isUserApprovalRequired() && !$user->membership()->isReciprocal() ) {
          // if one way friendship and verification not required

          $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
          $chatData['postData']['accepted'] = array($resource->getIdentity());
          Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);

      } else if( !$user->membership()->isUserApprovalRequired() && $user->membership()->isReciprocal() ){
          $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
          $chatData['postData']['accepted'] = array($resource->getIdentity());
          Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
      }
    return $this;
  }

  public function setUserApproved(Core_Model_Item_Abstract $resource, User_Model_User $user)
  {
    parent::setUserApproved($resource, $user);

    if( $this->isReciprocal() ) {
      parent::setResourceApproved($user, $resource);
    }

    if( !$this->isUserApprovalRequired() ) {
      parent::setResourceApproved($resource, $user);

      if( $this->isReciprocal() ) {
        parent::setUserApproved($user, $resource);
      }
    }
      if( !$user->membership()->isUserApprovalRequired() && !$user->membership()->isReciprocal() ) {
          // if one way friendship and verification not required
          $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
          $chatData['postData']['accepted'] = array($resource->getIdentity());
          Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);

      } else if( !$user->membership()->isUserApprovalRequired() && $user->membership()->isReciprocal() ){
          $chatData['url'] = "https://api-".Engine_Api::_()->getApi('settings', 'core')->getSetting('commetchatapi.region', 'us').".cometchat.io/v2.0/users/".$user->getIdentity()."/friends";
          $chatData['postData']['accepted'] = array($resource->getIdentity());
          Engine_Api::_()->ecometchatapi()->sendRequestCometChat($chatData);
      }
    return $this;
  }

  public function removeAllUserFriendship(User_Model_User $user)
  {
    // first get all cases where user_id == $user->getIdentity
    $select = $this->getTable()->select()
      ->where('user_id = ?', $user->getIdentity());

    $friendships = $this->getTable()->fetchAll($select);
    foreach( $friendships as $friendship ) {
      // if active == 1 get the user corresponding to resource_id and take away the member_count by 1
      if($friendship->active){
        $friend = Engine_Api::_()->getItem('user', $friendship->resource_id);
        if($friend && !empty($friend->member_count)){
          $friend->member_count--;
          $friend->save();
        }
      }
      $friendship->delete();
    }

    // get all cases where resource_id == $user->getIdentity
    // remove all
    $this->getTable()->delete(array(
      'resource_id = ?' => $user->getIdentity()
    ));
  }
}
