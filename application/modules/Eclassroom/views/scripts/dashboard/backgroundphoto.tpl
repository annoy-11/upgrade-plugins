<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: backgroundphoto.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array('classroom' => $this->classroom));	
?>
  <div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
  <div class="classroom_dashboard_form classroom_dashboard_photo_form">
    <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<script type="application/javascript">
  sesJqueryObject(document).ready(function() {
	var removehtml=sesJqueryObject('#removeimage-wrapper').html();
	sesJqueryObject('#removeimage-wrapper').remove();
	sesJqueryObject('#classroom_main_photo_preview-element').append('<div id="removeimage-wrapper">'+removehtml+'</div>');
	
    var obj = sesJqueryObject('#dragandrophandlerbackground');
    obj.click(function(e){
      sesJqueryObject('#background').trigger('click');
    });
    obj.on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
      sesJqueryObject (this).addClass("sesbd");
    });
    obj.on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
    obj.on('drop', function (e) {
      sesJqueryObject (this).removeClass("sesbd");
      sesJqueryObject (this).addClass("sesbm");
      e.preventDefault();
      var files = e.originalStore.dataTransfer;
      handleFileBackgroundUpload(files,'classroom_main_photo_preview');
    });
    sesJqueryObject (document).on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
    sesJqueryObject (document).on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
	sesJqueryObject (document).on('drop', function (e) {
      e.stopPropagation();
      e.preventDefault();
	});
  });
<?php
if ($this->classroom->background_photo_id !== null && $this->classroom->background_photo_id){ 
 $backgroundImage =	Engine_Api::_()->storage()->get($this->classroom->background_photo_id, '')->getPhotoUrl();?>
 ShowhandleFileBackgroundUpload('<?php echo $backgroundImage ?>','classroom_main_photo_preview');
<?php }else{ ?>
sesJqueryObject  (document).ready(function()
{
	$('dragdropbackground-wrapper').style.display = 'block';
	$('classroom_main_photo_preview-wrapper').style.display = 'none';
	$('background-wrapper').style.display = 'none';
});
<?php } ?>
function ShowhandleFileBackgroundUpload(input,id) {
  var url = input; 
		$('background-wrapper').style.display = 'none';
    $('dragdropbackground-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('classroom_main_photo_preview').style.display = 'block';
    $('classroom_main_photo_preview-wrapper').style.display = 'block';
  }

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
    $('dragdropbackground-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('classroom_main_photo_preview').style.display = 'block';
    $('classroom_main_photo_preview-wrapper').style.display = 'block';
    reader.readAsDataURL(input.files[0]);
  }
}
function removeImage() {
	$('dragdropbackground-element').style.display = 'block';
	$('removeimage-wrapper').style.display = 'none';
	$('removeimage1').style.display = 'none';
	$('classroom_main_photo_preview').style.display = 'none';
	$('classroom_main_photo_preview-wrapper').style.display = 'none';
	$('classroom_main_photo_preview').src = '';
	$('MAX_FILE_SIZE').value = '';
	$('removeimage2').value = '';
}
function uploadBackgroundPhoto(){
	document.getElementById("EditPhoto").submit();
}
function removePhotoClassroom(url) {
  window.location.href = url;
}
</script>
<?php if($this->is_ajax) die; ?>
