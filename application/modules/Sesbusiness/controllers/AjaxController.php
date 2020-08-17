<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AjaxController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_AjaxController extends Core_Controller_Action_Standard {

  //get business categories
  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $business_id = $this->_getParam('business_id', null);
    if($business_id) {
      $oldeText = Engine_Api::_()->getItem('businesses',$business_id)->custom_url;
    }
   // $custom_url = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->checkCustomUrl($value, $business_id);
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
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
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

  // get business subsubcategory
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickBusiness']))
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
    if ($type == 'businesses') {
      $dbTable = 'businesses';
      $modulename = 'sesbusiness';
      $resorces_id = 'business_id';
      $notificationType = 'sesbusiness_business_like';
    } elseif($type == 'sesbusiness_photo') {
      $dbTable = 'photos';
      $modulename = 'sesbusiness';
      $resorces_id = 'photo_id';
      $notificationType = 'sesbusiness_photo_like';
    } elseif($type == 'sesbusiness_album') {
      $dbTable = 'albums';
      $modulename = 'sesbusiness';
      $resorces_id = 'album_id';
      $notificationType = 'sesbusiness_album_like';
    }elseif($type == 'businessoffer') {
      $dbTable = 'businessoffers';
      $modulename = 'sesbusinessoffer';
      $resorces_id = 'businessoffer_id';
      $notificationType = 'sesbusinessoffer_like';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getDbTable($dbTable, $modulename);
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
        if($type == 'businesses') {

          if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          }

          // Business admin notifications and email work
          $getAllBusinessAdmins = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->getAllBusinessAdmins(array('business_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
          foreach($getAllBusinessAdmins as $getAllBusinessAdmin) {
            $businessadmin = Engine_Api::_()->getItem('user', $getAllBusinessAdmin->user_id);
            if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $businessadmin->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
          }

          $joinedMembers = Engine_Api::_()->sesbusiness()->getallJoinedMembers($item);
          foreach($joinedMembers as $joinedMember) {
            $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'sesbusiness_business_bsjoinlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_likebusinessjoined', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getFollowers($item->getIdentity());
          foreach($followerMembers as $followerMember) {
            $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'sesbusiness_business_bsfollwlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sesbusiness_business_likebusinessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_businessliked', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } else {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        }


        //$result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));


        if($notificationType == 'sesbusiness_business_like') {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sesbusiness_album_like') {
          $business = Engine_Api::_()->getItem('businesses', $subject->business_id);
          $albumlink = '<a href="' . $subject->getHref() . '">' . 'album' . '</a>';
          $businesslink = '<a href="' . $business->getHref() . '">' . $business->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('albumlink' => $albumlink, 'businessname' => $businesslink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sesbusiness_photo_like') {
          $business = Engine_Api::_()->getItem('businesses', $subject->business_id);
          $photolink = '<a href="' . $subject->getHref() . '">' . 'photo' . '</a>';
          $businesslink = '<a href="' . $business->getHref() . '">' . $business->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('photolink' => $photolink, 'businessname' => $businesslink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      if ($type == 'businesses') {
        $businessFollowers = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getFollowers($subject->business_id);
        if (count($businessFollowers) > 0) {
          foreach ($businessFollowers as $follower) {
            $user = Engine_Api::_()->getItem('user', $follower->owner_id);
            if ($user->getIdentity()) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'sesbusiness_business_like_followed');
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
    if ($this->_getParam('type') == 'businesses') {
      $type = 'businesses';
      $dbTable = 'businesses';
      $modulename = 'sesbusiness';
      $resorces_id = 'business_id';
      $notificationType = 'sesbusiness_business_favourite';
    } elseif ($this->_getParam('type') == 'sesbusiness_photo') {
      $type = 'sesbusiness_photo';
      $dbTable = 'photos';
      $modulename = 'sesbusiness';
      $resorces_id = 'photo_id';
      $notificationType = '';
    } elseif ($this->_getParam('type') == 'sesbusiness_album') {
      $type = 'sesbusiness_album';
      $dbTable = 'albums';
      $modulename = 'sesbusiness';
      $resorces_id = 'album_id';
      $notificationType = '';
    }elseif ($this->_getParam('type') == 'businessoffer') {
      $type = 'businessoffer';
      $dbTable = 'businessoffers';
      $modulename = 'sesbusinessoffer';
      $resorces_id = 'businessoffer_id';
      $notificationType = 'sesbusinessoffer_favourite';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesbusiness')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbTable($dbTable, $modulename);
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
      $db = Engine_Api::_()->getDbTable('favourites', 'sesbusiness')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesbusiness')->createRow();
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

          if($type == 'businesses') {

            if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }

            if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_businessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }

            // Business admin notifications and email work
            $getAllBusinessAdmins = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->getAllBusinessAdmins(array('business_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
            foreach($getAllBusinessAdmins as $getAllBusinessAdmin) {
              $businessadmin = Engine_Api::_()->getItem('user', $getAllBusinessAdmin->user_id);
              if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $businessadmin->getIdentity()))) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
              }
              if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $businessadmin->getIdentity()))) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_businessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
              }
            }
          } else {

            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_businessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
    $item_type = $this->_getParam('type');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    if ($this->_getParam('type') == 'businesses') {
      $modulename = 'sesbusiness';
    }elseif ($this->_getParam('type') == 'businessoffer') {
      $modulename = 'sesbusinessoffer';
    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getItemFollower($item_type, $item_id);
    if($item_type == 'businesses') {
        $followerItem = Engine_Api::_()->getDbTable('businesses', $modulename);
    } elseif($item_type == 'businessoffer') {
        $followerItem = Engine_Api::_()->getDbTable('businessoffers', $modulename);
    }
    
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
      if($item_type == 'businesses') {
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('business_id = ?' => $item_id));
      } elseif($item_type == 'businessoffer') {
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('businessoffer_id = ?' => $item_id));
      }
      $item = Engine_Api::_()->getItem($item_type, $item_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesbusiness_business_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'sesbusiness_business_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = $item_type;
        $follow->resource_id = $item_id;
        $follow->save();
        if($item_type == 'businesses') {
          $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('business_id = ?' => $item_id));
        }elseif($item_type == 'businessoffer') {
          $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('businessoffer_id = ?' => $item_id));
        }
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem($item_type, @$item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && $item_type == 'businesses') {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'sesbusiness_business_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesbusiness_business_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }

        if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sesbusiness_business_follow');
        }

        if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sesbusiness_business_businessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }


        // Business admin notifications and email work
        $getAllBusinessAdmins = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->getAllBusinessAdmins(array('business_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
        foreach($getAllBusinessAdmins as $getAllBusinessAdmin) {

          $businessadmin = Engine_Api::_()->getItem('user', $getAllBusinessAdmin->user_id);

          if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $businessadmin->getIdentity()))) {

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($businessadmin, $viewer, $item, 'sesbusiness_business_follow');
          }

          if(Engine_Api::_()->getDbTable('notifications','sesbusiness')->getNotifications(array('business_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $businessadmin->getIdentity()))) {

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($businessadmin, 'notify_sesbusiness_business_businessfollowed', array('business_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      elseif ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && $item_type == 'businessoffer') {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');
        $result = $activityTable->fetchRow(array('type =?' => 'sesbusinessoffer_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesbusinessoffer_follow');
        }

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesbusinessoffer_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sesbusinessoffer_follow');
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getItemFollower('sesbusiness_category', $item_id);
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
      $db = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'sesbusiness_category';
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

  public function getBusinessAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getbusiness'] = true;
    $businesses = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($value);
    foreach ($businesses as $business) {
      $business_icon = $this->view->itemPhoto($business, 'thumb.icon');
      $sesdata[] = array(
          'id' => $business->business_id,
          'label' => $business->title,
          'photo' => $business_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeBusinessAction() {
    $business_id = $this->_getParam('business_id', '0');
    if ($business_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->business_id = $business_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'businesses')
            ->where('resource_id = ?', $business_id)
            ->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per business and current business number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function favouriteBusinessAction() {
    $business_id = $this->_getParam('business_id', '0');
    if ($business_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->business_id = $business_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sesbusiness_favourite');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'businesses')
            ->where('resource_id = ?', $business_id)
            ->order('favourite_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per business and current business number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function followBusinessAction() {
    $business_id = $this->_getParam('business_id', '0');
    if ($business_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->business_id = $business_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sesbusiness_follower');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'businesses')
            ->where('resource_id = ?', $business_id)
            ->order('follower_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per business and current business number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function getUserBusinessesAction() {
    $user_id = $this->_getParam('user_id', false);

    $table = Engine_Api::_()->getDbTable('businessroles','sesbusiness');
    $selelct = $table->select($table->info('name'),'business_id')->where('user_id =?',$this->view->viewer()->getIdentity());
    $res = $table->fetchAll($selelct);

    $businessIds = array();
    foreach($res as $business){
      $businessIds[] = $business->business_id;
    }
    if (!$user_id)
      $user_id = $this->view->viewer()->getIdentity();
    $value['user_id'] = $user_id;
    $value['businessIds'] = $businessIds;
    $value['fetchAll'] = true;
    $this->view->businesses = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($value);
  }

}
