<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _billingInformation.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $viewer = $this->viewer(); ?>
<?php $counties = Engine_Api::_()->getDbTable('countries','estore')->getCountries(); ?>
<?php
    $viewer_id = $this->viewer()->getIdentity();
    //get details
    $billingAddress = $shippingAddress = "";
    if($viewer_id){
        $addressTable = Engine_Api::_()->getDbTable('addresses','sesproduct');
        $billingAddressArray = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>0));
        $shipingAddressArray = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>1));
        if(count($billingAddressArray) > 0){
            $billingAddress = $billingAddressArray[0];
        }
        if(count($shipingAddressArray) > 0){
            $shipingAddress = $shipingAddressArray[0];
        }
    }
?>
<div class="sesproduct_checkout_body" style="display: none;">
    <h5><?php echo $this->translate("Billing Address"); ?></h5>
    <div class="sesproduct_address_form sesproduct_billing_frm">
        <div class="form-group _half-w">
            <label><?php echo $this->translate("First Name"); ?><span class="sesproduct_required"> *</span></label>
            <input type="text" name="first_name" value="<?php echo (!empty($billingAddress)) ? $billingAddress->first_name : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-w">
            <label><?php echo $this->translate("Last Name"); ?><span class="sesproduct_required"> *</span></label>
            <input type="text" name="last_name" value="<?php echo (!empty($billingAddress)) ? $billingAddress->last_name : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-w">
            <label><?php echo $this->translate("Email"); ?><span class="sesproduct_required"> *</span></label>
            <input type="email" name="email" value="<?php echo (!empty($billingAddress)) ? $billingAddress->email : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
            <span class="error-message sesproduct_required" style="display: none;"><?php echo $this->translate("Please provide valid email address.");  ?></span>
        </div>
        <div class="form-group _half-w">
            <label><?php echo $this->translate("Phone Number"); ?><span class="sesproduct_required"> *</span></label>
            <input type="text" name="phone_number" value="<?php echo (!empty($billingAddress)) ? $billingAddress->phone_number : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-w">
            <label><?php echo $this->translate("Country"); ?><span class="sesproduct_required"> *</span></label>
            <select name="country" class="country_sesproduct" onchange="getStates(this,'state_billing')">
                <option value=""><?php echo $this->translate('Select Country'); ?></option>
                <?php foreach($counties as $country){ ?>
                <option value="<?php echo $country['country_id']; ?>" <?php echo !empty($billingAddress) && $billingAddress->country == $country['country_id'] ? "selected" : ""; ?> ><?php echo $country['name']; ?></option>
                <?php } ?>
            </select>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-w">
            <label><?php echo $this->translate("Address"); ?><span class="sesproduct_required"> *</span></label>
            <textarea name="address"><?php echo (!empty($billingAddress)) ? $billingAddress->address : ''; ?></textarea>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-q">
            <label><?php echo $this->translate("City"); ?><span class="sesproduct_required"> *</span></label>
            <input type="text" name="city" value="<?php echo (!empty($billingAddress)) ? $billingAddress->city : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-q">
            <label><?php echo $this->translate("State"); ?><span class="sesproduct_required"> *</span></label>
            <select name="state" id="state_billing" data-rel="<?php echo (!empty($billingAddress)) ? $billingAddress->state : ''; ?>">
                <option value=""><?php echo $this->translate('Select State');  ?></option>
            </select>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
        <div class="form-group _half-q">
            <label><?php echo $this->translate("ZIP/PIN Code"); ?><span class="sesproduct_required"> *</span></label>
            <input type="text" name="zip_code" value="<?php echo (!empty($billingAddress)) ? $billingAddress->zip_code : ''; ?>"/>
            <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
        </div>
    </div>
    <div class="sesproduct_address_form sesproduct_shipping_frm">
        <div>
            <h5><?php echo $this->translate("Shipping Address"); ?></h5>
            <div class="form-group">
                <input type="checkbox" value="1" id="sameasbillingaddress" checked name="sameasbillingaddress" class="sameasbillingaddress"/>
                <label for="sameasbillingaddress"><?php echo $this->translate('Same as Billing Address'); ?></label>
            </div>
            <div class="sameasbillingaddress_cnt" style="display: none">
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("First Name"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="text" name="shipping_first_name" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->first_name : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("Last Name"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="text" name="shipping_last_name" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->last_name : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("Email"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="email" name="shipping_email" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->email : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                    <span class="error-message sesproduct_required" style="display: none;"><?php echo $this->translate("Please provide valid email address.");  ?></span>
                </div>
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("Phone Number"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="text" name="shipping_phone_number" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->phone_number : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("Country"); ?><span class="sesproduct_required"> *</span></label>
                    <select  name="shipping_country" class="country_sesproduct"  onchange="getStates(this,'state_shipping')">
                        <option  value=""><?php echo $this->translate("Select Country"); ?></option>
                        <?php foreach($counties as $country){ ?>
                        <option value="<?php echo $country['country_id']; ?>" <?php echo !empty($shipingAddress) && $shipingAddress->country == $country['country_id'] ? "selected" : ""; ?> ><?php echo $country['name']; ?></option>
                        <?php } ?>
                    </select>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-w">
                    <label><?php echo $this->translate("Address"); ?><span class="sesproduct_required"> *</span></label>
                    <textarea name="shipping_address"><?php echo (!empty($shipingAddress)) ? $shipingAddress->address : ''; ?></textarea>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-q">
                    <label><?php echo $this->translate("State"); ?><span class="sesproduct_required"> *</span></label>
                    <select name="shipping_state" id="state_shipping" data-rel="<?php echo (!empty($shipingAddress)) ? $shipingAddress->state : ''; ?>">
                        <option value=""><?php echo $this->translate('Select State');  ?></option>
                    </select>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>                
                <div class="form-group _half-q">
                    <label><?php echo $this->translate("City"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="text" name="shipping_city" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->city : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
                <div class="form-group _half-q">
                    <label><?php echo $this->translate("ZIP/PIN Code"); ?><span class="sesproduct_required"> *</span></label>
                    <input type="text" name="shipping_zip_code" value="<?php echo (!empty($shipingAddress)) ? $shipingAddress->zip_code : ''; ?>"/>
                    <span class="error-message sesproduct_required"><?php echo $this->translate("Please complete this field - it is required.");  ?></span>
                </div>
            </div>
            <div class="submit">
                <?php if(!$this->viewer()->getIdentity()){ ?>
                    <a href="javascript:;" class="back_check"><i class="fa fa-angle-left"></i>&nbsp;<span><?php echo $this->translate('Back'); ?></span></a>
                <?php } ?>
                <a href="javascript:void(0);" class="info_btn nextprevious"><?php echo $this->translate("Save & Continue"); ?></a>
            </div>
        </div>
    </div>
    <button type="submit" name="address_submit" style="display: none;" onclick="submitAddressForm();"></button>
</div>
<style>
    .sesproduct_required{
        color:red;
    }
    .error-message{
        display:none;
        font-size: 85%;
        margin:5px 0;
    }
</style>
<script type="application/javascript">

    sesJqueryObject(document).ready(function (e) {
        sesJqueryObject('.country_sesproduct').trigger('onchange');
    });
    function getStates(obj,id) {
        var value = obj.value;
        var selectedVal = sesJqueryObject('#'+id).data('rel');
        if(!sesJqueryObject(obj).parent().find('.loading_image').length){
            sesJqueryObject(obj).parent().append('<img class="loading_image" src="application/modules/Core/externals/images/large-loading.gif">');
        }
        sesJqueryObject.post('sesproduct/cart/get-state',{country_id:value,selected:selectedVal},function (response) {
            sesJqueryObject(obj).parent().find('.loading_image').remove();
            sesJqueryObject('#'+id).removeAttr('data-rel');
            sesJqueryObject('#'+id).html(response);
        })
    }
</script>
