<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataStatics.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
 <?php if(isset($this->likeCountActive)):?>
<span class="sesbasic_text_light ecoupon_like_count_<?php echo $coupon->coupon_id; ?>" title="<?php echo $this->translate(array('%s Like', '%s Likes', $coupon->like_count), $this->locale()->toNumber($coupon->like_count)) ?>"><i class="sesbasic_icon_like_o"></i><?php echo $coupon->like_count; ?></span>
 <?php endif;?>
 <?php if(isset($this->commentActive)):?>
<span class="sesbasic_text_light"  title="<?php echo $this->translate(array('%s Comment', '%s Comments', $coupon->comment_count), $this->locale()->toNumber($coupon->comment_count)) ?>"><i class="sesbasic_icon_comment_o"></i><?php echo $coupon->comment_count; ?></span>
<?php endif;?>
<?php if(isset($this->viewCountActive)):?>
<span class="sesbasic_text_light" title="<?php echo $this->translate(array('%s View', '%s Views', $coupon->view_count), $this->locale()->toNumber($coupon->view_count)) ?>"><i class="sesbasic_icon_view"></i><?php echo $coupon->view_count; ?></span>
<?php endif;?>
<?php if(isset($this->favoriteCountActive)):?>
<span class="sesbasic_text_light ecoupon_favourite_count_<?php echo $coupon->coupon_id; ?>" title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $coupon->favourite_count), $this->locale()->toNumber($coupon->favourite_count)) ?>"><i class="sesbasic_icon_favourite_o"></i> <?php echo $coupon->favourite_count; ?></span>
<?php endif;?>

