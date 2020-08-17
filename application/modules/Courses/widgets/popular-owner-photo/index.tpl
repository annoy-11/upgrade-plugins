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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>

<?php foreach( $this->paginator as $course): ?>
<?php 
  $item = Engine_Api::_()->getItem('user', $course->owner_id);
  if(empty($item))
    continue;
  $href = $item->getHref();

?>
<ul class="courses_top_instructors">
<?php if($this->view_type == 'list'): ?>
  <li class="courses_top_instructors_list sesbasic_sidebar_list sesbasic_clearfix clear">
    <?php echo $this->htmlLink($item, $this->itemPhoto($item, 'thumb.icon')); ?>
    <div class="sesbasic_sidebar_list_info">
      <?php  if(isset($this->byActive)){ ?>
        <div class="sesbasic_sidebar_list_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_list){
          $title = mb_substr($item->getTitle(),0,($this->title_truncation_list - 3)).'...';
	          echo $this->htmlLink($href,$title );
          } else { ?>
          <?php echo $this->htmlLink($href,$item->getTitle() ) ?>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="courses_list_stats">
        <?php if(isset($this->courseCountActive) && isset($course->total_courses)) {  ?>
	        <span title="<?php echo $this->translate(array('%s Total Course', '%s Total Courses', $course->total_courses), $this->locale()->toNumber($course->total_courses))?>"><i class="fa fa-book sesbasic_text_light"></i><?php echo $course->total_courses; ?></span>
        <?php } ?> 
        <?php if(isset($this->testCountActive) && isset($course->total_tests)) { ?>
        <span title="<?php echo $this->translate(array('%s Total test', '%s Total tests', $course->total_tests), $this->locale()->toNumber($course->total_tests))?>"><i class="fa fa-list sesbasic_text_light"></i><?php echo $course->total_tests; ?></span>
        <?php } ?>
        <?php if(isset($this->lectureCountActive) && isset($course->total_lectures)) { ?>
        <span title="<?php echo $this->translate(array('%s Total Lecture', '%s Total Lectures', $course->total_lectures), $this->locale()->toNumber($course->total_lectures))?>"><i class="fa fa-bell sesbasic_text_light"></i><?php echo $course->total_lectures; ?></span>
        <?php } ?>
      </div>
    </div>
  </li>
<?php else: ?>
	<li class="courses_host_list courses_grid_btns_wrap sesbasic_clearfix <?php if($this->contentInsideOutside == 'in'): ?> courses_host_list_in <?php else: ?> courses_host_list_out <?php endif; ?> <?php if($this->mouseOver): ?> sesae-i-over <?php endif; ?>" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
    <div class="courses_host_list_thumb">
      <?php
      $href = $href;
      $imageURL = $item->getPhotoUrl('thumb.main');
      ?>
      <a href="<?php echo $href; ?>" class="courses_host_list_thumb_img">
        <span style="background-image:url(<?php echo $imageURL; ?>);height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"></span>
      </a>
    </div>
    <div class="courses_host_list_info sesbasic_clearfix">
      <?php if(isset($this->byActive) ){ ?>
	      <div class="courses_host_list_name">
	        <?php if(strlen($item->getTitle()) > $this->title_truncation_grid) {
		        $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid - 3)).'...';
		        echo $this->htmlLink($href,$title ) ?>
	        <?php } else { ?>
		        <?php echo $this->htmlLink($href,$item->getTitle() ) ?>
	        <?php } ?>
	      </div>
      <?php } ?>
      <div class="courses_host_list_stats courses_list_stats">
         <?php if(isset($this->courseCountActive) && isset($course->total_courses)) {  ?>
	        <span title="<?php echo $this->translate(array('%s Total Course', '%s Total Courses', $course->total_courses), $this->locale()->toNumber($course->total_courses))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $course->total_courses; ?></span>
        <?php } ?> 
        <?php if(isset($this->testCountActive) && isset($course->total_tests)) {  ?>
	        <span title="<?php echo $this->translate(array('%s Total test', '%s Total tests', $course->total_tests), $this->locale()->toNumber($course->total_tests))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $course->total_tests; ?></span>
        <?php } ?> 
        <?php if(isset($this->lectureCountActive) && isset($course->total_lectures)) { ?>
	        <span title="<?php echo $this->translate(array('%s Total Lecture', '%s Total Lectures', $course->total_lectures), $this->locale()->toNumber($course->total_lectures))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $course->total_lectures; ?></span>
        <?php } ?>
      </div>
    </div>
  </li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
