<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmaterial/externals/styles/styles.css'); ?>
<?php if($this->bannerimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->bannerimage;
    $bannerimage = $photoUrl;
    ?>
  <?php else: ?>
	<?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesmaterial/externals/images/paralex-background.jpg';
    $bannerimage = $photoUrl;
	?>
  <?php endif; ?>
  <div class="sesmaterial_lp_parallax_block_wraper sesbasic_bxs sesbasic_clearfix" style="height:<?php echo $this->height ?>px;">
    <div class="sesmaterial_lp_parallax_block">
      <div class="sesmaterial_lp_parallax_background_container">
        <div class="sesmaterial_lp_parallax_background_img" style="background-image:url(<?php echo $photoUrl?>);"></div>
      </div>
      <div class="sesmaterial_lp_parallax_foreground_container" style="height:<?php echo $this->height ?>px;">
        <div class="sesmaterial_lp_parallax_foreground_content">
          <div>
          	<div class="sesmaterial_lp_parallax_content">
            	<?php if($this->paralextitle): ?>
								<?php echo $this->translate($this->paralextitle); ?>
            	<?php endif; ?>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>



