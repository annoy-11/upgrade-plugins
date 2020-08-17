<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/styles/styles.css'); ?>
<?php if($this->bannervideo): ?>
  <?php 
    $videoUrl = $this->baseUrl() . '/' . $this->bannervideo;
    $bannervideo = $videoUrl;
    ?>
  <?php else: ?>
	<?php 
    $videoUrl = $this->baseUrl() . '/application/modules/Seshtmlbackground/externals/images/paralex-video.mp4';
    $bannervideo = $videoUrl;
	?>
  <?php endif; ?>
  <div class="seshtmlbackground_parallax_block_wraper sesbasic_bxs sesbasic_clearfix" style="height:<?php echo $this->height ?>px;">
    <div class="seshtmlbackground_parallax_block" style="height:<?php echo $this->height ?>px;">
      <div class="seshtmlbackground_parallax_background_container">
        <div id="video-wrap" class="seshtmlbackground_parallax_background video-wrap" style="height:100%;width:100%">
          <?php $extention = @end(explode('.',$videoUrl)); ?>
          <video  preload="metadata" loop id="my-video" autoplay muted>
            <source src="<?php echo $videoUrl?>" type="video/<?php echo $extention; ?>">
          </video>
        </div>
      </div>
      <div class="seshtmlbackground_parallax_foreground_container" style="height:<?php echo $this->height ?>px;">
        <div class="seshtmlbackground_parallax_foreground_content">
          <div>
          	<div class="seshtmlbackground_parallax_content">
              <?php if($this->paralextitle): ?>
									<?php echo $this->translate($this->paralextitle); ?>
            	<?php endif; ?>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
 <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/scripts/jquery.min.js'); ?>
 <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seshtmlbackground/externals/scripts/backgoundvideo.min.js'); ?>
<script>
	backgroundParalexSes(document).ready(function() {
			backgroundParalexSes('#my-video').backgroundVideo({
					$outerWrap: sesJqueryObject('.seshtmlbackground_parallax_background_container'),
					$videoWrap: sesJqueryObject('#video-wrap'),
					pauseVideoOnViewLoss: false,
					parallaxOptions: {
							effect: 1.9
					}
			});
	});
</script>