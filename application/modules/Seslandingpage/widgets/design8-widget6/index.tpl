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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template8.css'); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des8wid6_wrapper">
  <div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des8_head">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <div class="seslp_des8wid6_listing sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des8wid6_list_item">
          <article>
            <div class="seslp_des8wid6_list_item_thumb">
              <a href="<?php echo $result->getHref(); ?>"><span class="seslp_des8wid6_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span></a>
            </div>
            <?php if(in_array('title', $this->showstats)) { ?>
              <div class="seslp_des8wid6_list_item_cont">
                <h3><a href="<?php echo $result->getHref(); ?>" class="sesbasic_linkinherit"><?php echo $result->getTitle(); ?></a></h3>
              </div>
            <?php } ?>
            <p class="seslp_des8wid6_list_item_stat sesbasic_text_light">
              <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" class="sesbasic_text_light"><?php echo $user->getTitle(); ?></a></span></span>
              <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                <span><i class="fa fa-user"></i><span><a href="<?php echo $user->getHref(); ?>" class="sesbasic_text_light"><?php echo $user->getTitle(); ?></a></span></span>
              <?php } ?>
              <?php if(in_array('creationdate', $this->showstats)) { ?>
                <span><i class="fa fa-calendar"></i><span><?php echo date('M d, Y',strtotime($result->creation_date));?></span></span>
              <?php } ?>
            </p>
            <p class="seslp_des8wid6_list_item_stat sesbasic_text_light">
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
            <?php if(in_array('readmorebutton', $this->showstats)) { ?>
              <p class="seslp_des8wid6_list_item_btn">
                <a href="<?php echo $result->getHref(); ?>" class="seslp_animation"><?php echo $this->readmorebuttontext; ?></a>
              </p>
            <?php } ?>
          </article>
        </div>
      <?php } ?>
    </div>
	</div>      
</div>