<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Seslisting/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Seslisting/externals/scripts/owl.carousel.js'); 
?>

<div class="seslisting_listings_ticker_container sesbasic_clearfix sesbasic_bxs">
	<div class="seslisting_listings_ticker_title">
		<?php echo $this->translate($this->title); ?>
  </div>
  <div class="seslisting_listings_ticker">
    <?php foreach( $this->paginatorRight as $item): ?>
	    <div class="seslisting_listings_ticker_item sesbasic_clearfix">
        <?php if($this->showCreationDate): ?>
        <div class="seslisting_listings_ticker_item_date sesbasic_text_light">
        	<?php echo ' '.date('M d, Y',strtotime($item->publish_date));?>
        </div>
        <?php endif; ?>
        <div class="seslisting_listings_ticker_item_title">
        	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php if($this->enableSlideshow): ?>
  <script type="text/javascript">
    seslistingJqueryObject(document).ready(function() {
      seslistingJqueryObject('.seslisting_listings_ticker').owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->autoplay ?>,
        autoplayTimeout:'<?php echo $this->speed ?>',
        autoplayHoverPause:true
      });
      seslistingJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      seslistingJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
  </script>
<?php endif; ?>
