<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: show-detail.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="eclassroom_view_stats_popup">
  <div class="eclassroom_view_popup_con">
    <?php $classroomItem = Engine_Api::_()->getItem('classroom', $this->claimItem->classroom_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="eclassroom_popup_img_classroom">
      <p class="popup_img"><?php echo $this->itemPhoto($classroomItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $classroomItem->getTitle();?></p>
    	<p class="owner_title"><b>Classroom Owner :</b><span class="owner_des"><?php echo $classroomItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="eclassroom_popup_owner_classroom">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
