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

<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->backgroundimage;
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des1wid3_wrapper">
	<div class="seslp_des1wid3_background" style="background-image:url(<?php echo $backgroundimage; ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des1wid3_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
  	<?php if($this->description) { ?>
      <p class="seslp_des1wid3_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des1wid3_listings">
      
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des1wid3_listing_item sesbasic_clearfix wow zoomIn" data-wow-duration="1.5s">
          <article class="sesbasic_clearfix">
            <a href="<?php echo $result->getHref(); ?>" class="seslp_des1wid3_listing_item_thumb seslp_animation">
              <div class="seslp_des1wid3_listing_item_thumb_img">
                <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span>
              </div>
              <div class="seslp_des1wid3_listing_item_stats seslp_animation">
                <?php if(in_array('likecount', $this->showstats)) { ?>
                  <p class="_likes"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></p>
                <?php } ?>
                <?php if(in_array('commentcount', $this->showstats)) { ?>
                  <p class="_comments"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></p>
                <?php } ?>
                <?php if(in_array('viewcount', $this->showstats)) { ?>
                  <p class="_views"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></p>
                <?php } ?>
                <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)) { ?>
                  <p class="_fav"><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></p>
                <?php } ?>
                <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)) { ?>
                  <p class="_rating"><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></p>
                <?php } ?>
              </div>
              <?php if(in_array('title', $this->showstats)) { ?>
                <div class="seslp_des1wid3_listing_item_title">
                  <span><?php echo $result->getTitle(); ?></span>
                </div>
              <?php } ?>
            </a>
            <div class="seslp_des1wid3_listing_item_info sesbasic_clearfix">
              <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                <p class="_location">
                  <span><i class="fa fa-map-marker"></i></span>
                  <span><?php echo $result->location; ?></span>	
                </p>
              <?php } ?>
              <?php if(in_array('description', $this->showstats)) { ?>
                <p class="_des">
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
              <?php } ?>
            </div>
          </article>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<div class="seslp_des1wid3_btm sesbasic_clearfix sesbasic_bxs">
	<div class="seslp_blocks_container sesbasic_clearfix">
    <?php if($this->block1title && $this->block1url && $this->block1bgimage) { ?>
      <?php if($this->block1bgimage): ?>
        <?php 
          $photoUrl = $this->baseUrl() . '/' . $this->block1bgimage;
          $block1bgimage = $photoUrl;
        ?>
      <?php endif; ?>
      <div class="seslp_des1wid3_btm_item wow slideInLeft" data-wow-duration="1.5s">
        <div class="seslp_des1wid3_btm_item_thumb">
          <a href="<?php echo $this->block1url; ?>">
            <span class="seslp_des1wid3_btm_item_thumb_img seslp_animation" style="background-image:url(<?php echo $block1bgimage ?>)"></span>
            <div class="seslp_des1wid3_btm_item_cont">
              <div><p><?php echo $this->block1title; ?></p></div>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
    <?php if($this->block2title && $this->block2url && $this->block2bgimage) { ?>
      <?php if($this->block2bgimage): ?>
        <?php 
          $photoUrl = $this->baseUrl() . '/' . $this->block2bgimage;
          $block2bgimage = $photoUrl;
        ?>
      <?php endif; ?>
      <div class="seslp_des1wid3_btm_item wow zoomIn" data-wow-duration="1.5s">
        <div class="seslp_des1wid3_btm_item_thumb">
          <a href="<?php echo $this->block2url; ?>">
            <span class="seslp_des1wid3_btm_item_thumb_img seslp_animation" style="background-image:url(<?php echo $block2bgimage ?>)"></span>
            <div class="seslp_des1wid3_btm_item_cont">
              <div><p><?php echo $this->block2title; ?></p></div>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
    <?php if($this->block3title && $this->block3url && $this->block3bgimage) { ?>
      <?php if($this->block3bgimage): ?>
        <?php 
          $photoUrl = $this->baseUrl() . '/' . $this->block3bgimage;
          $block3bgimage = $photoUrl;
        ?>
      <?php endif; ?>
      <div class="seslp_des1wid3_btm_item wow slideInRight" data-wow-duration="1.5s">
        <div class="seslp_des1wid3_btm_item_thumb">
          <a href="<?php echo $this->block3url; ?>">
            <span class="seslp_des1wid3_btm_item_thumb_img seslp_animation" style="background-image:url(<?php echo $block3bgimage ?>)"></span>
            <div class="seslp_des1wid3_btm_item_cont">
              <div><p><?php echo $this->block3title; ?></p></div>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
  </div>
</div>