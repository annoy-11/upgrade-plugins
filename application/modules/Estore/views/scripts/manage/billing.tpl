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
<div class="sesproduct_checkout_body" >
    <?php echo $this->form->render($this); ?>
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
    function getStates(value,id,selectedVal) { 
    
        sesJqueryObject.post('sesproduct/cart/get-state',{country_id:value,selected:selectedVal},function (response) { 
            sesJqueryObject('#'+id).removeAttr('data-rel');
            sesJqueryObject('#'+id).html(response);
        })
    }
    getStates('<?php echo $this->country_id; ?>','state','<?php echo $this->state_id; ?>');
    
  <?php if($this->viewer()->getIdentity()){ ?>
        sesJqueryObject(document).ready(function () {
            sesJqueryObject('.sesproduct_billing_details').find('.sesproduct_checkout_body').show();
        });
	<?php } ?>
	sesJqueryObject(document).on('click','.sesproduct_place_order',function (e) {
		var checkboxes = sesJqueryObject('.accept_term_conditions');
		var isValid = true;
        checkboxes.each(function (e) {
            var errorMessage = sesJqueryObject(this).parent().find('.error_message');
			if(sesJqueryObject(this).prop('checked') == false){
			    if(!errorMessage.length){
                    sesJqueryObject(this).parent().find('.sesproduct_order_note_cnt').before('<span class="error_message" style="color: red;"><?php echo $this->translate("Please agree with terms & conditions."); ?></span>');
                    isValid = false;
                }
            }else{
                sesJqueryObject(this).parent().find('.error_message').remove();
            }
        });
		if(isValid == false){
		    return;
        }
		//place order now

		var formData = new FormData(document.getElementById('sesproduct_checkout_form'));
        formData.append('place-order', 1);
		sesJqueryObject('.sesproduct_place_order_loading').show();
        sesJqueryObject.ajax({
            url: "<?php echo $this->url(array('action'=>'place-order'),'sesproduct_cart',true);?>",
            type: "POST",
            contentType:false,
            processData: false,
            cache: false,
            data: formData,
            success: function(response) {
                sesJqueryObject('.sesproduct_place_order_loading').hide();
                if(response == "return_to_cart"){
                    window.location.href = cartUrl;
                    return;
                }
                var result = sesJqueryObject.parseJSON(response);
                if(result.url) {
                	window.location.href = result.url;
                }
            }
        });
    });
	sesJqueryObject(document).on('click','.sesproduct_order_note',function (e) {
		var elem = sesJqueryObject(this).parent();
		if(elem.hasClass('open')){
		    elem.removeClass('open');
		    elem.find('textarea').hide();
        }else{
            elem.addClass('open');
            elem.find('textarea').show();
        }
    });
    function removeProductsfromShipping(key,obj) {
        sesJqueryObject(obj).parent().hide();
        sesJqueryObject(obj).parent().parent().find('div').eq(1).show();
    }
    sesJqueryObject(document).on('change','input[name=payment_type]',function () {
		if(sesJqueryObject(this).val() == "check"){
			sesJqueryObject('#sesproduct_check_cnt').show();
        }else {
            sesJqueryObject('#sesproduct_check_cnt').hide();
        }
    });
	function submitAddressForm(){
	    var isValid = true;
		//check all mandatory fields
		sesJqueryObject('.sesproduct_billing_frm').find('input, select, textarea').each(function() {
            var value = sesJqueryObject(this).val();
            var prop = sesJqueryObject(this).prop('type');
            if(prop != "email") {
                if (!value) {
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                } else {
                    sesJqueryObject(this).parent().find('.error-message').eq(0).hide();
                }
            }else{
                if (!value) {
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                    sesJqueryObject(this).parent().find('.error-message').eq(1).hide();
                } else if(!isSesproductCheckEmail(value)){
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(1).show();
                    sesJqueryObject(this).parent().find('.error-message').eq(0).hide();
				}else {
                    sesJqueryObject(this).parent().find('.error-message').eq(0).hide();
                }
            }
		});

        sesJqueryObject('.sesproduct_billing_frm').find('input, select, textarea').each(function() {
            var value = sesJqueryObject(this).val();
            var prop = sesJqueryObject(this).prop('type');
            if(prop != "email") {
                if (!value) {
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                } else {
                    sesJqueryObject(this).parent().find('.error-message').hide();
                }
            }else{
                if (!value) {
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                    sesJqueryObject(this).parent().find('.error-message').eq(1).hide();
                } else if(!isSesproductCheckEmail(value)){
                    isValid = false;
                    sesJqueryObject(this).parent().find('.error-message').eq(1).show();
                    sesJqueryObject(this).parent().find('.error-message').eq(0).hide();
                }else {
                    sesJqueryObject(this).parent().find('.error-message').hide();
                }
            }
        });
        var checkbox = sesJqueryObject('.sameasbillingaddress:checked').length;
        if(!checkbox){
            sesJqueryObject('.sesproduct_shipping_frm').find('input, select, textarea').each(function() {
                var value = sesJqueryObject(this).val();
                var prop = sesJqueryObject(this).prop('type');
                if(prop != "email") {
                    if (!value) {
                        isValid = false;
                        sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                    } else {
                        sesJqueryObject(this).parent().find('.error-message').hide();
                    }
                }else{
                    if (!value) {
                        isValid = false;
                        sesJqueryObject(this).parent().find('.error-message').eq(0).show();
                        sesJqueryObject(this).parent().find('.error-message').eq(1).hide();
                    } else if(!isSesproductCheckEmail(value)){
                        isValid = false;
                        sesJqueryObject(this).parent().find('.error-message').eq(1).show();
                        sesJqueryObject(this).parent().find('.error-message').eq(0).hide();
                    }else {
                        sesJqueryObject(this).parent().find('.error-message').hide();
                    }
                }
            });
		}
		return isValid;
    }
    function isSesproductCheckEmail(email){
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return regex.test(email);
    }
	sesJqueryObject(document).on('click','.back_check',function (e) {
		var parentElem = sesJqueryObject(this).closest('.sesproduct_checkout_step');
        var allChildrens = sesJqueryObject('.sesproduct_checkout_container').find('.sesproduct_checkout_step');
        var currentIndex = allChildrens.index(parentElem);
        allChildrens.eq(currentIndex).find('.sesproduct_checkout_body').hide();
        //show next content
        allChildrens.eq(currentIndex - 1).find('.sesproduct_checkout_body').slideDown(1000, function() {
            // Animation complete.
            sesJqueryObject(this).css('display','block');
        });

    });
	sesJqueryObject(document).on('click','.sameasbillingaddress',function (e) {
		var value = sesJqueryObject('.sameasbillingaddress:checked').length;
		var parent = sesJqueryObject(this).parent().parent().find('.sameasbillingaddress_cnt');
		if(value == 0){
            parent.slideDown(500);
        }else{
			parent.slideUp(500);
        }
    })
sesJqueryObject(document).on('click','.nextprevious',function (e) {
    var parentElem = sesJqueryObject(this).closest('.sesproduct_checkout_step');
    var allChildrens = sesJqueryObject('.sesproduct_checkout_container').find('.sesproduct_checkout_step');
    var currentIndex = allChildrens.index(parentElem);
	if(currentIndex + 1 == allChildrens.length){
	    //call submit form
		return;
    }
    if(allChildrens.eq(currentIndex + 1).hasClass('shipping_method')){
        //validate form values
		if(!submitAddressForm()){
			return false;
		}
		//call shipping methods
        shipping_method(currentIndex);
        sesJqueryObject('<img style="float:right ;" class="sesproduct_img_cnt" src="application/modules/Core/externals/images/loading.gif">').insertBefore(sesJqueryObject(this));
		return;
	}else if(sesJqueryObject(this).hasClass('shipping_method_save')){
        reviewShippingMethod(currentIndex);
        return;
	}else if(allChildrens.eq(currentIndex + 1).hasClass('order_review')){
		//call order review
        order_review(currentIndex,this);
        return;
    }

    hideFunctionSesproductCheckout(currentIndex)
	
});
	function reviewShippingMethod(currentIndex) {
		var elem = sesJqueryObject('.sesproduct_shipping_address');
		var isValid = true;
		elem.each(function (index) {
			var store_id = sesJqueryObject(this).data('action');
			if(sesJqueryObject('#no_shipping_'+store_id).length && !sesJqueryObject('#no_shipping_'+store_id+":checked").length){
				sesJqueryObject('#sesproduct_shipping_error_'+store_id).show();
                isValid = false;
            }else if(sesJqueryObject('input[name=shipping_method_'+store_id+']').length && !sesJqueryObject('input[name=shipping_method_'+store_id+']:checked').length){
                sesJqueryObject('#sesproduct_shipping_error_'+store_id).show();
                isValid = false;
			}else{
                sesJqueryObject('#sesproduct_shipping_error_'+store_id).hide();
			}
        });
		if(isValid == true){
            paymentMethods(currentIndex);
        }
    }
	function hideFunctionSesproductCheckout(currentIndex) {
        var allChildrens = sesJqueryObject('.sesproduct_checkout_container').find('.sesproduct_checkout_step');
        //Hide current div
        allChildrens.eq(currentIndex).find('.sesproduct_checkout_body').hide();
        //show next content
        allChildrens.eq(currentIndex + 1).find('.sesproduct_checkout_body').slideDown(1000, function() {
            // Animation complete.
            sesJqueryObject(this).css('display','block');
        });
    }
    function getAllBillingFieldValues(className) {
        var inputValues = sesJqueryObject('.'+className).find('input, select, textarea').serialize();
        return inputValues;
    }
    function paymentMethods(currentIndex) {
		//get Shipping ids of store
        var shipping = sesJqueryObject('.shipping_method').find('input[type=radio]').serialize();
        sesJqueryObject.post('sesproduct/cart/place-order',{shipping:shipping,order:2},function (response) {
            if(response == "return_to_cart"){
                window.location.href = cartUrl;
                return;
            }
            sesJqueryObject('.sesproduct_img_cnt').remove();
            sesJqueryObject('.payment_methods').find('.sesproduct_checkout_body').remove();
            sesJqueryObject('.payment_methods').append(response);
            hideFunctionSesproductCheckout(currentIndex);
        });
    }
    var cartUrl = "<?php echo $this->url(array('action'=>'index'),'sesproduct_cart',true); ?>"
	function shipping_method(currentIndex){
		var billingAddress = getAllBillingFieldValues('sesproduct_billing_frm');
        var checkbox = sesJqueryObject('.sameasbillingaddress:checked').length;
        var shippingAddress = "";
        if(!checkbox) {
			shippingAddress = getAllBillingFieldValues('sesproduct_shipping_frm');
        }
		sesJqueryObject.post('sesproduct/cart/place-order',{shippingAddress:shippingAddress,billingAddress:billingAddress,checkbox:checkbox,order:1},function (response) {
		    if(response == "return_to_cart"){
		        window.location.href = cartUrl;
		        return;
            }
		    sesJqueryObject('.sesproduct_img_cnt').remove();
			sesJqueryObject('.shipping_method').find('.sesproduct_checkout_body').remove();
            sesJqueryObject('.shipping_method').append(response);
		    hideFunctionSesproductCheckout(currentIndex);
        });
	}
	function order_review(currentIndex,obj){
		//check payment method selected
		var method = sesJqueryObject('input[name=payment_type]:checked');
		if(method.length){
            sesJqueryObject('.payment_method_error').hide();
        }else{
		    sesJqueryObject('.payment_method_error').show();
		    return;
        }
        if(method.val() == "check"){
			var isValid = true;
			sesJqueryObject('#sesproduct_check_cnt').find('input').each(function () {
				if(!sesJqueryObject(this).val()){
                    sesJqueryObject(this).css('border','1px solid red');
                    isValid = false;
                }else{
                    sesJqueryObject(this).css('border','');
                }
            });
			if(isValid == false){
			    return;
            }
        }
        sesJqueryObject('<img style="float:right ;" class="sesproduct_img_cnt" src="application/modules/Core/externals/images/loading.gif">').insertBefore(sesJqueryObject(obj));

        //shipping details
        var shipping = sesJqueryObject('.shipping_method').find('input[type=radio]').serialize();
        sesJqueryObject.post('sesproduct/cart/place-order',{order:3,shipping:shipping},function (response) {
            if(response == "return_to_cart"){
                window.location.href = cartUrl;
                return;
            }
            sesJqueryObject('.sesproduct_img_cnt').remove();
            sesJqueryObject('.order_review').find('.sesproduct_checkout_body').remove();
            sesJqueryObject('.order_review').append(response);
            hideFunctionSesproductCheckout(currentIndex);
        });
	}
sesJqueryObject(document).on('click','.sesproduct_checkout_head',function (e) {
    var parentElem = sesJqueryObject(this).closest('.sesproduct_checkout_step');
    var allChildrens = sesJqueryObject('.sesproduct_checkout_container').find('.sesproduct_checkout_step');
    var currentIndex = allChildrens.index(parentElem);
    //click elem index greater than current open index
	var currentDisplayElem = sesJqueryObject('.sesproduct_checkout_body[style*="block"]').parent();
	var currentDisplayIndex = allChildrens.index(currentDisplayElem);
	if(currentDisplayIndex < currentIndex || currentDisplayIndex == 0 || currentIndex == currentDisplayIndex){
		return;
    }
    allChildrens.eq(currentDisplayIndex).find('.sesproduct_checkout_body').hide();
    allChildrens.eq(currentIndex).find('.sesproduct_checkout_body').slideDown(1000,function () {
        // Animation complete.
        sesJqueryObject(this).css('display','block');
    });
});
sesJqueryObject(document).on('click','.auth_logincheck',function (e) {
	var value = sesJqueryObject('input[type=radio][name=login_type]:checked').val();
	if(value == "guest"){
		sesJqueryObject('.firststep').trigger('click');
	}else{
		window.location.href = 'login?return_url=<?php echo $this->url(array('action'=>'checkout'),'sesproduct_cart',true); ?>'
	}
});
</script>
