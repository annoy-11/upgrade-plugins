<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: TestController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_TestController extends Core_Controller_Action_Standard
{
  public function createAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'test_create')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $viewer = $this->view->viewer();
    //$this->_helper->content->setEnabled();
    $this->view->courseId = $courseId = $this->_getParam('course_id',false);
    $course = Engine_Api::_()->getItem('courses', $courseId);
    $totalTests = Engine_Api::_()->getDbTable('tests', 'courses')->countTests($viewer->getIdentity());
    $allowTestCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'test_count');
    $this->view->createLimit = 1;
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      // Render
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
    }  else { 
      $this->_helper->content->setEnabled();
    }
    if ($totalTests >= $allowTestCount && $allowTestCount != 0) {
      $this->view->createLimit = 0;
    } else {
         $this->view->form = $form = new Courses_Form_Test_Create();
    }
    if (!$this->getRequest()->isPost()) {
       return;
    }
    $values = $form->getValues();
    $values = $_POST;
    $testTable = Engine_Api::_()->getDbTable('tests', 'courses');
    $db = $testTable->getAdapter();
    $db->beginTransaction();
    try {
        $test = $testTable->createRow();
        $viewer = Engine_Api::_()->user()->getViewer();
        if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
            $test->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,'courses','courses','',$test,true);
        }
        $test->course_id = $course->course_id;
        $test->save();
        $values['description'] = Engine_Text_BBCode::prepare($values['description']);
        $values['success_message'] = Engine_Text_BBCode::prepare($values['success_message']);
        $values['failure_message'] = Engine_Text_BBCode::prepare($values['failure_message']);
        $values['question'] = Engine_Text_BBCode::prepare($values['question']); 
        $values['owner_id'] = $viewer->getIdentity();
        $test->setFromArray($values);
        $test->save();
        $course->test_count++;
        $course->save();
        $db->commit();
        $users = Engine_Api::_()->getDbtable('ordercourses', 'courses')->getCoursePurchasedMember($course->course_id);
        $courseTitle = '<a href="'.$course->getHref().'">'.$course->getTitle().'</a>';
        foreach($users as $user){
          $user = Engine_Api::_()->getItem('user', $user->user_id);
          Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $course, 'courses_test_create',array('testTitle'=>$test->getTitle()));
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'courses_test_create', array('course_name' => $courseTitle, 'test_title' => $test->getTitle(),'object_link' => $course->getHref(), 'host' => $_SERVER['HTTP_HOST']));
           //Activity Feed work
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $course, "courses_test_create", null, array('testTitle' => array($test->getTitle())));
          if ($action) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $course);
          }
        }
        return $this->_helper->redirector->gotoRoute(array('course_id' => $course->custom_url,'action'=>'manage-tests'), 'courses_dashboard', true);

    }catch(Exception $e){
      $db->rollBack();
      throw $e;
    }
  }
  public function editAction() {
    if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'test_edit')->isValid())
        return;
    if (!$this->_helper->requireUser->isValid())
        return;
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      // Render
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
    }
    $testId = $this->_getParam('test_id',false);
    $this->view->test = $test = Engine_Api::_()->getItem('courses_test', $testId);
    $storagePath = Engine_Api::_()->storage()->get($test->photo_id, '');
    $this->view->img_path = 0;
    if(!empty($storagePath)) {
      $this->view->img_path = 1;
    }
    $course = Engine_Api::_()->getItem('courses', $test->course_id);
    $this->view->form = $form = new Courses_Form_Test_Edit();
    $form->populate($test->toArray());
    if (!$this->getRequest()->isPost()) {
        return;
    }
    $values = $form->getValues();
    $values = $_POST;
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
        if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
            $test->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,'courses','courses','',$test,true);
        }
        $test->save();
        $values['description'] = Engine_Text_BBCode::prepare($values['description']);
        $values['success_message'] = Engine_Text_BBCode::prepare($values['success_message']);
        $values['failure_message'] = Engine_Text_BBCode::prepare($values['failure_message']);
        $values['question'] = Engine_Text_BBCode::prepare($values['question']);
        $test->setFromArray($values);
        $test->save();
        $db->commit();
        return $this->_helper->redirector->gotoRoute(array('course_id' => $course->custom_url,'action'=>'manage-tests'), 'courses_dashboard', true);
    }catch(Exception $e){
      $db->rollBack();
      throw $e;
    }
  }
  public function addQuestionAction() {
    $this->view->test_id = $testId = $this->_getParam('test_id',false);
    $test = Engine_Api::_()->getItem('courses_test', $testId);
    $course = Engine_Api::_()->getItem('courses', $test->course_id);
    $this->view->form = $form = new Courses_Form_Test_Addquestion();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
        return;
    $questionTable = Engine_Api::_()->getDbTable('testquestions', 'courses');
    $db = $questionTable->getAdapter();
    $db->beginTransaction();
    try {
      $question = $questionTable->createRow();
      $question->setFromArray(array_merge(array(
          'test_id' => $testId,
          'course_id'=>$test->course_id), $form->getValues()));
      $test->total_questions++;
      $test->save();
      $question->save();
      $db->commit();
      // Redirect
      $showData = $this->view->partial('_questions.tpl', 'courses', array('question' => $question, 'test_id' => $test->test_id, 'is_ajax' => true));
      echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
      exit();
    } catch (Exception $e) {
    $db->rollBack();
    }
  }
  public function editQuestionAction() {
    $this->view->question_id = $questionId = $this->_getParam('question_id',false);
    $question = Engine_Api::_()->getItem('courses_testquestion', $questionId);
    $this->view->test_id = $question->test_id;
    $this->view->form = $form = new Courses_Form_Test_Editquestion(array('isEdit'=>1));
    $form->populate($question->toArray());
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
        return;
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
        $question->setFromArray($form->getValues());
        $question->save();
        $db->commit();
        // Redirect
        echo Zend_Json::encode(array('status' => 1, 'message' => '','title'=>$question->question));
        exit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
  public function deleteQuestionAction() {
      $questionId = $this->_getParam('question_id',false);
      $question = Engine_Api::_()->getItem('courses_testquestion', $questionId);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          $test = Engine_Api::_()->getItem('courses_test', $question->test_id);
          $test->total_questions--;
          $test->save();
          $question->delete();
          $db->commit();
          echo Zend_Json::encode(array('status' => 1, 'error' => false));
          exit();
      } catch (Exception $e) {
      $db->rollBack();
      }
  }
  public function deleteAnswerAction() {
      $answerId = $this->_getParam('answer_id',false); 
      $answer = Engine_Api::_()->getItem('courses_testanswer', $answerId);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          $question = Engine_Api::_()->getItem('courses_testquestion', $answer->testquestion_id);
          $question->total_options--;
          $question->save();
          $answer->delete();
          $db->commit();
          echo Zend_Json::encode(array('status' => 1, 'error' => false));
          exit();
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
  public function deleteTestAction() {
      $testId = $this->_getParam('test_id',false);
      $test = Engine_Api::_()->getItem('courses_test', $testId);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
          $course = Engine_Api::_()->getItem('courses', $test->course_id);
          $course->test_count--;
          $course->save();
          $test->is_delete = 1;
          $test->save();
          $db->commit();
          echo Zend_Json::encode(array('status' => 1, 'error' => false));
          exit();
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
  public function addAnswerAction() {
      $this->view->question_id = $questionId = $this->_getParam('question_id',false);
      $question = Engine_Api::_()->getItem('courses_testquestion', $questionId);
      $course = Engine_Api::_()->getItem('courses', $question->course_id);
      $this->view->form = $form = new Courses_Form_Test_AddAnswer(array('question'=>$question));
      if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
          return;
      $answerTable = Engine_Api::_()->getDbTable('testanswers', 'courses');
      $db = $answerTable->getAdapter();
      $db->beginTransaction();
      try {
      $answers = Engine_Api::_()->getDbTable('testanswers', 'courses')->getAnswersSelect(array('testquestion_id'=>$question->testquestion_id,'fetchAll'=>true));
      if(($question->answer_type == 1) && count($answers) > 0):
        echo Zend_Json::encode(array('status' => 2, 'message' => ''));
        exit();
      endif;
      $answerTable = $answerTable->createRow();
      $answerTable->setFromArray(array_merge(array(
          'test_id' => $question->test_id,'course_id'=>$question->course_id,'testquestion_id'=>$question->testquestion_id), $form->getValues()));
      $question->total_options++;
      $question->save();
      $answerTable->save();
      $db->commit();
      $class = $answerTable->is_true ? "is_true" : "";
      // Redirect
      $showData = '<div class="dashboard_test_answer '.$class.'" id="dashboard_test_answer_'.$answerTable->testanswer_id.'">
                      <div class="_ans">'.$answerTable->answer.'</div>
                      <div class="_data"> <a href="'.$this->view->url(array('answer_id' => $answerTable->testanswer_id,'action'=>'edit-answer'), 'tests_general', true).'" class="sessmoothbox sesbasic_button"><i class="fa fa-pencil"></i></a> <a href="javascript:;" data-url="'.$this->view->url(array('answer_id' => $answerTable->testanswer_id,'action'=>'delete-answer'), 'tests_general', true).'" data-id="'.$answerTable->testanswer_id.'" data-type="answer" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> </div>
                  </div>';
      echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
      exit();
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
  public function editAnswerAction() {
    $this->view->answer_id = $answerId = $this->_getParam('answer_id',false);
    $answer = Engine_Api::_()->getItem('courses_testanswer', $answerId);
    $question = Engine_Api::_()->getItem('courses_testquestion', $answer->testquestion_id);
    $this->view->form = $form = new Courses_Form_Test_EditAnswer(array('question'=>$question,'isTrue'=> $answer->is_true));
    $form->populate($answer->toArray());
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
        return;
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
        $answer->setFromArray($form->getValues());
        $answer->save();
        $db->commit();
        // Redirect
        $showData = '<div class="_ans">'.$answer->answer.'</div>
                    <div class="_data"> <a href="'.$this->view->url(array('answer_id' => $answer->testanswer_id,'action'=>'edit-answer'), 'tests_general', true).'" class="sessmoothbox sesbasic_button '.$class.'"><i class="fa fa-pencil"></i></a> <a href="javascript:;" data-url="'.$this->view->url(array('question_id' => $answer->testanswer_id,'action'=>'delete-answer'), 'tests_general', true).'" data-id="'.$answer->testanswer_id.'" data-type="answer" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> </div>';
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData,'is_true'=>$answer->is_true));
        exit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
  public function viewAction() { 
    $testId = $this->_getParam('test_id',false);
    $test = Engine_Api::_()->getItem('courses_test', $testId);
    if(empty($test))
      return false;
    Engine_Api::_()->core()->setSubject($test);
    $this->_helper->content->setEnabled();
  }
  public function resultAction() {
    $testId = $this->_getParam('test_id',false);
    $usertestId = $this->_getParam('usertest_id',false);
    $test = Engine_Api::_()->getItem('courses_test', $testId);
    if(empty($test))
      return false;
    Engine_Api::_()->core()->setSubject($test);
    $this->_helper->content->setEnabled();
  }
  public function printResultAction() {
    $value['test_id'] = $test_id = $this->getParam('test_id', $_POST['test_id']);
    $this->view->usertest_id = $value['usertest_id'] = $usertest_id = $this->getParam('usertest_id', $_POST['usertest_id']);
    $this->view->test = Engine_Api::_()->getItem('courses_test', $value['test_id']);
     $this->view->usertest = Engine_Api::_()->getItem('courses_usertest',$value['usertest_id']);
    $value['fetchAll'] = true;
    $paginator = Engine_Api::_()->getDbTable('usertests', 'courses')->getUserTestSelect($value);
    $this->view->paginator = $paginator;
  }
}
