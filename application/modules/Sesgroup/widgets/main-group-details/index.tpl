<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $group = $this->group;?>
<?php $viewer = $this->viewer();?>
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs sesgroup_linked_groups_block">
	<div class="sesbasic_sidebar_list">
    <?php if(isset($this->groupPhotoActive)):?>
      <div class="_thumb">
        <img src="<?php echo $group->getPhotoUrl('thumb.icon') ?>" class="thumb_icon" alt="" />
      </div>
    <?php endif;?>
    <div class="sesbasic_sidebar_list_info">
      <?php if(isset($this->titleActive)):?>
        <div class="sesbasic_sidebar_list_title">
          <?php echo $group->title; ?>
        </div>
      <?php endif; ?>
      <div class="_itembtns">
      	<?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        	<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?>
      	<?php endif;?>
        <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
        <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'sesgroup_group', 'group_can_join');?>
        <?php if($canJoin && isset($this->joinButtonActive)):?>
          <?php if($viewerId):?>
            <?php $row = $group->membership()->getRow($viewer);?>
            <?php if(null === $row):?>
              <?php if($group->membership()->isResourceApprovalRequired()):?>
                <?php $action = 'request';?>
              <?php else:?>
                <?php $action = 'join';?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'group_id' => $group->group_id),'sesgroup_extended',true);?>" class="smoothbox sesgroup_button sesgroup_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
            <?php else:?>
              <?php if($row->active):?>
                <a href="javascript:void(0);" class="sesgroup_button sesgroup_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
              <?php else:?>
                <a href="javascript:void(0);" id="sesgroup_user_approval" class="sesgroup_button sesgroup_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
              <?php endif;?>
            <?php endif;?>
          <?php else:?>
            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" id="sesgroup_user_approval" class="smoothbox sesgroup_button sesgroup_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
