<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ProfileController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() && ($id = $this->_getParam('coupon_id'))) {
      if ($id) {
        $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $id);
        if ($coupon)
          Engine_Api::_()->core()->setSubject($coupon);
        else
          return $this->_forward('requireauth', 'error', 'core');
      } else
        return $this->_forward('requireauth', 'error', 'core');
    }
    $this->_helper->requireSubject();
    $this->_helper->requireAuth()->setNoForward()->setAuthParams(
            $subject, Engine_Api::_()->user()->getViewer(), 'view'
    );
  }
  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
// 		if((!$subject->is_approved || !$subject->draft) && $viewer->getIdentity() != $subject->getOwner()->getIdentity()){
// 			return $this->_forward('notfound', 'error', 'core');
// 		}
//     if(!$subject->authorization()->isAllowed($viewer, 'view')){
//       return $this->_forward('requireauth', 'error', 'core');
//     }
    // Check block
    if ($viewer->isBlockedBy($subject)) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    // Increment view count
    if (!$subject->getOwner()->isSelf($viewer)) {
      $subject->view_count++;
      $subject->save();
    }
    $this->_helper->content->setEnabled();
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
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'coupon')->getPhotoId($course->photo_id);
    $photo = Engine_Api::_()->getItem('coupon_photo', $getPhotoId);

    $courselink = '<a href="' . $course->getHref() . '">' . $course->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'coupon_course_pfphoto', null, array('coursename' => $courselink));
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

//    if ($photo != 0) {
//      $im = Engine_Api::_()->getItem('storage_file', $photo);
//      $im->delete();
//    }
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
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'coupon')->getPhotoId($course->cover);
    $photo = Engine_Api::_()->getItem('coupon_photo', $getPhotoId);

    $courselink = '<a href="' . $course->getHref() . '">' . $course->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'coupon_course_coverphoto', null, array('coursename' => $courselink));
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
    $course = Engine_Api::_()->getItem('coupon', $course_id);
    if (!$course)
      return;
    $position = $this->_getParam('position', '0');
    $course->cover_position = $position;
    $course->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
