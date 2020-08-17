<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataButtons.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
  return;
?>
<?php if($group->is_approved):?>
  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'comment');?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->sesgroup()->getLikeStatus($group->group_id,$group->getType()); ?>
    <a href="javascript:;" data-type="like_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgroup_like_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $group->like_count;?></span></a>
  <?php endif;?>
  <?php if($viewerId):?>
    <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.favourite', 1)):?>
      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->isFavourite(array('resource_id' => $group->group_id,'resource_type' => $group->getType())); ?>
      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesgroup_favourite_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $group->favourite_count;?></span></a>
    <?php endif;?>
    <?php if($viewerId != $group->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.follow', 1)):?>
      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesgroup')->isFollow(array('resource_id' => $group->group_id,'resource_type' => $group->getType())); ?>
      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesgroup_follow_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $group->follow_count;?></span></a>
    <?php endif;?>
  <?php endif;?>
<?php endif;?>