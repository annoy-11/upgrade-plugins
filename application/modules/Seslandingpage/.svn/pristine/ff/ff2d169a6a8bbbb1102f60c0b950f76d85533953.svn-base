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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des2wid4_wrapper">
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
	<div class="seslp_des2wid4_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des2wid4_head"><?php echo $this->title ; ?></h2>
  	<?php } ?>
  	<?php if($this->heading) { ?>
      <h3 class="seslp_des2wid4_subhead"><?php echo $this->heading; ?></h3>
    <?php } ?>
    <?php if($this->description) { ?>
      <p class="seslp_des2wid4_des"><?php echo $this->description; ?></p>
    <?php } ?>
    
    <div class="seslp_des2wid4_listing sesbasic_clearfix">
      <?php foreach($this->results as $result): ?>
    	<div class="seslp_des2wid4_list_item">
      	<article class="sesbasic_clearfix">
        	<div class="seslp_des2wid4_list_item_thumb">
          	<a href="<?php echo $result->getHref(); ?>" class="seslp_des2wid4_list_item_img"><span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl(); ?>);"></span></a>
          </div>
          <?php if($this->showstats) { ?>
            <div class="seslp_des2wid4_list_item_cont sesbasic_clearfix">
              <?php if(in_array('creationdate', $this->showstats)) { ?>
                <?php $date = explode('-', $result->creation_date); ?>
                <div class="seslp_des2wid4_list_item_date">
                  <span class="_month"><?php echo date("M", mktime(0, 0, 0, $date[1], 10)); ?></span>
                  <?php $date = explode(' ', $date[2]); ?>
                  <span class="_day"><?php echo $date[0]; ?></span>
                </div>
              <?php } ?>
              <div class="seslp_des2wid4_list_item_info">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <h3 class="seslp_des2wid4_list_item_title">
                    <a title="<?php echo $result->getTitle() ;?>" href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle() ;?></a>
                  </h3>
                <?php } ?>
                <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                  <p class="seslp_des2wid4_list_item_stat"><span><i class="fa fa-map-marker"></i><a href="javascript:void(0);"><?php echo $result->location; ?></a></span></p>
                <?php } ?>
                <?php if(isset($result->category_id) && in_array('category', $this->showstats)) { ?>
                  <?php 
                  $resourceType = explode('_', $this->resourcetype);
                  if($resourceType[0]) {
                  $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                  <?php if($category) { ?>
                    <p class="seslp_des2wid4_list_item_stat"><span><i class="fa fa-folder-open"></i><a href="javascript:void(0);"><?php echo $category->title; ?></a></span></p>
                <?php } } } ?>
                <p class="seslp_des2wid4_list_item_stat">
                  <?php if(in_array('likecount', $this->showstats)): ?>
                    <span><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></span>
                  <?php endif; ?>
                  <?php if(in_array('commentcount', $this->showstats)): ?>
                    <span><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></span>
                  <?php endif; ?>
                  <?php if(in_array('viewcount', $this->showstats)): ?>
                    <span><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></span>
                  <?php endif; ?>
                  <?php if(isset($result->favourite_count) && in_array('favouritecount', $this->showstats)) : ?>
                    <span><i class="fa fa-heart"></i><span><?php echo $result->favourite_count; ?></span></span>
                  <?php endif; ?>
                  <?php if(isset($result->rating) && in_array('ratingcount', $this->showstats)) : ?>
                    <span><i class="fa fa-star"></i><span><?php echo $result->rating; ?></span></span>
                  <?php endif; ?>
                </p>
              </div>
            </div>
          <?php } ?>
        </article>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>