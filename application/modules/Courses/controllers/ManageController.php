<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ManageController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_ManageController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'view')->isValid())
      return;
  }
  public function billingAction()
  {
  $this->_helper->content->setEnabled();
   $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
    $addressTable = Engine_Api::_()->getDbTable('addresses','courses');
    $billingAddressArray = $addressTable->getAddress(array('user_id'=>$viewer_id));
    $this->view->form = $form = new Courses_Form_Billing();
    if(count($billingAddressArray)){
        $this->view->country_id = $billingAddressArray->country;
        $this->view->state_id = $billingAddressArray->state;
        $form->populate($billingAddressArray->toArray());
    }
    $form->setTitle('Billing form');
    $form->setAttrib('id', 'courses_billing_form');
    if($this->getRequest()->isPost())
    {
        if(!count($billingAddressArray)){
            $billing = $addressTable->createRow();
            $billing->setFromArray($_POST);
            $billing->user_id = $viewer_id;
            $billing->save();
        }else{
            $billing = $billingAddressArray;
            $billing->setFromArray($_POST);
            $billing->user_id = $viewer_id;
            $billing->save();
        }
         $this->_redirect('/courses/manage/billing');
    }
  }
public function myOrderAction()
{
   $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
      $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      if($this->_getParam('is_ajax',null) && $this->_getParam('order_id',null))
        {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $order = Engine_Api::_()->getItem('courses_order', $this->_getParam('order_id'))->delete();
            $db->commit();
             echo json_encode(array('status'=>1));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
         echo json_encode(array('status'=>0));die;
     }
    if ($this->getRequest()->isPost()) {
      $deleteOrder = $this->getRequest()->getPost();
      foreach ($deleteOrder as $key => $order) {
        if ($key == 'delete_' . $order) {
         if($order)
          Engine_Api::_()->getItem('courses_order', $order)->delete();
        }
      }
    }
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    if(isset($_POST['searchParams']) && $_POST['searchParams']){
      parse_str($_POST['searchParams'], $searchArray);
    }
    $this->view->searchForm = $searchForm = new Courses_Form_Searchorder();
    $value['order_id'] = isset($searchArray['order_id']) ? $searchArray['order_id'] : '';
    $value['buyer_name'] = isset($searchArray['buyer_name']) ? $searchArray['buyer_name'] : '';
    $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
    $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
    $value['order_min'] = isset($searchArray['order']['order_min']) ? $searchArray['order']['order_min'] : '';
    $value['order_max'] = isset($searchArray['order']['order_max']) ? $searchArray['order']['order_max'] : '';
    $value['commision_min'] = isset($searchArray['commision']['commision_min']) ? $searchArray['commision']['commision_min'] : '';
    $value['commision_max'] = isset($searchArray['commision']['commision_max']) ? $searchArray['commision']['commision_max'] : '';
    $value['gateway'] = isset($searchArray['gateway']) ? $searchArray['gateway'] : '';
    $value['user_id'] = $viewer_id;
    $this->view->orders = $orders = Engine_Api::_()->getDbtable('orders', 'courses')->manageOrders($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }
  public function myTestsAction()
{
   $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
      $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      if($this->_getParam('is_ajax',null) && $this->_getParam('usertest_id',null))
        {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
           $counter = $this->_getParam('data_count');
           $userTest =  Engine_Api::_()->getItem('courses_usertest', $this->_getParam('usertest_id'));
            Engine_Api::_()->courses()->deleteUserTest($userTest);
            $db->commit();
            echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Test found.', '%s Tests found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
         echo json_encode(array('status'=>0));die;
     }
    if ($this->getRequest()->isPost()) {
      $deleteTest = $this->getRequest()->getPost();
      foreach ($deleteTest as $key => $test) {
        if ($key == 'delete_' . $test) {
         if(!$test)
          continue;
            $userTest = Engine_Api::_()->getItem('courses_usertest', $test);
            Engine_Api::_()->courses()->deleteUserTest($userTest);
        }
      }
    }
    $viewer = $this->view->viewer();
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    if(isset($_POST['searchParams']) && $_POST['searchParams']){
      parse_str($_POST['searchParams'], $searchArray);
    }
   $this->view->searchForm = $searchForm = new Courses_Form_Searchtest();
    $viewer = Engine_Api::_()->user()->getViewer();
    $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
    $value['is_passed'] = isset($searchArray['is_passed']) ? $searchArray['is_passed'] : '';
    $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
    $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
    $value['user_id'] = $viewer_id;
    $this->view->orders = $tests = Engine_Api::_()->getDbtable('usertests', 'courses')->manageTest($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($tests);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }
  
  public function myWishlistsAction()
  {
      $viewer = $this->view->viewer();
      $viewer_id = $viewer->getIdentity();
      if(!$this->_helper->requireUser()->isValid() ) return;
      $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
      $this->_helper->content->setEnabled();
      $this->view->formFilter = $formFilter = new Courses_Form_Admin_Wishlist();
      if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                $wishlist = Engine_Api::_()->getItem('courses_wishlist', $value);
                        $wishlist->delete();
                }
            }
        }
        if($this->_getParam('is_ajax',null) && $this->_getParam('wishlist_id'))
        {
            $counter = $this->_getParam('data_count');
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $order = Engine_Api::_()->getItem('courses_wishlist', $this->_getParam('wishlist_id'))->delete();
                $db->commit();
                echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Wishlist found.', '%s Wishlists found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            echo json_encode(array('status' => 0));die;
        }
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
        $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
        ), $values);

        if (isset($_POST['searchParams']) && $_POST['searchParams'])
            parse_str($_POST['searchParams'], $searchArray);
        $this->view->assign($values);
        $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
        $courseTable = Engine_Api::_()->getDbTable('wishlists', 'courses');
        $courseTableName = $courseTable->info('name');
        $select = $courseTable->select()
        ->setIntegrityCheck(false)
        ->from($courseTableName)
        ->where($courseTableName.'.owner_id = ?',$viewer_id)
        ->joinLeft($tableUserName, "$courseTableName.owner_id = $tableUserName.user_id", 'username')
        ->order((!empty($_GET['order']) ? $_GET['order'] : 'wishlist_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

        if (!empty($searchArray['name']))
            $select->where($courseTableName . '.title LIKE ?', '%' . $searchArray['name'] . '%');
        if (!empty($searchArray['owner_name']))
            $select->where($tableUserName . '.displayname LIKE ?', '%' . $searchArray['owner_name'] . '%');
        if (isset($searchArray['is_featured']) && $searchArray['is_featured'] != '')
            $select->where($courseTableName . '.is_featured = ?', $searchArray['is_featured']);
        if (isset($searchArray['is_sponsored']) && $searchArray['is_sponsored'] != '')
            $select->where($courseTableName . '.is_sponsored = ?', $searchArray['is_sponsored']);
        if (isset($searchArray['offtheday']) && $searchArray['offtheday'] != '')
            $select->where($courseTableName . '.offtheday = ?', $searchArray['offtheday']);
        if (isset($searchArray['rating']) && $searchArray['rating'] != '') {
            if ($searchArray['rating'] == 1):
                $select->where($courseTableName . '.rating <> ?', 0);
            elseif ($searchArray['rating'] == 0 && $searchArray['rating'] != ''):
                $select->where($courseTableName . '.rating = ?', $searchArray['rating']);
            endif;
        }
        if (!empty($searchArray['order_max']))
				$select->having("$courseTableName . '.creation_date <=?", $searchArray['order_max']);
        if (!empty($searchArray['order_min']))
          $select->having("$courseTableName . '.creation_date >=?", $searchArray['order_min']);
        if (isset($searchArray['subcat_id'])) {
                $formFilter->subcat_id->setValue($searchArray['subcat_id']);
                $this->view->category_id = $searchArray['category_id'];
        }
        if (isset($searchArray['subsubcat_id'])) {
                $formFilter->subsubcat_id->setValue($searchArray['subsubcat_id']);
                $this->view->subcat_id = $searchArray['subcat_id'];
        }
        $urlParams = array();
        foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
        if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
            continue;
            $urlParams['query'][$urlParamsKey] = $urlParamsVal;
        }
        $this->view->urlParams = $urlParams;
        $paginator = Zend_Paginator::factory($select);
        $this->view->paginator = $paginator;
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  public function deleteWishlistAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $wishlist_id = $this->_getParam('wishlist_id');
    $this->view->wishlist_id = $wishlist_id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $courses = Engine_Api::_()->getItem('courses_wishlist', $wishlist_id);
        Engine_Api::_()->courses()->deleteCourse($courses);
        $db->commit();
      }
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('manage/delete.tpl');
  }
  public function classroomReviewsAction()
  {
    $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
     if(!$this->_helper->requireUser()->isValid() ) return;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->reviewFormFilter = $reviewFormFilter = new Eclassroom_Form_Admin_Review_Filter();
    $reviewFormFilter->removeElement('course_title');
    //Process form
    $values = array();
    if ($reviewFormFilter->isValid($this->_getAllParams())) {
      $values = $reviewFormFilter->getValues();
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
          $video = Engine_Api::_()->getItem('eclassroom_review', $value)->delete();
        }
      }
    }
    if($this->_getParam('is_ajax',null) && $this->_getParam('review_id'))
    {
        $counter = $this->_getParam('data_count');
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
           Engine_Api::_()->getItem('eclassroom_review', $this->_getParam('review_id'))->delete();
            $db->commit();
             echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Review found.', '%s Reviews found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
         echo json_encode(array('status'=>0));die;
    }
    if (isset($_GET['searchParams']) && $_GET['searchParams'])
            parse_str($_GET['searchParams'], $searchArray);

    $classroomTable = Engine_Api::_()->getDbTable('classrooms', 'eclassroom');
    $classroomTableName = $classroomTable->info('name');
    $table = Engine_Api::_()->getDbtable('reviews', 'eclassroom');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->where($tableName.'.owner_id = ?',$viewer_id)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
            ->joinLeft($classroomTableName, "$classroomTableName.classroom_id = $tableName.classroom_id",array('classroom_id'))
            ->order($tableName.'.review_id DESC');
    if (!empty($searchArray['title']))
        $select->where($tableName . '.title LIKE ?', '%' . $searchArray['title'] . '%');
    if (!empty($searchArray['rating_star']))
        $select->where($tableName . '.rating  = ?',  $searchArray['rating_star']);
    if (!empty($searchArray['classroom_title']))
        $select->where($tableName . '.title LIKE ?', '%' . $searchArray['classroom_title'] . '%');
    if (!empty($searchArray['oftheday']))
      $select->where($tableName.'.offtheday LIKE ?', '%' . $searchArray['offtheday'] . '%');
    if (!empty($searchArray['featured']))
      $select->where($tableName.'.featured LIKE ?', '%' . $searchArray['featured'] . '%');
    if (!empty($searchArray['verified']))
      $select->where($tableName.'.verified = ?',  $searchArray['verified']);
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);

  }
  public function courseReviewsAction()
  {
     $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
     $viewer_id = $viewer->getIdentity();
     if(!$this->_helper->requireUser()->isValid() ) return;
     $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->reviewFormFilter = $reviewFormFilter = new Eclassroom_Form_Admin_Review_Filter();
    $reviewFormFilter->removeElement('classroom_title');
    //Process form
    $values = array();
    if ($reviewFormFilter->isValid($this->_getAllParams())) {
      $values = $reviewFormFilter->getValues();
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
          $review = Engine_Api::_()->getItem('courses_review', $value)->delete();
        }
      }
    }
    if($this->_getParam('is_ajax',null) && $this->_getParam('review_id'))
    {
        $counter = $this->_getParam('data_count');
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->getItem('courses_review', $this->_getParam('review_id'))->delete();
            $db->commit();
            echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Review found.', '%s Reviews found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        echo json_encode(array('status' => 0));die;
    }
    if (isset($_GET['searchParams']) && $_GET['searchParams'])
      parse_str($_GET['searchParams'], $searchArray);
    $courseTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $courseTableName = $courseTable->info('name');
    $table = Engine_Api::_()->getDbtable('reviews', 'courses');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->where($tableName.'.owner_id = ?',$viewer_id)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
            ->joinLeft($courseTableName, "$courseTableName.course_id = $tableName.course_id",array('course_id'))
            ->order($tableName.'.review_id DESC');
    if (!empty($searchArray['title']))
      $select->where($tableName . '.title LIKE ?', '%' . $searchArray['title'] . '%');
    if (!empty($searchArray['rating_star']))
        $select->where($tableName . '.rating  = ?',  $searchArray['rating_star']);
    if (!empty($searchArray['course_title']))
      $select->where($courseTableName . '.title LIKE ?', '%' . $searchArray['course_title'] . '%');
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }
    public function deleteReviewAction() {

    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Review');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $review = Engine_Api::_()->getItem('couses_review', $this->_getParam('review_id'));
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

}
