<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AjaxController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_AjaxController extends Core_Controller_Action_Standard {

  //get group categories 
  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $group_id = $this->_getParam('group_id', null);
    if($group_id) {
      $oldeText = Engine_Api::_()->getItem('sesgroup_group',$group_id)->custom_url;
    }
   // $custom_url = Engine_Api::_()->getDbTable('groups', 'sesgroup')->checkCustomUrl($value, $group_id);
    $custom_url = Engine_Api::_()->sesbasic()->checkBannedWord($value,$oldeText);
    if ($custom_url) {
      echo json_encode(array('error' => true, 'value' => $value));
      die;
    } else {
      echo json_encode(array('error' => false, 'value' => $value));
      die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
            $clean;
  }

  public function subcategoryAction() {
    $category_id = $this->_getParam('category_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }

  // get group subsubcategory 
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickGroup']))
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }

  function likeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if ($viewer_id == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    
    $type = $this->_getParam('type', false);
    if ($type == 'sesgroup_group') {
      $dbTable = 'groups';
      $resorces_id = 'group_id';
      $notificationType = 'sesgroup_group_like';
    } elseif($type == 'sesgroup_photo') {
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = 'sesgroup_photo_like';
    } elseif($type == 'sesgroup_album') {
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = 'sesgroup_album_like';
    }
    
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getDbTable($dbTable, 'sesgroup');
    $tableLike = Engine_Api::_()->getDbTable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', $type)
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);
    if (count($result) > 0) {
      //delete		
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $item = Engine_Api::_()->getItem($type, $item_id);
      $owner = $item->getOwner();
      if(!empty($notificationType)) {
        //Engine_Api::_()->sesbasic()->deleteFeed(array('type' => $notificationType, "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
        Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {
        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($resorces_id . '= ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($notificationType && $owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        //Send to all joined members
        if($type == 'sesgroup_group') {
        
          if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          }

          // Group admin notifications and email work
          $getAllGroupAdmins = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->getAllGroupAdmins(array('group_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
          foreach($getAllGroupAdmins as $getAllGroupAdmin) {
            $groupadmin = Engine_Api::_()->getItem('user', $getAllGroupAdmin->user_id);
            if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $groupadmin->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
          }

          $joinedMembers = Engine_Api::_()->sesgroup()->getallJoinedMembers($item);
          foreach($joinedMembers as $joinedMember) {
            $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'sesgroup_gpsijoinedlike');
            
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_likegroupjoined', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
          
          $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getFollowers($item->getIdentity());
          foreach($followerMembers as $followerMember) {
            $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'sesgroup_gpsifollowedlike');
            
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesgroup_group_likegroupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
          
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupliked', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } else {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        }
        
        
        //$result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        
        
        if($notificationType == 'sesgroup_group_like') {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sesgroup_album_like') {
          $group = Engine_Api::_()->getItem('sesgroup_group', $subject->group_id);
          $albumlink = '<a href="' . $subject->getHref() . '">' . 'album' . '</a>';
          $grouplink = '<a href="' . $group->getHref() . '">' . $group->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('albumlink' => $albumlink, 'groupname' => $grouplink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sesgroup_photo_like') {
          $group = Engine_Api::_()->getItem('sesgroup_group', $subject->group_id);
          $photolink = '<a href="' . $subject->getHref() . '">' . 'photo' . '</a>';
          $grouplink = '<a href="' . $group->getHref() . '">' . $group->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('photolink' => $photolink, 'groupname' => $grouplink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      if ($type == 'sesgroup_group') {
        $groupFollowers = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getFollowers($subject->group_id);
        if (count($groupFollowers) > 0) {
          foreach ($groupFollowers as $follower) {
            $user = Engine_Api::_()->getItem('user', $follower->owner_id);
            if ($user->getIdentity()) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'sesgroup_group_like_followed');
            }
          }
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  //item favourite as per item tye given
  function favouriteAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    if ($this->_getParam('type') == 'sesgroup_group') {
      $type = 'sesgroup_group';
      $dbTable = 'groups';
      $resorces_id = 'group_id';
      $notificationType = 'sesgroup_group_favourite';
    } elseif ($this->_getParam('type') == 'sesgroup_photo') {
      $type = 'sesgroup_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = '';
    } elseif ($this->_getParam('type') == 'sesgroup_album') {
      $type = 'sesgroup_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = '';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbTable($dbTable, 'sesgroup');
    if (count($Fav) > 0) {
      //delete		
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array($resorces_id . ' = ?' => $item_id));
      $item = Engine_Api::_()->getItem($type, $item_id);
      if($notificationType) { 
        Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
        Engine_Api::_()->sesbasic()->deleteFeed(array('type' => $notificationType, "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->createRow();
        $fav->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $fav->resource_type = $type;
        $fav->resource_id = $item_id;
        $fav->save();
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1')), array($resorces_id . '= ?' => $item_id));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send Notification and Activity Feed Work.
      $item = Engine_Api::_()->getItem(@$type, @$item_id);
      if (@$notificationType) {
        $subject = $item;
        $owner = $subject->getOwner();
        if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
          $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');
          $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          if (!$result) {
            $action = $activityTable->addActivity($viewer, $subject, $notificationType);
            if ($action)
              $activityTable->attachActivity($action, $subject);
          }
          
          if($type == 'sesgroup_group') {
          
            if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
            
            if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }
            
            // Group admin notifications and email work
            $getAllGroupAdmins = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->getAllGroupAdmins(array('group_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
            foreach($getAllGroupAdmins as $getAllGroupAdmin) {
              $groupadmin = Engine_Api::_()->getItem('user', $getAllGroupAdmin->user_id);
              if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $groupadmin->getIdentity()))) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
              }
              if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $groupadmin->getIdentity()))) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
              }
            }
          } else {
          
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
      die;
    }
  }

  function followAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getItemFollower('sesgroup_group', $item_id);
    $followerItem = Engine_Api::_()->getDbTable('groups', 'sesgroup');
    if (count($Fav) > 0) {
      //delete		
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('group_id = ?' => $item_id));
      $item = Engine_Api::_()->getItem('sesgroup_group', $item_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesgroup_group_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'sesgroup_group_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sesgroup')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'sesgroup_group';
        $follow->resource_id = $item_id;
        $follow->save();
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('group_id = ?' => $item_id));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem('sesgroup_group', @$item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'sesgroup_group_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesgroup_group_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }

        if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sesgroup_group_follow');
        }
        
        if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesgroup_group_groupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        
        
        // Group admin notifications and email work
        $getAllGroupAdmins = Engine_Api::_()->getDbTable('grouproles', 'sesgroup')->getAllGroupAdmins(array('group_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
        foreach($getAllGroupAdmins as $getAllGroupAdmin) {
          
          $groupadmin = Engine_Api::_()->getItem('user', $getAllGroupAdmin->user_id);
          
          if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $groupadmin->getIdentity()))) {

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($groupadmin, $viewer, $item, 'sesgroup_group_follow');
          }
          
          if(Engine_Api::_()->getDbTable('notifications','sesgroup')->getNotifications(array('group_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $groupadmin->getIdentity()))) {
          
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($groupadmin, 'notify_sesgroup_group_groupfollowed', array('group_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      $this->view->follower_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->follow_count, 'follower_id' => 1));
      die;
    }
  }
  
   function followCategoryAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getItemFollower('sesgroup_category', $item_id);
    if (count($Fav) > 0) {
      //delete		
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced'));
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'sesgroup')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sesgroup')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'sesgroup_category';
        $follow->resource_id = $item_id;
        $follow->save();
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment'));
      die;
    }
  }

  public function getGroupAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getgroup'] = true;
    $groups = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($value);
    foreach ($groups as $group) {
      $group_icon = $this->view->itemPhoto($group, 'thumb.icon');
      $sesdata[] = array(
          'id' => $group->group_id,
          'label' => $group->title,
          'photo' => $group_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeGroupAction() {
    $group_id = $this->_getParam('group_id', '0');
    if ($group_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->group_id = $group_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sesgroup_group')
            ->where('resource_id = ?', $group_id)
            ->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per group and current group number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function favouriteGroupAction() {
    $group_id = $this->_getParam('group_id', '0');
    if ($group_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->group_id = $group_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sesgroup_favourite');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sesgroup_group')
            ->where('resource_id = ?', $group_id)
            ->order('favourite_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per group and current group number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function followGroupAction() {
    $group_id = $this->_getParam('group_id', '0');
    if ($group_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->group_id = $group_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sesgroup_follower');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sesgroup_group')
            ->where('resource_id = ?', $group_id)
            ->order('follower_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per group and current group number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function getUserGroupsAction() {
    $user_id = $this->_getParam('user_id', false);
    
    $table = Engine_Api::_()->getDbTable('grouproles','sesgroup');
    $selelct = $table->select($table->info('name'),'group_id')->where('user_id =?',$this->view->viewer()->getIdentity());
    $res = $table->fetchAll($selelct);
    
    $groupIds = array();
    foreach($res as $group){
      $groupIds[] = $group->group_id;  
    }
    if (!$user_id)
      $user_id = $this->view->viewer()->getIdentity();
    $value['user_id'] = $user_id;
    $value['groupIds'] = $groupIds;
    $value['fetchAll'] = true;
    $this->view->groups = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($value);
  }

}
