<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AjaxController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_AjaxController extends Core_Controller_Action_Standard {

  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $course_id = $this->_getParam('course_id', null);
    $custom_url = Engine_Api::_()->getDbtable('courses', 'courses')->checkCustomUrl($value,$course_id);
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
      $subcategory = Engine_Api::_()->getDbTable('categories', 'courses')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
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
  // get course subsubcategory
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'courses')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickCourse']))
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
    if ($type == 'courses') {
      $dbTable = 'courses';
      $resorces_id = 'course_id';
      $sourceType = 'courses';
      $notificationType = 'courses_course_like';
      $actionType = 'courses_course_like';
    } elseif($type == 'courses_wishlist') {
      $dbTable = 'wishlists';
      $resorces_id = 'wishlist_id';
      $sourceType = 'courses';
      //$notificationType = 'courses_photo_like';
    } elseif($type == 'coursesalbum_photo') {
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
       $sourceType = 'coursesalbum';
      $notificationType = 'coursesalbum_photo_like';
    } elseif($type == 'coursesalbum_album') {
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $sourceType = 'coursesalbum';
      $notificationType = 'coursesalbum_album_like';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $itemTable = Engine_Api::_()->getDbTable($dbTable, $sourceType);
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
      $titleMessage = $this->view->translate(array('%s like', '%s likes', $item->like_count), $this->view->locale()->toNumber($item->like_count));
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
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
	       $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
	       Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	       Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
// 	       $result = $activityTable->fetchRow(array('type =?' => $actionType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        $action = $activityTable->addActivity($viewer, $subject, $actionType);
        if ($action)
	          $activityTable->attachActivity($action, $subject);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_courses_course_courseliked', array('course_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }
      $titleMessage = $this->view->translate(array('%s like', '%s likes', $item->like_count), $this->view->locale()->toNumber($item->like_count));
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
    if ($this->_getParam('type') == 'courses') {
      $type = 'courses';
      $dbTable = 'courses';
      $sourceType = 'courses';
      $resorces_id = 'course_id';
      $notificationType = 'courses_course_favourite';
    } elseif($this->_getParam('type') == 'courses_wishlist') {
      $type = 'courses_wishlist';
      $dbTable = 'wishlists';
      $sourceType = 'courses';
      $resorces_id = 'wishlist_id';
      //$notificationType = 'courses_photo_like';
    } elseif ($this->_getParam('type') == 'coursesalbum_photo') {
      $type = 'coursesalbum_photo';
      $dbTable = 'photos';
      $sourceType = 'coursesalbum';
      $resorces_id = 'photo_id';
      $notificationType = 'coursesalbum_photo';
    } elseif ($this->_getParam('type') == 'coursesalbum_album') {
      $type = 'coursesalbum_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
      $sourceType = 'coursesalbum';
      $notificationType = 'coursesalbum_album';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'courses')->getItemfav($type, $item_id);
    $favItem = Engine_Api::_()->getDbTable($dbTable, $sourceType);
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
      $titleMessage = $this->view->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count,'title'=>$titleMessage));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'courses')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'courses')->createRow();
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
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_courses_course_coursefavourites', array('course_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
      }
     // End Activity Feed Work
      $this->view->favourite_id = 1;
      $titleMessage = $this->view->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1,'title'=>$titleMessage));
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
    if ($this->_getParam('type') == 'courses_category') {
        $type = "courses_category";
    } else {

    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'courses')->getItemFollower('courses_category', $item_id);
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
      $db = Engine_Api::_()->getDbTable('followers', 'courses')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'courses')->createRow();
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
}
