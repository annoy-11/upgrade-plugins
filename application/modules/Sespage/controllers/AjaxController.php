<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AjaxController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_AjaxController extends Core_Controller_Action_Standard {

  //get page categories
  public function customUrlCheckAction() {
    $value = $this->sanitize($this->_getParam('value', null));
    if (!$value) {
      echo json_encode(array('error' => true));
      die;
    }
    $page_id = $this->_getParam('page_id', null);
    if($page_id) {
      $oldeText = Engine_Api::_()->getItem('sespage_page',$page_id)->custom_url;
    }
   // $custom_url = Engine_Api::_()->getDbTable('pages', 'sespage')->checkCustomUrl($value, $page_id);
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
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sespage')->getModuleSubcategory(array('category_id' => $category_id, 'column_name' => '*'));
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

  // get page subsubcategory
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbTable('categories', 'sespage')->getModuleSubsubcategory(array('category_id' => $category_id, 'column_name' => '*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if(!isset($_POST['quickPage']))
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
    if ($type == 'sespage_page') {
      $dbTable = 'pages';
      $modulename = 'sespage';
      $resorces_id = 'page_id';
      $notificationType = 'sespage_page_like';
    } elseif($type == 'sespage_photo') {
      $dbTable = 'photos';
      $modulename = 'sespage';
      $resorces_id = 'photo_id';
      $notificationType = 'sespage_photo_like';
    } elseif($type == 'sespage_album') {
      $dbTable = 'albums';
      $modulename = 'sespage';
      $resorces_id = 'album_id';
      $notificationType = 'sespage_album_like';
    } elseif($type == 'pagenote') {
      $dbTable = 'pagenotes';
      $modulename = 'sespagenote';
      $resorces_id = 'pagenote_id';
      $notificationType = 'sespagenote_like';
    } elseif($type == 'pageoffer') {
      $dbTable = 'pageoffers';
      $modulename = 'sespageoffer';
      $resorces_id = 'pageoffer_id';
      $notificationType = 'sespageoffer_like';
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
        if($type == 'sespage_page') {

          if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $owner->getIdentity()))) {
            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
          }

          // Page admin notifications and email work
          $getAllPageAdmins = Engine_Api::_()->getDbTable('pageroles', 'sespage')->getAllPageAdmins(array('page_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
          foreach($getAllPageAdmins as $getAllPageAdmin) {
            $pageadmin = Engine_Api::_()->getItem('user', $getAllPageAdmin->user_id);
            if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_like','notification_type'=>'site_notification', 'user_id' => $pageadmin->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }
          }

          $joinedMembers = Engine_Api::_()->sespage()->getallJoinedMembers($item);
          foreach($joinedMembers as $joinedMember) {
            $joinedMember = Engine_Api::_()->getItem('user', $joinedMember->user_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, $viewer, $subject, 'sespage_page_pagesijoinedlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_likepagejoined', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          $followerMembers = Engine_Api::_()->getDbTable('followers', 'sespage')->getFollowers($item->getIdentity());
          foreach($followerMembers as $followerMember) {
            $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, $viewer, $subject, 'sespage_page_pagesifollowedlike');

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_sespage_page_likepagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }

          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pageliked', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        } else {
          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        }


        //$result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));


        if($notificationType == 'sespage_page_like') {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sespage_album_like') {
          $page = Engine_Api::_()->getItem('sespage_page', $subject->page_id);
          $albumlink = '<a href="' . $subject->getHref() . '">' . 'album' . '</a>';
          $pagelink = '<a href="' . $page->getHref() . '">' . $page->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('albumlink' => $albumlink, 'pagename' => $pagelink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        } else if($notificationType == 'sespage_photo_like') {
          $page = Engine_Api::_()->getItem('sespage_page', $subject->page_id);
          $photolink = '<a href="' . $subject->getHref() . '">' . 'photo' . '</a>';
          $pagelink = '<a href="' . $page->getHref() . '">' . $page->getTitle() . '</a>';
          $action = $activityTable->addActivity($viewer, $subject, $notificationType, null, array('photolink' => $photolink, 'pagename' => $pagelink));
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      if ($type == 'sespage_page') {
        $pageFollowers = Engine_Api::_()->getDbTable('followers', 'sespage')->getFollowers($subject->page_id);
        if (count($pageFollowers) > 0) {
          foreach ($pageFollowers as $follower) {
            $user = Engine_Api::_()->getItem('user', $follower->owner_id);
            if ($user->getIdentity()) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $subject, 'sespage_page_like_followed');
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
    if ($this->_getParam('type') == 'sespage_page') {
      $type = 'sespage_page';
      $dbTable = 'pages';
      $modulename = 'sespage';
      $resorces_id = 'page_id';
      $notificationType = 'sespage_page_favourite';
    } elseif ($this->_getParam('type') == 'sespage_photo') {
      $type = 'sespage_photo';
      $dbTable = 'photos';
      $modulename = 'sespage';
      $resorces_id = 'photo_id';
      $notificationType = '';
    } elseif ($this->_getParam('type') == 'sespage_album') {
      $type = 'sespage_album';
      $dbTable = 'albums';
      $modulename = 'sespage';
      $resorces_id = 'album_id';
      $notificationType = '';
    } elseif ($this->_getParam('type') == 'pagenote') {
      $type = 'pagenote';
      $dbTable = 'pagenotes';
      $modulename = 'sespagenote';
      $resorces_id = 'pagenote_id';
      $notificationType = 'sespagenote_favourite';
    } elseif ($this->_getParam('type') == 'pageoffer') {
      $type = 'pageoffer';
      $dbTable = 'pageoffers';
      $modulename = 'sespageoffer';
      $resorces_id = 'pageoffer_id';
      $notificationType = 'sespageoffer_favourite';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sespage')->getItemfav($type, $item_id);
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
      $db = Engine_Api::_()->getDbTable('favourites', 'sespage')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sespage')->createRow();
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

          if($type == 'sespage_page') {

            if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
              Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
            }

            //Send to page owner when someonce mark page to favourite
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pagemarkfavourite', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));

            if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
              Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
            }

            // Page admin notifications and email work
            $getAllPageAdmins = Engine_Api::_()->getDbTable('pageroles', 'sespage')->getAllPageAdmins(array('page_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
            foreach($getAllPageAdmins as $getAllPageAdmin) {
              $pageadmin = Engine_Api::_()->getItem('user', $getAllPageAdmin->user_id);
              if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'site_notification', 'user_id' => $pageadmin->getIdentity()))) {
                Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
              }
              if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_favourite','notification_type'=>'email_notification', 'user_id' => $pageadmin->getIdentity()))) {
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
              }
            }
          } else {

            Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'sespage')->getItemFollower($item_type, $item_id);
    if($item_type == 'sespage_page') {
        $followerItem = Engine_Api::_()->getDbTable('pages', 'sespage');
    } elseif($item_type == 'pageoffer') {
        $followerItem = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer');
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
      if($item_type == 'sespage_page') {
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('page_id = ?' => $item_id));
      } elseif($item_type == 'pageoffer') {
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('pageoffer_id = ?' => $item_id));
      }

      $item = Engine_Api::_()->getItem($item_type, $item_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sespage_page_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'sespage_page_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'sespage')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sespage')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = $item_type;
        $follow->resource_id = $item_id;
        $follow->save();
        if($item_type == 'sespage_page') {
            $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('page_id = ?' => $item_id));
        } elseif($item_type == 'pageoffer') {
            $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('pageoffer_id = ?' => $item_id));
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
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && $item_type == 'sespage_page') {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'sespage_page_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sespage_page_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }

        if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $item->getOwner()->getIdentity()))) {

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sespage_page_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sespage_page_follow');
        }

        if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $item->getOwner()->getIdentity()))) {
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($subject->getOwner(), 'notify_sespage_page_pagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }


        // Page admin notifications and email work
        $getAllPageAdmins = Engine_Api::_()->getDbTable('pageroles', 'sespage')->getAllPageAdmins(array('page_id' => $item->getIdentity(), 'user_id' => $item->owner_id));
        foreach($getAllPageAdmins as $getAllPageAdmin) {

          $pageadmin = Engine_Api::_()->getItem('user', $getAllPageAdmin->user_id);

          if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'site_notification', 'user_id' => $pageadmin->getIdentity()))) {

            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($pageadmin, $viewer, $item, 'sespage_page_follow');
          }

          if(Engine_Api::_()->getDbTable('notifications','sespage')->getNotifications(array('page_id'=>$item->getIdentity(), 'type'=>'notification_type','role'=>'new_follow','notification_type'=>'email_notification', 'user_id' => $pageadmin->getIdentity()))) {

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($pageadmin, 'notify_sespage_page_pagefollowed', array('page_title' => $subject->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $subject->getHref(), 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      } elseif ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && $item_type == 'pageoffer') {

        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'sespageoffer_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sespageoffer_follow');
        }

          Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sespageoffer_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sespageoffer_follow');
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
    $Fav = Engine_Api::_()->getDbTable('followers', 'sespage')->getItemFollower('sespage_category', $item_id);
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
      $db = Engine_Api::_()->getDbTable('followers', 'sespage')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sespage')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'sespage_category';
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

  public function getPageAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
    $value['fetchAll'] = true;
    $value['getpage'] = true;
    $pages = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($value);
    foreach ($pages as $page) {
      $page_icon = $this->view->itemPhoto($page, 'thumb.icon');
      $sesdata[] = array(
          'id' => $page->page_id,
          'label' => $page->title,
          'photo' => $page_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function likePageAction() {
    $page_id = $this->_getParam('page_id', '0');
    if ($page_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page_id = $page_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sespage_page')
            ->where('resource_id = ?', $page_id)
            ->order('like_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }

  public function favouritePageAction() {
    $page_id = $this->_getParam('page_id', '0');
    if ($page_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page_id = $page_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sespage_favourite');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sespage_page')
            ->where('resource_id = ?', $page_id)
            ->order('favourite_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }

  public function followPageAction() {
    $page_id = $this->_getParam('page_id', '0');
    if ($page_id == 0)
      return;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page_id = $page_id;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $parentTable = Engine_Api::_()->getItemTable('sespage_follower');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', 'sespage_page')
            ->where('resource_id = ?', $page_id)
            ->order('follower_id DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }

  public function getUserPagesAction() {
    $user_id = $this->_getParam('user_id', false);

    $table = Engine_Api::_()->getDbTable('pageroles','sespage');
    $selelct = $table->select($table->info('name'),'page_id')->where('user_id =?',$this->view->viewer()->getIdentity());
    $res = $table->fetchAll($selelct);

    $pageIds = array();
    foreach($res as $page){
      $pageIds[] = $page->page_id;
    }
    if (!$user_id)
      $user_id = $this->view->viewer()->getIdentity();
    $value['user_id'] = $user_id;
    $value['pageIds'] = $pageIds;
    $value['fetchAll'] = true;
    $this->view->pages = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($value);
  }

}
