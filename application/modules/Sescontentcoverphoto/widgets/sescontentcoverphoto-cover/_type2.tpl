<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _type2.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontentcoverphoto/externals/styles/cover_layout2.css'); ?>
<div class="sesusercover_main_container sesusercover_cover_type2 sesbasic_bxs <?php if($this->is_fullwidth){?>sescontentcoverphoto_cover_wrapper_full<?php } ?>">
  <div class="sesusercover_cover_wrapper" style="height:<?php echo $this->height; ?>px">
    <div class="sesusercover_cover_container" style="height:<?php echo $this->height; ?>px">
      <!--Cover Photo-->
      <?php 
        $contentInfo = Engine_Api::_()->sescontentcoverphoto()->isResourceExist($subject->getType(), $subject->getIdentity());
        if(isset($contentInfo->cover) && $contentInfo->cover != 0 && $contentInfo->cover != '') {
          $memberCover =	Engine_Api::_()->storage()->get($contentInfo->cover, ''); 
          if($memberCover)
            $memberCover = $memberCover->getPhotoUrl();
        } else
        $memberCover = $this->defaultCoverPhoto; 
      ?>
      <div class="sesusercover_cover_img">
        <img id="sescontentcoverphoto_cover_id" src="<?php echo $memberCover; ?>" style="top:<?php echo $contentInfo->cover_position ? $contentInfo->cover_position : '0px'; ?>;" />
      </div>
      <!--Upload/Change Cover Options-->
      <?php if($this->can_edit  && $this->canCreate){ ?>
        <div class="sescontentcoverphoto_cover_change_cover" id="sescontentcoverphoto_cover_change">
          <a href="javascript:;" id="cover_change_btn">
            <i class="fa fa-camera" id="cover_change_btn_i"></i>
            <span id="change_coverphoto_profile_txt"><?php echo $this->translate("Update Cover Photo"); ?></span>
          </a>
          <div class="sescontentcoverphoto_change_cover_options sesbasic_option_box"> 
            <i class="sescontentcoverphoto_change_cover_options_main_arrow"></i>
            <input type="file" id="uploadFilesesContentCoverPhoto" name="art_cover" onchange="readCoverPhotoImageUrl(this);" style="display:none">
            <a id="uploadCoverPhotoWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Cover Photo"); ?></a>
            <a id="fromCoverPhotoExistingAlbum" href="javascript:;"><i class="fa fa-picture-o"></i><?php echo $this->translate("Choose From Existing Albums"); ?></a>
            <a id="uploadCoverPhoto" href="javascript:;"><i class="fa fa-plus"></i><?php echo ($contentInfo->cover != 0 && $contentInfo->cover != '') ? $this->translate('Change Cover Photo') : $this->translate('Add Cover Photo');; ?></a>
            <a id="removeCover" href="<?php echo 'sescontentcoverphoto/index/confirmation/'; ?>" class="sessmoothbox" style="display:<?php echo (isset($contentInfo->cover) && $contentInfo->cover != 0 && $contentInfo->cover != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $contentInfo->cover; ?>"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Cover Photo'); ?></a>
            <a style="display:<?php echo $contentInfo->cover ? 'block !important' : 'none !important' ; ?>;" href="javascript:;" id="sescontentcoverphoto_main_photo_reposition"><i class="fa fa-arrows-alt"></i><?php echo $this->translate("Reposition"); ?></a>
          </div>
        </div>
        <div class="sescontentcoverphoto_cover_reposition_btn" style="display:none;">
          <a class="sesbasic_button" href="javascript:;" id="cancelreposition">Cancel</a>
          <a class="sesbasic_button" href="javascript:;" id="savereposition">Save</a>
        </div>
      <?php } ?>
      <div id="sescontentcoverphoto_cover_photo_loading" class="sescoverpphoto_overlay" style="display:none;"><div class="sescover_loading"><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div><div class="sescover_loading_bar"></div></div></div>
 
<!--    <div class="sesusercover_cover_labels">
    <?php //if(in_array('featuredlabel',$this->option) && $subject->featured){ ?>
      <p class="sesmember_label_featured"><?php //echo $this->translate("FEATURED");?></p>
    <?php //} ?>
    <?php //if(in_array('sponsoredLabel',$this->option) && $subject->sponsored){ ?>
      <p class="sesmember_label_sponsored"><?php //echo $this->translate("SPONSORED");?></p>
    <?php //} ?>
    <?php //if(in_array('viplabel',$this->option) && $subject->vip){ ?>
      <i class="sesmember_vip_label" title="<?php //echo $this->translate('VIP') ;?>"></i>
    <?php //} ?>
    </div>-->
    </div>
  </div>
  
  <div class="sescontentcoverphoto_cover_information_block sesbasic_clearfix">
  	<div class="sescontentcoverphoto_cover_information_block_inner sesbasic_clearfix">
      <!--Main Photo-->     
      <?php if(in_array('photo',$this->option)){ ?>
        <?php
          if(!$subject->getPhotoUrl('thumb.profile')){
            $imgurl = $typeArray['defaultPhoto'];
          } else
            $imgurl = $subject->getPhotoUrl();
            
          if($this->resource_type == 'blog') {
            $owner_id = $subject->owner_id;
            $blogUser = Engine_Api::_()->getItem('user', $owner_id);
            $imgurl = $blogUser->getPhotoUrl(); 
          }
        ?>
        <div class="sescontentcoverphoto_profile_img">
          <img src="<?php echo $imgurl ; ?>" alt="" class="thumb_profile item_photo_user sescontentcoverphoto_cover_image_main">        
          <?php if($this->can_edit && $typeArray['uploadprofilePhoto']){ ?>
            <div class="sescontentcoverphoto_cover_change_cover_main" id="sescontentcoverphoto_cover_option_main_id">
            <input type="file" id="uploadFileMainsescontentcoverphoto" name="main_photo_cvr" onchange="uploadFileMainsescontentcoverphoto(this);"  style="display:none" />
              <a href="javascript:;" id="change_main_btn">
                <i class="fa fa-camera" id="change_main_i"></i>
                <span id="change_main_txt"><?php echo $this->translate("Upload Profile Picture"); ?></span>
              </a>
              <div class="sescontentcoverphoto_change_cover_options_main sesbasic_option_box">
                <i class="sescontentcoverphoto_change_cover_options_main_arrow"></i>
                <a href="javascript:;" id="change_main_cvr_pht"><i class="fa fa-plus"></i><?php echo $photo_id  ?  $this->translate("Change Profile Photo") : $this->translate("Add Profile Photo"); ?></a>
                <a style="display:<?php echo $photo_id ? 'block !important' : 'none !important' ; ?>;" href="javascript:;" id="sescontentcoverphoto_main_photo_i"><i class="fa fa-trash"></i><?php echo $this->translate("Remove Profile Photo"); ?></a>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if(in_array('title',$this->option)){ ?>   
        <div class="sescontentcoverphoto_profile_title">
          <p>
            <?php echo $subject->getTitle(); ?>
            <?php if(in_array('verifiedLabel',$this->option) && $subject->user_verified){ ?>
              <i class="sesmember_verified_sign fa fa-check-circle" title="<?php echo $this->translate('Verified') ;?>"></i>
            <?php } ?>
          </p>
        </div>
      <?php } ?> 
      <div class="sescontentcoverphoto_cover_content sesbasic_clearfix">
        <?php include APPLICATION_PATH .  '/application/modules/Sescontentcoverphoto/widgets/sescontentcoverphoto-cover/contents/_'.$this->resource_type.'.tpl';?>
      </div>
      <?php //User Cover Photo Work ?>
        <div class="sescontentcoverphoto_cover_buttons">
           <?php include APPLICATION_PATH .  '/application/modules/Sescontentcoverphoto/views/scripts/_iconButton.tpl';?>
        </div>
      <?php //End User Cover Photo Work ?>
    </div>
  </div>
</div>
<?php if(in_array('options',$this->option)) { ?>
	<div id="sesusercover_option_data_div">
    <?php //Options widget show ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sescontentcoverphoto/views/scripts/_options.tpl';?>
  </div>
<?php } ?>


<script type="application/javascript">

sesJqueryObject('<div id="sesusercover_profile_options" class="sesuser_cover_options_pulldown sesbasic_bxs" style="display:none;"><i class="fa fa-caret-up"></i>'+sesJqueryObject('#sesusercover_option_data_div').html()+'</div>').appendTo('body');
sesJqueryObject('#sesusercover_option_data_div').remove();

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
var previousPositionOfCover = sesJqueryObject('#sescontentcoverphoto_cover_id').css('top');
<!-- Reposition Photo -->
sesJqueryObject('#sescontentcoverphoto_main_photo_reposition').click(function(){
		sesJqueryObject('.sescontentcoverphoto_cover_reposition_btn').show();
		sesJqueryObject('.sescontentcoverphoto_cover_fade').hide();
		sesJqueryObject('#sescontentcoverphoto_cover_change').hide();
		sesJqueryObject('.sescontentcoverphoto_cover_buttons').hide();
		sesJqueryUIMin('#sescontentcoverphoto_cover_id').dragncrop({instruction: true,instructionText:'<?php echo $this->translate("Drag to Reposition") ?>'});
});
sesJqueryObject('#cancelreposition').click(function(){
	sesJqueryObject('.sescontentcoverphoto_cover_reposition_btn').hide();
	sesJqueryObject('#sescontentcoverphoto_cover_id').css('top',previousPositionOfCover);
	sesJqueryObject('.sescontentcoverphoto_cover_fade').show();
	sesJqueryObject('#sescontentcoverphoto_cover_change').show();
	sesJqueryObject('.sescontentcoverphoto_cover_buttons').show();
	sesJqueryUIMin("#sescontentcoverphoto_cover_id").dragncrop('destroy');
});

sesJqueryObject('#savereposition').click(function(){
	var sendposition = sesJqueryObject('#sescontentcoverphoto_cover_id').css('top');
		sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').show();
	var uploadURL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/reposition-cover/user_id/<?php echo $user_id ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>';
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
        sesJqueryObject('.sescontentcoverphoto_cover_reposition_btn').hide();
        sesJqueryUIMin("#sescontentcoverphoto_cover_id").dragncrop('destroy');
        sesJqueryObject('.sescontentcoverphoto_cover_fade').show();
        sesJqueryObject('#sescontentcoverphoto_cover_change').show();
        sesJqueryObject('.sescontentcoverphoto_cover_buttons').show();
      }else{
        alert('<?php echo $this->translate("Something went wrong, please try again later.") ?>');	
      }
        sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').hide();
      //silence
      }
  });	
});

<!-- Upload Main User Photo Code -->
function uploadFileToServerMain(files){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sescontentcoverphoto_cover_main_photo').append('<div id="sescontentcoverphoto_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;border-radius:50%;"></div>');
	<?php }else{ ?>
		sesJqueryObject('.sescontentcoverphoto_cover_main_photo').append('<div id="sescontentcoverphoto_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
	<?php } ?>
	var formData = new FormData();
	formData.append('webcam', files);
	uploadURL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/upload-main/user_id/<?php echo $user_id ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>';
	var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			response = sesJqueryObject.parseJSON(response);
			sesJqueryObject('#uploadFileMainsescontentcoverphoto').val('');
			sesJqueryObject('#sescontentcoverphoto_cover_loading_main').remove();
			sesJqueryObject('.sescontentcoverphoto_cover_image_main').attr('src', response.src);
			sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
			sesJqueryObject('#sescontentcoverphoto_main_photo_i').css('display','block !important');
     }
    });
}

sesJqueryObject('#sescontentcoverphoto_main_photo_i').click(function(){
	<?php if($this->fullwidth){ ?>
	sesJqueryObject('.sescontentcoverphoto_cover_main_photo').append('<div id="sescontentcoverphoto_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;border-radius:50%;"></div>');
	<?php }else{ ?>
		sesJqueryObject('.sescontentcoverphoto_cover_main_photo').append('<div id="sescontentcoverphoto_cover_loading_main" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
	<?php } ?>
		var user_id = '<?php echo $user_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/remove-main/user_id/<?php echo $user_id; ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>';
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				sesJqueryObject('#change_main_cvr_pht').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add User Photo'));
				response = sesJqueryObject.parseJSON(response);
				sesJqueryObject('.sescontentcoverphoto_cover_image_main').attr('src', response.src);
				sesJqueryObject('#sescontentcoverphoto_cover_loading_main').remove();
				sesJqueryObject('#sescontentcoverphoto_main_photo_i').hide();
				//silence
			 }
			}); 
});

function uploadFileMainsescontentcoverphoto(input){	
	 var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
				uploadFileToServerMain(input.files[0]);
    }else{
				//Silence
		}

}

sesJqueryObject(document).on('click','#change_main_cvr_pht',function(){
	document.getElementById('uploadFileMainsescontentcoverphoto').click();	
});


<!-- Upload Cover Photo Code -->
sesJqueryObject('<div class="sescontentcoverphoto_photo_update_popup sesbasic_bxs" id="coverphoto_popup_cam_upload" style="display:none"><div class="sescontentcoverphoto_photo_update_popup_overlay"></div><div class="sescontentcoverphoto_photo_update_popup_container sescontentcoverphoto_photo_update_webcam_container"><div class="sescontentcoverphoto_photo_update_popup_header sesbm"><?php echo $this->translate("Click to Take Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontentcoverphoto_photo_update_popup_webcam_options"><div id="coverphoto_camera" style="background-color:#ccc;"></div><div class="centerT sescontentcoverphoto_photo_update_popup_btns">   <button onclick="take_coverphotosnapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Photo") ?></button><button onclick="hideCoverPhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sescontentcoverphoto_photo_update_popup sesbasic_bxs" id="coverphoto_popup_existing_upload" style="display:none"><div class="sescontentcoverphoto_photo_update_popup_overlay"></div><div class="sescontentcoverphoto_photo_update_popup_container" id="coverphoto_popup_container_existing"><div class="sescontentcoverphoto_photo_update_popup_header sesbm"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideCoverPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontentcoverphoto_photo_update_popup_content"><div id="coverphoto_existing_data"></div><div id="coverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
sesJqueryObject(document).on('click','#uploadCoverPhoto',function(){
		document.getElementById('uploadFilesesContentCoverPhoto').click();
});
function readCoverPhotoImageUrl(input){
	var url = input.files[0].name;
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
		var formData = new FormData();
		formData.append('webcam', input.files[0]);
		formData.append('user_id', '<?php echo $user_id; ?>');
		sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').show();
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
    url:  en4.core.staticBaseUrl+'sescontentcoverphoto/index/edit-coverphoto/user_id/<?php echo $user_id; ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>',
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			text = JSON.parse(response);
			if(text.status == 'true'){
				if(text.src != '')
				sesJqueryObject('#sescontentcoverphoto_cover_id').attr('src',  text.src );
				sesJqueryObject('#sescontentcoverphoto_cover_default').hide();
				sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
				sesJqueryObject('#removeCover').css('display','block');
				sesJqueryObject('#sescontentcoverphoto_main_photo_reposition').css('display','block');
			}
			sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').hide();
				sesJqueryObject('#uploadFilesesContentCoverPhoto').val('');
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
		sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').show();
		// upload results
		 Webcam.upload( data_uri, en4.core.staticBaseUrl+'sescontentcoverphoto/index/edit-coverphoto/user_id/<?php echo $user_id; ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>' , function(code, text) {
			 	text = JSON.parse(text);
				if(text.status == 'true'){
					if(text.src != ''){
						sesJqueryObject('#sescontentcoverphoto_cover_id').attr('src',  text.src );;
						sesJqueryObject('#sescontentcoverphoto_cover_default').hide();
						sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
						sesJqueryObject('#removeCover').css('display','block');
						sesJqueryObject('#sescontentcoverphoto_main_photo_reposition').css('display','block');
					}
				}
				sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').hide();
			} );
	});
}
function removeCoverPhoto(){
		sesJqueryObject('#removeCover').css('display','none');
		//sesJqueryObject('#sescontentcoverphoto_cover_id').attr('src',  '' );
		sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').show();
		sesJqueryObject('#sescontentcoverphoto_cover_default').show();
		var user_id = '<?php echo $user_id; ?>';
		uploadURL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/remove-cover/user_id/<?php echo $user_id; ?>/resource_type/<?php echo $this->resource_type; ?>/resource_id/<?php echo $this->resource_id; ?>';
		var jqXHR=sesJqueryObject.ajax({
			url: uploadURL,
			type: "POST",
			contentType:false,
			processData: false,
			cache: false,
			success: function(response){
				var response = sesJqueryObject.parseJSON(response);
				sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').hide();
				sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Add Cover Photo'));
				sesJqueryObject('#sescontentcoverphoto_main_photo_reposition').css('display','none');
				sesJqueryObject('#sescontentcoverphoto_cover_id').css('top','0');
				//update defaultphoto if available from admin.
				if(response.src)
					sesJqueryObject('#sescontentcoverphoto_cover_id').attr('src',response.src);
			 }
			}); 
}
function hideCoverPhotoUpload(){
	if(typeof Webcam != 'undefined')
	 Webcam.reset();
	canPaginatePageNumber = 1;
	sesJqueryObject('#coverphoto_popup_cam_upload').hide();
	sesJqueryObject('#coverphoto_popup_existing_upload').hide();
	if(typeof Webcam != 'undefined'){
		sesJqueryObject('.slimScrollDiv').remove();
		sesJqueryObject('.sescontentcoverphoto_photo_update_popup_content').html('<div id="coverphoto_existing_data"></div><div id="coverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
	}
}
sesJqueryObject(document).click(function(event){
	if(event.target.id == 'change_coverphoto_profile_txt' || event.target.id == 'cover_change_btn_i' || event.target.id == 'cover_change_btn'){
		sesJqueryObject('#sescontentcoverphoto_cover_option_main_id').removeClass('active')
		if(sesJqueryObject('#sescontentcoverphoto_cover_change').hasClass('active'))
			sesJqueryObject('#sescontentcoverphoto_cover_change').removeClass('active');
		else
			sesJqueryObject('#sescontentcoverphoto_cover_change').addClass('active');
	}else if(event.target.id == 'change_main_txt' || event.target.id == 'change_main_btn' || event.target.id == 'change_main_i'){console.log('tyes');
		sesJqueryObject('#sescontentcoverphoto_cover_change').removeClass('active');		
		if(sesJqueryObject('#sescontentcoverphoto_cover_option_main_id').hasClass('active'))
			sesJqueryObject('#sescontentcoverphoto_cover_option_main_id').removeClass('active');
		else
			sesJqueryObject('#sescontentcoverphoto_cover_option_main_id').addClass('active');
			
	}else{
			sesJqueryObject('#sescontentcoverphoto_cover_change').removeClass('active')
			sesJqueryObject('#sescontentcoverphoto_cover_option_main_id').removeClass('active')
	}
});



sesJqueryObject(document).on('click','#fromCoverPhotoExistingAlbum',function(){
	sesJqueryObject('#coverphoto_popup_existing_upload').show();
	existingCoverPhotosGet();
});
var canPaginatePageNumber = 1;
function existingCoverPhotosGet(){
	sesJqueryObject('#coverphoto_profile_existing_img').show();
	var URL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/existing-photos/';
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

sesJqueryObject(document).on('click','a[id^="sescontentcoverphoto_cover_existing_album_see_more_"]',function(event){
	event.preventDefault();
	var thatObject = this;
	sesJqueryObject(thatObject).parent().hide();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	var pageNum = parseInt(sesJqueryObject(this).attr('data-src'),10);
	sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_loading_'+id).show();
	if(pageNum == 0){
		sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_page_'+id).remove();
		return;
	}
	var URL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/existing-albumphotos/';
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
				document.getElementById('sescontentcoverphoto_photo_content_'+id).innerHTML = document.getElementById('sescontentcoverphoto_photo_content_'+id).innerHTML + responseHTML;
				var dataSrc = sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_page_'+id).html();
      	sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_'+id).attr('data-src',dataSrc);
				sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_page_'+id).remove();
				if(dataSrc == 0)
					sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_'+id).parent().remove();
				else
					sesJqueryObject(thatObject).parent().show();
				sesJqueryObject('#sescontentcoverphoto_existing_album_see_more_loading_'+id).hide();
		}
    })).send();	
});

sesJqueryObject(document).on('click','a[id^="sescontentcoverphoto_cover_upload_existing_photos_"]',function(event){
	event.preventDefault();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	if(!id)
		return;
  sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').show();
	hideCoverPhotoUpload();
	var URL = en4.core.staticBaseUrl+'sescontentcoverphoto/index/uploadexistingcoverphoto/';
	(new Request.HTML({
    method: 'post',
    'url': URL ,
    'data': {
      format: 'html',
      id: id,
      cover: 'cover',
      user_id:'<?php echo $user_id; ?>',
      resource_type: '<?php echo $this->resource_type; ?>',
      resource_id: '<?php echo $this->resource_id ?>'
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      text = JSON.parse(responseHTML);
      if(text.status == 'true'){
            
        if(text.src != '')
          sesJqueryObject('#sescontentcoverphoto_cover_id').attr('src',  text.src );
          sesJqueryObject('#sescontentcoverphoto_cover_default').hide();
          sesJqueryObject('#uploadCoverPhoto').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Cover Photo'));
          sesJqueryObject('#removeCover').css('display','block');
          sesJqueryObject('#sescontentcoverphoto_main_photo_reposition').css('display','block');
      }
      sesJqueryObject('#sescontentcoverphoto_cover_photo_loading').hide();
      sesJqueryObject('#uploadFilesesContentCoverPhoto').val('');
    }
  })).send();	
});
</script>
<?php } ?>
