<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $randonNumber = $this->identity; ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/PeriodicalExecuter.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/Carousel.js"></script>
<script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/Carousel.Extra.js"></script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seselegant/externals/styles/styles.css'); ?>
<style>
  #slide_<?php echo $randonNumber; ?> {
    position: relative;
    height:<?php echo $this->height ?>px;
    overflow: hidden;
  }
</style>
<div class="slide lp_music_carousel_container clearfix sesbasic_bxs">
  <div id="slide_<?php echo $randonNumber; ?>" class="lp_music_carousel_content">
    <?php foreach( $this->results as $item ):  ?>
    	<div class="lp_music_thumb" style="width:<?php echo $this->width ?>px;height:<?php echo $this->height ?>px;">
        <div class="lp_music_thumb_img">
          <?php echo $this->itemPhoto($item, 'thumb.main'); ?>
        </div>
        <div class="lp_music_thumb_info">
          <?php if(!empty($this->information) && in_array('title', $this->information)): ?>
            <div class="lp_music_thumb_info_title">
              <?php echo $item->getTitle(); ?>
            </div>
          <?php endif; ?>
          <div class="lp_music_thumb_info_bottom">
            <?php if (!empty($this->information) && in_array('postedby', $this->information)) : ?>
							<div class="lp_music_thumb_info_owner">
								<?php echo $this->translate('by');?> <?php echo $item->getOwner()->getTitle() ?>
							</div>
            <?php endif; ?>
            <div class="lp_music_thumb_stats">
              <?php if (!empty($this->information) && in_array('commentCount', $this->information)) :?>
                <span>
                  <i class="fa fa-comment"></i>
                  <?php echo $item->comment_count; ?>
                </span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('likeCount', $this->information)) : ?>
                <span>
                	<i class="fa fa-thumbs-up"></i>
                  <?php echo $item->like_count; ?>
                </span>
              <?php endif; ?>
              <?php if (!empty($this->information) && in_array('viewCount', $this->information)) : ?>
                <span>
                	<i class="fa fa-eye"></i>
                  <?php echo $item->view_count; ?>
                </span>
              <?php endif; ?>
            </div>
        	</div>
        </div>
        <a href="<?php echo $item->getHref(); ?>" class="lp_music_thumb_link"></a>
    	</div>
    <?php endforeach; ?>
  </div>
  <div class="tabs_<?php echo $randonNumber; ?> lp_music_carousel_nav">
    <a class="lp_music_carousel_nav_pre" href="#page-p"><i class="fa fa-angle-left"></i></a>
    <a class="lp_music_carousel_nav_nxt" href="#page-p"><i class="fa fa-angle-right"></i></a>
  </div>  
</div>
<script type="text/javascript">
window.addEvent('domready', function() {
  var duration = 150,
  div = document.getElement('div.tabs_<?php echo $randonNumber; ?>');
  links = div.getElements('a'),
  carousel = new Carousel.Extra({
    activeClass: 'selected',
    container: 'slide_<?php echo $randonNumber; ?>',
    circular: true,
    current: 1,
    previous: links.shift(),
    next: links.pop(),
    tabs: links,
    mode: 'horizontal',
    fx: {
      duration: duration
    }
  })
});
</script>