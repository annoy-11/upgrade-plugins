<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/jQuery/jquery.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/scripts/owl.carousel.js') ?>
<div class="einstaclone_category_carousel_wrapper einstaclone_clearfix einstaclone_bxs">
  <div class="einstaclone_cat_header">
    <h2 class="einstaclone_text_light"><?php echo $this->translate("Discover People"); ?></h2>
    <a href="members/browse"><?php echo $this->translate("See All"); ?></a>
  </div>
  <div class="einstaclone_category_carousel owl-carousel">
    <?php foreach($this->results as $item) { ?>
      <div class="einstaclone_category_carousel_item einstaclone_clearfix einstaclone_bg">
        <a href="<?php echo $item->getHref(); ?>"><?php echo $this->itemPhoto($item, 'thumb.icon'); ?></a>
        <h3><a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a></h3>
        <p class="einstaclone_text_light"><?php echo $this->translate("Followed by %s member", $item->member_count); ?></p>
        <div class="_btn">
          <?php echo $this->partial('_addfriend.tpl', 'einstaclone', array('subject' => $item)); ?>
        </div>
      </div>
     <?php } ?>
  </div>
</div>
<script type="text/javascript">
  scriptJquery(".einstaclone_category_carousel").owlCarousel({
    nav:true,
    dots:false,
    loop:false,
    items:5,
    margin:20,
    responsiveClass:true,
    autoplaySpeed:2000,
    autoplay: true,
    responsive:{
      0:{
          items:2,
      },
      600:{
          items:3,
      },
			900:{
          items:5,
      },
    }
  });
  scriptJquery(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  scriptJquery(".owl-next").html('<i class="fa fa-angle-right"></i>');
  if(scriptJquery('.owl-item').length > 5){
    options.loop=true;
  }
</script>
