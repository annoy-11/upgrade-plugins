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

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des3wid2_wrapper">
	<div class="seslp_blocks_container">
  	<div class="seslp_des3wid2_listing sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des3wid2_item">
          <div class="seslp_des3wid2_item_thumb">
            <a href="<?php echo $result->getHref(); ?>" class="seslp_des3wid2_item_thumb_img">
              <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
              <p class="seslp_animation _overlay"></p>
            </a>
            <p class="corners">
              <span class="corner-1 seslp_animation"></span>
              <span class="corner-2 seslp_animation"></span>
              <span class="corner-3 seslp_animation"></span>
              <span class="corner-4 seslp_animation"></span>
             </p> 
             <?php if(isset($result->category_id) && $result->category_id && in_array('category', $this->showstats)) { ?>
               <?php 
                $resourceType = explode('_', $this->resourcetype);
                if($resourceType[0]) {
                $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                <?php if($category) { ?>
               <p class="seslp_des3wid2_item_category seslp_animation"><a href="javascript:void(0);"><?php echo $category->getTitle(); ?></a></p>
            <?php } } } ?>
          </div>
          <?php if($this->showstats) { ?>
            <div class="seslp_des3wid2_item_cont sesbasic_clearfix">
              <?php if(in_array('title', $this->showstats)) { ?>
                <div class="seslp_des3wid2_item_title">
                  <a href="<?php echo $result->getHref(); ?>" title="<?php echo $result->getTitle(); ?>"><?php echo $result->getTitle(); ?></a>
                </div>
              <?php } ?>
              <?php if(isset($result->location) && in_array('location', $this->showstats)) { ?>
                <div class="seslp_des3wid2_item_date">
                  <span><i class="fa fa-map-marker"></i><span><?php echo $result->location; ?></span></span>
                </div>
              <?php } ?>
              <div class="seslp_des3wid2_item_date">
                <?php if(in_array('likecount', $this->showstats)) { ?>
                  <span><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></span>
                <?php } ?>
                <?php if(in_array('commentcount', $this->showstats)) { ?>
                  <span><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></span>
                <?php } ?>
                <?php if(in_array('viewcount', $this->showstats)) { ?>
                  <span><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></span>
                <?php } ?>
                <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)) { ?>
                  <span><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></span>
                <?php } ?>
                <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)) { ?>
                  <span><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                <?php } ?>
              </div>
<!--              <div class="seslp_des3wid2_item_btn">
                <a href="" class="seslp_animation">Book</a>
              </div>-->
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>