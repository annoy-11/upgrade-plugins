<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<div class="slide sesbasic_clearfix sesbasic_bxs edocument_category_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
  <div class="documentslide_<?php echo $this->identity; ?>">
    <?php foreach( $this->paginator as $item): ?>
    <div class="edocument_category_carousel_item sesbasic_clearfix edocument_grid_btns_wrap" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
      <div class="edocument_category_carousel_item_thumb" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">       
          <a href="<?php echo $item->getHref(); ?>" class="edocument_list_thumb_img">
            <span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);"></span>
          </a>
          <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="edocument_grid_btns"> 
              <?php if(isset($this->socialshareActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.enable.sharing', 1)) { ?>
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="edocument_category_carousel_item_info sesbasic_clearfix centerT">
          <?php if(isset($this->titleActive) ){ ?>
            <span class="edocument_category_carousel_item_info_title">
              <?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 
                $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';
                echo $this->htmlLink($item->getHref(),$title) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
              <?php } ?>
            </span>
          <?php } ?>
           <?php if(isset($this->descriptionActive) ){ ?>
           <span class="edocument_category_carousel_item_info_des">
              <?php if(strlen($item->description) > $this->description_truncation_grid){ 
              $description = mb_substr($item->description,0,$this->description_truncation_grid).'...';
              echo $description; ?>
              <?php }else{ ?>
              	<?php echo $item->description ?>
              <?php } ?>
            </span>
          <?php } ?>
          <?php if(isset($this->countDocumentsActive) ){ ?>
            <span class="edocument_category_carousel_item_info_stat">
              <?php echo $this->translate(array('%s DOCUMENT', '%s DOCUMENTS',$item->total_documents_categories), $this->locale()->toNumber($item->total_documents_categories)); ?>
            </span>
          <?php } ?>
        </div>
    	</div>
    <?php endforeach; ?>
  </div>
</div>
<?php
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Edocument/externals/scripts/slick/slick.js');
?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->isfullwidth){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('edocument_category_carousel');
		<?php } ?>
		<?php if($this->autoplay){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
		sesBasicAutoScroll('.documentslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			autoplaySpeed: <?php echo $this->speed ?>,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			autoplay: autoplay_<?php echo $this->identity; ?>,
		});
  });
</script>
