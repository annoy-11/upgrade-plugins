<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: order-review.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<form id="courses_order_review_frm">
<div class="courses_checkout_step_content">
 <?php $_SESSION['courses_cart_checkout']['cart_total_price'] = array(0); ?>
  <div class="courses_cart_list">
    <?php foreach($this->cartData['coursesArray'] as $key => $cartCourses) {  ?>
      <ul>
          <?php foreach($cartCourses['course_id'] as $cart) { 
            $course = Engine_Api::_()->getItem('courses',$cart->course_id);
            if(!$course)
              Continue;
            $priceData = Engine_Api::_()->courses()->courseDiscountPrice($course);
          ?>
          <li class="courses_cart_list_item courses_cart_list_item_<?php echo $cart->cartcourse_id; ?>">
            <article class="sesbasic_bg sesbasic_clearfix">
              <div class="course_thumb">
                <a href="<?php echo $course->getHref(); ?>"><span class="bg_item_photo" style="background-image:url(<?php echo $course->getPhotoUrl('icon'); ?>);"></span></a>
              </div>
              <div class="course_info">
                <div class="course_title">
                  <?php echo $course->getTitle(); ?>
                </div>
                <?php if($course->classroom_id): ?>
                  <?php $classroom = Engine_Api::_()->getItem('classroom',$course->classroom_id); ?>
                  <div class="course_owner sesbasic_text_light">
                    <?php echo $this->translate('In'); ?>
                    <a href="<?php echo $classroom->getHref(); ?>"><?php echo $classroom->getTitle(); ?></a>
                  </div>
                <?php endif; ?>
                <div class="course_price">
                    <?php if(!empty($priceData['discountPrice']) && $priceData['discountPrice'] > 0){ ?>
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
            <a class="remove_item" id="course_cart_remove_item" onclick="getDeleteCartCourse('<?php echo $cart->cartcourse_id; ?>','<?php echo $course->classroom_id; ?>')" title="Remove"><i class="fa fa-times"></i></a>
            </article>
            <div class="courses_cart_list_item_bottom">
              <div class="_left">
                <div class="courses_cart_terms">
                  <input type="checkbox" id="termaccept_<?php echo $course->course_id; ?>" name ="termaccept_<?php echo $course->course_id; ?>" class="courses_accept_term_conditions" />
                  <label for="termaccept_<?php echo $course->course_id; ?>"><span style="display:none;color: 'red';">*</span><?php echo $this->translate('I agree with the.'); ?><a href="<?php echo $this->url(array('action'=>'course-policy','course_id'=>$course->course_id),'courses_dashboard',true);?>" target="_blank"><?php echo $this->translate('Terms and Conditions.'); ?></a>.</label>
                </div>
              </div>
              <div class="_right">
                <div class="courses_cart_list_item_price_box sesbasic_bg">
                  <ul>
                    <li>
                      <?php $taxes = Engine_Api::_()->getDbTable('taxstates','courses')->getOrderTaxes(array_merge(array('course_id'=>$course->course_id,'total_price'=>round($priceData['discountPrice'],2)),$_SESSION['courses_cart_checkout'])); ?>
                      <span><?php echo $this->translate('Billing Tax:'); ?></span>
                      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($taxes['total_tax'],2)) ; ?></span>
                    </li>
                    <li class="_total">
                      <span><?php echo $this->translate('Subtotal:'); ?></span>
                      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round($priceData['discountPrice']+$taxes['total_tax'],2)) ; ?></span>
                    </li>
                    <?php $_SESSION['courses_cart_checkout']['cart_total_price'][$course->course_id] = round($priceData['discountPrice']+$taxes['total_tax'],2); ?>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        <?php }  ?>
          <?php if(!empty(@$key) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')): ?>
              <div class="courses_cart_coupon_link">
                <b><?php echo $this->translate("Have a coupon?");?></b> <a href="javascript:;" onclick="showCoupon('<?php echo $key; ?>')" ><?php echo $this->translate("Click here to enter your code");?></a>
              </div>
              <div class="courses_cart_coupon_box" id="courses_cart_coupon_box_<?php echo $key; ?>" style="display:none;">
                <p><?php echo $this->translate("If you have a coupon code, please apply it below.");?></p>
                <div class="courses_cart_coupon_box_field" >
                  <div class="_input"><input type="text" id="coupon_code_value_<?php echo $key; ?>" name="coupon_code_value_<?php echo $key; ?>" /></div>
                  <div class="_btn"><button onclick="applyCouponcode('<?php echo $key; ?>',event)"><?php echo $this->translate("Apply Coupon");?></button></div>
                </div>
                <div class="_errormsg" id="coupon_error_msg_<?php echo $key; ?>" ></div>
              </div>
          <?php endif; ?>
      </ul>
    <?php } ?>
  </div>
</div>
</form>
<div class="courses_checkout_step_footer">
  <div class="_left">
    <!--<a href=""><i class="fa fa-angle-left"></i><span>Back</span></a>-->
  </div>
  <div class="_right">
    <span class="gtotal"><?php echo $this->translate('Total:'); ?><b id="totalamount"><?php echo Engine_Api::_()->courses()->getCurrencyPrice(round(array_sum($_SESSION['courses_cart_checkout']['cart_total_price']),2)) ; ?></b></span>
    <button id="courses_cart_order_overview"></i><span><?php echo $this->translate('Continue'); ?></span></button>
  </div>
</div>
<?php die; ?>
