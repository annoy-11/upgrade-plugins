<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataButton.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
          return;
?>
<?php if($coupon->is_approved):  ?>
<?php $canComment = Engine_Api::_()->authorization()->isAllowed('coupon', $viewer, 'view'); ?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->ecoupon()->getLikeStatus($coupon->coupon_id,$coupon->getType()); ?>
    <a href="javascript:;" data-url="<?php echo $coupon->coupon_id; ?>" data-type="ecoupon_like_view" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn ecoupon_like_<?php echo $coupon->coupon_id; ?> seslisting_like_seslisting_listing ecoupon_likefavourite <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $coupon->like_count;?></span></a>
  <?php endif;  ?>
  <?php if(isset($this->favoriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.allow.favourite', 1)):?>
    <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'ecoupon')->isFavourite(array('resource_id' => $coupon->coupon_id,'resource_type' => $coupon->getType())); ?>
      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing ecoupon_likefavourite ecoupon_favourite_<?php echo $coupon->coupon_id; ?>  <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>" data-type="ecoupon_favourite_view" data-url="<?php echo $coupon->coupon_id; ?>"><i class="fa fa-heart"></i><span><?php echo $coupon->favourite_count;?></span></a>
  <?php endif; ?>
<?php endif; ?>
