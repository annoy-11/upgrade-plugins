<?php

/**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Sesblog
 * @copyright  Copyright 2014-2020 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2017-06-20 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

?>

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesblog/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesblog/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesblog/externals/scripts/owl.carousel.js'); 
?>

<div class="sesblog_blogs_ticker_container sesbasic_clearfix sesbasic_bxs">
	<div class="sesblog_blogs_ticker_title">
		<?php echo $this->translate($this->title); ?>
  </div>
  <div class="sesblog_blogs_ticker">
    <?php foreach( $this->paginatorRight as $item): ?>
	    <div class="sesblog_blogs_ticker_item sesbasic_clearfix">
        <?php if($this->showCreationDate): ?>
        <div class="sesblog_blogs_ticker_item_date sesbasic_text_light">
        	<?php echo ' '.date('M d, Y',strtotime($item->publish_date));?>
        </div>
        <?php endif; ?>
        <div class="sesblog_blogs_ticker_item_title">
        	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php if($this->enableSlideshow): ?>
  <script type="text/javascript">
    sesblogJqueryObject(document).ready(function() {
      sesblogJqueryObject('.sesblog_blogs_ticker').owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->autoplay ?>,
        autoplayTimeout:'<?php echo $this->speed ?>',
        autoplayHoverPause:true
      });
      sesblogJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sesblogJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
  </script>
<?php endif; ?>
