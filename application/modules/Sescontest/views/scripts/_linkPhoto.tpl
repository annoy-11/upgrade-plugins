<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _linkPhoto.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseURL = Zend_Registry::get('StaticBaseUrl');?>
 <?php if ($baseURL):?>
   <?php  $baseurl = $baseURL;?>
<?php else:?>
  <?php $baseurl = '/';?>
<?php endif;?>
<?php $redirect_uri = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/sesrecord.php'.'?media_type=image';?>
<script type="text/javascript">
  en4.core.runonce.add(function() {
   sesJqueryObject('<div class="sescontest_photo_update_popup sesbasic_bxs" id="sescontest_popup_existing_upload" style="display:none"><div class="sescontest_photo_update_popup_overlay"></div><div class="sescontest_photo_update_popup_container" id="sescontest_popup_container_existing"><div class="sescontest_photo_update_popup_header"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideContentPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontest_photo_update_popup_content"><div id="sescontest_album_existing_data"></div><div id="sescontest_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    sesJqueryObject(document).on('click','#sescontest_content_link',function(){
           if($('photouploader-wrapper'))
	$('photouploader-wrapper').style.display = 'none';
        sesJqueryObject('#sescontest_content_link').addClass('active');
        sesJqueryObject('#uploadWebCamPhoto').removeClass('active');
        sesJqueryObject('#uploadimage').removeClass('active');
        sesJqueryObject('#sescontest_from_url').removeClass('active');
        sesJqueryObject('#audovideo-record').hide();
        sesJqueryObject('#removeimage-wrapper').hide();
        sesJqueryObject('#fromurl-wrapper').hide();
        sesJqueryObject('#remove_fromurl_image-wrapper').hide();
        sesJqueryObject('#contest_url_photo_preview-wrapper').hide();
	    $('contest_main_photo_preview-wrapper').style.display = 'none';
        if(sesJqueryObject('#sescontest_link_id').val() != '') {
          $('remove_link_image-wrapper').style.display = 'block';
          sesJqueryObject('#removelinkimage').show();
        }
        if($('contest_link_photo_preview'))
	     $('contest_link_photo_preview-wrapper').style.display = 'block';
       $('contest_link_photo_preview').style.display = 'block';
       sesJqueryObject('#uploaded_content_type').val(3);
    });
    sesJqueryObject(document).on('click','#contest_link_photo_preview',function(e){
        e.preventDefault();
        sesJqueryObject('#sescontest_popup_existing_upload').show();
        existingMyPhotosGet();
    });
  });
      var canPaginatePageNumber = 1;
function existingMyPhotosGet(){
	sesJqueryObject('#sescontest_profile_existing_img').show();
	var URL = en4.core.baseUrl+'sescontest/join/existing-photos/contest_id/'+"<?php echo $this->contest_id;?>";
	(new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
        format: 'html',
        page: canPaginatePageNumber,
        is_ajax: 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('sescontest_album_existing_data').innerHTML = document.getElementById('sescontest_album_existing_data').innerHTML + responseHTML;
      	sesJqueryObject('#sescontest_album_existing_data').slimscroll({
					 height: 'auto',
					 alwaysVisible :true,
					 color :'#000',
					 railOpacity :'0.5',
					 disableFadeOut :true,					 
					});
					sesJqueryObject('#sescontest_album_existing_data').slimScroll().bind('slimscroll', function(event, pos){
					 if(canPaginateExistingPhotos == '1' && pos == 'bottom' && sesJqueryObject('#sescontest_profile_existing_img').css('display') != 'block'){
						 	sesJqueryObject('#sescontest_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
							existingMyPhotosGet();
					 }
					});
					sesJqueryObject('#sescontest_profile_existing_img').hide();
		}
    })).send();	
}
  sesJqueryObject(document).on('click','a[id^="sescontest_profile_upload_existing_photos_"]',function(event){
	event.preventDefault();
	var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
	if(!id)
      return;
    var src = sesJqueryObject('#sescontest_profile_upload_existing_photos_'+id).find('span').css('background-image');
    src = src.replace('url("','');
    src = src.replace('")','');
    $('contest_link_photo_preview').style.display = 'block';
	$('contest_link_photo_preview-wrapper').style.display = 'block';
	$('contest_link_photo_preview').src = src;
    sesJqueryObject('#sescontest_link_id').val(id);
    $('remove_link_image-wrapper').style.display = 'block';
    sesJqueryObject('#removelinkimage').show();
    resetPhotoData();
    removeImage();
    removeFromurlImage();
    hideContentPhotoUpload();
});

  function hideContentPhotoUpload(){
	canPaginatePageNumber = 1;
    sesJqueryObject('#sescontest_album_existing_data').html('');
	sesJqueryObject('#sescontest_popup_existing_upload').hide();
}
  function resetPhotoData() {
    document.getElementById("audovideo-record").src = "<?php echo $redirect_uri;?>";
    return false;
  }
</script>
