<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeSeseventAlbum.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
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
#compose-video-activator,
.tool_i_video
{
 display: none !important;
}
#compose-photo-menu span,
#compose-photo-activator,
.tool_i_photo
{
 display: none !important;
}
</style>
<style type="text/css">
/*REMOVE SES MUSIC COMPOSER FROM FEED */
#compose-sesmusic-menu span,
#compose-sesmusic-activator,
.tool_i_sesmusic
{
 display: none !important;
}
/*REMOVE SE MUSIC COMPOSER FROM FEED */
#compose-music-menu span,
#compose-music-activator,
.tool_i_sesmusic
{
 display: none !important;
}
</style>
<?php
   //CHECK PRIVACY
   $viewer = Engine_Api::_()->user()->getViewer();
   if(!$subject->authorization()->isAllowed(null, 'photo') )
      return;
?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'externals/fancyupload/Swiff.Uploader.js')
    ->appendFile($this->layout()->staticBaseUrl . 'externals/fancyupload/Fx.ProgressBar.js')
    ->appendFile($this->layout()->staticBaseUrl . 'externals/fancyupload/FancyUpload2.js');
  $this->headLink()
    ->appendStylesheet($this->layout()->staticBaseUrl . 'externals/fancyupload/fancyupload.css');
  $this->headTranslate(array(
    'Overall Progress ({total})', 'File Progress', 'Uploading "{name}"',
    'Upload: {bytesLoaded} with {rate}, {timeRemaining} remaining.', '{name}',
    'Remove', 'Click to remove this entry.', 'Upload failed',
    '{name} already added.',
    '{name} ({size}) is too small, the minimal file size is {fileSizeMin}.',
    '{name} ({size}) is too big, the maximal file size is {fileSizeMax}.',
    '{name} could not be added, amount of {fileListMax} files exceeded.',
    '{name} ({size}) is too big, overall filesize of {fileListSizeMax} exceeded.',
    'Server returned HTTP-Status <code>#{code}</code>',
    'Security error occurred ({text})',
    'Error caused a send or load operation to fail ({text})',
  ));
?>
<style>
#compose-photo-error{ display:none;}
</style>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    if (Composer.Plugin.Seseventphoto)
      return;

    Asset.javascript('<?php echo $this->layout()->staticBaseUrl ?>application/modules/Sesevent/externals/scripts/composer_photo.js', {
      onLoad:  function() {
        var type = 'wall';
        if (composeInstance.options.type) type = composeInstance.options.type;
        composeInstance.addPlugin(new Composer.Plugin.Seseventphoto({
          title : '<?php echo $this->string()->escapeJavascript($this->translate('Add Photo')) ?>',
          lang : {
            'Add Photo' : '<?php echo $this->string()->escapeJavascript($this->translate('Add Photo')) ?>',
            'Select File' : '<?php echo $this->string()->escapeJavascript($this->translate('Select File')) ?>',
            'cancel' : '<?php echo $this->string()->escapeJavascript($this->translate('cancel')) ?>',
            'Loading...' : '<?php echo $this->string()->escapeJavascript($this->translate('Loading...')) ?>',
            'Unable to upload photo. Please click cancel and try again': ''
          },
					event_id : <?php echo $subject->getIdentity(); ?>,
          requestOptions : {
            'url'  : en4.core.baseUrl + 'sesevent/album/upload-photo/type/'+type+'/event_id/<?php echo $subject->getIdentity(); ?>',
          },
          fancyUploadOptions : {
            'url'  : en4.core.baseUrl + 'sesevent/album/upload-photo/format/json/type/'+type+'/event_id/<?php echo $subject->getIdentity(); ?>',
            'path' : en4.core.basePath + 'externals/fancyupload/Swiff.Uploader.swf'
          }
        }));
      }});
  });
</script>