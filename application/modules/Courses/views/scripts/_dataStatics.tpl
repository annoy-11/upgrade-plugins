<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataStatics.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php if(isset($this->likeActive)): ?>
<span class="sesbasic_text_light courses_like_count_<?php echo $course->course_id; ?>" title="<?php echo $this->translate(array('%s Like', '%s Likes', $course->like_count), $this->locale()->toNumber($course->like_count)) ?>"><i class="sesbasic_icon_like_o"></i><?php echo $course->like_count; ?></span>
 <?php endif;?>
 <?php if(isset($this->commentActive)):?>
<span class="sesbasic_text_light"  title="<?php echo $this->translate(array('%s Comment', '%s Comments', $course->comment_count), $this->locale()->toNumber($course->comment_count)) ?>"><i class="sesbasic_icon_comment_o"></i><?php echo $course->comment_count; ?></span>
<?php endif;?>
<?php if(isset($this->favouriteActive)):?>
<span class="sesbasic_text_light courses_favourite_count_<?php echo $course->course_id; ?>" title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $course->favourite_count), $this->locale()->toNumber($course->favourite_count)) ?>"><i class="sesbasic_icon_favourite_o"></i> <?php echo $course->favourite_count; ?></span>
<?php endif;?>
<?php if(isset($this->viewActive)):?>
<span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s View', '%s Views', $course->view_count), $this->locale()->toNumber($course->view_count)) ?>"><i class="sesbasic_icon_view"></i><?php echo $course->view_count; ?></span>
<?php endif;?>
<?php if(isset($this->lectureCountActive)):?>
<span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s Lecture', '%s Lectures', $course->lecture_count), $this->locale()->toNumber($course->lecture_count)) ?>"><i class="fa fa-bell-o"></i><?php echo $course->lecture_count; ?></span>
<?php endif;?>
<?php if(isset($this->testCountActive)):?>
<span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s Test', '%s Tests', $course->test_count), $this->locale()->toNumber($course->test_count)) ?>"><i class="fa fa-list"></i><?php echo $course->test_count; ?></span>
<?php endif;?>

           
