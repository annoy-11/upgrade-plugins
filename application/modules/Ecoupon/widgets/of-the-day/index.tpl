<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/styles.css'); ?>
<?php $height = $this->height;?>
<?php $width = $this->width;?>

<div class="ecoupon_coupon_of_the_day">
    <ul class="ecoupon_listing sesbasic_bxs">
        <?php $limit = 0;?>
        <?php  $coupon = Engine_Api::_()->getItem('ecoupon_coupon',$this->coupon_id);?>
        <?php if($coupon):?>
          <?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/coupon-view.tpl';?>
        <?php endif;?>
        <?php $limit++;?>
    </ul>
</div>
