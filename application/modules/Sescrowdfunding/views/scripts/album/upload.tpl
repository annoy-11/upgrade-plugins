<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: upload.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding)); ?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="sescrowdfunding_dashboard_form sescf_dashboard_album_upload">
	<?php echo $this->form->render($this) ?>
</div>
<?php if(!$this->is_ajax) { ?>
  	</div>
  </div>
</div>
<?php } ?>

<script type="text/javascript">
en4.core.runonce.add(function() {
sesJqueryObject('#dragdrop-wrapper').show();
sesJqueryObject('#fromurl-wrapper').hide();
sesJqueryObject('#file_multi_sesalbum-wrapper').hide();
sesJqueryObject('#submit-wrapper').hide();
sesJqueryObject('#sescf_create_form_tabs li a').on('click',function(){
		sesJqueryObject('#dragdrop-wrapper').hide();
		sesJqueryObject('#fromurl-wrapper').hide();
		sesJqueryObject('#file_multi_sesalbum-wrapper').hide();
		if(sesJqueryObject(this).hasClass('drag_drop'))
			sesJqueryObject('#dragdrop-wrapper').show();
		else if(sesJqueryObject(this).hasClass('multi_upload')){
			document.getElementById('file_multi_sesalbum').click();			
		}else if(sesJqueryObject(this).hasClass('from_url')){
			document.getElementById('fromurl-wrapper').style.display="block";
		}
});
});
</script>

<script type="text/javascript">

sesJqueryObject (document).ready(function()
{
var obj = sesJqueryObject('.dragandrophandler');
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
     handleFileUploadsesalbum(files,obj);
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
sesJqueryObject(document).on('click','div[id^="abortPhoto_"]',function(){
		var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
		if(typeof jqXHR[id] != 'undefined'){
				jqXHR[id].abort();
				delete filesArray[id];	
				execute = true;
				sesJqueryObject(this).parent().remove();
				executeuploadsesalbum();
		}else{
				delete filesArray[id];	
				sesJqueryObject(this).parent().remove();
		}
});
var rowCount=0;
function createStatusbarsesalbum(obj,file)
{
     rowCount++;
     var row="odd";
     if(rowCount %2 ==0) row ="even";
		  var checkedId = sesJqueryObject("input[name=cover]:checked");
			this.objectInsert = sesJqueryObject('<div class="sesalbum_upload_item sesbm '+row+'"></div>');
			this.overlay = sesJqueryObject("<div class='overlay sesalbum_upload_item_overlay'></div>").appendTo(this.objectInsert);
			this.abort = sesJqueryObject('<div class="abort sesalbum_upload_item_abort" id="abortPhoto_'+countUploadSes+'"><span><?php echo $this->translate("Cancel Uploading"); ?></span></div>').appendTo(this.objectInsert);
			this.progressBar = sesJqueryObject('<div class="overlay_image progressBar"><div></div></div>').appendTo(this.objectInsert);
			this.imageContainer = sesJqueryObject('<div class="sesalbum_upload_item_photo"></div>').appendTo(this.objectInsert);
			this.src = sesJqueryObject('<img src="'+en4.core.baseUrl+'application/modules/Sesalbum/externals/images/blank-img.gif">').appendTo(this.imageContainer);
			this.infoContainer = sesJqueryObject('<div class="sesalbum_upload_photo_info sesbasic_clearfix"></div>').appendTo(this.objectInsert);
			this.size = sesJqueryObject('<span class="sesalbum_upload_item_size sesbasic_text_light"></span>').appendTo(this.infoContainer);
			this.filename = sesJqueryObject('<span class="sesalbum_upload_item_name"></span>').appendTo(this.infoContainer);
			this.option = sesJqueryObject('<div class="sesalbum_upload_item_options clear sesbasic_clearfix"><a class="edit_image_upload_sesalbum fa fa-pencil" href="javascript:void(0);"></a><a class="delete_image_upload delete_image_upload_sesalbum fa fa-trash" href="javascript:void(0);"></a></div>').appendTo(this.objectInsert);

				 var objectAdd = sesJqueryObject(this.objectInsert).appendTo('#show_photo_sesalbum');

			sesJqueryObject(this.objectInsert).css('width', widthSetImageContainer+'px');
		if ($('album').get('value') == 0) {
			if(sesJqueryObject('#show_photo_sesalbum').children('div').length == 1) {
				var idPhoto = sesJqueryObject('#show_photo_sesalbum').eq(0).find('.sesalbum_upload_item_radio').find('input').attr('id');
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
						executeuploadsesalbum();
        });
    }
}
var widthSetImageContainer = 180;
en4.core.runonce.add(function() {
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
function handleFileUploadsesalbum(files,obj)
{
	 selectedFileLength = files.length;
   for (var i = 0; i < files.length; i++) 
   {
			var url = files[i].name;
    	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
				var status = new createStatusbarsesalbum(obj,files[i]); //Using this we can set progress.
				status.setFileNameSize(files[i].name,files[i].size);
				statusArray[countUploadSes] =status;
				filesArray[countUploadSes] = files[i];
				countUploadSes++;
			}
   }
	 executeuploadsesalbum();
}
var execute = true;
function executeuploadsesalbum(){
	if(Object.keys(filesArray).length == 0 && !sesJqueryObject('#show_photo_sesalbum').find('.sesalbum_upload_item').lenght){
		sesJqueryObject('#submit-wrapper').show();
	}
	if(execute == true){
	 for (var i in filesArray) {
		if (filesArray.hasOwnProperty(i))
    {
     	sendFileToServersesalbum(filesArray[i],statusArray[i],filesArray[i],'upload',i);
			break;
    }			
	 }
	}
}
var jqXHR = new Array();
function sendFileToServersesalbum(formData,status,file,isURL,i)
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
		sesJqueryObject('#show_photo_sesalbum_container').addClass('iscontent');
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
							status.option.find('.sesalbum_upload_item_radio').find('input').attr('value',response.photo_id);
							status.src.attr('src',response.url);
							status.option.attr('data-src',response.photo_id);
							status.overlay.css('display','none');
							status.setProgress(100);
							status.abort.remove();
					}else{
							status.abort.html('<span>Error In Uploading File</span>');
              var parseURL = sesJqueryObject.parseJSON(response);
              if(typeof parseURL.errorCode != 'undefined'){
                var code = parseURL.errorCode;
                if(code == "3999"){
                  alert(parseURL.message);  
                }  
              }   
          }
					executeuploadsesalbum();
       }
    }); 
}

function readImageUrlsesalbum(input) {
	handleFileUploadsesalbum(input.files,sesJqueryObject('.dragandrophandler'));
}
var isUploadUrl = false;
 <?php if(!$this->isOpenPopup || !$this->anfalbumparams): ?>
sesJqueryObject('.dragandrophandler').click(function(){
	document.getElementById('file_multi_sesalbum').click();	
});


sesJqueryObject(document).on('click','#upload_from_url',function(e){
	e.preventDefault();
	var url = sesJqueryObject('#from_url_upload').val();
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	var name = url.split('/').pop();
	name = name.substr(0, name.lastIndexOf('.'));
		if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
			var status = new createStatusbarsesalbum(sesJqueryObject('.dragandrophandler'),url,'url'); //Using this we can set progress.
			var fd = new FormData();
			fd.append('Filedata', url);
			status.setFileNameSize(name);
			isUploadUrl = true;
			sesJqueryObject('#loading_image').html('uploading ...');
			sendFileToServersesalbum(fd,status,url,'url');
			isUploadUrl = false;
			sesJqueryObject('#loading_image').html('');
			sesJqueryObject('#from_url_upload').val('');
   }
	 return false;
});
sesJqueryObject(document).on('click','.edit_image_upload_sesalbum',function(e){
	e.preventDefault();
	var photo_id = sesJqueryObject(this).closest('.sesalbum_upload_item_options').attr('data-src');
	if(photo_id){
		editImage(photo_id);
	}else
		return false;
});
sesJqueryObject(document).on('click','.multi_upload_sesact',function(e){
document.getElementById('file_multi_sesalbum').click();
});
sesJqueryObject(document).on('click','.delete_image_upload_sesalbum',function(e){
	e.preventDefault();
	sesJqueryObject(this).parent().parent().find('.sesalbum_upload_item_overlay').css('display','block');
	var sesthat = this;
	var isCover = sesJqueryObject(this).closest('.sesalbum_upload_item_options').find('.sesalbum_upload_item_radio').find('input').prop('checked');
	var photo_id = sesJqueryObject(this).closest('.sesalbum_upload_item_options').attr('data-src');
	if(photo_id){
		request = new Request.JSON({
    'format' : 'json',
    'url' : '<?php echo $this->url(Array('module' => 'sescrowdfunding', 'controller' => 'album', 'action' => 'remove'), 'default') ?>',
    'data': {
      'photo_id' : photo_id
    },
   'onSuccess' : function(responseJSON) {
			sesJqueryObject(sesthat).parent().parent().remove();
			var fileids = document.getElementById('fancyuploadfileids');
			sesJqueryObject('#fancyuploadfileids').val(fileids.value.replace(photo_id + " ",''));
		if ($('album').get('value') == 0) {
			if(isCover){
				var idPhoto = sesJqueryObject('#show_photo_sesalbum').eq(0).find('.sesalbum_upload_item_radio').find('input').attr('id');
				sesJqueryObject('#'+idPhoto).prop('checked', true);	
			}
		}
			if(sesJqueryObject('.sesalbum_upload_item').length == 0){
				sesJqueryObject('#submit-wrapper').hide();
				sesJqueryObject('#show_photo_sesalbum_container').removeClass('iscontent');
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
<?php endif; ?>
  function editImage(photo_id) {
    var url = '<?php echo $this->url(Array('module' => 'sescrowdfunding', 'controller' => 'album', 'action' => 'edit-photo'), 'default') ?>' + '/photo_id/'+ photo_id;
    Smoothbox.open(url);
  }
	function enablePasswordFiled(value){
		if(value == 0){
			sesJqueryObject('#password-wrapper').hide();
		}else{
			sesJqueryObject('#password-wrapper').show();		
		}
	}
   en4.core.runonce.add(function() {
	  sesJqueryObject('#password-wrapper').hide();
   });
</script>
