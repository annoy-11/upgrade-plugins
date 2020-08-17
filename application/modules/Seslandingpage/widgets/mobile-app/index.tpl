<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbasic
 * @package    Sesbasic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
	$baseUrl = $this->layout()->staticBaseUrl;
	$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Seslandingpage/externals/styles/styles.css');
?>


<div class="seslp_mobileapp_section_wrapper seslp_blocks_wrapper sesbasic_bxs">
  <div class="seslp_mobileapp_section_bg" style="background-image:url(<?php echo Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage); ?>);"></div>
  <div class="seslp_mobileapp_section">
    <section class="seslp_blocks_container seslp_section_spacing">
      <?php if($this->slideimage) { ?>
      <div class="seslp_mobileapp_section_img wow fadeInLeft">
      	<img src="<?php echo Engine_Api::_()->seslandingpage()->getFileUrl($this->slideimage); ?>" alt="" />
      </div>
      <?php } ?>
      <div class="seslp_mobileapp_section_content wow fadeInRight">
        <?php if($this->heading) { ?>
      	<h2><?php echo $this->translate($this->heading);?></h2>
      	<?php } ?>
      	<?php if($this->description) { ?>
        <p><?php echo $this->translate($this->description);?></p>
        <?php } ?>
        <div class="sec_buttons">
          <?php if($this->buttonurl1) { ?>
        	<a href="<?php echo $this->buttonurl1; ?>" class="app_download_btn">
          	<img src="application/modules/Seslandingpage/externals/images/a-store.png" alt="" />
          </a>
          <?php } ?>
          <?php if($this->buttonurl2) { ?>
        	<a href="<?php echo $this->buttonurl2; ?>" class="app_download_btn">
          	<img src="application/modules/Seslandingpage/externals/images/g-play.png" alt="" />
          </a>
          <?php } ?>
        </div>
      </div>
    </section>
  </div>
</div>
