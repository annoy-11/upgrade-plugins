<?php

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupalbum/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<script type="text/javascript">
	var updateTextFields = function()
	{
		var fieldToggleGroup = ['#title-wrapper', '#description-wrapper', '#search-wrapper','#auth_view-wrapper',  '#auth_comment-wrapper', '#auth_tag-wrapper','#location-wrapper','#mapcanvas-wrapper','#tags-wrapper','#art_cover-wrapper','#is_locked-wrapper'];
				fieldToggleGroup = $$(fieldToggleGroup.join(','))
		if ($('album').get('value') == 0) {
			fieldToggleGroup.show();

		}else {
			fieldToggleGroup.hide();
		}
	}
  en4.core.runonce.add(updateTextFields);

</script>
<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'tag-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });

</script>
<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
<div class="tip"> <span> <?php echo $this->translate('You have already uploaded the maximum number of albums allowed.');?> <?php echo $this->translate('If you would like to upload a new album, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesgroupalbum_general'));?> </span> </div>
<br/>
<?php else:?>
<div class="sesgroupalbum_album_form"> <?php echo $this->form->render($this) ?> </div>
<?php endif; ?>
<script type="text/javascript">
sesJqueryObject('#dragdrop-wrapper').show();
sesJqueryObject('#fromurl-wrapper').hide();
sesJqueryObject('#file_multi-wrapper').hide();
sesJqueryObject('#submit-wrapper').hide();
sesJqueryObject('#sesgroupalbum_create_form_tabs li a').on('click',function(){
		sesJqueryObject('#dragdrop-wrapper').hide();
		sesJqueryObject('#fromurl-wrapper').hide();
		sesJqueryObject('#file_multi-wrapper').hide();
		if(sesJqueryObject(this).hasClass('drag_drop'))
			sesJqueryObject('#dragdrop-wrapper').show();
		else if(sesJqueryObject(this).hasClass('multi_upload')){
			document.getElementById('file_multi').click();			
		}else if(sesJqueryObject(this).hasClass('from_url')){
			document.getElementById('fromurl-wrapper').style.display="block";
		}
});
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum_enable_location', 1)){ ?>
sesJqueryObject(document).ready(function(){

sesJqueryObject('#lat-wrapper').css('display' , 'none');
sesJqueryObject('#lng-wrapper').css('display' , 'none');
sesJqueryObject('#mapcanvas-element').attr('id','map-canvas-list');
//sesJqueryObject('#map-canvas-list').css('height','200px');
sesJqueryObject('#ses_location-label').attr('id','sesgroup_location_data_list');
sesJqueryObject('#sesgroup_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
sesJqueryObject('#ses_location-wrapper').css('display','none');
initializeSesGroupAlbumMapList();
});
sesJqueryObject( window ).load(function() {
	editGroupSetMarkerOnMapList();
});
<?php } ?>
</script>
<?php 
$defaultProfileFieldId = "0_0_$this->defaultProfileId";
$profile_type = 2;
?>

<script type="text/javascript">

  window.addEvent('domready', function() {
	var sesdevelopment = 1;

  });
sesJqueryObject (document).ready(function()
{
var obj = sesJqueryObject('#dragandrophandler');
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
     var files = e.originalEvent.dataTransfer.files;
     //We need to send dropped files to Server
     handleFileUpload(files,obj);
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
var rowCount=0;
sesJqueryObject(document).on('click','div[id^="abortPhoto_"]',function(){
		var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
		if(typeof jqXHR[id] != 'undefined'){
				jqXHR[id].abort();
				delete filesArray[id];	
				execute = true;
				sesJqueryObject(this).parent().remove();
				executeupload();
		}else{
				delete filesArray[id];	
				sesJqueryObject(this).parent().remove();
		}
});
function createStatusbar(obj,file)
{
     rowCount++;
     var row="odd";
     if(rowCount %2 ==0) row ="even";
		  var checkedId = sesJqueryObject("input[name=cover]:checked");
			this.objectInsert = sesJqueryObject('<div class="sesgroupalbum_upload_item sesbm '+row+'"></div>');
			this.overlay = sesJqueryObject("<div class='overlay sesgroupalbum_upload_item_overlay'></div>").appendTo(this.objectInsert);
			this.abort = sesJqueryObject('<div class="abort sesgroupalbum_upload_item_abort" id="abortPhoto_'+countUploadSes+'"><span><?php echo $this->translate("Cancel Uploading"); ?></span></div>').appendTo(this.objectInsert);
			this.progressBar = sesJqueryObject('<div class="overlay_image progressBar"><div></div></div>').appendTo(this.objectInsert);
			this.imageContainer = sesJqueryObject('<div class="sesgroupalbum_upload_item_photo"></div>').appendTo(this.objectInsert);
			this.src = sesJqueryObject('<img src="'+en4.core.baseUrl+'application/modules/Sesgroupalbum/externals/images/blank-img.gif">').appendTo(this.imageContainer);
			this.infoContainer = sesJqueryObject('<div class=sesgroupalbum_upload_photo_info sesbasic_clearfix"></div>').appendTo(this.objectInsert);
			this.size = sesJqueryObject('<span class="sesgroupalbum_upload_item_size sesbasic_text_light"></span>').appendTo(this.infoContainer);
			this.filename = sesJqueryObject('<span class="sesgroupalbum_upload_item_name"></span>').appendTo(this.infoContainer);
			this.option = sesJqueryObject('<div class="sesgroupalbum_upload_item_options clear sesbasic_clearfix"><span class="sesgroupalbum_upload_item_radio"><input type="radio" id="main_photo_id'+rowCount+'" name="cover"><label for="main_photo_id'+rowCount+'"><?php echo $this->translate("Main Photo"); ?></label></span><a class="edit_image_upload" href="javascript:void(0);"><img src="'+en4.core.baseUrl+'application/modules/Sesgroupalbum/externals/images/edit.png"></a><a class="delete_image_upload" href="javascript:void(0);"><img src="'+en4.core.baseUrl+'application/modules/Sesgroupalbum/externals/images/error.png"></a></div>').appendTo(this.objectInsert);
		  var objectAdd = sesJqueryObject(this.objectInsert).appendTo('#show_photo');
			sesJqueryObject(this.objectInsert).css('width', widthSetImageContainer+'px');
		if ($('album').get('value') == 0) {
			if(sesJqueryObject('#show_photo').children('div').length == 1) {
				var idPhoto = sesJqueryObject('#show_photo').eq(0).find('.sesgroupalbum_upload_item_radio').find('input').attr('id');
				sesJqueryObject('#'+idPhoto).prop('checked', true);
			}else{
				sesJqueryObject(checkedId).prop('checked', true);
			}
		}
    this.setFileNameSize = function(name,size)
    {
				if(typeof size != 'undefined'){
					var sizeStr="";
					var sizeKB = size/1024;
					if(parseInt(sizeKB) > 1024)
					{
							var sizeMB = sizeKB/1024;
							sizeStr = sizeMB.toFixed(2)+" MB";
					}
					else
					{
							sizeStr = sizeKB.toFixed(2)+" KB";
					}
					this.size.html(sizeStr);
				}
					this.filename.html(name);
    }
    this.setProgress = function(progress)
    {       
        var progressBarWidth =progress*this.progressBar.width()/ 100;  
        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
        if(parseInt(progress) >= 100)
        {
						sesJqueryObject(this.progressBar).remove();
        }
    }
    this.setAbort = function(jqxhr)
    {
        var sb = this.objectInsert;
				
        this.abort.click(function()
        {
            jqxhr.abort();
            sb.hide();
						executeupload();
        });
    }
}
var widthSetImageContainer = 180;
sesJqueryObject(document).ready(function(){
calculateWidthOfImageContainer();
});
function calculateWidthOfImageContainer(){
	var widthOfContainer = sesJqueryObject('#uploadFileContainer-element').width();
	if(widthOfContainer>=740){
		widthSetImageContainer = 	(widthOfContainer/4)-12;
	}else if(widthOfContainer>=570){
			widthSetImageContainer = (widthOfContainer/3)-12;
	}else if(widthOfContainer>=380){
			widthSetImageContainer = (widthOfContainer/2)-12;
	}else {
			widthSetImageContainer = (widthOfContainer/1)-12;
	}
}
var selectedFileLength = 0;
var statusArray =new Array();
var filesArray = [];
var countUploadSes = 0;
var fdSes = new Array();
function handleFileUpload(files,obj)
{
	 selectedFileLength = files.length;
   for (var i = 0; i < files.length; i++) 
   {
			var url = files[i].name;
    	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
				var status = new createStatusbar(obj,files[i]); //Using this we can set progress.
				status.setFileNameSize(files[i].name,files[i].size);
				statusArray[countUploadSes] =status;
				filesArray[countUploadSes] = files[i];
				countUploadSes++;
			}
   }
	 executeupload();
}
var execute = true;
function executeupload(){
	if(Object.keys(filesArray).length == 0 && sesJqueryObject('#show_photo').html() != ''){
		sesJqueryObject('#submit-wrapper').show();
	}
	if(execute == true){
	 for (var i in filesArray) {
		if (filesArray.hasOwnProperty(i))
    {
     	sendFileToServer(filesArray[i],statusArray[i],filesArray[i],'upload',i);
			break;
    }			
	 }
	}
}
var jqXHR = new Array();
function sendFileToServer(formData,status,file,isURL,i)
{
		execute = false;
		var formData = new FormData();
		formData.append('Filedata', file);
		if(isURL == 'upload'){
			var reader = new FileReader();
			reader.onload = function (e) {
				status.src.attr('src', e.target.result);
			}
			reader.readAsDataURL(file);
			var urlIs = '';
		}else{
			status.src.attr('src', file);
			var urlIs = true;
		}
		sesJqueryObject('#show_photo_container').addClass('iscontent');
		var url = '&isURL='+urlIs;
    var uploadURL =$('form-upload').action + '?ul=1'+url; //Upload URL
    var extraData ={}; //Extra Data.
    jqXHR[i]=sesJqueryObject.ajax({
		xhr: function() {
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
						status.setProgress(percent);
				}, false);
		}
		return xhrobj;
		},
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
		cache: false,
		data: formData,
		success: function(response){
					execute = true;
					delete filesArray[i];
					//sesJqueryObject('#submit-wrapper').show();
					if (response.status) {
							var fileids = document.getElementById('fancyuploadfileids');
							fileids.value = fileids.value + response.photo_id + " ";
							status.option.find('.sesgroupalbum_upload_item_radio').find('input').attr('value',response.photo_id);
							status.src.attr('src',response.url);
							status.option.attr('data-src',response.photo_id);
							status.overlay.css('display','none');
							status.setProgress(100);
							status.abort.remove();
					}else
							status.abort.html('<span>Error In Uploading File</span>');
					executeupload();
       }
    }); 
}
//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateForm(){
		var errorPresent = false;
		sesJqueryObject('#form-upload input, #form-upload select,#form-upload checkbox,#form-upload textarea,#form-upload radio').each(
				function(index){
						var input = sesJqueryObject(this);
						if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
						  if(sesJqueryObject(this).prop('type') == 'checkbox'){
								value = '';
								if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
										value = 1;
								};
								if(value == '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
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
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
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
							}
							if(error)
								errorPresent = true;
							error = false;
						}
				}
			);
				
			return errorPresent ;
}
sesJqueryObject(document).on('submit', '#form-upload',function(e) {
		var validation = validateForm();
		if(validation)
		{
			alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
			if(typeof objectError != 'undefined'){
			 var errorFirstObject = sesJqueryObject(objectError).parent().parent();
			 sesJqueryObject('html, body').animate({
        scrollTop: errorFirstObject.offset().top
    	 }, 2000);
			}
			return false;	
		}else{
			sesJqueryObject('#file_multi-wrapper').remove();
			sesJqueryObject('#submit').attr('disabled',true);
			sesJqueryObject('#submit').html(en4.core.language.translate('Submitting Form ...'));
			return true;
		}
});
function readImageUrl(input) {
	handleFileUpload(input.files,sesJqueryObject('#dragandrophandler'));
}
sesJqueryObject('#dragandrophandler').click(function(){
	document.getElementById('file_multi').click();	
});
var isUploadUrl = false;
sesJqueryObject(document).on('click','#upload_from_url',function(e){
	e.preventDefault();
	var url = sesJqueryObject('#from_url_upload').val();
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	var name = url.split('/').pop();
	name = name.substr(0, name.lastIndexOf('.'));
		if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
			var status = new createStatusbar(sesJqueryObject('#dragandrophandler'),url,'url'); //Using this we can set progress.
			var fd = new FormData();
			fd.append('Filedata', url);
			status.setFileNameSize(name);
			isUploadUrl = true;
			sesJqueryObject('#loading_image').html('uploading ...');
			sendFileToServer(fd,status,url,'url');
			isUploadUrl = false;
			sesJqueryObject('#loading_image').html('');
			sesJqueryObject('#from_url_upload').val('');
   }
	 return false;
});
sesJqueryObject(document).on('click','.edit_image_upload',function(e){
	e.preventDefault();
	var photo_id = sesJqueryObject(this).closest('.sesgroupalbum_upload_item_options').attr('data-src');
	if(photo_id){
		editImage(photo_id);
	}else
		return false;
});
sesJqueryObject(document).on('click','.delete_image_upload',function(e){
	e.preventDefault();
	sesJqueryObject(this).parent().parent().find('.sesgroupalbum_upload_item_overlay').css('display','block');
	var sesthat = this;
	var isCover = sesJqueryObject(this).closest('.sesgroupalbum_upload_item_options').find('.sesgroupalbum_upload_item_radio').find('input').prop('checked');
	var photo_id = sesJqueryObject(this).closest('.sesgroupalbum_upload_item_options').attr('data-src');
	if(photo_id){
		request = new Request.JSON({
    'format' : 'json',
    'url' : '<?php echo $this->url(Array('module' => 'sesgroupalbum', 'controller' => 'index', 'action' => 'remove'), 'default') ?>',
    'data': {
      'photo_id' : photo_id
    },
   'onSuccess' : function(responseJSON) {
			sesJqueryObject(sesthat).parent().parent().remove();
			var fileids = document.getElementById('fancyuploadfileids');
			sesJqueryObject('#fancyuploadfileids').val(fileids.value.replace(photo_id + " ",''));
		if ($('album').get('value') == 0) {
			if(isCover){
				var idPhoto = sesJqueryObject('#show_photo').eq(0).find('.sesgroupalbum_upload_item_radio').find('input').attr('id');
				sesJqueryObject('#'+idPhoto).prop('checked', true);	
			}
		}
			if(sesJqueryObject('#show_photo').html() == ''){
				sesJqueryObject('#submit-wrapper').hide();
				sesJqueryObject('#show_photo_container').removeClass('iscontent');
			}
     return false;
    }
    });
    request.send();
	}else
		return false;
});
<?php if(isset($_POST['file']) && $_POST['file'] != ''){ ?>
		sesJqueryObject('#fancyuploadfileids').val("<?php echo $_POST['file'] ?>");    	
<?php } ?>
  function editImage(photo_id) {
    var url = '<?php echo $this->url(Array('module' => 'sesgroupalbum', 'controller' => 'index', 'action' => 'edit-photo'), 'default') ?>' + '/photo_id/'+ photo_id;
    Smoothbox.open(url);
  }
	function enablePasswordFiled(value){
		if(value == 0){
			sesJqueryObject('#password-wrapper').hide();
		}else{
			sesJqueryObject('#password-wrapper').show();		
		}
	}
	sesJqueryObject('#password-wrapper').hide();
</script>