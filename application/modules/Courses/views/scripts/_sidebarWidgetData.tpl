<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _sidebarWidgetData.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); 
?>
<?php $height = $this->params['height'];?>
<?php $width = $this->params['width'];?>
<?php foreach( $this->results as $course ): ?>
  <?php $title = ''; ?>
  <?php if(isset($this->titleActive)):?>
    <?php if(isset($this->params['grid_title_truncation'])):?>
      <?php $titleLimit = $this->params['grid_title_truncation'];?>
    <?php else:?>
      <?php $titleLimit = $this->params['title_truncation'];?>
    <?php endif;?>
    <?php if(strlen($course->getTitle()) > $titleLimit): ?>
      <?php $title = mb_substr($course->getTitle(),0,$titleLimit).'...'; ?>
    <?php else:?>
      <?php $title = $course->getTitle();?>
    <?php endif; ?>
  <?php endif;?>
  <?php $descriptionLimit = 0;?>
  <?php if(isset($this->listdescriptionActive)):?>
    <?php $descriptionLimit = $this->params['list_description_truncation'];?>
  <?php elseif(isset($this->descriptionActive)):?>
    <?php $descriptionLimit = $this->params['description_truncation'];?>
  <?php endif;?>
  <?php $owner = $course->getOwner();  ?>
  <?php if (!empty($course->category_id)): ?>
    <?php $category = Engine_Api::_ ()->getDbtable('categories', 'courses')->find($course->category_id)->current();?>
  <?php endif;?> 
	<?php if($this->view_type == 'list'):?>
		<li class="courses_list_item">
      <article class="sesbasic_clearfix">
        <div class="_thumb courses_thumb" style="width:<?php echo is_numeric($width) ? $width.'px' : $width; ?>; height:<?php echo is_numeric($height) ? $height.'px' : $height; ?>">
          <a href="<?php echo $course->getHref(); ?>" class="courses_thumb_img">
            <span style="background-image:url('<?php echo $course->getPhotoUrl('thumb.profile'); ?>');"></span>
          </a>
          <div class="courses_labels">
            <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataLabel.tpl';?>
          </div>
          <div class="_btns sesbasic_animation">
            <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
          </div>
        </div>
        <div class="_cont">
          <div class="price_header">
              <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_coursePrice.tpl';?>
              <?php if($this->ratingActive): ?>
                <div class="sesbasic_rating_star">
                  <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>
                </div>
              <?php endif;?>
          </div>
          <?php if(!empty($title)): ?>
            <div class="_title">
                <a href="<?php echo $course->getHref(); ?>"><?php echo $title; ?></a>
            </div>    
          <?php endif;?>
          <?php if((isset($category) && isset($this->categoryActive)) || isset($this->byActive)): ?>
            <div class="owner sesbasic_text_light">
                <?php if(isset($category) && isset($this->categoryActive)): ?> 
                  <?php echo $this->translate('Posted in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
                <?php endif;?>
                <?php if(isset($this->byActive)): ?> 
                  <?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
                <?php endif;?>   
            </div>
          <?php endif;?> 
          <?php if($descriptionLimit):?>
            <div class="_des sesbasic_text_light">
              <?php echo $this->string()->truncate($this->string()->stripTags($course->description), $descriptionLimit) ?>
            </div>
          <?php endif;?>
          <div class="courses_footer">
            <div class="_stats">
                <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_data.tpl';?>
            </div>
            <div class="_counts">
              <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
            </div>
        </div>
      </article>
    </li>
	<?php elseif($this->view_type == 'grid'): ?>
		<li class="courses_grid_item" style="width:<?php echo is_numeric($width) ? $width.'px' : $width; ?>;">
      <article class="sesbasic_clearfix">
        <div class="_thumb courses_thumb" style="height:<?php echo is_numeric($height) ? $height.'px' : $height; ?>">
          <a href="<?php echo $course->getHref(); ?>" class="courses_thumb_img">
            <span style="background-image:url('<?php echo $course->getPhotoUrl('thumb.profile'); ?>');"></span>
          </a>
          <div class="courses_labels">
            <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataLabel.tpl';?>
          </div>
          <div class="_btns sesbasic_animation">
          <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataButtons.tpl';?>
          </div>
        </div>
        <div class="_cont">
          <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_coursePrice.tpl';?>
          <?php if(!empty($title)): ?>
            <div class="_title">
                <a href="<?php echo $course->getHref(); ?>"><?php echo $title; ?></a>
            </div>    
          <?php endif;?>
          <?php if((isset($category) && isset($this->categoryActive)) || isset($this->byActive)): ?>
            <div class="owner sesbasic_text_light">
              <?php if(isset($category) && isset($this->categoryActive)): ?> 
                <?php echo $this->translate('Posted in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
              <?php endif;?>
              <?php if(isset($this->byActive)): ?> 
                <?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if($this->ratingActive): ?>
            <div class="sesbasic_rating_star">
                <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>
            </div>
          <?php endif;?>
          <div class="_stats">
            <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_data.tpl';?>
          </div>
          <div class="_counts">
            <?php  include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/_dataStatics.tpl';?>
          </div>
      </div>
      </article>
    </li>
	<?php endif; ?>
<?php endforeach; ?>
