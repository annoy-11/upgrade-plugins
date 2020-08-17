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
<?php $height = $this->height;?>
<?php $width = $this->width;?>

<div class="courses_course_of_the_day">
    <ul class="courses_courses_listing sesbasic_bxs">
        <?php $limit = 0;?>
        <?php  $course = Engine_Api::_()->getItem('courses',$this->course_id);?>
        <?php if($course):?>
            <?php if (!empty($course->category_id)): ?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'courses')->find($course->category_id)->current();?>
            <?php endif;?> 
          <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/courses-views/_gridView.tpl';?>
        <?php endif;?>
        <?php $limit++;?>
    </ul>
</div>
