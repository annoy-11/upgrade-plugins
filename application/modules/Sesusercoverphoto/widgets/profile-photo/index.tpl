<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesusercoverphoto/externals/styles/styles.css'); ?>

<?php 
if(isset($this->canEdit)) {
// First, include the Webcam.js JavaScript Library 
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/webcam.js'); 
  }
?>
<?php if($this->widgetPlaced == 'home'){ ?>
 <h3><?php echo $this->translate('Hi %1$s!', $this->viewer()->getTitle()); ?></h3>
<?php } ?>
<input type="file" name="sesusercoverphoto_profile_upload_direct" onchange="readImageUrlCover(this)" id="sesusercoverphoto_profile_uploadcover_direct" style="display:none;"  />
<div id='profile_photo_cover' class="sesusercoverphoto_member_profile_photo sesbasic_bxs">
	<div class="sesusercoverphoto_member_photo_loading" id="sesusercoverphoto-profile-upload-loading" style="display:none;"></div>
 <?php if($this->widgetPlaced == 'home'){ ?>
  <a href="<?php echo Engine_Api::_()->user()->getViewer()->getHref(); ?>">
  <?php echo $this->itemPhoto($this->viewer()); ?>
 <?php }else{ ?>
  <?php echo $this->itemPhoto($this->subject());
  	}
   ?>
  <?php if($this->widgetPlaced == 'home'){ ?>
  	</a>
  <?php } ?>
 <?php if(isset($this->canEdit)){ ?>
  <div class="sesusercoverphoto_album_coverphoto_op" id="sesusercoverphoto_profile_change">
      <a href="javascript:;" id="profile_change_btn"><i class="fa fa-camera" id="profile_change_btn_i"></i><span id="change_profile_txt"><?php echo $this->translate("Update Profile Picture"); ?></span></a>
      <div class="sesusercoverphoto_album_coverphoto_op_box sesbasic_option_box ">
      	<i class="sesusercoverphoto_album_coverphoto_op_box_arrow"></i>
          <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
          <a id="uploadProfilePhotoCover" href="javascript:;"><i class="fa fa-plus"></i><?php echo $this->translate("Upload Photo"); ?></a>
          <a id="fromExistingAlbum" href="javascript:;"><i class="fa fa-picture-o"></i><?php echo $this->translate("Choose From Existing"); ?></a>
      </div>
    </div>
 <?php } ?>
</div>
<?php if(isset($this->canEdit)){ ?>
<script type="application/javascript">
sesJqueryObject('<div class="sesusercoverphoto_photo_update_popup sesbasic_bxs" id="sesusercoverphoto_popup_cam_upload" style="display:none"><div class="sesusercoverphoto_photo_update_popup_overlay"></div><div class="sesusercoverphoto_photo_update_popup_container sesusercoverphoto_photo_update_webcam_container"><div class="sesusercoverphoto_photo_update_popup_header"><?php echo $this->translate("Click to Take Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercoverphoto_photo_update_popup_webcam_options"><div id="sesusercoverphoto_camera" style="background-color:#ccc;"></div><div class="centerT sesusercoverphoto_photo_update_popup_btns">   <button onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesusercoverphoto_photo_update_popup sesbasic_bxs" id="sesusercoverphoto_popup_existing_upload" style="display:none"><div class="sesusercoverphoto_photo_update_popup_overlay"></div><div class="sesusercoverphoto_photo_update_popup_container" id="sesusercoverphoto_popup_container_existing"><div class="sesusercoverphoto_photo_update_popup_header"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesusercoverphoto_photo_update_popup_content"><div id="sesusercoverphoto_album_existing_data"></div><div id="sesusercoverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
var canPaginatePageNumber = 1;
function existingPhotosGet(){
	sesJqueryObject('#sesusercoverphoto_profile_existing_img').show();
	var URL = en4.core.staticBaseUrl+'sesusercoverphoto/index/existing-photos/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        page: canPaginatePageNumber,
        is_ajax: 1,
        cover: 'profile',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('sesusercoverphoto_album_existing_data').innerHTML = document.getElementById('sesusercoverphoto_album_existing_data').innerHTML + responseHTML;
      	sesJqueryObject('#sesusercoverphoto_album_existing_data').slimscroll({
					 height: 'auto',
					 alwaysVisible :true,
					 color :'#000',
					 railOpacity :'0.5',
					 disableFadeOut :true,					 
					});
					sesJqueryObject('#sesusercoverphoto_album_existing_data').slimScroll().bind('slimscroll', function(event, pos){
					 if(canPaginateExistingPhotos == '1' && pos == 'bottom' && sesJqueryObject('#sesusercoverphoto_profile_existing_img').css('display') != 'block'){
						 	sesJqueryObject('#sesusercoverphoto_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
							existingPhotosGet();
					 }
					});
					sesJqueryObject('#sesusercoverphoto_profile_existing_img').hide();
		}
    })).send();	
}
sesJqueryObject(document).on('click','a[id^="sesusercoverphoto_profile_upload_existing_photos_"]',function(event){
	event.preventDefault();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	if(!id)
		return;
	sesJqueryObject('#sesusercoverphoto-profile-upload-loading').show();
	hideProfilePhotoUpload();
	var URL = en4.core.staticBaseUrl+'sesusercoverphoto/index/upload-existingphoto/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        id: id,
        cover: 'profile',
				user_id:'<?php echo $this->user_id; ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				text = JSON.parse(responseHTML);
				if(text.status == 'true'){
					if(text.src != '')
					sesJqueryObject('#profile_photo_cover').find('.thumb_profile').attr('src',text.src);
			}
			sesJqueryObject('#sesusercoverphoto-profile-upload-loading').hide();
			}
    })).send();	
});
sesJqueryObject(document).on('click','a[id^="sesusercoverphoto_existing_album_see_more_"]',function(event){
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
        cover: 'profile',
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
sesJqueryObject(document).on('click','#fromExistingAlbum',function(){
	sesJqueryObject('#sesusercoverphoto_popup_existing_upload').show();
	existingPhotosGet();
});
sesJqueryObject(document).on('click','#uploadProfilePhotoCover',function(){
		document.getElementById('sesusercoverphoto_profile_uploadcover_direct').click();
});
function readImageUrlCover(input){
	var url = input.files[0].name;
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
		var formData = new FormData();
		formData.append('webcam', input.files[0]);
		formData.append('user_id', '<?php echo $this->user_id; ?>');
		sesJqueryObject('#sesusercoverphoto-profile-upload-loading').show();
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
    url:  en4.core.staticBaseUrl+'sesusercoverphoto/index/upload-main/',
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
			text = JSON.parse(response);
			if(text.status == 'true'){
				if(text.src != '')
				sesJqueryObject('#profile_photo_cover').find('img').attr('src',text.src);
			}
			sesJqueryObject('#sesusercoverphoto-profile-upload-loading').hide();
		}
    });
	}
}
sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
	sesJqueryObject('#sesusercoverphoto_popup_cam_upload').show();
	<!-- Configure a few settings and attach camera -->
	Webcam.set({
		width: 320,
		height: 240,
		image_format:'jpeg',
		jpeg_quality: 90
	});
	Webcam.attach('#sesusercoverphoto_camera');
});
<!-- Code to handle taking the snapshot and displaying it locally -->
function take_snapshot() {
	// take snapshot and get image data
	Webcam.snap(function(data_uri) {
		Webcam.reset();
		sesJqueryObject('#sesusercoverphoto_popup_cam_upload').hide();
		sesJqueryObject('#sesusercoverphoto-profile-upload-loading').show();
		// upload results
		
		 Webcam.upload( data_uri, en4.core.staticBaseUrl+'sesusercoverphoto/index/upload-main/user_id/<?php echo $this->user_id; ?>' , function(code, text) {
			 	text = JSON.parse(text);
				if(text.status == 'true'){
					if(text.src != '')
					sesJqueryObject('#profile_photo_cover').find('img').attr('src',text.src);
				}
				sesJqueryObject('#sesusercoverphoto-profile-upload-loading').hide();
			} );
	});
}
function hideProfilePhotoUpload(){
	if(typeof Webcam != 'undefined')
	 Webcam.reset();
	canPaginatePageNumber = 1;
	sesJqueryObject('#sesusercoverphoto_popup_cam_upload').hide();
	sesJqueryObject('#sesusercoverphoto_popup_existing_upload').hide();
	if(typeof Webcam != 'undefined'){
		sesJqueryObject('.slimScrollDiv').remove();
		sesJqueryObject('.sesusercoverphoto_photo_update_popup_content').html('<div id="sesusercoverphoto_album_existing_data"></div><div id="sesusercoverphoto_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
	}
}
sesJqueryObject(document).click(function(event){
	if(event.target.id == 'change_profile_txt' || event.target.id == 'profile_change_btn_i' || event.target.id == 'profile_change_btn'){
		if(sesJqueryObject('#sesusercoverphoto_profile_change').hasClass('active'))
			sesJqueryObject('#sesusercoverphoto_profile_change').removeClass('active')
		else
			sesJqueryObject('#sesusercoverphoto_profile_change').addClass('active')
	}else{
			sesJqueryObject('#sesusercoverphoto_profile_change').removeClass('active')
	}
});
</script>
<?php } ?>