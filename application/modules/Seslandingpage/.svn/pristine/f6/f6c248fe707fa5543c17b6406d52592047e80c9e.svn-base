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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template2.css'); ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des2wid2_wrapper">
	<div class="seslp_des2wid2_column seslp_des2wid2_column_left">
  	<div class="seslp_des2wid2_column_cont sesbasic_clearfix">
      <?php if($this->leftsideheading) { ?>
        <div class="seslp_des2wid2_column_title">
          <?php echo $this->leftsideheading; ?>
        </div>
      <?php } ?>
      <?php if($this->leftsidedescription) { ?>
      <div class="seslp_des2wid2_column_des">
      	<?php echo $this->leftsidedescription; ?>
      </div>
      <?php } ?>
      <?php if($this->leftsidefonticon || $this->leftsidereadmoretext || $this->leftsidereadmoreurl) { ?>
        <div class="seslp_des2wid2_column_btns">
          <?php if($this->leftsidefonticon) { ?>
          <span class="seslp_des2wid2_column_icon"><i class="fa <?php echo $this->leftsidefonticon; ?>"></i></span>
          <?php } ?>
          <?php if($this->leftsidereadmoretext && $this->leftsidereadmoreurl) { ?>
            <a href="<?php echo $this->leftsidereadmoreurl; ?>" class="seslp_des2wid2_column_btn seslp_animation"><?php echo $this->leftsidereadmoretext; ?></a>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="seslp_des2wid2_column_listing sesbasic_clearfix">
      <?php foreach($this->leftsideresults as $leftsideresult): ?>
        <div class="seslp_des2wid2_listing_item">
          <a href="<?php echo $leftsideresult->getHref(); ?>">
            <span class="seslp_des2wid2_listing_item_img seslp_animation" style="background-image:url(<?php echo $leftsideresult->getPhotoUrl() ?>);"></span>
            <span class="seslp_des2wid2_listing_item_overlay"></span>
            <div class="seslp_des2wid2_listing_item_icon seslp_animation"><i class="fa <?php echo $this->leftsidefonticon; ?>"></i></div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  
  <div class="seslp_des2wid2_column seslp_des2wid2_column_right">
  	<div class="seslp_des2wid2_column_cont sesbasic_clearfix">
      <?php if($this->rightsideheading) { ?>
        <div class="seslp_des2wid2_column_title">
          <?php echo $this->rightsideheading; ?>
        </div>
      <?php } ?>
      <?php if($this->rightsidedescription) { ?>
        <div class="seslp_des2wid2_column_des">
          <?php echo $this->rightsidedescription; ?>
        </div>
      <?php } ?>
      <?php if($this->rightsidefonticon || $this->rightsidereadmoretext || $this->rightsidereadmoreurl) { ?>
        <div class="seslp_des2wid2_column_btns">
          <?php if($this->rightsidefonticon) { ?>
            <span class="seslp_des2wid2_column_icon"><i class="fa <?php echo $this->rightsidefonticon; ?>"></i></span>
          <?php } ?>
          <?php if($this->rightsidereadmoretext && $this->rightsidereadmoreurl) { ?>
            <a href="<?php echo $this->rightsidereadmoreurl; ?>" class="seslp_des2wid2_column_btn seslp_animation"><?php echo $this->rightsidereadmoretext; ?></a>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="seslp_des2wid2_column_listing sesbasic_clearfix">
      <?php foreach($this->rightsideresults as $rightsideresult): ?>
        <div class="seslp_des2wid2_listing_item">
          <a href="<?php echo $rightsideresult->getHref(); ?>">
            <span class="seslp_des2wid2_listing_item_img seslp_animation" style="background-image:url(<?php echo $rightsideresult->getPhotoUrl() ?>);"></span>
            <span class="seslp_des2wid2_listing_item_overlay"></span>
            <div class="seslp_des2wid2_listing_item_icon seslp_animation"><i class="fa <?php echo $this->rightsidefonticon; ?>"></i></div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>