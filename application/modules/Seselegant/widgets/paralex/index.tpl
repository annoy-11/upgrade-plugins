<?php
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seselegant/externals/styles/styles.css'); ?>
<?php if($this->bannerimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->bannerimage;
    $bannerimage = $photoUrl;
    ?>
  <?php else: ?>
	<?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Seselegant/externals/images/parallax-bg.jpg';
    $bannerimage = $photoUrl;
	?>
  <?php endif; ?>
  <div class="elegant_parallax_block_wrapper sesbasic_bxs sesbasic_clearfix" style="height:<?php echo $this->height ?>px;">
    <div class="elegant_parallax_block">
      <div class="elegant_parallax_background_container">
        <div class="elegant_parallax_background_img" style="background-image:url(<?php echo $photoUrl?>);"></div>
      </div>
      <div class="elegant_parallax_foreground_container" style="height:<?php echo $this->height ?>px;">
        <div class="elegant_parallax_foreground_content">
          <div>
          	<div class="elegant_parallax_content">
            	<?php if($this->paralextitle): ?>
								<?php echo $this->translate($this->paralextitle); ?>
            	<?php endif; ?>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>



