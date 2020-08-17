<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataSharing.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php if($this->widgetId) { ?>
<?php $params = Engine_Api::_()->sespage()->getWidgetParams($this->widgetId);  ?>
<?php } else { ?>
<?php $params = Engine_Api::_()->sespage()->getWidgetParams($this->identity);  ?>
<?php } ?>
<?php $allowShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.allow.share', '1'); ?>
<?php  if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || $this->favouriteButtonActive){  ?>
  <span class="sespageoffer_social_share">
    <?php if($allowShare == '2' && isset($this->socialSharingActive)){ 
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref());
      ?>
      <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $params['socialshare_icon_limit'])); ?>
    <?php } ?>
    <?php if($viewerId) { ?>
      <?php $canComment = Engine_Api::_()->authorization()->isAllowed('pageoffer', $viewer, 'comment');?>
      <?php if(isset($this->likeButtonActive) && $canComment && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.enable.like', 1)):?>
        <?php $likeStatus = Engine_Api::_()->sespage()->getLikeStatus($item->getIdentity(),$item->getType()); ?>
        <a href="javascript:;" data-contenttype="<?php echo $item->getType(); ?>" data-type="like_view" data-url="<?php echo $item->getIdentity() ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespage_like_<?php echo $item->getIdentity() ?> sespage_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
      <?php endif;?>
       <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.enable.favourite', 1)):?>
        <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sespage')->isFavourite(array('resource_id' => $item->getIdentity(),'resource_type' => $item->getType())); ?>
        <a href="javascript:;" data-contenttype="<?php echo $item->getType(); ?>" data-type="favourite_view" data-url="<?php echo $item->getIdentity() ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sespageoffer_favourite_<?php echo $item->getIdentity() ?> sespage_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count;?></span></a>
      <?php endif;?>
      <?php if($viewerId != $item->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageoffer.allow.follow', 1)):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $item->getIdentity(),'resource_type' => $item->getType())); ?>
        <a href="javascript:;" data-contenttype="<?php echo $item->getType(); ?>" data-type="follow_view" data-url="<?php echo $item->getIdentity() ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sespageoffer_<?php echo $item->getIdentity() ?> sespage_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $item->follow_count;?></span></a>
      <?php endif;?>
    <?php } ?>
  </span>
<?php } ?>
