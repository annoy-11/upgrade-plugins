<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: payment-methods.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<div class="sesproduct_checkout_body" style="display: none;">
    <div class="sesproduct_error_message payment_method_error" style="display: none;">
        <?php echo $this->translate("Please choose a payment method"); ?>
    </div>
    <?php if($this->totalPrice){ ?>
    <?php if(in_array('paypal',$this->paymentMethods)){ ?>
    <div class="form-group">
        <input type="radio" value="paypal"  name="payment_type" id="payment_type_paypal"/>
            <label for="payment_type_paypal" title="<?php echo $this->translate("Pay With Paypal"); ?>"><img src="./application/modules/Sesproduct/externals/images/paypal.png"/></label>
    </div>
    <?php } ?>
    <?php if(in_array(0,$this->paymentMethods) && isset($settings->getSetting('estore.payment.siteadmin', array())['0'])){ ?>
    <div class="form-group">
        <input type="radio" value="cod"  name="payment_type" id="payment_type_cod"/>
        <label for="payment_type_cod" title="<?php echo $this->translate("Pay With Cash on Delivery"); ?>"><img src="./application/modules/Sesproduct/externals/images/cash.png"/></label>
    </div>
    <?php } ?>
     <?php if(in_array('stripe',$this->paymentMethods)){ ?>
        <div class="form-group">
            <input type="radio" value="stripe"  name="payment_type" id="payment_type_stripe"/>
            <label for="payment_type_stripe" title="<?php echo $this->translate("Pay With Stripe"); ?>"><img src="./application/modules/Sesproduct/externals/images/stripe.png"/></label>
        </div>
   <?php } ?>
    <?php if(in_array('paytm',$this->paymentMethods)){ ?>
        <div class="form-group">
            <input type="radio" value="paytm"  name="payment_type" id="payment_type_paytm"/>
            <label for="payment_type_paytm" title="<?php echo $this->translate("Pay With Paytm"); ?>"><img src="./application/modules/Sesproduct/externals/images/paytm.png"/></label>
        </div>
    <?php } ?>
    <?php if(in_array(1,$this->paymentMethods) && isset($settings->getSetting('estore.payment.siteadmin', array())['1'])){ ?>
    <div class="form-group">
        <input type="radio" value="cheque"  name="payment_type" id="payment_type_check"/>
        <label for="payment_type_check" title="<?php echo $this->translate("Pay With Cheque"); ?>"><img src="./application/modules/Sesproduct/externals/images/cheque.png"/></label>
    </div>
    <div id="sesproduct_check_cnt" style="display: none;">
        <div>
            <h3><?php echo $this->translate("Send Cheque to:"); ?></h3>
            <div><?php echo nl2br($this->checkDetails); ?></div>
        </div>
        <p><?php echo $this->translate("Please enter the information for your payment."); ?></p>
        <div>
            <div class="form-label">
                <label><?php echo $this->translate("Cheque No. / Ref. No."); ?></label>
            </div>
            <div class="form-element"><input type="text" name="check_number"></div>
        </div>

        <div>
            <div class="form-label">
                <label><?php echo $this->translate("Account Holder Name"); ?></label>
            </div>
            <div class="form-element"><input type="text" name="account_name"></div>
        </div>
        <div>
            <div class="form-label">
                <label><?php echo $this->translate("Account Number"); ?></label>
            </div>
            <div class="form-element"><input type="text" name="account_number"></div>
        </div>
        <div>
            <div class="form-label">
                <label><?php echo $this->translate("Bank Routing Number"); ?></label>
            </div>
            <div class="form-element"><input type="text" name="bank_routing_number"></div>
        </div>
    </div>
    <?php } ?>
<?php }else{ ?>
    <div>
        <input type="radio" name="payment_type" value="freeorder" checked style="display: none;">
        <span><?php echo $this->translate("Free Order"); ?></span>
    </div>
<?php } ?>
    <div class="submit">
        <a href="javascript:;" class="back_check"><i class="fa fa-angle-left"></i>&nbsp;<span><?php echo $this->translate('Back'); ?></span></a>
        <a href="javascript:void(0);" class="info_btn nextprevious"><?php echo $this->translate("Save & Continue"); ?></a>
    </div>
</div>
<?php die; ?>
