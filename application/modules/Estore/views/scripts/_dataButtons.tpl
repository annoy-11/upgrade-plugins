<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
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
<?php if($store->is_approved):?>
 <?php if(isset($this->socialSharingActive)){ ?>
            
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $store, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php } ?>
  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'create');?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->estore()->getLikeStatus($store->store_id,$store->getType()); ?>
    <a href="javascript:;" data-type="like_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn estore_like_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $store->like_count;?></span></a>
  <?php endif;?>
  <?php if($viewerId):?>
    <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.favourite', 1)):?>
      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'estore')->isFavourite(array('resource_id' => $store->store_id,'resource_type' => $store->getType())); ?>
      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn estore_favourite_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $store->favourite_count;?></span></a>
    <?php endif;?>
    <?php if($viewerId != $store->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.follow', 1)):?>
      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'estore')->isFollow(array('resource_id' => $store->store_id,'resource_type' => $store->getType())); ?>
      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $store->store_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn estore_follow_<?php echo $store->store_id ?> estore_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $store->follow_count;?></span></a>
    <?php endif;?>
  <?php endif;?>
<?php endif;?>
