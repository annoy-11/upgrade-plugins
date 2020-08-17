<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeSeseventVideo.tpl 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php  if (Engine_Api::_()->core()->hasSubject('sesevent_event')):
				 $subject = Engine_Api::_()->core()->getSubject();
			  else:
        	return;
			 endif; 
?>
<style type="text/css">
/*REMOVE SE VIDEO COMPOSER FROM FEED */
#compose-video-menu span,
#compose-video-activator
{
 display: none !important;
}
</style>       
<?php
       //CHECK PRIVACY
       $viewer = Engine_Api::_()->user()->getViewer();
       if(!Engine_Api::_()->authorization()->isAllowed('sesevent_event', $viewer, 'event_video') || !$subject->authorization()->isAllowed(null, 'video') )
       		return;
?>
<?php
   $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seseventvideo/externals/scripts/composer_video.js');

  $allowed = 0;
  $user = Engine_Api::_()->user()->getViewer();
  $is_allowed_option = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('seseventvideo_video', $user, 'video_upload_option');
	$youtube = (bool) in_array('youtube',$is_allowed_option) ? 1 : 0;
	$vimeo = (bool) in_array('vimeo',$is_allowed_option) ? 1 : 0;
	$dailymotion = (bool) in_array('dailymotion',$is_allowed_option) ? 1 : 0;
	$myComputer = (bool) in_array('myComputer',$is_allowed_option) ? 1 : 0;
  $allowed_upload = (bool) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('seseventvideo', $user, 'upload');
  $ffmpeg_path = (bool) Engine_Api::_()->getApi('settings', 'core')->seseventvideo_ffmpeg_path;
  $youtubeEnabled = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('seseventvideo.youtube.apikey');
  if($allowed_upload && $ffmpeg_path) $allowed = 1;
?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    var type = 'wall';
    if (composeInstance.options.type) type = composeInstance.options.type;
    composeInstance.addPlugin(new Composer.Plugin.Seseventvideo({
      title : '<?php echo $this->translate('Add Video') ?>',
			youtubeCheck:<?php echo $youtube; ?>,
			vimeoCheck:<?php echo $vimeo;?>,
			dailymotionCheck:<?php echo $dailymotion;?>,
			myComputerCheck:<?php echo $myComputer;?>,
      lang : {
        'Add Video' : '<?php echo $this->string()->escapeJavascript($this->translate('Add Video')) ?>',
        'Select File' : '<?php echo $this->string()->escapeJavascript($this->translate('Select File')) ?>',
        'cancel' : '<?php echo $this->string()->escapeJavascript($this->translate('cancel')) ?>',
        'Attach' : '<?php echo $this->string()->escapeJavascript($this->translate('Attach')) ?>',
        'Loading...' : '<?php echo $this->string()->escapeJavascript($this->translate('Loading...')) ?>',
        'Choose Source': '<?php echo $this->string()->escapeJavascript($this->translate('Choose Source')) ?>',
        'My Computer': '<?php echo $this->string()->escapeJavascript($this->translate('My Computer')) ?>',
        'YouTube': '<?php echo $this->string()->escapeJavascript($this->translate('YouTube')) ?>',
        'Vimeo': '<?php echo $this->string()->escapeJavascript($this->translate('Vimeo')) ?>',
				'Dailymotion': '<?php echo $this->string()->escapeJavascript($this->translate('Dailymotion')) ?>',
        'To upload a video from your computer, please use our full uploader.': '<?php echo $this->string()->escapeJavascript($this->translate('To upload a video from your computer, please use our <a href="%1$s">full uploader</a>.', $this->url(array('action' => 'create', 'type'=>3,'parent_id'=>$subject->getIdentity()), 'seseventvideo_general'))) ?>'
      },
      allowed : <?php echo $allowed;?>,
			parent_id:<?php echo $subject->getIdentity(); ?>,
      type : type,
			youtubeEnabled: <?php echo (int) $youtubeEnabled?>,
      requestOptions : {
        'url' : en4.core.baseUrl + 'seseventvideo/index/compose-upload/format/json/c_type/'+type
      }
    }));
  });
</script>
