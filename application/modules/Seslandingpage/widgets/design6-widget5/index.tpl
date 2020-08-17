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
$baseURL = $this->layout()->staticBaseUrl;
$this->headLink()->appendStylesheet($baseURL . 'application/modules/Seslandingpage/externals/styles/template6.css');
$this->headScript()->appendFile($baseURL . 'application/modules/Seslandingpage/externals/scripts/jquery.js');
$this->headScript()->appendFile($baseURL . 'application/modules/Seslandingpage/externals/scripts/owl.carousel.js'); 
?>
<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->backgroundimage;
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des6wid5_wrapper">
	<div class="seslp_des6wid5_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
	<div class="seslp_blocks_container">
    <?php if($this->title) { ?>
      <h2 class="seslp_des6_head"><?php echo $this->title; ?></h2>
  	<?php } ?>
    <div class="seslp_des6_carousel seslp_des6_listings">
      <?php foreach($this->results as $result) { ?>
        <div class="seslp_des6_list_item">
          <article>
            <div class="seslp_des6_list_item_thumb">
              <a href="<?php echo $result->getHref(); ?>">
                <span class="seslp_des6_list_item_thumb_img seslp_animation" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
                <?php if($this->fonticon) { ?>
                  <span class="seslp_des6_list_item_icon"><i class="fa <?php echo $this->fonticon; ?>"></i></span>
                <?php } ?>
                <p class="seslp_des6_list_item_title"><?php echo $result->getTitle(); ?></p>
               </a>
            </div>
          </article>
        </div>
      <?php  } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
  seslpJqueryObject(document).ready(function() {
    seslpJqueryObject('.seslp_des6_carousel').owlCarousel({
      loop:false,
      items:3,
      margin:0,
      autoHeight:true,
      autoplay:true,
      autoplayTimeout:'1000',
      autoplayHoverPause:true,	
		responsiveClass:true,
		responsive:{
				0:{
						items:1,
						nav:true
				},
				600:{
						items:3,
						nav:false
				},
				1000:{
						items:3,
						nav:true,
						loop:false
				}
		}
 
    });
    seslpJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
    seslpJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
  });
</script>