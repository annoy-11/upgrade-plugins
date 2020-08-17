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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des1wid5_wrapper">
  <?php if($this->backgroundimage): ?>
    <?php 
      $photoUrl = Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage);
      $backgroundimage = $photoUrl;
    ?>
  <?php else: ?>
    <?php 
      $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
      $backgroundimage = $photoUrl;
    ?>
  <?php endif; ?>
	<div class="seslp_des1wid5_background" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des1wid5_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
  	<?php if($this->description) { ?>
      <p class="seslp_des1wid5_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des1wid5_listings">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des1wid5_listing_item sesbasic_clearfix wow zoomIn" datat-wow-duration="1.3s">
          <article class="sesbasic_clearfix">
            <a href="<?php echo $result->getHref(); ?>" class="seslp_des1wid5_listing_item_thumb seslp_animation">
              <div class="seslp_des1wid5_listing_item_thumb_img">
                <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span>
              </div>
              <?php if(in_array($this->resourcetype, array('video', 'sesvieo_video'))) { ?>
                <div class="seslp_des1wid5_listing_item_thumb_overlay seslp_animation">
                  <span class="fa fa-play seslp_animation"></span>
                </div>
              <?php } ?>
            </a>
            <?php if($this->showstats): ?>
              <div class="seslp_des1wid5_listing_item_info sesbasic_clearfix">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <p class="seslp_des1wid5_listing_item_title"><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></p>
                <?php } ?>
                <?php if(in_array('ownername', $this->showstats)) { ?>
                  <p class="seslp_des1wid5_listing_item_date">
                    <?php echo $this->translate("Posted by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a>	
                  </p>
                <?php } ?>
                <p class="seslp_des1wid5_listing_item_date">
                  <?php if(in_array('likecount', $this->showstats)): ?>
                    <span class="fa fa-thumbs-up"><?php echo $result->like_count; ?></span>
                  <?php endif; ?>
                  <?php if(in_array('commentcount', $this->showstats)): ?>
                    <span class="fa fa-comment"><?php echo $result->comment_count; ?></span>
                  <?php endif; ?>
                  <?php if(in_array('viewcount', $this->showstats)): ?>
                    <span class="fa fa-eye"><?php echo $result->view_count; ?></span>
                  <?php endif; ?>
                  <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)): ?>
                    <span class="fa fa-heart"><?php echo $result->favourite_count; ?></span>
                  <?php endif; ?>
                  <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)): ?>
                    <span class="fa fa-star"><?php echo $result->rating; ?></span>
                  <?php endif; ?>
                </p>
              </div>
              <div class="overlay"></div>
            <?php endif; ?>
          </article>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
