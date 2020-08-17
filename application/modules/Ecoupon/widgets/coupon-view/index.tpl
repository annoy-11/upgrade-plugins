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
<?php $viewer = Engine_Api::_()->user()->getViewer(); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<div class="ecoupon_coupon_profile">
  <div class="ecoupon_coupon_inner_profile">
    <div class="ecoupon_img">
       <a href="javascript:void(0)" style="width:250px;height:250px;">
         <img src="<?php echo $this->coupon->getPhotoUrl(); ?>" />
       </a>
    </div>
    <?php $coupon = $this->coupon; ?>
    <div class="ecoupon_cont">
       <div class="_labels">
         <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataLabel.tpl';?>
       </div>
       <div class="_title"><?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($this->coupon->getTitle(),16)); ?></div>
       <div class="_date">
            <?php if(isset($this->startDateActive)) { ?>
              <span class="sesbasic_text_light"><b><?php echo $this->translate('Start Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$this->coupon->discount_start_time)); ?></span>
            <?php } ?>
            <?php if(isset($this->endDateActive)  && $coupon->discount_end_type) { ?>
              <span class="sesbasic_text_light"><b><?php echo $this->translate('End Date:'); ?></b> <?php echo date('d M Y',strtotime(@$this->coupon->discount_end_time)); ?></span>
            <span class="_counts">
            <?php } ?>
            <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataStatics.tpl';?>
          </span>
       </div>
      <?php if(isset($this->descriptionActive)) { ?>
        <div class="_desc sesbasic_text_light"><?php echo $this->coupon->description; ?></div>
      <?php } ?>
        <div class="_btns">
          <?php  include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/_dataButtons.tpl';?>
       </div>
       <div class="ecoupon_options_btn">
         <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
         <div class="sesbasic_pulldown_options">
            <ul>
            <?php if(($this->viewer_id == $this->coupon->owner_id) && $this->coupon->authorization()->isAllowed($viewer, 'delete')) { ?>
              <?php if($this->coupon->authorization()->isAllowed($viewer, 'edit')) {?>
                <li><a href="<?php echo $this->url(array('subject' => $this->coupon->getItemType(),'coupon_id'=> $this->coupon->coupon_id,'action'=>'edit'), 'ecoupon_general', false); ?>"><i class="fa fa-pencil-square-o"></i><?php echo $this->translate('Edit Coupon'); ?></a></li>
               <?php } ?>
               <?php if($this->coupon->authorization()->isAllowed($viewer, 'delete')) {?>
                <li><a href="<?php echo $this->url(array('subject' => $this->coupon->getItemType(),'coupon_id'=> $this->coupon->coupon_id,'action'=>'delete'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-trash-o"></i><?php echo $this->translate('Delete Coupon'); ?></a></li>
              <?php } ?>
              <?php if($this->coupon->authorization()->isAllowed($viewer, 'edit')) {?>
                <?php if($this->coupon->enabled): ?>
                  <li><a href="<?php echo $this->url(array('subject' => $this->coupon->getItemType(),'coupon_id'=> $this->coupon->coupon_id,'action'=>'enable'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-minus-square-o"></i><?php echo $this->translate('Disable Coupon'); ?> </a></li>
                <?php else: ?>
                  <li><a href="<?php echo $this->url(array('subject' => $this->coupon->getItemType(),'coupon_id'=> $this->coupon->coupon_id,'action'=>'enable'), 'ecoupon_general', false); ?>" class="sessmoothbox"><i class="fa fa-minus-square-o"></i><?php echo $this->translate('Enable Coupon'); ?> </a></li>
                <?php endif; ?>
              <?php } ?>
            <?php } ?>
              <?php if(isset($this->printButtonActive)) { ?>
                <li><a href="<?php echo $this->url(array('subject' => $this->coupon->getItemType(),'coupon_id'=> $this->coupon->coupon_id,'action'=>'print','format'=>'smoothbox'), 'ecoupon_general',false); ?>" target='_blank'><i class="fa fa-print"></i><?php echo $this->translate('Print Coupon'); ?></a></li>
              <?php } ?>
            </ul>
         </div>
       </div>
    </div>
    <div class="_coupon_right">
       <span class="_off">
          <?php if($this->coupon->discount_type == 0){ ?>
              <?php echo $this->translate("%s%s OFF",str_replace('.00','',$this->coupon->percentage_discount_value),"%"); ?>
          <?php } else { ?>
              <?php echo $this->translate("%s OFF",Engine_Api::_()->ecoupon()->getCurrencyPrice($this->coupon->fixed_discount_value)); ?>
          <?php } ?>
       </span>
       <?php if(isset($this->couponCodeActive)) { ?>
          <span><a href="javascript:void(0)" class="_coupon ecoupon_coupon_code"><?php echo $this->coupon->coupon_code; ?></a></span>
        <?php } ?>
        <?php if(isset($this->remaingCouponActive)) { ?>
          <span class="_remain"><?php echo $this->translate('%s Coupons left',$this->coupon->remaining_coupon); ?></span>
        <?php } ?>
    </div>
  </div>
</div>
