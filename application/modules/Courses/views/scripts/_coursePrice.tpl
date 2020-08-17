<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _coursePrice.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->priceActive) || isset($this->discountActive)){ ?>
  <div class="pricing_header">
    <?php if(isset($this->priceActive)){ ?>
      <?php $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course); ?>
        <span class="_price"><?php echo $priceData['discountPrice'] > 0 ? Engine_Api::_()->courses()->getCurrencyPrice($priceData['discountPrice']) : $this->translate('FREE'); ?></span>
    <?php } ?>
    <?php if(isset($this->discountActive) && $priceData['discount'] > 0){ ?>
        <span class="_discount">
            <?php if($course->discount_type == 0){ ?>
                <?php echo $this->translate("%s%s OFF",str_replace('.00','',$priceData['discount']),"%"); ?>
            <?php } else { ?>
                <?php echo $this->translate("%s OFF",Engine_Api::_()->courses()->getCurrencyPrice($priceData['discount'])); ?>
            <?php } ?>
        </span>
    <?php } ?>
  </div>
<?php } ?>
