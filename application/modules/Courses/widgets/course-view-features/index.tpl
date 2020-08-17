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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>

<div class="courses_view_features sesbasic_bxs sesbasic_clearfix">
  <ul class="courses_features">
    <?php if(isset($this->duration)):?>
      <li class="feature_item">
        <span class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
        <span class="label"><?php echo $this->translate('Duration'); ?></span><span class="item-value"><?php echo date('H:i:s',$this->course->getDuration()->duration); ?></span>
      </li>
    <?php endif;?>
    <?php if(isset($this->lectures)):?>
      <li class="feature_item">
        <span class="icon"><i class="fa fa-bell-o" aria-hidden="true"></i></span>
        <span class="label"><?php echo $this->translate('Lectures'); ?></span><span class="item-value"><?php echo $this->course->lecture_count; ?></span>
      </li>
    <?php endif;?>
    <?php if(isset($this->tests)):?>
      <li class="feature_item">
        <span class="icon"><i class="fa fa-list" aria-hidden="true"></i></span>
        <span class="label"><?php echo $this->translate('Tests'); ?></span><span class="item-value"><?php echo $this->course->test_count; ?></span>
      </li>
    <?php endif;?>
     <?php if(isset($this->passparcentage)):?>
      <li class="feature_item">
        <span class="icon"><i class="fa fa-check" aria-hidden="true"></i></span>
        <span class="label"><?php echo $this->translate('Pass Percentage'); ?></span><span class="item-value"><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.ptest.pass', 1); ?></span>
      </li>
    <?php endif;?>
  <!--   <li class="feature_item">
      <span class="icon"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
      <span class="label"><?php //echo $this->translate('Test Attempts'); ?></span><span class="item-value">3</span>
    </li>-->
  </ul>
</div>
