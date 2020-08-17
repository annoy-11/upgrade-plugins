<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/styles/styles.css'); ?>
<?php if($this->bannerimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->bannerimage;
    $bannerimage = $photoUrl;
    ?>
  <?php else: ?>
	<?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesariana/externals/images/parallax-bg.jpg';
    $bannerimage = $photoUrl;
	?>
  <?php endif; ?>
  <div class="ariana_parallax_block_wrapper sesbasic_bxs sesbasic_clearfix" style="height:<?php echo $this->height ?>px;">
    <div class="ariana_parallax_block">
      <div class="ariana_parallax_background_container">
        <div class="ariana_parallax_background_img" style="background-image:url(<?php echo $photoUrl?>);"></div>
      </div>
      <div class="ariana_parallax_foreground_container" style="height:<?php echo $this->height ?>px;">
        <div class="ariana_parallax_foreground_content">
          <div>
          	<div class="ariana_parallax_content">
            	<?php if($this->paralextitle): ?>
								<?php echo $this->translate($this->paralextitle); ?>
            	<?php endif; ?>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>