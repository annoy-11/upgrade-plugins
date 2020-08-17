<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminManageController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_mng');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_mng', array(), 'courses_admin_main_mgcrs');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Filter(array(
            'resourseType' => 'course',
        ));
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $courses = Engine_Api::_()->getItem('courses', $value);
            Engine_Api::_()->courses()->deleteCourse($courses);
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $coursesTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $coursesTableName = $coursesTable->info('name');
    $select = $coursesTable->select()
            ->setIntegrityCheck(false)
            ->from($coursesTableName,array('course_id','is_approved','featured','sponsored','verified','enddate','offtheday','creation_date','custom_url','owner_id','title','price','hot'))
            ->joinLeft($tableUserName, "$coursesTableName.owner_id = $tableUserName.user_id", 'username')
            ->order($coursesTableName.(!empty($_GET['order']) ? '.'.$_GET['order'] : '.course_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['course_title']))
      $select->where($coursesTableName . '.title LIKE ?', '%' . $_GET['course_title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['price_max']))
        $select->having($coursesTableName.".price <=?", $_GET['price_max']);
    if (!empty($_GET['price_min']))
        $select->having($coursesTableName.".price >=?", $_GET['price_min']);
    if (!empty($_GET['category_id']))
      $select->where($coursesTableName . '.category_id =?', $_GET['category_id']);
    if (!empty($_GET['subcat_id']))
      $select->where($coursesTableName . '.subcat_id =?', $_GET['subcat_id']);
    if (!empty($_GET['subsubcat_id']))
      $select->where($coursesTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);
    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($coursesTableName . '.featured = ?', $_GET['featured']);
    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($coursesTableName . '.sponsored = ?', $_GET['sponsored']);
    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($coursesTableName . '.verified = ?', $_GET['verified']);
    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($coursesTableName . '.hot = ?', $_GET['hot']);
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($coursesTableName . '.offtheday = ?', $_GET['offtheday']);
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($coursesTableName . '.is_approved = ?', $_GET['is_approved']);
    if (!empty($_GET['date']['date_from']))
        $select->having($coursesTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($coursesTableName . '.creation_date >=?', $_GET['date']['date_to']);
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
  
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  
  public function lectureAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_mng');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_mng', array(), 'courses_admin_main_mglct');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_LectureFilter(array(
            'resourseType' => 'lecture',
    ));
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $item = Engine_Api::_()->getItem('courses_lecture', $value);
            $course = Engine_Api::_()->getItem('courses', $item->course_id);
            $item->delete();
            $course->lecture_count--;
            $course->save();
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $coursesTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $coursesTableName = $coursesTable->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $lectureTable = Engine_Api::_()->getDbTable('lectures', 'courses');
    $lectureTableName = $lectureTable->info('name');
    $select = $lectureTable->select()
            ->setIntegrityCheck(false)
            ->from($lectureTableName,array('lecture_id','course_id','creation_date','owner_id','title','is_approved','view_count','type'))
            ->joinLeft($tableUserName, "$lectureTableName.owner_id = $tableUserName.user_id", 'username')
            ->joinLeft($coursesTableName, "$lectureTableName.course_id = $coursesTableName.course_id",array("course_title"=>"title"))
            ->order($lectureTableName.(!empty($_GET['order']) ? '.'.$_GET['order'] : '.lecture_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['course_title']))
      $select->where($coursesTableName . '.course_title LIKE ?', '%' . $_GET['course_title'] . '%');
    if (!empty($_GET['lecture_title']))
      $select->where($lectureTableName . '.title LIKE ?', '%' . $_GET['lecture_title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($lectureTableName . '.offtheday = ?', $_GET['offtheday']);
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($lectureTableName . '.is_approved = ?', $_GET['is_approved']);
    if (!empty($_GET['date']['date_from']))
        $select->having($lectureTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($lectureTableName . '.creation_date >=?', $_GET['date']['date_to']);
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function testAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_mng');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_mng', array(), 'courses_admin_main_mgtst');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_TestFilter(array(
            'resourseType' => 'course',
    ));
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
             $item = Engine_Api::_()->getItem('courses_test', $value);
            $course = Engine_Api::_()->getItem('courses', $item->course_id);
            $item->delete();
            $course->test_count--;
            $course->save();
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $coursesTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $coursesTableName = $coursesTable->info('name');
    $testTable = Engine_Api::_()->getDbTable('Tests', 'courses');
    $testTableName = $testTable->info('name');
    $select = $testTable->select()
            ->setIntegrityCheck(false)
            ->from($testTableName,array('course_id','title','creation_date','total_questions','test_time','test_id','owner_id'))
            ->joinLeft($tableUserName, "$testTableName.owner_id = $tableUserName.user_id", 'username')
            ->joinLeft($coursesTableName, "$testTableName.course_id = $coursesTableName.course_id",array("course_title"=>"title"))
            ->order($testTableName.(!empty($_GET['order']) ? '.'.$_GET['order'] : '.test_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    $select->where($testTableName . '.is_delete != ?',1);
    if (!empty($_GET['course_title']))
      $select->where($coursesTableName . '.course_title LIKE ?', '%' . $_GET['course_title'] . '%');
    if (!empty($_GET['test_title']))
      $select->where($testTableName . '.title LIKE ?', '%' . $_GET['test_title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['date']['date_from']))
        $select->having($testTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($testTableName . '.creation_date >=?', $_GET['date']['date_to']);
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  
  public function manageClassroomAction() {
     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_mng');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_mng', array(), 'courses_admin_main_mgcls');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Filter();
    $this->view->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $this->view->subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : 0;
    $this->view->subsubcat_id = isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : 0;
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $classroom = Engine_Api::_()->getItem('classroom', $value);
            Engine_Api::_()->courses()->deleteClassroom($classroom);
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $classroomTableName = $classroomTable->info('name');
    $select = $classroomTable->select()
            ->setIntegrityCheck(false)
            ->from($classroomTableName,array('classroom_id','is_approved','featured','sponsored','hot','verified','enddate','offtheday','creation_date','custom_url','owner_id','title'))
            ->joinLeft($tableUserName, "$classroomTableName.owner_id = $tableUserName.user_id", 'username')
            ->order($classroomTableName.(!empty($_GET['order']) ? '.'.$_GET['order'] : '.classroom_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['classroom_title']))
      $select->where($classroomTableName . '.title LIKE ?', '%' . $_GET['classroom_title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['category_id']))
      $select->where($classroomTableName . '.category_id =?', $_GET['category_id']);
    if (!empty($_GET['subcat_id']))
      $select->where($classroomTableName . '.subcat_id =?', $_GET['subcat_id']);
    if (!empty($_GET['subsubcat_id']))
      $select->where($classroomTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);
    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($classroomTableName . '.featured = ?', $_GET['featured']);
    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
      $select->where($classroomTableName . '.sponsored = ?', $_GET['sponsored']);
    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($classroomTableName . '.verified = ?', $_GET['verified']);
    if (isset($_GET['hot']) && $_GET['hot'] != '')
      $select->where($classroomTableName . '.hot = ?', $_GET['hot']);
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
      $select->where($classroomTableName . '.offtheday = ?', $_GET['offtheday']);
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($classroomTableName . '.is_approved = ?', $_GET['is_approved']);
    if (!empty($_GET['creation_date']))
      $select->where($classroomTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $course_id = $this->_getParam('course_id',false);
    $item = Engine_Api::_()->getItem('courses', $course_id);
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete course?');
    $form->setDescription('Are you sure that you want to delete this course? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
         if ($classroom_id)
            Engine_Api::_()->courses()->deleteClassroom($item);
         else
            Engine_Api::_()->courses()->deleteCourse($item);
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this entry.')
      ));
    }
  }
  public function lectureDeleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $lecture_id = $this->_getParam('lecture_id',false);
    $item = Engine_Api::_()->getItem('courses_lecture', $lecture_id);
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Lecture?');
    $form->setDescription('Are you sure that you want to delete this Lecture? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          if(count($item)) {
            $course = Engine_Api::_()->getItem('courses', $item->course_id);
            $item->delete();
            $course->lecture_count--;
            $course->save();
          }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this entry.')
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }
  public function testDeleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $test_id = $this->_getParam('test_id',false);
    $item = Engine_Api::_()->getItem('courses_test', $test_id);
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Test?');
    $form->setDescription('Are you sure that you want to delete this Test? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          if(count($item)) {
            $course = Engine_Api::_()->getItem('courses', $item->course_id);
            $item->delete();
            $course->test_count--;
            $course->save();
          }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this entry.')
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }
  
  //Featured Action
  public function featuredAction() {
    $course_id = $this->_getParam('course_id',false);
    $wishlist_id = $this->_getParam('wishlist_id',null);
    if($wishlist_id){
        $item = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
          $item->is_featured = !$item->is_featured;
         $url = 'admin/courses/manage/wishlist';
    } else {
        $item = Engine_Api::_()->getItem('courses', $course_id);
        $url = 'admin/courses/manage';
        $item->featured = !$item->featured;
        if($item->featured){
           $viewer = Engine_Api::_()->user()->getViewer();
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'courses_course_featured');
        }
    }
    $item->save();
    $this->_redirect($url);
  }

  //Sponsored Action
  public function sponsoredAction() {
    $course_id = $this->_getParam('course_id',false);
    $wishlist_id = $this->_getParam('wishlist_id',null);
    if($wishlist_id){
        $item = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
          $item->is_sponsored = !$item->is_sponsored;
         $url = 'admin/courses/manage/wishlist';
    } else {
        $item = Engine_Api::_()->getItem('courses', $course_id);
        $url = 'admin/courses/manage';
        $item->sponsored = !$item->sponsored;
        if($item->sponsored){
          $viewer = Engine_Api::_()->user()->getViewer();
          Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'courses_course_sponsored');
        }
    }
    $item->save();
    $this->_redirect($url);
  }

  //Verify Action
  public function verifyAction() {
    $course_id = $this->_getParam('course_id',false);
    $wishlist_id = $this->_getParam('wishlist_id',null);
    if($wishlist_id){
        $item = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
          $item->is_private = !$item->is_private;
         $url = 'admin/courses/manage/wishlist';
    } else {
        $item = Engine_Api::_()->getItem('courses', $course_id);
        $url = 'admin/courses/manage';
        $item->verified = !$item->verified;
      if($item->verified){
        $viewer = Engine_Api::_()->user()->getViewer();
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'courses_course_verified');
      }
    }
    $item->save();
    $this->_redirect($url);
  }

  //Verify Action
  public function hotAction() {
    $course_id = $this->_getParam('course_id',false);
    if(!$course_id)
      return;
    $item = Engine_Api::_()->getItem('courses', $course_id);
    $item->hot = !$item->hot;
    $item->save();
    $this->_redirect('admin/courses/manage');
  }

  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $course_id = $this->_getParam('course_id',false);
    $wishlist_id = $this->_getParam('wishlist_id',false);
    if (!empty($course_id) && empty($wishlist_id)) {
      $item = Engine_Api::_()->getItem('courses', $course_id);
      $id = $course_id;
      $dbTable = 'engine4_courses_courses';
      $item_id = 'course_id';
    }else if(empty($course_id) && !empty($wishlist_id)){
        $item = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
        $id = $wishlist_id;
        $dbTable = 'engine4_courses_wishlists';
        $item_id = 'wishlist_id';
    }
    if($course_id)

    $param = $this->_getParam('param');
    $this->view->form = $form = new Courses_Form_Admin_Oftheday();
    if (!empty($course_id)) {
        $form->setTitle("Course of the Day");
        $form->setDescription('Here, choose the start date and end date for this product to be displayed as "Course of the Day".');
    } else {
        $form->setTitle("Wishlist of the Day");
        $form->setDescription('Here, choose the start date and end date for this product to be displayed as "Wishlist of the Day".');
    }
    $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) {
        return;
      }
      $values = $form->getValues();
      $start = strtotime($values['startdate']);
      $end = strtotime($values['enddate']);
      $values['startdate'] = date('Y-m-d', $start);
      $values['enddate'] = date('Y-m-d', $end);
      $db->update($dbTable, array('startdate' => $values['startdate'], 'enddate' => $values['enddate']), array("$item_id = ?" => $id));
      if (@$values['remove']) {
        $db->update($dbTable, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($dbTable, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }

  public function viewAction() {
    $course_id = $this->_getParam('course_id',false);
    if(!$course_id)
        return;
    $item = Engine_Api::_()->getItem('courses', $course_id);
    $this->view->item = $item;
  }
    
  //Approved Action
  public function lectureApprovedAction() {
    $lecture_id = $this->_getParam('lecture_id',false);
    if(!$lecture_id)
        return;
    $item = Engine_Api::_()->getItem('courses_lecture', $lecture_id);
    $item->is_approved = !$item->is_approved;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/courses/manage/lecture');
  }
  
  //Approved Action
  public function approvedAction() {
    $course_id = $this->_getParam('course_id',false);
    if(!$course_id)
        return;
    $item = Engine_Api::_()->getItem('courses', $course_id);
    $item->is_approved = !$item->is_approved;
    $viewer = Engine_Api::_()->user()->getViewer();
    if($item->is_approved){
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'courses_course_adminaapr');
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->getOwner(), 'courses_course_adminaapr', array('course_title' => $item->getTitle(), 'recipient_title' => $item->getOwner()->getTitle(), 'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    } else {
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'courses_course_admindisapr');
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($item->getOwner(), 'courses_course_admindisapr', array('course_title' => $item->getTitle(), 'recipient_title' => $item->getOwner()->getTitle(), 'object_link' => $item->getHref(), 'host' => $_SERVER['HTTP_HOST']));
    }
    $item->save();
    $this->_redirect('admin/courses/manage');
  }
  public function wishlistAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_managewishlists');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Wishlist();
    if ($this->getRequest()->isPost()) {
        $values = $this->getRequest()->getPost();
        foreach ($values as $key => $value) {
            if ($key == 'delete_' . $value) {
                $wishlist = Engine_Api::_()->getItem('courses_wishlist', $value);
                $wishlist->delete();
            }
        }
        $this->_redirect('admin/courses/manage/wishlist');
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $productTable = Engine_Api::_()->getDbTable('wishlists', 'courses');
    $courseTableName = $productTable->info('name');
    $select = $productTable->select()
        ->setIntegrityCheck(false)
        ->from($courseTableName)
        ->joinLeft($tableUserName, "$courseTableName.owner_id = $tableUserName.user_id", 'username')
        ->order((!empty($_GET['order']) ? $_GET['order'] : 'wishlist_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
        $select->where($courseTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');
    if (!empty($_GET['owner_name']))
        $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (isset($_GET['is_featured']) && $_GET['is_featured'] != '')
        $select->where($courseTableName . '.is_featured = ?', $_GET['is_featured']);
    if (isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '')
        $select->where($courseTableName . '.is_sponsored = ?', $_GET['is_sponsored']);
    if (isset($_GET['is_private']) && $_GET['is_private'] != '')
        $select->where($courseTableName . '.is_private = ?', $_GET['is_private']);
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
        $select->where($courseTableName . '.offtheday = ?', $_GET['offtheday']);
    if (!empty($_GET['date']['date_from']))
        $select->having($courseTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($courseTableName . '.creation_date >=?', $_GET['date']['date_to']);
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
        if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
        $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  public function deleteWishlistAction() {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $wishlist_id = $this->_getParam('wishlist_id');
    $this->view->wishlist_id = $wishlist_id;
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete course?');
    $form->setDescription('Are you sure that you want to delete this course? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    // Check post
    if( $this->getRequest()->isPost() ) {
        $wishlist = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
        $db = $wishlist->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->getDbtable('playlistcourses', 'courses')->delete(array('wishlist_id =?' => $this->_getParam('wishlist_id')));
            $wishlist->delete();
            $db->commit();
        } catch(Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh'=> 10,
            'messages' => array('')
        ));
    }
    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }
  public function viewWishlistAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('courses_wishlist', $id);
    $this->view->item = $item;
  }
  
  public function claimAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_crsclaim');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Claim_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $coursesClaim = Engine_Api::_()->getItem('courses_claim', $value);
          $coursesClaim->delete();
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $courseClaimTable = Engine_Api::_()->getDbTable('claims', 'courses');
    $courseClaimTableName = $courseClaimTable->info('name');
    $select = $courseClaimTable->select()
                            ->setIntegrityCheck(false)
                            ->from($courseClaimTableName)
                            ->joinLeft($tableUserName, "$courseClaimTableName.user_id = $tableUserName.user_id", 'username')
                            ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
      $select->where($courseClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
      $select->where($courseClaimTableName . '.status = ?', $_GET['is_approved']);
    if (!empty($_GET['creation_date']))
      $select->where($courseClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('courses_claim', $claimId);
  }
  public function approveClaimAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('courses_claim', $claimId);
    $courseItem = Engine_Api::_()->getItem('courses', $claimItem->course_id);
    $currentOwnerId = $courseItem->owner_id;
    $this->view->form = $form = new Courses_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();
    if (!$this->getRequest()->isPost()) {
        return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
        return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
   if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {
    Engine_Api::_()->eclassroom()->updateNewOwnerId(array('newuser_id' => $claimItem->user_id, 'olduser_id' => $courseItem->owner_id, 'course_id' => $courseItem->course_id));
        $db->update('engine4_courses_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));
        $fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
        $fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
        $mailDataClaimOwner = array('sender_title' => $fromName);
        $bodyForClaimOwner = '';
        $bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
        $bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
        $mailDataClaimOwner['message'] = $bodyForClaimOwner;
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'courses_claim_owner_approve', $mailDataClaimOwner);
        $mailDataCourseOwner = array('sender_title' => $fromName);
        $bodyForCourseOwner = '';
        $bodyForCourseOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
        if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
        $bodyForCourseOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
        $bodyForCourseOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
        $mailDataCourseOwner['message'] = $bodyForCourseOwner;
        $courseOwnerId = Engine_Api::_()->getItem('courses', $claimItem->course_id)->owner_id;
        $courseOwnerEmail = Engine_Api::_()->getItem('user', $courseOwnerId)->email;
        $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
        $courseOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($courseOwnerEmail, 'courses_course_owner_approve', $mailDataCourseOwner);
//         Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $courseItem, 'courses_claim_approve');
//         Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($courseOwner, $viewer, $courseItem, 'courses_owner_informed');
    } elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_courses_claims', array("claim_id = ?" => $claimItem->claim_id));
		 Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $courseItem, 'courses_claim_declined');
    }
    else {
        $form->addError($this->view->translate("Choose atleast one option for this claim request."));
        return;
    }
    $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('Claim has been updated Successfully')
    ));
  }
  public function editorsAction() {
    
  }
  
}
