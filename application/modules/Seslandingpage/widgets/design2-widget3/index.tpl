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
<?php 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/scripts/lity.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/lity.css');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template2.css'); ?>
<?php $contents = Zend_Json::decode($this->featureblock->contents); ?>

<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des2wid3_wrapper">
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des2wid3_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
  	<?php if($this->description) { ?>
      <p class="seslp_des2wid3_des"><?php echo $this->description; ?></p>
    <?php } ?>
    <div class="seslp_des2wid3_cont sesbasic_clearfix">
      <?php if($this->backgroundimage && $this->videourl) { ?>
        <div class="seslp_des2wid3_cont_left wow slideInLeft"  data-wow-duration="1.5s">
          <div class="seslp_des2wid3_video">
            <a href="<?php echo $this->videourl; ?>" data-lity>
              <?php if($this->backgroundimage): ?>
                <?php 
                  $photoUrl = Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage);
                  $backgroundimage = $photoUrl;
                ?>
              <?php else: ?>
                <?php 
                  $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
                  $backgroundimage = $photoUrl;
                ?>
              <?php endif; ?>
              <span class="seslp_des2wid3_video_img seslp_animation" style="background-image:url(<?php echo $backgroundimage ?>);"></span>
              <span class="seslp_des2wid3_video_btn"><i class="fa fa-play"></i></span>
            </a>
          </div>
        </div>
      <?php } ?>
      <div class="seslp_des2wid3_cont_right wow slideInRight"  data-wow-duration="1.5s">
      	<div class="seslp_des2wid3_features_list">
          
          <?php if($contents['title1']) { ?>
            <div class="seslp_des2wid3_features_list_item sesbasic_clearfix">
              <div class="seslp_des2wid3_feature_list_icon">
							<?php if($contents['icon_type1'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon1']; ?>"></i>
              <?php } elseif($contents['icon_type1'] == 0) { ?>
								<?php $photo1 = Engine_Api::_()->storage()->get($contents['photo1'], ''); ?>
								<?php if($photo1) { ?>
									<i style="background-image:url(<?php echo $photo1->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
              <div class="seslp_des2wid3_features_list_cont">
                <h3><?php echo $contents['title1']; ?></h3>
                <?php if($contents['description1']) { ?>
                  <p><?php echo $contents['description1']; ?></p>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
          
          <?php if($contents['title2']) { ?>
            <div class="seslp_des2wid3_features_list_item sesbasic_clearfix">
               <div class="seslp_des2wid3_feature_list_icon">
							<?php if($contents['icon_type2'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon2']; ?>"></i>
              <?php } elseif($contents['icon_type2'] == 0) { ?>
								<?php $photo2 = Engine_Api::_()->storage()->get($contents['photo2'], ''); ?>
								<?php if($photo2) { ?>
									<i style="background-image:url(<?php echo $photo2->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
              <div class="seslp_des2wid3_features_list_cont">
                <h3><?php echo $contents['title2']; ?></h3>
                <?php if($contents['description2']) { ?>
                  <p><?php echo $contents['description2']; ?></p>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
          
          <?php if($contents['title3']) { ?>
            <div class="seslp_des2wid3_features_list_item sesbasic_clearfix">
               <div class="seslp_des2wid3_feature_list_icon">
							<?php if($contents['icon_type3'] == 1) { ?>
								<i class="fa <?php echo $contents['fonticon3']; ?>"></i>
              <?php } elseif($contents['icon_type3'] == 0) { ?>
								<?php $photo3 = Engine_Api::_()->storage()->get($contents['photo3'], ''); ?>
								<?php if($photo3) { ?>
									<i style="background-image:url(<?php echo $photo3->getPhotoUrl(); ?>);"></i>
								<?php } ?>
              <?php } ?>
            </div>
              <div class="seslp_des2wid3_features_list_cont">
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
</div>
