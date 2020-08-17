<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AjaxController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_AjaxController extends Core_Controller_Action_Standard {

  //get store categories
  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $store_id = $this->_getParam('store_id', null);
    if($store_id) {
      $oldeText = Engine_Api::_()->getItem('stores',$store_id)->custom_url;
    }
   // $custom_url = Engine_Api::_()->getDbTable('stores', 'estore')->checkCustomUrl($value, $store_id);
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
      $subcategory = Engine_Api::_()->getDbTable('categories', 'estore')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
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

  // get store subsubcategory
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'estore')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickStore']))
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
    if ($type == 'stores') {
      $dbTable = 'stores';
      $resorces_id = 'store_id';
      $notificationType = 'estore_store_like';
    } elseif($type == 'estore_photo') {
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = 'estore_photo_like';
    } elseif($type == 'estore_album') {
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = 'estore_album_like';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getDbTable($dbTable, 'estore');
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
        if($type == 'stores') {

          if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          }

          // Store admin notifications and email work
          $getAllStoreAdmins = Engine_Api::_()->getDbTable('storeroles', 'estore')->getAllStoreAdmins(array('store_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
          foreach($getAllStoreAdmins as $getAllStoreAdmin) {
            $storeadmin = Engine_Api::_()->getItem('user', $getAllStoreAdmin->user_id);
            if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $storeadmin->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
          }

          $joinedMembers = Engine_Api::_()->estore()->getallJoinedMembers($item);
          foreach($joinedMembers as $joinedMember) {
            $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'estore_store_bsjoinlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_likestorejoined', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          $followerMembers = Engine_Api::_()->getDbTable('followers', 'estore')->getFollowers($item->getIdentity());
          foreach($followerMembers as $followerMember) {
            $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'estore_store_bsfollwlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_estore_store_likestorefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storeliked', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } else {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        }


        //$result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));


        if($notificationType == 'estore_store_like') {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'estore_album_like') {
          $store = Engine_Api::_()->getItem('stores', $subject->store_id);
          $albumlink = '<a href="' . $subject->getHref() . '">' . 'album' . '</a>';
          $storelink = '<a href="' . $store->getHref() . '">' . $store->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('albumlink' => $albumlink, 'storename' => $storelink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'estore_photo_like') {
          $store = Engine_Api::_()->getItem('stores', $subject->store_id);
          $photolink = '<a href="' . $subject->getHref() . '">' . 'photo' . '</a>';
          $storelink = '<a href="' . $store->getHref() . '">' . $store->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('photolink' => $photolink, 'storename' => $storelink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      if ($type == 'stores') {
        $storeFollowers = Engine_Api::_()->getDbTable('followers', 'estore')->getFollowers($subject->store_id);
        if (count($storeFollowers) > 0) {
          foreach ($storeFollowers as $follower) {
            $user = Engine_Api::_()->getItem('user', $follower->owner_id);
            if ($user->getIdentity()) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'estore_store_like_followed');
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
    if ($this->_getParam('type') == 'stores') {
      $type = 'stores';
      $dbTable = 'stores';
      $resorces_id = 'store_id';
      $notificationType = 'estore_store_favourite';
    } elseif ($this->_getParam('type') == 'estore_photo') {
      $type = 'estore_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
      $notificationType = '';
    } elseif ($this->_getParam('type') == 'estore_album') {
      $type = 'estore_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $notificationType = '';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'estore')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbTable($dbTable, 'estore');
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
      $db = Engine_Api::_()->getDbTable('favourites', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'estore')->createRow();
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

          if($type == 'stores') {

            if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }

            if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }

            // Store admin notifications and email work
            $getAllStoreAdmins = Engine_Api::_()->getDbTable('storeroles', 'estore')->getAllStoreAdmins(array('store_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
            foreach($getAllStoreAdmins as $getAllStoreAdmin) {
              $storeadmin = Engine_Api::_()->getItem('user', $getAllStoreAdmin->user_id);
              if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $storeadmin->getIdentity()))) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
              }
              if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $storeadmin->getIdentity()))) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
              }
            }
          } else {

            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'estore')->getItemFollower('stores', $item_id);
    $followerItem = Engine_Api::_()->getDbTable('stores', 'estore');
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
      $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('store_id = ?' => $item_id));
      $item = Engine_Api::_()->getItem('stores', $item_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'estore_store_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'estore_store_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'estore')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'stores';
        $follow->resource_id = $item_id;
        $follow->save();
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('store_id = ?' => $item_id));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem('stores', @$item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'estore_store_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'estore_store_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }

        if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'estore_store_follow');
        }

        if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_estore_store_storefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }


        // Store admin notifications and email work
        $getAllStoreAdmins = Engine_Api::_()->getDbTable('storeroles', 'estore')->getAllStoreAdmins(array('store_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
        foreach($getAllStoreAdmins as $getAllStoreAdmin) {

          $storeadmin = Engine_Api::_()->getItem('user', $getAllStoreAdmin->user_id);

          if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $storeadmin->getIdentity()))) {

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($storeadmin, $viewer, $item, 'estore_store_follow');
          }

          if(Engine_Api::_()->getDbTable('notifications','estore')->getNotifications(array('store_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $storeadmin->getIdentity()))) {

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($storeadmin, 'notify_estore_store_storefollowed', array('store_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'estore')->getItemFollower('estore_category', $item_id);
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
      $db = Engine_Api::_()->getDbTable('followers', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'estore')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'estore_category';
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

  public function getStoreAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getstore'] = true;
    $stores = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect($value);
    foreach ($stores as $store) {
      $store_icon = $this->view->itemPhoto($store, 'thumb.icon');
      $sesdata[] = array(
          'id' => $store->store_id,
          'label' => $store->title,
          'photo' => $store_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function likeStoreAction() {
    $store_id = $this->_getParam('store_id', '0');
    if ($store_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->store_id = $store_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'stores')
            ->where('resource_id = ?', $store_id)
            ->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per store and current store number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function favouriteStoreAction() {
    $store_id = $this->_getParam('store_id', '0');
    if ($store_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->store_id = $store_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('estore_favourite');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'stores')
            ->where('resource_id = ?', $store_id)
            ->order('favourite_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per store and current store number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

  public function followStoreAction() {
    $store_id = $this->_getParam('store_id', '0');
    if ($store_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->store_id = $store_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('estore_follower');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'stores')
            ->where('resource_id = ?', $store_id)
            ->order('follower_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per store and current store number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }

    public function reviewStoreAction() {
    $store_id = $this->_getParam('store_id', '0');
    if ($store_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->store_id = $store_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('estore_review');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('store_id = ?', $store_id)
            ->order('review_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per store and current store number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($page);
  }
  public function getUserStoresAction() {
    $user_id = $this->_getParam('user_id', false);

    $table = Engine_Api::_()->getDbTable('storeroles','estore');
    $selelct = $table->select($table->info('name'),'store_id')->where('user_id =?',$this->view->viewer()->getIdentity());
    $res = $table->fetchAll($selelct);

    $storeIds = array();
    foreach($res as $store){
      $storeIds[] = $store->store_id;
    }
    if (!$user_id)
      $user_id = $this->view->viewer()->getIdentity();
    $value['user_id'] = $user_id;
    $value['storeIds'] = $storeIds;
    $value['fetchAll'] = true;
    $this->view->stores = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect($value);
  }
}
