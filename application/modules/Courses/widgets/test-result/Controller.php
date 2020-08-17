<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Widget_TestResultController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  { 
    $ids = Zend_Controller_Front::getInstance()->getRequest();
    $value['test_id'] = $test_id = $ids->getParam('test_id', $_POST['test_id']);
    $this->view->usertest_id = $value['usertest_id'] = $usertest_id = $ids->getParam('usertest_id', $_POST['usertest_id']);
     $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->limit_data = $limit_data = $this->_getParam('limit_data',1);
    $this->view->test = Engine_Api::_()->getItem('courses_test', $value['test_id']);
    $this->view->usertest = Engine_Api::_()->getItem('courses_usertest', $value['usertest_id']);
    $paginator = Engine_Api::_()->getDbTable('usertests', 'courses')->getUserTestPaginator($value);
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $this->view->widgetName = "test-result";
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
    else {
      // Do not render if nothing to show
      if ($paginator->getTotalItemCount() <= 0) {
        return $this->setNoRender();
      }
    }
  }
}
