<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template1.css'); ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des1wid4_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des1wid4_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
  	<?php if($this->description) { ?>
      <p class="seslp_des1wid4_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des1wid4_listings sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des1wid4_listing_item wow slideInUp" datat-wow-duration="1.3s">
          <article class="sesbasic_clearfix">
            <div class="seslp_des1wid4_listing_item_thumb">
              <a href="<?php echo $result->getHref(); ?>" class="seslp_des1wid4_listing_item_thumb_img"><span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              
              <?php if(isset($result->category_id) && in_array('category', $this->showstats)) {  ?>
                <?php 
                $resourceType = explode('_', $this->resourcetype);
                if($resourceType[0]) {
                $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                <?php if($category) { ?>
                <div class="seslp_des1wid4_listing_item_category">
                  <a href="javascript:void(0);" class="seslp_animation"><?php echo $category->title; ?></a>
                </div>
              <?php } } } ?>
              <?php if(in_array('socialSharing', $this->showstats)):?>
                <div class="seslp_des1wid4_listing_item_btns seslp_animation">
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $result, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                </div>
              <?php endif;?>
            </div>
            
            <?php if($this->showstats): ?>
              <div class="seslp_des1wid4_listing_item_info sesbasic_clearfix">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <div class="seslp_des1wid4_listing_item_title">
                    <a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a>
                  </div>
                <?php } ?>
                <div class="seslp_des1wid4_listing_item_owner sesbasic_clearfix">
                  <?php if(in_array('ownerphoto', $this->showstats)): ?>
                    <div class="seslp_des1wid4_listing_item_owner_photo">
                      <a href="<?php echo $result->getOwner()->getHref(); ?>"><img src="<?php echo $result->getOwner()->getPhotoUrl('thumb.icon'); ?>" alt="" class="thumb_profile item_photo_user"></a>
                    </div>
                  <?php endif; ?>
                  <div class="seslp_des1wid4_listing_item_owner_info sesbasic_text_light">
                    <?php if(in_array('ownername', $this->showstats)): ?>
                      <span><?php echo $this->translate("by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>
                    <?php endif; ?>
                    <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                      <span><i class="fa fa-map-marker"></i><a href="javascript:void(0);"><?php echo $result->location; ?></a></span>
                    <?php } ?>
                  </div>
                </div>
                <div class="seslp_des1wid4_listing_item_date sesbasic_clearfix">
                  <?php if(in_array('creationdate', $this->showstats)): ?>
                    <p class="floatL"><i class="sesbasic_text_light fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></p>
                  <?php endif; ?>
                  <p class="seslp_des1wid4_listing_item_stats floatR">
                    <?php if(in_array('likecount', $this->showstats)): ?>
                      <span class="sesbasic_text_light fa fa-thumbs-up"><?php echo $result->like_count; ?></span>
                    <?php endif; ?>
                    <?php if(in_array('commentcount', $this->showstats)): ?>
                      <span class="sesbasic_text_light fa fa-comment"><?php echo $result->comment_count; ?></span>
                    <?php endif; ?>
                    <?php if(in_array('viewcount', $this->showstats)): ?>
                      <span class="sesbasic_text_light fa fa-eye"><?php echo $result->view_count; ?></span>
                    <?php endif; ?>
                    <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)) : ?>
                      <span class="sesbasic_text_light fa fa-heart"><?php echo $result->favourite_count; ?></span>
                    <?php endif; ?>
                    <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)) : ?>
                      <span class="sesbasic_text_light fa fa-star"><?php echo $result->rating; ?></span>
                    <?php endif; ?>
                  </p>
                </div>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <div class="seslp_des1wid4_listing_item_des">
                    <p>
                      <?php
                        if(isset($result->description) && !empty($result->description)) {
                          $description = $result->description;
                        } else if(isset($result->body) && !empty($result->body)) {
                          $description = $result->body;
                        }
                        if(strlen(strip_tags($description)) > $this->descriptiontruncation)
                          $description = $this->string()->truncate($this->string()->stripTags(strip_tags($description)), ($this->descriptiontruncation - 3)).'...';
                        else
                          $description = strip_tags($description);
                        echo $description;
                      ?>
                    </p>
                  </div>
                <?php } ?>
              </div>
            <?php endif; ?>
          </article>
        </div>
      <?php } ?>
    </div>
  </div>
</div>