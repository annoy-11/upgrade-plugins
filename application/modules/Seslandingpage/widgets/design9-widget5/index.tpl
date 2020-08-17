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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template9.css'); ?>
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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des9wid5_wrapper">
	<div class="seslp_des9wid5_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des9_head">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <div class="seslp_des9wid5_row sesbasic_clearfix">
    	<div class="seslp_des9wid5_column">
        <?php $leftSide = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($leftSide < 2) { ?>
            <div class="seslp_des9wid5_list_item sesbasic_clearfix wow slideInLeft" data-wow-duration="1.5s">
              <div class="seslp_des9wid5_list_item_thumb">
                <a href="<?php echo $result->getHref() ?>"><span class="seslp_animation seslp_des9wid5_list_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
              </div>
              <div class="seslp_des9wid5_list_item_cont">
                <?php if(isset($result->category_id) && in_array('category', $this->showstats)) {  ?>
                  <?php 
                  $resourceType = explode('_', $this->resourcetype);
                  if($resourceType[0]) {
                  $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                  <?php if($category) { ?>
                  <p class="seslp_des9wid5_list_item_cat seslp_des9wid5_list_item_stats"><span><i class="fa fa-folder-open"></i><span><a href="javascript:void(0);" class="seslp_animation"><?php echo $category->title; ?></a></span></span></p>
                <?php } } } ?>
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des9wid5_list_item_stats">
                  <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } ?>
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                </p>
                <p class="seslp_des9wid5_list_item_stats">
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
                  <?php if(isset($result->rating_count) && in_array('ratingcount', $this->showstats)): ?>
                    <span><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                  <?php endif; ?>
                </p>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <p class="seslp_des9wid5_list_item_des">
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
            </div>
          <?php } ?>
        <?php $leftSide++; } ?>
      </div>
      
      <div class="seslp_des9wid5_column wow slideInRight" data-wow-duration="1.5s">
      	<div class="seslp_des9wid5_list_item_big">
          <?php $rightSide = 0; ?>
          <?php foreach($this->results as $result) { ?>
            <?php if($rightSide == 2) { ?>
              <div class="seslp_des9wid5_list_item_big_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_animation seslp_des9wid5_list_item_big_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span></a>
              </div>
              <div class="seslp_des9wid5_list_item_big_cont">
                <?php if(isset($result->category_id) && in_array('category', $this->showstats)) {  ?>
                  <?php 
                  $resourceType = explode('_', $this->resourcetype);
                  if($resourceType[0]) {
                  $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                  <?php if($category) { ?>
                  <p class="seslp_des9wid5_list_item_big_cat seslp_des9wid5_list_item_big_stats"><span><i class="fa fa-folder-open"></i><span><a href="javascript:void(0);" class="seslp_animation"><?php echo $category->title; ?></a></span></span></p>
                <?php } } } ?>
                
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des9wid5_list_item_big_stats">
                  <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                    <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                    <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" ><?php echo $user->getTitle(); ?></a></span></span>
                  <?php } ?>
                  <?php if(in_array('creationdate', $this->showstats)) { ?>
                    <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
                  <?php } ?>
                </p>
                <p class="seslp_des9wid5_list_item_big_stats">
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
                  <?php if(isset($result->rating_count) && in_array('ratingcount', $this->showstats)): ?>
                    <span><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                  <?php endif; ?>
                </p>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <p class="seslp_des9wid5_list_item_big_des">
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
            <?php } ?>
          <?php $rightSide++; } ?>
        </div>
      </div>
    </div>
  </div>
</div>
