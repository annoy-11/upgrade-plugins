<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _type1.tpl 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if($this->sesmemberenable) { ?>
<?php $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($this->subject->getIdentity());?>
<?php } ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesusercoverphoto/externals/styles/cover_layout1.css'); ?>

<div class="sesusercoverphoto_cover_wrapper sesbasic_bxs sesusercover_cover_type1 <?php if($this->is_fullwidth){?>sesusercoverphoto_cover_wrapper_full<?php } ?>" style="height:<?php echo $this->height; ?>px">
<div class="sesusercoverphoto_cover_container sesbasic_bxs <?php echo $this->tab == 'inside' ? 'sesusercoverphoto_cover_tabs_wrap' : '' ?> " style="height:<?php echo $this->height; ?>px">
  <!--Cover Photo-->
   <?php if(isset($this->subject->coverphoto) && $this->subject->coverphoto != 0 && $this->subject->coverphoto != ''){ 
  			 $memberCover =	Engine_Api::_()->storage()->get($this->subject->coverphoto, ''); 
         if($memberCover)
         	$memberCover = $memberCover->map();
   }else
   		$memberCover = $this->defaultCoverPhoto;        
	?>
  <div id="sesusercoverphoto_cover_default" class="sesusercoverphoto_cover_thumbs" style="display:<?php echo !$memberCover ? 'block' : 'none'; ?>;">
 </div>
  <?php $coverphotoparams = !empty($this->subject->coverphotoparams) ? Zend_Json_Decoder::decode($this->subject->coverphotoparams) : Zend_Json_Decoder::decode('{"top":"0","left":0}'); ?>
 	<div class="sesusercoverphoto_cover_image">
    <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercovervideo') && isset($this->subject->cover_video) && $this->subject->cover_video) { ?>
      <?php $video_cover =	Engine_Api::_()->storage()->get($this->subject->cover_video, ''); ?>
      <video loop="loop" id="sesusercoverphoto_cover_video_id" controls autoplay>
        <source src="<?php echo $this->layout()->staticBaseUrl . $video_cover->storage_path ?>" type="video/mp4">
      </video>
      <img id="sesusercoverphoto_cover_id" src="<?php echo $memberCover; ?>" style="top:<?php echo $coverphotoparams['top'] . 'px'; ?>;display:none;" />
    <?php } else { ?>
      <img id="sesusercoverphoto_cover_id" src="<?php echo $memberCover; ?>" style="top:<?php echo $coverphotoparams['top'] . 'px'; ?>;" />
  	<?php } ?>
  </div>
  <span class="sesusercoverphoto_cover_fade"></span>
  <!--Upload/Change Cover Options-->
 <?php if($this->can_edit  && $this->canCreate){ ?>
  <div class="sesusercoverphoto_cover_change_cover" id="sesusercoverphoto_cover_change">
  	 <a href="javascript:;" id="cover_change_btn">
     	<i class="fa fa-camera" id="cover_change_btn_i"></i>
      <span id="change_coverphoto_profile_txt"><?php echo $this->translate("Update Cover Photo"); ?></span>
    </a>
    <div class="sesusercoverphoto_change_cover_options sesbasic_option_box"> 
    	<i class="sesusercoverphoto_change_cover_options_main_arrow"></i>
      <input accept="image/*" type="file" id="uploadFilesesUserCoverPhoto" name="art_cover" onchange="readCoverPhotoImageUrl(this);" style="display:none">
      <a id="uploadCoverPhotoWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Cover Photo"); ?></a>
      
      <a id="fromCoverPhotoExistingAlbum" href="javascript:;"><i class="fa fa-picture-o"></i><?php echo $this->translate("Choose From Existing Albums"); ?></a>
      
      <a id="uploadCoverPhoto" href="javascript:;"><i class="fa fa-plus"></i><?php echo ($this->subject->coverphoto != 0 && $this->subject->coverphoto != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo');; ?></a>
      
      <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesusercovervideo') && $this->canCreateVideo) { ?>
        <a href="<?php echo 'sesusercovervideo/index/subject_id/'.$this->subject->getIdentity(); ?>" class="smoothbox" id="uploadCoverVideo" href="javascript:;"><i class="fa fa-plus"></i><?php echo ($this->subject->cover_video != 0 && $this->subject->cover_video != '') ? $this->translate('Change Cover Video') : $this->translate('Add Cover Video');; ?></a>
      <?php } ?>
      
      <a id="removeCover" href="<?php echo 'sesusercoverphoto/index/confirmation/'; ?>" class="sessmoothbox" style="display:<?php echo ((isset($this->subject->coverphoto) && $this->subject->coverphoto != 0 && $this->subject->coverphoto != '') || (isset($this->subject->cover_video) && $this->subject->cover_video != 0 && $this->subject->cover_video != '')) ? 'block' : 'none' ; ?>;" data-src="<?php echo $this->subject->coverphoto; ?>"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover'); ?></a>
      
     	<a style="display:<?php echo $this->subject->coverphoto ? 'block !important' : 'none !important' ; ?>;" href="javascript:;" id="sesusercoverphoto_main_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>
    </div>
  </div>
  <div class="sesusercoverphoto_cover_reposition_btn" style="display:none;">
  	<a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
    <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
  </div>
 <?php } ?>
  <?php if($this->sesmemberenable): ?>
  <div class="sesusercover_cover_labels">
  <?php if(in_array('featuredlabel',$this->option) && $getUserInfoItem->featured){ ?>
    <p class="sesmember_label_featured"><?php echo $this->translate("FEATURED");?></p>
  <?php } ?>
  <?php if(in_array('sponsoredLabel',$this->option) && $getUserInfoItem->sponsored){ ?>
    <p class="sesmember_label_sponsored"><?php echo $this->translate("SPONSORED");?></p>
   <?php } ?>
  <?php if(in_array('viplabel',$this->option) && $getUserInfoItem->vip){ ?>
    <i class="sesmember_vip_label" title="<?php echo $this->translate('VIP') ;?>"></i>
  <?php } ?>
  </div>
  <?php endif; ?>
  <div class="sesusercoverphoto_cover_inner">
    <div class="sesusercoverphoto_cover_cont sesbasic_clearfix">
      <div class="sesusercoverphoto_cover_cont_inner">
        <!--Main Photo-->     
        <?php
        	if(!$this->subject->getPhotoUrl('thumb.profile')  && !$this->sesmemberenable){
            $imgurl = 'application/modules/User/externals/images/nophoto_user_thumb_profile.png';
          } else
            $imgurl = $this->subject->getPhotoUrl('thumb.profile');
      ?>
      <?php if(in_array('photo',$this->option)){ ?>      
        <div class="sesusercoverphoto_cover_main_photo">
         <img src="<?php echo $imgurl ; ?>" alt="" class="thumb_profile item_photo_user sesusercoverphoto_cover_image_main">
        <?php if($this->can_edit){ ?>
            <div class="sesusercoverphoto_cover_change_cover_main" id="sesusercoverphoto_cover_option_main_id">
            <input type="file" id="uploadFileMainCoverPhoto" name="main_photo_cvr" onchange="uploadFileMainCoverPhoto(this);"  style="display:none" />
              <a href="javascript:;" id="change_main_btn">
                <i class="fa fa-camera" id="change_main_i"></i>
                <span id="change_main_txt"><?php echo $this->translate("Upload Profile Picture"); ?></span>
              </a>
              <div class="sesusercoverphoto_change_cover_options_main sesbasic_option_box">
                <i class="sesusercoverphoto_change_cover_options_main_arrow"></i>
                <a href="javascript:;" id="change_main_cvr_pht"><i class="fa fa-plus"></i><?php echo $this->subject->photo_id  ?  $this->translate("Change User Photo") : $this->translate("Add User Photo"); ?></a>
                <a style="display:<?php echo $this->subject->photo_id ? 'block !important' : 'none !important' ; ?>;" href="javascript:;" id="sesusercoverphoto_main_photo_i"><i class="fa fa-trash"></i><?php echo $this->translate("Remove User Photo"); ?></a>
              </div>
            </div>
        <?php } ?>
          </div>
         <?php } ?>
        <div class="sesusercoverphoto_cover_info">
         <?php if(in_array('title',$this->option)){ ?>
          <h2 class="sesusercoverphoto_cover_title">
          	<?php echo $this->subject->getTitle(); ?>
            <?php if(($this->sesmemberenable || $this->sesuserdocverificationenable) && in_array('verifiedLabel',$this->option) && (isset($getUserInfoItem->user_verified) || count($this->documents) > 0)){ ?>
          		<i class="<?php if(!empty($this->show_ver_tip)) { ?> sesbasic_verify_tip <?php } ?> sesbasic_verify_icon" title="<?php echo $this->translate('Verified') ;?>"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 347.971 347.971" style="enable-background:new 0 0 347.971 347.971;" xml:space="preserve"><path d="M317.309,54.367C257.933,54.367,212.445,37.403,173.98,0C135.519,37.403,90.033,54.367,30.662,54.367 c0,97.405-20.155,236.937,143.317,293.604C337.463,291.305,317.309,151.773,317.309,54.367z M162.107,225.773l-47.749-47.756 	l21.379-21.378l26.37,26.376l50.121-50.122l21.378,21.378L162.107,225.773z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></i>
              <?php if($this->sesuserdocverificationenable && count($this->documents) > 0) { ?>
          		<?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_verification_info.tpl'; ?>
              <?php } ?>
            <?php } ?>
          </h2>
         <?php } ?>
        <?php if(in_array('membersince',$this->option)){ ?>
          <div class="sesusercoverphoto_cover_field sesbasic_clearfix"> 
          	<i class="fa fa-clock-o"></i>
            <span><?php echo  $this->translate('Member Since').': '.$this->timestamp($this->subject->creation_date) ; ?></span>
          </div>
          <?php } ?>
          <?php if(in_array('location',$this->option) && $this->sesmemberenable && $getUserInfoItem->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember_enable_location', 1)){ ?>
						<div class="sesusercoverphoto_cover_field sesbasic_clearfix"> 
              <i class="fa fa-map-marker"></i>
              <span>
              	<a href="<?php echo $this->url(array('resource_id' => $this->subject->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl"><?php echo $getUserInfoItem->location; ?></a>
              </span>
            </div>
          <?php } ?>
           <?php if(in_array('dob',$this->option)){ 
            $getFieldsObjectsByAlias = Engine_Api::_()->fields()->getFieldsObjectsByAlias($this->subject); 
              if (!empty($getFieldsObjectsByAlias['birthdate'])) {
                $optionId = $getFieldsObjectsByAlias['birthdate']->getValue($this->subject); 
              }
            ?>
            <?php if(!empty($optionId) && $optionId->value){ ?>
              <div class="sesusercoverphoto_cover_field sesbasic_clearfix"> 
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
                  </div>
                <?php } ?>          			
           		<?php } ?>
              
             <!-- get Mutual firends -->     
             <?php  if(in_array('mutualfriend',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('sesmember') && !$this->viewer->isSelf($this->subject) && $mutualFirends = Engine_Api::_()->getApi('core', 'sesmember')->getMutualFriendCount($this->subject,$this->viewer)){
                ?>
                <div class="sesusercoverphoto_cover_field sesbasic_clearfix"> 
                  <i title="<?php echo $this->translate(array('%s mutual friend', '%s  mutual friends', $mutualFirends), $this->locale()->toNumber($mutualFirends))?>" class="fa fa-users"></i>
                 <?php if($this->sesmemberenable){ ?>
                 	<a href="<?php echo $this->url(array('user_id' => $this->subject->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo   $mutualFirends. str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s  Mutual Friend', '%s  Mutual Friends', $mutualFirends), $this->locale()->toNumber($mutualFirends)))); ?></a>
                 <?php }else{ ?>
                  <span class="sesusercoverphoto_cover_stat_txt"><?php echo $mutualFirends; ?> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s  Mutual Friend', '%s  Mutual Friends', $mutualFirends), $this->locale()->toNumber($mutualFirends)))); ?></span>
                 <?php } ?>
                </div>    
             <?php
             } ?>
            <!-- get Total firends -->     
            <?php  if(in_array('totalfriends',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('sesmember') || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable('user')) && $totalFirends = $this->subject->membership()->getMemberCount($this->subject)){
                ?>
                <div class="sesusercoverphoto_cover_field sesbasic_clearfix"> 
                <i title="<?php echo $this->translate(array('%s friend', '%s  friends', $totalFirends), $this->locale()->toNumber($totalFirends))?>" class="fa fa-users"></i>
                 <?php if($this->sesmemberenable){ ?>
                   <a href="<?php echo $this->url(array('user_id' => $this->subject->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo   $totalFirends. str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Friend', '%s Friends', $totalFirends), $this->locale()->toNumber($totalFirends)))); ?></a>
                   <?php }else{ ?>
                  <span class="sesusercoverphoto_cover_stat_txt"> <?php echo $totalFirends; ?> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Friend', '%s Friends', $totalFirends), $this->locale()->toNumber($totalFirends)))); ?></span>
                  <?php } ?>
              </div>    
             <?php
           } ?>
           
          <!--Member Statics-->          
            <div class="sesusercoverphoto_cover_stats sesbasic_clearfix clear">
     
           <?php if(in_array('videocount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesvideo')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('video')))){ ?> 
           		<?php $video_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser('video',$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s video', '%s videos', $video_count), $this->locale()->toNumber($video_count)); ?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $video_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Video', '%s Videos', $video_count), $this->locale()->toNumber($video_count)))); ?></span>
              </div>
           <?php } ?>
            <?php if(in_array('albumcount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesalbum')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('album')))){ ?>
            <?php $photo_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser('album',$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s album', '%s albums', $photo_count), $this->locale()->toNumber($photo_count))?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $photo_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Album', '%s Albums', $photo_count), $this->locale()->toNumber($photo_count)))); ?></span>
              </div>
         <?php } ?>
            <?php if(in_array('eventcount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesevent')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('event')))){ ?>
            <?php $event_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser('event',$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s event', '%s events', $event_count), $this->locale()->toNumber($event_count))?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $event_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Event', '%s Events', $event_count), $this->locale()->toNumber($event_count)))); ?></span>
              </div>
         <?php } ?>
         <?php if(in_array('forumcount',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('forum'))){ ?>
            <?php $forum_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser('forum_topic',$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s forum', '%s forums', $forum_count), $this->locale()->toNumber($forum_count))?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $forum_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Forum', '%s Forums', $forum_count), $this->locale()->toNumber($forum_count)))); ?></span>
              </div>
         <?php } ?>          
         <?php if(in_array('musiccount',$this->option) && (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('music')) || Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesmusic')))){ ?>
         <?php if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('music')))
         					$musicItem = 'music_playlist';
               else
               		$musicItem = 'sesmusic_albums';
           ?>
            <?php $music_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser($musicItem,$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s music', '%s musics', $music_count), $this->locale()->toNumber($music_count))?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $music_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Music', '%s Music', $music_count), $this->locale()->toNumber($music_count)))); ?></span>
              </div>
         <?php } ?>         
         <?php if(in_array('groupcount',$this->option) && Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('group'))){ ?>
            <?php $group_count =  Engine_Api::_()->getApi('core', 'sesusercoverphoto')->getModuleRecordsOfUser('group',$this->subject->getIdentity()); ?>
              <div title="<?php echo $this->translate(array('%s group', '%s groups', $group_count), $this->locale()->toNumber($group_count))?>"> 
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $group_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Group', '%s Groups', $group_count), $this->locale()->toNumber($group_count)))); ?></span>
              </div>
         <?php } ?>
          <?php if(in_array('viewcount',$this->option) && $this->sesmemberenable){ ?>
              <div title="<?php echo $this->translate(array('%s view', '%s views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count))?>">
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $this->subject->view_count ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/','',$this->translate(array('%s View', '%s Views', $this->subject->view_count), $this->locale()->toNumber($this->subject->view_count)))); ?></span>
              </div>
          
              <?php $followCount = count(Engine_Api::_()->getDbTable('follows', 'sesmember')->getFollowers($this->subject->getIdentity())); ?>
              <div title="<?php echo $this->translate('%s Followers', $followCount); ?>">
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $followCount; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> Followers</span>
              </div>
          <?php } ?>
          <?php if(in_array('likecount',$this->option) && $this->sesmemberenable){ ?>
              <div title="<?php echo $this->translate(array('%s like', '%s likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count))?>">
                <span class="sesusercoverphoto_cover_stat_count"><?php echo $this->subject->like_count; ?></span>
                <span class="sesusercoverphoto_cover_stat_txt"> <?php echo str_replace(',','',preg_replace('/[0-9]+/', '', $this->translate(array('%s Like', '%s Likes', $this->subject->like_count), $this->locale()->toNumber($this->subject->like_count)))); ?></span>
              </div>      
        <?php } ?>
            </div>

          <?php if(in_array('rating',$this->option) && $this->sesmemberenable){ ?>
          		<div class="sesusercoverphoto_cover_rating sesbasic_clearfix">
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

            <?php //User Cover Photo Work ?>
              <div class="sesusercoverphoto_cover_buttons">
                <?php include APPLICATION_PATH .  '/application/modules/Sesusercoverphoto/widgets/sesusercoverphoto-cover/icon_button.tpl';?>
              </div>
            <?php //End User Cover Photo Work ?>
          
          <?php if(in_array('recentlyViewedBy',$this->option)  && $this->sesmemberenable){ ?>
            <div class="sesbasic_clearfix sesusercover_users">
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
       <div class="sesusercoverphoto_cover_footer">
       		<div class="sesusercoverphoto_cover_footer_inner">     
           <?php if($this->tab == 'inside'){ ?>
            <div class="sesusercoverphoto_tabs sesusercoverphoto_cover_tabs"></div>
           <?php } ?>
         </div>
       </div>
      </div>
    </div>
  </div>
  <div id="sesusercoverphoto_cover_photo_loading" class="sescoverpphoto_overlay" style="display:none;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>
</div>
</div>
<div id="sesusercover_option_data_div"><?php echo $this->content()->renderWidget("user.profile-options",array("optionsG"=>true)); ?></div>
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
<?php if(($this->module == 'user' || $this->module == 'sesmember') && $this->controller == 'profile' && $this->action == 'index'): ?>
  <?php if($this->tab == 'inside'){ ?>
  <style type="text/css">
  @media only screen and (min-width:767px){
  .layout_core_container_tabs .tabs_alt{ display:none;}
  }
	.displayF{display:none !important;}
  </style>
  <script type="application/javascript">
  if (matchMedia('only screen and (min-width: 767px)').matches) {
  sesJqueryObject(document).ready(function(){
  var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
  	//sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
		sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').addClass('displayF').hide();
		sesJqueryObject('#main_tabs').attr('id','main_tabs_ses');
		sesJqueryObject('.tab_pulldown_contents').find('ul').addClass('ses_ul_mail');
		sesJqueryObject('.tab_pulldown_contents').removeClass('tab_pulldown_contents');
		sesJqueryObject('.sesusercoverphoto_tabs').html(tabs);
  });
  sesJqueryObject(document).on('click','ul#main_tabs li > a',function(){
    if(sesJqueryObject(this).parent().hasClass('more_tab'))
      return;
    var index = sesJqueryObject(this).parent().index() + 2;
    var divLength = sesJqueryObject('.layout_core_container_tabs > div');
    for(i=0;i<divLength.length;i++){
      sesJqueryObject(divLength[i]).hide();
    }		
		sesJqueryObject('#main_tabs_ses').children().eq(index-2).trigger('click');
    sesJqueryObject('.layout_core_container_tabs').children().eq(index).show();
  });
  sesJqueryObject(document).on('click','.tab_pulldown_contents ul li',function(){
  var totalLi = sesJqueryObject('ul#main_tabs > li').length + 1;
  var index = sesJqueryObject(this).index();
  var divLength = sesJqueryObject('.layout_core_container_tabs > div');
	for(i=0;i<divLength.length;i++){
		sesJqueryObject(divLength[i]).hide();
	}
	sesJqueryObject('.ses_ul_mail').children().eq(index).trigger('click');	
  sesJqueryObject('.layout_core_container_tabs').children().eq(index+totalLi).show();
  });
  }
  </script>
  <?php } ?>
<?php endif; ?>
<?php if(isset($this->can_edit)){ ?>
<script type="application/javascript">
var previousPositionOfCover = sesJqueryObject('#sesusercoverphoto_cover_id').css('top');
<!-- Reposition Photo -->
sesJqueryObject('#sesusercoverphoto_main_photo_reposition').click(function(){
		sesJqueryObject('.sesusercoverphoto_cover_reposition_btn').show();
		sesJqueryObject('.sesusercoverphoto_cover_fade').hide();
		sesJqueryObject('#sesusercoverphoto_cover_change').hide();
		sesJqueryObject('.sesusercoverphoto_cover_inner').hide();
		sesJqueryUIMin('#sesusercoverphoto_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
});
sesJqueryObject('#cancelreposition').click(function(){
	sesJqueryObject('.sesusercoverphoto_cover_reposition_btn').hide();
	sesJqueryObject('#sesusercoverphoto_cover_id').css('top',previousPositionOfCover);
	sesJqueryObject('.sesusercoverphoto_cover_fade').show();
	sesJqueryObject('#sesusercoverphoto_cover_change').show();
	sesJqueryObject('.sesusercoverphoto_cover_inner').show();
	sesJqueryUIMin("#sesusercoverphoto_cover_id").dragncrop('destroy');
});

sesJqueryObject('#savereposition').click(function(){
	var sendposition = sesJqueryObject('#sesusercoverphoto_cover_id').css('top');
		sesJqueryObject('#sesusercoverphoto_cover_photo_loading').show();
	var uploadURL = en4.core.staticBaseUrl+'sesusercoverphoto/index/reposition-cover/user_id/<?php echo $this->subject->user_id ?>';
	var formData = new FormData();
	formData.append('position', sendposition);
	var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			data: formData,
			cache: false,
			success: function(response){
				response = sesJqueryObject.parseJSON(response);
				if(response.status == 1){
					previousPositionOfCover = sendposition;
					sesJqueryObject('.sesusercoverphoto_cover_reposition_btn').hide();
					sesJqueryUIMin("#sesusercoverphoto_cover_id").dragncrop('destroy');
					sesJqueryObject('.sesusercoverphoto_cover_fade').show();
					sesJqueryObject('#sesusercoverphoto_cover_change').show();
					sesJqueryObject('.sesusercoverphoto_cover_inner').show();
				}else{
					alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>');	
				}
					sesJqueryObject('#sesusercoverphoto_cover_photo_loading').hide();
				//silence
			 }
			});
	
	
});



<!-- Upload Main User Photo Code -->
function uploadFileToServerMain(files){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sesusercoverphoto_cover_main_photo').append('<div id="sesusercoverphoto_cover_loading_main" class="sescoverpphoto_overlay" style="display:block;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div></div>');
	<?php }else{ ?>
		sesJqueryObject('.sesusercoverphoto_cover_main_photo').append('<div id="sesusercoverphoto_cover_loading_main" class="sescoverpphoto_overlay" style="display:block;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>');
	<?php } ?>
	var formData = new FormData();
	formData.append('webcam', files);
	uploadURL = en4.core.staticBaseUrl+'sesusercoverphoto/index/upload-main/user_id/<?php echo $this->subject->user_id ?>';
	var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			response = sesJqueryObject.parseJSON(response);
			sesJqueryObject('#uploadFileMainCoverPhoto').val('');
			sesJqueryObject('#sesusercoverphoto_cover_loading_main').remove();
			sesJqueryObject('.sesusercoverphoto_cover_image_main').attr('src', response.src);
			sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
			sesJqueryObject('#sesusercoverphoto_main_photo_i').css('display','block !important');
     }
    });
}

sesJqueryObject('#sesusercoverphoto_main_photo_i').click(function(){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sesusercoverphoto_cover_main_photo').append('<div id="sesusercoverphoto_cover_loading_main" class="sescoverpphoto_overlay" style="display:block;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>');
	<?php }else{ ?>
		sesJqueryObject('.sesusercoverphoto_cover_main_photo').append('<div id="sesusercoverphoto_cover_loading_main" class="sescoverpphoto_overlay" style="display:block;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>');
	<?php } ?>
		var user_id = '<?php echo $this->subject->user_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'sesusercoverphoto/index/remove-main/user_id/'+user_id;
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add User Photo'));
				response = sesJqueryObject.parseJSON(response);
				sesJqueryObject('.sesusercoverphoto_cover_image_main').attr('src', response.src);
				sesJqueryObject('#sesusercoverphoto_cover_loading_main').remove();
				sesJqueryObject('#sesusercoverphoto_main_photo_i').hide();
				//silence
			 }
			}); 
});

function uploadFileMainCoverPhoto(input){	
	 var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
				uploadFileToServerMain(input.files[0]);
    }else{
				//Silence
		}

}

sesJqueryObject(document).on('click','#change_main_cvr_pht',function(){
	document.getElementById('uploadFileMainCoverPhoto').click();	
});


<!-- Upload Cover Photo Code -->
sesJqueryObject('<div class="sesusercoverphoto_photo_update_popup sesbasic_bxs" id="coverphoto_popup_cam_upload" style="display:none"><div class="sesusercoverphoto_photo_update_popup_overlay"></div><div class="sesusercoverphoto_photo_update_popup_container sesusercoverphoto_photo_update_webcam_container"><div class="sesusercoverphoto_photo_update_popup_header sesbm"><?php echo $this->translate("Click to Take Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercoverphoto_photo_update_popup_webcam_options"><div id="coverphoto_camera" style="background-color:#ccc;"></div><div class="centerT sesusercoverphoto_photo_update_popup_btns">   <button onclick="take_coverphotosnapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Photo") ?></button><button onclick="hideCoverPhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesusercoverphoto_photo_update_popup sesbasic_bxs" id="coverphoto_popup_existing_upload" style="display:none"><div class="sesusercoverphoto_photo_update_popup_overlay"></div><div class="sesusercoverphoto_photo_update_popup_container" id="coverphoto_popup_container_existing"><div class="sesusercoverphoto_photo_update_popup_header sesbm"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercoverphoto_photo_update_popup_content"><div id="coverphoto_existing_data"></div><div id="coverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
sesJqueryObject(document).on('click','#uploadCoverPhoto',function(){
		document.getElementById('uploadFilesesUserCoverPhoto').click();
});
function readCoverPhotoImageUrl(input){
	var url = input.files[0].name;
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
		var formData = new FormData();
		formData.append('webcam', input.files[0]);
		formData.append('user_id', '<?php echo $this->subject->user_id; ?>');
		sesJqueryObject('#sesusercoverphoto_cover_photo_loading').show();
 sesJqueryObject.ajax({
		xhr:  function() {
		var xhrobj = sesJqueryObject.ajaxSettings.xhr();
		if (xhrobj.upload) {
				xhrobj.upload.addEventListener('progress', function(event) {
						var percent = 0;
						var position = event.loaded || event.position;
						var total = event.total;
						if (event.lengthComputable) {
								percent = Math.ceil(position / total * 100);
						}
						//Set progress
				}, false);
		}
		return xhrobj;
		},
    url:  en4.core.staticBaseUrl+'sesusercoverphoto/index/edit-coverphoto/',
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			text = JSON.parse(response);
			if(text.status == 'true'){
        if(text.src != ''){
          if(sesJqueryObject('#sesusercoverphoto_cover_video_id').length)
            sesJqueryObject('#sesusercoverphoto_cover_video_id').hide();
          sesJqueryObject('#sesusercoverphoto_cover_id').show();
          sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',  text.src );
        }
				sesJqueryObject('#sesusercoverphoto_cover_default').hide();
				sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
				sesJqueryObject('#removeCover').css('display','block');
				sesJqueryObject('#sesusercoverphoto_main_photo_reposition').css('display','block');
			}
			sesJqueryObject('#sesusercoverphoto_cover_photo_loading').hide();
				sesJqueryObject('#uploadFilesesUserCoverPhoto').val('');
		}
    });
	}
}
sesJqueryObject(document).on('click','#uploadCoverPhotoWebCamPhoto',function(){
	sesJqueryObject('#coverphoto_popup_cam_upload').show();
	<!-- Configure a few settings and attach camera -->
	Webcam.set({
		width: 320,
		height: 240,
		image_format:'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach('#coverphoto_camera');
});
<!-- Code to handle taking the snapshot and displaying it locally -->
function take_coverphotosnapshot() {
	// take snapshot and get image data
	Webcam.snap(function(data_uri) {
		Webcam.reset();
		sesJqueryObject('#coverphoto_popup_cam_upload').hide();
		sesJqueryObject('#sesusercoverphoto_cover_photo_loading').show();
		// upload results
		 Webcam.upload( data_uri, en4.core.staticBaseUrl+'sesusercoverphoto/index/edit-coverphoto/user_id/<?php echo $this->subject->user_id; ?>' , function(code, text) {
			 	text = JSON.parse(text);
				if(text.status == 'true'){
				
        if(text.src != ''){
          if(sesJqueryObject('#sesusercoverphoto_cover_video_id').length)
            sesJqueryObject('#sesusercoverphoto_cover_video_id').hide();
          sesJqueryObject('#sesusercoverphoto_cover_id').show();
          sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',  text.src );
        
						sesJqueryObject('#sesusercoverphoto_cover_default').hide();
						sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
						sesJqueryObject('#removeCover').css('display','block');
						sesJqueryObject('#sesusercoverphoto_main_photo_reposition').css('display','block');
					}
				}
				sesJqueryObject('#sesusercoverphoto_cover_photo_loading').hide();
			} );
	});
}
function removeCoverPhoto(){
		sesJqueryObject('#removeCover').css('display','none');
		//sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',  '' );
		sesJqueryObject('#sesusercoverphoto_cover_photo_loading').show();
		//sesJqueryObject('#sesusercoverphoto_cover_default').show();
		var user_id = '<?php echo $this->subject->user_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'sesusercoverphoto/index/remove-cover/user_id/'+user_id;
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				
				var response = sesJqueryObject.parseJSON(response);
				sesJqueryObject('#sesusercoverphoto_cover_photo_loading').hide();
				sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
				sesJqueryObject('#sesusercoverphoto_main_photo_reposition').css('display','none');
				sesJqueryObject('#sesusercoverphoto_cover_id').css('top','0');
				//update defaultphoto if available from admin.
				if(response.src) {
					sesJqueryObject('#sesusercovevideo_cover_video_id').hide();
          sesJqueryObject('#sesusercoverphoto_cover_id').show();
          sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',response.src);
        }
			 }
			}); 
};
function hideCoverPhotoUpload(){
	if(typeof Webcam != 'undefined')
	 Webcam.reset();
	canPaginatePageNumber = 1;
	sesJqueryObject('#coverphoto_popup_cam_upload').hide();
	sesJqueryObject('#coverphoto_popup_existing_upload').hide();
	if(typeof Webcam != 'undefined'){
		sesJqueryObject('.slimScrollDiv').remove();
		sesJqueryObject('.sesusercoverphoto_photo_update_popup_content').html('<div id="coverphoto_existing_data"></div><div id="coverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
	}
}
sesJqueryObject(document).click(function(event){
	if(event.target.id == 'change_coverphoto_profile_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
		sesJqueryObject('#sesusercoverphoto_cover_option_main_id').removeClass('active')
		if(sesJqueryObject('#sesusercoverphoto_cover_change').hasClass('active'))
			sesJqueryObject('#sesusercoverphoto_cover_change').removeClass('active');
		else
			sesJqueryObject('#sesusercoverphoto_cover_change').addClass('active');
	}else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){console.log('tyes');
		sesJqueryObject('#sesusercoverphoto_cover_change').removeClass('active');		
		if(sesJqueryObject('#sesusercoverphoto_cover_option_main_id').hasClass('active'))
			sesJqueryObject('#sesusercoverphoto_cover_option_main_id').removeClass('active');
		else
			sesJqueryObject('#sesusercoverphoto_cover_option_main_id').addClass('active');
			
	}else{
			sesJqueryObject('#sesusercoverphoto_cover_change').removeClass('active')
			sesJqueryObject('#sesusercoverphoto_cover_option_main_id').removeClass('active')
	}
});


sesJqueryObject(document).on('click','#fromCoverPhotoExistingAlbum',function(){
	sesJqueryObject('#coverphoto_popup_existing_upload').show();
	existingCoverPhotosGet();
});
var canPaginatePageNumber = 1;
function existingCoverPhotosGet(){
	sesJqueryObject('#coverphoto_profile_existing_img').show();
	var URL = en4.core.staticBaseUrl+'sesusercoverphoto/index/existing-photos/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        cover: 'cover',
        page: canPaginatePageNumber,
        is_ajax: 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('coverphoto_existing_data').innerHTML = document.getElementById('coverphoto_existing_data').innerHTML + responseHTML;
      	sesJqueryObject('#coverphoto_existing_data').slimscroll({
					 height: 'auto',
					 alwaysVisible :true,
					 color :'#000',
					 railOpacity :'0.5',
					 disableFadeOut :true,					 
					});
					sesJqueryObject('#coverphoto_existing_data').slimScroll().bind('slimscroll', function(event, pos){
					 if(canPaginateExistingPhotos == '1' && pos == 'bottom' && sesJqueryObject('#coverphoto_profile_existing_img').css('display') != 'block'){
						 	sesJqueryObject('#coverphoto_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
							existingCoverPhotosGet();
					 }
					});
					sesJqueryObject('#coverphoto_profile_existing_img').hide();
		}
    })).send();	
}

sesJqueryObject(document).on('click','a[id^="sesusercoverphoto_cover_existing_album_see_more_"]',function(event){
	event.preventDefault();
	var thatObject = this;
	sesJqueryObject(thatObject).parent().hide();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	var pageNum = parseInt(sesJqueryObject(this).attr('data-src'),10);
	sesJqueryObject('#sesusercoverphoto_existing_album_see_more_loading_'+id).show();
	if(pageNum == 0){
		sesJqueryObject('#sesusercoverphoto_existing_album_see_more_page_'+id).remove();
		return;
	}
	var URL = en4.core.staticBaseUrl+'sesusercoverphoto/index/existing-albumphotos/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        page: pageNum+1,
        id: id,
        cover: 'cover',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('sesusercoverphoto_photo_content_'+id).innerHTML = document.getElementById('sesusercoverphoto_photo_content_'+id).innerHTML + responseHTML;
				var dataSrc = sesJqueryObject('#sesusercoverphoto_existing_album_see_more_page_'+id).html();
      	sesJqueryObject('#sesusercoverphoto_existing_album_see_more_'+id).attr('data-src',dataSrc);
				sesJqueryObject('#sesusercoverphoto_existing_album_see_more_page_'+id).remove();
				if(dataSrc == 0)
					sesJqueryObject('#sesusercoverphoto_existing_album_see_more_'+id).parent().remove();
				else
					sesJqueryObject(thatObject).parent().show();
				sesJqueryObject('#sesusercoverphoto_existing_album_see_more_loading_'+id).hide();
		}
    })).send();	
});

sesJqueryObject(document).on('click','a[id^="sesusercoverphoto_cover_upload_existing_photos_"]',function(event){
	event.preventDefault();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	if(!id)
		return;
  sesJqueryObject('#sesusercoverphoto_cover_photo_loading').show();
	hideCoverPhotoUpload();
	var URL = en4.core.staticBaseUrl+'sesusercoverphoto/index/uploadexistingcoverphoto/';
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
      if(text.status == 'true'){
            
        if(text.src != ''){
          if(sesJqueryObject('#sesusercoverphoto_cover_video_id').length)
            sesJqueryObject('#sesusercoverphoto_cover_video_id').hide();
          sesJqueryObject('#sesusercoverphoto_cover_id').show();
          sesJqueryObject('#sesusercoverphoto_cover_id').attr('src',  text.src );
        }
          sesJqueryObject('#sesusercoverphoto_cover_default').hide();
          sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
          sesJqueryObject('#removeCover').css('display','block');
          sesJqueryObject('#sesusercoverphoto_main_photo_reposition').css('display','block');
      }
      sesJqueryObject('#sesusercoverphoto_cover_photo_loading').hide();
      sesJqueryObject('#uploadFilesesUserCoverPhoto').val('');
    }
  })).send();	
});
</script>
<?php } ?>
