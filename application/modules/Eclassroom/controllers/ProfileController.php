<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ProfileController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() && ($id = $this->_getParam('id'))) {
      $classroom_id = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomId($id);
      if ($classroom_id) {
        $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
        if ($classroom)
          Engine_Api::_()->core()->setSubject($classroom);
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
    if (!$viewer->getIdentity())
      $level_id = 0;
    else
      $level_id = $viewer->level_id;
    if ((!$subject->is_approved || !$subject->draft) && $level_id != 1 && $level_id != 2) {
      return $this->_forward('notfound', 'error', 'core');
    }
    if(!$subject->authorization()->isAllowed($viewer, 'view')){
      return $this->_forward('requireauth', 'error', 'core');
    }
    // Check block
    if ($viewer->isBlockedBy($subject)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Increment view count
    if (!$subject->getOwner()->isSelf($viewer)) {
      $subject->view_count++;
      $subject->save();
    }
    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_eclassroom_recentlyviewitems (resource_id, resource_type,owner_id,creation_date) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
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
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')){
        $attributionType = Engine_Api::_()->getDbTable('postattributions', 'eclassroom')->getClassroomPostAttribution(array('classroom_id' => $subject->getIdentity()));
        $classroomAttributionType = Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'seb_attribution');
        $allowUserChooseClassroomAttribution = Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'auth_defattribut');
        $enablePostAttribution = Engine_Api::_()->authorization()->isAllowed('classroom', $viewer, 'auth_contSwitch');
        if (!$classroomAttributionType || $attributionType == 0) {
          $classroomAttribution = "";
        }
        if($classroomAttributionType && !$allowUserChooseClassroomAttribution || !$enablePostAttribution) {
          $classroomAttribution = $subject;
        }
        if($classroomAttributionType && $allowUserChooseClassroomAttribution && $attributionType == 1 || !$enablePostAttribution) {
           $classroomAttribution = $subject;
        }
        $data = $this->view->partial('_showAttribution.tpl', 'eclassroom', array('classroom' => $classroomAttribution, 'eclassroom' => $subject));
        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $attrPost = preg_replace($search, $replace, $data);
        $script = '';
        $user_id = $this->view->viewer()->getIdentity();
        if($user_id){
          $value['fetchAll'] = true;
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
          $classroomsUser = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomSelect($value);
        }

        $script .= "sesJqueryObject(document).ready(function () {
           sesJqueryObject('" . $attrPost . "').insertBefore('#compose-container');
           sesJqueryObject('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject('.eclassroom_feed_change_option_a').data('src'));
        });
        var sesItemSubjectGuid = '" . $subject->getGuid() . "';
        ";
        $view->headScript()->appendScript($script);
        if (!$enablePostAttribution || (!$classroomAttributionType) || !$user_id || !count($classroomsUser)) {
          $view->headStyle()->appendStyle('.eclassroom_switcher_cnt{display:none !important;}');
        }
	}
    if ($subject->classroomstyle == 1)
      $classroom = 'eclassroom_profile_index_1';
    elseif ($subject->classroomstyle == 2)
      $classroom = 'eclassroom_profile_index_2';
    elseif ($subject->classroomstyle == 3)
      $classroom = 'eclassroom_profile_index_3';
    elseif ($subject->classroomstyle == 4)
      $classroom = 'eclassroom_profile_index_4';

    $this->_helper->content->setContentName($classroom)->setEnabled();
  }

  //update cover photo function
  public function uploadPhotoAction() {

    $classroom = Engine_Api::_()->core()->getSubject();
    if (!$classroom)
      return;
    $photo = $classroom->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $classroom->setPhoto($data, '', 'profile');

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'eclassroom')->getPhotoId($classroom->photo_id);
    $photo = Engine_Api::_()->getItem('eclassroom_photo', $getPhotoId);

    $classroomlink = '<a href="' . $classroom->getHref() . '">' . $classroom->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'eclassroom_classroom_pfphoto', null, array('classroomname' => $classroomlink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $classroom->getIdentity();
        $detailAction->sesresource_type = $classroom->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

   if ($photo != 0) {
     $im = Engine_Api::_()->getItem('storage_file', $photo);
     if(!empty($im))
      $im->delete();
   }
    echo json_encode(array('file' => $classroom->getPhotoUrl()));
    die;
  }

  public function removePhotoAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    if (!$classroom)
      return false;
    if (isset($classroom->photo_id) && $classroom->photo_id > 0) {
      $classroom->photo_id = 0;
      $classroom->save();
    }
    echo json_encode(array('file' => $classroom->getPhotoUrl()));
    die;
  }

  //update cover photo function
  public function uploadCoverAction() {

    $classroom = Engine_Api::_()->core()->getSubject();
    if (!$classroom)
      return;
    $cover_photo = $classroom->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $classroom->setCoverPhoto($data) ;

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'eclassroom')->getPhotoId($classroom->cover);
    $photo = Engine_Api::_()->getItem('eclassroom_photo', $getPhotoId);

    $classroomlink = '<a href="' . $classroom->getHref() . '">' . $classroom->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'eclassroom_classroom_coverphoto', null, array('classroomname' => $classroomlink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $classroom->getIdentity();
        $detailAction->sesresource_type = $classroom->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      if(!empty($im))
        $im->delete();
    }
    echo json_encode(array('file' => $classroom->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    if (!$classroom)
      return false;
    if (isset($classroom->cover) && $classroom->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $classroom->cover);
      $classroom->cover = 0;
      $classroom->save();
      $im->delete();
    }
    echo json_encode(array('file' => $classroom->getCoverPhotoUrl()));
    die;
  }

  public function repositionCoverAction() {
    $classroom_id = $this->_getParam('id', '0');
    if ($classroom_id == 0)
      return;
    $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    if (!$classroom)
      return;

    $position = $this->_getParam('position', '0');
    $classroom->cover_position = $position;
    $classroom->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
