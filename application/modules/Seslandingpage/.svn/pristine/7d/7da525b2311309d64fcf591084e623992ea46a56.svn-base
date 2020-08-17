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
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des3wid5_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des3wid5_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
    <div class="seslp_des3wid5_listing sesbasic_clearfix">
      <?php foreach($this->results as $result): ?>
        <div class="seslp_des3wid5_list_item">
          <article>
            <div class="seslp_des3wid5_list_item_thumb">
              <a href="<?php echo $result->getHref(); ?>" class="seslp_des3wid5_list_item_img">
                <span class="seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
              </a>
              <?php if(isset($result->category_id) && $result->category_id && in_array('category', $this->showstats)) { ?>
                <?php 
                $resourceType = explode('_', $this->resourcetype);
                if($resourceType[0]) {
                $category = Engine_Api::_()->getItem($resourceType[0].'_category', $result->category_id); ?>
                <?php if($category) { ?>
                <a href="javascript:void(0);" class="seslp_des3wid5_list_item_cat seslp_animation"><?php echo $category->getTitle(); ?></a>
              <?php } } } ?>
            </div>
            <?php if($this->showstats) { ?>
              <div class="seslp_des3wid5_list_item_cont">
                <?php if(in_array('title', $this->showstats)) { ?>
                  <div class="seslp_des3wid5_list_item_title">
                    <a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a>
                  </div>  
                <?php } ?>
                <div class="seslp_des3wid5_list_item_date sesbasic_clearfix">
                  <?php if(in_array('ownername', $this->showstats)) { ?>
                    <p class="floatL sesbasic_text_light">
                      <span><i class="fa fa-user"></i><span><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span></span>
                    </p>
                  <?php } ?>
                  <p class="floatR sesbasic_text_light">
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
                  </p>
                </div>
                <?php if(in_array('description', $this->showstats)) { ?>
                  <div class="seslp_des3wid5_list_item_des">
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