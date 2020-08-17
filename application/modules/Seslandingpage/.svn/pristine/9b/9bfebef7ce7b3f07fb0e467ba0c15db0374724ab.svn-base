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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template3.css'); ?>
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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des3wid4_wrapper">
	<div class="seslp_des3wid4_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container sesbasic_clearfix">
  	<div class="seslp_des3wid4_left">
      <?php if($this->title) { ?>
        <h2 class="seslp_des3wid4_head"><?php echo $this->title; ?></h2>
      <?php } ?>
      <?php if($this->description) { ?>
        <p class="seslp_des3wid4_des"><?php echo $this->description; ?></p>
      <?php } ?>
      <?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <a href="<?php echo $this->seeallbuttonurl ; ?>" class="seslp_des3wid4_btn seslp_animation"><?php echo $this->seeallbuttontext; ?></a> 
      <?php } ?>
		</div>
    <div class="seslp_des3wid4_right">
    	<div class="seslp_des3wid4_listing sesbasic_clearfix">
        <?php foreach($this->results as $result) { ?>
          <div class="seslp_des3wid4_list_item">
            <article>
              <div class="seslp_des3wid4_list_item_thumb">
                <a href="<?php echo $result->getHref(); ?>" class="seslp_des3wid4_list_item_thumb_img">
                  <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                  <span class="_overlay seslp_animation"></span>
                  <?php if($this->leftsidefonticon) { ?>
                    <i class="seslp_animation fa <?php echo $this->leftsidefonticon; ?>"></i>
                  <?php } ?>
                </a>
              </div>
              
              <div class="seslp_des3wid4_list_item_cont seslp_animation">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <div class="seslp_des3wid4_list_item_title">
                    <a title="<?php echo $result->getTitle(); ?>" href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a>
                  </div>
                <?php } ?>
                <?php if(in_array('ownername', $this->showstats)) { ?>
                  <div class="seslp_des3wid4_list_item_date">
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span></span>
                  </div>
                <?php } ?>
                <div class="seslp_des3wid4_list_item_date">
                  <?php if(in_array('likecount', $this->showstats)) { ?>
                    <span class="sesbasic_text_light"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></span>
                  <?php } ?>
                  <?php if(in_array('commentcount', $this->showstats)) { ?>
                    <span class="sesbasic_text_light"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></span>
                  <?php } ?>
                  <?php if(in_array('viewcount', $this->showstats)) { ?>
                    <span class="sesbasic_text_light"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></span>
                  <?php } ?>
                  <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)) { ?>
                    <span class="sesbasic_text_light"><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></span>
                  <?php } ?>
                  <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)) { ?>
                    <span class="sesbasic_text_light"><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                  <?php } ?>
                </div>
              </div>
            </article>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>  
</div>