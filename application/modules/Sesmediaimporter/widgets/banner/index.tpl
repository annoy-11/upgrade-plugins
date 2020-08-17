<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmediaimporter/externals/styles/styles.css'); ?> 

<div class="sesmdimp_cover_wrapper <?php echo $this->full_width ? 'isfullwith' : ''; ?>  sesbasic_bxs sesbasic_clearfix">
  <div class="sesmdimp_cover">
  	<div class="sesmdimp_cover_inner">
			<div class="sesmdimp_cover_cont">
      	<h1><?php echo $this->translate($this->title_text);?></h1>
        <p><?php echo $this->translate($this->description_text);?></p>
        <?php if($this->ios_url || $this->android_url){ ?>
        <div class="sesmdimp_cover_buttons">
          <?php if($this->ios_url){ ?>
        	<a href="<?php echo $this->ios_url; ?>" target="_blank"><img src="application/modules/Sesmediaimporter/externals/images/ios-app-store-icon.svg" alt="" /></a>
          <?php } ?>
          <?php if($this->android_url){ ?>
          <a href="<?php echo $this->android_url; ?>" target="_blank"><img src="application/modules/Sesmediaimporter/externals/images/google-play-store-icon.svg" alt="" /></a>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <div class="sesmdimp_cover_img">
      	<img src="application/modules/Sesmediaimporter/externals/images/banner-img.png" alt="" />
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.sesmdimp_cover_wrapper .sesmdimp_cover{
  background: $theme_button_background_color;
  background: -webkit-linear-gradient(to left, <?php echo '#'.$this->bgcolor; ?>, #eef2f3);
  background: linear-gradient(to left, <?php echo '#'.$this->bgcolor; ?>, #eef2f3);
}
</style>
<script type="application/javascript">
  sesJqueryObject('#global_wrapper').css('padding',0);
</script>
