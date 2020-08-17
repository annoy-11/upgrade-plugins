<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _uploadPhoto.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
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
<iframe id="audovideo-record" src="<?php echo $redirect_uri;?>" style="display:none;"></iframe>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    var photoType = 1;
    sesJqueryObject('#uploadWebCamPhoto').click(function(e){
      sesJqueryObject('#fromurl-wrapper').hide();
      sesJqueryObject('#dragandrophandlerbackground').hide();
      sesJqueryObject('#contest_main_photo_preview').hide();
      sesJqueryObject('#contest_link_photo_preview').hide();
      sesJqueryObject('#fromurl-wrapper').hide();
      sesJqueryObject('#remove_fromurl_image-wrapper').hide();
      sesJqueryObject('#contest_url_photo_preview-wrapper').hide();
      sesJqueryObject('#removeimage-wrapper').hide();
      sesJqueryObject('#audovideo-record').show();
      sesJqueryObject('#uploadimage').removeClass('active');
      sesJqueryObject('#uploadWebCamPhoto').addClass('active');
      sesJqueryObject('#sescontest_content_link').removeClass('active');
      sesJqueryObject('#sescontest_from_url').removeClass('active');
      sesJqueryObject('#remove_link_image-wrapper').hide();
      photoType = 2;
      sesJqueryObject('#uploaded_content_type').val(photoType);
    });
    sesJqueryObject('#sescontest_from_url').click(function(e){
      sesJqueryObject('#dragandrophandlerbackground').hide();
      sesJqueryObject('#contest_main_photo_preview-wrapper').hide();
      sesJqueryObject('#contest_main_photo_preview').hide();
      sesJqueryObject('#contest_link_photo_preview').hide();
      sesJqueryObject('#removeimage-wrapper').hide();
      if(sesJqueryObject('#contest_url_photo_preview').attr('src') == '') {
        sesJqueryObject('#fromurl-wrapper').show();
      }
      else {
        $('contest_url_photo_preview-wrapper').style.display = 'block';
        $('remove_fromurl_image-wrapper').style.display = 'block';
      }
      sesJqueryObject('#uploadimage').removeClass('active');
      sesJqueryObject('#sescontest_from_url').addClass('active');
      sesJqueryObject('#sescontest_content_link').removeClass('active');
      sesJqueryObject('#uploadWebCamPhoto').removeClass('active');
      sesJqueryObject('#remove_link_image-wrapper').hide();
      sesJqueryObject('#audovideo-record').hide();
      photoType = 4;
      sesJqueryObject('#uploaded_content_type').val(photoType);
    });
   sesJqueryObject('#uploadimage').click(function(e){
    sesJqueryObject('#contest_link_photo_preview').hide();
    sesJqueryObject('#fromurl-wrapper').hide();
    sesJqueryObject('#remove_fromurl_image-wrapper').hide();
    sesJqueryObject('#contest_url_photo_preview-wrapper').hide();
    if($('photouploader-wrapper'))
	$('photouploader-wrapper').style.display = 'block';
    sesJqueryObject('#dragandrophandlerbackground').show();
    if(sesJqueryObject('#contest_main_photo_preview').attr('src') != '') {
      sesJqueryObject('#contest_main_photo_preview').show();
      sesJqueryObject('#contest_main_photo_preview-wrapper').show();
      sesJqueryObject('#removeimage-wrapper').show();
      sesJqueryObject('#remove_link_image-wrapper').show();
    }
    else {
      sesJqueryObject('#contest_main_photo_preview').hide();
      sesJqueryObject('#contest_main_photo_preview-wrapper').hide();
      sesJqueryObject('#removeimage-wrapper').hide();
      sesJqueryObject('#remove_link_image-wrapper').hide();
    }
    if($('contest_link_photo_preview'))
	$('contest_link_photo_preview-wrapper').style.display = 'none';
    sesJqueryObject('#uploadimage').addClass('active');
    sesJqueryObject('#sescontest_content_link').removeClass('active');
    sesJqueryObject('#uploadWebCamPhoto').removeClass('active');
    sesJqueryObject('#sescontest_from_url').removeClass('active');
    sesJqueryObject('#audovideo-record').hide();
    photoType = 1;
    sesJqueryObject('#uploaded_content_type').val(photoType);
   });
  });
      
  function resetPhotoData() {
    document.getElementById("audovideo-record").src = "<?php echo $redirect_uri;?>";
    return false;
  }
  sesJqueryObject(document).on('click','#upload_from_url',function(e){
	e.preventDefault();
    var img = new Image();
    var url = sesJqueryObject('#from_url_upload').val();
    sesJqueryObject(img).load(function () {
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
        $('contest_url_photo_preview').style.display = 'block';
        $('contest_url_photo_preview-wrapper').style.display = 'block';
        $('contest_url_photo_preview').src = url;
        sesJqueryObject('#sescontest_url_id').val(url);
        $('remove_fromurl_image-wrapper').style.display = 'block';
        $('removefromurlimage').style.display = 'block';
        $('from_url_upload').value = '';
        $('fromurl-wrapper').style.display = 'none';
        resetPhotoData();
        removeImage(); 
        removeLinkImage();
      }
    })
    // if there was an error loading the image, react accordingly
    .error(function () {
      alert('Image Does Not Exist !');
    })
    // *finally*, set the src attribute of the new image to our image
    .attr('src', url);
});
</script>
