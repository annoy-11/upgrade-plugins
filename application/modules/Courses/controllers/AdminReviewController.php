<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminReviewController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_AdminReviewController extends Core_Controller_Action_Admin {

  public function reviewSettingsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_rvwstngs');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_rvwstngs', array(), 'courses_admin_main_courservw');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_courservw', array(), 'courses_admin_main_rvwprm');
    $this->view->form = $form = new Courses_Form_Admin_Course_Review_ReviewSettings();
    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) )
    {
      $values = $form->getValues();
      foreach ($values as $key => $value){
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
  public function manageReviewsAction() {
     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_rvwstngs');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_rvwstngs', array(), 'courses_admin_main_courservw');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_courservw', array(), 'courses_admin_main_mngrvw');
    $this->view->formFilter = $formFilter = new Courses_Form_Admin_Course_Review_Filter();
    //Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams())) {
      $values = $formFilter->getValues();
    }
    foreach ($_GET as $key => $value) {
      if ('' === $value) {
        unset($_GET[$key]);
      } else
        $values[$key] = $value;
    }
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $video = Engine_Api::_()->getItem('courses_review', $value)->delete();
        }
      }
    }
    $table = Engine_Api::_()->getDbtable('reviews', 'courses');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
				    ->order('review_id DESC');
    if (!empty($_GET['title']))
      $select->where('title LIKE ?', '%' . $_GET['title'] . '%');
    if (!empty($_GET['rating_star']))
      $select->where($tableName.'.rating = ?',  $_GET['rating_star']);
    if (!empty($_GET['oftheday']))
      $select->where($tableName.'.offtheday LIKE ?', '%' . $_GET['oftheday'] . '%');
    if (!empty($_GET['featured']))
      $select->where($tableName.'.featured LIKE ?', '%' . $_GET['featured'] . '%');
    if (!empty($_GET['verified']))
      $select->where($tableName.'.verified = ?',  $_GET['verified']);
      
    if (!empty($_GET['creation_date']))
      $select->where('date(' . $tableName . '.creation_date) = ?', $_GET['creation_date']);

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (!empty($_GET['course_title'])){
        $tableCourseName = Engine_Api::_()->getItemTable('courses')->info('name');
        $select->joinLeft($tableCourseName, $tableCourseName . '.course_id = ' . $tableName . '.course_id',null);
        $select->where($tableCourseName.'.title LIKE ?', '%' . $values['course_title'] . '%');
    }
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function viewAction() {
    $this->view->item = Engine_Api::_()->getItem('courses_review', $this->_getParam('id', null));
  }
  //Delete entry
  public function deleteReviewAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Review');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $review = Engine_Api::_()->getItem('courses_review', $this->_getParam('review_id',$this->_getParam('id')));
        $review->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete entry.')
      ));
    }
  }
  public function levelSettingsAction() {
	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_rvwstngs');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_rvwstngs', array(), 'courses_admin_main_courservw');
     $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_courservw', array(), 'courses_admin_main_lvlstngs');

    //Get level id
    if (null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))))
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    else
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();

    if (!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');
    $id = $level->level_id;
    //Make form
    $this->view->form = $form = new Courses_Form_Admin_Course_Review_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);
    $content_type = 'courses_review';
    $module_name = $this->_getParam('module_name', null);

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed($content_type, $id, array_keys($form->getValues())));
    //Check post
    if (!$this->getRequest()->isPost())
      return;
    //Check validitiy
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    //Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      //Set permissions
      $permissionsTable->setAllowed($content_type, $id, $values);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }
  public function reviewParameterAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main', array(), 'courses_admin_main_rvwstngs');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_rvwstngs', array(), 'courses_admin_main_courservw');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('courses_admin_main_courservw', array(), 'courses_admin_main_rvwprmtr');
     $this->view->category = Engine_Api::_()->getDbTable('categories', 'courses')->getCategory(array('column_name' => '*', 'profile_type' => true));
    //END PROFILE TYPE WORK
  }
  public function addParameterAction() {
    $category_id = $this->_getParam('id', null);
    if (!$category_id)
      return $this->_forward('notfound', 'error', 'core');
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Courses_Form_Admin_Course_Parameter_Add();
    $reviewParameters = Engine_Api::_()->getDbtable('parameters', 'courses')->getParameterResult(array('category_id' => $category_id));
    if (!count($reviewParameters))
      $form->setTitle('Add Review Parameters');
    else {
      $form->setTitle('Edit Review Parameters');
      $form->submit->setLabel('Edit');
    }
    $form->setDescription("");
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = Engine_Api::_()->getDbtable('parameters', 'courses');
    $tablename = $table->info('name');
    try {
      $values = $form->getValues();
      unset($values['addmore']);
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $deleteIds = explode(',', $_POST['deletedIds']);
      foreach ($deleteIds as $val) {
        if (!$val)
          continue;
        $query = 'DELETE FROM ' . $tablename . ' WHERE parameter_id = ' . $val;
        $dbObject->query($query);
      }
      foreach ($_POST as $key => $value) {
        if (count(explode('_', $key)) != 3 || !$value)
          continue;
        $id = str_replace('courses_review_', '', $key);
        $query = 'UPDATE ' . $tablename . ' SET title = "' . $value . '" WHERE parameter_id = ' . $id;
        $dbObject->query($query);
      }
      foreach ($_POST['parameters'] as $key => $val) {
        if ($_POST['parameters'][$key] != '') {
          $query = 'INSERT IGNORE INTO ' . $tablename . ' (`category_id`, `title`, `rating`) VALUES ("' . $category_id . '","' . $val . '","0")';
          $dbObject->query($query);
        }
      }
    } catch (Exception $e) {
      throw $e;
    }
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Review Parameters have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array($this->view->message)
    ));
  }
  public function verifyAction() {
   $review_id = $this->_getParam('review_id',false);
    $item = Engine_Api::_()->getItem('courses_review', $review_id);
    $item->verified = !$item->verified;
    $item->save();
    $this->_redirect('admin/courses/review/manage-reviews');
  }
   //Featured Action
  public function featuredAction() {
    $review_id = $this->_getParam('review_id',false);
    $item = Engine_Api::_()->getItem('courses_review', $review_id);
    $item->featured = !$item->featured;
    $item->save();
    $this->_redirect('admin/courses/review/manage-reviews');
  }
  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $review_id = $this->_getParam('review_id',false);
    $item = Engine_Api::_()->getItem('courses_review', $review_id);
    $id = $review_id;
    $dbTable = 'engine4_courses_reviews';
    $item_id = 'review_id';
    $param = $this->_getParam('param');
    $this->view->form = $form = new Courses_Form_Admin_Oftheday();
        $form->setTitle("Review of the Day");
        $form->setDescription('Here, choose the start date and end date for this course to be displayed as "Review of the Day".');
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
}
