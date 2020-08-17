<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: print-result.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php //if($this->format == 'smoothbox' && empty($_GET['order'])){ ?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Courses/externals/styles/print.css" rel="stylesheet" media="print" type="text/css" />
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/print.css'); ?>
<?php //} ?>
 <?php  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_test_result sesbasic_bxs sesbasic_clearfix">
  <div class="courses_test_result_inner">
    <h3 class="courses_test_result_head"><?php echo $this->translate('TEST RESULT'); ?></h3>
    <div class="courses_test_result_header">
      <span class="_name"><?php echo $this->test->getTitle(); ?></span>
      <?php  $totalquestion = Engine_Api::_()->getDbTable('testquestions', 'courses')->countQuestions($this->test->test_id); ?>
      <span><?php echo $this->translate(array('Total Question: %s', 'Total Questions: %s', $totalquestion), $this->locale()->toNumber($totalquestion)); ?></span>
    </div>
    <div class="courses_test_result_body" id="test-result_<?php echo $randonNumber; ?>">
    <?php $counter = 1; $class="";?>
    <?php foreach($this->paginator as $question): ?>
      <?php $isTrue = $question->is_true ? 'application/modules/Courses/externals/images/tick.png':'application/modules/Courses/externals/images/cross.png'; ?>
      <?php if(!$question->is_attempt): ?>
        <?php $class = "border"; ?>
      <?php endif; ?>
      <?php $testquestion = Engine_Api::_()->getItem('courses_testquestion',$question->testquestion_id); ?>
        <div class="courses_test_result_box <?php echo $class; ?>">
          <div class="courses_test_result_ques">
            <span class="ques_num"><?php echo $this->translate('Q %s',$counter); ?></span><?php echo $testquestion->question; ?>
          </div>
          <div class="courses_test_result_answer sesbasic_text_light">
            <?php if(is_array(json_decode($question->testanswers,true))): ?>
              <?php $providedAnswers = Engine_Api::_()->getItemMulti('courses_testanswer',json_decode($question->testanswers,true)); ?>
              <?php if(!empty($providedAnswers)): ?>
                <?php foreach($providedAnswers as $providedAnswer):  ?>
                  <div class="_ans"><?php echo $providedAnswer->answer; ?><img src="<?php echo (in_array($providedAnswer->testanswer_id,json_decode($question->testanswers,true)) && $providedAnswer->is_true) ? 'application/modules/Courses/externals/images/tick.png' : 'application/modules/Courses/externals/images/cross.png'; ?>" /></div>
                <?php endforeach;  ?>
              <?php endif; ?>
            <?php elseif(is_numeric(json_decode($question->testanswers,true))): ?>
              <?php $providedAnswers = Engine_Api::_()->getItem('courses_testanswer',json_decode($question->testanswers,true)); ?>
                <div class="_ans"><?php echo $providedAnswer->answer; ?><img src="<?php echo $isTrue; ?>" /></div>
            <?php endif; ?>
            <?php  $currectAnswers = Engine_Api::_()->getDbTable('testanswers', 'courses')->getAnswersPaginator(array('testquestion_id'=>$question->testquestion_id,'is_true'=>true)); ?>
              <?php foreach($currectAnswers as $currectAnswer):  ?>
                <div class="correct_ans"><?php echo $this->translate('Correct Answer is :'); ?> <?php echo $currectAnswer->answer; ?></div>
              <?php endforeach;  ?>
          </div>
        </div>
    <?php $counter++; endforeach;  ?>
  </div>
    <?php $attemptQuestionCount = Engine_Api::_()->courses()->getIsUserTestDetails(array('usertest_id'=>$this->usertest_id,'test_id'=>$this->test->test_id,'currect_answer'=>true));?>
    <div class="courses_total_Score"><?php echo $this->translate('Answered %s Out of %s Correctly',($attemptQuestionCount),$totalquestion); ?></div>
    <div class="courses_pass_fail">
      <?php if($this->usertest->is_passed): ?>
        <div><?php echo $this->test->success_message; ?></div>
        <span class="passed"> <img src="application/modules/Courses/externals/images/passed.png" /><?php echo $this->translate('PASSED'); ?> </span>
      <?php else: ?>
        <div><?php echo $this->test->failure_message; ?></div>
        <span class="failed"><img src="application/modules/Courses/externals/images/failed.png" /><?php echo $this->translate('FAILED'); ?> </span>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php if(empty($_GET['order'])){ ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
    window.print();
});
</script>
<?php } ?>
