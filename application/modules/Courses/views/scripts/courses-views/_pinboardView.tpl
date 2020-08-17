<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _pinboardView.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['pinboard_title_truncation'])):?>
    <?php $titleLimit = $this->params['pinboard_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($course->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($course->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $course->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->pinboarddescriptionActive)):?>
  <?php $descriptionLimit = $this->params['pinboard_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $course->getOwner();?>
<li class="courses_pinboard_item" style="width:<?php echo $width; ?>px;">
  <article class="sesbasic_clearfix">
    <div class="_thumb courses_thumb">
      <div class="_img">
      <a href="<?php echo $course->getHref(); ?>" class="courses_thumb_img">
        <img src="<?php echo $course->getPhotoUrl('thumb.profile'); ?>">
      </a>
      </div>
      <div class="courses_labels">
        <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataLabel.tpl';?>
      </div>
      <div class="_btns sesbasic_animation">
        <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataSharing.tpl';?>
        <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
      </div>
    </div>
    <div class="_cont">
      <div class="price_header">
          <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_coursePrice.tpl';?>
      </div>
      <?php if(!empty($title)): ?>
        <div class="_title">
            <a href="<?php echo $course->getHref(); ?>"><?php echo $title; ?></a>
        </div>    
      <?php endif;?>
      <?php if(isset($this->classroonNamePhotoActive)):?>
          <?php  $classroom = Engine_Api::_()->getItem('classroom', $course->classroom_id); ?>
      <?php endif;?>
      <?php if((isset($category) && isset($this->categoryActive)) || isset($this->byActive)): ?>
        <div class="owner sesbasic_text_light">
            <!--   classroom work       -->
            <?php if(!empty($classroom)): ?> 
              &nbsp;<?php echo $this->htmlLink($classroom->getHref(), $this->itemPhoto($classroom, 'thumb.icon', $classroom->getTitle()), array('title'=>$classroom->getTitle())) ?><?php echo $this->htmlLink($classroom->getHref(), $classroom->getTitle()) ?>
            <?php endif;?>
            
            <?php if(isset($category) && isset($this->categoryActive)): ?> 
              <?php echo $this->translate('Posted in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
            <?php endif;?>
            <?php if(isset($this->byActive)): ?> 
              <?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
            <?php endif;?>   
        </div>
      <?php endif;?> 
      <?php if($this->ratingActive): ?>
        <div class="_rating sesbasic_rating_star">
            <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>
        </div>
      <?php endif; ?>
       <div class="courses_options">
          <div class="_left">
            <?php if(isset($this->addCartActive)):?>
               <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_addToCart.tpl';?>
            <?php endif; ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.wishlist', 1) && Engine_Api::_()->courses()->allowAddWishlist() && isset($this->addWishlistActive)): ?>
              <a href="javascript:;" data-rel="<?php echo $course->getIdentity(); ?>" class="courses_wishlist" data-rel="<?php echo $course->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i> <?php echo $this->translate('Add to wishlist'); ?></a>
            <?php endif; ?>
          </div>
          <?php if(isset($this->addCompareActive)):?>
            <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_addToCompare.tpl';?>
          <?php endif; ?>
      </div>
      <div class="bottom_stats">
      <div class="_stats">
        <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_data.tpl';?>
      </div>
      <div class="_counts">
        <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
      </div>
      </div>
    </div>
  </article>
</li>
