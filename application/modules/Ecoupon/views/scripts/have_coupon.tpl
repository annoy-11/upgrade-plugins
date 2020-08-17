<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Ecoupon
 * @package    Ecoupon
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _customdates.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $key = $this->id; ?>
  <div style ="display:none" id ="coupon_applied_<?php echo $key; ?>">
    <ul>
      <li>
        <span><?php echo $this->translate('Item Amount'); ?></span>
        <span id="item_actual_amount_<?php echo $key; ?>"></span>
      </li>
      <li>
        <span><?php echo $this->translate('Discount Amount'); ?></span>
        <span id="item_discount_amount_<?php echo $key; ?>"></span>
      </li>
      <li>
        <span><?php echo $this->translate('Current Amount'); ?></span>
        <span id="item_current_amount_<?php echo $key; ?>"></span>
      </li>
    </ul>
  </div>
  <div class="ecoupon_coupon_link">
    <b><?php echo $this->translate("Have a coupon?");?></b> <a href="javascript:;" onclick="showCoupon<?php echo $key; ?>('<?php echo $key; ?>')" ><?php echo $this->translate("Click here to enter your code");?></a>
  </div>
  <div class="ecoupon_coupon_box" id="ecoupon_coupon_box_<?php echo $key; ?>" style="display:none;">
    <p><?php echo $this->translate("If you have a coupon code, please apply it below.");?></p>
    <div class="ecoupon_coupon_box_field" >
      <div class="_input"><input type="text" id="coupon_code_value_<?php echo $key; ?>" data-amount = "" name="coupon_code_value_<?php echo $key; ?>" /></div>
      <div class="_btn"><button onclick="applyCouponcode<?php echo $key; ?>('<?php echo $key; ?>',event)" id="apply_coupon_code_<?php echo $key; ?>"><?php echo $this->translate("Apply Coupon");?></button></div>
    </div>
    <div class="_errormsg" id="coupon_error_msg_<?php echo $key; ?>" ></div>
  </div>
<script type="application/javascript">
function showCoupon<?php echo $key; ?>(id){
  sesJqueryObject('#ecoupon_coupon_box_'+id).toggle();
}
function applyCouponcode<?php echo $key; ?>(key,event) {
    event.preventDefault();
    if(!sesJqueryObject("#coupon_code_value_" +key).val())
      return false;
    var that = sesJqueryObject(this);
    new Request.HTML({
    method: 'post',
    format: 'html',
    'url': en4.core.baseUrl + 'ecoupon/index/apply-coupon',
    'data': {
        coupon_code: sesJqueryObject("#coupon_code_value_" +key).val(),
        item_amount: sesJqueryObject("#coupon_code_value_" +key).attr('data-amount'),
        params: '<?php echo $this->params; ?>',
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        var obj = jQuery.parseJSON(responseHTML);
        if(obj.status){
          sesJqueryObject('#item_actual_amount_'+key).html(obj.item_actual_amount);
          sesJqueryObject('#item_current_amount_'+key).html(obj.item_discounted_amount);
          sesJqueryObject('#item_discount_amount_'+key).html(obj.discount_amount);
          if(typeof itemPrice<?php echo $key; ?> != 'undefined'){
            itemPrice<?php echo $key; ?> = obj.item_discounted_amount;
          }
          sesJqueryObject('#coupon_applied_'+key).show();
          sesJqueryObject('#coupon_error_msg_'+key).hide();
          showCouponTooltip(10,10,'<i class="fa fa-check-circle"></i><span>'+(en4.core.language.translate('Coupon code copied successfully'))+'</span>', 'sesbasic_liked_notification');
        } else {
          sesJqueryObject('#coupon_applied_'+key).hide();
          sesJqueryObject('#coupon_error_msg_'+key).html("<b>"+obj.message+"</b>");
          sesJqueryObject('#coupon_error_msg_'+key).show();
        }
        if(typeof sesJqueryObject('#sescredit_apply_credit_'+key) != 'undefined'){
          sesJqueryObject('#sescredit_apply_credit_'+key).trigger('click');
        } 
        if(typeof couponApplied<?php echo $key; ?> == 'function'){
            couponApplied<?php echo $key; ?>(obj);
        }
    }
  }).send();
}
function showCouponTooltip(x, y, contents, className) {
    if(sesJqueryObject('.sesbasic_notification').length > 0)
        sesJqueryObject('.sesbasic_notification').hide();
    sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
        display: 'block',
    }).appendTo("body").fadeOut(20000,'',function(){
        sesJqueryObject(this).remove();
    });
}
</script>
