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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template2.css'); ?>


<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des2wid5_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des2wid5_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
    <div class="seslp_des2wid5_listings sesbasic_clearfix">
      <?php foreach($this->results as $result): ?>
        <div class="seslp_des2wid5_listing_item">
          <article class="sesbasic_clearfix">
            <div class="seslp_des2wid5_listing_item_thumb">
              <a href="<?php echo $result->getHref() ;?>">
                <span class="seslp_animation seslp_des2wid5_listing_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span>
                <?php if(in_array('showoverlay', $this->showstats)) { ?>
                  <span class="seslp_animation seslp_des2wid5_listing_item_thumb_overlay"><i class="fa fa-link"></i></span>
                <?php } ?>
              </a>
            </div>
            <?php if($this->showstats) { ?>
              <div class="seslp_des2wid5_listing_item_info sesbasic_clearfix">
                <?php if(in_array('title', $this->showstats)) { ?>
                <div class="seslp_des2wid5_listing_item_title">
                  <a href="<?php echo $result->getHref() ;?>"><?php echo $result->getTitle() ;?></a>
                </div>
                <?php } ?>
                <div class="seslp_des2wid5_listing_item_date sesbasic_clearfix">
                  <p class="seslp_des2wid5_listing_item_stats">
                    <?php if(in_array('ownername', $this->showstats)) { ?>
                      <span class="sesbasic_text_light"><i class="fa fa-user"></i><span><a href="<?php echo $result->getOwner()->getHref() ;?>"><?php echo $result->getOwner()->getTitle(); ?></a></span></span>	
                    <?php } ?>
                    <?php if(in_array('creationdate', $this->showstats)) { ?>
                      <span class="sesbasic_text_light"><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                    <?php } ?>
                  </p>
                </div>
                <div class="seslp_des2wid5_listing_item_date sesbasic_clearfix">
                  <p class="seslp_des2wid5_listing_item_stats">
                    <?php if(in_array('likecount', $this->showstats)): ?>
                      <span class="sesbasic_text_light"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('commentcount', $this->showstats)): ?>
                      <span class="sesbasic_text_light"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('viewcount', $this->showstats)): ?>
                      <span class="sesbasic_text_light"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)): ?>
                      <span class="sesbasic_text_light"><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($result->rating_count) && in_array('ratingcount', $this->showstats)): ?>
                      <span class="sesbasic_text_light"><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                    <?php endif; ?>
                  </p>
                </div>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <div class="seslp_des2wid5_listing_item_des">
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
            <?php } ?>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>