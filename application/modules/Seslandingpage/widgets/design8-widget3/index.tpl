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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/styles/template8.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslandingpage/externals/scripts/slick.min.js'); ?>
<?php $randonNumber = $this->identity; ?>

<?php if($this->backgroundimage): ?>
  <?php 
    $photoUrl = Engine_Api::_()->seslandingpage()->getFileUrl($this->backgroundimage);
    $backgroundimage = $photoUrl;
  ?>
<?php else: ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesspectromedia/externals/images/paralex-background.jpg';
    $backgroundimage = $photoUrl;
  ?>
<?php endif; ?>
<div class="seslp_blocks_wrapper sesbasic_clearfix sesbasic_bxs seslp_des8wid3_wrapper">
	<div class="seslp_des8wid3_bg" style="background-image:url(<?php echo $backgroundimage ?>);"></div>
  <?php if($this->title) { ?>
    <div class="seslp_des8_head">
      <h2><?php echo $this->title; ?></h2>
    </div>
  <?php } ?>
  <div class="seslp_des8wid3_listing sesbasic_clearfix seslp_des8wid3_carousel_<?php echo $randonNumber; ?>">
  	<?php foreach($this->results as $result) { ?>
      <div class="seslp_des8wid3_list_item seslp_animation">
        <div class="seslp_des8wid3_list_item_thumb">
          <a href="<?php echo $result->getHref(); ?>">
            <span class="seslp_animation seslp_des8wid3_list_item_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl() ?>);"></span>
            <div class="seslp_animation seslp_des8wid3_list_item_cont">
              <?php if($this->fonticon) { ?>
              <i class="fa <?php echo $this->fonticon; ?>"></i>
              <?php } ?>
              <p class="seslp_des8wid3_list_item_title"><?php echo $result->getTitle(); ?></p>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<script type="text/javascript">
sesJqueryObject('.seslp_des8wid3_carousel_<?php echo $randonNumber; ?>').slick({
  centerMode: true,
  centerPadding: '0px',
  slidesToShow: 5,
	centerPadding: '60px',
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 1
      }
    }
  ]
});
</script>
