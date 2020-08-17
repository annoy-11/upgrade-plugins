<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/styles.css'); ?>
<div class="ecoupon_create_btn">
  <a href="<?php echo $this->url(array('action' => 'create','subject'=>$this->resource_type,'resource_id' => $this->resource_id), "ecoupon_general"); ?>" class="sesbasic_button sessmoothbox"><i class="fa fa-plus"></i><?php echo $this->translate("Create New Coupon"); ?></a>
</div>
<div class="ecoupon_coupon_main">
  <?php foreach($this->paginator as $coupon): ?> 
  <div class="ecoupon_coupon_inner">
     <div class="ecoupon_img">
      <?php if(isset($this->couponPhotoActive)) { ?>
        <a href="<?php echo $coupon->getHref(); ?>" style="width:200px;height:160px;">
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
       <?php if(isset($this->titleActive)) { ?>
        <div class="_title"><?php echo $this->htmlLink($coupon->getHref(), $this->translate(Engine_Api::_()->sesbasic()->textTruncation($coupon->getTitle(),16)), array('title' => $coupon->getTitle(), 'target' => '_blank')) ?></div>
       <?php } ?>
       <?php if(isset($this->startDateActive) || isset($this->endDateActive)) { ?>
        <div class="_date">
          <?php if(isset($this->startDateActive)) { ?>
            <span class="sesbasic_text_light"><b><?php echo $this->translate('Start Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$coupon->discount_start_time)); ?></span>
          <?php } ?>
          <?php if(isset($this->endDateActive)  && $coupon->discount_end_type) { ?>
            <span class="sesbasic_text_light"><b><?php echo $this->translate('End Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$coupon->discount_end_time)); ?></span>
          <?php } ?>
        </div>
       <?php } ?>
       <?php if(isset($this->descriptionActive)) { ?>
        <div class="_desc sesbasic_text_light"><?php echo $coupon->description; ?></div>
       <?php } ?>
       <?php if(isset($this->couponCodeActive) || isset($this->remaingCouponActive)) { ?>
        <div class="_coupon_footer">
          <?php if(isset($this->couponCodeActive)) { ?>
            <span class="_coupon ecoupon_coupon_code"><?php echo $coupon->coupon_code; ?></span>
          <?php } ?>
          <?php if(isset($this->remaingCouponActive)) { ?>
            <span class="_remain"><?php echo $this->translate('%s Coupons left',$coupon->remaining_coupon); ?></span>
          <?php } ?>
        </div>
       <?php } ?>
       <div class="_btns">
          <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataButtons.tpl';?>
        </div>
        <div class="_counts">
            <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataStatics.tpl';?>
        </div>
       <div class="ecoupon_options_btn">
         <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
         <div class="sesbasic_pulldown_options">
            <ul>
              <li><a href="<?php echo $this->url(array('subject' => $coupon->resource_type,'coupon_id'=> $coupon->coupon_id,'action'=>'edit'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-pencil-square-o"></i><?php echo $this->translate('Edit Coupon'); ?></a></li>
              <li><a href="<?php echo $this->url(array('subject' => $coupon->resource_type,'coupon_id'=> $coupon->coupon_id,'action'=>'delete'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-trash-o"></i><?php echo $this->translate('Delete Coupon'); ?></a></li>
              <?php if($coupon->enabled): ?>
                <li><a href="<?php echo $this->url(array('subject' => $coupon->resource_type,'coupon_id'=> $coupon->coupon_id,'action'=>'enable'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-minus-square-o"></i><?php echo $this->translate('Disable Coupon'); ?> </a></li>
              <?php else: ?>
                <li><a href="<?php echo $this->url(array('subject' => $coupon->resource_type,'coupon_id'=> $coupon->coupon_id,'action'=>'enable'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-minus-square-o"></i><?php echo $this->translate('Enable Coupon'); ?> </a></li>
              <?php endif; ?>
              <li><a href="<?php echo $this->url(array('subject' => $coupon->resource_type,'coupon_id'=> $coupon->coupon_id,'action'=>'print','format'=>'smoothbox'), 'ecoupon_general',false); ?>" target='_blank'><i class="fa fa-print"></i><?php echo $this->translate('Print Coupon'); ?></a></li>
            </ul>
         </div>
       </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
