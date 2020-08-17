<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $allParams=$this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/scripts/jquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/scripts/owl.carousel.js') ?>
<div class="slide sesbasic_clearfix sesbasic_bxs eblog_category_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
  <div class="eblogslide_<?php echo $this->identity; ?> owl-carousel owl-theme eblog_carousel" style="height:<?php echo $this->height ?>px;">
    <?php foreach( $this->paginator as $item): ?>
    <div class="eblog_category_carousel_item sesbasic_clearfix">
      <div class="eblog_category_carousel_item_thumb">       
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl();
        ?>
        <a href="<?php echo $href; ?>" class="eblog_list_thumb_img" style="height:<?php echo $this->width ?>px;width:<?php echo $this->width ?>px;">
          <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
          <!-- <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
          <div class="eblog_grid_btns"> 
            <?php if(isset($this->socialshareActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)){ ?>
            
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

            <?php } ?>
          </div>
          <?php } ?>-->
        </div>
        <div class="eblog_category_carousel_item_info sesbasic_clearfix">
          <?php if(isset($this->titleActive) ){ ?>
            <span class="eblog_category_carousel_item_info_title sesbasic_text_light">
              <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
                $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';
                echo $this->htmlLink($item->getHref(),$title) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
              <?php } ?>
            </span>
          <?php } ?>
          <!-- <?php if(isset($this->descriptionActive) ){ ?>
           <span class="eblog_category_carousel_item_info_des">
              <?php if(strlen($item->description) > $this->description_truncation_grid){ 
                      $description = mb_substr($item->description,0,$this->description_truncation_grid).'...';
                      echo $description; ?>
              <?php }else{ ?>
              	<?php echo $item->description ?>
              <?php } ?>
            </span>
          <?php } ?>
          <?php if(isset($this->countBlogsActive) ){ ?>
            <span class="eblog_category_carousel_item_info_stat">
              <?php echo $this->translate(array('%s BLOG', '%s BLOGS',$item->total_blogs_categories), $this->locale()->toNumber($item->total_blogs_categories)); ?>
            </span>
          <?php } ?> -->
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
  eblogJqueryObject(".eblog_carousel").owlCarousel({
  nav:true,
  dots:false,
  items:1,
	margin:10,
  loop:true,
  responsiveClass:true,
	autoplaySpeed: <?php echo $allParams['speed']; ?>,
	autoplay: autoplay_<?php echo $this->identity; ?>,
  responsive:{
    0:{
        items:1,
    },
    600:{
        items:7,
    },
  }
});
eblogJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
eblogJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
