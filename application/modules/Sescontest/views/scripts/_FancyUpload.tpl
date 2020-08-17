<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _fancyUpload.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $baseURL = Zend_Registry::get('StaticBaseUrl');?>
 <?php if ($baseURL):?>
   <?php  $baseurl = $baseURL;?>
<?php else:?>
  <?php $baseurl = '/';?>
<?php endif;?>
<?php $uploadSize = str_replace('M','',ini_get('upload_max_filesize'));?>
<?php $redirect_uri = ( isset($_SERVER["HTTPS"]) && (strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . '/sesrecord.php'.'?media_type=video';?>
<iframe id="audovideo-record" src="<?php echo $redirect_uri;?>" style="display:none;"></iframe>

<script type="text/javascript">
  var videoType = 1;
  en4.core.runonce.add(function() {
    sesJqueryObject('#uploadWebCamVideo').click(function(e){
      sesJqueryObject('#demo-fallback').hide();
      sesJqueryObject('#audovideo-record').show();
      if($('contest_link_video_preview-wrapper'))
      $('contest_link_video_preview-wrapper').style.display = 'none';
      if($('remove_link_video-wrapper'))
      $('remove_link_video-wrapper').style.display = 'none';
      sesJqueryObject('#uploadvideo').removeClass('active');
      if(sesJqueryObject('#sescontest_video_link').length > 0)
      sesJqueryObject('#sescontest_video_link').removeClass('active');
      sesJqueryObject('#uploadWebCamVideo').addClass('active');
      videoType = 2;
      sesJqueryObject('#uploaded_content_type').val(videoType);
    });
    sesJqueryObject('#uploadvideo').click(function(e){
     sesJqueryObject('#demo-fallback').show();
     sesJqueryObject('#uploadvideo').addClass('active');
     sesJqueryObject('#uploadWebCamVideo').removeClass('active');
     if(sesJqueryObject('#sescontest_video_link').length > 0)
      sesJqueryObject('#sescontest_video_link').removeClass('active');
     sesJqueryObject('#audovideo-record').hide();
     $('contest_link_video_preview-wrapper').style.display = 'none';
     $('remove_link_video-wrapper').style.display = 'none';
     videoType = 1;
     sesJqueryObject('#uploaded_content_type').val(videoType);
    });
  });
  function resetFullVideoData(obj) {
     if("<?php echo $uploadSize ;?>" < obj.files[0].size/1024/1024) {
      alert(en4.core.language.translate('Video you are selecting is exceeding the size. You can upload the video of max size') +"<?php echo $uploadSize ;?>"+" MB");
      sesJqueryObject('#sescontest_video_file').val('');
    }
    else {
      var fieldValue = sesJqueryObject('#sescontest_video_file').val();
      var fileExt = fieldValue.split('.').pop();
      if(fileExt != 'mp4' && fileExt != 'flv') {
        sesJqueryObject('#sescontest_video_file').val('');
        alert(en4.core.language.translate('You can upload video only from here of mp4 and flv type extension.'));
      }
    }
    document.getElementById("audovideo-record").src = "<?php echo $redirect_uri;?>";
    if(sesJqueryObject('#contest_link_video_preview-wrapper').find('iframe').length > 0) {
      $('remove_link_video-wrapper').style.display = 'none';
      sesJqueryObject('#contest_link_video_preview-wrapper').html('<div id="contest_link_video_preview-label" class="form-label">&nbsp;</div><div id="contest_link_video_preview-element" class="form-element">'+en4.core.language.translate('Select Your Video')+'</div>');
    }
    return false;
  }
 function resetVideoData() {
    document.getElementById("audovideo-record").src = "<?php echo $redirect_uri;?>";
    return false;
  }
    function resetLinkData() {
    if(sesJqueryObject('#contest_link_video_preview-wrapper').find('iframe').length > 0) {
      $('remove_link_video-wrapper').style.display = 'none';
      sesJqueryObject('#contest_link_video_preview-wrapper').html('<div id="contest_link_video_preview-label" class="form-label">&nbsp;</div><div id="contest_link_video_preview-element" class="form-element">'+en4.core.language.translate('Select Your Video')+'</div>');
      return false;
    }
  }
</script>
<?php $ffmpeg_path = Engine_Api::_()->getApi('settings', 'core')->sescontest_ffmpeg_path;?>
<?php $checkFfmpeg = Engine_Api::_()->sescontest()->checkFfmpeg($ffmpeg_path);?>
<fieldset id="demo-fallback">
  <label for="demo-photoupload">
    <?php echo $this->translate('Upload a Video:');?>
    <input type="file" id="sescontest_video_file" name="Filedata" accept="video/*" onchange="resetFullVideoData(this);"/>
  </label>
  <?php if(!$ffmpeg_path || !$checkFfmpeg):?>
    <div class="sescontest_video_message">
      <p><b><?php echo $this->translate('Note: ');?></b><?php echo $this->translate('From here you can upload only mp4 and flv type video');?></p>
    </div>
  <?php endif;?>
</fieldset>


