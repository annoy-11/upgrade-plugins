<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataButtons.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
  return;
?>
<?php if($course->is_approved):  ?>
<?php $canComment = Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'create');?>
  <?php if(isset($this->likeButtonActive) && $canComment && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.like', 1)): ?>
    <?php $likeStatus = Engine_Api::_()->courses()->getLikeStatus($course->course_id,$course->getType()); ?>
      <a href="javascript:;" data-type="courses_like_view" data-url="<?php echo $course->course_id; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn courses_like_<?php echo $course->course_id; ?> courses_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $course->like_count;?></span></a>
  <?php endif;  ?>
  <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.favourite', 1)):?>
    <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'courses')->isFavourite(array('resource_id' => $course->course_id,'resource_type' => $course->getType())); ?>
      <a href="javascript:;" data-type="courses_favourite_view" data-url="<?php echo $course->course_id; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn <?php echo ($favouriteStatus) ? 'button_active' : ''; ?> courses_favourite_<?php echo $course->course_id; ?> courses_likefavfollow"><i class="fa fa-heart"></i><span><?php echo $course->favourite_count;?></span></a>
  <?php endif; ?>
<?php endif; ?>
  
