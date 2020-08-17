<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: show-detail.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="courses_view_stats_popup">
  <div class="courses_view_popup_con">
    <?php $courseItem = Engine_Api::_()->getItem('courses', $this->claimItem->course_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="courses_popup_img_course">
      <p class="popup_img"><?php echo $this->itemPhoto($courseItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $courseItem->getTitle();?></p>
    	<p class="owner_title"><b>Store Owner :</b><span class="owner_des"><?php echo $courseItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="courses_popup_owner_course">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
