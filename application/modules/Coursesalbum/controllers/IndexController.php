<?php

class Coursesalbum_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
   //item favourite as per item tye given
  function favouriteAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
  if ($this->_getParam('type') == 'eclassroom_photo') {
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
      //End Activity Feed Work
      $this->view->favourite_id = 1;
      $titleMessage = $this->view->translate(array('%s favourites', '%s favourite', $item->favourite_count), $this->view->locale()->toNumber($item->favourite_count));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1,'title'=>$titleMessage));
      die;
    }
  }
}
