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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template1.css'); ?>
<?php $contents = Zend_Json::decode($this->featureblock->contents); ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des1wid2_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des1wid2_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
  	<?php if($this->description) { ?>
      <p class="seslp_des1wid2_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des1wid2_cont sesbasic_clearfix">
    	<div class="seslp_des1wid2_features">
        
        <?php if(!empty($contents['title1'])) { ?>
          <div class="seslp_des1wid2_feature_item">
            <div class="seslp_des1wid2_feature_item_icon">
							<?php if($contents['icon_type1'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon1']; ?>"></i>
              <?php } elseif($contents['icon_type1'] == 0) { ?>
								<?php $photo1 = Engine_Api::_()->storage()->get($contents['photo1'], ''); ?>
								<?php if($photo1) { ?>
									<i style="background-image:url(<?php echo $photo1->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
            <div class="seslp_des1wid2_feature_item_cont">
              <h3><?php echo $contents['title1']; ?></h3>
              <?php if($contents['description1']) { ?>
                <p><?php echo $contents['description1']; ?></p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        
        <?php if(!empty($contents['title2'])) { ?>
          <div class="seslp_des1wid2_feature_item">
            <div class="seslp_des1wid2_feature_item_icon">
							<?php if($contents['icon_type2'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon2']; ?>"></i>
              <?php } else if($contents['icon_type2'] == 0) { ?>
								<?php $photo2 = Engine_Api::_()->storage()->get($contents['photo2'], ''); ?>
								<?php if($photo2) { ?>
									<i style="background-image:url(<?php echo $photo2->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
            <div class="seslp_des1wid2_feature_item_cont">
              <h3><?php echo $contents['title2']; ?></h3>
              <?php if($contents['description2']) { ?>
                <p><?php echo $contents['description2']; ?></p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        
        <?php if(!empty($contents['title3'])) { ?>
          <div class="seslp_des1wid2_feature_item">
            <div class="seslp_des1wid2_feature_item_icon">
							<?php if($contents['icon_type3'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon3']; ?>"></i>
              <?php } else if($contents['icon_type3'] == 0) { ?>
								<?php $photo3 = Engine_Api::_()->storage()->get($contents['photo3'], ''); ?>
								<?php if($photo3) { ?>
									<i style="background-image:url(<?php echo $photo3->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
            <div class="seslp_des1wid2_feature_item_cont">
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
</div>
