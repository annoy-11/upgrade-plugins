<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Eblog/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Eblog/externals/scripts/owl.carousel.js'); 
?>

<div class="eblog_blogs_ticker_container sesbasic_clearfix sesbasic_bxs">
	<div class="eblog_blogs_ticker_title">
		<?php echo $this->translate($this->title); ?>
  </div>
  <div class="eblog_blogs_ticker">
    <?php foreach( $this->paginatorRight as $item): ?>
	    <div class="eblog_blogs_ticker_item sesbasic_clearfix">
        <?php if($this->showCreationDate): ?>
        <div class="eblog_blogs_ticker_item_date sesbasic_text_light">
        	<?php echo ' '.date('M d, Y',strtotime($item->publish_date));?>
        </div>
        <?php endif; ?>
        <div class="eblog_blogs_ticker_item_title">
        	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php if($this->enableSlideshow): ?>
  <script type="text/javascript">
    eblogJqueryObject(document).ready(function() {
      eblogJqueryObject('.eblog_blogs_ticker').owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->autoplay ?>,
        autoplayTimeout:'<?php echo $this->speed ?>',
        autoplayHoverPause:true
      });
      eblogJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      eblogJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
  </script>
<?php endif; ?>
