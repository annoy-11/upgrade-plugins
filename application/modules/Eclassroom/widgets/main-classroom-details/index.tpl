<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $classroom = $this->classroom;?>
<?php $viewer = $this->viewer();?>
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs eclassroom_linked_classrooms_block">
	<div class="sesbasic_sidebar_list">
    <?php if(isset($this->classroomPhotoActive)):?>
      <div class="_thumb">
        <img src="<?php echo $classroom->getPhotoUrl('thumb.icon') ?>" class="thumb_icon" alt="" />
      </div>
    <?php endif;?>
    <div class="sesbasic_sidebar_list_info">
      <?php if(isset($this->titleActive)):?>
        <div class="sesbasic_sidebar_list_title">
          <?php echo $classroom->title; ?>
        </div>
      <?php endif; ?>
      <div class="_itembtns">
      	<?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        	<?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataButtons.tpl';?>
      	<?php endif;?>
        <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
        <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'eclassroom', 'bs_can_join');?>
        <?php if($canJoin && isset($this->joinButtonActive)):?>
          <?php if($viewerId):?>
            <?php $row = $classroom->membership()->getRow($viewer);?>
            <?php if(null === $row):?>
              <?php if($classroom->membership()->isResourceApprovalRequired()):?>
                <?php $action = 'request';?>
              <?php else:?>
                <?php $action = 'join';?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'classroom_id' => $classroom->classroom_id),'eclassroom_extended',true);?>" class="smoothbox eclassroom_button eclassroom_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
            <?php else:?>
              <?php if($row->active):?>
                <a href="javascript:void(0);" class="eclassroom_button eclassroom_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
              <?php else:?>
                <a href="javascript:void(0);" id="eclassroom_user_approval" class="eclassroom_button eclassroom_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
              <?php endif;?>
            <?php endif;?>
          <?php else:?>
            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" id="eclassroom_user_approval" class="smoothbox eclassroom_button eclassroom_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
