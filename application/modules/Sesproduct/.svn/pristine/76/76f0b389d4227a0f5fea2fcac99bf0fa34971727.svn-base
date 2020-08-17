sesJqueryObject(document).on('click','.sesproduct_addtocart',function (e) {
    e.preventDefault();
    if(sesJqueryObject(this).find('.loading_image').length){
        return;
    }
    var product_id = sesJqueryObject(this).attr('data-action');
    if(product_id){
        sesJqueryObject(this).prepend('<img class="loading_image" src="application/modules/Core/externals/images/loading.gif">');
        var that = this;

        var url = 'sesproduct/cart/addtocart';
        new Request.JSON({
            url : url,
            data : {
                format: 'json',
                product_id:product_id,
            },
            onComplete : function(responseJSON) {
                sesJqueryObject(that).find('.loading_image').remove();
                showTipOnAddToCart(responseJSON);

                getCartValue();

            }
        }).send();
    }
});
function getCartValue() {
    sesJqueryObject.post('sesproduct/cart/product-cart',{},function (response) {
        if(sesJqueryObject('.sesproduct_cart_count').length){
            if(response > 0) {
                sesJqueryObject('.sesproduct_cart_count').show();
                var count = parseInt(sesJqueryObject('.sesproduct_cart_count').html());
                sesJqueryObject('.sesproduct_cart_count').html(response);
            }else{
                sesJqueryObject('.sesproduct_cart_count').hide();
                sesJqueryObject('.sesproduct_cart_count').html(0);
            }
        }
    });

}
function showTipOnAddToCart(responseJSON) {
    if(responseJSON.status == 1){
        showCartTooltip(10,10,'<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate(responseJSON.message))+'</span>', 'sesbasic_liked_notification');
    }else{
        //error
        showCartTooltip(10,10,'<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate(responseJSON.message))+'</span>', 'sesbasic_unlikedliked_notification');
    }
}
function showCartTooltip(x, y, contents, className) {
    if(sesJqueryObject('.sesbasic_notification').length > 0)
        sesJqueryObject('.sesbasic_notification').hide();
    sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
        display: 'block',
    }).appendTo("body").fadeOut(20000,'',function(){
        sesJqueryObject(this).remove();
    });
}
function setPriceConfiguration(obj) {
    var words = sesJqueryObject(obj).attr('limit');

	
    if(typeof words != "undefined" && words > 0){
        var elementCount = sesJqueryObject(obj).val();
        if(elementCount.length > words){
			console.log(elementCount.length);
			console.log(words);
            sesJqueryObject(obj).val(sesJqueryObject(obj).val().substring(0, words));
        }
    }
    if(en4.core.environment == "development") {
        console.log(sesJqueryObject(obj), words);
    }
    return true;
}
var callSesproductSubmitFromTrigger = false;
function getPriceConfiguration(obj) {
    if(sesJqueryObject('#sesproduct_add_to_cart').length){
        callSesproductSubmitFromTrigger = true;
        sesJqueryObject('#sesproduct_add_to_cart').trigger('submit');
    }
}
function checkProductVariationFormValidity(){
    var errorPresent = false;
    sesJqueryObject('#sesproduct_add_to_cart input, #sesproduct_add_to_cart select,#sesproduct_add_to_cart checkbox,#sesproduct_add_to_cart textarea,#sesproduct_add_to_cart radio').each(
        function(index){
            var input = sesJqueryObject(this);
            if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){
                if(sesJqueryObject(this).prop('type') == 'checkbox'){
                    value = '';
                    if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) {
                        value = 1;
                    };
                    if(value == '') {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        sesJqueryObject(this).css('border','');
                        error = false;
                    }
                }else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null) {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        error = false;
                        sesJqueryObject(this).css('border','');
                    }
                }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() === "0") {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        sesJqueryObject(this).css('border','');
                        error = false;
                    }
                }else if(sesJqueryObject(this).prop('type') == 'radio'){
                    if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '') {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        error = false;
                        sesJqueryObject(this).css('border','');
                    }
                }else if(sesJqueryObject(this).prop('type') == 'textarea') {
                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null) {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        error = false;
                        sesJqueryObject(this).css('border','');
                    }
                }else{
                    if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null) {
                        error = true;
                        sesJqueryObject(this).css('border','1px solid red');
                    }else {
                        error = false;
                        sesJqueryObject(this).css('border','');
                    }
                }
                if(error) {
                    errorPresent = true;
                }
                error = false;
            }
        }
    );
    return errorPresent ;
}
var ajaxSesproductRequest;
sesJqueryObject(document).on('submit','#sesproduct_add_to_cart',function (e) {
    e.preventDefault();
    var getPrice = 0;
    var url = 'sesproduct/cart/get-configuration-product-price';
    var addToCart = false;
    if(callSesproductSubmitFromTrigger == false){
        var isValid = checkProductVariationFormValidity();
        if(isValid == true){
            return false;
        }
        if(sesJqueryObject('#addtocart').find('.loading_image').length){
            return;
        }
        addToCart = true;
        var url = 'sesproduct/cart/addtocart-configuration-product';
        sesJqueryObject('#addtocart').prepend('<img class="loading_image" src="application/modules/Core/externals/images/loading.gif">');
        var that = this;
    }else{
        getPrice = 1;
    }
    if(ajaxSesproductRequest != null){
        ajaxSesproductRequest.abort();
    }
    callSesproductSubmitFromTrigger = false;
    var formData = new FormData(this);
    formData.append('getPrice',getPrice);
    formData.append('product_id',en4.core.subject.id);

    ajaxSesproductRequest = sesJqueryObject.ajax({
        type:'POST',
        dataType:'json',
        url: url,
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            if(addToCart == false) {
                if (response.status == 1) {
                    sesJqueryObject('.current_value').html(response.price);
                } else {
                    alert(response.message);
                    if (response.variation == 0) {

                    }
                }
            }else{
                sesJqueryObject('#addtocart').find('.loading_image').remove();
                showTipOnAddToCart(response);
                if(typeof response.href != "undefined"){
                    window.location.href = response.href;
                }
            }
            ajaxSesproductRequest = null;
        },
        error: function(data){
            ajaxSesproductRequest = null;
        }
    });
});
function markSesproductUnselectAll(obj) {
    var cartWrapper = sesJqueryObject('#addtocart-element').find('select');
    var elemIndex = cartWrapper.index(obj);
    cartWrapper.each(function (index) {
        if(sesJqueryObject(this).prop('type') == "select-one"){
            if(index > elemIndex){
                sesJqueryObject(this).html("<option value='0'>"+cartOptionValue+"</option>");
            }
        }
    });
}
var requestSespageVariation;
function getVariationAttribute(obj) {
    var elem = sesJqueryObject(obj);
    var id = sesJqueryObject(obj).attr('id').replace('select_','');
    markSesproductUnselectAll(obj);
    var nextObjectId = sesJqueryObject(obj).closest('.form-wrapper').next().attr('id');
    var nextFieldId = nextObjectId.replace('select_','').replace('-wrapper','');
    if(typeof requestSespageVariation != "undefined")
        requestSespageVariation.cancel();
    getPriceConfiguration(this);

    //send previous selected variations
    var cartWrapper = sesJqueryObject('#addtocart-element').find('select');
    var elemIndex = cartWrapper.index(obj);
    var previousSelectIds = "";
    cartWrapper.each(function (index) {
        if(sesJqueryObject(this).prop('type') == "select-one"){
            if(index < elemIndex){
                previousSelectIds = sesJqueryObject(this).val()+ ',' + previousSelectIds;
            }
        }
    });
    requestSespageVariation = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "sesproduct/cart/product-variation",
        'data': {
            format: 'html',
            'field_id':id,
            'option_id':sesJqueryObject(obj).val(),
            'product_id': en4.core.subject.id,
            'next_field_id':nextFieldId,
            'previousSelectIds':previousSelectIds,
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            if(responseHTML != ""){
                sesJqueryObject('#select_'+nextFieldId).html(responseHTML);
            }else{
                var optionFirst = sesJqueryObject('#select_'+nextFieldId).children().eq(0);
                sesJqueryObject('#select_'+nextFieldId).html(optionFirst);
            }
        }
    });
    requestSespageVariation.send();
}