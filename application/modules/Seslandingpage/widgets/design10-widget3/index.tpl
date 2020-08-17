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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template10.css'); ?>
<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->backgroundimage;
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Seslandingpage/externals/images/design10/block5-bg.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des10wid3_wrapper">
	<div class="seslp_des10wid3_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
  	<div class="seslp_des10wid3_row sesbasic_clearfix">
    	<div class="seslp_des10wid3_column seslp_des10wid3_column_left">
        <?php $leftside = 0; ?>
        <?php foreach($this->results as $result) { ?> 
          <?php if($leftside == 0) { ?>
            <div class="seslp_des10wid3_column_left_item">
              <a href="<?php echo $result->getHref(); ?>">
                <span class="seslp_des10wid3_column_left_item_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                <span class="seslp_des10wid3_column_left_item_overlay seslp_animation"></span>
              </a>
            </div>
          <?php } ?>
        <?php $leftside++; } ?>
      </div>
      <div class="seslp_des10wid3_column seslp_des10wid3_column_right">
        <?php if($this->title) { ?>
          <div class="seslp_des10_head sesbasic_clearfix">
            <h2><?php echo $this->title; ?></h2>
          </div>
        <?php } ?>
        <?php if($this->description) { ?>
          <p class="seslp_des10wid3_des"><?php echo $this->description; ?></p>
        <?php } ?>
        <div class="seslp_des10wid3_listing sesbasic_clearfix">
          <?php $rightside = 0; ?>
          <?php foreach($this->results as $result) { ?> 
            <?php if($rightside > 0) { ?>
              <div class="seslp_des10wid3_list_item">
                <article>
                  <div class="seslp_des10wid3_list_item_thumb">
                    <a href="<?php echo $result->getHref(); ?>">
                      <span class="seslp_des10wid3_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                      <span class="seslp_des10wid3_list_item_thumb_overlay seslp_animation"></span>
                      <?php if($this->fonticon) { ?>
                        <span class="seslp_des10wid3_list_item_thumb_btn"><i class="fa <?php echo $this->fonticon; ?>"></i></span>
                      <?php } ?>
                    </a>
                  </div>  	
                </article>
              </div>
          <?php } $rightside++; } ?>
        </div>
      </div>
    </div>
  </div>
</div>