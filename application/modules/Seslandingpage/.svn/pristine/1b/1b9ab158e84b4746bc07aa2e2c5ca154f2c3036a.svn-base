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

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des10wid2_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des10_head sesbasic_clearfix">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <?php if($this->description) { ?>
      <p class="seslp_des10wid2_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des10wid2_listing sesbasic_clearfix">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des10wid2_list_item">
          <article>
            <div class="seslp_des10wid2_list_item_thumb">
              <a href="<?php echo $result->getHref(); ?>">
                <span class="seslp_des10wid2_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                <span class="seslp_des10wid2_list_item_thumb_overlay seslp_animation"></span>
                <?php if($this->fonticon) { ?>
                  <span class="seslp_des10wid2_list_item_thumb_icon seslp_animation"><i class="fa <?php echo $this->fonticon; ?>"></i></span>
                <?php } ?>
              </a>
            </div>
          </article>
        </div>
      <?php } ?>
    </div>
  </div>
</div>