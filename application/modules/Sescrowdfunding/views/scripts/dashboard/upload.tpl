<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: upload.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(!$this->is_ajax) { ?>
  <?php
  echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array(
  'crowdfunding' => $this->crowdfunding,
  ));	
  ?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>

<div class="sescrowdfunding_dashboard_form crowdfunding_dashboard_photo_upload">
	<?php echo $this->form->render($this) ?>
</div>
<?php if(!$this->is_ajax){ ?>
  	</div>
  </div>
</div>
<?php } ?>
<script type="application/javascript">
sesJqueryObject('<div class="sesalbum_photo_update_popup sesbasic_bxs" id="sesalbum_popup_cam_upload" style="display:none"><div class="sesalbum_photo_update_popup_overlay"></div><div class="sesalbum_photo_update_popup_container sesalbum_photo_update_webcam_container"><div class="sesalbum_photo_update_popup_header"><?php echo $this->translate("Click to Take Photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesalbum_photo_update_popup_webcam_options"><div id="sesalbum_camera" style="background-color:#ccc;"></div><div class="centerT sesalbum_photo_update_popup_btns">   <button onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesalbum_photo_update_popup sesbasic_bxs" id="sesalbum_popup_existing_upload" style="display:none"><div class="sesalbum_photo_update_popup_overlay"></div><div class="sesalbum_photo_update_popup_container" id="sesalbum_popup_container_existing"><div class="sesalbum_photo_update_popup_header"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesalbum_photo_update_popup_content"><div id="sesalbum_album_existing_data"></div><div id="sesalbum_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div><div class="option_container sesalbum_photo_update_popup_buttons" style="display:none"><a href="javascript:;" class="select_img_upload button">Select Image</a> or <a href="javascript:;" onclick="hideProfilePhotoUpload();">Close</a></div></div></div></div>').appendTo('body');
sesJqueryObject(document).on('click','.select_img_upload',function(e){
	var allselectedimage = sesJqueryObject('.selected_album_photo');
	for(var i = 0; i < allselectedimage.length; i++){
			var title = sesJqueryObject(allselectedimage[i]).find('div').html();
			var id = sesJqueryObject(allselectedimage[i]).attr('id').match(/\d+/)[0];
			sesJqueryObject('#demo-list').show();
			var html = '<li class="file file-success"><span class="file-size"></span><a class="file-remove file-remove-selected" href="#" data-src="'+id+'" title="Click to remove this entry.">Remove</a><span class="file-name">'+title+'</span><span class="file-info"><span>Upload complete.</span></span></li>';
			sesJqueryObject('#demo-list').append(html);
			sesJqueryObject('#selected_photo_id').val(sesJqueryObject('#selected_photo_id').val()+' '+id+' ');
			sesJqueryObject(allselectedimage[i]).removeClass('selected_album_photo');
	}
		hideProfilePhotoUpload();
		sesJqueryObject('#submit-wrapper').show();
});
sesJqueryObject(document).on('click','.file-remove-selected',function(e){
	e.preventDefault();
	sesJqueryObject('#selected_photo_id').val(sesJqueryObject('#selected_photo_id').val().replace(sesJqueryObject(this).attr('data-src')+' ',""));
	sesJqueryObject(this).parent().remove();
});
var canPaginatePageNumber = 1;
function existingPhotosGet(){
	sesJqueryObject('#sesalbum_profile_existing_img').show();
	var URL = en4.core.staticBaseUrl+'sescrowdfunding/index/existing-photos/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        page: canPaginatePageNumber,
        is_ajax: 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('sesalbum_album_existing_data').innerHTML = document.getElementById('sesalbum_album_existing_data').innerHTML + responseHTML;
				sesJqueryObject('.option_container').show();
      	sesJqueryObject('#sesalbum_album_existing_data').slimscroll({
					 height: 'auto',
					 alwaysVisible :true,
					 color :'#000',
					 railOpacity :'0.5',
					 disableFadeOut :true,					 
					});
					sesJqueryObject('#sesalbum_album_existing_data').slimScroll().bind('slimscroll', function(event, pos){
					 if(canPaginateExistingPhotos == '1' && pos == 'bottom' && sesJqueryObject('#sesalbum_profile_existing_img').css('display') != 'block'){
						 	sesJqueryObject('#sesalbum_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
							existingPhotosGet();
					 }
					});
					sesJqueryObject('#sesalbum_profile_existing_img').hide();
		}
    })).send();	
}
sesJqueryObject(document).on('click','a[id^="sesalbum_profile_upload_existing_photos_"]',function(event){
	event.preventDefault();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	if(!id)
		return;
	if(!sesJqueryObject(this).hasClass('selected_album_photo'))
		sesJqueryObject(this).addClass('selected_album_photo');
	else
		sesJqueryObject(this).removeClass('selected_album_photo');
});
sesJqueryObject(document).on('click','a[id^="sesalbum_existing_album_see_more_"]',function(event){
	event.preventDefault();
	var thatObject = this;
	sesJqueryObject(thatObject).parent().hide();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	var pageNum = parseInt(sesJqueryObject(this).attr('data-src'),10);
	sesJqueryObject('#sesalbum_existing_album_see_more_loading_'+id).show();
	if(pageNum == 0){
		sesJqueryObject('#sesalbum_existing_album_see_more_page_'+id).remove();
		return;
	}
	var URL = en4.core.staticBaseUrl+'sescrowdfunding/index/existing-albumphotos/';
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        page: pageNum+1,
        id: id,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('sesalbum_photo_content_'+id).innerHTML = document.getElementById('sesalbum_photo_content_'+id).innerHTML + responseHTML;
				var dataSrc = sesJqueryObject('#sesalbum_existing_album_see_more_page_'+id).html();
      	sesJqueryObject('#sesalbum_existing_album_see_more_'+id).attr('data-src',dataSrc);
				sesJqueryObject('#sesalbum_existing_album_see_more_page_'+id).remove();
				if(dataSrc == 0)
					sesJqueryObject('#sesalbum_existing_album_see_more_'+id).parent().remove();
				else
					sesJqueryObject(thatObject).parent().show();
				sesJqueryObject('#sesalbum_existing_album_see_more_loading_'+id).hide();
		}
    })).send();	
});
sesJqueryObject(document).on('click','#get-album-photo-sescrowdfunding',function(){
	sesJqueryObject('#sesalbum_popup_existing_upload').show();
	if(canPaginatePageNumber == 1)
	existingPhotosGet();
});
function hideProfilePhotoUpload(){
	sesJqueryObject('#sesalbum_popup_cam_upload').hide();
	sesJqueryObject('#sesalbum_popup_existing_upload').hide();
}
</script>
