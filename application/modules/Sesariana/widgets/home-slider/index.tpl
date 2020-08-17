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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/scripts/typed.js'); ?>
<?php 
$contentArray = array();
foreach($this->sesariana_banner_content as $content) {
$contentArray[] = $this->translate($content);
}
?>
<script type="text/javascript">
	sesJqueryObject (function(){
    sesJqueryObject(".sesariana_slider_caption").typed({
      strings: <?php echo json_encode($contentArray); ?>,
      typeSpeed: 60,
      backDelay: 500,
      callback: function () { $(this) }
    });
	});
</script>
<div class="sesariana_home_slider clearfix sesbasic_bxs">
	<div class="sesariana_home_slider_img" style="background-image:url(<?php echo $this->bgimage; ?>);"></div>
  <div class="sesariana_home_slider_cont clearfix">
  	<div class="sesariana_home_slider_cont_inner clearfix">
      <?php if($this->bannerupimage): ?>
        <div class="sesariana_home_slider_cont_inner_img">
          <img src="<?php echo $this->bannerupimage; ?>" />
        </div>
      <?php endif; ?>
      <div class="sesariana_home_slider_cont_inner_cont">
        <h1><?php echo $this->translate($this->staticContent); ?></h1>
        <span id="typed" class="sesariana_slider_caption"></span>
      </div>
    </div>
  </div>
</div>
