<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $randonNumber = $this->identity; ?>
<?php $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/PeriodicalExecuter.js')
 												 ->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/Carousel.js')
                         ->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/Carousel.Extra.js'); 
      $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesbusinessvideo/externals/styles/carousel.css');
      $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessvideo/externals/styles/styles.css');
 ?>
<style type="text/css">
.sesbusinessvideo_carousel_wrapper_<?php echo $randonNumber; ?>.sesbusinessvideo_carousel_h_wrapper{
	background-color:<?php echo '#'.str_replace('#','',$this->bgColor) ?>;
	padding:<?php echo str_replace(array('px','%'),array(''),$this->spacing).'px'; ?> 0;
}
.sesbusinessvideo_carousel_wrapper_<?php echo $randonNumber; ?>.sesbusinessvideo_carousel_h_wrapper .sesbusinessvideo_grid_info *{
	color:<?php echo '#'.str_replace('#','',$this->textColor) ; ?>
}
#sesbusinessvideo_slider_<?php echo $randonNumber; ?> {
	position: relative;
	height:<?php echo is_numeric($this->height_main) ? $this->height_main.'px' : $this->height_main ?>;
	overflow: hidden;
}
/*.sesbusinessvideo_carousel_wrapper_<?php echo $randonNumber; ?>.sesbusinessvideo_carousel_h_wrapper .sesbusinessvideo_carousel_nav a{top:<?php echo $this->height/2; ?>px;}*/
</style>
<div class="sesbusinessvideo_carousel_wrapper clearfix sesbasic_bxs sesbasic_clearfix sesbm <?php echo $this->align == 'vertical' ? 'sesbusinessvideo_carousel_v_wrapper' : 'sesbusinessvideo_carousel_h_wrapper'; ?> sesbusinessvideo_carousel_wrapper_<?php echo $randonNumber; ?>">
  <div id="sesbusinessvideo_slider_<?php echo $randonNumber; ?>">
    <?php 
    if($this->categoryItem == 'chanels'){
    $allowRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.chanel.rating',1);
      $allowShowPreviousRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.ratechanel.show',1);
      if($allowRating == 0){
        if($allowShowPreviousRating == 0)
          $ratingChanelShow = false;
         else
          $ratingChanelShow = true;
      }else
        $ratingChanelShow = true;
      }else if($this->categoryItem == 'videos'){
      $allowRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessvideo.video.rating',1);
      $allowShowPreviousRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessvideo.ratevideo.show',1);
      if($allowRating == 0){
        if($allowShowPreviousRating == 0)
          $ratingChanelShow = false;
         else
          $ratingChanelShow = true;
      }else
        $ratingChanelShow = true;
      }else 
        $ratingChanelShow = true;
    	foreach( $this->paginator as $item ){
      $photoURL = $item->getPhotoUrl('thumb.normalmain'); ?>
        <div class="sesbusinessvideo_listing_grid" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height_main) ? $this->height_main.'px' : $this->height_main ?>;">
        	<div class="sesbusinessvideo_grid_thumb sesbusinessvideo_thumb sesbusinessvideo_play_btn_wrap" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
          <?php 
          $photoURL=$item->getPhotoUrl(); ?>
          <a class="<?php echo $item->getType() == 'businessvideo' ? 'sesbusinessvideo_thumb_img' : 'sesbusinessvideo_thumb_nolightbox' ?>" href="<?php echo $item->getHref(); ?>">
            <span style="background-image: url(<?php echo $photoURL; ?>);"></span> 
          </a>
            <?php  if($item->getType() == 'businessvideo') { ?>
            <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sesbusinessvideo_play_btn fa fa-play-circle sesbusinessvideo_thumb_img">
            	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>
            </a>  
            <?php } ?>
            <?php if(isset($this->featured) || isset($this->sponsored) || isset($this->hot)){ ?>
              <p class="sesbusinessvideo_labels">
              <?php if(isset($this->featured) && $item->is_featured == 1){ ?>
                <span class="sesbusinessvideo_label_featured"><?php echo $this->translate('FEATURED'); ?></span>
              <?php } ?>
              <?php if(isset($this->sponsored)  && $item->is_sponsored == 1){ ?>
                <span class="sesbusinessvideo_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>
              <?php } ?>
             <?php if(isset($this->hot)  && $item->is_hot == 1){ ?>
                <span class="sesbusinessvideo_label_hot"><?php echo $this->translate("HOT"); ?></span>
              <?php } ?>
              </p>
             <?php } ?>
         		 <?php if(isset($this->duration) && isset($item->duration) && $item->duration ): ?>
                <span class="sesbusinessvideo_length">
                  <?php
                    if( $item->duration >= 3600 ) {
                      $duration = gmdate("H:i:s", $item->duration);
                    } else {
                      $duration = gmdate("i:s", $item->duration);
                    }
                    echo $duration;
                  ?>
                </span>
             <?php endif ?>
             <?php if(isset($this->watchlater) && (isset($item->watchlater_id)) && Engine_Api::_()->user()->getViewer()->getIdentity() != '0'){ ?>
            		<?php $watchLaterId = $item->watchlater_id; ?>
              	<a href="javascript:;" class="sesbusinessvideo_watch_later_btn sesbusinessvideo_watch_later <?php echo !is_null($watchLaterId)  ? 'selectedWatchlater' : '' ?>" title = "<?php echo !is_null($watchLaterId)  ? $this->translate('Remove from Watch Later') : $this->translate('Add to Watch Later') ?>" data-url="<?php echo $item->video_id ; ?>"></a>
            <?php } ?>
            <?php 
              if(isset($this->socialSharing) || isset($this->likeButton) || isset($this->favouriteButton)){
              //basic viewpage link for sharing
              $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
              <span class="sesbusinessvideo_thumb_btns">
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessvideo.enable.socialshare', 1) && isset($this->socialSharing)){ ?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

                  <?php } 
                    if($item->video_id){
                      $itemtype = 'businessvideo';
                      $getId = 'video_id';
                    }
                    $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
                    if(isset($this->likeButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && $canComment){
                  ?>
                  <?php $LikeStatus = Engine_Api::_()->sesbusinessvideo()->getLikeStatusVideo($item->$getId,$item->getType()); ?>
                   <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusinessvideo_like_<?php echo $itemtype; ?><?php echo ($LikeStatus) ? ' button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                    <?php }
                    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessvideo.enable.favourite', 1) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->favouriteButton)){
                    $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesbusinessvideo')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesbusinessvideo_favourite_<?php echo $itemtype; ?><?php echo ($favStatus)  ? ' button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                    <?php } ?>
              </span>
            <?php } ?>
            </div>
              <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->rating) || isset($this->favouriteCount) || isset($this->downloadCount)  || isset($this->by) || isset($this->videoCount)){ ?>
                <div class="sesbusinessvideo_grid_info clear">
                  <?php if(isset($this->title)) { ?>
                    <div class="sesbusinessvideo_grid_title">
                      <?php echo $this->htmlLink($item, $this->htmlLink($item, $this->string()->truncate($item->getTitle(), $this->title_truncation), array('title'=>$item->getTitle()))) ?>
                    </div>
                  <?php } ?>
									<?php if(isset($this->by)) { ?>
                  	<div class="sesbusinessvideo_grid_date sesbusinessvideo_list_stats sesbasic_text_light floatL">
                      <span>
                  			<i class="fa fa-user"></i>
                        <?php echo $this->translate('By');?>
                        <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                      </span>
                      </div>
                  <?php }?>
                  <div class="sesbusinessvideo_grid_date sesbusinessvideo_list_stats sesbasic_text_light clear floatL">
                    <?php if(isset($this->like)) { ?>
                      <span class="sesbasic_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count))?>">
                        <i class="fa fa-thumbs-up"></i>
                        <?php echo $item->like_count;?>
                      </span>
                    <?php } ?>
                  <?php if(isset($this->comment)) { ?>
                    <span class="sesbasic_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>">
                      <i class="fa fa-comment"></i>
                      <?php echo $item->comment_count;?>
                    </span>
                 <?php } ?>
                 <?php if(isset($this->view)) { ?>
                  <span class="sesbasic_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>">
                    <i class="fa fa-eye"></i>
                    <?php echo $item->view_count;?>
                  </span>
                 <?php } ?>
                 <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessvideo.enable.favourite', 1) && isset($this->favouriteCount)) { ?>
                    <span class="sesbasic_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>">
                      <i class="fa fa-heart"></i> 
                      <?php echo $item->favourite_count;?>            
                    </span>
                  <?php } ?>
                  <?php if(isset($this->videoCount)) { ?>
                 <?php if($item->getType() == 'sesbusinessvideo_chanel'){
                 	$videoCount = $item->total_videos;
                  }else{ 
                 	$videoCount = $item->countVideos();
                   } ?>
                <span class="sesbasic_list_grid_download" title="<?php echo $this->translate(array('%s video', '%s videos', $videoCount), $this->locale()->toNumber($videoCount))?>">
                  <i class="fa fa-video-camera"></i> 
                  <?php echo $videoCount;?>            
                </span>
              <?php } ?>
              <?php if(isset($this->rating) && $ratingChanelShow && $item->rating > 0) { ?>
                      <span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
               <i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>
              </span>
                  <?php } ?>
            	</div>
            </div>         
          <?php } ?>
        </div>      
    <?php
    } ?>
  </div>
  <?php if($this->align == 'horizontal'): ?>
    <div class="tabs_<?php echo $randonNumber; ?> sesbusinessvideo_carousel_nav">
      <a class="sesbusinessvideo_carousel_nav_pre" href="#page-p"><i class="fa fa-angle-left"></i></a>
      <a class="sesbusinessvideo_carousel_nav_nxt" href="#page-p"><i class="fa fa-angle-right"></i></a>
    </div>  
  <?php else: ?>
    <div class="tabs_<?php echo $randonNumber; ?> sesbusinessvideo_carousel_nav">
      <a class="sesbusinessvideo_carousel_nav_pre" href="#page-p"><i class="fa fa-angle-up"></i></a>
      <a class="sesbusinessvideo_carousel_nav_nxt" href="#page-p"><i class="fa fa-angle-down"></i></a>
    </div>  
  <?php endif; ?>
</div>
<script type="text/javascript">
	window.addEvent('domready', function () {
		var duration = <?php echo $this->durationSlide; ?>,
			div = document.getElement('div.tabs_<?php echo $randonNumber; ?>');
			links = div.getElements('a'),
			carousel = new Carousel.Extra({
				activeClass: 'selected',
				container: 'sesbusinessvideo_slider_<?php echo $randonNumber; ?>',
				circular: true,
				current: 1,
				previous: links.shift(),
				next: links.pop(),
				tabs: links,
			  mode: '<?php echo $this->align; ?>',
				fx: {
					duration: duration
				}
			})
	})
</script>
