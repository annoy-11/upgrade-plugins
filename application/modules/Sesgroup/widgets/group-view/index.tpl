<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $group = $this->group;?>
<?php $viewer = $this->viewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.share', 1);?>
<?php if($group->can_join && Engine_Api::_()->authorization()->getPermission($levelId, 'sesgroup_group', 'group_can_join')):?>
  <?php $canJoin = 1;?>
<?php else:?>
  <?php $canJoin = 0;?>
<?php endif;?>
<?php $isGroupEdit = Engine_Api::_()->sesgroup()->groupPrivacy($group, 'edit');?>
<?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.enable.package', 0)):?>
  <?php $params = Engine_Api::_()->getItem('sesgrouppackage_package', $this->group->package_id)->params;?>
  <?php $params = json_decode($params, true);?>
  <?php $canUploadCover = $params['upload_cover'];?>
<?php else:?>
  <?php $canUploadCover = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->viewer(), 'upload_cover');?>
<?php endif;?>
<?php if($isGroupEdit):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
   <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');?>
<?php endif;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/style_cover.css'); ?>
<?php $isGroupDelete = Engine_Api::_()->sesgroup()->groupPrivacy($group, 'delete');?>
<?php $group = $this->group;?>
<?php $owner = $group->getOwner();?>
<?php if(is_numeric($this->params['cover_height'])):?>
  <?php $height = $this->params['cover_height'].'px';?>
<?php else:?>
  <?php $height = $this->params['cover_height'];?>
<?php endif;?>
<div id="sesgroup_cover_load" class="sesgroup_cover_empty prelative" style="height:<?php echo $height ?>;"><div class="sesbasic_loading_cont_overlay" style="display:block;"></div></div>
<div id="sesgroup_content" style="display:none">
<?php if($this->params['layout_type'] == 2):?>
  <?php // Cover Layout code ?>
  <div class="sesgroup_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>sesgroup_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="sesgroup_cover" style="height:<?php echo $height ?>;">
      <div class="sesgroup_cover_inner sesbasic_clearfix">
        <div class="sesgroup_default_cover" style="height:<?php echo $height ?>;">
          <img id="sesgroup_cover_id" src="<?php echo $group->getCoverPhotoUrl() ?>" style="top:<?php echo $group->cover_position ? $group->cover_position : '0px'; ?>;" />
        </div>
        <span class="sesgroup_cover_fade"></span>
        <?php if($isGroupEdit && $canUploadCover):?>
          <div class="sesgroup_cover_change_btn" id="sesgroup_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="sesgroup_cover_change_options sesbasic_option_box"> 
              <i class="sesgroupcover_option_box_arrow"></i>
               <input type="file" id="uploadFilesesgroup" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangesesgroup" data-src="<?php echo $group->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemovesesgroup" style="display:<?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $group->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sesgroup_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="sesgroup_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="sesgroup_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="sesgroup_cover_content sesgroup_cover_d2">
        	<div class="sesgroup_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $group->featured):?>
              <span class="sesgroup_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $group->sponsored):?>
              <span class="sesgroup_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $group->hot):?>
              <span class="sesgroup_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
          <div class="_maincont sesbasic_clearfix">
            <div class="_cnw">
              <?php if(isset($this->photoActive)):?>
                <div class="_mainphoto">
                  <div id="sesgroup_cover_mainphotoinner" class="sesgroup_cover_mainphotoinner">
                    <img id="sesgroup_photo_id" src="<?php echo $group->getPhotoUrl('thumb.profile') ?>" alt="" />
                  </div>
                  <?php if($isGroupEdit):?>
                  <div class="sesgroup_cover_change_btn">
                    <a href="javascript:;" class="sesgroup_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                      <i class="fa fa-camera"></i>
                    </a>
                    <div class="sesgroup_cover_main_change_options sesbasic_option_box"> 
                      <i class="sesgroupcover_option_box_arrow"></i>
                      <input type="file" id="uploadPhotoFilesesgroup" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                      <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                      <a id="photoChangesesgroup" data-src="<?php echo $group->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                      <?php echo (isset($group->photo_id) && $group->photo_id != 0 && $group->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                      <a id="photoRemovesesgroup" style="display:<?php echo (isset($group->photo_id) && $group->photo_id != 0 && $group->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $group->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                    </div>
                  </div>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_info">
              	<?php if(isset($this->titleActive)):?><h1><?php echo $group->title;?><?php if(isset($this->verifiedLabelActive) && $this->group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>  
              	<p class="_data _stats">
                  <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                    <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                  <?php endif;?>
                  <?php if(isset($this->categoryActive)):?>
                    <?php $category = Engine_Api::_()->getItem('sesgroup_category',$this->group->category_id); ?>
                    <?php if($category):?>
                      <span><?php echo $this->translate('in ');?><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a></span></span>
                    <?php endif;?>
                  <?php endif;?>
                  <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?>
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
        <?php if($group->is_approved):?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->sesgroup()->getLikeStatus($this->group->group_id,$this->group->getType()); ?>
            <?php $likeClass = (!$likeStatus) ? 'fa fa-thumbs-up' : 'fa fa-thumbs-down' ;?>
            <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
            <div class="_likebtn">
            <a href='javascript:;' data-type='like_group_button_view' data-url='<?php echo $this->group->group_id; ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_button sesbasic_animation sesgroup_likefavfollow sesgroup_like_view_<?php echo $this->group->group_id; ?> segroup_like_group_view"><i class='fa <?php echo $likeClass ; ?>'></i><span><?php echo $likeText; ?></span></a>	
            </div>
          <?php endif;?>
          <?php if($viewerId):?>
            <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.favourite', 1)):?>
              <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->isFavourite(array('resource_id' => $this->group->group_id,'resource_type' => $this->group->getType())); ?>
              <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
              <div class="_favbtn">
                <a href='javascript:;' data-type='favourite_group_button_view' data-url='<?php echo $this->group->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_button sesbasic_animation sesgroup_likefavfollow sesgroup_favourite_view_<?php echo $this->group->group_id ?> sesgroup_favourite_group_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span><?php echo $favouriteText; ?></span></a>
              </div>
            <?php endif;?>
            <?php if($viewerId != $this->group->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.follow', 1)):?>
              <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesgroup')->isFollow(array('resource_id' => $group->group_id,'resource_type' => $group->getType())); ?>
              <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
              <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
              <div class="_followbtn">
                <a href='javascript:;' data-type='follow_group_button_view' data-url='<?php echo $this->group->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_button sesbasic_animation sesgroup_likefavfollow sesgroup_follow_view_<?php echo $this->group->getIdentity(); ?> sesgroup_follow_group_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>    
              </div>
            <?php endif;?>
          <?php  endif;?>
        <?php endif;?>
        <?php if(isset($this->socialSharingActive) && $shareType):?>
          <div class="_sharebtn">
            <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation sesgroup_button_toggle"><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
            <div class="sesgroup_listing_share_popup">
              <p><?php echo $this->translate("Share This Group");?></p>	
              <?php if($shareType == 2):?>
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $group, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $group->getType(),'id' => $group->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="smoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a>
            </div>
          </div>
        <?php endif;?>
        <?php if(isset($this->optionMenuActive)):?>
          <div class="_optionbtn"><a href="javascript:void(0);" class="sesbasic_button sesgroup_cbtn" id="sesgroup_cover_option_btn"><i class="fa fa-cog"></i></a></div>
        <?php endif;?>
      </div>
      <div class="_rightbtns">
        <div class="_joinbtn">
          <?php if($canJoin && isset($this->joinButtonActive)):?>
            <div class="_listbuttons_join">
              <?php if($viewerId):?>
                <?php $group = Engine_Api::_()->getItem('sesgroup_group',$group->group_id);?>
                <?php  $row = $group->membership()->getRow($viewer);?>
                <?php if(null === $row):?>
                  <?php if($group->membership()->isResourceApprovalRequired()):?>
                    <?php $action = 'request';?>
                  <?php else:?>
                    <?php $action = 'join';?>
                  <?php endif;?>
                  <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'group_id' => $group->group_id),'sesgroup_extended',true);?>" class="smoothbox sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                <?php else:?>
                  <?php if($row->active):?>
                    <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                  <?php else:?>
                    <a href="javascript:void(0);" id="sesgroup_user_approval" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" id="sesgroup_user_approval" class="smoothbox sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
              <?php endif;?>
            </div>
          <?php endif;?>
        </div>
        <?php if($viewerId && isset($this->messageOwnerActive) && $viewerId != $this->group->owner_id):?>
          <div class="_mgsowner">
            <a href="<?php echo $this->url(array('owner_id' => $this->group->owner_id,'action'=>'contact'), 'sesgroup_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
          </div>
        <?php endif;?>
        <?php if(isset($this->addButtonActive)):?>
          <div class="_contactbtn">
            <?php echo $this->content()->renderWidget("sesgroup.profile-action-button",array('identity'=>12312312))?>
          </div>
        <?php endif;?>
      </div>
    </div>  
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="sesgroup_cover_options_wrap" style="display:none;">
      <div class="sesgroup_cover_options sesgroup_options_dropdown" id="sesgroup_cover_options">
        <span class="sesgroup_options_dropdown_arrow"></span>
        <div class="sesgroup_options_dropdown_links">
          <?php echo $this->content()->renderWidget('sesgroup.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){	
			var topPositionOfParentSpan =  sesJqueryObject("#sesgroup_cover_option_btn").offset().top + 34;
			topPositionOfParentSpan = topPositionOfParentSpan+'px';
			var leftPositionOfParentSpan =  sesJqueryObject("#sesgroup_cover_option_btn").offset().left - 142;
			leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
			sesJqueryObject('.sesgroup_cover_options').css('top',topPositionOfParentSpan);
			sesJqueryObject('.sesgroup_cover_options').css('left',leftPositionOfParentSpan);
		}
		window.addEventListener("scroll", function(event) {
			doResizeForButton();
		});
    window.addEvent('load',function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).ready(function(){
			sesJqueryObject("<div>"+sesJqueryObject("#sesgroup_cover_options_wrap").html()+'</div>').appendTo('body');
			sesJqueryObject('#sesgroup_cover_options_wrap').remove();
			doResizeForButton();
		});
    sesJqueryObject(window).resize(function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).click(function(){
			sesJqueryObject('#sesgroup_cover_options').removeClass('show-options');
		})
    sesJqueryObject(document).on('click','#sesgroup_cover_option_btn', function(e){
			e.preventDefault();
			if(sesJqueryObject('#sesgroup_cover_options').hasClass('show-options'))
				sesJqueryObject('#sesgroup_cover_options').removeClass('show-options');
			else
				sesJqueryObject('#sesgroup_cover_options').addClass('show-options');
			return false;
    });
  <?php endif;?>
</script>
<?php else:?>
  <?php // Cover Layout code ?>
  <div class="sesgroup_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>sesgroup_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="sesgroup_cover" style="height:<?php echo $height ?>;">
      <div class="sesgroup_cover_inner sesbasic_clearfix">
        <div class="sesgroup_default_cover" style="height:<?php echo $height ?>;">
          <img id="sesgroup_cover_id" src="<?php echo $group->getCoverPhotoUrl() ?>" style="top:<?php echo $group->cover_position ? $group->cover_position : '0px'; ?>;" />
        </div>
        <span class="sesgroup_cover_fade"></span>
        <?php if($isGroupEdit && $canUploadCover):?>
          <div class="sesgroup_cover_change_btn" id="sesgroup_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="sesgroup_cover_change_options sesbasic_option_box"> 
              <i class="sesgroupcover_option_box_arrow"></i>
               <input type="file" id="uploadFilesesgroup" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangesesgroup" data-src="<?php echo $group->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemovesesgroup" style="display:<?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $group->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($group->cover) && $group->cover != 0 && $group->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sesgroup_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="sesgroup_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="sesgroup_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="sesgroup_cover_content sesgroup_cover_d1">
        	<div class="sesgroup_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $group->featured):?>
              <span class="sesgroup_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $group->sponsored):?>
              <span class="sesgroup_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $group->hot):?>
              <span class="sesgroup_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
        	<div class="_cnw">		
            <div class="_maincont sesbasic_clearfix">
              <?php if(isset($this->photoActive)):?>
                <div class="_mainphoto">
                  <div id="sesgroup_cover_mainphotoinner" class="sesgroup_cover_mainphotoinner">
                  <img id="sesgroup_photo_id" src="<?php echo $group->getPhotoUrl() ?>" alt="">
                </div>
                  <?php if($isGroupEdit):?>
                    <div class="sesgroup_cover_change_btn">
                        <a href="javascript:;" class="sesgroup_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                          <i class="fa fa-camera"></i>
                        </a>
                        <div class="sesgroup_cover_main_change_options sesbasic_option_box">
                          <i class="sesgroupcover_option_box_arrow"></i>
                          <input type="file" id="uploadPhotoFilesesgroup" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                          <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                          <a id="photoChangesesgroup" data-src="<?php echo $group->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                          <?php echo (isset($group->photo_id) && $group->photo_id != 0 && $group->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                          <a id="photoRemovesesgroup" style="display:<?php echo (isset($group->photo_id) && $group->photo_id != 0 && $group->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $group->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                        </div>
                      </div>
                    <?php endif;?>
                  </div>
                <?php endif;?>
               <?php if(isset($this->titleActive)):?><h1><?php echo $group->title;?><?php if(isset($this->verifiedLabelActive) && $this->group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>
              <p class="_data _stats">
                <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                  <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                <?php endif;?>
                <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?>
              </p>
			  <div class="_midbtns">
              	<div class="_joinbtn">
                  <?php if($canJoin && isset($this->joinButtonActive)):?>
                    <div class="_listbuttons_join">
                      <?php if($viewerId):?>
                        <?php $row = $group->membership()->getRow($this->viewer());?>
                        <?php if(null === $row):?>
                          <?php if($group->membership()->isResourceApprovalRequired()):?>
                            <?php $action = 'request';?>
                          <?php else:?>
                            <?php $action = 'join';?>
                          <?php endif;?>
                          <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'group_id' => $group->group_id),'sesgroup_extended',true);?>" class="smoothbox sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                        <?php else:?>
                          <?php if($row->active):?>
                            <a href="javascript:void(0);" class="sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                          <?php else:?>
                            <a href="javascript:void(0);" id="sesgroup_user_approval" class="sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                          <?php endif;?>
                        <?php endif;?>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" id="sesgroup_user_approval" class="smoothbox sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
                <?php if($viewerId && isset($this->messageOwnerActive) && $viewerId != $this->group->owner_id):?>
                  <div class="_mgsowner">
                    <a href="<?php echo $this->url(array('owner_id' => $this->group->owner_id,'action'=>'contact'), 'sesgroup_general', true); ?>" class="sessmoothbox sesgroup_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
                  </div>
                <?php endif;?>
                <?php if(isset($this->addButtonActive)):?>
                  <div class="_contactbtn">
                    <?php echo $this->content()->renderWidget("sesgroup.profile-action-button",array('identity'=>12312312))?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="_footer sesbasic_clearfix">
              <div class="_footerinner _cnw sesbasic_clearfix">
                <div class="sesgroup_cover_social_btns">
                <?php if(isset($this->socialSharingActive) && $shareType == 2):?>
                  <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $group, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
                <?php endif;?>  
                <?php if($group->is_approved):?>
                  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $this->viewer(), 'create');?>
                  <?php if(isset($this->likeButtonActive) && $canComment):?>
                    <?php $likeStatus = Engine_Api::_()->sesgroup()->getLikeStatus($group->group_id,$group->getType()); ?>
                    <a href="javascript:;" data-type="like_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgroup_like_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $group->like_count;?></span></a>
                  <?php endif;?>
                  <?php if($viewerId):?>
                    <?php  if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.favourite', 1)):?>
                      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->isFavourite(array('resource_id' => $group->group_id,'resource_type' => $group->getType())); ?>
                      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesgroup_favourite_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $group->favourite_count;?></span></a>
                    <?php  endif;?>
                    <?php if($viewerId != $group->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.follow', 1)):?>
                      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesgroup')->isFollow(array('resource_id' => $group->group_id,'resource_type' => $group->getType())); ?>
                      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $group->group_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sesgroup_follow_<?php echo $group->group_id ?> sesgroup_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $group->follow_count;?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
                  <?php if(isset($this->optionMenuActive)):?>
                    <a href="javascript:void(0);" class="sesbasic_icon_btn" id="sesgroup_cover_option_btn"><i class="fa fa-cog"></i></a>
                  <?php endif;?>
                </div>
                <?php if($this->params['tab_placement'] == 'in'):?>
                  <div class="sesgroup_cover_tabs _tabs"></div>
                <?php endif;?>
              </div>  
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="sesgroup_cover_options_wrap" style="display:none;">
      <div class="sesgroup_cover_options sesgroup_options_dropdown" id="sesgroup_cover_options">
        <span class="sesgroup_options_dropdown_arrow"></span>
        <div class="sesgroup_options_dropdown_links">
          <?php echo $this->content()->renderWidget('sesgroup.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){
        var topPositionOfParentSpan =  sesJqueryObject("#sesgroup_cover_option_btn").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#sesgroup_cover_option_btn").offset().left - 142;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.sesgroup_cover_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.sesgroup_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEvent('load',function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).ready(function(){
			sesJqueryObject("<div>"+sesJqueryObject("#sesgroup_cover_options_wrap").html()+'</div>').appendTo('body');
			sesJqueryObject('#sesgroup_cover_options_wrap').remove();
			doResizeForButton();
		});
    sesJqueryObject(window).resize(function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).click(function(){
			sesJqueryObject('#sesgroup_cover_options').removeClass('show-options');
		})
    sesJqueryObject(document).on('click','#sesgroup_cover_option_btn', function(e){
			e.preventDefault();
			if(sesJqueryObject('#sesgroup_cover_options').hasClass('show-options'))
				sesJqueryObject('#sesgroup_cover_options').removeClass('show-options');
			else
				sesJqueryObject('#sesgroup_cover_options').addClass('show-options');
			return false;
    });
  <?php endif;?>
  <?php if($this->params['tab_placement'] == 'in'):?>
    if (matchMedia('only screen and (min-width: 767px)').matches) {
        sesJqueryObject(document).ready(function(){
        if(sesJqueryObject('.layout_core_container_tabs').length>0){
          var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
          sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
          sesJqueryObject('.sesgroup_cover_tabs').html(tabs);
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
	sesJqueryObject(document).on('click','.sesgroup_cover_mainphoto_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject('.sesgroup_cover_mainphoto_toggle').removeClass('open');
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	sesJqueryObject(document).click(function(){
		sesJqueryObject('.sesgroup_cover_mainphoto_toggle').removeClass('open');
	});

  sesJqueryObject(document).click(function(event){
  if(event.target.id != 'sesgroup_dropdown_btn' && event.target.id != 'a_btn' && event.target.id != 'i_btn'){
    sesJqueryObject('#sesgroup_dropdown_btn').find('.sesgroup_option_box1').css('display','none');
    sesJqueryObject('#a_btn').removeClass('active');
  }
  if(event.target.id == 'change_cover_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
      if(sesJqueryObject('#sesgroup_change_cover_op').hasClass('active'))
          sesJqueryObject('#sesgroup_change_cover_op').removeClass('active')
      else
          sesJqueryObject('#sesgroup_change_cover_op').addClass('active');

      sesJqueryObject('#sesgroup_cover_option_main_id').removeClass('active');

  }else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){
    if(sesJqueryObject('#sesgroup_cover_option_main_id').hasClass('active'))
      sesJqueryObject('#sesgroup_cover_option_main_id').removeClass('active')
    else
      sesJqueryObject('#sesgroup_cover_option_main_id').addClass('active');
      sesJqueryObject('#sesgroup_change_cover_op').removeClass('active');
  }else{
    sesJqueryObject('#sesgroup_change_cover_op').removeClass('active');
    sesJqueryObject('#sesgroup_cover_option_main_id').removeClass('active')
  }
  if(event.target.id == 'a_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sesgroup_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sesgroup_option_box1').css('display','block');
    }
  }else if(event.target.id == 'i_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sesgroup_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sesgroup_option_box1').css('display','block');
    }
  }	
});
  sesJqueryObject(document).on('click','#coverChangesesgroup',function(){
    document.getElementById('uploadFilesesgroup').click();	
  });
  sesJqueryObject(document).on('click','#photoChangesesgroup',function(){
    document.getElementById('uploadPhotoFilesesgroup').click();	
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
      sesJqueryObject('.sesgroup_cover_mainphotoinner').append('<div id="sesgroup_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'sesgroup/profile/upload-photo/id/<?php echo $group->group_id ?>';
    }
    else {
      sesJqueryObject('.sesgroup_cover_inner').append('<div id="sesgroup_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'sesgroup/profile/upload-cover/id/<?php echo $group->group_id ?>';
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
            sesJqueryObject('#uploadFilesesgroup').val('');
            sesJqueryObject('#sesgroup_cover_loading').remove();
            sesJqueryObject('#sesgroup_cover_id').attr('src', response.file);
            sesJqueryObject('#coverChangesesgroup').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
            sesJqueryObject('#sesgroup_cover_photo_reposition').css('display','block');
            sesJqueryObject('#coverRemovesesgroup').css('display','block');
          }
        }
    }); 
  }
  function uploadmainPhoto(response){
      sesJqueryObject('#uploadPhotoFilesesgroup').val('');
      sesJqueryObject('#sesgroup_cover_loading').remove();
      sesJqueryObject('#sesgroup_photo_id').attr('src', response.file);
      sesJqueryObject('#photoChangesesgroup').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));
      sesJqueryObject('#photoRemovesesgroup').css('display','block');  
  }
  sesJqueryObject('#coverRemovesesgroup').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.sesgroup_cover_inner').append('<div id="sesgroup_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'sesgroup/profile/remove-cover/id/<?php echo $group->group_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          sesJqueryObject('#coverChangesesgroup').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#sesgroup_cover_id').attr('src', response.file);
          sesJqueryObject('#sesgroup_cover_photo_reposition').css('display','none');
          sesJqueryObject('#sesgroup_cover_loading').remove();
          //silence
       }
      }); 
    });
    sesJqueryObject('#photoRemovesesgroup').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.sesgroup_cover_mainphotoinner').append('<div id="sesgroup_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'sesgroup/profile/remove-photo/id/<?php echo $group->group_id ?>';
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
        sesJqueryObject('#photoChangesesgroup').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Upload Photo'));
        response = sesJqueryObject.parseJSON(response);
        sesJqueryObject('#sesgroup_photo_id').attr('src', response.file);
        sesJqueryObject('#sesgroup_cover_loading').remove();
        sesJqueryObject('#photoRemovesesgroup').css('display','none'); 
    }
    if(sesJqueryObject('.sesgroup_photo_update_popup').length == 0){
    sesJqueryObject('<div class="sesgroup_photo_update_popup sesbasic_bxs" id="sesgroup_popup_cam_upload" style="display:none"><div class="sesgroup_photo_update_popup_overlay"></div><div class="sesgroup_photo_update_popup_container sesgroup_photo_update_webcam_container sesgroup_fg_color"><div class="sesgroup_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesgroup_photo_update_popup_webcam_options"><div id="sesgroup_camera" style="background-color:#ccc;"></div><div class="centerT sesgroup_photo_update_popup_btns"><button class="capturePhoto" onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesgroup_photo_update_popup sesbasic_bxs" id="sesgroup_popup_existing_upload" style="display:none"><div class="sesgroup_photo_update_popup_overlay"></div><div class="sesgroup_photo_update_popup_container" id="sesgroup_popup_container_existing"><div class="sesgroup_select_photo_popup_header sesgroup_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesgroup_photo_update_popup_content"><div id="sesgroup_existing_data"></div><div id="sesgroup_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    }
  var contentTypeSesgroup;
  sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
    sesJqueryObject('#sesgroup_popup_cam_upload').show();
    contentTypeSesgroup = sesJqueryObject(this).closest('.sesgroup_cover_main_change_options').length > 0 ? 'photo' : 'cover';
    <!-- Configure a few settings and attach camera -->
    if(contentTypeSesgroup == 'photo') {
      sesJqueryObject('.sesgroup_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Photo") ?>');
      sesJqueryObject('.sesgroup_select_photo_popup_header').html('<?php echo $this->translate("Select a photo") ?>');
    }
    else {
      sesJqueryObject('.sesgroup_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Cover Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Cover Photo") ?>');
      sesJqueryObject('.sesgroup_select_photo_popup_header').html('<?php echo $this->translate("Select a Cover photo") ?>');
    }
    Webcam.set({
        width: 320,
        height: 240,
        image_format:'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#sesgroup_camera');
  });
  function hideProfilePhotoUpload(){
    if(typeof Webcam != 'undefined')
     Webcam.reset();
    canPaginateGroupNumber = 1;
    sesJqueryObject('#sesgroup_popup_cam_upload').hide();
    sesJqueryObject('#sesgroup_popup_existing_upload').hide();
    if(typeof Webcam != 'undefined'){
        sesJqueryObject('.slimScrollDiv').remove();
        sesJqueryObject('.sesgroup_photo_update_popup_content').html('<div id="sesgroup_existing_data"></div><div id="sesgroup_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#sesgroup_popup_cam_upload').hide();
      // upload results
      sesJqueryObject('.sesgroup_cover_inner').append('<div id="sesgroup_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
       Webcam.upload( data_uri, en4.core.staticBaseUrl+'sesgroup/profile/upload-'+contentTypeSesgroup+'/id/<?php echo $group->group_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('#sesgroup_cover_loading').remove();
              sesJqueryObject('#sesgroup_'+contentTypeSesgroup+'_id').attr('src', response.file);
              sesJqueryObject('#'+contentTypeSesgroup+'Changesesgroup').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change '+contentTypeSesgroup == "cover"?"Cover":""+' Photo'));
              sesJqueryObject('#sesgroup_'+contentTypeSesgroup+'_photo_reposition').css('display','block');
              sesJqueryObject('#'+contentTypeSesgroup+'Removesesgroup').css('display','block');
              
              sesJqueryObject('#sesgroup_'+contentTypeSesgroup+'_id_main').attr('src', response.file);
              sesJqueryObject('#photoChangesesgroup_<?php echo $group->group_id; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));              sesJqueryObject('#photoRemovesesgroup_<?php echo $group->group_id; ?>').css('display','block');
              
          } );
    });
  }
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('sesgroup_cover_full');
    });
  <?php } ?>
  <?php if($isGroupEdit && $canUploadCover):?>
  var previousPositionOfCover = sesJqueryObject('#sesgroup_cover_id').css('top');
  <!-- Reposition Photo -->
  sesJqueryObject('#sesgroup_cover_photo_reposition').click(function(){
          sesJqueryObject('.sesgroup_cover_reposition_btn').show();
          sesJqueryObject('.sesgroup_cover_fade').hide();
          sesJqueryObject('#sesgroup_change_cover_op').hide();
          sesJqueryObject('.sesgroup_cover_content').hide();
          sesJqueryUIMin('#sesgroup_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
  });
  sesJqueryObject('#cancelreposition').click(function(){
      sesJqueryObject('.sesgroup_cover_reposition_btn').hide();
      sesJqueryObject('#sesgroup_cover_id').css('top',previousPositionOfCover);
      sesJqueryObject('.sesgroup_cover_fade').show();
      sesJqueryObject('#sesgroup_change_cover_op').show();
      sesJqueryObject('.sesgroup_cover_content').show();
      sesJqueryUIMin("#sesgroup_cover_id").dragncrop('destroy');
  });
  sesJqueryObject('#savereposition').click(function(){
      var sendposition = sesJqueryObject('#sesgroup_cover_id').css('top');
      sesJqueryObject('#sesgroup_cover_photo_loading').show();
      var uploadURL = en4.core.staticBaseUrl+'sesgroup/profile/reposition-cover/id/<?php echo $group->group_id ?>';
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
                      sesJqueryObject('.sesgroup_cover_reposition_btn').hide();
                      sesJqueryUIMin("#sesgroup_cover_id").dragncrop('destroy');
                      sesJqueryObject('.sesgroup_cover_fade').show();
                      sesJqueryObject('#sesgroup_change_cover_op').show();
                      sesJqueryObject('.sesgroup_cover_content').show();
                  }else{
                      alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>');	
                  }
                      sesJqueryObject('#sesgroup_cover_photo_loading').hide();
                  //silence
               }
              });


  });
<?php endif;?>
sesJqueryObject(document).ready(function(e){
  //sesJqueryObject('#main_tabs').children().eq(0).find('a').trigger('click');
});
</script>
</div>
 
<div id="locked_content" style="display:none" class="sesbasic_locked_msg sesbasic_clearfix sesbasic_bxs">
  <div class="sesbasic_locked_msg_img"><i class="fa fa-lock"></i></div>
    <div class="sesbasic_locked_msg_cont">
  	<h1><?php echo $this->translate('Locked Group'); ?></h1>
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
    sesJqueryObject('#sesgroup_content').hide();
    sesJqueryObject('#locked_content').show();
    swal({   
      title: "",   
      text: "<?php echo $this->translate('Enter Password For:'); ?> <?php echo $this->group->getTitle(); ?>",  
      type: "input",   
      showCancelButton: true,   
      closeOnConfirm: false,   
      animation: "slide-from-top",   
      inputPlaceholder: "<?php echo $this->translate('Enter Password'); ?>"
    }, function(inputValue){   
      if (inputValue === false) {
          sesJqueryObject('#sesgroup_content').remove();
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
        sesJqueryObject('#sesgroup_content').show();
				sesJqueryObject('#sesgroup_cover_load').remove();
        setCookieSesgroup('<?php echo $this->group->group_id; ?>');
        if(sesJqueryObject('.sesgroup_view_embed').find('iframe')){
          var changeiframe = true;
        }else{
        }
        sesJqueryObject('.layout_core_comments').show();
        swal.close();
        sesJqueryObject('.layout_sesgroup_group_view_page').show();
      }else{
        swal("Wrong Password", "You wrote: " + inputValue, "error");
        sesJqueryObject('#sesgroup_content').remove();
        sesJqueryObject('#locked_content').show();
        sesJqueryObject('.layout_core_comments').remove();
      }
      if(typeof changeiframe != 'undefined'){
        sesJqueryObject('.sesgroup_view_embed').find('iframe').attr('src',sesJqueryObject('.sesgroup_view_embed').find('iframe').attr('src'));
        var aspect = 16 / 9;
        var el = document.id("pageFrame<?php echo $this->group->getIdentity(); ?>");
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
      sesJqueryObject('#sesgroup_content').show();
			sesJqueryObject('#sesgroup_cover_load').remove();
      sesJqueryObject('.layout_core_comments').show();
      if(sesJqueryObject('.sesgroup_view_embed').find('iframe')){
        sesJqueryObject('.sesgroup_view_embed').find('iframe').attr('src',sesJqueryObject('.sesgroup_view_embed').find('iframe').attr('src'));
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
