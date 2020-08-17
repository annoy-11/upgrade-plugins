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

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des3wid6_wrapper">
	<div class="seslp_des3wid6_container">
    <?php if($this->leftsidefonticon) { ?>
      <i class="seslp_des3wid6_icon fa <?php echo $this->leftsidefonticon; ?>"></i>
  	<?php } ?>
    <div class="seslp_des3wid6_cont sesbasic_clearfix">
      <?php if($this->title) { ?>
        <h2 class="seslp_des3wid6_head"><?php echo $this->title; ?></h2>
      <?php } ?>
      <?php if($this->description) { ?>
        <p><?php echo $this->description; ?></p>
      <?php } ?>
      <?php if($this->seeallbuttontext && $this->seeallbuttonurl) { ?>
        <a href="<?php echo $this->seeallbuttonurl; ?>" class="seslp_des3wid6_btn seslp_animation"><?php echo $this->seeallbuttontext; ?></a>
      <?php } ?>
  	</div>
  </div>  
  <div class="seslp_des3wid6_listing sesbasic_clearfix">
    <?php foreach($this->results as $result) { ?>
      <div class="seslp_des3wid6_list_item">
        <div class="seslp_des3wid6_list_item_thumb">
          <a href="<?php echo $result->getHref() ; ?>" class="seslp_des3wid6_list_item_thumb_img seslp_animation">
            <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl(thumb.normal) ?>);"></span>
            <?php if($this->showstats) { ?>
              <div class="seslp_des3wid6_list_item_cont seslp_animation">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <p class="seslp_des3wid6_list_item_title" title="<?php echo $result->getTitle(); ?>"><?php echo $result->getTitle(); ?></p>
                <?php } ?>
                <?php if(in_array('ownername', $this->showstats)) { ?>
                  <p class="seslp_des3wid6_list_item_date">
                    <span><i class="fa fa-user"></i><span><?php echo $result->getOwner()->getTitle(); ?></span></span>
                  </p>
                <?php } ?>
                <p class="seslp_des3wid6_list_item_date">
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
                </p>
              </div>
            <?php } ?>
          </a>
        </div>  	
      </div>
  	<?php } ?>
  </div>
</div>