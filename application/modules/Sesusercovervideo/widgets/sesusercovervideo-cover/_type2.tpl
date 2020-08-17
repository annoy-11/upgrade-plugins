<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _type2.tpl 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->sesmemberenable) { ?>
  <?php $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($this->subject->getIdentity());?>
<?php } ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesusercovervideo/externals/styles/cover_layout2.css'); ?>

<div class="sesusercover_main_container sesusercover_cover_type2 sesbasic_bxs <?php if($this->is_fullwidth){?>sesusercovervideo_cover_wrapper_full<?php } ?>">
  <div class="sesusercover_cover_wrapper" style="height:<?php echo $this->height; ?>px">
    <div class="sesusercover_cover_container" style="height:<?php echo $this->height; ?>px">
      <!--Cover Photo-->
       <?php 
        $isUserVideo = Engine_Api::_()->getDbTable('videos', 'sesusercovervideo')->isUserVideo(array('user_id' => $this->subject->getIdentity()));
        if(isset($isUserVideo) && $isUserVideo != 0 && $isUserVideo != '') {
          $memberVideoCover =	Engine_Api::_()->storage()->get($isUserVideo, ''); 
          $memberCover = '';
          if($memberVideoCover) {
            $videoCover = true;
          }
        } else if(isset($this->subject->cover_photo) && $this->subject->cover_photo != 0 && $this->subject->cover_photo != ''){ 
          $memberVideoCover = '';
          $memberCover =	Engine_Api::_()->storage()->get($this->subject->cover_photo, ''); 
          if($memberCover)
            $memberCover = $memberCover->map();
          $videoCover = false;
        } else {
          $memberVideoCover = '';
          $memberCover = $this->defaultCoverPhoto;
          $videoCover = false;
        }
      ?>
      <div id="sesusercovervideo_cover_image" class="sesusercover_cover_img">
        <video loop="loop" id="sesusercovervideo_cover_video_id" style="<?php if(empty($videoCover)) { ?> display:none; <?php } ?>" controls autoplay>
          <source id="sesusercovervideo_cover_video_id_src" src="<?php echo $this->layout()->staticBaseUrl . @$memberVideoCover->storage_path ?>" type="video/mp4">
        </video>
        <img id="sesusercoverphoto_cover_id" src="<?php echo $memberCover; ?>" style="<?php if(empty($videoCover)) { ?> display:block; <?php } else if(empty($memberCover)) {  ?> display:none; <?php } ?>" />
      </div>
      <!--Upload/Change Cover Options-->
     <?php if($this->can_edit  && $this->canCreate){ ?>
      <div class="sesusercovervideo_cover_change_cover" id="sesusercovervideo_cover_change">
         <a href="javascript:;" id="cover_change_btn">
          <i class="fa fa-camera" id="cover_change_btn_i"></i>
          <span id="change_coverphoto_profile_txt"><?php echo $this->translate("Update Cover Video"); ?></span>
        </a>
        <div class="sesusercovervideo_change_cover_options sesbasic_option_box"> 
          <i class="sesusercovervideo_change_cover_options_main_arrow"></i>
          <input type="file" id="uploadFilesesUserCoverPhoto" name="art_cover" onchange="readCoverPhotoImageUrl(this);" style="display:none">

          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercovervideo')) { ?>
            <a href="<?php echo 'sesusercovervideo/index/upload/subject_id/'.$this->subject->getIdentity(); ?>" class="smoothbox" id="uploadCoverVideo" href="javascript:;"><i class="fa fa-plus"></i><?php echo ($isUserVideo != 0 && $isUserVideo != '') ? $this->translate('Change Cover Video') : $this->translate('Add Cover Video');; ?></a>
          <?php } ?>
          <?php if($this->existingVideospaginator->getTotalItemCount() > 0) { ?>
            <a id="fromCoverPhotoExistingAlbum" href="javascript:;"><i class="fa fa-picture-o"></i><?php echo $this->translate("Choose From Existing Videos"); ?></a>
          <?php } ?>
          <a id="removeCover" href="<?php echo 'sesusercovervideo/index/confirmation/'; ?>" class="sessmoothbox" style="display:<?php echo (isset($isUserVideo) && $isUserVideo != 0 && $isUserVideo != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $isUserVideo; ?>"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Video'); ?></a>

        </div>
      </div>
     <?php } ?>
      <div id="sesusercovervideo_cover_photo_loading" class="sescoverpphoto_overlay" style="display:none;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>
      <?php if($this->sesmemberenable): ?>
      <div class="sesusercover_cover_labels">
      <?php if(in_array('featuredlabel',$this->option) && $this->subject->featured){ ?>
      	<p class="sesmember_label_featured"><?php echo $this->translate("FEATURED");?></p>
      <?php } ?>
      <?php if(in_array('sponsoredLabel',$this->option) && $this->subject->sponsored){ ?>
        <p class="sesmember_label_sponsored"><?php echo $this->translate("SPONSORED");?></p>
       <?php } ?>
      <?php if(in_array('viplabel',$this->option) && $this->subject->vip){ ?>
        <i class="sesmember_vip_label" title="<?php echo $this->translate('VIP') ;?>"></i>
      <?php } ?>
      </div>
      <?php endif; ?>
    </div>

  </div>
  <div class="sesusercovervideo_cover_information_block sesbasic_clearfix">
  	<div class="sesusercovervideo_cover_information_block_inner sesbasic_clearfix">
      <!--Main Photo-->     
    <?php if(in_array('photo',$this->option)){ ?>
      <?php
        if(!$this->subject->getPhotoUrl('thumb.profile') && !$this->sesmemberenable){
          $imgurl = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png';
        } else
          $imgurl = $this->subject->getPhotoUrl('thumb.profile');
      ?>
    	<div class="sesusercovervideo_profile_img">
     		<img src="<?php echo $imgurl ; ?>" alt="" class="thumb_profile item_photo_user sesusercovervideo_cover_image_main">        
        <?php if($this->can_edit){ ?>
          <div class="sesusercovervideo_cover_change_cover_main" id="sesusercovervideo_cover_option_main_id">
          <input type="file" id="uploadFileMainsesusercovervideo" name="main_photo_cvr" onchange="uploadFileMainsesusercovervideo(this);"  style="display:none" />
            <a href="javascript:;" id="change_main_btn">
              <i class="fa fa-camera" id="change_main_i"></i>
              <span id="change_main_txt"><?php echo $this->translate("Upload Profile Picture"); ?></span>
            </a>
            <div class="sesusercovervideo_change_cover_options_main sesbasic_option_box">
              <i class="sesusercovervideo_change_cover_options_main_arrow"></i>
              <a href="javascript:;" id="change_main_cvr_pht"><i class="fa fa-plus"></i><?php echo $this->subject->photo_id  ?  $this->translate("Change User Photo") : $this->translate("Add User Photo"); ?></a>
              <a style="display:<?php echo $this->subject->photo_id ? 'block !important' : 'none !important' ; ?>;" href="javascript:;" id="sesusercovervideo_main_photo_i"><i class="fa fa-trash"></i><?php echo $this->translate("Remove User Photo"); ?></a>
            </div>
          </div>
        <?php } ?>
      </div>
     <?php } ?>
   <?php if(in_array('title',$this->option)){ ?>   
      <div class="sesusercovervideo_profile_title">
        <p>
          <?php echo $this->subject->getTitle(); ?>
          <?php if(($this->sesmemberenable || $this->sesuserdocverificationenable) && in_array('verifiedLabel',$this->option) && (isset($getUserInfoItem->user_verified) || count($this->documents) > 0)){ ?>
            <i class="<?php if(!empty($this->show_ver_tip)) { ?> sesbasic_verify_tip <?php } ?> sesbasic_verify_icon" title="<?php echo $this->translate('Verified') ;?>"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 347.971 347.971" style="enable-background:new 0 0 347.971 347.971;" xml:space="preserve"><path d="M317.309,54.367C257.933,54.367,212.445,37.403,173.98,0C135.519,37.403,90.033,54.367,30.662,54.367 c0,97.405-20.155,236.937,143.317,293.604C337.463,291.305,317.309,151.773,317.309,54.367z M162.107,225.773l-47.749-47.756 	l21.379-21.378l26.37,26.376l50.121-50.122l21.378,21.378L162.107,225.773z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i>
            <?php if($this->sesuserdocverificationenable && count($this->documents) > 0) { ?>
            <?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_verification_info.tpl'; ?>
            <?php } ?>
          <?php } ?>
        </p>
      </div>
      <?php } ?> 
      
      <div class="sesusercovervideo_cover_content sesbasic_clearfix">
      	<div class="sesusercovervideo_cover_content_left">
        	
      <?php if(in_array('membersince',$this->option)){ ?>    
          <p class="sesusercovervideo_cover_field">
          	<i class="fa fa-clock-o"></i>
            <span>
              <?php echo  $this->translate('Member Since').': '.$this->timestamp($this->subject->creation_date) ; ?>
            </span>
          </p>
        <?php } ?>
        
         <?php if(in_array('location',$this->option) && $this->sesmemberenable && $this->subject->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_enable_location', 1)){ ?>
						<p class="sesusercovervideo_cover_field sesbasic_clearfix"> 
              <i class="fa fa-map-marker"></i>
              <span>
              	<a href="<?php echo $this->url(array('resource_id' => $this->subject->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl"><?php echo $this->subject->location; ?></a>
              </span>
            </p>
          <?php } ?>
          
           <?php if(in_array('dob',$this->option)){ 
            $getFieldsObjectsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($this->subject); 
              if (!empty($getFieldsObjectsByAlias['birthdate'])) {
                $optionId = $getFieldsObjectsByAlias['birthdate']->getValue($this->subject); 
                if ($optionId && @$optionId->value) {
                 //$age = floor((time() - strtotime($optionId->value)) / 31556926);
                }
              }
          ?>
          <?php if(!empty($optionId) && @$optionId->value){ ?>
            <p class="sesusercovervideo_cover_field sesbasic_clearfix"> 
              <i class="fa fa-birthday-cake" title="<?php echo $this->translate('Date of birth');?>"></i>
             <?php if((date('m-d',time())) == (date('m-d',strtotime($optionId->value)))) 
            	$todayBirthday = true;
             else
             	$todayBirthday = false;
            ?>
                           <span>
                   <?php $label = $this->locale()->toDate($optionId->value, array('size' => 'long', 'timezone' => false)); ?>
                   <?php echo $label; ?>
                </span>
            </p>
            <?php } ?>          			
          <?php } ?>
          
           <!-- get Mutual firends -->     
           <?php  if(in_array('mutualfriend',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('sesmember') && !$this->viewer->isSelf($this->subject) && $mutualFirends = Engine_Api::_()->getApi('core', 'sesmember')->getMutualFriendCount($this->subject,$this->viewer)){
              ?>
              <p class="sesusercovervideo_cover_field sesbasic_clearfix"> 
                <i title="<?php echo $this->translate(array('%s mutual friend', '%s  mutual friends', $mutualFirends), $this->locale()->toNumber($mutualFirends))?>" class="fa fa-users"></i>
                 <?php if($this->sesmemberenable){ ?>
                 	<a href="<?php echo $this->url(array('user_id' => $this->subject->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo   $mutualFirends. str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s  Mutual Friend', '%s  Mutual Friends', $mutualFirends), $this->locale()->toNumber($mutualFirends)))); ?></a>
                 <?php }else{ ?>
                  <span class="sesusercovervideo_cover_stat_txt"><?php echo $mutualFirends; ?> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s  Mutual Friend', '%s  Mutual Friends', $mutualFirends), $this->locale()->toNumber($mutualFirends)))); ?></span>
                 <?php } ?>
              </p>    
           <?php
           } ?>
          <!-- get Total firends -->     
          <?php  if(in_array('totalfriends',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('sesmember') || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('user')) && $totalFirends = $this->subject->membership()->getMemberCount($this->subject) ){
               ?>
              <p class="sesusercovervideo_cover_field sesbasic_clearfix"> 
              <i title="<?php echo $this->translate(array('%s friend', '%s  friends', $totalFirends), $this->locale()->toNumber($totalFirends))?>" class="fa fa-users"></i>
              <?php if($this->sesmemberenable){ ?>
               <a href="<?php echo $this->url(array('user_id' => $this->subject->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo   $totalFirends. str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Friend', '%s Friends', $totalFirends), $this->locale()->toNumber($totalFirends)))); ?></a>
               <?php }else{ ?>
              <span class="sesusercovervideo_cover_stat_txt"> <?php echo $totalFirends; ?> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Friend', '%s Friends', $totalFirends), $this->locale()->toNumber($totalFirends)))); ?></span>
              <?php } ?>
            </p>    
           <?php
           } ?>
            <?php if(in_array('rating',$this->option) && $this->sesmemberenable){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
          		<div class="sesusercovervideo_cover_rating sesbasic_clearfix">
                <div id="video_rating" class="sesbasic_rating_star floatL" onmouseout="rating_out();">
                  <span id="rate_cover_1" class="fa fa-star"  onmouseover="rating_over_cover(1);" onclick="rate_cover(1)"><p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_rating_stars_one',$this->translate('terrible')); ?></p></span>
                  <span id="rate_cover_2"  class="fa fa-star" onmouseover="rating_over_cover(2);" onclick="rate_cover(2)"><p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_rating_stars_two',$this->translate('poor')); ?></p></span>
                  <span id="rate_cover_3"  class="fa fa-star"  onmouseover="rating_over_cover(3);" onclick="rate_cover(3)"><p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_rating_stars_three',$this->translate('average')); ?></p></span>
                  <span id="rate_cover_4"  class="fa fa-star" onmouseover="rating_over_cover(4);" onclick="rate_cover(4)"><p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_rating_stars_four',$this->translate('very good')); ?></p></span>
                  <span id="rate_cover_5"  class="fa fa-star" onmouseover="rating_over_cover(5);" onclick="rate_cover(5)"><p><?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_rating_stars_five',$this->translate('excellent')); ?></p></span>
                  <span id="rating_text_cover" class="sesbasic_rating_text"><?php echo $this->translate('click to rate');?></span>
                </div>
                <a class="details_btn sessmoothbox" href="<?php echo $this->url(array('action'=>'review-stats','user_id'=>$this->subject->getIdentity()), 'sesmember_general'); ?>" title="Rating Details">
                  Rating Details
               </a>
             </div>
            <?php } ?>
        </div>
				<div class="sesusercovervideo_cover_stats sesbasic_clearfix">
     			<ul>
          <?php if(in_array('likecount',$this->option) && $this->sesmemberenable){ ?>
            <li>
              <span><i class="fa fa-thumbs-o-up"></i></span>
              <?php echo $this->subject->like_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Like', '%s Likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)))); ?>
            </li>     
            <?php $followCount = count(Engine_Api::_()->getDbTable('follows', 'sesmember')->getFollowers($this->subject->getIdentity())); ?>
            <li>
              <span><i class="fa fa-check"></i></span>
              <?php echo $this->translate(" %s Followers", $followCount); ?>
            </li>
          <?php } ?>
          <?php if(in_array('viewcount',$this->option) && $this->sesmemberenable){ ?>
            <li>
              <span><i class="fa fa-eye"></i></span>
              <?php echo $this->subject->view_count ?><?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)))); ?></span>
            </li>
          <?php } ?>
          	<?php if(in_array('videocount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesvideo')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('video')))){ ?> 
           		<?php $video_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser('video',$this->subject->getIdentity()); ?>
              <li> 
              	<span><i class="fa fa-video-camera"></i></span>
                <?php echo $video_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Video', '%s Videos', $video_count), $this->locale()->toNumber($video_count)))); ?>
              </li>
           	<?php } ?>
            <?php if(in_array('albumcount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesalbum')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('album')))){ ?>
            <?php $photo_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser('album',$this->subject->getIdentity()); ?>
              <li>
                <span><i class="fa fa-picture-o"></i></span> 
                <?php echo $photo_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Album', '%s Albums', $photo_count), $this->locale()->toNumber($photo_count)))); ?>
              </li>
         		<?php } ?>
            <?php if(in_array('eventcount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesevent')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('event')))){ ?>
            <?php $event_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser('event',$this->subject->getIdentity()); ?>
              <li>
              	<span><i class="fa fa-calendar"></i></span>  
                <?php echo $event_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Event', '%s Events', $event_count), $this->locale()->toNumber($event_count)))); ?>
              </li>
         		<?php } ?>
         <?php if(in_array('forumcount',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('forum'))){ ?>
            <?php $forum_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser('forum_topic',$this->subject->getIdentity()); ?>
              <li>
              	<span><i class="fa fa-file-text"></i></span> 
                <?php echo $forum_count; ?>
                <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Forum', '%s Forums', $forum_count), $this->locale()->toNumber($forum_count)))); ?>
              </li>
         <?php } ?>          
         <?php if(in_array('musiccount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('music')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesmusic')))){ ?>
         <?php if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('music')))
         					$musicItem = 'music_playlist';
               else
               		$musicItem = 'sesmusic_albums';
           ?>
            <?php $music_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser($musicItem,$this->subject->getIdentity()); ?>
              <li>
                <span><i class="fa fa-music"></i></span> 
                <?php echo $music_count; ?><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Music', '%s Musics', $music_count), $this->locale()->toNumber($music_count)))); ?>
              </li>
         <?php } ?>         
         <?php if(in_array('groupcount',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('group'))){ ?>
            <?php $group_count =  Engine_Api::_()->getApi('core', 'sesusercovervideo')->getModuleRecordsOfUser('group',$this->subject->getIdentity()); ?>
              <li>
                <span><i class="fa fa-users"></i></span>  
                <?php echo $group_count; ?></span><?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Group', '%s Groups', $group_count), $this->locale()->toNumber($group_count)))); ?>
              </li>
         	<?php } ?>
        </ul>
			</div>
        
        <?php if(in_array('recentlyViewedBy',$this->option)  && $this->sesmemberenable){ ?>
          <div class="sesusercovervideo_users floatR">
            <?php $recentlyViewed = Engine_Api::_()->getDbTable('userviews', 'sesmember')->whoViewedMe(array('resources_id'=>$this->subject->getIdentity(),'limit'=>5)); ?>
            <?php if(count($recentlyViewed) > 0){ ?>
              <span><?php echo $this->translate("Recently viewed by:"); ?></span>
              <?php foreach($recentlyViewed as $val){ ?>
              <a href="<?php echo $val->getHref(); ?>" class="ses_tooltip" data-src="<?php echo $val->getGuid(); ?>">
                <?php echo $this->itemPhoto($val, 'thumb.icon'); ?>
              </a>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
      <?php //User Cover Photo Work ?>
      <div class="sesusercovervideo_cover_buttons">
        <?php include APPLICATION_PATH .  '/application/modules/Sesusercovervideo/widgets/sesusercovervideo-cover/icon_button.tpl';?>
      </div>
    <?php //End User Cover Photo Work ?>
    </div>
  </div>
</div>
<?php if(in_array('options',$this->option)) { ?>
	<div id="sesusercover_option_data_div">
  	<?php echo $this->content()->renderWidget("user.profile-options",array("optionsG"=>true)); ?>
  </div>
<?php } ?>
<script type="application/javascript">
sesJqueryObject('<div id="sesusercover_profile_options" class="sesuser_cover_options_pulldown sesbasic_bxs" style="display:none;"><i class="fa fa-caret-up"></i>'+sesJqueryObject('#sesusercover_option_data_div').html()+'</div>').appendTo('body');
sesJqueryObject('#sesusercover_option_data_div').remove();
<?php if(($this->module == 'user' || $this->module == 'sesmember') && $this->controller == 'profile' && $this->action == 'index'): ?>
function doResizeForButton(){
	var topPositionOfParentDiv =  sesJqueryObject(".sesusercover_option_btn").offset().top + 45;
	topPositionOfParentDiv = topPositionOfParentDiv+'px';
	var leftPositionOfParentDiv =  sesJqueryObject(".sesusercover_option_btn").offset().left - 160;
	leftPositionOfParentDiv = leftPositionOfParentDiv+'px';
	sesJqueryObject('.sesuser_cover_options_pulldown').css('top',topPositionOfParentDiv);
	sesJqueryObject('.sesuser_cover_options_pulldown').css('left',leftPositionOfParentDiv);
}
window.addEvent('load',function(){
	doResizeForButton();
});
<?php endif; ?>
sesJqueryObject(document).click(function(event){
	if(event.target.id == 'parent_container_option' || event.target.id == 'fa-ellipsis-v'){
		if(sesJqueryObject('#parent_container_option').hasClass('active')){
			sesJqueryObject('#parent_container_option').removeClass('active');
			sesJqueryObject('.sesuser_cover_options_pulldown').hide();	
		}else{
			sesJqueryObject('#parent_container_option').addClass('active');
			sesJqueryObject('.sesuser_cover_options_pulldown').show();	
		}
	}else{
		sesJqueryObject('#parent_container_option').removeClass('active');
		sesJqueryObject('.sesuser_cover_options_pulldown').hide();	
	}
});
</script>

<?php if(isset($this->can_edit)){ ?>
<script type="application/javascript">
  
    sesJqueryObject(document).on('click','#fromCoverPhotoExistingAlbum',function(){
    sesJqueryObject('#covervideo_popup_existing_upload').show();
    existingCoverVideosGet();
    });

    var canPaginateVideoPageNumber = 1;
    function existingCoverVideosGet() {
    sesJqueryObject('#covervideo_profile_existing_img').show();
    var URL = en4.core.staticBaseUrl+'sesusercovervideo/index/existing-videos/';
    (new Request.HTML({
    method: 'post',
    'url': URL ,
    'data': {
      format: 'html',
        cover: 'cover',
        page: canPaginateVideoPageNumber,
        is_ajax: 1
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      document.getElementById('covervideo_existing_data').innerHTML = document.getElementById('covervideo_existing_data').innerHTML + responseHTML;
      //       	sesJqueryObject('#covervideo_existing_data').slimscroll({
      // 					 height: 'auto',
      // 					 alwaysVisible :true,
      // 					 color :'#000',
      // 					 railOpacity :'0.5',
      // 					 disableFadeOut :true,					 
      // 					});
      // 					sesJqueryObject('#covervideo_existing_data').slimScroll().bind('slimscroll', function(event, pos){
      // 					 if(canPaginateExistingVideos == '1' && pos == 'bottom' && sesJqueryObject('#covervideo_profile_existing_img').css('display') != 'block') {
      //             sesJqueryObject('#covervideo_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
      //             existingCoverVideosGet();
      // 					 }
      // 					});
      sesJqueryObject('#covervideo_profile_existing_img').hide();
    }
    })).send();
    }

    sesJqueryObject(document).on('click','a[id^="sesusercovervideo_cover_upload_existing_videos_"]',function(event) {
      event.preventDefault();
      var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
      if(!id)
        return;
      sesJqueryObject('#sesusercovervideo_cover_photo_loading').show();
      hideCoverVideoUpload();
      var URL = en4.core.staticBaseUrl+'sesusercovervideo/index/uploadexistingcovervideo/';
      (new Request.HTML({
        method: 'post',
        'url': URL ,
        'data': {
          format: 'html',
            id: id,
            cover: 'cover',
            user_id:'<?php echo $this->subject->user_id; ?>'
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          text = JSON.parse(responseHTML);
          if(text.status == 'true') {
            if(text.src != '') {
              sesJqueryObject('#sesusercovervideo_cover_image').html('<video loop="loop" id="sesusercovervideo_cover_video_id" style="display:block;" controls autoplay><source id="sesusercovervideo_cover_video_id_src" src="'+text.src+'" type="video/mp4"></video><img id="sesusercoverphoto_cover_id" src="" style="display:none;" />');
            }
                        sesJqueryObject('#sesusercovervideo_cover_default').hide();
                        sesJqueryObject('#uploadCoverVideo').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Video'));
                        sesJqueryObject('#removeVideoCover').css('display','block');
          }
                    sesJqueryObject('#sesusercovervideo_cover_photo_loading').hide();
                    sesJqueryObject('#uploadFilesesUserCoverPhoto').val('');
        }
      })).send();
    });

    sesJqueryObject('<div class="sesusercovervideo_photo_update_popup sesbasic_bxs" id="covervideo_popup_cam_upload" style="display:none"><div class="sesusercovervideo_photo_update_popup_overlay"></div><div class="sesusercovervideo_photo_update_popup_container sesusercovervideo_photo_update_webcam_container"><div class="sesusercovervideo_photo_update_popup_header sesbm"><?php echo $this->translate("Click to Take Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverVideoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercovervideo_photo_update_popup_webcam_options"><div id="coverphoto_camera" style="background-color:#ccc;"></div><div class="centerT sesusercovervideo_photo_update_popup_btns">   <button onclick="take_coverphotosnapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Photo") ?></button><button onclick="hideCoverVideoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesusercovervideo_photo_update_popup sesbasic_bxs" id="covervideo_popup_existing_upload" style="display:none"><div class="sesusercovervideo_photo_update_popup_overlay"></div><div class="sesusercovervideo_photo_update_popup_container" id="coverphoto_popup_container_existing"><div class="sesusercovervideo_photo_update_popup_header sesbm"><?php echo $this->translate("Select a Video") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverVideoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercovervideo_photo_update_popup_content"><div id="covervideo_existing_data"></div><div id="covervideo_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');

    function hideCoverVideoUpload(){
      canPaginateVideoPageNumber = 1;
      sesJqueryObject('#covervideo_popup_cam_upload').hide();
      sesJqueryObject('#covervideo_popup_existing_upload').hide();
      sesJqueryObject('.sesusercovervideo_photo_update_popup_content').html('<div id="covervideo_existing_data"></div><div id="covervideo_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }

<!-- Upload Main User Photo Code -->
function uploadFileToServerMain(files){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sesusercovervideo_cover_main_photo').append('<div id="sesusercovervideo_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;border-radius:50%;"></div>');
	<?php }else{ ?>
		sesJqueryObject('.sesusercovervideo_cover_main_photo').append('<div id="sesusercovervideo_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
	<?php } ?>
	var formData = new FormData();
	formData.append('webcam', files);
	uploadURL = en4.core.staticBaseUrl+'sesusercovervideo/index/upload-main/user_id/<?php echo $this->subject->user_id ?>';
	var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			response = sesJqueryObject.parseJSON(response);
			sesJqueryObject('#uploadFileMainsesusercovervideo').val('');
			sesJqueryObject('#sesusercovervideo_cover_loading_main').remove();
			sesJqueryObject('.sesusercovervideo_cover_image_main').attr('src', response.src);
			sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
			sesJqueryObject('#sesusercovervideo_main_photo_i').css('display','block !important');
     }
    });
}

sesJqueryObject('#sesusercovervideo_main_photo_i').click(function(){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sesusercovervideo_cover_main_photo').append('<div id="sesusercovervideo_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;border-radius:50%;"></div>');
	<?php }else{ ?>
		sesJqueryObject('.sesusercovervideo_cover_main_photo').append('<div id="sesusercovervideo_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
	<?php } ?>
		var user_id = '<?php echo $this->subject->user_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'sesusercovervideo/index/remove-main/user_id/'+user_id;
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add User Photo'));
				response = sesJqueryObject.parseJSON(response);
				sesJqueryObject('.sesusercovervideo_cover_image_main').attr('src', response.src);
				sesJqueryObject('#sesusercovervideo_cover_loading_main').remove();
				sesJqueryObject('#sesusercovervideo_main_photo_i').hide();
				//silence
			 }
			}); 
});

function uploadFileMainsesusercovervideo(input){	
	 var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
				uploadFileToServerMain(input.files[0]);
    }else{
				//Silence
		}

}

sesJqueryObject(document).on('click','#change_main_cvr_pht',function(){
	document.getElementById('uploadFileMainsesusercovervideo').click();	
});

    function removeCoverPhoto() {
      sesJqueryObject('#removeCover').css('display','none');
      sesJqueryObject('#sesusercovervideo_cover_photo_loading').show();

      var user_id = '<?php echo $this->subject->user_id; ?>';
      uploadURL = en4.core.staticBaseUrl+'sesusercovervideo/index/remove-cover/user_id/'+user_id;
      var jqXHR=sesJqueryObject.ajax({
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        success: function(response) {
          
          var response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#sesusercovervideo_cover_photo_loading').hide();
          sesJqueryObject('#uploadCoverVideo').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Video'));
          //update defaultphoto if available from admin.
          if(response.src) {
            sesJqueryObject('#sesusercovervideo_cover_video_id').hide();
            sesJqueryObject('#sesusercoverphoto_cover_id').show();
            sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',response.src);
          }
        }
      }); 
    }


sesJqueryObject(document).click(function(event) {
	if(event.target.id == 'change_coverphoto_profile_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
		sesJqueryObject('#sesusercovervideo_cover_option_main_id').removeClass('active')
		if(sesJqueryObject('#sesusercovervideo_cover_change').hasClass('active'))
			sesJqueryObject('#sesusercovervideo_cover_change').removeClass('active');
		else
			sesJqueryObject('#sesusercovervideo_cover_change').addClass('active');
	}else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){console.log('tyes');
		sesJqueryObject('#sesusercovervideo_cover_change').removeClass('active');		
		if(sesJqueryObject('#sesusercovervideo_cover_option_main_id').hasClass('active'))
			sesJqueryObject('#sesusercovervideo_cover_option_main_id').removeClass('active');
		else
			sesJqueryObject('#sesusercovervideo_cover_option_main_id').addClass('active');
			
	}else{
			sesJqueryObject('#sesusercovervideo_cover_change').removeClass('active')
			sesJqueryObject('#sesusercovervideo_cover_option_main_id').removeClass('active')
	}
});
</script>
<?php } ?>
