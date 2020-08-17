<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $allParams=$this->allParams;   ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/scripts/jquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/scripts/owl.carousel.js') ?>
<div class="slide sesbasic_clearfix sesbasic_bxs epetition_category_carousel_wrapper <?php echo $allParams['isfullwidth'] ? 'isfull_width' : '' ; ?>" style="height:<?php echo $allParams['height']; ?>px;">
  <div class="petitionslide_<?php echo $this->identity; ?> owl-carousel owl-theme epetition_carousel" style="height:<?php echo $allParams['height']; ?>px;">
    <?php foreach( $this->paginators as $item): ?>
    <div class="epetition_category_carousel_item sesbasic_clearfix epetition_grid_btns_wrap" style="height:<?php echo $allParams['height']; ?>px;">
      <div class="epetition_category_carousel_item_thumb" style="height:<?php echo $this->height ?>px;">       
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl('../images/transprant-bg.png');
        ?>
        <a href="<?php echo $href; ?>" class="epetition_list_thumb_img">
          <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
          <?php if(in_array('socialshare',$allParams['show_criteria'])) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
          <div class="epetition_grid_btns"> 
            <?php if(in_array('socialshare',$allParams['show_criteria'])  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)){ ?>
            
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' =>$allParams['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $allParams['socialshare_icon_limit'])); ?>

            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <div class="epetition_category_carousel_item_info sesbasic_clearfix centerT">
          <?php if(in_array('title',$allParams['show_criteria'])){   ?>
            <span class="epetition_category_carousel_item_info_title">
              <?php if(strlen($item->getTitle()) > $allParams['title_truncation_grid']){
                $title = mb_substr($item->getTitle(),0,$allParams['title_truncation_grid']).'...';
                echo $this->htmlLink($item->getHref(),$title) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
              <?php } ?>
            </span>
          <?php } ?>
           <?php if(in_array('description',$allParams['show_criteria']) ){ ?>
           <span class="epetition_category_carousel_item_info_des">
              <?php if(strlen($item->description) > $allParams['description_truncation_grid']){
                      $description = mb_substr($item->description,0,$allParams['description_truncation_grid']).'...';
                      echo $description; ?>
              <?php }else{ ?>
              	<?php echo $item->description ?>
              <?php } ?>
            </span>
          <?php } ?>
          <?php if(in_array('countPetitions',$allParams['show_criteria']) && isset($item->total_petitions_categories)){   ?>
            <span class="epetition_category_carousel_item_info_stat">
              <?php echo $item->total_petitions_categories; ?>
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
  sesblogJqueryObject(".epetition_carousel").owlCarousel({
  nav:true,
  dots:false,
  items:1,
  loop:true,
  responsiveClass:true,
	autoplay:true,
	autoplaySpeed: <?php echo $allParams['speed']; ?>,
	autoplay: autoplay_<?php echo $this->identity; ?>,
  responsive:{
    0:{
        items:1,
    },
    600:{
        items:4,
    },
  }
});
sesblogJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
sesblogJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
