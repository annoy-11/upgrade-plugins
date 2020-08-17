<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: LectureProfileController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_LectureProfileController extends Core_Controller_Action_Standard {
  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity())
      $level_id = 0;
    else
      $level_id = $viewer->level_id;
    if ((!$subject->is_approved || !$subject->draft ) && $level_id != 1 && $level_id != 2) {
      return $this->_forward('notfound', 'error', 'core');
    }
    if ($viewer->isBlockedBy($subject)) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    // Increment view count
    if (!$subject->getOwner()->isSelf($viewer)) {
      $subject->view_count++;
      $subject->save();
    }
    $this->_helper->content->setEnabled();
    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_courses_recentlyviewitems (resource_id, resource_type,owner_id,creation_date) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
     }
    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $subject->getType())
            ->where('id = ?', $subject->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
      $view->doctype('XHTML1_RDFA');
      if ($subject->seo_title)
        $view->headTitle($subject->seo_title, 'SET');
      if ($subject->seo_description)
        $view->headMeta()->appendName('description', $subject->seo_description);
    }
  }
  //update cover photo function
  public function uploadPhotoAction() {
    $course = Engine_Api::_()->core()->getSubject();
    if (!$course)
      return;
    $photo = $course->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $course->setPhoto($data, '', 'profile');

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'courses')->getPhotoId($course->photo_id);
    $photo = Engine_Api::_()->getItem('courses_photo', $getPhotoId);

    $courselink = '<a href="' . $course->getHref() . '">' . $course->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'courses_course_pfphoto', null, array('coursename' => $courselink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $course->getIdentity();
        $detailAction->sesresource_type = $course->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
    echo json_encode(array('file' => $course->getPhotoUrl()));
    die;
  }
  public function removePhotoAction() {
    $course = Engine_Api::_()->core()->getSubject();
    if (!$course)
      return false;
    if (isset($course->photo_id) && $course->photo_id > 0) {
      $course->photo_id = 0;
      $course->save();
    }
    echo json_encode(array('file' => $course->getPhotoUrl()));
    die;
  }
  //update cover photo function
  public function uploadCoverAction() {
    $course = Engine_Api::_()->core()->getSubject();
    if (!$course)
      return;
    $cover_photo = $course->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $course->setCoverPhoto($data) ;
    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'courses')->getPhotoId($course->cover);
    $photo = Engine_Api::_()->getItem('courses_photo', $getPhotoId);

    $courselink = '<a href="' . $course->getHref() . '">' . $course->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'courses_course_coverphoto', null, array('coursename' => $courselink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $course->getIdentity();
        $detailAction->sesresource_type = $course->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      $im->delete();
    }
    echo json_encode(array('file' => $course->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $course = Engine_Api::_()->core()->getSubject();
    if (!$course)
      return false;
    if (isset($course->cover) && $course->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $course->cover);
      $course->cover = 0;
      $course->save();
      $im->delete();
    }
    echo json_encode(array('file' => $course->getCoverPhotoUrl()));
    die;
  }
  public function repositionCoverAction() {
    $course_id = $this->_getParam('id', '0');
    if ($course_id == 0)
      return;
    $course = Engine_Api::_()->getItem('courses', $course_id);
    if (!$course)
      return;
    $position = $this->_getParam('position', '0');
    $course->cover_position = $position;
    $course->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
