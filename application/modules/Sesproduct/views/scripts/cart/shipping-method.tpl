<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: shipping-method.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <div class="sesproduct_checkout_body" style="display: none;">

   <?php foreach($this->shippingMethods as $key=>$shippingMethod){ ?>
    <div class="_title bold"><?php echo $shippingMethod['store_title']; ?></div>
    <div style="display: none" class="sesproduct_error_message" id="sesproduct_shipping_error_<?php echo $key; ?>">
        <?php echo $this->translate('Please choose a shipping method for %s Store',$shippingMethod['store_title']); ?>
    </div>
    <div style="display: none;" data-action="<?php echo $key; ?>" class="sesproduct_shipping_address"></div>
        <?php if(count($shippingMethod['shipping_methods'])){ ?>
            <?php foreach($shippingMethod['shipping_methods'] as $shipping_methods){ ?>
                <div class="form-group">
                    <?php if(count($shippingMethod['shipping_methods']) > 0){ ?>
                        <input type="radio" value="<?php echo $shipping_methods['shippingmethod_id']; ?>" name="shipping_method_<?php echo $key; ?>" id="radio_<?php echo $shipping_methods['shippingmethod_id']; ?>"/>
                    <?php
                    }else{ ?>
                    <input type="radio" style="display: none;" value="<?php echo $shipping_methods['shippingmethod_id']; ?>" name="shipping_method_<?php echo $key; ?>" checked id="radio_<?php echo $shipping_methods['shippingmethod_id']; ?>"/>
                    <?php
                    } ?>
                    <div>
                        <label for="radio_<?php echo $shipping_methods['shippingmethod_id']; ?>"><?php echo $shipping_methods['title'].'('.Engine_Api::_()->sesproduct()->getCurrencyPrice($shipping_methods["price"]).')'; ?></label>
                        <span class="sesbasic_text_light _shippingtime">(<?php echo $this->translate('Delivered in %s',$shipping_methods['delivery_time']); ?>)</span>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
        <div class="sesproduct_no_shipping_method">
            <div>
                <?php echo $this->translate("There are no shipping methods available for this store yet. So, please remove products of this store from your cart to complete your purchase. To remove products, %1sclick here%2s", '<a href="javascript:void(0)" onClick="removeProductsfromShipping('.$key.',this)">', '</a>'); ?>
            </div>
            <div style="display: none;">
                <p class="bold"><?php echo $this->translate("Remove Products?"); ?></p>
                <input type="checkbox" id="no_shipping_<?php echo $key; ?>" name="no_shipping" value="<?php echo $key; ?>" />
                <?php echo $this->translate("Yes, remove products of this store from my cart."); ?>
            </div>
        </div>
     <?php } ?>
     <?php } ?>
    <div class="submit">
        <a href="javascript:;" class="back_check"><i class="fa fa-angle-left"></i>&nbsp;<span><?php echo $this->translate('Back'); ?></span></a>
        <a href="javascript:void(0);" class="info_btn nextprevious shipping_method_save" >Save & Continue</a>
    </div>

 </div>
 <?php die; ?>

