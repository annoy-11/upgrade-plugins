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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template5.css'); ?>

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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des5wid3_wrapper">
	<div class="seslp_des5wid3_bg" style="background-image:url(<?php echo $backgroundimage; ?>)"></div>
	<div class="seslp_blocks_container">
  	<div class="seslp_des5wid_head sesbasic_clearfix">
      <?php if($this->title) { ?>
        <h2><?php echo $this->title; ?></h2>
  		<?php } ?>
  		<?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <span class="seslp_des5wid_head_btn"><a href="<?php echo $this->seeallbuttonurl; ?>" class="seslp_animation"><?php echo $this->seeallbuttontext; ?></a></span>
    	<?php } ?>
    </div>
    <div class="seslp_des5wid3_listings sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des5wid3_list_item sesbasic_clearfix">
          <article>
            <div class="seslp_des5wid3_list_item_thumb">
              <span class="seslp_des5wid3_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
              <a href="<?php echo $result->getHref(); ?>" class="seslp_des5wid3_list_item_thunb_overlay seslp_animation"></a>
              <?php if(in_array('creationdate', $this->showstats)) { ?>
                <span class="seslp_des5wid3_list_item_date"><?php echo date('M d, Y',strtotime($result->creation_date));?></span>
              <?php } ?>
            </div>
            <?php if($this->showstats) { ?>
              <div class="seslp_des5wid3_list_item_cont seslp_animation">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <p class="seslp_des5wid3_list_item_title"><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></p>
                <?php } ?>
                <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                  <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                  <p class="seslp_des5wid3_list_item_stats"><span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span></span></p>
                <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                  <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                  <p class="seslp_des5wid3_list_item_stats"><span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle(); ?></a></span></span></p>
                <?php } ?>
                <?php if(isset($result->location) && $result->location && in_array('location', $this->showstats)) { ?>
                  <p class="seslp_des5wid3_list_item_stats"><span><i class="fa fa-map-marker"></i><span><a href="javascript:void(0);"><?php echo $result->location; ?></a></span></span></p>
                <?php } ?>
                <p class="seslp_des5wid3_list_item_stats">
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
              </div>
            <?php } ?>
          </article>	
        </div>
      <?php } ?>
    </div>
  </div>
</div>