<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _entryPhoto.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
//drag drop photo upload
 en4.core.runonce.add(function()
  {
	if(sesJqueryObject('#entrydragandrophandlerbackground').hasClass('requiredClass')){
		sesJqueryObject('#entrydragandrophandlerbackground').parent().parent().find('#photouploaderentry-label').find('label').addClass('required').removeClass('optional');	
	}
    if($('photouploaderentry-wrapper'))
	$('photouploaderentry-wrapper').style.display = 'block';
	$('contest_entry_main_photo_preview-wrapper').style.display = 'none';
   
	$('entry_photo-wrapper').style.display = 'none';

var obj = sesJqueryObject('#entrydragandrophandlerbackground');
obj.click(function(e){
	sesJqueryObject('#entry_photo').val('');
	sesJqueryObject('#contest_entry_main_photo_preview').attr('src','');
  sesJqueryObject('#entry_photo').trigger('click');
});
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    sesJqueryObject (this).addClass("sesbd");
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
		 sesJqueryObject (this).removeClass("sesbd");
		 sesJqueryObject (this).addClass("sesbm");
     e.preventDefault();
     var files = e.originalEvent.dataTransfer;
     entryhandleFileBackgroundUpload(files,'contest_entry_main_photo_preview');
});
sesJqueryObject (document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
sesJqueryObject (document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
});
	sesJqueryObject (document).on('drop', function (e) 
	{
			e.stopPropagation();
			e.preventDefault();
	});
});
function entryhandleFileBackgroundUpload(input,id) {
  var url = input.value; 
  if(typeof url == 'undefined')
    url = input.files[0]['name'];
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    var reader = new FileReader();
    reader.onload = function (e) {
     // $(id+'-wrapper').style.display = 'block';
      $(id).setAttribute('src', e.target.result);
    }
    if($('photouploaderentry-element'))
    $('photouploaderentry-element').style.display = 'none';
    $('removeEntryImage-wrapper').style.display = 'block';
    $('removeentryimage1').style.display = 'inline-block';
    $('contest_entry_main_photo_preview').style.display = 'block';
    $('contest_entry_main_photo_preview-wrapper').style.display = 'block';
    reader.readAsDataURL(input.files[0]);
  }
}
function removeEntryImage() {
    if($('photouploaderentry-element'))
	$('photouploaderentry-element').style.display = 'block';
	$('removeEntryImage-wrapper').style.display = 'none';
	$('removeentryimage1').style.display = 'none';
	$('contest_entry_main_photo_preview').style.display = 'none';
	$('contest_entry_main_photo_preview-wrapper').style.display = 'none';
	$('contest_entry_main_photo_preview').src = '';
	$('MAX_FILE_SIZE').value = '';
	$('removeentryimage2').value = '';
	$('entry_photo').value = '';
}
</script>