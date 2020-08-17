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
<div class="sesbasic_breadcrumb">
    <a href="<?php echo $this->url(array('action' => 'browse'), 'courses_general'); ?>"><?php echo $this->translate("Browse Courses");?></a>&nbsp;&raquo;
  <?php  if($this->subject->getType() == 'courses_lecture'): ?>
    <?php $course = Engine_Api::_()->getItem('courses',$this->subject->course_id); ?>
      <?php if($course): ?>
        <a href="<?php echo $course->getHref(); ?>"><?php echo $course->getTitle(); ?></a>&nbsp;&raquo;
      <?php endif; ?>
    <?php if($this->subject): ?>
      <a href="<?php echo $this->subject->getHref(); ?>"><?php echo $this->subject->getTitle(); ?></a>&nbsp;&raquo;
    <?php endif; ?>
  <?php endif; ?>
</div>
