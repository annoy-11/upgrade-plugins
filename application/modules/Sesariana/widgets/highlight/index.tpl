<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/styles/styles.css'); ?>
<?php if($this->design == 3){ ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesariana/externals/scripts/slick.min.js'); ?>
<?php $randonNumber = $this->identity; ?>

<div class="sesariana_content_carousel_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
  <div class="sesariana_content_carousel_main clearfix">
    <div class="sesariana_content_carousel sesariana_content_carousel_<?php echo $randonNumber; ?>">
      <?php  foreach($this->result as $result){    ?>
        <div class="sesariana_content_carousel_item">
        	<a href="<?php echo $result->getHref(); ?>">
            <div class="sesariana_content_carousel_item_photo">
            	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
            </div>
            <div class="sesariana_content_carousel_item_cont clearfix">
            	<?php echo $this->translate($result->getTitle()); ?>
            </div>
        	</a>    
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
sesJqueryObject('.sesariana_content_carousel_<?php echo $randonNumber; ?>').slick({
  centerMode: true,
  centerPadding: '0px',
  slidesToShow: 3,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: true,
        centerMode: false,
        centerPadding: '0',
        slidesToShow: 1
      }
    }
  ]
});
</script>
<?php } else if($this->design == 2){ ?>
<div class="seariana_highlights_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
  <div class="seariana_highlights_cont clearfix">
  	<div class="seariana_highlights_cont_row clearfix">
    <?php  foreach($this->result as $result){    ?>
      <div class="seariana_highlights_item">
        <div class="seariana_highlights_item_inner">
          <div class="seariana_highlights_item_photo">
            <a href="<?php echo $result->getHref(); ?>">
              <img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
            </a>
          </div>
          <div class="seariana_highlights_item_cont clearfix">
          	<a href="<?php echo $result->getHref(); ?>">
            	<?php echo $this->translate($result->getTitle()); ?>             
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<style>
.seariana_highlights_item:hover a,
.seariana_content_item:hover .seariana_content_item_title{
  background-color:#<?php echo $this->contentbackgroundcolor ?> !important;
}
</style>
<?php }else{ ?>
<div class="seariana_content_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <?php if($this->widgetdescription): ?>
    <p><?php echo $this->widgetdescription; ?></p>
  <?php endif; ?>
	<div class="seariana_content_inner clearfix">
  <?php 
    $counter = 1;
    foreach($this->result as $result){ 
    if($counter == 1){
    ?>
  	<div class="seariana_content_item_big">
    	<div class="seariana_content_item_big_img">
      	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
      </div>
      <a href="<?php echo $result->getHref(); ?>" class="seariana_content_item_big_cont">
      	<div class="seariana_content_item_big_cont_inner">
        	<div class="seariana_content_item_big_cont_inner_info">
            <div class="seariana_content_item_big_cont_inner_title">
              <?php echo $this->translate($result->getTitle()); ?>
            </div>
            <div class="seariana_content_item_big_cont_inner_des">
              <?php echo $this->translate($result->getDescription()); ?>
            </div>
            <?php if($result->getType() == 'sesevent_event'){ ?>
              <div class="seariana_content_item_big_cont_inner_stat">
                <?php echo $this->eventStartEndDates($result);?>
              </div>
            <?php } ?>
          </div>
          <div class="seariana_content_item_big_cont_inner_btn">View More</div>
        </div>
        <div class="seariana_content_item_big_cont_inner_arrow">
          <i class="fa fa-arrow-right" aria-hidden="true"></i>
        </div>
      </a>
    </div>
    <?php }else{ ?>
    <div class="seariana_content_item">
    	<a href="<?php echo $result->getHref(); ?>">
      	<div class="seariana_content_item_img">
        	<img src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
        </div>
        <div class="seariana_content_item_title">
        	<?php echo $this->translate($result->getTitle()); ?>
        </div>
      </a>
    </div>
    <?php } ?>
 <?php 
  $counter++;
  } ?>
  </div>
	
</div>
<style>
.seariana_content_item_big_cont:before,
.seariana_content_item_big:hover .seariana_content_item_big_cont_inner_arrow{
  background-color:#<?php echo $this->contentbackgroundcolor ?> !important;
}
</style>
<?php } ?>