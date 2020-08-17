<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $classroom = $this->classroom;?>
<?php $viewer = $this->viewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.share', 1);?>
<?php if($classroom->can_join && Engine_Api::_()->authorization()->getPermission($levelId, 'eclassroom', 'bs_can_join')):?>
  <?php $canJoin = 1;?>
<?php else:?>
  <?php $canJoin = 0;?>
<?php endif;?>
<?php $isClassroomEdit = Engine_Api::_()->eclassroom()->privacy($classroom, 'edit');?>
<?php $canUploadCover = Engine_Api::_()->authorization()->getPermission($levelId, 'eclassroom', 'upload_cover'); ?>

<?php if($isClassroomEdit):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
   <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');?>
<?php endif;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/style_cover.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/style_profile.css'); ?>
<?php $isClassroomDelete = Engine_Api::_()->eclassroom()->privacy($classroom, 'delete');?>
<?php $owner = $classroom->getOwner();?>
<?php if(is_numeric($this->params['cover_height'])):?>
  <?php $height = $this->params['cover_height'].'px';?>
<?php else:?>
  <?php $height = $this->params['cover_height'];?>
<?php endif;?>
<div id="eclassroom_cover_load" class="eclassroom_cover_empty prelative" style="height:<?php echo $height ?>;"><div class="sesbasic_loading_cont_overlay" style="display:block;"></div></div>
<div id="eclassroom_content" style="display:none">
<?php if($this->params['layout_type'] == 2):  ?>
  <?php // Cover Layout code ?>
  <div class="eclassroom_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>eclassroom_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="eclassroom_cover" style="height:<?php echo $height ?>;">
      <div class="eclassroom_cover_inner sesbasic_clearfix">
        <div class="eclassroom_default_cover" style="height:<?php echo $height ?>;">
          <img id="eclassroom_cover_id" src="<?php echo $classroom->getCoverPhotoUrl() ?>" style="top:<?php echo $classroom->cover_position ? $classroom->cover_position : '0px'; ?>;" />
        </div>
        <span class="eclassroom_cover_fade"></span>
        <?php if($isClassroomEdit && $canUploadCover): ?>
          <div class="eclassroom_cover_change_btn" id="eclassroom_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="eclassroom_cover_change_options sesbasic_option_box"> 
              <i class="classroomscover_option_box_arrow"></i>
               <input type="file" id="uploadFileclassroom" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangeclassroom" data-src="<?php echo $classroom->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemoveclassroom" style="display:<?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $classroom->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="eclassroom_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="eclassroom_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="eclassroom_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif; ?>
        <div class="eclassroom_cover_content eclassroom_cover_d2">
          <div class="eclassroom_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $classroom->featured):?>
              <span class="eclassroom_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $classroom->sponsored):?>
              <span class="eclassroom_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $classroom->hot):?>
              <span class="eclassroom_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
          <div class="_maincont sesbasic_clearfix">
            <div class="_cnw">
              <?php if(isset($this->photoActive)): ?>
                <div class="_mainphoto">
                  <div id="eclassroom_cover_mainphotoinner" class="eclassroom_cover_mainphotoinner">
                    <img id="eclassroom_photo_id" src="<?php echo $classroom->getPhotoUrl('thumb.profile') ?>" alt="" />
                  </div>
                  <?php if($isClassroomEdit):?>
                  <div class="eclassroom_cover_change_btn">
                    <a href="javascript:;" class="eclassroom_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                      <i class="fa fa-camera"></i>
                    </a>
                    <div class="eclassroom_cover_main_change_options sesbasic_option_box"> 
                      <i class="classroomscover_option_box_arrow"></i>
                      <input type="file" id="uploadPhotoFileclassroom" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                      <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                      <a id="photoChangeclassroom" data-src="<?php echo $classroom->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                      <?php echo (isset($classroom->photo_id) && $classroom->photo_id != 0 && $classroom->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                      <a id="photoRemoveclassroom" style="display:<?php echo (isset($classroom->photo_id) && $classroom->photo_id != 0 && $classroom->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $classroom->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                    </div>
                  </div>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_info">
                <?php if(isset($this->titleActive)):?><h1><?php echo $classroom->title;?><?php if(isset($this->verifiedLabelActive) && $this->classroom->verified):?><i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>  
                <p class="_data _stats">
                  <?php if(isset($this->byActive)):?>
                    <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                  <?php endif;?>
                  <?php if(isset($this->categoryActive)):?>
                    <?php $category = Engine_Api::_()->getItem('eclassroom_category',$this->classroom->category_id); ?>
                    <?php if($category):?>
                      <span><?php echo $this->translate('in ');?><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a></span></span>
                    <?php endif;?>
                  <?php endif;?>
                  <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl'; ?>
                </p>
              </div>  
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
  <div class="sescover_footer_des2_footer sesbasic_bxs<?php if(isset($this->photoActive)):?> ismainphoto<?php endif;?>">
    <div class="_footerinner _cnw sesbasic_clearfix">
      <div class="_leftbtns">
        <?php if($classroom->is_approved):?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($this->classroom->classroom_id,$this->classroom->getType()); ?>
            <?php $likeClass = (!$likeStatus) ? 'fa fa-thumbs-up' : 'fa fa-thumbs-down' ;?>
            <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
            <div class="_likebtn">
            <a href='javascript:;' data-type='like_classroom_button_view' data-url='<?php echo $this->classroom->classroom_id; ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_button sesbasic_animation eclassroom_likefavfollow eclassroom_like_view_<?php echo $this->classroom->classroom_id; ?> classroom_like_class_view"><i class='fa <?php echo $likeClass ; ?>'></i><span><?php echo $likeText; ?></span></a>  
            </div>
          <?php endif;?>
          <?php if($viewerId):?>
            <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.favourite', 1)):?>
              <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->isFavourite(array('resource_id' => $this->classroom->classroom_id,'resource_type' => $this->classroom->getType())); ?>
              <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
              <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
              <div class="_favbtn">
                <a href='javascript:;' data-type='favourite_classroom_button_view' data-url='<?php echo $this->classroom->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_button sesbasic_animation eclassroom_likefavfollow eclassroom_favourite_view_<?php echo $this->classroom->classroom_id ?> classroom_favourite_class_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span><?php echo $favouriteText; ?></span></a>
              </div>
            <?php endif;?>
            <?php if($viewerId != $this->classroom->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.follow', 1)):?>
              <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'eclassroom')->isFollow(array('resource_id' => $classroom->classroom_id,'resource_type' => $classroom->getType())); ?>
              <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
              <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
              <div class="_followbtn">
                <a href='javascript:;' data-type='follow_classroom_button_view' data-url='<?php echo $this->classroom->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_button sesbasic_animation eclassroom_likefavfollow eclassroom_follow_view_<?php echo $this->classroom->getIdentity(); ?> classroom_follow_class_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>    
              </div>
            <?php endif;?>
          <?php  endif;?>
        <?php endif;?>
        <?php if(isset($this->socialSharingActive) && $shareType):?>
          <div class="_sharebtn">
            <!-- <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation eclassroom_button_toggle"><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
            <div class="eclassroom_listing_share_popup"> -->
             <!-- <p><?php echo $this->translate("Share This Classroom");?></p> -->
              <?php if($shareType == 2):?>
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $classroom, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $classroom->getType(),'id' => $classroom->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="smoothbox sesbasic_button sesbasic_animation" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
             <!-- </div> -->
          </div>
        <?php endif;?>
        <?php if(isset($this->optionMenuActive)):?>
          <div class="_optionbtn"><a href="javascript:void(0);" class="sesbasic_button eclassroom_cbtn" id="eclassroom_cover_option_btn"><i class="fa fa-cog"></i></a></div>
        <?php endif;?>
      </div>
      <div class="_rightbtns">
        <div class="_joinbtn">
          <?php if($canJoin && isset($this->joinButtonActive)):?>
            <div class="_listbuttons_join">
              <?php if($viewerId):?>
                <?php $classroom = Engine_Api::_()->getItem('classroom',$classroom->classroom_id);?>
                <?php  $row = $classroom->membership()->getRow($viewer);?>
                <?php if(null === $row):?>
                  <?php if($classroom->membership()->isResourceApprovalRequired()):?>
                    <?php $action = 'request';?>
                  <?php else:?>
                    <?php $action = 'join';?>
                  <?php endif;?>
                  <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'classroom_id' => $classroom->classroom_id),'eclassroom_extended',true);?>" class="smoothbox sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                <?php else:?>
                  <?php if($row->active):?>
                    <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                  <?php else:?>
                    <a href="javascript:void(0);" id="eclassroom_user_approval" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" id="eclassroom_user_approval" class="smoothbox eclassroom_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
              <?php endif;?>
            </div>
          <?php endif;?>
        </div>
        <?php if(isset($this->messageOwnerActive) && $viewerId != $this->classroom->owner_id):?>
          <div class="_mgsowner">
            <a href="<?php echo $this->url(array('owner_id' => $this->classroom->owner_id,'action'=>'contact'), 'eclassroom_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
          </div>
        <?php endif;?>
        <?php if(isset($this->addButtonActive)):?>
          <div class="_contactbtn">
            <?php echo $this->content()->renderWidget("eclassroom.profile-action-button",array('identity'=>12312312))?>
          </div>
        <?php endif;?>
      </div>
    </div>  
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="eclassroom_cover_options_wrap" style="display:none;">
      <div class="eclassroom_cover_options eclassroom_options_dropdown" id="eclassroom_cover_options">
        <span class="eclassroom_options_dropdown_arrow"></span>
        <div class="eclassroom_options_dropdown_links">
          <?php echo $this->content()->renderWidget('eclassroom.profile-options',array('dashboard'=>true));  ?> 
        </div>
      </div>
    </div>  
  <?php endif; ?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){ 
      var topPositionOfParentSpan =  sesJqueryObject("#eclassroom_cover_option_btn").offset().top + 34;
      topPositionOfParentSpan = topPositionOfParentSpan+'px';
      var leftPositionOfParentSpan =  sesJqueryObject("#eclassroom_cover_option_btn").offset().left - 142;
      leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
      sesJqueryObject('.eclassroom_cover_options').css('top',topPositionOfParentSpan);
      sesJqueryObject('.eclassroom_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEventListener("scroll", function(event) {
      doResizeForButton();
    });
    window.addEvent('load',function(){
      doResizeForButton();
    });
    sesJqueryObject(document).ready(function(){
      sesJqueryObject("<div>"+sesJqueryObject("#eclassroom_cover_options_wrap").html()+'</div>').appendTo('body');
      sesJqueryObject('#eclassroom_cover_options_wrap').remove();
      doResizeForButton();
    });
    sesJqueryObject(window).resize(function(){
      doResizeForButton();
    });
    sesJqueryObject(document).click(function(){
      sesJqueryObject('#eclassroom_cover_options').removeClass('show-options');
    })
    sesJqueryObject(document).on('click','#eclassroom_cover_option_btn', function(e){
      e.preventDefault();
      if(sesJqueryObject('#eclassroom_cover_options').hasClass('show-options'))
        sesJqueryObject('#eclassroom_cover_options').removeClass('show-options');
      else
        sesJqueryObject('#eclassroom_cover_options').addClass('show-options');
      return false;
    });
  <?php endif;?>
</script>
<?php else: ?>
  <?php // Cover Layout code ?>
  <div class="eclassroom_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>eclassroom_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="eclassroom_cover" style="height:<?php echo $height ?>;">
      <div class="eclassroom_cover_inner sesbasic_clearfix">
        <div class="eclassroom_default_cover" style="height:<?php echo $height ?>;">
          <img id="eclassroom_cover_id" src="<?php echo $classroom->getCoverPhotoUrl(); ?>" style="top:<?php echo $classroom->cover_position ? $classroom->cover_position : '0px'; ?>;" />
        </div>
        <span class="eclassroom_cover_fade"></span>
        <?php if($isClassroomEdit && $canUploadCover):?>
          <div class="eclassroom_cover_change_btn" id="eclassroom_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="eclassroom_cover_change_options sesbasic_option_box"> 
              <i class="classroomscover_option_box_arrow"></i>
               <input type="file" id="uploadFileclassroom" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangeclassroom" data-src="<?php echo $classroom->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemoveclassroom" style="display:<?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $classroom->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($classroom->cover) && $classroom->cover != 0 && $classroom->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="eclassroom_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="eclassroom_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="eclassroom_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="eclassroom_cover_content eclassroom_cover_d1">
          <div class="eclassroom_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $classroom->featured):?>
              <span class="eclassroom_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $classroom->sponsored):?>
              <span class="eclassroom_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $classroom->hot):?>
              <span class="eclassroom_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
          <div class="_cnw">    
            <div class="_maincont sesbasic_clearfix">
              <?php if(isset($this->photoActive)):?>
                <div class="_mainphoto">
                  <div id="eclassroom_cover_mainphotoinner" class="eclassroom_cover_mainphotoinner">
                  <img id="eclassroom_photo_id" src="<?php echo $classroom->getPhotoUrl('thumb.profile') ?>" alt="">
                </div>
                  <?php if($isClassroomEdit):?>
                    <div class="eclassroom_cover_change_btn">
                        <a href="javascript:;" class="eclassroom_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                          <i class="fa fa-camera"></i>
                        </a>
                        <div class="eclassroom_cover_main_change_options sesbasic_option_box">
                          <i class="classroomscover_option_box_arrow"></i>
                          <input type="file" id="uploadPhotoFileclassroom" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                          <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                          <a id="photoChangeclassroom" data-src="<?php echo $classroom->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                          <?php echo (isset($classroom->photo_id) && $classroom->photo_id != 0 && $classroom->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                          <a id="photoRemoveclassroom" style="display:<?php echo (isset($classroom->photo_id) && $classroom->photo_id != 0 && $classroom->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $classroom->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                        </div>
                      </div>
                    <?php endif;?>
                  </div>
                <?php endif;?>
               <?php if(isset($this->titleActive)):?><h1><?php echo $classroom->title;?><?php if(isset($this->verifiedLabelActive) && $this->classroom->verified):?><i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>
              <p class="_data _stats">
                <?php if(isset($this->byActive)):?>
                  <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                <?php endif;?>
                <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl';?>
              </p>
        <div class="_midbtns">
                <div class="_joinbtn">
                  <?php if($canJoin && isset($this->joinButtonActive)):?>
                    <div class="_listbuttons_join">
                      <?php if($viewerId):?>
                        <?php $row = $classroom->membership()->getRow($this->viewer());?>
                        <?php if(null === $row):?>
                          <?php if($classroom->membership()->isResourceApprovalRequired()):?>
                            <?php $action = 'request';?>
                          <?php else:?>
                            <?php $action = 'join';?>
                          <?php endif;?>
                          <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'classroom_id' => $classroom->classroom_id),'eclassroom_extended',true);?>" class="smoothbox eclassroom_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                        <?php else:?>
                          <?php if($row->active):?>
                            <a href="javascript:void(0);" class="eclassroom_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                          <?php else:?>
                            <a href="javascript:void(0);" id="eclassroom_user_approval" class="eclassroom_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                          <?php endif;?>
                        <?php endif;?>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" id="eclassroom_user_approval" class="smoothbox eclassroom_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
                <?php if(isset($this->messageOwnerActive) && $viewerId != $this->classroom->owner_id):?>
                  <div class="_mgsowner">
                    <a href="<?php echo $this->url(array('owner_id' => $this->classroom->owner_id,'action'=>'contact'), 'eclassroom_general', true); ?>" class="sessmoothbox eclassroom_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
                  </div>
                <?php endif;?>
                <?php if(isset($this->addButtonActive)):?>
                  <div class="_contactbtn">
                    <?php echo $this->content()->renderWidget("classroom.profile-action-button",array('identity'=>12312312))?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="_footer sesbasic_clearfix">
              <div class="_footerinner _cnw sesbasic_clearfix">
                <div class="eclassroom_cover_social_btns">
                <?php if(isset($this->socialSharingActive) && $shareType == 2):?>
                  <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $classroom, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
                <?php endif;?>  
                <?php if($classroom->is_approved):?>
                  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('eclassroom', $this->viewer(), 'create');?>
                  <?php if(isset($this->likeButtonActive) && $canComment):?>
                    <?php $likeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($classroom->classroom_id,$classroom->getType()); ?>
                    <a href="javascript:;" data-type="eclassroom_like_view" data-url="<?php echo $classroom->classroom_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eclassroom_like_<?php echo $classroom->classroom_id ?> eclassroom_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $classroom->like_count;?></span></a>
                  <?php endif;?>
                  <?php if($viewerId):?>
                    <?php  if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.favourite', 1)):?>
                      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->isFavourite(array('resource_id' => $classroom->classroom_id,'resource_type' => $classroom->getType())); ?>
                      <a href="javascript:;" data-type="eclassroom_favourite_view" data-url="<?php echo $classroom->classroom_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eclassroom_favourite_<?php echo $classroom->classroom_id ?> eclassroom_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $classroom->favourite_count;?></span></a>
                    <?php  endif;?>
                    <?php if($viewerId != $classroom->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.follow', 1)):?>
                      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'eclassroom')->isFollow(array('resource_id' => $classroom->classroom_id,'resource_type' => $classroom->getType())); ?>
                      <a href="javascript:;" data-type="eclassroom_follow_view" data-url="<?php echo $classroom->classroom_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn classroom_follow_<?php echo $classroom->classroom_id ?> eclassroom_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $classroom->follow_count;?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
                  <?php if(isset($this->optionMenuActive)):?>
                    <a href="javascript:void(0);" class="sesbasic_icon_btn" id="eclassroom_cover_option_btn"><i class="fa fa-cog"></i></a>
                  <?php endif;?>
                </div>
                <?php if($this->params['tab_placement'] == 'in'):?>
                  <div class="eclassroom_cover_tabs _tabs"></div>
                <?php endif;?>
              </div>  
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="eclassroom_cover_options_wrap" style="display:none;">
      <div class="eclassroom_cover_options eclassroom_options_dropdown" id="eclassroom_cover_options">
        <span class="eclassroom_options_dropdown_arrow"></span>
        <div class="eclassroom_options_dropdown_links">
          <?php echo $this->content()->renderWidget('eclassroom.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){
        var topPositionOfParentSpan =  sesJqueryObject("#eclassroom_cover_option_btn").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#eclassroom_cover_option_btn").offset().left - 142;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.eclassroom_cover_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.eclassroom_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEvent('load',function(){
      doResizeForButton();
    });
    sesJqueryObject(document).ready(function(){
      sesJqueryObject("<div>"+sesJqueryObject("#eclassroom_cover_options_wrap").html()+'</div>').appendTo('body');
      sesJqueryObject('#eclassroom_cover_options_wrap').remove();
      doResizeForButton();
    });
    sesJqueryObject(window).resize(function(){
      doResizeForButton();
    });
    sesJqueryObject(document).click(function(){
      sesJqueryObject('#eclassroom_cover_options').removeClass('show-options');
    })
    sesJqueryObject(document).on('click','#eclassroom_cover_option_btn', function(e){
      e.preventDefault();
      if(sesJqueryObject('#eclassroom_cover_options').hasClass('show-options'))
        sesJqueryObject('#eclassroom_cover_options').removeClass('show-options');
      else
        sesJqueryObject('#eclassroom_cover_options').addClass('show-options');
      return false;
    });
  <?php endif;?>
  <?php if($this->params['tab_placement'] == 'in'):?>
    if (matchMedia('only screen and (min-width: 767px)').matches) {
        sesJqueryObject(document).ready(function(){
        if((sesJqueryObject('.layout_core_container_tabs').length > 0) && (typeof sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0) != "undefined")){
          var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
          sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
          sesJqueryObject('.eclassroom_cover_tabs').html(tabs);
        }
      });
      sesJqueryObject(document).on('click','ul#main_tabs li > a',function(){
          if(sesJqueryObject(this).parent().hasClass('more_tab'))
              return;
          var index = sesJqueryObject(this).parent().index() + 1;
          var divLength = sesJqueryObject('.layout_core_container_tabs > div');
          for(i=0;i<divLength.length;i++){
              sesJqueryObject(divLength[i]).hide();
          }
          sesJqueryObject('.layout_core_container_tabs').children().eq(index).show();
      });
      sesJqueryObject(document).on('click','.tab_pulldown_contents ul li',function(){
       var totalLi = sesJqueryObject('ul#main_tabs > li').length;
       var index = sesJqueryObject(this).index();
       var divLength = sesJqueryObject('.layout_core_container_tabs > div');
          for(i=0;i<divLength.length;i++){
              sesJqueryObject(divLength[i]).hide();
          }
       sesJqueryObject('.layout_core_container_tabs').children().eq(index+totalLi).show();
      });
    }
  <?php endif;?>
</script>
<?php endif;?>
<script type="text/javascript">
  sesJqueryObject(document).on('click','.eclassroom_cover_mainphoto_toggle',function(){
    if(sesJqueryObject(this).hasClass('open')){
      sesJqueryObject(this).removeClass('open');
    }else{
      sesJqueryObject('.eclassroom_cover_mainphoto_toggle').removeClass('open');
      sesJqueryObject(this).addClass('open');
    }
      return false;
  });
  sesJqueryObject(document).click(function(){
    sesJqueryObject('.eclassroom_cover_mainphoto_toggle').removeClass('open');
  });

  sesJqueryObject(document).click(function(event){
  if(event.target.id != 'eclassroom_dropdown_btn' && event.target.id != 'a_btn' && event.target.id != 'i_btn'){
    sesJqueryObject('#eclassroom_dropdown_btn').find('.eclassroom_option_box1').css('display','none');
    sesJqueryObject('#a_btn').removeClass('active');
  }
  if(event.target.id == 'change_cover_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
      if(sesJqueryObject('#eclassroom_change_cover_op').hasClass('active'))
          sesJqueryObject('#eclassroom_change_cover_op').removeClass('active')
      else
          sesJqueryObject('#eclassroom_change_cover_op').addClass('active');

      sesJqueryObject('#eclassroom_cover_option_main_id').removeClass('active');

  }else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){
    if(sesJqueryObject('#eclassroom_cover_option_main_id').hasClass('active'))
      sesJqueryObject('#eclassroom_cover_option_main_id').removeClass('active')
    else
      sesJqueryObject('#eclassroom_cover_option_main_id').addClass('active');
      sesJqueryObject('#eclassroom_change_cover_op').removeClass('active');
  }else{
    sesJqueryObject('#eclassroom_change_cover_op').removeClass('active');
    sesJqueryObject('#eclassroom_cover_option_main_id').removeClass('active')
  }
  if(event.target.id == 'a_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.eclassroom_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.eclassroom_option_box1').css('display','block');
    }
  }else if(event.target.id == 'i_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.eclassroom_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.eclassroom_option_box1').css('display','block');
    }
  } 
});
  sesJqueryObject(document).on('click','#coverChangeclassroom',function(){
    document.getElementById('uploadFileclassroom').click();  
  });
  sesJqueryObject(document).on('click','#photoChangeclassroom',function(){
    document.getElementById('uploadPhotoFileclassroom').click(); 
  });
  function uploadCoverArt(input,type){
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
      uploadFileToServer(input.files[0],type);
    }
  }
  function uploadFileToServer(files,type){
    if(type == 'photo') {
      sesJqueryObject('.eclassroom_cover_mainphotoinner').append('<div class="sesbasic_loading_cont_overlay eclassroom_cover_loading" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'eclassroom/profile/upload-photo/id/<?php echo $classroom->classroom_id ?>';
    }
    else {
      sesJqueryObject('.eclassroom_cover_inner').append('<div class="sesbasic_loading_cont_overlay eclassroom_cover_loading" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'eclassroom/profile/upload-cover/id/<?php echo $classroom->classroom_id ?>';
    }
    var formData = new FormData();
    formData.append('Filedata', files);
    
    var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
        cache: false,
        data: formData,
        success: function(response){
          response = sesJqueryObject.parseJSON(response);
          if(type == 'photo') {
            uploadmainPhoto(response);
            if(typeof uploadPhoto == "function"){
               uploadPhoto(response);
            }
          }
          else {
            sesJqueryObject('#uploadFileclassroom').val('');
            sesJqueryObject('.eclassroom_cover_loading').remove();
            sesJqueryObject('#eclassroom_cover_id').attr('src', response.file);
            sesJqueryObject('#coverChangeclassroom').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
            sesJqueryObject('#eclassroom_cover_photo_reposition').css('display','block');
            sesJqueryObject('#coverRemoveclassroom').css('display','block');
          }
        }
    }); 
  }
  function uploadmainPhoto(response){
      sesJqueryObject('#uploadPhotoFileclassroom').val('');
      console.log(sesJqueryObject('.eclassroom_cover_loading'));
      sesJqueryObject('.eclassroom_cover_loading').remove();
      sesJqueryObject('#eclassroom_photo_id').attr('src', response.file);
      sesJqueryObject('#photoChangeclassroom').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));
      sesJqueryObject('#photoRemoveclassroom').css('display','block');  
  }
  sesJqueryObject('#coverRemoveclassroom').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.eclassroom_cover_inner').append('<div class="sesbasic_loading_cont_overlay eclassroom_cover_loading" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'eclassroom/profile/remove-cover/id/<?php echo $classroom->classroom_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          sesJqueryObject('#coverChangeclassroom').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#eclassroom_cover_id').attr('src', response.file);
          sesJqueryObject('#eclassroom_cover_photo_reposition').css('display','none');
          sesJqueryObject('.eclassroom_cover_loading').remove();
          //silence
       }
      }); 
    });
    sesJqueryObject('#photoRemoveclassroom').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.eclassroom_cover_mainphotoinner').append('<div class="sesbasic_loading_cont_overlay eclassroom_cover_loading" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'eclassroom/profile/remove-photo/id/<?php echo $classroom->classroom_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          uploadmainRemovePhoto(response);
          if(typeof uploadremovemain == "function"){
            uploadremovemain(response);
          }
          //silence
       }
      }); 
    });
    function uploadmainRemovePhoto(response){
        sesJqueryObject('#photoChangeclassroom').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Upload Photo'));
        response = sesJqueryObject.parseJSON(response);
        sesJqueryObject('#eclassroom_photo_id').attr('src', response.file);
        sesJqueryObject('.eclassroom_cover_loading').remove();
        sesJqueryObject('#photoRemoveclassroom').css('display','none'); 
    }
    if(sesJqueryObject('.eclassroom_photo_update_popup').length == 0){
    sesJqueryObject('<div class="eclassroom_photo_update_popup sesbasic_bxs" id="eclassroom_popup_cam_upload" style="display:none"><div class="eclassroom_photo_update_popup_overlay"></div><div class="eclassroom_photo_update_popup_container eclassroom_photo_update_webcam_container eclassroom_fg_color"><div class="eclassroom_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="eclassroom_photo_update_popup_webcam_options"><div id="eclassroom_camera" style="background-color:#ccc;"></div><div class="centerT eclassroom_photo_update_popup_btns"><button class="capturePhoto" onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="eclassroom_photo_update_popup sesbasic_bxs" id="eclassroom_popup_existing_upload" style="display:none"><div class="eclassroom_photo_update_popup_overlay"></div><div class="eclassroom_photo_update_popup_container" id="eclassroom_popup_container_existing"><div class="eclassroom_select_photo_popup_header eclassroom_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="eclassroom_photo_update_popup_content"><div id="eclassroom_existing_data"></div><div id="eclassroom_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    }
  var contentTypeCourses;
  sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
    sesJqueryObject('#eclassroom_popup_cam_upload').show();
    contentTypeCourses = sesJqueryObject(this).closest('.eclassroom_cover_main_change_options').length > 0 ? 'photo' : 'cover';
    <!-- Configure a few settings and attach camera -->
    if(contentTypeCourses == 'photo') {
      sesJqueryObject('.eclassroom_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Photo") ?>');
      sesJqueryObject('.eclassroom_select_photo_popup_header').html('<?php echo $this->translate("Select a photo") ?>');
    }
    else {
      sesJqueryObject('.eclassroom_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Cover Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Cover Photo") ?>');
      sesJqueryObject('.eclassroom_select_photo_popup_header').html('<?php echo $this->translate("Select a Cover photo") ?>');
    }
    Webcam.set({
        width: 320,
        height: 240,
        image_format:'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#eclassroom_camera');
  });
  function hideProfilePhotoUpload(){
    if(typeof Webcam != 'undefined')
     Webcam.reset();
    canPaginateClassroomNumber = 1;
    sesJqueryObject('#eclassroom_popup_cam_upload').hide();
    sesJqueryObject('#eclassroom_popup_existing_upload').hide();
    if(typeof Webcam != 'undefined'){
        sesJqueryObject('.slimScrollDiv').remove();
        sesJqueryObject('.eclassroom_photo_update_popup_content').html('<div id="eclassroom_existing_data"></div><div id="eclassroom_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#eclassroom_popup_cam_upload').hide();
      // upload results
      sesJqueryObject('.eclassroom_cover_inner').append('<div id="eclassroom_cover_loading" class="sesbasic_loading_cont_overlay eclassroom_cover_loading"></div>');
       Webcam.upload( data_uri, en4.core.staticBaseUrl+'eclassroom/profile/upload-'+contentTypeCourses+'/id/<?php echo $classroom->classroom_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('.eclassroom_cover_loading').remove();
              sesJqueryObject('#eclassroom_'+contentTypeCourses+'_id').attr('src', response.file);
              sesJqueryObject('#'+contentTypeCourses+'Changeclassroom').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change '+contentTypeCourses == "cover"?"Cover":""+' Photo'));
              sesJqueryObject('#eclassroom_'+contentTypeCourses+'_photo_reposition').css('display','block');
              sesJqueryObject('#'+contentTypeCourses+'Removeclassroom').css('display','block');
              
              sesJqueryObject('#eclassroom_'+contentTypeCourses+'_id_main').attr('src', response.file);
              sesJqueryObject('#photoChangeeclassroom_<?php echo $classroom->classroom_id; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));              sesJqueryObject('#photoRemoveeclassroom_<?php echo $classroom->classroom_id; ?>').css('display','block');
              
          } );
    });
  }
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('eclassroom_cover_full');
    });
  <?php } ?>
  <?php if($isClassroomEdit && $canUploadCover):?>
  var previousPositionOfCover = sesJqueryObject('#eclassroom_cover_id').css('top');
  <!-- Reposition Photo -->
  sesJqueryObject('#eclassroom_cover_photo_reposition').click(function(){
          sesJqueryObject('.eclassroom_cover_reposition_btn').show();
          sesJqueryObject('.eclassroom_cover_fade').hide();
          sesJqueryObject('#eclassroom_change_cover_op').hide();
          sesJqueryObject('.eclassroom_cover_content').hide();
          sesJqueryUIMin('#eclassroom_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
  });
  sesJqueryObject('#cancelreposition').click(function(){
      sesJqueryObject('.eclassroom_cover_reposition_btn').hide();
      sesJqueryObject('#eclassroom_cover_id').css('top',previousPositionOfCover);
      sesJqueryObject('.eclassroom_cover_fade').show();
      sesJqueryObject('#eclassroom_change_cover_op').show();
      sesJqueryObject('.eclassroom_cover_content').show();
      sesJqueryUIMin("#eclassroom_cover_id").dragncrop('destroy');
  });
  sesJqueryObject('#savereposition').click(function(){
      var sendposition = sesJqueryObject('#eclassroom_cover_id').css('top');
      sesJqueryObject('#eclassroom_cover_photo_loading').show();
      var uploadURL = en4.core.staticBaseUrl+'eclassroom/profile/reposition-cover/id/<?php echo $classroom->classroom_id; ?>';
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
                      sesJqueryObject('.eclassroom_cover_reposition_btn').hide();
                      sesJqueryUIMin("#eclassroom_cover_id").dragncrop('destroy');
                      sesJqueryObject('.eclassroom_cover_fade').show();
                      sesJqueryObject('#eclassroom_change_cover_op').show();
                      sesJqueryObject('.eclassroom_cover_content').show();
                  }else{
                      alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>'); 
                  }
                      sesJqueryObject('#eclassroom_cover_photo_loading').hide();
                  //silence
               }
              });


  });
<?php endif;?>
sesJqueryObject(document).ready(function(e){
  sesJqueryObject('#main_tabs').children().eq(0).find('a').trigger('click');
});
</script>
</div>
 
<div id="locked_content" style="display:none" class="sesbasic_locked_msg sesbasic_clearfix sesbasic_bxs">
  <div class="sesbasic_locked_msg_img"><i class="fa fa-lock"></i></div>
    <div class="sesbasic_locked_msg_cont">
    <h1><?php echo $this->translate('Locked Classroom'); ?></h1>
    <p>
      <?php echo $this->translate('Seems you enter wrong password'); ?>
      <a href="javascript:;" onClick="window.location.reload();"><?php echo $this->translate('click here'); ?></a>
      <?php echo $this->translate('to enter password again.'); ?>
    </p>
  </div>
</div>

<?php if($this->locked){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customAlert/sweetalert.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customAlert/sweetalert.js'); ?>
  <script type="application/javascript">
    function promptPasswordCheck(){
    sesJqueryObject('#eclassroom_content').hide();
    sesJqueryObject('#locked_content').show();
    swal({   
      title: "",   
      text: "<?php echo $this->translate('Enter Password For:'); ?> <?php echo $this->classroom->getTitle(); ?>",  
      type: "input",   
      showCancelButton: true,   
      closeOnConfirm: false,   
      animation: "slide-from-top",   
      inputPlaceholder: "<?php echo $this->translate('Enter Password'); ?>"
    }, function(inputValue){   
      if (inputValue === false) {
          sesJqueryObject('#eclassroom_content').remove();
          sesJqueryObject('#locked_content').show();
          sesJqueryObject('.layout_core_comments').remove();
       return false;
      }
      if (inputValue === "") {    
        swal.showInputError("<?php echo $this->translate('You need to write something!');  ?>");     
        return false   
      }
      if(inputValue.toLowerCase() == '<?php echo strtolower($this->password); ?>'){
        sesJqueryObject('#locked_content').remove();
        sesJqueryObject('#eclassroom_content').show();
        sesJqueryObject('#eclassroom_cover_load').remove();
        setCookieCourses('<?php echo $this->classroom->classroom_id; ?>');
        if(sesJqueryObject('.eclassroom_view_embed').find('iframe')){
          var changeiframe = true;
        }else{
        }
        sesJqueryObject('.layout_core_comments').show();
        swal.close();
        sesJqueryObject('.layout_eclassroom_classroom_view_page').show();
      }else{
        swal("Wrong Password", "You wrote: " + inputValue, "error");
        sesJqueryObject('#eclassroom_content').remove();
        sesJqueryObject('#locked_content').show();
        sesJqueryObject('.layout_core_comments').remove();
      }
      if(typeof changeiframe != 'undefined'){
        sesJqueryObject('.eclassroom_view_embed').find('iframe').attr('src',sesJqueryObject('.eclassroom_view_embed').find('iframe').attr('src'));
        var aspect = 16 / 9;
        var el = document.id("pageFrame<?php echo $this->classroom->getIdentity(); ?>");
        if(typeof el == "undefined" || !el)
            return;
        var parent = el.getParent();
        var parentSize = parent.getSize();
        el.set("width", parentSize.x);
        el.set("height", parentSize.x / aspect);  
      }
    });
   }
   promptPasswordCheck();
  </script>
<?php }else{ ?>
  <script type="application/javascript">
    sesJqueryObject(document).ready(function(){
      sesJqueryObject('#locked_content').remove();
      sesJqueryObject('#eclassroom_content').show();
      sesJqueryObject('#eclassroom_cover_load').remove();
      sesJqueryObject('.layout_core_comments').show();
      if(sesJqueryObject('.eclassroom_view_embed').find('iframe')){
        sesJqueryObject('.eclassroom_view_embed').find('iframe').attr('src',sesJqueryObject('.eclassroom_view_embed').find('iframe').attr('src'));
        var aspect = 16 / 9;
        var el = document.getElementById("pageFrame");
        if(typeof el == "undefined" || !el)
        return;
        var parent = el.getParent();
        var parentSize = parent.getSize();
        el.set("width", parentSize.x);
        el.set("height", parentSize.x / aspect);  
      }
    });
  </script>
<?php } ?>
