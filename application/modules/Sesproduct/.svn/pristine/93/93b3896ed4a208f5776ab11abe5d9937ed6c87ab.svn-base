<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _productPrice.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesproduct_price">
    <?php
        if($item->discount && $priceDiscount = Engine_Api::_()->sesproduct()->productDiscountPrice($item)){
    ?>
    <span class="current_value"><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($priceDiscount); ?></span>
    <span class="old_value"><?php echo Engine_Api::_()->sesproduct()->getCurrencySymbol(Engine_Api::_()->sesproduct()->getCurrentCurrency()); ?><strike><?php echo $item->price; ?></strike></span>
    <?php if(isset($this->discountActive)){ ?>
        <span class="discount">
            <?php if($item->discount_type == 0){ ?>
                <?php echo $this->translate("%s%s OFF",str_replace('.00','',$item->percentage_discount_value),"%"); ?>
            <?php } else { ?>
                <?php echo $this->translate("%s OFF",Engine_Api::_()->sesproduct()->getCurrencyPrice($item->fixed_discount_value)); ?>
            <?php } ?>
        </span>
    <?php } ?>
    <?php } else { ?>
        <span class="current_value"><?php echo $item->price > 0 ? Engine_Api::_()->sesproduct()->getCurrencyPrice($item->price) : $this->translate('FREE'); ?></span>
    <?php } ?>
</div>
