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

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des8wid4_wrapper">
  <div class="seslp_blocks_container">
    <div class="seslp_des8wid4_row sesbasic_clearfix">
    	<div class="seslp_des8wid4_col seslp_des8wid4_col_left">
        <?php if($this->title) { ?>
          <div class="seslp_des8_head">
            <h2><?php echo $this->title; ?></h2>
          </div>
        <?php } ?>
        <?php $leftSide = 0; ?>
        <?php foreach($this->results as $result) { ?>
          <?php if($leftSide > 0) continue; ?>
          <div class="seslp_des8wid4_sin_item">
            <div class="seslp_des8wid4_sin_item_thumb">
              <a href="<?php echo $result->getHref(); ?>">
                <span class="seslp_animation seslp_des8wid4_sin_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                <?php if($this->fonticon) { ?>
                  <span class="seslp_animation seslp_des8wid4_sin_item_thumb_icon"><i class="fa <?php echo $this->fonticon; ?>"></i></span>
                <?php } ?>
              </a>
            </div>
            <div class="seslp_des8wid4_sin_item_cont">
              <?php if(in_array('title', $this->showstats)) { ?>
                <h3><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></h3>
              <?php } ?>
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
        <?php $leftSide++; } ?>
      </div>
      
      <div class="seslp_des8wid4_col seslp_des8wid4_col_right">
        <?php $rightSide = 0; ?>
      	<?php foreach($this->results as $result) { ?>
          <?php if($rightSide > 0) { ?>
            <div class="seslp_des8wid4_item">
              <article>
                <div class="seslp_des8wid4_item_thumb">
                  <a href="<?php echo $result->getHref(); ?>">
                    <span class="seslp_des8wid4_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                    <span class="seslp_des8wid4_item_thumb_overlay seslp_animation"></span>
                    <div class="seslp_des8wid4_item_cont seslp_animation">
                      <?php if(in_array('title', $this->showstats)) { ?>
                        <p class="seslp_des8wid4_item_title"><?php echo $result->getTitle(); ?></p>
                      <?php } ?>
                      <?php if(isset($result->owner_id) && in_array('ownername', $this->showstats)) { ?>
                        <?php $user = Engine_Api::_()->getItem('user', $result->owner_id); ?>
                        <p><?php echo $user->getTitle(); ?></p>
                      <?php } else if(isset($result->user_id) && in_array('ownername', $this->showstats)) { ?>
                        <?php $user = Engine_Api::_()->getItem('user', $result->user_id); ?>
                        <p><?php echo $user->getTitle(); ?></p>
                      <?php } ?>
                    </div>
                  </a>
                </div>
              </article>
            </div>
          <?php } ?>
        <?php $rightSide++; } ?>
      </div>
    </div>
	</div>
</div>