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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template4.css'); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des4wid4_wrapper">
	<div class="seslp_blocks_container sesbasic_clearfix">
		<div class="seslp_des4wid4_column seslp_des4wid4_column_l">
      <?php if($this->title) { ?>
        <h2><?php echo $this->title; ?></h2>
    	<?php } ?>
    	<?php if($this->heading) { ?>
        <h3><?php echo $this->heading; ?></h3>
      <?php } ?>
      <?php if($this->description) { ?>
        <p><?php echo $this->description; ?></p>
      <?php } ?>
      <?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <p class="seslp_des4wid4_column_l_btn">
          <a href="<?php echo $this->seeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->seeallbuttontext; ?></a>
        </p>
      <?php } ?>
    </div>
    <div class="seslp_des4wid4_column seslp_des4wid4_column_r">
    	<div class="seslp_des4wid4_listing sesbasic_clearfix">
        <?php foreach($this->results as $result) { ?>
          <div class="seslp_des4wid4_list_item">
            <article>
              <div class="seslp_des4wid4_list_item_thumb">
                <a href="<?php echo $result->getHref(); ?>" class="seslp_des4wid4_list_item_img">
                  <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                  <span class="seslp_animation seslp_des4wid4_list_item_thumb_overlay"></span>
                </a>
                <?php if(isset($result->category_id) && $result->category_id && in_array('category', $this->showstats)) { ?>
                  <?php 
                  $resourceType = explode('_', $this->resourcetype);
                  if($resourceType[0]) {
                  $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                  <?php if($category) { ?>
                  <p class="seslp_des4wid4_list_item_cat">
                    <a href="javascript:void();" class="seslp_animation_animation"><?php echo $category->getTitle(); ?></a>
                  </p>
                <?php } } } ?>
              </div>
              <?php if($this->showstats) { ?>
                <div class="seslp_des4wid4_list_item_cont">
                  <?php if(in_array('title', $this->showstats)) { ?>
                    <div class="seslp_des4wid4_list_item_title">
                      <a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a>
                    </div>
                  <?php } ?>
                  <div class="seslp_des4wid4_list_item_stats">
                    <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                      <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span></span>
                    <?php } ?>
                    <?php if(in_array('creationdate', $this->showstats)) { ?>
                      <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                    <?php } ?>
                  </div>
                  <div class="seslp_des4wid4_list_item_stats">
                    <?php if(in_array('likecount', $this->showstats)): ?>
                      <span><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('commentcount', $this->showstats)): ?>
                      <span><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(in_array('viewcount', $this->showstats)): ?>
                      <span><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)): ?>
                      <span><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></span>
                    <?php endif; ?>
                    <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)): ?>
                      <span><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                    <?php endif; ?>
                  </div>
                </div>
              <?php } ?>
            </article>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>