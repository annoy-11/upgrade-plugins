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
<?php $descriptionLimit = 0;?>
<?php if(isset($this->listdescriptionActive)):?>
<?php $descriptionLimit = $this->params['list_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)): ?>
<?php $descriptionLimit = $this->params['description_truncation']; ?>
<?php endif;?>
<?php $course = $this->course; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php $owner = $this->course->getOwner();?>
<div class="courses_single_view sesbasic_bxs sesbasic_clearfix">
  <div class="course_header">
    <div class="_left"> 
      <?php if(isset($this->titleActive)):?>
        <span class="_title">
          <a href="<?php echo $this->course->getHref(); ?>">
            <?php echo $this->course->getTitle(); ?>
          </a>
        </span> 
      <?php endif;?>
       <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_coursePrice.tpl';?>
    </div>
    <?php if(isset($this->addCompareActive)):?>
      <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_addToCompare.tpl';?>
    <?php endif;?>
  </div>
  <?php if(isset($this->descriptionActive)):?>
    <div class="course_des">
      <?php echo $course->description; ?>
    </div>
  <?php endif;?>
  <?php if(!$this->noPaymentGatewayEnableByAdmin || isset($this->purchaseNoteActive)): ?>
      <div class="course_payment_images">
        <?php if(!$this->noPaymentGatewayEnableByAdmin):?>
        <h4>Payment Accepted by</h4>
          <?php if(in_array('paypal',$this->paymentMethods)){ ?>
            <img src="application/modules/Courses/externals/images/paypal.png" />
          <?php } ?>
          <?php if(in_array('stripe',$this->paymentMethods)){ ?>
            <img src="application/modules/Courses/externals/images/stripe.png" />
          <?php } ?>
          <?php if(in_array('paytm',$this->paymentMethods)){ ?>
            <img src="application/modules/Courses/externals/images/paytm.png" />
          <?php } ?>
        <?php endif; ?>
        <?php if(isset($this->purchaseNoteActive)):?>
          <p class="sesbasic_text_light"><?php echo $course->purchase_note; ?></p>
        <?php endif; ?>
      </div>
  <?php endif; ?>
  <div class="mid_cont">
    <?php if(isset($this->classroonNamePhotoActive)):?>
      <?php  $classroom = Engine_Api::_()->getItem('classroom', $this->course->classroom_id); ?>
      <?php if(!empty($classroom)): ?>
        <div class="_instructor">
          <div class="_img"><?php echo $this->htmlLink($classroom->getHref(), $this->itemPhoto($classroom, 'thumb.icon', $classroom->getTitle()), array('title'=>$classroom->getTitle())) ?></div>
          <div class="_cont">
            <div class="_name"><?php echo $this->translate('Classroom:'); ?></div>
            <div class="_value"><?php echo $this->htmlLink($classroom->getHref(), $classroom->getTitle()) ?></div>
          </div>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if(isset($this->byActive)):?>
      <div class="_instructor">
        <div class="_img"><?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?></div>
        <div class="_cont">
          <div class="_name"><?php echo $this->translate('Instructor:'); ?></div>
          <div class="_value"><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></div>
        </div>
      </div>
    <?php endif;?>
    <?php if(isset($this->categoryActive)):?>
      <div class="_category">
        <div class="_name"><?php $this->translate('Category:'); ?></div>
        <?php $category = Engine_Api::_()->getItem('courses_category',$this->course->category_id); ?>
        <?php if($category):?>
          <div class="_value sesbasic_text_light"><a href="<?php echo $category->getHref(); ?>"><i class="fa fa-folder-open"></i> <?php echo $category->category_name; ?></a></div>
        <?php endif;?>
      </div>
    <?php endif;?>
    <?php if(isset($this->ratingActive)):?>
      <div class="_reviews">
        <div class="_name"><?php $this->translate('Reviews:'); ?></div>
        <div class="_value">
          <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>
        </div>
      </div>
    <?php endif;?>
    <div class="_buy"><a href="javascript:;"  data-url="<?php echo $this->url(array('action'=>'checkout'),'courses_cart',true); ?>" data-buy="1" class="course_addtocart" data-action="<?php echo $course->course_id; ?>"><?php echo $this->translate('Buy course'); ?></a></div>
  </div>
  <div class="bottom_cont">
    <div class="add_btns"> 
      <?php if(isset($this->addCartActive)):?>
        <span class="_cart">
          <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_addToCart.tpl';?>
        </span> 
      <?php endif; ?>
      <span class="_wishlist">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.wishlist', 1) && Engine_Api::_()->courses()->allowAddWishlist() && isset($this->addWishlistActive)): ?>
          <a href="javascript:;" data-rel="<?php echo $course->getIdentity(); ?>" class="courses_wishlist" data-rel="<?php echo $course->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i> <?php echo $this->translate('Add to wishlist'); ?></a>
        <?php endif; ?>
      </span> 
    </div>
    <div class="bottom_btns">
    <div class="_stats"> 
      <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
    </div>
    <div class="_btns"> 
      <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataSharing.tpl';?>
      <!--Like Button--> 
      <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
    </div>
   </div>
  </div>
  <?php if(isset($this->coursePhotoActive)):?>
    <div class="course_single_img"  style="height:<?php echo is_numeric($this->params['maxHeight']) ? $this->params['maxHeight'].'px' : $this->params['maxHeight']; ?>"><img src="<?php echo $this->course->getPhotoUrl('thumb.profile'); ?>" /> </div>
  <?php endif; ?>
</div>
