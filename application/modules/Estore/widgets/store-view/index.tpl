<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $store = $this->store;?>
<?php $viewer = $this->viewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
<?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1);?>
<?php if($store->can_join && Engine_Api::_()->authorization()->getPermission($levelId, 'stores', 'bs_can_join')):?>
  <?php $canJoin = 1;?>
<?php else:?>
  <?php $canJoin = 0;?>
<?php endif;?>
<?php $isStoreEdit = Engine_Api::_()->estore()->storePrivacy($store, 'edit');?>
<?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('estorepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.enable.package', 0)):?>
  <?php $params = Engine_Api::_()->getItem('estorepackage_package', $this->store->package_id)->params;?>
  <?php $params = json_decode($params, true);?>
  <?php $canUploadCover = $params['upload_cover'];?>
<?php else:?>
  <?php $canUploadCover = Engine_Api::_()->authorization()->isAllowed('stores', $this->viewer(), 'upload_cover');?>
<?php endif;?>
<?php if($isStoreEdit):?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/webcam.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
   <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');?>
<?php endif;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/style_cover.css'); ?>
<?php $isStoreDelete = Engine_Api::_()->estore()->storePrivacy($store, 'delete');?>
<?php $store = $this->store;?>
<?php $owner = $store->getOwner();?>
<?php if(is_numeric($this->params['cover_height'])):?>
  <?php $height = $this->params['cover_height'].'px';?>
<?php else:?>
  <?php $height = $this->params['cover_height'];?>
<?php endif;?>
<div id="estore_cover_load" class="estore_cover_empty prelative" style="height:<?php echo $height ?>;"><div class="sesbasic_loading_cont_overlay" style="display:block;"></div></div>
<div id="estore_content" style="display:none">
  <div class="estore_cover_container sesbasic_clearfix sesbasic_bxs <?php if($this->params['show_full_width'] == 'yes'){ ?>estore_cover_container_full <?php } ?>" style="margin-top:-<?php echo is_numeric($this->params['margin_top']) ? $this->params['margin_top'].'px' : $this->params['margin_top']?>;">
    <div class="estore_cover" style="height:<?php echo $height ?>;">
      <div class="estore_cover_inner sesbasic_clearfix">
        <div class="estore_default_cover" style="height:<?php echo $height ?>;">
          <img id="estore_cover_id" src="<?php echo $store->getCoverPhotoUrl() ?>" style="top:<?php echo $store->cover_position ? $store->cover_position : '0px'; ?>;" />
        </div>
        <span class="estore_cover_fade"></span>
        <?php if($isStoreEdit && $canUploadCover): ?>
          <div class="estore_cover_change_btn" id="estore_change_cover_op">
            <a href="javascript:;" id="cover_change_btn">
              <i class="fa fa-camera" id="cover_change_btn_i"></i>
              <span id="change_cover_txt"><?php echo $this->translate("Upload Cover Photo"); ?></span>
            </a>
            <div class="estore_cover_change_options sesbasic_option_box"> 
              <i class="estorecover_option_box_arrow"></i>
               <input type="file" id="uploadFileestore" name="art_cover" onchange="uploadCoverArt(this,'cover');"  style="display:none" />
               <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
               <a id="coverChangeestore" data-src="<?php echo $store->cover; ?>" href="javascript:;"><i class="fa fa-plus"></i>
               <?php echo (isset($store->cover) && $store->cover != 0 && $store->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo'); ?></a>
                <a id="coverRemoveestore" style="display:<?php echo (isset($store->cover) && $store->cover != 0 && $store->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $store->cover; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
                <a style="display:<?php echo (isset($store->cover) && $store->cover != 0 && $store->cover != '') ? 'block' : 'none' ; ?>;" href="javascript:;" id="estore_cover_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>        
            </div>
          </div>
          <div id="estore_cover_photo_loading" class="sesbasic_loading_cont_overlay"></div>
          <div class="estore_cover_reposition_btn" style="display:none;">
            <a class="sesbasic_button" href="javascript:;" id="savereposition"><?php echo $this->translate("Save"); ?></a>
            <a class="sesbasic_button" href="javascript:;" id="cancelreposition"><?php echo $this->translate("Cancel"); ?></a>
          </div>
        <?php endif;?>
        <div class="estore_cover_content estore_cover_d2">
          <div class="estore_cover_labels sesbasic_animation">
            <?php if(isset($this->featuredLabelActive) && $store->featured):?>
              <span class="estore_label_featured"><?php echo $this->translate("Featured");?></span>
            <?php endif;?>
            <?php if(isset($this->sponsoredLabelActive) && $store->sponsored):?>
              <span class="estore_label_sponsored"><?php echo $this->translate("Sponsored");?></span>
            <?php endif;?>
            <?php if(isset($this->hotLabelActive) && $store->hot):?>
              <span class="estore_label_hot"><?php echo $this->translate("Hot");?></span>
            <?php endif;?>
          </div>
          <div class="_maincont sesbasic_clearfix">
            <div class="_cnw">
              <?php if(isset($this->photoActive)): ?>
                <div class="_mainphoto" style="height:<?php echo is_numeric($this->params['main_photo_height']) ? $this->params['main_photo_height'].'px' : $this->params['main_photo_height'] ?>;width:<?php echo is_numeric($this->params['main_photo_width']) ? $this->params['main_photo_width'].'px' : $this->params['main_photo_width'] ?>;">
                  <div id="estore_cover_mainphotoinner" class="estore_cover_mainphotoinner">
                    <img id="estore_photo_id" src="<?php echo $store->getPhotoUrl('thumb.profile') ?>" alt="" />
                  </div>
                  <?php if($isStoreEdit):?>
                  <div class="estore_cover_change_btn">
                    <a href="javascript:;" class="estore_cover_mainphoto_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
                      <i class="fa fa-camera"></i>
                    </a>
                    <div class="estore_cover_main_change_options sesbasic_option_box"> 
                      <i class="estorecover_option_box_arrow"></i>
                      <input type="file" id="uploadPhotoFileestore" name="art_cover" onchange="uploadCoverArt(this,'photo');"  style="display:none" />
                      <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
                      <a id="photoChangeestore" data-src="<?php echo $store->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
                      <?php echo (isset($store->photo_id) && $store->photo_id != 0 && $store->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
                      <a id="photoRemoveestore" style="display:<?php echo (isset($store->photo_id) && $store->photo_id != 0 && $store->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $store->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
                    </div>
                  </div>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <div class="_info">
                <?php if(isset($this->titleActive)):?><h1><?php echo $store->title;?><?php if(isset($this->verifiedLabelActive) && $this->store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              <?php if(isset($this->priceActive)): ?>
                <div class="estore_price">
                  	<span class="price_val"><i class="fa fa-dollar-sign"></i> <b><?php echo $store->price; ?></b></span>
                </div>
             <?php endif;?>
           </h1>
    <?php endif;?>  
                <div class="_data _stats">
                <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                    <span><i class="far fa-user"></i><span><?php echo $this->translate('By ');?><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span></span>
                  <?php endif;?>
                  <?php if(isset($this->categoryActive)):?>
                    <?php $category = Engine_Api::_()->getItem('estore_category',$this->store->category_id); ?>
                    <?php if($category):?>
                      <span><i class="far fa-folder-open"></i><a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a></span>
                    <?php endif;?>
                  <?php endif;?>
                  <?php if(isset($this->creationDateActive)):?>
                     <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
                  <?php endif;?>
                  <?php if(isset($this->ratingActive)):?>
                    <span><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?></span>
                  <?php endif;?>
                   </div>
                  <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabelStatics.tpl';?>
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
        <?php if($store->is_approved):?>
          <?php $canComment = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment):?>
            <?php $likeStatus = Engine_Api::_()->estore()->getLikeStatus($this->store->store_id,$this->store->getType()); ?>
            <?php $likeClass = (!$likeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
            <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
            <div class="_likebtn">
            <a href='javascript:;' data-type='like_store_button_view' data-url='<?php echo $this->store->store_id; ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_button sesbasic_animation estore_likefavfollow estore_like_view_<?php echo $this->store->store_id; ?> sestore_like_store_view"><i class='far <?php echo $likeClass ; ?>'></i><span><?php echo $likeText; ?></span></a>  
            </div>
          <?php endif;?>
          <?php if($viewerId):?>
            <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.favourite', 1)):?>
              <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'estore')->isFavourite(array('resource_id' => $this->store->store_id,'resource_type' => $this->store->getType())); ?>
              <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
              <div class="_favbtn">
                <a href='javascript:;' data-type='favourite_store_button_view' data-url='<?php echo $this->store->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_button sesbasic_animation estore_likefavfollow estore_favourite_view_<?php echo $this->store->store_id ?> estore_favourite_store_view"><i class='far <?php echo $favouriteClass ; ?>'></i><span><?php echo $favouriteText; ?></span></a>
              </div>
            <?php endif;?>
            <?php if($viewerId != $this->store->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.follow', 1)):?>
              <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'estore')->isFollow(array('resource_id' => $store->store_id,'resource_type' => $store->getType())); ?>
              <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
              <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
              <div class="_followbtn">
                <a href='javascript:;' data-type='follow_store_button_view' data-url='<?php echo $this->store->getIdentity(); ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_button sesbasic_animation estore_likefavfollow estore_follow_view_<?php echo $this->store->getIdentity(); ?> estore_follow_store_view"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>    
              </div>
            <?php endif;?>
          <?php  endif;?>
        <?php endif;?>
        <?php if(isset($this->socialSharingActive) && $shareType):?>
          <div class="_sharebtn">
            <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation estore_button_toggle"><i class="far fa-share-square"></i><span><?php echo $this->translate('Share');?></span></a>
            <div class="estore_listing_share_popup">
             <!-- <p><?php echo $this->translate("Share This Store");?></p> -->
              <?php if($shareType == 2):?>
                <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $store, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
              <?php endif;?>
              <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $store->getType(),'id' => $store->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="smoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="far fa-share-square"></i></a>
            </div>
          </div>
        <?php endif;?>
        <?php if(isset($this->optionMenuActive)):?>
        <div>
         <a href="javascript:void(0);" class="sesbasic_button" id="estore_cover_option_btn"><i class="fa fa-ellipsis-h"></i></a>
        </div>
        <?php endif;?>
      </div>
      <div class="_rightbtns">
        <div class="_joinbtn">
          <?php if($canJoin && isset($this->joinButtonActive)):?>
            <div class="_listbuttons_join">
              <?php if($viewerId):?>
                <?php $store = Engine_Api::_()->getItem('stores',$store->store_id);?>
                <?php  $row = $store->membership()->getRow($viewer);?>
                <?php if(null === $row):?>
                  <?php if($store->membership()->isResourceApprovalRequired()):?>
                    <?php $action = 'request';?>
                  <?php else:?>
                    <?php $action = 'join';?>
                  <?php endif;?>
                  <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'store_id' => $store->store_id),'estore_extended',true);?>" class="smoothbox sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
                <?php else:?>
                  <?php if($row->active):?>
                    <a href="javascript:void(0);" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
                  <?php else:?>
                    <a href="javascript:void(0);" id="estore_user_approval" class="sesbasic_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
                  <?php endif;?>
                <?php endif;?>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" id="estore_user_approval" class="smoothbox estore_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
              <?php endif;?>
            </div>
          <?php endif;?>
        </div>
        <?php if(isset($this->messageOwnerActive) && $viewerId != $this->store->owner_id && $viewerId):?>
          <div class="_mgsowner">
            <a href="<?php echo $this->url(array('owner_id' => $this->store->owner_id,'action'=>'contact'), 'estore_general', true); ?>" class="sessmoothbox sesbasic_button"><i class="far fa-envelope"></i><span><?php echo $this->translate('Message Owner');?></span></a>
          </div>
        <?php endif;?>
        <?php if(isset($this->addButtonActive)):?>
          <div class="_contactbtn">
            <?php echo $this->content()->renderWidget("estore.profile-action-button",array('identity'=>12312312))?>
          </div>
        <?php endif;?>
      </div>
    </div>  
  </div>
  <?php if(isset($this->optionMenuActive) && $viewerId): ?>
    <div id="estore_cover_options_wrap" style="display:none;">
      <div class="estore_cover_options estore_options_dropdown" id="estore_cover_options">
        <span class="estore_options_dropdown_arrow"></span>
        <div class="estore_options_dropdown_links">
          <?php echo $this->content()->renderWidget('estore.profile-options',array('dashboard'=>true)); ?> 
        </div>
      </div>
    </div>  
  <?php endif;?>
<script type="text/javascript">
  <?php if(isset($this->optionMenuActive)):?>
    function doResizeForButton(){
        var topPositionOfParentSpan =  sesJqueryObject("#estore_cover_option_btn").offset().top + 34;
        topPositionOfParentSpan = topPositionOfParentSpan+'px';
        var leftPositionOfParentSpan =  sesJqueryObject("#estore_cover_option_btn").offset().left - 142;
        leftPositionOfParentSpan = leftPositionOfParentSpan+'px';
        sesJqueryObject('.estore_cover_options').css('top',topPositionOfParentSpan);
        sesJqueryObject('.estore_cover_options').css('left',leftPositionOfParentSpan);
    }
    window.addEvent('load',function(){
      doResizeForButton();
    });
    sesJqueryObject(document).ready(function(){
      sesJqueryObject("<div>"+sesJqueryObject("#estore_cover_options_wrap").html()+'</div>').appendTo('body');
      sesJqueryObject('#estore_cover_options_wrap').remove();
      doResizeForButton();
    });
    sesJqueryObject(window).resize(function(){
      doResizeForButton();
    });
    sesJqueryObject(document).click(function(){
      sesJqueryObject('#estore_cover_options').removeClass('show-options');
    })
    sesJqueryObject(document).on('click','#estore_cover_option_btn', function(e){
      e.preventDefault();
      if(sesJqueryObject('#estore_cover_options').hasClass('show-options'))
        sesJqueryObject('#estore_cover_options').removeClass('show-options');
      else
        sesJqueryObject('#estore_cover_options').addClass('show-options');
      return false;
    });
  <?php endif;?>
</script>
<script type="text/javascript">
  sesJqueryObject(document).on('click','.estore_cover_mainphoto_toggle',function(){
    if(sesJqueryObject(this).hasClass('open')){
      sesJqueryObject(this).removeClass('open');
    }else{
      sesJqueryObject('.estore_cover_mainphoto_toggle').removeClass('open');
      sesJqueryObject(this).addClass('open');
    }
      return false;
  });
  sesJqueryObject(document).click(function(){
    sesJqueryObject('.estore_cover_mainphoto_toggle').removeClass('open');
  });

  sesJqueryObject(document).click(function(event){
  if(event.target.id != 'estore_dropdown_btn' && event.target.id != 'a_btn' && event.target.id != 'i_btn'){
    sesJqueryObject('#estore_dropdown_btn').find('.estore_option_box1').css('display','none');
    sesJqueryObject('#a_btn').removeClass('active');
  }
  if(event.target.id == 'change_cover_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
      if(sesJqueryObject('#estore_change_cover_op').hasClass('active'))
          sesJqueryObject('#estore_change_cover_op').removeClass('active')
      else
          sesJqueryObject('#estore_change_cover_op').addClass('active');

      sesJqueryObject('#estore_cover_option_main_id').removeClass('active');

  }else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){
    if(sesJqueryObject('#estore_cover_option_main_id').hasClass('active'))
      sesJqueryObject('#estore_cover_option_main_id').removeClass('active')
    else
      sesJqueryObject('#estore_cover_option_main_id').addClass('active');
      sesJqueryObject('#estore_change_cover_op').removeClass('active');
  }else{
    sesJqueryObject('#estore_change_cover_op').removeClass('active');
    sesJqueryObject('#estore_cover_option_main_id').removeClass('active')
  }
  if(event.target.id == 'a_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.estore_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.estore_option_box1').css('display','block');
    }
  }else if(event.target.id == 'i_btn'){
    if(sesJqueryObject('#a_btn').hasClass('active')){
      sesJqueryObject('#a_btn').removeClass('active');
      sesJqueryObject('.estore_option_box1').css('display','none');
    }
    else{
      sesJqueryObject('#a_btn').addClass('active');
      sesJqueryObject('.estore_option_box1').css('display','block');
    }
  } 
});
  sesJqueryObject(document).on('click','#coverChangeestore',function(){
    document.getElementById('uploadFileestore').click();  
  });
  sesJqueryObject(document).on('click','#photoChangeestore',function(){
    document.getElementById('uploadPhotoFileestore').click(); 
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
      sesJqueryObject('.estore_cover_mainphotoinner').append('<div id="estore_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'estore/profile/upload-photo/id/<?php echo $store->store_id ?>';
    }
    else {
      sesJqueryObject('.estore_cover_inner').append('<div id="estore_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'estore/profile/upload-cover/id/<?php echo $store->store_id ?>';
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
            sesJqueryObject('#uploadFileestore').val('');
            sesJqueryObject('#estore_cover_loading').remove();
            sesJqueryObject('#estore_cover_id').attr('src', response.file);
            sesJqueryObject('#coverChangeestore').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
            sesJqueryObject('#estore_cover_photo_reposition').css('display','block');
            sesJqueryObject('#coverRemoveestore').css('display','block');
          }
        }
    }); 
  }
  function uploadmainPhoto(response){
      sesJqueryObject('#uploadPhotoFileestore').val('');
      sesJqueryObject('#estore_cover_loading').remove();
      sesJqueryObject('#estore_photo_id').attr('src', response.file);
      sesJqueryObject('#photoChangeestore').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));
      sesJqueryObject('#photoRemoveestore').css('display','block');  
  }
  sesJqueryObject('#coverRemoveestore').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.estore_cover_inner').append('<div id="estore_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'estore/profile/remove-cover/id/<?php echo $store->store_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
          sesJqueryObject('#coverChangeestore').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
          response = sesJqueryObject.parseJSON(response);
          sesJqueryObject('#estore_cover_id').attr('src', response.file);
          sesJqueryObject('#estore_cover_photo_reposition').css('display','none');
          sesJqueryObject('#estore_cover_loading').remove();
          //silence
       }
      }); 
    });
    sesJqueryObject('#photoRemoveestore').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('.estore_cover_mainphotoinner').append('<div id="estore_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'estore/profile/remove-photo/id/<?php echo $store->store_id ?>';
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
        sesJqueryObject('#photoChangeestore').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Upload Photo'));
        response = sesJqueryObject.parseJSON(response);
        sesJqueryObject('#estore_photo_id').attr('src', response.file);
        sesJqueryObject('#estore_cover_loading').remove();
        sesJqueryObject('#photoRemoveestore').css('display','none'); 
    }
    if(sesJqueryObject('.estore_photo_update_popup').length == 0){
    sesJqueryObject('<div class="estore_photo_update_popup sesbasic_bxs" id="estore_popup_cam_upload" style="display:none"><div class="estore_photo_update_popup_overlay"></div><div class="estore_photo_update_popup_container estore_photo_update_webcam_container estore_fg_color"><div class="estore_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-times" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="estore_photo_update_popup_webcam_options"><div id="estore_camera" style="background-color:#ccc;"></div><div class="centerT estore_photo_update_popup_btns"><button class="capturePhoto" onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="estore_photo_update_popup sesbasic_bxs" id="estore_popup_existing_upload" style="display:none"><div class="estore_photo_update_popup_overlay"></div><div class="estore_photo_update_popup_container" id="estore_popup_container_existing"><div class="estore_select_photo_popup_header estore_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-times" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="estore_photo_update_popup_content"><div id="estore_existing_data"></div><div id="estore_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    }
  var contentTypeEstore;
  sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
    sesJqueryObject('#estore_popup_cam_upload').show();
    contentTypeEstore = sesJqueryObject(this).closest('.estore_cover_main_change_options').length > 0 ? 'photo' : 'cover';
    <!-- Configure a few settings and attach camera -->
    if(contentTypeEstore == 'photo') {
      sesJqueryObject('.estore_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Photo") ?>');
      sesJqueryObject('.estore_select_photo_popup_header').html('<?php echo $this->translate("Select a photo") ?>');
    }
    else {
      sesJqueryObject('.estore_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Cover Photo") ?>');
      sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Cover Photo") ?>');
      sesJqueryObject('.estore_select_photo_popup_header').html('<?php echo $this->translate("Select a Cover photo") ?>');
    }
    Webcam.set({
        width: 320,
        height: 240,
        image_format:'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#estore_camera');
  });
  function hideProfilePhotoUpload(){
    if(typeof Webcam != 'undefined')
     Webcam.reset();
    canPaginateStoreNumber = 1;
    sesJqueryObject('#estore_popup_cam_upload').hide();
    sesJqueryObject('#estore_popup_existing_upload').hide();
    if(typeof Webcam != 'undefined'){
        sesJqueryObject('.slimScrollDiv').remove();
        sesJqueryObject('.estore_photo_update_popup_content').html('<div id="estore_existing_data"></div><div id="estore_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
    }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#estore_popup_cam_upload').hide();
      // upload results
      sesJqueryObject('.estore_cover_inner').append('<div id="estore_cover_loading" class="sesbasic_loading_cont_overlay"></div>');
       Webcam.upload( data_uri, en4.core.staticBaseUrl+'estore/profile/upload-'+contentTypeEstore+'/id/<?php echo $store->store_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('#estore_cover_loading').remove();
              sesJqueryObject('#estore_'+contentTypeEstore+'_id').attr('src', response.file);
              sesJqueryObject('#'+contentTypeEstore+'Changeestore').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change '+contentTypeEstore == "cover"?"Cover":""+' Photo'));
              sesJqueryObject('#estore_'+contentTypeEstore+'_photo_reposition').css('display','block');
              sesJqueryObject('#'+contentTypeEstore+'Removeestore').css('display','block');
              
              sesJqueryObject('#estore_'+contentTypeEstore+'_id_main').attr('src', response.file);
              sesJqueryObject('#photoChangeestore_<?php echo $store->store_id; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));              sesJqueryObject('#photoRemoveestore_<?php echo $store->store_id; ?>').css('display','block');
              
          } );
    });
  }
  <?php if($this->params['show_full_width'] == 'yes'){ ?>
    sesJqueryObject(document).ready(function(){
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('estore_cover_full');
    });
  <?php } ?>
  <?php if($isStoreEdit && $canUploadCover):?>
  var previousPositionOfCover = sesJqueryObject('#estore_cover_id').css('top');
  <!-- Reposition Photo -->
  sesJqueryObject('#estore_cover_photo_reposition').click(function(){
          sesJqueryObject('.estore_cover_reposition_btn').show();
          sesJqueryObject('.estore_cover_fade').hide();
          sesJqueryObject('#estore_change_cover_op').hide();
          sesJqueryObject('.estore_cover_content').hide();
          sesJqueryUIMin('#estore_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
  });
  sesJqueryObject('#cancelreposition').click(function(){
      sesJqueryObject('.estore_cover_reposition_btn').hide();
      sesJqueryObject('#estore_cover_id').css('top',previousPositionOfCover);
      sesJqueryObject('.estore_cover_fade').show();
      sesJqueryObject('#estore_change_cover_op').show();
      sesJqueryObject('.estore_cover_content').show();
      sesJqueryUIMin("#estore_cover_id").dragncrop('destroy');
  });
  sesJqueryObject('#savereposition').click(function(){
      var sendposition = sesJqueryObject('#estore_cover_id').css('top');
      sesJqueryObject('#estore_cover_photo_loading').show();
      var uploadURL = en4.core.staticBaseUrl+'estore/profile/reposition-cover/id/<?php echo $store->store_id ?>';
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
                      sesJqueryObject('.estore_cover_reposition_btn').hide();
                      sesJqueryUIMin("#estore_cover_id").dragncrop('destroy');
                      sesJqueryObject('.estore_cover_fade').show();
                      sesJqueryObject('#estore_change_cover_op').show();
                      sesJqueryObject('.estore_cover_content').show();
                  }else{
                      alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>'); 
                  }
                      sesJqueryObject('#estore_cover_photo_loading').hide();
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
    <h1><?php echo $this->translate('Locked Store'); ?></h1>
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
    sesJqueryObject('#estore_content').hide();
    sesJqueryObject('#locked_content').show();
    swal({   
      title: "",   
      text: "<?php echo $this->translate('Enter Password For:'); ?> <?php echo $this->store->getTitle(); ?>",  
      type: "input",   
      showCancelButton: true,   
      closeOnConfirm: false,   
      animation: "slide-from-top",   
      inputPlaceholder: "<?php echo $this->translate('Enter Password'); ?>"
    }, function(inputValue){   
      if (inputValue === false) {
          sesJqueryObject('#estore_content').remove();
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
        sesJqueryObject('#estore_content').show();
        sesJqueryObject('#estore_cover_load').remove();
        setCookieEstore('<?php echo $this->store->store_id; ?>');
        if(sesJqueryObject('.estore_view_embed').find('iframe')){
          var changeiframe = true;
        }else{
        }
        sesJqueryObject('.layout_core_comments').show();
        swal.close();
        sesJqueryObject('.layout_estore_store_view_page').show();
      }else{
        swal("Wrong Password", "You wrote: " + inputValue, "error");
        sesJqueryObject('#estore_content').remove();
        sesJqueryObject('#locked_content').show();
        sesJqueryObject('.layout_core_comments').remove();
      }
      if(typeof changeiframe != 'undefined'){
        sesJqueryObject('.estore_view_embed').find('iframe').attr('src',sesJqueryObject('.estore_view_embed').find('iframe').attr('src'));
        var aspect = 16 / 9;
        var el = document.id("pageFrame<?php echo $this->store->getIdentity(); ?>");
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
      sesJqueryObject('#estore_content').show();
      sesJqueryObject('#estore_cover_load').remove();
      sesJqueryObject('.layout_core_comments').show();
      if(sesJqueryObject('.estore_view_embed').find('iframe')){
        sesJqueryObject('.estore_view_embed').find('iframe').attr('src',sesJqueryObject('.estore_view_embed').find('iframe').attr('src'));
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
