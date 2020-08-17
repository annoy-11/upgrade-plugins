<?php

/**

 * SocialEngineSolutions

 *

 * @category   Application_Sescrowdfundingvideo

 * @package    Sescrowdfundingvideo

 * @copyright  Copyright 2015-2016 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: _profileShowVideoListGrid.tpl 2018-07-04 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */

?>

<?php if(isset($this->optionsEnable) && in_array('pinboard',$this->optionsEnable) && !$this->is_ajax){ 

	 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');

	 $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/pinboard.css'); 

   $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');

   $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');

 } ?>

<?php 

  if(isset($this->identityForWidget) && !empty($this->identityForWidget)){

    $randonNumber = $this->identityForWidget;

  } else {

    $randonNumber = $this->identity; 

  }

?>

<?php if(!$this->is_ajax){ ?>

<div class="sescrowdfunding_profile_tab_wrapper sescrowdfunding_profile_videos sesbasic_bxs">

  <div class="sescrowdfunding_profile_content_search sesbasic_clearfix">

    <div class="_input">

      <input placeholder="<?php echo $this->translate('Search'); ?>" type="text" id="video_text_search" name="video_text_search" />

    </div>

      <div class="_select">

        <select onchange="videoSearch(this.value);" id="video_browsebyoptions">

          <option value="creation_date"><?php echo $this->translate("Recently Created"); ?></option>

          <option value="most_liked"><?php echo $this->translate("Most Liked"); ?></option>

          <option value="most_viewed"><?php echo $this->translate("Most Viewed"); ?></option>

          <option value="most_commented"><?php echo $this->translate("Most Commented"); ?></option>

        </select>

      </div>

    <?php if($this->allowVideo && $this->canUpload){ ?>

    	<div class="_addbtn"> 

        <a class="sesbasic_button sesbasic_icon_add sescrowdfunding_cbtn" href="<?php echo $this->url(array('module' => 'sescrowdfundingvideo', 'action' => 'create', 'parent_id' => $this->parent_id), 'sescrowdfundingvideo_general', true); ?>">

          <?php echo $this->translate('Post New Video'); ?>

        </a>

    	</div>

  	<?php } ?>

  </div>

<?php } ?>



<?php if(!$this->is_ajax){ ?>

  <div class="sesbasic_view_type sesbasic_clearfix clear" style="display:<?php echo $this->bothViewEnable ? 'block' : 'none'; ?>;height:<?php echo $this->bothViewEnable ? '' : '0px'; ?>">

  	<div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">

    <?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>

      <a href="javascript:;" rel="list" id="sescrowdfundingvideo_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo $this->translate('List View') ; ?>"></a>

    <?php } ?>

    <?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>

    	<a href="javascript:;" rel="grid" id="sescrowdfundingvideo_grid_view_<?php echo $randonNumber; ?>" class="gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo $this->translate('Grid View'); ?>"></a>

    <?php } ?>

    <?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>

     	<a href="javascript:;" rel="pinboard" id="sescrowdfundingvideo_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo $this->translate('Pinboard View'); ?>"></a>

    <?php } ?>

    </div>

  </div>

<?php } ?>

<?php if((isset($this->optionsListGrid['tabbed']) || $this->loadJs || isset($this->optionsListGrid['profileTabbed'])) && !$this->is_ajax){ ?>

  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear prelative">

    <ul class="sescrowdfundingvideo_video_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">

<?php } ?>

      <?php foreach( $this->paginator as $item ):

        if(isset($this->getVideoItem) && $this->getVideoItem == 'getVideoItem'){

         $oldItem = $item;

        	if(isset($item->crowdfundingvideo_id))

           $item = Engine_Api::_()->getItem('crowdfundingvideo', $item->crowdfundingvideo_id);

          else if(isset($item->resource_id))

           $item = Engine_Api::_()->getItem('crowdfundingvideo', $item->resource_id);

          else

           $item = Engine_Api::_()->getItem('crowdfundingvideo', $item->file_id);

          if(isset($oldItem->watchlater_id)){

          	$watchlater_watch_id = $oldItem->watchlater_id;

            $watchlater_watch_id_exists = 'YES';

            }

				}

        /*Rating code start*/

       if($item->getType() == 'crowdfundingvideo'){

          $allowRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.video.rating',1);

          $allowShowPreviousRating = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.ratevideo.show',1);

          if($allowRating == 0){

            if($allowShowPreviousRating == 0)

              $ratingShow = false;

             else

              $ratingShow = true;

          }else

            $ratingShow = true;

        }else

       	$ratingShow = true;

       /*Rating code End*/

      ?>

			<?php if($this->view_type == 'grid' && $this->viewTypeStyle == 'mouseover'){ ?>

        <li class="sescrowdfundingvideo_listing_in_grid2" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">

          <div class="sescrowdfundingvideo_listing_in_grid2_thumb sescrowdfundingvideo_thumb sescrowdfundingvideo_play_btn_wrap">

            <?php

              $href = $item->getHref();

              $imageURL = $item->getPhotoUrl();

            ?>

            <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_thumb_img">

              <span style="background-image:url(<?php echo $imageURL; ?>);"></span>

            </a>

            <?php  if($item->getType() == 'crowdfundingvideo') { ?>

            <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_play_btn fa fa-play-circle sescrowdfundingvideo_thumb_img">

            	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>

            </a>  

            <?php } ?>

            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>

              <p class="sescrowdfundingvideo_labels">

              <?php if(isset($this->featuredLabelActive) && $item->is_featured == 1){ ?>

                <span class="sescrowdfundingvideo_label_featured"><?php echo $this->translate('FEATURED'); ?></span>

              <?php } ?>

              <?php if(isset($this->sponsoredLabelActive) && $item->is_sponsored == 1){ ?>

                <span class="sescrowdfundingvideo_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>

              <?php } ?>

              <?php if(isset($this->hotLabelActive) && $item->is_hot == 1){ ?>

                <span class="sescrowdfundingvideo_label_hot"><?php echo $this->translate("HOT"); ?></span>

              <?php } ?>

              </p>

             <?php } ?>

            <?php if(isset($this->durationActive) && isset($item->duration) && $item->duration ): ?>

              <span class="sescrowdfundingvideo_length">

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

             <?php if(isset($this->watchLaterActive) && (isset($item->watchlater_id) || isset($watchlater_watch_id_exists)) && Engine_Api::_()->user()->getViewer()->getIdentity() != '0'){ ?>

            <?php $watchLaterId = isset($watchlater_watch_id_exists) ? $watchlater_watch_id : $item->watchlater_id; ?>

              <a href="javascript:;" class="sescrowdfundingvideo_watch_later_btn sescrowdfundingvideo_watch_later <?php echo !is_null($watchLaterId)  ? 'selectedWatchlater' : '' ?>" title = "<?php echo !is_null($watchLaterId)  ? $this->translate('Remove from Watch Later') : $this->translate('Add to Watch Later') ?>" data-url="<?php echo $item->crowdfundingvideo_id ; ?>"></a>

            <?php } ?>

						<?php

           		if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)){

          		$urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>

           		<div class="sescrowdfundingvideo_thumb_btns"> 

              	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.socialshare', 1) && isset($this->socialSharingActive)){ ?>

              	

                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>



                <?php } 

                if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){

                      $itemtype = 'crowdfundingvideo';

                      $getId = 'crowdfundingvideo_id';



                      $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');

                      if(isset($this->likeButtonActive)){

                    ?>

                  <!--Like Button-->

                  <?php $LikeStatus = Engine_Api::_()->sescrowdfundingvideo()->getLikeStatusVideo($item->$getId,$item->getType()); ?>

                    <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfundingvideo_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>

                    <?php } ?>

                     <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count)){ ?>

                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sescrowdfundingvideo')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>

                    <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sescrowdfundingvideo_favourite_<?php echo $itemtype; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>

                  <?php } ?>

                <?php  } ?>

              </div>

            <?php } ?>      

          </div>

          <?php if(isset($this->titleActive) ){ ?>

            <div class="sescrowdfundingvideo_listing_in_grid2_title_show sescrowdfundingvideo_animation">

            	<?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 

              				$title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';

                       echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle())  ) ?>

              <?php }else{ ?>

              <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>

              <?php } ?>

            </div>

            <?php } ?>

          <div class="sescrowdfundingvideo_listing_in_grid2_info clear sescrowdfundingvideo_animation">

          	<?php if(isset($this->titleActive) ){ ?>

            <div class="sescrowdfundingvideo_listing_in_grid2_title">

            	<?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 

              				$title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';

                       echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle())  ) ?>

              <?php }else{ ?>

              <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>

              <?php } ?>

            </div>

            <?php } ?>

            <?php if(isset($this->byActive)){ ?>

              <div class="sescrowdfundingvideo_listing_in_grid2_date sescrowdfundingvideo_list_stats sesbasic_text_light">

                <?php $owner = $item->getOwner(); ?>

                <span>

                  <i class="fa fa-user"></i>

                  <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>

                </span>

              </div>

             <?php } ?>

             <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo_enable_location', 1)){ ?>

            	<div class="sescrowdfundingvideo_listing_in_grid2_date sescrowdfundingvideo_list_stats sescrowdfundingvideo_list_location sesbasic_text_light">

                <span>

                  <i class="fa fa-map-marker"></i>

                  <a href="javascript:;" onclick="openURLinSmoothBox('<?php echo $this->url(array("module"=> "sescrowdfundingvideo", "controller" => "index", "action" => "location",  "crowdfundingvideo_id" => $item->getIdentity(),'type'=>'video_location'),'default',true); ?>');return false;"><?php echo $item->location; ?></a>

                </span>

              </div>

            <?php } ?>

            <div class="sescrowdfundingvideo_listing_in_grid2_date sescrowdfundingvideo_list_stats sesbasic_text_light">

              <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>

                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>

              <?php } ?>

              <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>

                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>

              <?php } ?>

                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>

                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>

                <?php } ?>

                <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>

                  <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>

                <?php } ?>

                 <?php if(isset($this->ratingActive) && $ratingShow && isset($item->rating) && $item->rating > 0 ): ?>

                <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>

              <?php endif; ?>

            </div>

            <?php //if(isset($this->my_videos) && $this->my_videos ) { ?>

            <?php if(1) { ?>

              <?php if($this->can_edit  &&  $item->status !=2 && $this->can_delete && $item->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) { ?>

                <div class="sesvideo_listing_in_grid2_date sesbasic_text_light">

                  <span class="sesvideo_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>

                  <div class="sesvideo_listing_options_pulldown">

                    <?php if($this->can_edit){ 

                      echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general','module' => 'sescrowdfundingvideo','controller' => 'index','action' => 'edit','crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Edit Video')) ; 

                    } ?>

                    <?php if ($item->status !=2 && $this->can_delete){

                      echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general', 'module' => 'sescrowdfundingvideo', 'controller' => 'index', 'action' => 'delete', 'crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Delete Video'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));

                    } ?>

                  </div>

                </div>

              <?php } ?>

              <div class="sesvideo_manage_status_tip">

                <?php if($item->status == 0):?>

                   <div class="tip">

                     <span>

                       <?php echo $this->translate('Your video is in queue to be processed - you will be notified when it is ready to be viewed.')?>

                     </span>

                   </div>

                   <?php elseif($item->status == 2):?>

                   <div class="tip">

                     <span>

                       <?php echo $this->translate('Your video is currently being processed - you will be notified when it is ready to be viewed.')?>

                     </span>

                   </div>

                   <?php elseif($item->status == 3):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Please try %1$suploading again%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 4):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Video format is not supported by FFMPEG. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 5):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Audio files are not supported. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 7):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. You may be over the site upload limit.  Try %1$suploading%2$s a smaller file, or delete some files to free up space.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                <?php elseif(!$item->approve):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Your video has been successfully submitted for approval to our adminitrators - you will be notified when it is ready to be viewed.'); ?>

                     </span>

                   </div>

                <?php endif;?>

              </div>

            <?php } ?>

          </div>

        </li>

        <?php } else if($this->view_type == 'grid' && $this->viewTypeStyle != 'mouseover'){  ?>

        <li class="sescrowdfundingvideo_listing_grid" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">

          <div class="sescrowdfundingvideo_grid_thumb sescrowdfundingvideo_thumb sescrowdfundingvideo_play_btn_wrap" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">

            <?php

              $href = $item->getHref();

              $imageURL = $item->getPhotoUrl();

            ?>

            <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_thumb_img">

              <span style="background-image:url(<?php echo $imageURL; ?>);"></span>

            </a>

            <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_play_btn fa fa-play-circle sescrowdfundingvideo_thumb_img">

            	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>

            </a>  

            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>

              <p class="sescrowdfundingvideo_labels">

              <?php if(isset($this->featuredLabelActive) && $item->is_featured == 1){ ?>

                <span class="sescrowdfundingvideo_label_featured"><?php echo $this->translate('FEATURED'); ?></span>

              <?php } ?>

              <?php if(isset($this->sponsoredLabelActive) && $item->is_sponsored == 1){ ?>

                <span class="sescrowdfundingvideo_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>

              <?php } ?>

              <?php if(isset($this->hotLabelActive) && $item->is_hot == 1){ ?>

                <span class="sescrowdfundingvideo_label_hot"><?php echo $this->translate("HOT"); ?></span>

              <?php } ?>

              </p>

             <?php } ?>

            <?php if(isset($this->durationActive) && isset($item->duration) && $item->duration ): ?>

              <span class="sescrowdfundingvideo_length">

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

             <?php if(isset($this->watchLaterActive) && (isset($item->watchlater_id) || isset($watchlater_watch_id_exists)) && Engine_Api::_()->user()->getViewer()->getIdentity() != '0'){ ?>

            <?php $watchLaterId = isset($watchlater_watch_id_exists) ? $watchlater_watch_id : $item->watchlater_id; ?>

              <a href="javascript:;" class="sescrowdfundingvideo_watch_later_btn sescrowdfundingvideo_watch_later <?php echo !is_null($watchLaterId)  ? 'selectedWatchlater' : '' ?>" title = "<?php echo !is_null($watchLaterId)  ? $this->translate('Remove from Watch Later') : $this->translate('Add to Watch Later') ?>" data-url="<?php echo $item->crowdfundingvideo_id ; ?>"></a>

            <?php } ?>

						<?php

           		if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)){

          		$urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>

           		<div class="sescrowdfundingvideo_thumb_btns"> 

              	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.socialshare', 1) && isset($this->socialSharingActive)){ ?>

                  

                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>



                <?php } 

                if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){							 

											$itemtype = 'crowdfundingvideo';

											$getId = 'crowdfundingvideo_id';

                      $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');

                      if(isset($this->likeButtonActive)){

                    ?>

                  <!--Like Button-->

                  <?php $LikeStatus = Engine_Api::_()->sescrowdfundingvideo()->getLikeStatusVideo($item->$getId,$item->getType()); ?>

                    <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfundingvideo_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>

                    <?php } ?>

                     <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count)){ ?>

                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sescrowdfundingvideo')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>

                    <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sescrowdfundingvideo_favourite_<?php echo $itemtype; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>

                  <?php } ?>

                <?php  } ?>

              </div>

            <?php } ?>      

          </div>

          <div class="sescrowdfundingvideo_grid_info clear">

          	<?php if(isset($this->titleActive) ){ ?>

            <div class="sescrowdfundingvideo_grid_title">

            	<?php if(strlen($item->getTitle()) > $this->title_truncation_grid){ 

              				$title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';

                       echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>

              <?php }else{ ?>

              <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>

              <?php } ?>

            </div>

            <?php } ?>

            <?php if(isset($this->byActive)){ ?>

              <div class="sescrowdfundingvideo_grid_date sescrowdfundingvideo_list_stats sesbasic_text_light">

              	<?php $owner = $item->getOwner(); ?>

                <span>

                  <i class="fa fa-user"></i>

                  <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>

                </span>

              </div>

             <?php } ?>

              <?php if(isset($this->locationActive) && isset($item->location) && $item->location  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo_enable_location', 1)){ ?>

            	<div class="sescrowdfundingvideo_grid_date sescrowdfundingvideo_list_stats sesbasic_text_light sescrowdfundingvideo_list_location">

                <span>

                  <i class="fa fa-map-marker"></i>

                   <a href="javascript:;" onclick="openURLinSmoothBox('<?php echo $this->url(array("module"=> "sescrowdfundingvideo", "controller" => "index", "action" => "location",  "crowdfundingvideo_id" => $item->getIdentity(),'type'=>'video_location'),'default',true); ?>');return false;"><?php echo $item->location; ?></a>

                </span>

              </div>

            <?php } ?>

            <div class="sescrowdfundingvideo_grid_date sescrowdfundingvideo_list_stats sesbasic_text_light">

              <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>

                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>

              <?php } ?>

              <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>

                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>

              <?php } ?>

               <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>

                  	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>

                  <?php } ?>

                  

              <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>

                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>

              <?php } ?>

               <?php if(isset($this->ratingActive) && $ratingShow && isset($item->rating) && $item->rating > 0 ): ?>

              <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>

            <?php endif; ?>

            </div>

            <?php  if(isset($this->descriptiongridActive)){ ?>

              <div class="sescrowdfundingvideo_list_des">

                <?php if(strlen($item->description) > $this->description_truncation_grid){ 

                  $description = mb_substr($item->description,0,$this->description_truncation_grid).'...';

                  echo $title = nl2br(strip_tags($description));

                 } else { ?>

                  <?php  echo nl2br(strip_tags($item->description));?>

                <?php } ?>

              </div>

            <?php } ?>

            <?php //if(isset($this->my_videos) && $this->my_videos ){ ?>

            <?php if(1){ ?>

              <?php if($this->can_edit  &&  $item->status !=2 && $this->can_delete && $item->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) { ?>

                <div class="sescrowdfundingvideo_grid_date sesbasic_text_light">

                  <span class="sescrowdfundingvideo_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>

                  <div class="sescrowdfundingvideo_listing_options_pulldown">

                    <?php if($this->can_edit){ 

                      echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general','module' => 'sescrowdfundingvideo','controller' => 'index','action' => 'edit','crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Edit Video')) ; 

                    } ?>

                    <?php if ($item->status !=2 && $this->can_delete){

                      echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general', 'module' => 'sescrowdfundingvideo', 'controller' => 'index', 'action' => 'delete', 'crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Delete Video'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));

                    } ?>

                  </div>

                </div>

              <?php } ?>

              <div class="sescrowdfundingvideo_manage_status_tip">

                <?php if($item->status == 0):?>

                   <div class="tip">

                     <span>

                       <?php echo $this->translate('Your video is in queue to be processed - you will be notified when it is ready to be viewed.')?>

                     </span>

                   </div>

                   <?php elseif($item->status == 2):?>

                   <div class="tip">

                     <span>

                       <?php echo $this->translate('Your video is currently being processed - you will be notified when it is ready to be viewed.')?>

                     </span>

                   </div>

                   <?php elseif($item->status == 3):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Please try %1$suploading again%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 4):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Video format is not supported by FFMPEG. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 5):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. Audio files are not supported. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                   <?php elseif($item->status == 7):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Video conversion failed. You may be over the site upload limit.  Try %1$suploading%2$s a smaller file, or delete some files to free up space.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                     </span>

                   </div>

                <?php elseif(!$item->approve):?>

                   <div class="tip">

                     <span>

                      <?php echo $this->translate('Your video has been successfully submitted for approval to our adminitrators - you will be notified when it is ready to be viewed.'); ?>

                     </span>

                   </div>

                <?php endif;?>

              </div>

            <?php } ?>

          </div>

        </li>

        <?php }else if($this->view_type == 'list'){ ?>

        		<li class="sescrowdfundingvideo_listing_list sesbasic_clearfix clear">

              <div class="sescrowdfundingvideo_list_thumb sescrowdfundingvideo_thumb sescrowdfundingvideo_play_btn_wrap" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">

             <?php

                $href = $item->getHref();

                $imageURL = $item->getPhotoUrl();

              ?>

              <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_thumb_img">

              	<span style="background-image:url(<?php echo $imageURL; ?>);"></span>

              </a>

              <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_play_btn fa fa-play-circle sescrowdfundingvideo_thumb_img">

              	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>

              </a> 

              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>

              <p class="sescrowdfundingvideo_labels">

              <?php if(isset($this->featuredLabelActive) && isset($item->is_featured) && $item->is_featured == 1){ ?>

                <span class="sescrowdfundingvideo_label_featured"><?php echo $this->translate('FEATURED'); ?></span>

              <?php } ?>

              <?php if(isset($this->sponsoredLabelActive) && isset($item->is_sponsored) && $item->is_sponsored == 1){ ?>

                <span class="sescrowdfundingvideo_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>

              <?php } ?>

               <?php if(isset($this->hotLabelActive) && $item->is_hot == 1){ ?>

                <span class="sescrowdfundingvideo_label_hot"><?php echo $this->translate("HOT"); ?></span>

              <?php } ?>

              </p>

             <?php } ?>

              <?php if(isset($this->durationActive) && isset($item->duration) && $item->duration ): ?>

                <span class="sescrowdfundingvideo_length">

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

               <?php if(isset($this->watchLaterActive) && (isset($item->watchlater_id) || isset($watchlater_watch_id_exists)) && Engine_Api::_()->user()->getViewer()->getIdentity() != '0'){ ?>

            <?php $watchLaterId = isset($watchlater_watch_id_exists) ? $watchlater_watch_id : $item->watchlater_id; ?>

              <a href="javascript:;" class="sescrowdfundingvideo_watch_later_btn sescrowdfundingvideo_watch_later <?php echo !is_null($watchLaterId)  ? 'selectedWatchlater' : '' ?>" title = "<?php echo !is_null($watchLaterId)  ? $this->translate('Remove from Watch Later') : $this->translate('Add to Watch Later') ?>" data-url="<?php echo $item->crowdfundingvideo_id ; ?>"></a>

            <?php } ?>    

            						<?php

           		if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)){

          		$urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>

           		<div class="sescrowdfundingvideo_thumb_btns"> 

              	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.socialshare', 1) && isset($this->socialSharingActive)){ ?>

                  

                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

                  



                <?php } 

                if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){

                      $itemtype = 'crowdfundingvideo';

                      $getId = 'crowdfundingvideo_id';

                      $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');

                      if(isset($this->likeButtonActive)){

                    ?>

                  <!--Like Button-->

                  <?php $LikeStatus = Engine_Api::_()->sescrowdfundingvideo()->getLikeStatusVideo($item->$getId,$item->getType()); ?>

                    <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfundingvideo_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>

                    <?php } ?>

                     <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count)){ ?>

                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sescrowdfundingvideo')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>

                    <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sescrowdfundingvideo_favourite_<?php echo $itemtype; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>

                  <?php } ?>

                <?php  } ?>

              </div>

            <?php } ?>    

          	</div>

            <div class="sescrowdfundingvideo_list_info">

            	<?php  if(isset($this->titleActive)){ ?>

                <div class="sescrowdfundingvideo_list_title">

                 <?php if(strlen($item->getTitle()) > $this->title_truncation_list){

              				$title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';

                       echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle())  );

                  	 }else{ ?>

                  <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>

                  <?php } ?>

                </div>

              <?php } ?>

              <?php if(isset($this->byActive)){ ?>

                <div class="sescrowdfundingvideo_grid_date sescrowdfundingvideo_list_stats sesbasic_text_light">

                  <?php $owner = $item->getOwner(); ?>

                  <span>

                    <i class="fa fa-user"></i>

                    <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>

                  </span>

                </div>

               <?php } ?>

                 <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo_enable_location', 1)){ ?>

            	<div class="sescrowdfundingvideo_list_date sescrowdfundingvideo_list_stats sesbasic_text_light sescrowdfundingvideo_list_location">

                <span>

                  <i class="fa fa-map-marker"></i>

                   <a href="javascript:;" onclick="openURLinSmoothBox('<?php echo $this->url(array("module"=> "sescrowdfundingvideo", "controller" => "index", "action" => "location",  "crowdfundingvideo_id" => $item->getIdentity(),'type'=>'video_location'),'default',true); ?>');return false;"><?php echo $item->location; ?></a>

                </span>

              </div>

            <?php } ?>

                <div class="sescrowdfundingvideo_list_date sescrowdfundingvideo_list_stats sesbasic_text_light">

                	<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>

                  	<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>

                  <?php } ?>

                  <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>

                  	<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>

                  <?php } ?>

                  

                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>

                  	<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>

                  <?php } ?>

                  

                  <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>

                  	<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>

                  <?php } ?>

                  <?php if(isset($this->ratingActive) && $ratingShow && isset($item->rating) && $item->rating > 0 ): ?>

                  <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>

                <?php endif; ?>

                </div>

                

                <?php if(isset($this->descriptionlistActive)){ ?>

                <div class="sescrowdfundingvideo_list_des">

                  <?php if(strlen($item->description) > $this->description_truncation_list){ 

              				$description = mb_substr($item->description,0,$this->description_truncation_list).'...';

                      echo $title = nl2br(strip_tags($description));

                  	 }else{ ?>

                  <?php  echo nl2br(strip_tags($item->description));?>

                  <?php } ?>

                </div>

                <?php } ?>

                <div class="sescrowdfundingvideo_options_buttons sescrowdfundingvideo_list_options sesbasic_clearfix">

                  <?php //if(isset($this->my_videos) && $this->my_videos){ ?> 

                  <?php if($this->can_edit  &&  $item->status !=2 && $this->can_delete && $item->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) { ?>

                    <?php if($this->can_edit) { ?>

                    	<a href="<?php echo $this->url(array('module' => 'sescrowdfundingvideo', 'action' => 'edit', 'crowdfundingvideo_id' => $item->crowdfundingvideo_id), 'sescrowdfundingvideo_general', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Video'); ?>">

                    		<i class="fa fa-pencil"></i>

                  		</a>

                    <?php } ?>

                    <?php if ($item->status !=2 && $this->can_delete){ ?>

                   		<a href="<?php echo $this->url(array('module' => 'sescrowdfundingvideo', 'action' => 'delete', 'crowdfundingvideo_id' => $item->crowdfundingvideo_id), 'sescrowdfundingvideo_general', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Video'); ?>" onclick='opensmoothboxurl(this.href);return false;'>

                    		<i class="fa fa-trash"></i>

                      </a>

                 		<?php } ?>

                    <?php if($item->status == 0):?>

                      <div class="tip">

                        <span>

                          <?php echo $this->translate('Your video is in queue to be processed - you will be notified when it is ready to be viewed.')?>

                        </span>

                      </div>

                    <?php elseif($item->status == 2):?>

                      <div class="tip">

                        <span>

                          <?php echo $this->translate('Your video is currently being processed - you will be notified when it is ready to be viewed.')?>

                        </span>

                      </div>

                    <?php elseif($item->status == 3):?>

                      <div class="tip">

                        <span>

                         <?php echo $this->translate('Video conversion failed. Please try %1$suploading again%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sesvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                        </span>

                      </div>

                    <?php elseif($item->status == 4):?>

                      <div class="tip">

                        <span>

                         <?php echo $this->translate('Video conversion failed. Video format is not supported by FFMPEG. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sesvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                        </span>

                      </div>

                    <?php elseif($item->status == 5):?>

                      <div class="tip">

                        <span>

                         <?php echo $this->translate('Video conversion failed. Audio files are not supported. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sesvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                        </span>

                      </div>

                    <?php elseif($item->status == 7):?>

                      <div class="tip">

                        <span>

                         <?php echo $this->translate('Video conversion failed. You may be over the site upload limit.  Try %1$suploading%2$s a smaller file, or delete some files to free up space.', '<a href="'.$this->url(array('action' => 'create','module'=>'sesvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                        </span>

                      </div>

                    <?php elseif(!$item->approve):?>

                     <div class="tip">

                       <span>

                        <?php echo $this->translate('Your video has been successfully submitted for approval to our adminitrators - you will be notified when it is ready to be viewed.'); ?>

                       </span>

                     </div>

                  <?php endif;?>

                  <?php } ?>

                </div>

              </div>

            </li>

        <?php }else if(isset($this->view_type) && $this->view_type == 'pinboard'){ ?>

        		  <li class="sesbasic_bxs sesbasic_pinboard_list_item_wrap new_image_pinboard">

              	<div class="sesbasic_pinboard_list_item sesbm">

                	<div class="sesbasic_pinboard_list_item_top sescrowdfundingvideo_play_btn_wrap">

                  	<div class="sesbasic_pinboard_list_item_thumb">

                  		<a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_thumb_img">

                      	<img src="<?php echo $item->getPhotoUrl(); ?>">

                        	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>

                      </a>

                    </div>

                    <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="sescrowdfundingvideo_play_btn fa fa-play-circle sescrowdfundingvideo_thumb_img">

                    	<span style="background-image:url(<?php echo $item->getPhotoUrl(); ?>);display:none;"></span>

                    </a>           

                    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>

                      <div class="sesbasic_pinboard_list_label">

                      <?php if(isset($this->featuredLabelActive) && $item->is_featured == 1){ ?>

                        <span class="sescrowdfundingvideo_label_featured"><?php echo $this->translate('FEATURED'); ?></span>

                      <?php } ?>

                      <?php if(isset($this->sponsoredLabelActive) && $item->is_sponsored == 1){ ?>

                        <span class="sescrowdfundingvideo_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></span>

                      <?php } ?>

                      <?php if(isset($this->hotLabelActive) && $item->is_hot == 1){ ?>

                        <span class="sescrowdfundingvideo_label_hot"><?php echo $this->translate("HOT"); ?></span>

                      <?php } ?>

                      </div>

                     <?php } ?>                    

                  <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)){

                    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>

                     <div class="sesbasic_pinboard_list_btns"> 

                   <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.socialshare', 1) && isset($this->socialSharingActive)){ ?>

                   

                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>



                    <?php } 

                    if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){

                          $itemtype = 'crowdfundingvideo';

                          $getId = 'crowdfundingvideo_id';

                          $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');

                          if(isset($this->likeButtonActive)){

                        ?>

                      <!--Like Button-->

                      <?php $LikeStatus = Engine_Api::_()->sescrowdfundingvideo()->getLikeStatusVideo($item->$getId,$item->getType()); ?>

                        <a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfundingvideo_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>

                        <?php } ?>

                         <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteButtonActive) && isset($item->favourite_count)){ ?>

                        

                        <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sescrowdfundingvideo')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>

                        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sescrowdfundingvideo_favourite_<?php echo $itemtype; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>

                      <?php } ?>

                    <?php  } ?>

                  </div>

                  <?php } ?>

										<?php if(isset($this->durationActive) && isset($item->duration) && $item->duration ): ?>

                      <span class="sescrowdfundingvideo_length">

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

                     <?php if(isset($this->watchLaterActive) && (isset($item->watchlater_id) || isset($watchlater_watch_id_exists)) && Engine_Api::_()->user()->getViewer()->getIdentity() != '0'){ ?>

                    <?php $watchLaterId = isset($watchlater_watch_id_exists) ? $watchlater_watch_id : $item->watchlater_id; ?>

                      <a href="javascript:;" class="sescrowdfundingvideo_watch_later_btn sescrowdfundingvideo_watch_later <?php echo !is_null($watchLaterId)  ? 'selectedWatchlater' : '' ?>" title = "<?php echo !is_null($watchLaterId)  ? $this->translate('Remove from Watch Later') : $this->translate('Add to Watch Later') ?>" data-url="<?php echo $item->crowdfundingvideo_id ; ?>"></a>

                    <?php } ?>  

                  </div>

                  <div class="sesbasic_pinboard_list_item_cont sesbasic_clearfix">

              			<div class="sesbasic_pinboard_list_item_title">

                    <?php if(strlen($item->getTitle()) > $this->title_truncation_pinboard){ 

              				 $title = mb_substr($item->getTitle(),0,$this->title_truncation_pinboard).'...';

                       echo $this->htmlLink($item->getHref(),$title ) ?>

                    <?php }else{ ?>

                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>

                    <?php } ?>   

                    </div>

										  <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo_enable_location', 1)){ ?>

            	<div class="sescrowdfundingvideo_grid_date sescrowdfundingvideo_list_stats sesbasic_text_light sescrowdfundingvideo_list_location">

                <span>

                  <i class="fa fa-map-marker"></i>

                  <a href="javascript:;" onclick="openURLinSmoothBox('<?php echo $this->url(array("module"=> "sescrowdfundingvideo", "controller" => "index", "action" => "location",  "crowdfundingvideo_id" => $item->getIdentity(),'type'=>'video_location'),'default',true); ?>');return false;"><?php echo $item->location; ?></a>

                </span>

              </div>

            <?php } ?>

                    <?php if(isset($this->descriptionpinboardActive)){ ?>

                    	<div class="sesbasic_pinboard_list_item_des">

                      <?php if(strlen($item->description) > $this->description_truncation_pinboard){ 

                          $description = mb_substr($item->description,0,$this->description_truncation_pinboard).'...';

                          echo $title = nl2br(strip_tags($description));

                         }else{ ?>

                          <?php  echo nl2br(strip_tags($item->description));?>

                          </div>

                          <?php } ?>

                		<?php } ?>

                    <?php //if(isset($this->my_videos) && $this->my_videos ){ ?>

                    <?php if(1){ ?>

                    	<?php if($this->can_edit  &&  $item->status !=2 && $this->can_delete && $item->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) { ?>

                        <div class="sescrowdfundingvideo_grid_date sesbasic_text_light">

                          <span class="sescrowdfundingvideo_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>

                          <div class="sescrowdfundingvideo_listing_options_pulldown">

                            <?php if($this->can_edit){ 

                              echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general','module' => 'sescrowdfundingvideo','controller' => 'index','action' => 'edit','crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Edit Video')) ; 

                            } ?>

                            <?php if ($item->status !=2 && $this->can_delete){

                              echo $this->htmlLink(array('route' => 'sescrowdfundingvideo_general', 'module' => 'sescrowdfundingvideo', 'controller' => 'index', 'action' => 'delete', 'crowdfundingvideo_id' => $item->crowdfundingvideo_id), $this->translate('Delete Video'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));

                            } ?>

                          </div>

                      	</div>

                      <?php } ?>

                      <div class="sesvideo_manage_status_tip">

                        <?php if($item->status == 0):?>

                           <div class="tip">

                             <span>

                               <?php echo $this->translate('Your video is in queue to be processed - you will be notified when it is ready to be viewed.')?>

                             </span>

                           </div>

                           <?php elseif($item->status == 2):?>

                           <div class="tip">

                             <span>

                               <?php echo $this->translate('Your video is currently being processed - you will be notified when it is ready to be viewed.')?>

                             </span>

                           </div>

                           <?php elseif($item->status == 3):?>

                           <div class="tip">

                             <span>

                              <?php echo $this->translate('Video conversion failed. Please try %1$suploading again%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                             </span>

                           </div>

                           <?php elseif($item->status == 4):?>

                           <div class="tip">

                             <span>

                              <?php echo $this->translate('Video conversion failed. Video format is not supported by FFMPEG. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                             </span>

                           </div>

                           <?php elseif($item->status == 5):?>

                           <div class="tip">

                             <span>

                              <?php echo $this->translate('Video conversion failed. Audio files are not supported. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                             </span>

                           </div>

                           <?php elseif($item->status == 7):?>

                           <div class="tip">

                             <span>

                              <?php echo $this->translate('Video conversion failed. You may be over the site upload limit.  Try %1$suploading%2$s a smaller file, or delete some files to free up space.', '<a href="'.$this->url(array('action' => 'create','module'=>'sescrowdfundingvideo','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>

                             </span>

                           </div>

                        <?php endif;?>

                      </div>

                    <?php } ?>

                  </div>

                  <div class="sesbasic_pinboard_list_item_btm sesbm sesbasic_clearfix">

                  	<?php if(isset($this->byActive)){ ?>    

                      <div class="sesbasic_pinboard_list_item_poster sesbasic_text_light sesbasic_clearfix">

                        <?php $owner = $item->getOwner(); ?>

                        <div class="sesbasic_pinboard_list_item_poster_thumb">

                        	<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>

                        </div>

                        <div class="sesbasic_pinboard_list_item_poster_info">

                          <span class="sesbasic_pinboard_list_item_poster_info_title"><?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>

                          <span class="sesbasic_pinboard_list_item_poster_info_stats sesbasic_text_light">

                            <?php if(isset($this->likeActive) && isset($item->like_count)) { ?>

                              <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>

                            <?php } ?>

                            <?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>

                              <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>

                            <?php } ?>

                             <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo.enable.favourite', 1) && isset($this->favouriteActive) && isset($item->favourite_count)) { ?>

                                  <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>

                                <?php } ?>                          

                            <?php if(isset($this->viewActive) && isset($item->view_count)) { ?>

                              <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>

                            <?php } ?>

                               <?php if(isset($this->ratingActive) && $ratingShow && isset($item->rating) && $item->rating > 0 ): ?>

                      <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?></span>

                    <?php endif; ?>  

                          </span>

                        </div>

                      </div>

										<?php } ?>

                 <?php if(isset($this->enableCommentPinboardActive)){ ?>

                    <div class="sesbasic_pinboard_list_comments sesbasic_clearfix">

                    <?php //if((@$itemType != '')){ ?>

                    	<?php echo Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment') ? $this->action('list', 'comment', 'sesadvancedcomment', array('type' => $event->getType(), 'id' => $event->getIdentity(),'page'=>'')) : $this->action("list", "comment", "sesbasic", array("item_type" => 'crowdfundingvideo', "item_id" =>  $item->crowdfundingvideo_id,"widget_identity"=>$randonNumber)); ?>

                      <?php //} ?>

                    </div>

                 <?php } ?>

                  </div>

              	</div>

              </li>

        <?php

				}?>

        <?php endforeach; ?>

        <?php  if(  $this->paginator->getTotalItemCount() == 0){  ?>

           

              <div class="tip">

                <span>

                  <?php echo $this->translate('Nobody has created a video yet.');?>

                  <?php if ($this->can_create):?>

                    <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfundingvideo_general").'">', '</a>'); ?>

                  <?php endif; ?>

                </span>

              </div>

    			<?php } ?>

     <?php

   if((isset($this->optionsListGrid['paggindData']) || $this->loadJs) && $this->loadOptionData == 'pagging' && !isset($this->show_limited_data)){ ?>

 		 <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sescrowdfundingvideo"),array('identityWidget'=>$randonNumber)); ?>

 <?php } ?>

 <?php if(!$this->is_ajax){ ?>

 <?php if(isset($this->optionsListGrid['tabbed']) || $this->loadJs){ ?>

  </ul>

  <div class="sesbasic_loading_cont_overlay" id="videowidgetoverlay"></div>

 <?php } ?>

 <?php if((isset($this->optionsListGrid['paggindData']) || $this->loadJs) && $this->loadOptionData != 'pagging' && !isset($this->show_limited_data)){ ?>

  <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >

  	<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>    

  </div>  

  <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>

 <?php }

 	 if(isset($this->optionsListGrid['tabbed']) || $this->loadJs){ ?>

</div>

<?php } ?>

<?php if(isset($this->optionsListGrid['tabbed']) && !$this->is_ajax){ ?>

</div>

<?php } ?>

<?php if(!$this->is_ajax){ ?>

<script type="application/javascript">var requestTab_<?php echo $randonNumber; ?>;</script>

<?php } ?>

<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>

<script type="text/javascript">

var valueTabData ;

// globally define available tab array

	var availableTabs_<?php echo $randonNumber; ?>;

	var requestTab_<?php echo $randonNumber; ?>;

<?php if(isset($defaultOptionArray)){ ?>

  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($defaultOptionArray); ?>;

<?php  } ?>

<?php if($this->loadOptionData == 'auto_load' && !isset($this->show_limited_data)){ ?>

		window.addEvent('load', function() {



		 sesJqueryObject(window).scroll( function() {

			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;

        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();

        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){

						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();

				}

     });

	});

<?php } ?>

sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){

		if(sesJqueryObject(this).hasClass('active'))

			return;

		if($("view_more_<?php echo $randonNumber; ?>"))

			document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';

		document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";

		sesJqueryObject('#sescrowdfundingvideo_grid_view_<?php echo $randonNumber; ?>').removeClass('active');

		sesJqueryObject('#sescrowdfundingvideo_list_view_<?php echo $randonNumber; ?>').removeClass('active');

		sesJqueryObject('#sescrowdfundingvideo_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');

		sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');

		sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');

		sesJqueryObject(this).addClass('active');

		if(sesJqueryObject('#filter_form').length)

			var	searchData<?php echo $randonNumber; ?> = sesJqueryObject('#filter_form').serialize();

		 if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {

				 requestTab_<?php echo $randonNumber; ?>.cancel();

		 }

		 if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {

			 requestViewMore_<?php echo $randonNumber; ?>.cancel();

		 }

	  requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({

      method: 'post',

      'url': en4.core.baseUrl + "widget/index/mod/sescrowdfundingvideo/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,

      'data': {

        format: 'html',

        page: 1,

				type:sesJqueryObject(this).attr('rel'),

				params : <?php echo json_encode($this->params); ?>, 

				is_ajax : 1,

        sort:$('video_browsebyoptions').value,

        search:$('video_text_search').value,

				searchParams:searchData<?php echo $randonNumber; ?>,

				identity : '<?php echo $randonNumber; ?>',

      },

      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;

			if($("loading_image_<?php echo $randonNumber; ?>"))

				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';

			pinboardLayout_<?php echo $randonNumber ?>();

      }

    })).send();

});

</script>

<?php } ?>

<?php } ?>

<?php if(!$this->is_ajax){ ?>

<script type="application/javascript">

	var wookmark = undefined;

 //Code for Pinboard View

  var wookmark<?php echo $randonNumber ?>;

  function pinboardLayout_<?php echo $randonNumber ?>(force){

		if(sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') != 'pinboard'){

		 sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');

		 sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').css('height','');

	 		return;

	  }

		sesJqueryObject('.new_image_pinboard').css('display','none');

		var imgLoad = imagesLoaded('#tabbed-widget_<?php echo $randonNumber; ?>');

		imgLoad.on('progress',function(instance,image){

			sesJqueryObject(image.img.offsetParent).parent().parent().show();

			sesJqueryObject(image.img.offsetParent).parent().parent().removeClass('new_image_pinboard');

			imageLoadedAll<?php echo $randonNumber ?>();

		});

  }

  function imageLoadedAll<?php echo $randonNumber ?>(force){

	 sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');

	 if (typeof wookmark<?php echo $randonNumber ?> == 'undefined') {

			(function() {

				function getWindowWidth() {

					return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)

				}				

				wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {

					itemWidth: <?php echo isset($this->width_pinboard) ? str_replace(array('px','%'),array(''),$this->width_pinboard) : '300'; ?>, // Optional min width of a grid item

					outerOffset: 0, // Optional the distance from grid to parent

					align:'left',

					flexibleWidth: function () {

						// Return a maximum width depending on the viewport

						return getWindowWidth() < 1024 ? '100%' : '40%';

					}

				});

			})();

    } else {

      wookmark<?php echo $randonNumber ?>.initItems();

      wookmark<?php echo $randonNumber ?>.layout(true);

    }

}

 sesJqueryObject(window).resize(function(e){

    pinboardLayout_<?php echo $randonNumber ?>('',true);

   });

sesJqueryObject(document).ready(function(){

	pinboardLayout_<?php echo $randonNumber ?>();

})

</script>

<?php } ?>

<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>

<script type="text/javascript">

var defaultOpenTab ;

<?php if(isset($this->optionsListGrid['paggindData'])) {?>

	function changeTabSes_<?php echo $randonNumber; ?>(valueTab){

			if(sesJqueryObject("#sesTabContainer_<?php echo $randonNumber ?>_"+valueTab).hasClass('active'))

				return;

			var id = '_<?php echo $randonNumber; ?>';

			var length = availableTabs_<?php echo $randonNumber; ?>.length;

			for (var i = 0; i < length; i++){

				if(availableTabs_<?php echo $randonNumber; ?>[i] == valueTab){

					document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('active');

					sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('sesbasic_tab_selected');

				}

				else{

						sesJqueryObject('#sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('sesbasic_tab_selected');

					document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('active');

				}

			}

		if(valueTab){

					sesJqueryObject('.sesbasic_view_type').show();

				document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";

			if($("view_more_<?php echo $randonNumber; ?>"))

				document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';

			if($('ses_pagging'))

				document.getElementById("ses_pagging").style.display = 'none';

			 if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {

				 requestTab_<?php echo $randonNumber; ?>.cancel();

 			 }

			  if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {

				 requestViewMore_<?php echo $randonNumber; ?>.cancel();

 			 }

			 defaultOpenTab = valueTab;

			 console.log('safd');

			 requestTab_<?php echo $randonNumber; ?> = new Request.HTML({

				method: 'post',

				'url': en4.core.baseUrl+"widget/index/mod/sescrowdfundingvideo/name/<?php echo $this->widgetName; ?>/openTab/"+valueTab,

				'data': {

					format: 'html',

					page:  1,    

					params :<?php echo json_encode($this->params); ?>, 

					is_ajax : 1,

          sort:$('video_browsebyoptions').value,

          search:$('video_text_search').value,

					identity : '<?php echo $randonNumber; ?>',

				},

				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = '';

					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;

					pinboardLayout_<?php echo $randonNumber ?>();

					if($('ses_pagging'))

						document.getElementById("ses_pagging").style.display = 'block';

					if(!sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?> li').length)

						sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').hide();

					else

						sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').show();

				}

    	});

		requestTab_<?php echo $randonNumber; ?>.send();

    return false;			

		}

	}

<?php } ?>

var requestViewMore_<?php echo $randonNumber; ?>;

var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;

var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';

 var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';

 var searchParams<?php echo $randonNumber; ?> ;

	<?php if($this->loadOptionData != 'pagging'){ ?>

   viewMoreHide_<?php echo $randonNumber; ?>();	

  function viewMoreHide_<?php echo $randonNumber; ?>() {

    if ($('view_more_<?php echo $randonNumber; ?>'))

      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";

  }

  function viewMore_<?php echo $randonNumber; ?> (){

    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';

    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';

    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    

    requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({

      method: 'post',

      'url': en4.core.baseUrl + "widget/index/mod/sescrowdfundingvideo/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,

      'data': {

        format: 'html',

        page: page<?php echo $randonNumber; ?>,    

				params :	params<?php echo $randonNumber; ?>, 

				is_ajax : 1,

				searchParams:searchParams<?php echo $randonNumber; ?> ,

        sort:$('video_browsebyoptions').value,

        search:$('video_text_search').value,

        searchParams:searchParams<?php echo $randonNumber; ?>  ,

				identity : identity<?php echo $randonNumber; ?>,

      },

      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        if($('loading_images_browse_<?php echo $randonNumber; ?>'))

					sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();

				if($('loadingimgsescrowdfundingvideo-wrapper'))

						sesJqueryObject('#loadingimgsescrowdfundingvideo-wrapper').hide();

        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;

				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';

				pinboardLayout_<?php echo $randonNumber ?>();

				

      }

    });

		requestViewMore_<?php echo $randonNumber; ?>.send();

    return false;

  }

	<?php }else{ ?>

		function paggingNumber<?php echo $randonNumber; ?>(pageNum){

			 sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');

			 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';

				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({

					method: 'post',

					'url': en4.core.baseUrl + "widget/index/mod/sescrowdfundingvideo/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,

					'data': {

						format: 'html',

						page: pageNum,    

						params :params<?php echo $randonNumber; ?> , 

						is_ajax : 1,

						searchParams:searchParams<?php echo $randonNumber; ?>  ,

						identity : identity<?php echo $randonNumber; ?>,

            sort:$('video_browsebyoptions').value,

            search:$('video_text_search').value,

            searchParams:searchParams<?php echo $randonNumber; ?>  ,

						type:'<?php echo $this->view_type; ?>'

					},

					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

					if($('loading_images_browse_<?php echo $randonNumber; ?>'))

					sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();

					if($('loadingimgsescrowdfundingvideo-wrapper'))

						sesJqueryObject('#loadingimgsescrowdfundingvideo-wrapper').hide();

						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');

						document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;

						pinboardLayout_<?php echo $randonNumber ?>();

					}

				}));

				requestViewMore_<?php echo $randonNumber; ?>.send();

				return false;

		}

	<?php } ?>

	

	

  function videoSearch() {

  

   document.getElementById('videowidgetoverlay').style.display = 'block';   

   

   var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';

    requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({

      method: 'post',

      'url': en4.core.baseUrl + "widget/index/mod/sescrowdfundingvideo/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,

      'data': {

        format: 'html',

        page: page<?php echo $randonNumber; ?>,

        params :params<?php echo $randonNumber; ?> , 

        is_ajax : 1,

        sort:$('video_browsebyoptions').value,

        search:$('video_text_search').value,

        searchParams:searchParams<?php echo $randonNumber; ?>  ,

        identity : identity<?php echo $randonNumber; ?>,

        type:'<?php echo $this->view_type; ?>'

      },

      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

      if($('loading_images_browse_<?php echo $randonNumber; ?>'))

        sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();

      if($('loadingimgsescrowdfundingvideo-wrapper'))

        sesJqueryObject('#loadingimgsescrowdfundingvideo-wrapper').hide();

        document.getElementById('videowidgetoverlay').style.display = 'none';

        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;

        pinboardLayout_<?php echo $randonNumber ?>();

      }

    }));

    requestViewMore_<?php echo $randonNumber; ?>.send();

    return false;

  }

	

	

  en4.core.runonce.add(function() {

    $('video_text_search').addEvent('keypress', function(e) {

      if( e.key != 'enter' ) return;

      videoSearch();

    })

  });



</script>

<?php } ?>

<?php if(!$this->is_ajax){ ?>

<script type="application/javascript">

var tabId_video = <?php echo $this->identity; ?>;

window.addEvent('domready', function() {

	tabContainerHrefSesbasic(tabId_video);	

});

sesJqueryObject(document).on('click',function(){

	sesJqueryObject('.sescrowdfundingvideo_list_option_toggle').removeClass('open');

});

</script>

<?php } ?>

