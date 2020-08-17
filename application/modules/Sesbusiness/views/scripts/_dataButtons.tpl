<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataButtons.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
  return;
?>
<?php if($business->is_approved):?>
  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'comment');?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->sesbusiness()->getLikeStatus($business->business_id,$business->getType()); ?>
    <a href="javascript:;" data-type="like_view" data-url="<?php echo $business->business_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusiness_like_<?php echo $business->business_id ?> sesbusiness_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $business->like_count;?></span></a>
  <?php endif;?>
  <?php if($viewerId):?>
    <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.favourite', 1)):?>
      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesbusiness')->isFavourite(array('resource_id' => $business->business_id,'resource_type' => $business->getType())); ?>
      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $business->business_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesbusiness_favourite_<?php echo $business->business_id ?> sesbusiness_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $business->favourite_count;?></span></a>
    <?php endif;?>
    <?php if($viewerId != $business->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allow.follow', 1)):?>
      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->isFollow(array('resource_id' => $business->business_id,'resource_type' => $business->getType())); ?>
      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $business->business_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesbusiness_follow_<?php echo $business->business_id ?> sesbusiness_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $business->follow_count;?></span></a>
    <?php endif;?>
  <?php endif;?>
<?php endif;?>
