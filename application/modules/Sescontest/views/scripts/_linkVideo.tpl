<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _linkVideo.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
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
   sesJqueryObject('<div class="sescontest_photo_update_popup sesbasic_bxs" id="sescontest_popup_existing_upload" style="display:none"><div class="sescontest_photo_update_popup_overlay"></div><div class="sescontest_photo_update_popup_container" id="sescontest_popup_container_existing"><div class="sescontest_photo_update_popup_header"><?php echo $this->translate("Select a Video") ?><a class="fa fa-close" href="javascript:;" onclick="hideContentVideoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sescontest_photo_update_popup_content"><div id="sescontest_album_existing_data"></div><div id="sescontest_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
    sesJqueryObject(document).on('click','#sescontest_video_link',function(){
           if($('photouploader-wrapper'))
	$('photouploader-wrapper').style.display = 'none';
        $('contest_link_video_preview-wrapper').style.display = 'block';
        sesJqueryObject('#sescontest_video_link').addClass('active');
        sesJqueryObject('#uploadWebCamVideo').removeClass('active');
        sesJqueryObject('#uploadvideo').removeClass('active');
        sesJqueryObject('#audovideo-record').hide();
        sesJqueryObject('#demo-fallback').hide();
        sesJqueryObject('#removeimage-wrapper').hide();
        if(sesJqueryObject('#contest_link_video_preview-wrapper').find('iframe').length > 0)
          sesJqueryObject('#remove_link_video-wrapper').show();
         
	     //$('contest_main_photo_preview-wrapper').style.display = 'none';
       
        if($('contest_link_photo_preview'))
	     $('contest_link_photo_preview-wrapper').style.display = 'block';
     //  $('contest_link_photo_preview').style.display = 'block';
       sesJqueryObject('#uploaded_content_type').val(3);
    });
    sesJqueryObject(document).on('click','#contest_link_video_preview-element',function(e){
        e.preventDefault();
        sesJqueryObject('#sescontest_popup_existing_upload').show();
        existingMyVideosGet();
    });
  });
      var canPaginatePageNumber = 1;
function existingMyVideosGet(){
	sesJqueryObject('#sescontest_profile_existing_img').show();
	var URL = en4.core.baseUrl+'sescontest/join/existing-videos/contest_id/'+"<?php echo $this->contest_id;?>";
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
    var videoCode = sesJqueryObject('#sescontest_thumb_'+id).find('div').html();
    videoCode = videoCode.replace('[sesframe',' <iframe');
    videoCode = videoCode.replace('[/sesframe]','</iframe>');
    videoCode = videoCode.replace('[script','<script');
    videoCode = videoCode.replace('[/script',' </script');
    videoCode = videoCode.replace(']','>');
   
	$('contest_link_video_preview-wrapper').style.display = 'block';
	sesJqueryObject('#contest_link_video_preview-wrapper').html(videoCode);
    sesJqueryObject('#sescontest_link_id').val(id);
    sesJqueryObject('#removelinkvideo').show();
    sesJqueryObject('#remove_link_video-wrapper').show();
    resetVideoData();
    sesJqueryObject('#sescontest_video_file').val('');
    hideContentVideoUpload();
});

function removeLinkVideo() {
	$('remove_link_video-wrapper').style.display = 'none';
	sesJqueryObject('#contest_link_video_preview-wrapper').html('<div id="contest_link_video_preview-label" class="form-label">&nbsp;</div><div id="contest_link_video_preview-element" class="form-element">'+en4.core.language.translate('Select Your Video')+'</div>');
    
    sesJqueryObject('#sescontest_link_id').val('');
    sesJqueryObject('#sescontest_url_id').val('');
}

  function hideContentVideoUpload(){
	canPaginatePageNumber = 1;
    sesJqueryObject('#sescontest_album_existing_data').html('');
	sesJqueryObject('#sescontest_popup_existing_upload').hide();
}
</script>
