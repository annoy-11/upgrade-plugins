<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Ecoupon
 * @package    Ecoupon
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: coupon-view.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $width = isset($width) ? $width : '200px';?>
<?php $width = isset($width) ? $width : '160px'; ?>
<?php $title = ''; ?>

<?php if(isset($this->params['title_truncation'])):?>
  <?php $titleLimit = $this->params['title_truncation'];?>
<?php endif;?>
<?php if(strlen($coupon->getTitle()) > $titleLimit):?>
  <?php $title = mb_substr($coupon->getTitle(),0,$titleLimit).'...';?>
<?php else:?>
  <?php $title =$coupon->getTitle();?>
<?php endif; ?>

<div class="ecoupon_coupon_inner">
  <div class="ecoupon_img">
    <?php if(isset($this->couponPhotoActive)) { ?>
      <a href="<?php echo $coupon->getHref(); ?>" style="width:<?php echo is_numeric($width) ? $width.'px' : $width; ?>;height:<?php $width = isset($width) ? $width : '160px'; ?>;">
        <img src="<?php echo $coupon->getPhotoUrl(); ?>" />
      </a>
    <?php } ?>
    <?php if(isset($this->discountActive)) { ?>
      <span>
          <?php if($coupon->discount_type == 0){ ?>
                  <?php echo $this->translate("%s%s OFF",str_replace('.00','',$coupon->percentage_discount_value),"%"); ?>
          <?php } else { ?>
                  <?php echo $this->translate("%s OFF",Engine_Api::_()->ecoupon()->getCurrencyPrice($coupon->fixed_discount_value)); ?>
          <?php } ?>
      </span>
      <?php } ?>
  </div>
  <div class="ecoupon_cont">
     <div class="_labels">
          <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataLabel.tpl';?>
      </div>
    <?php if(isset($this->titleActive)) { ?>
      <div class="_title"><?php echo $this->htmlLink($coupon->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($title,16)), array('title' => $title, 'target' => '_blank')) ?></div>
      <?php } ?>
      <?php if(isset($this->startDateActive) || isset($this->endDateActive)) { ?>
      <div class="_date">
        <?php if(isset($this->startDateActive)) { ?>
          <span class="sesbasic_text_light"><b><?php echo $this->translate('Start Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$coupon->discount_start_time)); ?></span>
        <?php } ?>
        <?php if(isset($this->endDateActive) && $coupon->discount_end_type) { ?>
          <span class="sesbasic_text_light"><b><?php echo $this->translate('End Date:'); ?></b> <?php echo date('d M Y',strtotime(@$coupon->discount_end_time)); ?></span>
        <?php } ?>
        <span class="_counts">
          <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataStatics.tpl';?>
        </span>
      </div>
      <?php } ?>
      <?php if(isset($this->descriptionActive)) { ?>
      <div class="_desc sesbasic_text_light"><?php echo $coupon->description; ?></div>
      <?php } ?>
      <?php if(isset($this->couponCodeActive) || isset($this->remaingCouponActive)) { ?>
      <div class="_coupon_footer">
        <?php if(isset($this->couponCodeActive)) { ?>
          <a href="javascript:;" class="_coupon ecoupon_coupon_code"><?php echo $coupon->coupon_code; ?></a>
        <?php } ?>
        <?php if(isset($this->remaingCouponActive)) { ?>
          <span class="_remain"><?php echo $this->translate('%s Coupons left',$coupon->remaining_coupon); ?></span>
        <?php } ?>
         <div class="_btns floatR">
          <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataButtons.tpl';?>
        </div>
      </div>
      <?php } ?>
      <div class="ecoupon_options_btn">
        <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
        <div class="sesbasic_pulldown_options">
          <ul>
            <li><a href="<?php echo $this->url(array('subject' => $coupon->getItemType(),'coupon_id'=> $coupon->coupon_id,'action'=>'print','format'=>'smoothbox'), 'ecoupon_general',false); ?>" target='_blank'><i class="fa fa-print"></i><?php echo $this->translate('Print Coupon'); ?></a></li>
          </ul>
        </div>
      </div>
  </div>
</div>
