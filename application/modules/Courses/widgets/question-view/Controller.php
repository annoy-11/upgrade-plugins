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

class Courses_Widget_QuestionViewController extends Engine_Content_Widget_Abstract {
  public function indexAction() { 
    if (isset($_POST['formData']) && $_POST['formData'])
      parse_str($_POST['formData'], $formData);
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('test_id', false); 
    $id =  $id ? $id : $_POST['test_id'];
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->test = $test = Engine_Api::_()->getItem('courses_test', $id);
    else
      $this->view->test = $test = Engine_Api::_()->core()->getSubject();
    $this->view->ajax = $is_ajax = isset($_POST['is_ajax']) ? $_POST['is_ajax'] : 0;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->timeover = $timeover =  isset($_POST['timeover']) ? $_POST['timeover'] : false;
    $viewer = Engine_Api::_()->user()->getViewer(); 
    $viewer_id = $viewer->getIdentity();
    $usertestData = Engine_Api::_()->courses()->getUserTest();
    if(!isset($_SESSION['user_test'][$test->test_id]['start_time']) && empty($_SESSION['user_test'][$test->test_id]['start_time'])) {
      $course = Engine_Api::_()->getItem('courses',$test->course_id);
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($course->getOwner(), $viewer, $course, 'courses_test_given');
      $_SESSION['user_test'][$test->test_id]['start_time'] = date('Y-m-d H:i:s');
      $_SESSION['user_test'][$test->test_id]['user_id'] = $viewer_id;
      $_SESSION['user_test'][$test->test_id]['total_marks'] = 0;
      $_SESSION['user_test'][$test->test_id]['currect_answers'] = 0;
    }
    $addTime = $test->test_time == 1 ? "+".$test->test_time.'minute' : "+".$test->test_time.'minutes';
    $testEndTime = date('Y-m-d H:i:s',strtotime($addTime,strtotime($_SESSION['user_test'][$test->test_id]['start_time'])));
    $this->view->Timediff = $Timediff = round(abs(strtotime($testEndTime) - strtotime(date('Y-m-d H:i:s'))) / 60,2);
    $questionIds = explode(',',$_POST['questionIds']); 
    foreach($questionIds as $id):
      $is_attempt = 0;
      $is_true = 0;
      $question = Engine_Api::_()->getItem('courses_testquestion',$id);
      if($question->answer_type == 2){
        $name = 'radio_'.$question->testquestion_id;
      }else if($question->answer_type == 3){
        $name = 'checkbox_'.$question->testquestion_id;
      }else if($question->answer_type == 1){
        $name = 'isTrue_'.$question->testquestion_id;
      } else {
        $name = 'sortAnswer_'.$question->testquestion_id;
      }
      if(isset($formData[$name])) {
        $is_true = 0;
        $is_attempt = 1;
        $answers = array();
        if(is_array($formData[$name])) {
          foreach($formData[$name] as $ids):
            $testanswer = Engine_Api::_()->getItem('courses_testanswer',$ids);
            if($testanswer->is_true){
              $answers[] = $ids;
            }
          endforeach;
          if($answers == $formData[$name])
            $is_true = 1;
        } elseif($question->answer_type == 4){
          $is_true = 2;
        } else {
          $testanswer = Engine_Api::_()->getItem('courses_testanswer',$formData[$name]);
          if($testanswer->is_true){
            $is_true = 1; 
          } 
        }
      } 
      if($is_true){
        $_SESSION['user_test'][$test->test_id]['total_marks'] = $_SESSION['user_test'][$test->test_id]['total_marks'] + $question->marks;
        $_SESSION['user_test'][$test->test_id]['currect_answers'] = $_SESSION['user_test'][$test->test_id]['currect_answers'] + 1;
      } 
      $_SESSION['user_test']['questions'][$test->test_id][$question->testquestion_id] = array('is_attempt'=>$is_attempt,'is_true' => $is_true,'testanswers'=> $formData[$name]);
    endforeach; 
    if((isset($_POST['submit']) && $_POST['submit'] == 1) || $timeover){  
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $settings = Engine_Api::_()->getApi('settings', 'core'); 
        $passPercentage = is_numeric($settings->getSetting('courses.ptest.pass', 1)) ? $settings->getSetting('courses.ptest.pass', 1) : 1;
        $isPass = (($_SESSION['user_test'][$test->test_id]['currect_answers']/$test->total_questions)*100) > $passPercentage ? 1 : 0 ;
        Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_courses_usertests', array('test_id' => $test->test_id,'course_id' =>$test->course_id,'test_start' => $_SESSION['user_test'][$test->test_id]['start_time'],'test_end'=> date('Y-m-d H:i:s'),'is_passed'=>$isPass,'test_pass_percentage'=>$passPercentage,'user_id'=>$viewer_id,'total_marks'=>$_SESSION['user_test'][$test->test_id]['total_marks']));
        $this->view->usertest_id = $usertest_id = $db->lastInsertId();
      foreach($_SESSION['user_test']['questions'][$test->test_id] as $key=>$value):
        if(!$key)
          continue;
         Zend_Db_Table_Abstract::getDefaultAdapter()->insert('engine4_courses_userquestions', array('test_id' => $test->test_id,'course_id' =>$test->course_id,'testanswers' => json_encode($value['testanswers']),'user_id'=> $viewer_id,'is_true'=> $value['is_true'],'is_attempt'=>$value['is_attempt'],'testquestion_id'=> $key,'usertest_id'=>$usertest_id));
      endforeach;
      $db->commit(); 
      unset($_SESSION['user_test']);
      $course = Engine_Api::_()->getItem('courses',$test->course_id);
      $courseTitle = '<a href="'.$course->getHref().'">'.$course->getTitle().'</a>';
      $result = Engine_Api::_()->courses()->getIsUserTestDetails(array('usertest_id'=>$usertest_id,'test_id'=>$test->test_id,'is_passed'=>true));
      if($result){
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($course->getOwner(), $viewer, $course, 'courses_test_pass',array('course'=>$courseTitle));
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($course->getOwner(), 'courses_test_pass', array('course_title' => $course->getTitle(), 'test_title' => $test->getTitle(),'object_link' => $course->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } else {
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($course->getOwner(), $viewer, $course, 'courses_test_fail',array('course'=>$courseTitle));
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($course->getOwner(), 'courses_test_fail', array('course_title' => $course->getTitle(), 'test_title' => $test->getTitle(),'object_link' => $course->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      } 
      if($timeover){
        $url = $this->view->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'browse'), 'courses_general', false);
        echo '<span style="display:none">'.json_encode(array('url'=>$url,'status'=>1)).'</span>';die;
      } else {
        $url = $this->view->url(array('action' => 'result','usertest_id'=>$usertest_id,'test_id' => $test->test_id), 'tests_general', false);
       echo '<span style="display:none">'.json_encode(array('url'=>$url,'status'=>1)).'</span>';die;
      }
    }
    $limit_data = $this->_getParam('limit_data',1);
    $value['test_id'] = $test->test_id; 
    $paginator = Engine_Api::_()->getDbTable('testquestions', 'courses')->getQuestionsPaginator($value);
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
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
