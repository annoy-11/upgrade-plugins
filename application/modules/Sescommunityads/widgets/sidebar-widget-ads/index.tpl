<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescommunityads/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescommunityads/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescommunityads/externals/scripts/owl.carousel.js'); 
?>
<div class="sescmads_browse_ads_listing sesbasic_bxs">
	<ul class="sescmads_ads_listing" id="sescomm_widget_<?php echo $randonNumber; ?>">
<?php foreach($this->paginator as $ad){ ?>
  <?php if($ad->type == "promote_content_cnt" || $ad->type == "promote_website_cnt"){ ?>
    <?php include('application/modules/Sescommunityads/views/scripts/widget-data/_promoteContent.php'); ?>
  <?php } ?>
<?php } ?>
	</ul>
</div>
<script type="text/javascript">
  displayCommunityadsCarousel();
</script>