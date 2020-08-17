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
<?php $contents = Zend_Json::decode($this->featureblock->contents); ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des9wid2_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <div class="seslp_des9_head">
        <h2><?php echo $this->title; ?></h2>
      </div>
    <?php } ?>
    <div class="seslp_des9wid2_features sesbasic_clearfix">
      <?php if($contents['title1']) { ?>
        <div class="seslp_des9wid2_feature_item">
          <div class="seslp_des9wid2_feature_item_icon">
            <i class="fa <?php echo $contents['fonticon1']; ?>"></i>
          </div>
          <div class="seslp_des9wid2_feature_item_cont">
            <h3><?php echo $contents['title1']; ?></h3>
            <?php if($contents['description1']) { ?>
              <p><?php echo $contents['description1']; ?></p>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
      <?php if($contents['title2']) { ?>
        <div class="seslp_des9wid2_feature_item">
          <div class="seslp_des9wid2_feature_item_icon">
            <i class="fa <?php echo $contents['fonticon2']; ?>"></i>
          </div>
          <div class="seslp_des9wid2_feature_item_cont">
            <h3><?php echo $contents['title2']; ?></h3>
            <?php if($contents['description2']) { ?>
              <p><?php echo $contents['description2']; ?></p>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
      <?php if($contents['title3']) { ?>
        <div class="seslp_des9wid2_feature_item">
          <div class="seslp_des9wid2_feature_item_icon">
            <i class="fa <?php echo $contents['fonticon3']; ?>"></i>
          </div>
          <div class="seslp_des9wid2_feature_item_cont">
            <h3><?php echo $contents['title3']; ?></h3>
            <?php if($contents['description3']) { ?>
              <p><?php echo $contents['description3']; ?></p>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
