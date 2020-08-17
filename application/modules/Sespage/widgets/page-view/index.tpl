<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $page = $this->page;?>
<?php $viewer = $this->viewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.share', 1);?>
<?php if($page->can_join && Engine_Api::_()->authorization()->getPermission($levelId, 'sespage_page', 'page_can_join')):?>
  <?php $canJoin = 1;?>
<?php else:?>
  <?php $canJoin = 0;?>
<?php endif;?>
<?php $isPageEdit = Engine_Api::_()->sespage()->pagePrivacy($page, 'edit');?>
<?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)):?>
  <?php $params = Engine_Api::_()->getItem('sespagepackage_package', $this->page->package_id)->params;?>
  <?php $params = json_decode($params, true);?>
  <?php $canUploadCover = $params['upload_cover'];?>
<?php else:?>
  <?php $canUploadCover = Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->viewer(), 'upload_cover');?>
<?php endif;?>
<?php if($isPageEdit):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
   <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');?>
<?php endif;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/style_cover.css'); ?>
<?php $isPageDelete = Engine_Api::_()->sespage()->pagePrivacy($page, 'delete');?>
<?php $page = $this->page;?>
<?php $owner = $page->getOwner();?>
<?php if(is_numeric($this->params['cover_height'])):?>
  <?php $height = $this->params['cover_height'].'px';?>
<?php else:?>
  <?php $height = $this->params['cover_height'];?>
<?php endif;?>
<div id="sespage_cover_load" class="sespage_cover_empty prelative" style="height:<?php echo $height ?>;"><div class="sesbasic_loading_cont_overlay" style="display:block;"></div></div>
<div id="sespage_content" style="display:none">
<?php if($this->params['layout_type'] == 2):?>
  <?php // Cover Layout code ?>
  <div class="sespage_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>sespage_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="sespage_cover" style="height:<?php echo $height ?>;">
      <div class="sespage_cover_inner sesbasic_clearfix">
        <div class="sespage_default_cover" style="height:<?php echo $height ?>;">
          <img id="sespage_cover_id" src="<?php echo $page->getCoverPhotoUrl() ?>" style="top:<?php echo $page->cover_position ? $page->cover_position : '0px'; ?>;" />
        </div>
        <span class="sespage_cover_fade"></span>
        <?php if($isPageEdit && $canUploadCover):?>
          <div class="sespage_cover_change_btn" id="sespage_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="sespage_cover_change_options sesbasic_option_box"> 
              <i class="sespagecover_option_box_arrow"></i>
               <input type="file" id="uploadFilesespage" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangesespage" data-src="<?php echo $page->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemovesespage" style="display:<?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $page->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sespage_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="sespage_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="sespage_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="sespage_cover_content sespage_cover_d2">
        	<div class="sespage_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $page->featured):?>
              <span class="sespage_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $page->sponsored):?>
              <span class="sespage_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $page->hot):?>
              <span class="sespage_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
          <div class="_maincont sesbasic_clearfix">
            <div class="_cnw">
              <?php if(isset($this->photoActive)):?>
                <div class="_mainphoto">
                  <div id="sespage_cover_mainphotoinner" class="sespage_cover_mainphotoinner">
                    <img id="sespage_photo_id" src="<?php echo $page->getPhotoUrl('thumb.profile') ?>" alt="" />
                  </div>
                  <?php if($isPageEdit):?>
                  <div class="sespage_cover_change_btn">
                    <a href="javascript:;" class="sespage_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                      <i class="fa fa-camera"></i>
                    </a>
                    <div class="sespage_cover_main_change_options sesbasic_option_box"> 
                      <i class="sespagecover_option_box_arrow"></i>
                      <input type="file" id="uploadPhotoFilesespage" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                      <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                      <a id="photoChangesespage" data-src="<?php echo $page->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                      <?php echo (isset($page->photo_id) && $page->photo_id != 0 && $page->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                      <a id="photoRemovesespage" style="display:<?php echo (isset($page->photo_id) && $page->photo_id != 0 && $page->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $page->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                    </div>
                  </div>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_info">
              	<?php if(isset($this->titleActive)):?><h1><?php echo $page->title;?><?php if(isset($this->verifiedLabelActive) && $this->page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>  
              	<p class="_data _stats">
                  <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                    <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                  <?php endif;?>
                  <?php if(isset($this->categoryActive)):?>
                    <?php $category = Engine_Api::_()->getItem('sespage_category',$this->page->category_id); ?>
                    <?php if($category):?>
                      <span><?php echo $this->translate('in ');?><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a></span></span>
                    <?php endif;?>
                  <?php endif;?>
                  <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?>
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
        <?php if($page->is_approved):?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->sespage()->getLikeStatus($this->page->page_id,$this->page->getType()); ?>
            <?php $likeClass = (!$likeStatus) ? 'fa fa-thumbs-up' : 'fa fa-thumbs-down' ;?>
            <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
            <div class="_likebtn">
            <a href='javascript:;' data-type='like_page_button_view' data-url='<?php echo $this->page->page_id; ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_button sesbasic_animation sespage_likefavfollow sespage_like_view_<?php echo $this->page->page_id; ?> sepage_like_page_view"><i class='fa <?php echo $likeClass ; ?>'></i><span><?php echo $likeText; ?></span></a>	
            </div>
          <?php endif;?>
          <?php if($viewerId):?>
            <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.favourite', 1)):?>
              <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sespage')->isFavourite(array('resource_id' => $this->page->page_id,'resource_type' => $this->page->getType())); ?>
              <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
              <div class="_favbtn">
                <a href='javascript:;' data-type='favourite_page_button_view' data-url='<?php echo $this->page->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_button sesbasic_animation sespage_likefavfollow sespage_favourite_view_<?php echo $this->page->page_id ?> sespage_favourite_page_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span><?php echo $favouriteText; ?></span></a>
              </div>
            <?php endif;?>
            <?php if($viewerId != $this->page->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.follow', 1)):?>
              <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $page->page_id,'resource_type' => $page->getType())); ?>
              <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
              <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
              <div class="_followbtn">
                <a href='javascript:;' data-type='follow_page_button_view' data-url='<?php echo $this->page->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_button sesbasic_animation sespage_likefavfollow sespage_follow_view_<?php echo $this->page->getIdentity(); ?> sespage_follow_page_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>    
              </div>
            <?php endif;?>
          <?php  endif;?>
        <?php endif;?>
        <?php if(isset($this->socialSharingActive) && $shareType):?>
          <div class="_sharebtn">
            <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation sespage_button_toggle"><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
            <div class="sespage_listing_share_popup">
              <p><?php echo $this->translate("Share This Page");?></p>	
              <?php if($shareType == 2):?>
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $page, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $page->getType(),'id' => $page->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="smoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a>
            </div>
          </div>
        <?php endif;?>
        <?php if(isset($this->optionMenuActive)):?>
          <div class="_optionbtn"><a href="javascript:void(0);" class="sesbasic_button sespage_cbtn" id="sespage_cover_option_btn"><i class="fa fa-cog"></i></a></div>
        <?php endif;?>
      </div>
      <div class="_rightbtns">
        <div class="_joinbtn">
          <?php if($canJoin && isset($this->joinButtonActive)):?>
            <div class="_listbuttons_join">
              <?php if($viewerId):?>
                <?php $page = Engine_Api::_()->getItem('sespage_page',$page->page_id);?>
                <?php  $row = $page->membership()->getRow($viewer);?>
                <?php if(null === $row):?>
                  <?php if($page->membership()->isResourceApprovalRequired()):?>
                    <?php $action = 'request';?>
                  <?php else:?>
                    <?php $action = 'join';?>
                  <?php endif;?>
                  <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'page_id' => $page->page_id),'sespage_extended',true);?>" class="smoothbox sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                <?php else:?>
                  <?php if($row->active):?>
                    <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                  <?php else:?>
                    <a href="javascript:void(0);" id="sespage_user_approval" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" id="sespage_user_approval" class="smoothbox sespage_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
              <?php endif;?>
            </div>
          <?php endif;?>
        </div>
        <?php if($viewerId && isset($this->messageOwnerActive) && $viewerId != $this->page->owner_id):?>
          <div class="_mgsowner">
            <a href="<?php echo $this->url(array('owner_id' => $this->page->owner_id,'action'=>'contact'), 'sespage_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
          </div>
        <?php endif;?>
        <?php if(isset($this->addButtonActive)):?>
          <div class="_contactbtn">
            <?php echo $this->content()->renderWidget("sespage.profile-action-button",array('identity'=>12312312))?>
          </div>
        <?php endif;?>
      </div>
    </div>  
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="sespage_cover_options_wrap" style="display:none;">
      <div class="sespage_cover_options sespage_options_dropdown" id="sespage_cover_options">
        <span class="sespage_options_dropdown_arrow"></span>
        <div class="sespage_options_dropdown_links">
          <?php echo $this->content()->renderWidget('sespage.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){	
			var topPositionOfParentSpan =  sesJqueryObject("#sespage_cover_option_btn").offset().top + 34;
			topPositionOfParentSpan = topPositionOfParentSpan+'px';
			var leftPositionOfParentSpan =  sesJqueryObject("#sespage_cover_option_btn").offset().left - 142;
			leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
			sesJqueryObject('.sespage_cover_options').css('top',topPositionOfParentSpan);
			sesJqueryObject('.sespage_cover_options').css('left',leftPositionOfParentSpan);
		}
		window.addEventListener("scroll", function(event) {
			doResizeForButton();
		});
    window.addEvent('load',function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).ready(function(){
			sesJqueryObject("<div>"+sesJqueryObject("#sespage_cover_options_wrap").html()+'</div>').appendTo('body');
			sesJqueryObject('#sespage_cover_options_wrap').remove();
			doResizeForButton();
		});
    sesJqueryObject(window).resize(function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).click(function(){
			sesJqueryObject('#sespage_cover_options').removeClass('show-options');
		})
    sesJqueryObject(document).on('click','#sespage_cover_option_btn', function(e){
			e.preventDefault();
			if(sesJqueryObject('#sespage_cover_options').hasClass('show-options'))
				sesJqueryObject('#sespage_cover_options').removeClass('show-options');
			else
				sesJqueryObject('#sespage_cover_options').addClass('show-options');
			return false;
    });
  <?php endif;?>
</script>
<?php else:?>
  <?php // Cover Layout code ?>
  <div class="sespage_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>sespage_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="sespage_cover" style="height:<?php echo $height ?>;">
      <div class="sespage_cover_inner sesbasic_clearfix">
        <div class="sespage_default_cover" style="height:<?php echo $height ?>;">
          <img id="sespage_cover_id" src="<?php echo $page->getCoverPhotoUrl() ?>" style="top:<?php echo $page->cover_position ? $page->cover_position : '0px'; ?>;" />
        </div>
        <span class="sespage_cover_fade"></span>
        <?php if($isPageEdit && $canUploadCover):?>
          <div class="sespage_cover_change_btn" id="sespage_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="sespage_cover_change_options sesbasic_option_box"> 
              <i class="sespagecover_option_box_arrow"></i>
               <input type="file" id="uploadFilesespage" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangesespage" data-src="<?php echo $page->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemovesespage" style="display:<?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $page->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($page->cover) && $page->cover != 0 && $page->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="sespage_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="sespage_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="sespage_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="sespage_cover_content sespage_cover_d1">
        	<div class="sespage_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $page->featured):?>
              <span class="sespage_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $page->sponsored):?>
              <span class="sespage_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $page->hot):?>
              <span class="sespage_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
        	<div class="_cnw">		
            <div class="_maincont sesbasic_clearfix">
              <?php if(isset($this->photoActive)):?>
                <div class="_mainphoto">
                  <div id="sespage_cover_mainphotoinner" class="sespage_cover_mainphotoinner">
                  <img id="sespage_photo_id" src="<?php echo $page->getPhotoUrl() ?>" alt="">
                </div>
                  <?php if($isPageEdit):?>
                    <div class="sespage_cover_change_btn">
                        <a href="javascript:;" class="sespage_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                          <i class="fa fa-camera"></i>
                        </a>
                        <div class="sespage_cover_main_change_options sesbasic_option_box">
                          <i class="sespagecover_option_box_arrow"></i>
                          <input type="file" id="uploadPhotoFilesespage" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                          <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                          <a id="photoChangesespage" data-src="<?php echo $page->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                          <?php echo (isset($page->photo_id) && $page->photo_id != 0 && $page->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                          <a id="photoRemovesespage" style="display:<?php echo (isset($page->photo_id) && $page->photo_id != 0 && $page->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $page->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                        </div>
                      </div>
                    <?php endif;?>
                  </div>
                <?php endif;?>
               <?php if(isset($this->titleActive)):?><h1><?php echo $page->title;?><?php if(isset($this->verifiedLabelActive) && $this->page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></h1><?php endif;?>
              <p class="_data _stats">
                <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                  <span><i class="fa fa-user"></i> <span><?php echo $this->translate('by ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                <?php endif;?>
                <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?>
              </p>
			  <div class="_midbtns">
              	<div class="_joinbtn">
                  <?php if($canJoin && isset($this->joinButtonActive)):?>
                    <div class="_listbuttons_join">
                      <?php if($viewerId):?>
                        <?php $row = $page->membership()->getRow($this->viewer());?>
                        <?php if(null === $row):?>
                          <?php if($page->membership()->isResourceApprovalRequired()):?>
                            <?php $action = 'request';?>
                          <?php else:?>
                            <?php $action = 'join';?>
                          <?php endif;?>
                          <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'page_id' => $page->page_id),'sespage_extended',true);?>" class="smoothbox sespage_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                        <?php else:?>
                          <?php if($row->active):?>
                            <a href="javascript:void(0);" class="sespage_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                          <?php else:?>
                            <a href="javascript:void(0);" id="sespage_user_approval" class="sespage_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                          <?php endif;?>
                        <?php endif;?>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" id="sespage_user_approval" class="smoothbox sespage_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
                <?php if($viewerId && isset($this->messageOwnerActive) && $viewerId != $this->page->owner_id):?>
                  <div class="_mgsowner">
                    <a href="<?php echo $this->url(array('owner_id' => $this->page->owner_id,'action'=>'contact'), 'sespage_general', true); ?>" class="sessmoothbox sespage_button"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
                  </div>
                <?php endif;?>
                <?php if(isset($this->addButtonActive)):?>
                  <div class="_contactbtn">
                    <?php echo $this->content()->renderWidget("sespage.profile-action-button",array('identity'=>12312312))?>
                  </div>
                <?php endif;?>
              </div>
            </div>
            <div class="_footer sesbasic_clearfix">
              <div class="_footerinner _cnw sesbasic_clearfix">
                <div class="sespage_cover_social_btns">
                <?php if(isset($this->socialSharingActive) && $shareType == 2):?>
                  <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $page, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
                <?php endif;?>  
                <?php if($page->is_approved):?>
                  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sespage_page', $this->viewer(), 'create');?>
                  <?php if(isset($this->likeButtonActive) && $canComment):?>
                    <?php $likeStatus = Engine_Api::_()->sespage()->getLikeStatus($page->page_id,$page->getType()); ?>
                    <a href="javascript:;" data-type="like_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespage_like_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $page->like_count;?></span></a>
                  <?php endif;?>
                  <?php if($viewerId):?>
                    <?php  if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.favourite', 1)):?>
                      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sespage')->isFavourite(array('resource_id' => $page->page_id,'resource_type' => $page->getType())); ?>
                      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sespage_favourite_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $page->favourite_count;?></span></a>
                    <?php  endif;?>
                    <?php if($viewerId != $page->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.follow', 1)):?>
                      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $page->page_id,'resource_type' => $page->getType())); ?>
                      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sespage_follow_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $page->follow_count;?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                <?php endif;?>
                  <?php if(isset($this->optionMenuActive)):?>
                    <a href="javascript:void(0);" class="sesbasic_icon_btn" id="sespage_cover_option_btn"><i class="fa fa-cog"></i></a>
                  <?php endif;?>
                </div>
                <?php if($this->params['tab_placement'] == 'in'):?>
                  <div class="sespage_cover_tabs _tabs"></div>
                <?php endif;?>
              </div>  
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
  <?php if(isset($this->optionMenuActive)):?>
    <div id="sespage_cover_options_wrap" style="display:none;">
      <div class="sespage_cover_options sespage_options_dropdown" id="sespage_cover_options">
        <span class="sespage_options_dropdown_arrow"></span>
        <div class="sespage_options_dropdown_links">
          <?php echo $this->content()->renderWidget('sespage.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){
        var topPositionOfParentSpan =  sesJqueryObject("#sespage_cover_option_btn").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#sespage_cover_option_btn").offset().left - 142;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.sespage_cover_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.sespage_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEvent('load',function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).ready(function(){
			sesJqueryObject("<div>"+sesJqueryObject("#sespage_cover_options_wrap").html()+'</div>').appendTo('body');
			sesJqueryObject('#sespage_cover_options_wrap').remove();
			doResizeForButton();
		});
    sesJqueryObject(window).resize(function(){
    	doResizeForButton();
    });
		sesJqueryObject(document).click(function(){
			sesJqueryObject('#sespage_cover_options').removeClass('show-options');
		})
    sesJqueryObject(document).on('click','#sespage_cover_option_btn', function(e){
			e.preventDefault();
			if(sesJqueryObject('#sespage_cover_options').hasClass('show-options'))
				sesJqueryObject('#sespage_cover_options').removeClass('show-options');
			else
				sesJqueryObject('#sespage_cover_options').addClass('show-options');
			return false;
    });
  <?php endif;?>
  <?php if($this->params['tab_placement'] == 'in'):?>
    if (matchMedia('only screen and (min-width: 767px)').matches) {
        sesJqueryObject(document).ready(function(){
        if(sesJqueryObject('.layout_core_container_tabs').length>0){
          var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
          sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
          sesJqueryObject('.sespage_cover_tabs').html(tabs);
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
	sesJqueryObject(document).on('click','.sespage_cover_mainphoto_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject('.sespage_cover_mainphoto_toggle').removeClass('open');
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	sesJqueryObject(document).click(function(){
		sesJqueryObject('.sespage_cover_mainphoto_toggle').removeClass('open');
	});

  sesJqueryObject(document).click(function(event){
  if(event.target.id != 'sespage_dropdown_btn' && event.target.id != 'a_btn' && event.target.id != 'i_btn'){
    sesJqueryObject('#sespage_dropdown_btn').find('.sespage_option_box1').css('display','none');
    sesJqueryObject('#a_btn').removeClass('active');
  }
  if(event.target.id == 'change_cover_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
      if(sesJqueryObject('#sespage_change_cover_op').hasClass('active'))
          sesJqueryObject('#sespage_change_cover_op').removeClass('active')
      else
          sesJqueryObject('#sespage_change_cover_op').addClass('active');

      sesJqueryObject('#sespage_cover_option_main_id').removeClass('active');

  }else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){
    if(sesJqueryObject('#sespage_cover_option_main_id').hasClass('active'))
      sesJqueryObject('#sespage_cover_option_main_id').removeClass('active')
    else
      sesJqueryObject('#sespage_cover_option_main_id').addClass('active');
      sesJqueryObject('#sespage_change_cover_op').removeClass('active');
  }else{
    sesJqueryObject('#sespage_change_cover_op').removeClass('active');
    sesJqueryObject('#sespage_cover_option_main_id').removeClass('active')
  }
  if(event.target.id == 'a_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sespage_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sespage_option_box1').css('display','block');
    }
  }else if(event.target.id == 'i_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.sespage_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.sespage_option_box1').css('display','block');
    }
  }	
});
  sesJqueryObject(document).on('click','#coverChangesespage',function(){
    document.getElementById('uploadFilesespage').click();	
  });
  sesJqueryObject(document).on('click','#photoChangesespage',function(){
    document.getElementById('uploadPhotoFilesespage').click();	
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
      sesJqueryObject('.sespage_cover_mainphotoinner').append('<div id="sespage_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'sespage/profile/upload-photo/id/<?php echo $page->page_id ?>';
    }
    else {
      sesJqueryObject('.sespage_cover_inner').append('<div id="sespage_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'sespage/profile/upload-cover/id/<?php echo $page->page_id ?>';
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
            sesJqueryObject('#uploadFilesespage').val('');
            sesJqueryObject('#sespage_cover_loading').remove();
            sesJqueryObject('#sespage_cover_id').attr('src', response.file);
            sesJqueryObject('#coverChangesespage').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
            sesJqueryObject('#sespage_cover_photo_reposition').css('display','block');
            sesJqueryObject('#coverRemovesespage').css('display','block');
          }
        }
    }); 
  }
  function uploadmainPhoto(response){
      sesJqueryObject('#uploadPhotoFilesespage').val('');
      sesJqueryObject('#sespage_cover_loading').remove();
      sesJqueryObject('#sespage_photo_id').attr('src', response.file);
      sesJqueryObject('#photoChangesespage').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));
      sesJqueryObject('#photoRemovesespage').css('display','block');  
  }
  sesJqueryObject('#coverRemovesespage').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.sespage_cover_inner').append('<div id="sespage_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'sespage/profile/remove-cover/id/<?php echo $page->page_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          sesJqueryObject('#coverChangesespage').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#sespage_cover_id').attr('src', response.file);
          sesJqueryObject('#sespage_cover_photo_reposition').css('display','none');
          sesJqueryObject('#sespage_cover_loading').remove();
          //silence
       }
      }); 
    });
    sesJqueryObject('#photoRemovesespage').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.sespage_cover_mainphotoinner').append('<div id="sespage_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'sespage/profile/remove-photo/id/<?php echo $page->page_id ?>';
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
        sesJqueryObject('#photoChangesespage').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Upload Photo'));
        response = sesJqueryObject.parseJSON(response);
        sesJqueryObject('#sespage_photo_id').attr('src', response.file);
        sesJqueryObject('#sespage_cover_loading').remove();
        sesJqueryObject('#photoRemovesespage').css('display','none'); 
    }
    if(sesJqueryObject('.sespage_photo_update_popup').length == 0){
    sesJqueryObject('<div class="sespage_photo_update_popup sesbasic_bxs" id="sespage_popup_cam_upload" style="display:none"><div class="sespage_photo_update_popup_overlay"></div><div class="sespage_photo_update_popup_container sespage_photo_update_webcam_container sespage_fg_color"><div class="sespage_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sespage_photo_update_popup_webcam_options"><div id="sespage_camera" style="background-color:#ccc;"></div><div class="centerT sespage_photo_update_popup_btns"><button class="capturePhoto" onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sespage_photo_update_popup sesbasic_bxs" id="sespage_popup_existing_upload" style="display:none"><div class="sespage_photo_update_popup_overlay"></div><div class="sespage_photo_update_popup_container" id="sespage_popup_container_existing"><div class="sespage_select_photo_popup_header sespage_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sespage_photo_update_popup_content"><div id="sespage_existing_data"></div><div id="sespage_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    }
  var contentTypeSespage;
  sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
    sesJqueryObject('#sespage_popup_cam_upload').show();
    contentTypeSespage = sesJqueryObject(this).closest('.sespage_cover_main_change_options').length > 0 ? 'photo' : 'cover';
    <!-- Configure a few settings and attach camera -->
    if(contentTypeSespage == 'photo') {
      sesJqueryObject('.sespage_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Photo") ?>');
      sesJqueryObject('.sespage_select_photo_popup_header').html('<?php echo $this->translate("Select a photo") ?>');
    }
    else {
      sesJqueryObject('.sespage_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Cover Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Cover Photo") ?>');
      sesJqueryObject('.sespage_select_photo_popup_header').html('<?php echo $this->translate("Select a Cover photo") ?>');
    }
    Webcam.set({
        width: 320,
        height: 240,
        image_format:'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#sespage_camera');
  });
  function hideProfilePhotoUpload(){
    if(typeof Webcam != 'undefined')
     Webcam.reset();
    canPaginatePageNumber = 1;
    sesJqueryObject('#sespage_popup_cam_upload').hide();
    sesJqueryObject('#sespage_popup_existing_upload').hide();
    if(typeof Webcam != 'undefined'){
        sesJqueryObject('.slimScrollDiv').remove();
        sesJqueryObject('.sespage_photo_update_popup_content').html('<div id="sespage_existing_data"></div><div id="sespage_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#sespage_popup_cam_upload').hide();
      // upload results
      sesJqueryObject('.sespage_cover_inner').append('<div id="sespage_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
       Webcam.upload( data_uri, en4.core.staticBaseUrl+'sespage/profile/upload-'+contentTypeSespage+'/id/<?php echo $page->page_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('#sespage_cover_loading').remove();
              sesJqueryObject('#sespage_'+contentTypeSespage+'_id').attr('src', response.file);
              sesJqueryObject('#'+contentTypeSespage+'Changesespage').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change '+contentTypeSespage == "cover"?"Cover":""+' Photo'));
              sesJqueryObject('#sespage_'+contentTypeSespage+'_photo_reposition').css('display','block');
              sesJqueryObject('#'+contentTypeSespage+'Removesespage').css('display','block');
              
              sesJqueryObject('#sespage_'+contentTypeSespage+'_id_main').attr('src', response.file);
              sesJqueryObject('#photoChangesespage_<?php echo $page->page_id; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));              sesJqueryObject('#photoRemovesespage_<?php echo $page->page_id; ?>').css('display','block');
              
          } );
    });
  }
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('sespage_cover_full');
    });
  <?php } ?>
  <?php if($isPageEdit && $canUploadCover):?>
  var previousPositionOfCover = sesJqueryObject('#sespage_cover_id').css('top');
  <!-- Reposition Photo -->
  sesJqueryObject('#sespage_cover_photo_reposition').click(function(){
          sesJqueryObject('.sespage_cover_reposition_btn').show();
          sesJqueryObject('.sespage_cover_fade').hide();
          sesJqueryObject('#sespage_change_cover_op').hide();
          sesJqueryObject('.sespage_cover_content').hide();
          sesJqueryUIMin('#sespage_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
  });
  sesJqueryObject('#cancelreposition').click(function(){
      sesJqueryObject('.sespage_cover_reposition_btn').hide();
      sesJqueryObject('#sespage_cover_id').css('top',previousPositionOfCover);
      sesJqueryObject('.sespage_cover_fade').show();
      sesJqueryObject('#sespage_change_cover_op').show();
      sesJqueryObject('.sespage_cover_content').show();
      sesJqueryUIMin("#sespage_cover_id").dragncrop('destroy');
  });
  sesJqueryObject('#savereposition').click(function(){
      var sendposition = sesJqueryObject('#sespage_cover_id').css('top');
      sesJqueryObject('#sespage_cover_photo_loading').show();
      var uploadURL = en4.core.staticBaseUrl+'sespage/profile/reposition-cover/id/<?php echo $page->page_id ?>';
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
                      sesJqueryObject('.sespage_cover_reposition_btn').hide();
                      sesJqueryUIMin("#sespage_cover_id").dragncrop('destroy');
                      sesJqueryObject('.sespage_cover_fade').show();
                      sesJqueryObject('#sespage_change_cover_op').show();
                      sesJqueryObject('.sespage_cover_content').show();
                  }else{
                      alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>');	
                  }
                      sesJqueryObject('#sespage_cover_photo_loading').hide();
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
  	<h1><?php echo $this->translate('Locked Page'); ?></h1>
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
    sesJqueryObject('#sespage_content').hide();
    sesJqueryObject('#locked_content').show();
    swal({   
      title: "",   
      text: "<?php echo $this->translate('Enter Password For:'); ?> <?php echo $this->page->getTitle(); ?>",  
      type: "input",   
      showCancelButton: true,   
      closeOnConfirm: false,   
      animation: "slide-from-top",   
      inputPlaceholder: "<?php echo $this->translate('Enter Password'); ?>"
    }, function(inputValue){   
      if (inputValue === false) {
          sesJqueryObject('#sespage_content').remove();
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
        sesJqueryObject('#sespage_content').show();
				sesJqueryObject('#sespage_cover_load').remove();
        setCookieSespage('<?php echo $this->page->page_id; ?>');
        if(sesJqueryObject('.sespage_view_embed').find('iframe')){
          var changeiframe = true;
        }else{
        }
        sesJqueryObject('.layout_core_comments').show();
        swal.close();
        sesJqueryObject('.layout_sespage_page_view_page').show();
      }else{
        swal("Wrong Password", "You wrote: " + inputValue, "error");
        sesJqueryObject('#sespage_content').remove();
        sesJqueryObject('#locked_content').show();
        sesJqueryObject('.layout_core_comments').remove();
      }
      if(typeof changeiframe != 'undefined'){
        sesJqueryObject('.sespage_view_embed').find('iframe').attr('src',sesJqueryObject('.sespage_view_embed').find('iframe').attr('src'));
        var aspect = 16 / 9;
        var el = document.id("pageFrame<?php echo $this->page->getIdentity(); ?>");
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
      sesJqueryObject('#sespage_content').show();
			sesJqueryObject('#sespage_cover_load').remove();
      sesJqueryObject('.layout_core_comments').show();
      if(sesJqueryObject('.sespage_view_embed').find('iframe')){
        sesJqueryObject('.sespage_view_embed').find('iframe').attr('src',sesJqueryObject('.sespage_view_embed').find('iframe').attr('src'));
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
