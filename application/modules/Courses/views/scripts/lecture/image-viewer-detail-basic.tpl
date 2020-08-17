<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: image-viewer-detail-basic.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if ( $this->lecture->type == 3 && $this->lecture_extension == 'mp4' ){
    $this->headScript()
         ->appendFile($this->layout()->staticBaseUrl . 'externals/html5media/html5media.min.js');
}
?>
<?php if( $this->lecture->type == 3 && $this->lecture_extension == 'flv' ){
    $this->headScript()
         ->appendFile($this->layout()->staticBaseUrl . 'externals/flowplayer/flashembed-1.0.1.pack.js');
}
?>
<div class="ses_media_lightbox_left">
  <div class="ses_media_lightbox_item_wrapper">
    <div class="ses_media_lightbox_item">
      <div id="mainImageContainer">
        <div id="media_photo_next_ses" style="display:inline;">
         <?php 
         $className= '';
         $cssDisplay = 'block';
         if($this->locked){
         			$imageUrl = 'application/modules/Courses/externals/images/locked-video.jpg';
              $className = 'ses-blocked-video';
              $cssDisplay = 'none';
            }
        ?>
        <?php if(isset($this->imagePrivateURL)){
          				$imageUrl = $this->imagePrivateURL;
                  $className = 'ses-private-image';
              }else if(empty($imageUrl)){
              	$imageUrl = $this->lecture->getPhotoUrl();
             	}
          ?>
        <div id="video_data_lightbox" class="<?php echo $className; ?>" style="display:<?php echo $cssDisplay; ?>">
             <?php if( $this->lecture->type == 3 ): ?>
              <div id="video_embed_lightbox" class="sesbasic_view_embed_lightbox clear sesbasic_clearfix">
                <?php if ($this->lecture_extension !== 'flv'): ?>
                  <video id="video" controls preload="auto" width="480" height="386">
                    <source type='video/mp4' src="<?php echo $this->lecture_location ?>">
                  </video>
                <?php endif ?>
              </div>
              <?php else: ?>
                <div class="sesbasic_view_embed clear sesbasic_clearfix">
                  <?php echo $this->lectureEmbedded; ?>
                </div>
              <?php endif; ?>
        </div>
        </div>
        <?php
         echo $this->htmlImage($imageUrl, $this->lecture->getTitle(), array(
                  'id' => 'gallery-img',
                  'class' =>$className,
                  'style'=>'display:none',
          ));
         ?>
      </div>
    </div>
  </div>
   <?php if(isset($this->imagePrivateURL)){
          $imageUrl = $this->imagePrivateURL;
         }else
         	$imageUrl =	$this->lecture->getPhotoUrl(); 
          ?>
  <div class="ses_media_lightbox_nav_btns">
    <?php 
     if($this->toArray){ 
          if(!empty($this->previousVideo)) {
         	  $this->previousVideo = $courses_lecture_previous = Engine_Api::_()->getItem("courses_lecture", $this->previousVideo[0]['lecture_id']);
            $previousURL = $courses_lecture_previous->getHref();
            if(!empty($previousURL))
            	$previousVideoURL = $courses_lecture_previous->getPhotoUrl();
          }
       }else{
        if(!empty($this->previousVideo))
        	$previousURL = $this->previousVideo->getHref();;
          if(!empty($previousURL))
          $previousVideoURL = $this->previousVideo->getPhotoUrl();
       }
        if(isset($previousURL)){
        	if (!$this->previousVideo->authorization()->isAllowed($this->viewer, 'view')) {
            $previousVideoURL = $this->privateImageUrl;
          }else if($this->previousVideo->adult && !Engine_Api::_()->getApi('core', 'sesbasic')->checkAdultContent(array('module'=>'courses')))
          	$previousVideoURL = $this->privateImageURL;
      ?>
    <a class="ses_media_lightbox_nav_btn_prev" style="display:block" href="<?php echo $this->previousVideo->getHref(); ?>" title="<?php echo $this->translate('Previous'); ?>" onclick="getRequestedVideoForImageViewer('<?php echo $previousVideoURL; ?>','<?php echo $previousURL; ?>');return false;" id="nav-btn-prev"></a>
    <?php }     		
    		 if($this->toArray){ 
          if(!empty($this->nextVideo)) {
            $this->nextVideo = $courses_lecture_next = Engine_Api::_()->getItem("courses_lecture", $this->nextVideo[0]['lecture_id']);
	          $nextURL = $courses_lecture_next->getHref();;
            if(!empty($nextURL))
            	$nextVideoURL  = $courses_lecture_next->getPhotoUrl();
            }
         }else{
          if(!empty($this->nextVideo))
	          $nextURL = $this->nextVideo->getHref();
            if(!empty($nextURL))
            	$nextVideoURL  = $this->nextVideo->getPhotoUrl();
         }
        if(!empty($nextURL)){
        	if (!$this->nextVideo->authorization()->isAllowed($this->viewer, 'view')) {
            $nextVideoURL = $this->privateImageURL;
           }else if($this->nextVideo->adult && !Engine_Api::_()->getApi('core', 'sesbasic')->checkAdultContent(array('module'=>'video')))
          	$nextVideoURL = $this->privateImageURL;
       ?>
    <a class="ses_media_lightbox_nav_btn_next" style="display:block" href="<?php echo $this->nextVideo->getHref(); ?>" title="<?php echo $this->translate('Next'); ?>" onclick="getRequestedVideoForImageViewer('<?php echo $nextVideoURL; ?>','<?php echo $nextURL; ?>');return false;" id="nav-btn-next"></a>
    <?php } ?>
  </div>
  <div class="ses_media_lightbox_options">
    <div class="ses_media_lightbox_options_owner">
    	<?php $lectureUserDetails = Engine_Api::_()->user()->getUser($this->lecture->owner_id); ?>  
      <?php echo $this->htmlLink($lectureUserDetails->getHref(), $this->itemPhoto($lectureUserDetails, 'thumb.icon'), array('class' => 'userthumb')); ?>
      <?php echo $this->htmlLink($lectureUserDetails->getHref(), $lectureUserDetails->getTitle()); ?>&nbsp;&nbsp;&bull;&nbsp;&nbsp;
    </div>
    <div class="ses_media_lightbox_options_name">
      <?php echo $this->translate('In %1$s', $this->htmlLink( isset($this->item) ? $this->item->getHref() : $this->lecture->getHref(),isset($this->item) ? $this->string()->truncate($this->item->title,Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbasic.title.truncate',35)) : $this->string()->truncate($this->lecture->title,Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbasic.title.truncate',35)))); ?>
    </div>
  </div>
  <div class="ses_media_lightbox_fullscreen_btn">
    <a id="fsbutton" onclick="toogle()" href="javascript:;" title="<?php echo $this->translate('Enter Fullscreen'); ?>"><i class="fa fa-expand"></i></a>
  </div>
</div>
<div class="ses_media_lightbox_information">
<div id="heightOfImageViewerContent">
  <div id="flexcroll" >
    <div class="ses_media_lightbox_media_info" id="ses_media_lightbox_media_info">
      <div class="ses_media_lightbox_information_top sesbasic_clearfix">
        <?php $lectureUserDetails = Engine_Api::_()->user()->getUser($this->lecture->owner_id); ?>
        <div class="ses_media_lightbox_author_photo">  
          <?php echo $this->htmlLink($lectureUserDetails->getHref(), $this->itemPhoto($lectureUserDetails, 'thumb.icon')); ?>
        </div>
        <div class="ses_media_lightbox_author_info">
          <span class="ses_media_lightbox_author_name">
            <?php echo $this->htmlLink($lectureUserDetails->getHref(), $lectureUserDetails->getTitle()); ?>
          </span>
          <span class="ses_media_lightbox_posted_date sesbasic_text_light">
            <?php echo date('F j',strtotime($this->lecture->creation_date)); ?>
          </span>
        </div>
      </div>
      <div class="ses_media_lightbox_item_title" id="ses_title_get"> <?php echo $this->lecture->getTitle(); ?></div>
      <div class="ses_media_lightbox_item_description" id="ses_title_description"><?php echo $this->viewMore(nl2br($this->lecture->getDescription())); ?></div>
    </div>
    <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
  </div>
  </div>
</div>
<a href="javascript:;" class="cross ses_media_lightbox_close_btn exit_lightbox"><i class="fa fa-close sesbasic_text_light"></i></a>
<a href="javascript:;" class="ses_media_lightbox_close_btn exit_fullscreen" title="<?php echo $this->translate('Exit Full Screen') ; ?>" onclick="toogle()"><i class="fa fa-close sesbasic_text_light"></i></a>
