<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php if($this->viewer()->getIdentity()):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<div class="sespage_category_carousel_wrapper sespage_carousel_h_wrapper ">
  <div class="slide sesbasic_clearfix sesbasic_bxs sespage_slick_slider_container <?php echo $this->params['isfullwidth'] ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->params['height'] ?>px;display:none;">
    <div class="pageslide_<?php echo $this->identity; ?> sespage_category_carousel">
      <?php foreach( $this->paginator as $item): ?>
      <?php if($showFollowButton):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $item->category_id,'resource_type' => 'sespage_category')); ?>
        <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
        <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
      <?php endif;?>
      <div class="sespage_category_carousel_item sesbasic_clearfix sespage_grid_btns_wrap" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
        <div class="sespage_category_carousel_item_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">       
          <?php $href = $item->getHref(); $imageURL = $item->getPhotoUrl();?>
          <a href="<?php echo $href; ?>" class="sespage_list_thumb_img">
            <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
          </a>
          <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="sespage_grid_btns"> 
              <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')){ ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->params['socialshare_icon_limit'])); ?>
              <?php } ?>
            </div>
           <?php } ?>
          </div>
          <div class="sespage_category_carousel_item_info sesbasic_clearfix centerT">
            <?php if(isset($this->titleActive) ){ ?>
              <span class="sespage_category_carousel_item_info_title">
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
             <span class="sespage_category_carousel_item_info_des">
                <?php if(strlen($item->description) > $this->params['description_truncation']){ 
                        $description = mb_substr($item->description,0,($this->params['description_truncation'] - 3)).'...';
                        echo $description; ?>
                <?php }else{ ?>
                  <?php echo $item->description ?>
                <?php } ?>
              </span>
            <?php } ?>
            <?php if(isset($this->countPagesActive) ){ ?>
              <span class="sespage_category_carousel_item_info_stat">
                <?php echo $this->translate(array('%s Page', '%s Pages',$item->total_page_categories), $this->locale()->toNumber($item->total_page_categories)); ?>
              </span>
            <?php } ?>
            <?php if($showFollowButton && isset($this->followButtonActive)):?>
              <span class="sespage_category_carousel_item_info_button">
                <a href='javascript:;' data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sespage_category_follow sespage_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
              </span>
            <?php endif;?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/scripts/slick/slick.js') ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->params['isfullwidth']){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('sespage_category_carousel');
		<?php } ?>
		<?php if($this->params['autoplay']){ ?> var playAu = true; <?php }else{ ?> var playAu  = false; <?php } ?>
		sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			speed: <?php echo $this->params['speed'] ?>,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			autoplay:playAu,
		});
  });
	sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').on('init', function(page, slick, currentSlide, nextSlide){
		sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').parent().show();
		console.log('done');
	});
</script>