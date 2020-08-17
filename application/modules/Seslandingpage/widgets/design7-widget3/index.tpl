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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template7.css'); ?>
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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des7wid3_wrapper">
	<div class="seslp_des7wid3_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2><?php echo $this->title; ?></h2>
    <?php } ?>
    <div class="clear sesbasic_clearfix seslp_des7wid3_cont">
      <?php $firstCounter = 0; ?>
      <?php foreach($this->results as $result) { ?>
        <?php if($firstCounter == 0) { ?>
          <div class="seslp_des7wid3_col_l">
            <div class="seslp_des7wid3_col_l_item">
              <div class="seslp_des7wid3_col_l_item_thumb">
                <a href="<?php echo $result->getHref(); ?>"><span class="seslp_animation seslp_des7wid3_col_l_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>)"></span></a>
              </div>
              <div class="seslp_des7wid3_col_l_item_cont">
                <?php if(in_array('creationdate', $this->showstats)) { ?>
                  <p class="seslp_des7wid3_col_l_item_date"><?php echo date('M d, Y',strtotime($result->creation_date));?></p>
                <?php } ?>
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                <?php } ?>
                <p class="seslp_des7wid3_col_l_item_stats">
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
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php $firstCounter++; } ?>
      <div class="seslp_des7wid3_col_r">
      	<div class="seslp_des7wid3_listings sesbasic_clearfix">
          <?php $secondCounter = 0; ?>
          <?php foreach($this->results as $result) { ?>
            <?php if($secondCounter > 0) { ?>
              <div class="seslp_des7wid3_list_item">
                <article>
                  <div class="seslp_des7wid3_list_item_thumb">
                    <a href="<?php echo  $result->getHref(); ?>">
                      <span class="seslp_des7wid3_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span>
                    </a>
                    <span class="seslp_des7wid3_list_item_thumb_cont">
                      <?php if(in_array('creationdate', $this->showstats)) { ?>
                        <p><span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span></p>
                      <?php } ?>
                      <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                        <p><span><i class="fa fa-map-marker"></i><span><?php echo $result->location; ?></span></span></p>
                      <?php } ?>
                      <p>
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
                    </span>
                  </div>
                  <?php if(in_array('title', $this->showstats)) { ?>
                    <div class="seslp_des7wid3_list_item_title">
                      <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
                    </div>
                  <?php } ?>
                </article>
              </div>
            <?php } ?>
          <?php $secondCounter++; } ?>
        </div>
      </div>
		</div>
  </div>
</div>
