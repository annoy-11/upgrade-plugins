<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: enable.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Ecoupon/externals/styles/print.css" rel="stylesheet" media="print" type="text/css" />
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/print.css'); ?>
<div class="ecoupon_coupon_main">
  <div class="ecoupon_coupon_inner">
    <div class="ecoupon_img">
       <a href="<?php echo $this->coupon->getHref(); ?>" style="width:200px;height:160px;">
         <img src="<?php echo $this->coupon->getPhotoUrl(); ?>" />
       </a>
       <span>
          <?php if($this->coupon->discount_type == 0){ ?>
                  <?php echo $this->translate("%s%s OFF",str_replace('.00','',$this->coupon->percentage_discount_value),"%"); ?>
          <?php } else { ?>
                  <?php echo $this->translate("%s OFF",Engine_Api::_()->ecoupon()->getCurrencyPrice($this->coupon->fixed_discount_value)); ?>
          <?php } ?>
       </span>
    </div>
    <div class="ecoupon_cont">
       <div class="_title"><?php echo $this->coupon->getTitle(); ?></div>
       <div class="_date">
          <span class="sesbasic_text_light"><b><?php echo $this->translate('Start Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$this->coupon->discount_start_time)); ?></span>
          <span class="sesbasic_text_light"><b><?php echo $this->translate('End Date'); ?>:</b> <?php echo date('d M Y',strtotime(@$this->coupon->discount_end_time)); ?></span>
       </div>
       <div class="_desc sesbasic_text_light"><?php echo $this->coupon->description; ?></div>
       <div class="_coupon_footer">
         <span class="_coupon"><?php echo $this->coupon->coupon_code; ?></span>
         <span class="_remain"><?php echo $this->translate('%s Coupons left',$this->coupon->remaining_coupon); ?></span>
       </div>
    </div>
  </div>
</div>
<?php if(empty($_GET['order'])){ ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
    window.print();
});
</script>
<?php } ?>
