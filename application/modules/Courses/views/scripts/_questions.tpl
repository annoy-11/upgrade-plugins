<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _questions.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<div id="dashboard_test_question_<?php echo $this->question->testquestion_id; ?>">
  <div class="dashboard_test_question">
    <div class="_ques"><?php echo $this->question->question; ?> </div>
    <div class="_data"> <a href="<?php echo $this->url(array('question_id' => $this->question->testquestion_id,'action'=>'add-answer'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button dashboard_test_add_answer_<?php echo $this->question->testquestion_id; ?>"><i class="fa fa-plus"></i> <?php echo $this->translate("Add Answer");?></a> <a href="<?php echo $this->url(array('question_id' => $this->question->testquestion_id,'action'=>'edit-question'), 'tests_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-pencil"></i></a> <a href="javascript:;" data-url="<?php echo $this->url(array('question_id' => $this->question->testquestion_id,'action'=>'delete-question'), 'tests_general', true); ?>" data-id="<?php echo $this->question->testquestion_id; ?>" data-type="question" class="sesbasic_button delete-test-item"><i class="fa fa-trash-o"></i></a> </div>
  </div>
</div>
