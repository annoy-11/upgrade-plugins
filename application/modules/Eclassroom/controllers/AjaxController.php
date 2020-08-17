<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AjaxController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_AjaxController extends Core_Controller_Action_Standard {
  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $classroom_id = $this->_getParam('classroom_id', null);
    $custom_url = Engine_Api::_()->getDbtable('classrooms', 'eclassroom')->checkCustomUrl($value,$classroom_id);
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
      $subcategory = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
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
  // get classroom subsubcategory
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'eclassroom')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickClassroom']))
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
    if ($type == 'classroom') {
      $dbTable = 'classrooms';
      $resorces_id = 'classroom_id';
      $notificationType = 'eclassroom_classroom_like';
    } elseif($type == 'eclassroom_photo') {
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = 'eclassroom_photo_like';
    } elseif($type == 'eclassroom_album') {
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = 'eclassroom_album_like';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getDbTable($dbTable, 'eclassroom');
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
        Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      }
      $titleMessage = $this->view->translate(array('%s Like', '%s Likes', $item->like_count), $this->view->locale()->toNumber($item->like_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count,'title'=>$titleMessage));
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
        if($type == 'classroom') {

          if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          }
          
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
           
          // Classroom admin notifications and email work
          $getAllClassroomAdmins = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->getAllClassroomAdmins(array('classroom_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
          foreach($getAllClassroomAdmins as $getAllClassroomAdmin) {
            $classroomadmin = Engine_Api::_()->getItem('user', $getAllClassroomAdmin->user_id);
            if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $classroomadmin->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
          }
          $joinedMembers = Engine_Api::_()->eclassroom()->getallJoinedMembers($item);
          foreach($joinedMembers as $joinedMember) {
            $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'eclassroom_classroom_bsjoinlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'eclassroom_classroom_bsjoinlike', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          $followerMembers = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getFollowers($item->getIdentity());
          foreach($followerMembers as $followerMember) {
            $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'eclassroom_classroom_bsfollwlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'eclassroom_classroom_bsfollwlike', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'eclassroom_classroom_like', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } else {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        }
        //$result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

        if($notificationType == 'eclassroom_classroom_like') {
        
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'eclassroom_album_like') { 
          $classroom = Engine_Api::_()->getItem('classroom', $subject->classroom_id);
          $albumlink = '<a href="' . $subject->getHref() . '">' . 'album' . '</a>';
          $classroomlink = '<a href="' . $classroom->getHref() . '">' . $classroom->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('albumlink' => $albumlink, 'classroomname' => $classroomlink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'eclassroom_photo_like') {
          $classroom = Engine_Api::_()->getItem('classroom', $subject->classroom_id);
          $photolink = '<a href="' . $subject->getHref() . '">' . 'photo' . '</a>';
          $classroomlink = '<a href="' . $classroom->getHref() . '">' . $classroom->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('photolink' => $photolink, 'classroomname' => $classroomlink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      $titleMessage = $this->view->translate(array('%s Like', '%s Likes', $item->like_count), $this->view->locale()->toNumber($item->like_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count,'title'=>$titleMessage));
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
    if ($this->_getParam('type') == 'classroom') {
      $type = 'classroom';
      $dbTable = 'classrooms';
      $resorces_id = 'classroom_id';
      $notificationType = 'eclassroom_classroom_favourite';
    } elseif ($this->_getParam('type') == 'eclassroom_photo') {
      $type = 'eclassroom_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = 'eclassroom_photo';
    } elseif ($this->_getParam('type') == 'eclassroom_album') {
      $type = 'eclassroom_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = 'eclassroom_album';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbTable($dbTable, 'eclassroom');
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
      $titleMessage = $this->view->translate(array('%s Like', '%s Likes', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count,'title'=>$titleMessage));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->createRow();
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
          if($type == 'classrooms') {
            if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
            if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_eclassroom_classroom_classroomfollowed', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }
            // Classroom admin notifications and email work
            $getAllClassroomAdmins = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->getAllClassroomAdmins(array('classroom_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
            foreach($getAllClassroomAdmins as $getAllClassroomAdmin) {
              $classroomadmin = Engine_Api::_()->getItem('user', $getAllClassroomAdmin->user_id);
              if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $classroomadmin->getIdentity()))) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
              }
              if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $classroomadmin->getIdentity()))) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_eclassroom_classroom_classroomfollowed', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
              }
            }
          } else {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_eclassroom_classroom_classroomfollowed', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //End Activity Feed Work
      $this->view->favourite_id = 1;
      $titleMessage = $this->view->translate(array('%s favourites', '%s favourite', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1,'title'=>$titleMessage));
      die;
    }
  }
//
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getItemFollower('classroom', $item_id);
    $followerItem = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
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
      $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('classroom_id = ?' => $item_id));
      $item = Engine_Api::_()->getItem('classroom', $item_id);
      
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'eclassroom_classroom_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'eclassroom_classroom_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      $titleMessage = $this->view->translate(array('%s Follow', '%s Follows', $item->follow_count), $this->view->locale()->toNumber($item->follow_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count,'title'=>$titleMessage));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'eclassroom')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'classroom';
        $follow->resource_id = $item_id;
        $follow->save();
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('classroom_id = ?' => $item_id));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
//       //send notification and activity feed work.
        $item = Engine_Api::_()->getItem('classroom', @$item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');
        $result = $activityTable->fetchRow(array('type =?' => 'eclassroom_classroom_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'eclassroom_classroom_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
        if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'eclassroom_classroom_follow');
        }
        if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'eclassroom_classroom_follow', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        // Classroom admin notifications and email work
        $getAllClassroomAdmins = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom')->getAllClassroomAdmins(array('classroom_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
        foreach($getAllClassroomAdmins as $getAllClassroomAdmin) {
          $classroomadmin = Engine_Api::_()->getItem('user', $getAllClassroomAdmin->user_id);
          if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $classroomadmin->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($classroomadmin, $viewer, $item, 'eclassroom_classroom_follow');
          }
          if(Engine_Api::_()->getDbTable('notifications','eclassroom')->getNotifications(array('classroom_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $classroomadmin->getIdentity()))) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($classroomadmin, 'eclassroom_classroom_follow', array('classroom_name' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      $this->view->follower_id = 1;
      $titleMessage = $this->view->translate(array('%s Follow', '%s Follows', $item->follow_count), $this->view->locale()->toNumber($item->follow_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->follow_count, 'follower_id' => 1,'title'=>$titleMessage));
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
    if ($this->_getParam('type') == 'eclassroom_category') {
        $type = "eclassroom_category";
    } else {

    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getItemFollower('eclassroom_category', $item_id);
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
      $db = Engine_Api::_()->getDbTable('followers', 'eclassroom')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'eclassroom')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = $type;
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

  public function getClassroomAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getclassroom'] = true;
    $classrooms = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($value);
    foreach ($classrooms as $classroom) {
      $classroom_icon = $this->view->itemPhoto($classroom, 'thumb.icon');
      $sesdata[] = array(
          'id' => $classroom->classroom_id,
          'label' => $classroom->title,
          'photo' => $classroom_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
  public function likeClassroomAction() {
    $classroom_id = $this->_getParam('classroom_id', '0');
    if ($classroom_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->classroom_id = $classroom_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'classrooms')
            ->where('resource_id = ?', $classroom_id)
            ->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per classroom and current classroom number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }
  public function favouriteClassroomAction() {
    $classroom_id = $this->_getParam('classroom_id', '0');
    if ($classroom_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->classroom_id = $classroom_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('eclassroom_favourite');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'classrooms')
            ->where('resource_id = ?', $classroom_id)
            ->order('favourite_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per classroom and current classroom number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }
  public function followClassroomAction() {
    $classroom_id = $this->_getParam('classroom_id', '0');
    if ($classroom_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->classroom_id = $classroom_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('eclassroom_follower');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'classrooms')
            ->where('resource_id = ?', $classroom_id)
            ->order('follower_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per classroom and current classroom number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }
  public function reviewClassroomAction() {
    $classroom_id = $this->_getParam('classroom_id', '0');
    if ($classroom_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->classroom_id = $classroom_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('eclassroom_review');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('classroom_id = ?', $classroom_id)
            ->order('review_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per classroom and current classroom number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }
  public function getUserClassroomsAction() {
    $user_id = $this->_getParam('user_id', false);

    $table = Engine_Api::_()->getDbTable('classroomroles','eclassroom');
    $selelct = $table->select($table->info('name'),'classroom_id')->where('user_id =?',$this->view->viewer()->getIdentity());
    $res = $table->fetchAll($selelct);

    $classroomIds = array();
    foreach($res as $classroom){
      $classroomIds[] = $classroom->classroom_id;
    }
    if (!$user_id)
      $user_id = $this->view->viewer()->getIdentity();
    $value['user_id'] = $user_id;
    $value['classroomIds'] = $classroomIds;
    $value['fetchAll'] = true;
    $this->view->classrooms = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($value);
  }
}
