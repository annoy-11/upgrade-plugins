<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $page = $this->page;?>
<?php $viewer = $this->viewer();?>
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs sespage_linked_pages_block">
	<div class="sesbasic_sidebar_list">
    <?php if(isset($this->pagePhotoActive) && $page->photo_id):?>
      <div class="_thumb">
        <img src="<?php echo $page->getPhotoUrl('thumb.icon') ?>" class="thumb_icon" alt="" />
      </div>
    <?php endif;?>
    <div class="sesbasic_sidebar_list_info">
      <?php if(isset($this->titleActive)):?>
        <div class="sesbasic_sidebar_list_title">
          <?php echo $page->title; ?>
        </div>
      <?php endif; ?>
      <div class="_itembtns">
      	<?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        	<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
      	<?php endif;?>
        <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
        <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'sespage_page', 'page_can_join');?>
        <?php if($canJoin && isset($this->joinButtonActive)):?>
          <?php if($viewerId):?>
            <?php $row = $page->membership()->getRow($viewer);?>
            <?php if(null === $row):?>
              <?php if($page->membership()->isResourceApprovalRequired()):?>
                <?php $action = 'request';?>
              <?php else:?>
                <?php $action = 'join';?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'page_id' => $page->page_id),'sespage_extended',true);?>" class="smoothbox sespage_button sespage_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
            <?php else:?>
              <?php if($row->active):?>
                <a href="javascript:void(0);" class="sespage_button sespage_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
              <?php else:?>
                <a href="javascript:void(0);" id="sespage_user_approval" class="sespage_button sespage_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
              <?php endif;?>
            <?php endif;?>
          <?php else:?>
            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" id="sespage_user_approval" class="smoothbox sespage_button sespage_join_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
