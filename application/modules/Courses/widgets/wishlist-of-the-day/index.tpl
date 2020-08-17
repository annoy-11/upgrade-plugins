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
<?php $height = $this->height;?>
<?php $width = $this->width;?>
<div class="courses_course_of_the_day">
    <ul class="courses_courses_listing sesbasic_bxs">
        <?php $limit = 0;?>
        <?php  $wishlist = Engine_Api::_()->getItem('courses_wishlist',$this->wishlist_id);?>
        <?php if($wishlist):?>
          <li class="courses_grid_item" style="width:<?php echo is_numeric($width) ? $width.'px' : $width; ?>;">
            <article class="sesbasic_clearfix">
              <div class="_thumb courses_thumb" style="height:<?php echo is_numeric($height) ? $height.'px' : $height; ?>">
                <?php if($this->wishlistPhotoActive): ?>
                  <a href="<?php echo $wishlist->getHref(); ?>" class="courses_thumb_img">
                    <span style="background-image:url('<?php echo $wishlist->getPhotoUrl('thumb.profile'); ?>');"></span>
                  </a>
                <?php endif; ?>
                <div class="courses_labels">
                  <?php if(isset($this->featuredLabelActive) && $wishlist->is_featured):?>
                    <p class="courses_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></p>
                  <?php endif; ?>
                  <?php if(isset($this->sponsoredLabelActive) && $wishlist->is_sponsored):?>
                    <p class="courses_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><?php echo $this->translate('SPONSORED');?></p>
                  <?php endif; ?>
                </div>
                <div class="_btns sesbasic_animation">
                  <?php if(isset($this->likeButtonActive)): ?>
                    <?php $likeStatus = Engine_Api::_()->courses()->getLikeStatus($wishlist->wishlist_id,$wishlist->getType()); ?>
                      <a href="javascript:;" data-type="courses_wishlist_like_view" data-url="<?php echo $wishlist->wishlist_id; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn courses_wishlist_like_<?php echo $wishlist->wishlist_id; ?> courses_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $wishlist->like_count;?></span></a>
                  <?php endif;  ?>
                  <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.favourite', 1)):?>
                    <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'courses')->isFavourite(array('resource_id' => $wishlist->wishlist_id,'resource_type' => $wishlist->getType())); ?>
                      <a href="javascript:;" data-type="courses_wishlist_favourite_view" data-url="<?php echo $wishlist->wishlist_id; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn <?php echo ($favouriteStatus) ? 'button_active' : ''; ?> courses_wishlist_favourite_<?php echo $wishlist->wishlist_id; ?> courses_likefavfollow"><i class="fa fa-heart"></i><span><?php echo $wishlist->favourite_count;?></span></a>
                  <?php endif; ?>
                </div>
              </div>
              <div class="_cont">
                <?php if(isset($this->titleActive)):?>
                  <?php if(strlen($wishlist->getTitle()) > $this->title_truncation):?>
                    <?php $title = mb_substr($wishlist->getTitle(),0,$this->title_truncation).'...';?>
                  <?php else:?>
                    <?php $title = $wishlist->getTitle();?>
                  <?php endif; ?>
                  <?php if(!empty(@$title)): ?>
                    <div class="_title">
                        <a href="<?php echo $wishlist->getHref(); ?>"><?php echo $title; ?></a>
                    </div>    
                  <?php endif;?>
                <?php endif;?>
                <div class="_stats">
                <?php if(isset($this->likeCountActive)):?>
                    <span class="list_like courses_wishlist_like_count_<?php echo $wishlist->wishlist_id; ?>"><i class="sesbasic_icon_like_o"></i><?php echo $wishlist->like_count; ?></span>
                  <?php endif;?>
                  <?php if(isset($this->viewCountActive)):?>
                    <span class="list_view"><i class="sesbasic_icon_view"></i><?php  echo $wishlist->view_count; ?></span>
                  <?php endif;?> 
                  <?php if(isset($this->favouriteCountActive)):?>
                    <span class="list_fav courses_wishlist_favourite_count_<?php echo $wishlist->wishlist_id; ?>"><i class="fa fa-star-o"></i><?php echo $wishlist->favourite_count; ?></span>
                  <?php endif;?> 
                  <?php if(isset($this->courseCountActive)):?>
                    <span class="_students sesbasic_text_light"><i class="fa fa-list"></i><?php echo $this->translate(array('%s Course', '%s Courses', $wishlist->courses_count), $this->locale()->toNumber($wishlist->courses_count))?></span>
                  <?php endif;?>
                  <?php if(isset($this->creationDateActive)):?>
                    <span class="_duration sesbasic_text_light"><i class="fa fa-clock-o"></i><?php echo $this->timestamp($wishlist->creation_date, array()) ?></span>
                  <?php endif;?>
                </div>
              </div>
            </article>
          </li>
        <?php endif;?>
        <?php $limit++;?>
    </ul>
</div>
