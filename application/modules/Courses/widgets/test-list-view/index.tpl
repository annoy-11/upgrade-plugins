<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_test_profile sesbasic_bxs sesbasic_clearfix">
  <div class="courses_test_profile_inner">
    <?php foreach($this->paginator as $test): ?>
      <div class="courses_test_list_box">
          <?php if($test->photo_id){ ?>
            <span class="_img"><img src="<?php echo $test->getPhotoUrl(); ?>" /></span>
          <?php } ?>
          <span class="_name"><?php if(!$test->photo_id){ ?><i class="fa fa-file-text-o"></i><?php } ?><?php echo $test->getTitle(); ?></span>
          <?php $testQuestionCount = Engine_Api::_()->getDbTable('testquestions', 'courses')->countQuestions($test->test_id); ?>
          <span class="_ques sesbasic_text_light"><i class="fa fa-list"></i><?php echo $this->translate(array('%s Question', '%s Questions', $testQuestionCount), $this->locale()->toNumber($testQuestionCount)) ?></span>
          <span class="_time sesbasic_text_light"><i class="fa fa-clock-o"></i><?php echo $this->translate(array('%s Min', '%s Min', $test->test_time), $this->locale()->toNumber($test->test_time)) ?></span>
          <?php if($this->isPurchesed){ ?>
            <span class="_btn"><a href="<?php echo $this->url(array('test_id' => $test->test_id,'action'=>'view'), 'tests_general', true); ?>"><?php echo $this->translate('Take Test  >>'); ?></a></span>
          <?php } ?>
      </div>
     <?php endforeach; ?>
  </div>
</div>
