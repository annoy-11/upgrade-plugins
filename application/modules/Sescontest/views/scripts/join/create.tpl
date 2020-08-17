<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescontest/externals/styles/styles.css'); ?>

    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/flexcroll.js'); ?>
<div class="<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.create.form', 1)):?>sescontest_join_contest_form <?php endif;?>sescontest_join_form sesbasic_bxs">
  <?php echo $this->form->render();?>
  <div class="sescontest_join_loading sescontest_join_overlay" style="display: none">
  	<div class="sescontest_join_overlay_cont">
    	<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>
      <span class="_text"><?php echo $this->translate('Please wait your entry is submitting ...');?></span>
    </div>
  </div>
</div>
<div class="sescontest_link_content_popup_overlay" style="display:none;"></div>
<div class="sescontest_link_content_popup" style="display:none;">
	<div class="sescontest_link_content_popup_content">
  	<div class="sescontest_link_content_popup_content_inner">
      <div class="sescontest_link_content_popup_heading">
        <h2><?php echo $this->translate("Select Your Content"); ?></h2>
      </div>
      <input type="text" name="selectcontestcontent" id="selectcontestcontent" value="" placeholder="<?php echo $this->translate("Start typing ...") ?>" autocomplete="off" />
      <div class="sescontest_link_content_popup_elements">  
        <br />
	    <div class="sescontest_link_content_popup_buttons">
          <button id="saveContent" onclick=""><?php echo $this->translate("Save"); ?></button>
          <button id="cancelContent" onclick="" class="secondary_button"><?php echo $this->translate("Cancel"); ?></button>
      	</div>
      </div>
		</div>
	</div>
</div>
<script type="text/javascript">
   var acceptRule = false;
   sesJqueryObject('#contest_join_form_tabs li a').click(function(e){
	 e.preventDefault();
        var className = sesJqueryObject(this).parent().attr('data-url');
        if(sesJqueryObject('.first_step').hasClass('active') && className == 'first_third') {
          alert('Please first fill complete the "Registration" form.');
          return false;
        }
        if(sesJqueryObject('.first_step').hasClass('active') && sesJqueryObject(this).attr('id') == 'save_second_1-click' && acceptRule == false) {
          alert('Please accept rules.');
          return false;
        }
        acceptRule = false;
		if(onLoad == 'loadedElem' && className != 'first_second' && className != 'first_step'){
			var validationFm = validateForm();
			if(validationFm)
			{
              alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
              if(typeof objectError != 'undefined'){
               var errorFirstObject = sesJqueryObject(objectError).parent().parent();
               sesJqueryObject('html, body').animate({
                  scrollTop: errorFirstObject.offset().top
               }, 2000);
              }
              return false;	
			}
		}
        var liLength = sesJqueryObject('#contest_join_form_tabs li');
		for(i=0;i<liLength.length;i++)
			liLength[i].removeClass('active');
		onLoad = 'loadedElem';
		sesJqueryObject('#first_step-wrapper').hide();
		sesJqueryObject('#first_second-wrapper').hide();
		sesJqueryObject('#first_third-wrapper').hide();
		sesJqueryObject('#'+className+'-wrapper').show();
		sesJqueryObject(this).parent().addClass('active');
 });
  var onLoad = 'firstLoad';
  sesJqueryObject('#contest_join_form_tabs').children().eq(0).find('a').click();  
  sesJqueryObject(document).on('click','.next_elm',function(){
    var id = sesJqueryObject(this).attr('id');
    acceptRule = true;
    sesJqueryObject('#'+id+'-click').trigger('click');
  });
//Ajax error show before form submit
var error = false;
var recordedDataContest;
var objectError ;
var counter = 0;
function validateForm(){
  var errorPresent = false;
  sesJqueryObject('#form-upload input, #form-upload select,#form-upload checkbox,#form-upload textarea,#form-upload radio').each(
  function(index){
    var input = sesJqueryObject(this);
    if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
      if(sesJqueryObject(this).prop('type') == 'select-multiple'){
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
        else
          error = false;
      }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
        if(sesJqueryObject(this).val() === '')
          error = true;
        else
          error = false;
      }else if(sesJqueryObject(this).prop('type') == 'radio'){
        if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
          error = true;
        else
          error = false;
      }else if(sesJqueryObject(this).prop('type') == 'textarea'){
        if(sesJqueryObject('.first_second').hasClass('active') && this.id == 'contest_description')
          error = false;
        else {
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
        else
          error = false;
       }
      }else{
        if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
        else
          error = false;
      }
      if(error){
        if(counter == 0){
          objectError = this;
        }
        counter++
      }else{
        if(sesJqueryObject('#entry_photo').length && sesJqueryObject('#entry_photo').val() === '' && sesJqueryObject('#photouploaderentry-label').find('label').hasClass('required')){
          objectError = sesJqueryObject('#entrydragandrophandlerbackground');
          error = true;
        }
      }
      if(error)
      errorPresent = true;
      error = false;
    }
  }
 );
  return errorPresent ;
}
 
  //drag drop photo upload
 en4.core.runonce.add(function()
  {
	if(sesJqueryObject('#entrydragandrophandlerbackground').hasClass('requiredClass')){
		sesJqueryObject('#entrydragandrophandlerbackground').parent().parent().find('#photouploaderentry-label').find('label').addClass('required').removeClass('optional');	
	}
    if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
		sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
	}
    if($('photouploader-wrapper'))
	$('photouploader-wrapper').style.display = 'block';
    if($('contest_main_photo_preview-wrapper'))
	$('contest_main_photo_preview-wrapper').style.display = 'none';
    if($('contest_link_photo_preview-wrapper'))
	$('contest_link_photo_preview-wrapper').style.display = 'none';
    if($('contest_link_video_preview-wrapper'))
	$('contest_link_video_preview-wrapper').style.display = 'none';
    if($('contest_link_audio_preview-wrapper')) {
    $('contest_link_audio_preview-wrapper').style.display = 'none';
    }
    if($('fromurl-wrapper')) {
      $('fromurl-wrapper').style.display = 'none';
      $('remove_fromurl_image-wrapper').style.display = 'none';
      $('contest_url_photo_preview-wrapper').style.display = 'none';  
    }
    if($('contest_link_audio_data-wrapper'))
    $('contest_link_audio_data-wrapper').style.display = 'none';
    if($('photo-wrapper'))
	$('photo-wrapper').style.display = 'none';
    sesJqueryObject('.contest-entry-video').hide();
    
 var obj = sesJqueryObject('#dragandrophandlerbackground');
obj.click(function(e){
	sesJqueryObject('#photo').val('');
	sesJqueryObject('#contest_main_photo_preview').attr('src','');
  sesJqueryObject('#photo').trigger('click');
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
     handleFileBackgroundUpload(files,'contest_main_photo_preview');
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
    sesJqueryObject('#form-upload').submit(function(e){
      e.preventDefault();
      var uploadType = sesJqueryObject('#uploaded_content_type').val();
      if(uploadType == '') {
        uploadType = 1;
      }
      if("<?php echo $this->contest->contest_type ;?>" == 4) {
        if(uploadType == 2 && typeof recordedDataContest == 'undefined') {
           alert('Please record the audio for uploading content.');
           return false;
        }
        else if(uploadType == 1 && sesJqueryObject('#sescontest_audio_file').val() == '') {
           alert('Please seslect the audio.');
           return false;
        }
        else if(uploadType == 3 && sesJqueryObject('#contest_link_audio_data-wrapper').find('audio').length <= 0) {
           alert('Please seslect the audio from popup.');
           return false;
        }
      }
      else if("<?php echo $this->contest->contest_type ;?>" == 3) { 
        if(uploadType == 2 && typeof recordedDataContest == 'undefined') {
           alert('Please record the video for uploading content.');
           return false;
        }
        else if(uploadType == 1 && sesJqueryObject('#sescontest_video_file').val() == '') {
           alert('Please seslect the video.');
           return false;
        }
        else if(uploadType == 3 && sesJqueryObject('#contest_link_video_preview-wrapper').find('iframe').length <= 0) {
           alert('Please seslect the video from popup.');
           return false;
        }
      }
      else if("<?php echo $this->contest->contest_type ;?>" == 2) {
        if(uploadType == 2 && typeof recordedDataContest == 'undefined') {
           alert('Please upload the photo for uploading content.');
           return false;
        }
        else if(uploadType == 1 && sesJqueryObject('#contest_main_photo_preview-wrapper').css('display') == 'none') {
           alert('Please seslect the photo.');
           return false;
        }
        else if(uploadType == 3 && sesJqueryObject('#contest_link_photo_preview').attr("src") == '') {
           alert('Please seslect the photo from existing album.');
           return false;
        }
         else if(uploadType == 4 && sesJqueryObject('#contest_url_photo_preview').attr("src") == '') {
           alert('Please Enter the Photo URL.');
           return false;
        }
      }
      submitForm(this);
    });
    

    //Need to remove
    //sesJqueryObject('#sescontest_content_link').click(function(e){
   // sesJqueryObject('.sescontest_link_content_popup_overlay').show();
    //sesJqueryObject('.sescontest_link_content_popup').show();
  //  return false;
  // });
   // Need to remove
 
    
});



function handleFileBackgroundUpload(input,id) {
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
    $('photouploader-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('contest_main_photo_preview').style.display = 'block';
    $('contest_main_photo_preview-wrapper').style.display = 'block';
    reader.readAsDataURL(input.files[0]);
    resetPhotoData();
    removeLinkImage();
    removeFromurlImage(0);
  }
}
function removeImage() {
	$('photouploader-element').style.display = 'block';
	$('removeimage-wrapper').style.display = 'none';
	$('removeimage1').style.display = 'none';
	$('contest_main_photo_preview').style.display = 'none';
	$('contest_main_photo_preview-wrapper').style.display = 'none';
	$('contest_main_photo_preview').src = '';
	$('MAX_FILE_SIZE').value = '';
	$('removeimage2').value = '';
	$('photo').value = '';
}
  function removeLinkImage() {
    if($('remove_link_image-wrapper'))
    $('remove_link_image-wrapper').style.display = 'none';
    if($('contest_link_photo_preview'))
    $('contest_link_photo_preview').src = '';
    if($('sescontest_link_id'))
    sesJqueryObject('#sescontest_link_id').val('');
    $('MAX_FILE_SIZE').value = '';
  }
function removeFromurlImage(value) {
  $('remove_fromurl_image-wrapper').style.display = 'none';
  $('contest_url_photo_preview').src = '';
  $('contest_url_photo_preview-wrapper').style.display = 'none';
  if(value)
  $('fromurl-wrapper').style.display = 'block';
  sesJqueryObject('#sescontest_url_id').val('');
  $('MAX_FILE_SIZE').value = '';
}
function submitForm(obj) {
  var blob = recordedDataContest;
  var form_elem_name = 'webcam';
  var image_fmt = '';
  var form = new FormData(obj);
  if(sesJqueryObject('#uploaded_content_type').val() == 2 && "<?php echo $this->contest->contest_type ;?>" != 2 &&"<?php echo $this->contest->contest_type ;?>" != 1)
  form.append( form_elem_name, blob, form_elem_name+".webm" );
  else if("<?php echo $this->contest->contest_type ;?>" == 2)
  form.append('record_photo', blob);
  else if("<?php echo $this->contest->contest_type ;?>" == 1) {
    if("<?php echo $this->contest->editor_type ;?>" == 1) {
      var editorContent = tinyMCE.get('contest_description').getContent();
    }
    else {
      var editorContent = sesJqueryObject('#contest_description').val();
    }
    if(editorContent == '') {
      alert('Please fill the content.');
      return false;
    }
    else
      form.append('contest_description', editorContent);
  }
  sesJqueryObject('.sescontest_join_loading').show();
  sesJqueryObject('.sescontest_join_contest_form').addClass('_success');
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
 url:  en4.core.baseUrl+"<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.contest.manifest', 'contest');?>"+'/create/'+"<?php echo $this->contest->contest_id ;?>",
 type: "POST",
 contentType:false,
 processData: false,
     cache: false,
     data: form,
     success: function(response){
         var response = jQuery.parseJSON(response);
         if(response.status) {
           sesJqueryObject('.sescontest_join_loading').html('<div class="sescontest_join_success" style="display: block"><div class="sescontest_join_overlay_cont"><i><img src="application/modules/Sescontest/externals/images/success.png" alt="" /></i><span class="_text">'+en4.core.language.translate("Thanks for Participation !")+'</span></div></div>');
           window.location.href = response.href;
         }
     }
 });
}
</script>




