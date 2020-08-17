<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesproduct/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesproduct/externals/scripts/owl.carousel.js'); 
?>

<div class="sesproduct_products_ticker_container sesbasic_clearfix sesbasic_bxs">
	<div class="sesproduct_products_ticker_title">
		<?php echo $this->translate($this->title); ?>
  </div>
  <div class="sesproduct_products_ticker">
    <?php foreach( $this->paginatorRight as $item): ?>
	    <div class="sesproduct_products_ticker_item sesbasic_clearfix">
        <?php if($this->showCreationDate): ?>
        <div class="sesproduct_products_ticker_item_date sesbasic_text_light">
        	<?php echo ' '.date('M d, Y',strtotime($item->publish_date));?>
        </div>
        <?php endif; ?>
        <div class="sesproduct_products_ticker_item_title">
        	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php if($this->enableSlideshow): ?>
  <script type="text/javascript">
    sesproductJqueryObject(document).ready(function() {
      sesproductJqueryObject('.sesproduct_products_ticker').owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->autoplay ?>,
        autoplayTimeout:'<?php echo $this->speed ?>',
        autoplayHoverPause:true
      });
      sesproductJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sesproductJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
  </script>
<?php endif; ?>
