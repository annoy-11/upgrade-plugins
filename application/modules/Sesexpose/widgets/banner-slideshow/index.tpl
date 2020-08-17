<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesexpose/externals/styles/styles.css'); ?>
<?php $identity = $this->identity; ?>
<style>
#slideshow_container	{ width:512px; height:384px; position:relative; }
#slideshow_container img { display:block; position:absolute; top:0; left:0; z-index:1; }
</style>
<script>
window.addEvent('domready',function() {
	/* settings */
	var showDuration = 3000;
	var container = $('slideshow_container_<?php echo $identity; ?>');
	var images = container.getElements('img');
	var currentIndex = 0;
	var interval;
	/* opacity and fade */
	images.each(function(img,i){ 
		if(i > 0) {
			img.set('opacity',0);
		}
	});
	/* worker */
	var show = function() {
    sesJqueryObject('.expose_banner_content').find('div.expose_banner_content_inner').hide();    
		images[currentIndex].fade('out');
		images[currentIndex = currentIndex < images.length - 1 ? currentIndex+1 : 0].fade('in');
    sesJqueryObject('.expose_banner_content').children().eq(currentIndex).show();
	};
	/* start once the page is finished loading */
	window.addEvent('load',function(){
		interval = show.periodical(showDuration);
	});
});
</script>
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:900" rel="stylesheet">
<div id="slideshow_container_<?php echo $identity; ?>"  class="expose_banner_container_wrapper sesbasic_bxs<?php if($this->full_width){ ?> isfull<?php } ?> " style="height:<?php echo $this->height.'px'; ?>;">
  <div class="expose_banner_container">
		<div class="expose_banner_img_container" style="height:<?php echo $this->height.'px'; ?>;">
			<?php foreach($this->paginator as $itemdata): ?>
				<?php $item = Engine_Api::_()->getItem('sesexpose_slide',$itemdata->slide_id); ?>
				<img src="<?php echo $item->getFilePath('file_id'); ?>" />
			<?php endforeach; ?>
		</div>
		<div class="expose_banner_content" style="height:<?php echo $this->height.'px'; ?>;">
      <?php $counter = 1;
      foreach($this->paginator as $itemdata): ?>
        <div class="expose_banner_content_inner" <?php if($counter > 1){ ?> style="display:none;" <?php } ?>>
          <?php if($itemdata->title != '' || $itemdata->description  != '') { ?>	
            <?php if($itemdata->title != ''){ ?>
              <h2 class="expose_banner_title" style="color:#<?php echo $itemdata->title_button_color; ?>"><?php echo $itemdata->title; ?></h2>
            <?php } ?>
          <?php } ?>
          <?php if($itemdata->description  != ''){ ?>
            <p class="expose_banner_des" style="color:#<?php echo $itemdata->description_button_color; ?>"><?php echo $itemdata->description ; ?></p>
          <?php } ?>
          <?php if($itemdata->extra_button){ ?>
            <div class="expose_banner_btns" style=text-align:<?php if($itemdata->extra_button_position == 1) { ?>right<?php } else if($itemdata->extra_button_position == 2) { ?>left<?php } else if($itemdata->extra_button_position == 3) { ?>center<?php } ?>>
              <a href="<?php echo $itemdata->extra_button_link != '' ? $itemdata->extra_button_link : 'javascript:void(0)'; ?>" class="expose_banner_btn"><?php echo $this->translate($itemdata->extra_button_text); ?></a>
            </div>
          <?php } ?> 
        </div>
      <?php $counter++;
      endforeach; ?>
		</div>
	</div>
</div>
<?php if($this->full_width){ ?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
	sesJqueryObject('#global_content').css('padding-top',0);
	sesJqueryObject('#global_wrapper').css('padding-top',0);	
});
</script>

<?php } ?>