<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $allParams=$this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/jquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesevent/externals/scripts/owl.carousel.js') ?>
<div class="slide sesbasic_clearfix sesbasic_bxs sesevent_category_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
  <div class="eventslide_<?php echo $this->identity; ?> sesevent_carousel">
    <?php foreach( $this->paginator as $item): ?>
    <div class="sesevent_category_carousel_item sesbasic_clearfix sesevent_grid_btns_wrap">
      <div class="sesevent_category_carousel_item_thumb">       
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl();
        ?>
        <a href="<?php echo $href; ?>" class="sesevent_list_thumb_img" style="height:<?php echo $this->width ?>px;width:<?php echo $this->width ?>px;">
          <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
        </div>
        <div class="sesevent_category_carousel_item_info sesbasic_clearfix centerT">
          <?php if(isset($this->titleActive) ){ ?>
            <span class="sesevent_category_carousel_item_info_title">
              <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
                $title = mb_substr($item->getTitle(),0,($this->title_truncation_grid - 3 )).'...';
                echo $this->htmlLink($item->getHref(),$this->translate($title)) ?>
              <?php }else{ ?>
              	<?php 
              	echo $this->htmlLink($item->getHref(),$this->translate($item->getTitle()) )?>
              <?php } ?>
            </span>
          <?php } ?>
        </div>
    	</div>
    <?php endforeach; ?>
  </div>
</div>
<script type="text/javascript">
  <?php if($allParams['autoplay']){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
  seseventJqueryObject(".eventslide_<?php echo $this->identity; ?>").owlCarousel({
  nav:true,
  dots:false,
  items:1,
	margin:10,
  loop:<?php if($this->total_limit_data <= $this->limit_data){echo 1 ;}else{ echo 0 ;} ?>,
  responsiveClass:true,
	autoplaySpeed: <?php echo $this->speed; ?>,
  autoplay:<?php echo $this->autoplay; ?>,
  responsive:{
    0:{
        items:1,
    },
    600:{
        items:3,
    },
		1000:{
        items:<?php echo $this->total_limit_data; ?>,
    },
  }
});
seseventJqueryObject(".owl-prev").html('<i class="fas fa-angle-left"></i>');
seseventJqueryObject(".owl-next").html('<i class="fas fa-angle-right"></i>');
</script>
