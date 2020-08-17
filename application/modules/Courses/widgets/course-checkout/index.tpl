<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php $viewer = $this->viewer(); ?>
<?php $counties = Engine_Api::_()->getDbTable('countries','courses')->getCountries(); ?>
<?php
    $viewer_id = $this->viewer()->getIdentity();
    //get details
    if($viewer_id){
        $addressTable = Engine_Api::_()->getDbTable('addresses','courses');
        $userAddress = $addressTable->getAddress(array('user_id'=>$viewer_id));
    } 
?>
<div class="courses_checkout_main sesbasic_bxs">
	<div class="courses_checkout_main_content">
    <!--Billing Form-->
  	<section class="courses_checkout_step courses_checkout_step_billing sesbasic_bg courses_checkout_step_active">
    	<div class="courses_checkout_step_head">
      	<div class="_label"><?php echo $this->translate('Billing Address'); ?></div>
        <div class="_link">
          <a href="javascript:;" class="editlink"><?php echo $this->translate('Edit'); ?></a>
        </div>
      </div>
      <form id="courses_billing_frm">
        <div class="courses_checkout_step_content">
          <div class="courses_checkout_billing_form">
            <div class="courses_checkout_billing_form_field">
              <label for="firstname"><?php echo $this->translate('First Name'); ?></label>
              <div class="_input">
                <input type="text" id="firstname" name="first_name" value="<?php echo (!empty($userAddress)) ? $userAddress->first_name : ''; ?>" placeholder="Please enter your first name." />
              </div>
              <p class="_errormsg"><?php echo $this->translate('Starting letter should be in capital. It should only accept alphabets.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="lastname"><?php echo $this->translate('Last Name'); ?></label>
              <div class="_input">
                <input type="text" id="lastname" name="last_name" value="<?php echo (!empty($userAddress)) ? $userAddress->last_name : ''; ?>" placeholder="Please enter your last name." />
              </div>
              <p class="_errormsg"><?php echo $this->translate('Starting letter should be in capital. It should only accept alphabets.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="email"><?php echo $this->translate('Email'); ?></label>
              <div class="_input">
                <input type="email" id="email" name="email" value="<?php echo (!empty($userAddress)) ? $userAddress->email : ''; ?>" placeholder="Please provide your valid email address." />
              </div>
              <p class="_errormsg"><?php echo $this->translate("Please complete this field - it is required.");  ?></p>
              <p class="_errormsg"><?php echo $this->translate('The email Id entered is not valid. Please enter other email Id.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="country"><?php echo $this->translate('Select Country'); ?></label>
              <div class="_input">
                <select id="country" class="country_courses" onchange="getStates(this)" name="country">
                <option value=""><?php echo $this->translate('Select Country'); ?></option>
                <?php foreach($counties as $country){ ?>
                  <option value="<?php echo $country['country_id']; ?>" <?php echo !empty($userAddress) && $userAddress->country == $country['country_id'] ? "selected" : ""; ?> ><?php echo $country['name']; ?></option>
                <?php } ?>
                </select>
              </div>
              <p class="_errormsg"><?php echo $this->translate('Please select your country from the select box.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="state"><?php echo $this->translate('Select State'); ?></label>
              <div class="_input">
                <select id="state" data-rel="<?php echo (!empty($userAddress)) ? $userAddress->state : ''; ?>" name="state">
                  <option value=""><?php echo $this->translate('Select State');  ?></option>
                </select>
              </div>
              <p class="_errormsg"><?php echo $this->translate('Please select your state from the select box.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="city"><?php echo $this->translate('City'); ?></label>
              <div class="_input">
                <input type="text" id="city" name="city" value="<?php echo (!empty($userAddress)) ? $userAddress->city : ''; ?>" placeholder="Enter your city" />
              </div>
              <p class="_errormsg"><?php echo $this->translate('Please enter your city.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="address"><?php  echo $this->translate('Address'); ?></label>
              <div class="_input">
                <input type="text" id="address" name="address" value="<?php echo (!empty($userAddress)) ? $userAddress->address : ''; ?>" placeholder="Enter your full address." />
              </div>
            </div>
            <div class="courses_checkout_billing_form_field courses_checkout_billing_form_field_pnumber">
              <label for="city"><?php echo $this->translate('Phone Number'); ?></label>
              <div class="_input">
               <!-- <span class="_code">
                  <select>
                    <option>+91</option>
                    <option>+1</option>
                  </select>
                </span>  -->
                <span class="_text">
                  <input type="text" id="" name="phone_number" value="<?php echo (!empty($userAddress)) ? $userAddress->phone_number : ''; ?>" placeholder="Enter your contact number." />
                </span>
              </div>
              <p class="_errormsg"><?php echo $this->translate('Please enter valid phone number.'); ?></p>
            </div>
            <div class="courses_checkout_billing_form_field">
              <label for="pincode"><?php echo $this->translate('ZIP/PIN Code'); ?></label>
              <div class="_input">
                <input type="text" id="pincode" name="zip_code" value="<?php echo (!empty($userAddress)) ? $userAddress->zip_code : ''; ?>" placeholder="Please enter valid code" />
              </div>
              <p class="_errormsg"><?php echo $this->translate('Please enter valid area code.'); ?></p>
            </div>
          </div>
        </div>
        <div class="courses_checkout_step_footer">
          <div class="_left">
          </div>
          <div class="_right">
            <button id="courses_cart_billing_address"><span><?php echo $this->translate('Continue'); ?></span></button>
          </div>
        </div>
      </form>
    </section>

    <!--Order Review-->
    <section class="courses_checkout_step courses_checkout_step_order_review sesbasic_bg">
      <div class="courses_checkout_step_head">
        <div class="_label"><?php echo $this->translate('Order Review.'); ?></div>
        <div class="_link" style="display:none">
          <a href="javascript:;" class="editlink"><?php echo $this->translate('Edit'); ?></a>
        </div>
      </div>
      <div class="courses_checkout_step_order_review_body">
      </div>
    </section>

    <!--Payment Method-->
    <section class="courses_checkout_step courses_checkout_step_payment sesbasic_bg">
      <?php if(!$this->noPaymentGatewayEnableByAdmin): ?>
      <form id="courses_order_payment_frm">
        <div class="courses_checkout_step_head">
          <div class="_label"><?php echo $this->translate('Payment Method'); ?></div>
        </div>
        <div class="courses_checkout_step_content">
          <div class="courses_checkout_choose_payment">
            <ul>
              <?php if(in_array('paypal',$this->paymentMethods)){ ?>
                <li>
                  <label class="selection_field" for="paypal">
                    <input type="radio" name="payment_type" id="paypal" value="paypal">
                    <span>
                      <img src="application/modules/Courses/externals/images/paypal.png" />  
                    </span>
                  </label>
                </li>
              <?php } ?>
              <?php if(in_array('stripe',$this->paymentMethods)){ ?>
                <li>
                  <label class="selection_field" for="stripe">
                    <input type="radio" name="payment_type" id="stripe" value="stripe">
                    <span>
                      <img src="application/modules/Courses/externals/images/stripe.png" />  
                    </span>
                  </label>
                </li>
              <?php } ?>
              <?php if(in_array('paytm',$this->paymentMethods)){ ?>
                <li>
                  <label class="selection_field" for="paytm">
                    <input type="radio" name="payment_type" id="paytm" value="paytm">
                    <span>
                      <img src="application/modules/Courses/externals/images/paytm.png" />  
                    </span>
                  </label>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class="courses_checkout_step_footer">
          <div class="_left">
          </div>
          <div class="_right">
            <span class="gtotal"><?php echo $this->translate('Total:'); ?><b><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round(array_sum($_SESSION['courses_cart_checkout']['cart_total_price']),2)) ; ?></b></span>
            <button id="courses_cart_order_payment"></i><span><?php echo $this->translate('Place Order'); ?></span></button>
          </div>
        </div>
      </form>
      <?php else: ?>
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/no-gateway-enabled.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('Payment Gateway not Enabled in this Course'); ?>
            </span>
          </div>
      <?php endif; ?>
    </section>
   <!--Payment Method  End-->
  </div>	
  <div class="courses_checkout_sidebar">
  	<article class="sesbasic_bg">
    	<div class="courses_checkout_sidebar_head">
      	<?php echo $this->translate('Your Item(%s)',$this->cartData['cartCoursesCount']); ?> 
      </div>
      <ul class="courses_checkout_order_items">
        <?php foreach($this->cartData['cartCourses'] as $cart) { 
          $course = Engine_Api::_()->getItem('courses',$cart->course_id);
          if(!$course) {
            echo $course->course_id;
            Continue;
          }
          $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course);
        ?>
          <li class="courses_cart_list_item_<?php echo $cart->cartcourse_id; ?>" >
            <div class="_thumb">
              <img src="<?php echo $course->getPhotoUrl('icon'); ?>" />
            </div>
            <div class="_info">
              <div class="_title">
                <?php echo $course->getTitle(); ?>
              </div>
              <?php if($course->classroom_id):?>
                <?php $classroom = Engine_Api::_()->getItem('classroom',$course->classroom_id); ?>
                <div class="_owner sesbasic_text_light">
                  <?php echo $this->translate('In'); ?>
                  <a href="<?php echo $classroom->getHref(); ?>"><?php echo $classroom->getTitle(); ?></a>
                </div>
              <?php endif; ?>
              <div class="_price">
                   <?php if(!empty($priceData['discountPrice'])){ ?>
                    <span class="_ps"><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($priceData['discountPrice'],2)) ; ?></span>
                <?php } else { ?>
                  <span class="_ps"><?php echo $this->translate("Free "); ?></span>
                <?php } ?>
                <?php if($priceData['discount'] > 0){ ?>
                  <?php if($course->discount_type == 0){ ?>
                    <span class="_pc sesbasic_text_light"><?php echo $this->translate("%s%s OFF",str_replace('.00','',$priceData['discount']),"%"); ?></span>
                  <?php } else { ?>
                    <span class="_pc sesbasic_text_light"><?php echo $this->translate("%s OFF",Engine_Api::_()->courses()->getCurrencyPrice($priceData['discount'])); ?></span>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </li>
        <?php } ?>
      </ul>
      <div class="courses_checkout_order_total">
        <span class="_label"><?php echo $this->translate('Total Payable:'); ?></span>
        <span class="_amt"><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($this->cartData['totalPrice'],2)) ; ?></span>
      </div>
    </article>
  </div>
</div>
<script type="application/javascript">
    sesJqueryObject(document).ready(function (e) {
        sesJqueryObject('.country_courses').trigger('onchange');
    });
    function getStates(obj) {
        var value = obj.value;
        var selectedVal = sesJqueryObject('#state').data('rel');
        if(!sesJqueryObject(obj).parent().find('.loading_image').length){
            sesJqueryObject(obj).parent().append('<img class="loading_image" src="application/modules/Core/externals/images/large-loading.gif">');
        }
        sesJqueryObject.post('courses/cart/get-state',{country_id:value,selected:selectedVal},function (response) {
            sesJqueryObject(obj).parent().find('.loading_image').remove();
            sesJqueryObject('#state').removeAttr('data-rel');
            sesJqueryObject('#state').html(response);
        })
    }
    function getDeleteCartCourse(cartId,classroomId) {
      var confirmDelete = confirm("<?php echo $this->translate('Are you sure you want to delete?'); ?>");
      if(confirmDelete){
          var that = sesJqueryObject(this);
          that.html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
          ajaxDeleteRequest = (new Request.HTML({
          method: 'post',
          format: 'html',
          'url': en4.core.baseUrl + 'courses/cart/view',
          'data': {
              id: cartId,
              isAjax : 1,
              classroom_id : classroomId,
              isDelete: 1,
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
              var obj = jQuery.parseJSON(responseHTML);
              if(obj.status == "1") {
                sesJqueryObject('.courses_cart_list_item_'+cartId).remove();
                sesJqueryObject('.courses_checkout_sidebar_head').html(en4.core.language.translate(obj.cartCountMessage));
                sesJqueryObject('.courses_checkout_sidebar').children().find('._amt').html(obj.cartTotalPrice);
                sesJqueryObject('.courses_checkout_step_footer').children().find('b').html(obj.cartTotalAmount);
              } else
                that.html('<i class="fa fa-times"></i>');
              if(obj.cartCoursesCount <= 0)
                window.location.href = '<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'browse'), 'courses_general', false); ?>';
          }
        })).send();
      }
    }
    function submitAddressForm(){
      var isValid = true;
      //check all mandatory fields
      sesJqueryObject('#courses_billing_frm').find('input, select, textarea, email').each(function() {
        var value = sesJqueryObject(this).val();  
        var prop = sesJqueryObject(this).prop('type');
        if(prop != "email") {
            if (!value) { 
                isValid = false;
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').show();
            } else {
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').hide();
            }
        }else{
            if (!value) {
                isValid = false;
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').eq(0).show();
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').eq(1).hide();
            }else if(!isCoursesCheckEmail(value)){
                isValid = false; 
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').eq(1).show();
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').eq(0).hide();
            }else { 
                sesJqueryObject(this).parents('.courses_checkout_billing_form_field').find('._errormsg').eq(0).hide();
            }
        }
      });
      return isValid;
    }
    function isCoursesCheckEmail(email){ 
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }
    var requestedTab = "undefined";
    sesJqueryObject(document).on('click', '#courses_cart_billing_address', function (e) { 
        e.preventDefault();
        if(requestedTab != "undefined")
          return false;
        sesJqueryObject(this).append('<i class="fa fa-spinner fa-spin fa-fw margin-bottom"></i>');
        var that = this;
        formData = sesJqueryObject('#courses_billing_frm').serialize();
          if(!submitAddressForm())
            return false;
          
        requestedTab = (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + 'courses/cart/set-billing-address',
            'data': {
              format: 'html',
              formData:formData,
            },
            onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject(that).children('i').remove();
                sesJqueryObject('.courses_checkout_step').each(function(e) {
                  if(e == 1)
                   sesJqueryObject(this).addClass('courses_checkout_step_active');
                  else 
                    sesJqueryObject(this).removeClass('courses_checkout_step_active');
                });
                sesJqueryObject('.courses_checkout_step_order_review_body').html(responseHTML); 
                requestedTab = "undefined";
              return true;
            }
          })).send();
    }); 
    var tremCondition;
    sesJqueryObject(document).on('click', '#courses_cart_order_overview', function (e) { 
        e.preventDefault();
        var acceptedTerms = true;
        sesJqueryObject(this).append('<i class="fa fa-spinner fa-spin fa-fw margin-bottom"></i>');
        tremCondition = sesJqueryObject('#courses_order_review_frm').serialize();
        var checkboxes = sesJqueryObject('.courses_accept_term_conditions');
        checkboxes.each(function (e) {
          var errorMessage = sesJqueryObject(this).parent().find('.error_message');
              if(sesJqueryObject(this).prop('checked') == false){
                  acceptedTerms = false;
                  sesJqueryObject(this).parents('.courses_cart_terms').find('span').show();
              }else{
                   sesJqueryObject(this).parents('.courses_cart_terms').find('span').hide();
              }
          });
          sesJqueryObject(this).children('i').remove();
          if(!acceptedTerms){
            return false;
          }
          sesJqueryObject('.courses_checkout_step_footer').children().find('b').html(sesJqueryObject('#totalamount').html());
          sesJqueryObject('.courses_checkout_step').each(function(e) {
                  if(e == 2)
                   sesJqueryObject(this).addClass('courses_checkout_step_active');
                  else 
                    sesJqueryObject(this).removeClass('courses_checkout_step_active');
          });
          sesJqueryObject('.courses_checkout_step_order_review').children().find('._link').show();
    });
    var coursePaymentRequest;
    sesJqueryObject(document).on('click', '#courses_cart_order_payment', function (e) { 
      e.preventDefault();
        formData = sesJqueryObject('#courses_order_payment_frm').serialize();
        coursePaymentRequest = (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + 'courses/cart/checkout',
            'data': {
              format: 'html',
              formData:formData,
              overviewFormData: sesJqueryObject('#courses_order_review_frm').serialize(),
              paymetRequest: 1,
            },
            onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
              sesJqueryObject(this).children('i').remove();
              var response = jQuery.parseJSON(responseHTML);
              sesJqueryObject(this).children().remove();
              if(response.status == 1){
                 window.location.href = response.url;
              } else {
                if(!sesJqueryObject('.courses_checkout_step_payment').hasClass('error'))
                  sesJqueryObject('.courses_checkout_step_payment').addClass('error');
              }
              return true;
            }
        })).send();
    }); 
    sesJqueryObject(document).on('click', '.editlink', function (e) { 
        sesJqueryObject('.courses_checkout_step').each(function(e) {
            if(sesJqueryObject(this).find('.courses_checkout_step_active'))
             sesJqueryObject(this).removeClass('courses_checkout_step_active');
        });
        sesJqueryObject(this).parents('.courses_checkout_step').addClass('courses_checkout_step_active');
    });
    function showCoupon(id){
      sesJqueryObject('#courses_cart_coupon_box_'+id).toggle();
    }
    function applyCouponcode(classsroom_id,event) {
          event.preventDefault();
          if(!sesJqueryObject("#coupon_code_value_" +classsroom_id).val())
            return false;
          var that = sesJqueryObject(this);
          new Request.HTML({
          method: 'post',
          format: 'html',
          'url': en4.core.baseUrl + 'courses/cart/apply-coupon',
          'data': {
              coupon_code: sesJqueryObject("#coupon_code_value_" +classsroom_id).val(),
              classroom_id: classsroom_id
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
              var obj = jQuery.parseJSON(responseHTML);
              if(obj.status == "1") {
                sesJqueryObject('.courses_checkout_sidebar_head').html(en4.core.language.translate(obj.cartCountMessage));
                sesJqueryObject('.courses_checkout_sidebar').children().find('._amt').html(obj.cartTotalPrice);
                sesJqueryObject('.courses_checkout_step_footer').children().find('b').html(obj.cartTotalAmount);
                sesJqueryObject('#coupon_applied_'+classsroom_id).show();
                sesJqueryObject('#coupon_error_msg_'+classsroom_id).hide();
                showCouponTooltip(10,10,'<i class="fa fa-check-circle"></i><span>'+(en4.core.language.translate('Coupon code copied successfully'))+'</span>', 'sesbasic_liked_notification');
              } else {
                that.html('<i class="fa fa-times"></i>');
                sesJqueryObject('#coupon_applied_'+classsroom_id).hide();
                sesJqueryObject('#coupon_error_msg_'+classsroom_id).html("<b>"+obj.message+"</b>");
                sesJqueryObject('#coupon_error_msg_'+classsroom_id).show();
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
