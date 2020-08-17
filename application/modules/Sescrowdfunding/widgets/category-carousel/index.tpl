<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sescrowdfunding_category_carousel_wrapper sescrowdfunding_carousel_h_wrapper ">
  <div class="slide sesbasic_clearfix sesbasic_bxs sescrowdfunding_slick_slider_container <?php echo $this->params['isfullwidth'] ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->params['height'] ?>px;display:none;">
    <div class="crowdfundingslide_<?php echo $this->identity; ?> sescrowdfunding_category_carousel">
      <?php foreach( $this->paginator as $item): ?>
      <div class="sescrowdfunding_category_carousel_item sesbasic_clearfix sescrowdfunding_grid_btns_wrap" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
        <div class="sescrowdfunding_category_carousel_item_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">       
          <?php $href = $item->getHref(); $imageURL = $item->getPhotoUrl();?>
          <a href="<?php echo $href; ?>" class="sescrowdfunding_list_thumb_img">
            <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
          </a>
          <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="sescrowdfunding_grid_btns"> 
              <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')){ ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->params['socialshare_icon_limit'])); ?>
              <?php } ?>
            </div>
           <?php } ?>
          </div>
          <div class="sescrowdfunding_category_carousel_item_info sesbasic_clearfix centerT">
            <?php if(isset($this->titleActive) ){ ?>
              <span class="sescrowdfunding_category_carousel_item_info_title">
                <?php if(strlen($item->getTitle()) > $this->params['title_truncation']){ 
                  $title = mb_substr($item->getTitle(),0,($this->params['title_truncation'] - 3 )).'...';
                  echo $this->htmlLink($item->getHref(),$this->translate($title)) ?>
                <?php }else{ ?>
                  <?php 
                  echo $this->htmlLink($item->getHref(),$this->translate($item->getTitle()) )?>
                <?php } ?>
              </span>
            <?php } ?>
             <?php if(isset($this->descriptionActive) ){ ?>
             <span class="sescrowdfunding_category_carousel_item_info_des">
                <?php if(strlen($item->description) > $this->params['description_truncation']){ 
                        $description = mb_substr($item->description,0,($this->params['description_truncation'] - 3)).'...';
                        echo $description; ?>
                <?php }else{ ?>
                  <?php echo $item->description ?>
                <?php } ?>
              </span>
            <?php } ?>
            <?php if(isset($this->countCrowdfundingsActive) ){ ?>
              <span class="sescrowdfunding_category_carousel_item_info_stat">
                <?php echo $this->translate(array('%s Crowdfunding', '%s Crowdfundings',$item->total_crowdfundings_categories), $this->locale()->toNumber($item->total_crowdfundings_categories)); ?>
              </span>
            <?php } ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/slick/slick.js') ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->params['isfullwidth']){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('sescrowdfunding_category_carousel');
		<?php } ?>
		<?php if($this->params['autoplay']){ ?> var playAu = true; <?php }else{ ?> var playAu  = false; <?php } ?>
		sesBasicAutoScroll('.crowdfundingslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			speed: <?php echo $this->params['speed'] ?>,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			autoplay:playAu,
		});
  });
	sesBasicAutoScroll('.crowdfundingslide_<?php echo $this->identity; ?>').on('init', function(page, slick, currentSlide, nextSlide){
		sesBasicAutoScroll('.crowdfundingslide_<?php echo $this->identity; ?>').parent().show();
	});
</script>
