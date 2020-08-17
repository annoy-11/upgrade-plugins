<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfmm/views/scripts/dismiss_message.tpl';?>
<?php
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
  $this->headLink()
    ->appendStylesheet($this->layout()->staticBaseUrl . '/externals/uploader/uploader.css');
?>

<script type="text/javascript">
  var fileData = <?php echo Zend_Json::encode($this->contents) ?>;
  var absBasePath = '<?php echo (_ENGINE_SSL ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $this->baseUrl() . '/public/admin/'; ?>';

  var fileCopyUrl = function(arg)
  {
    var fileInfo = fileData[arg];
    Smoothbox.open('<div><input type=\'text\' style=\'width:400px\' /><br /><br /><button onclick="Smoothbox.close();">Close</button></div>', {autoResize : true});
    Smoothbox.instance.content.getElement('input').set('value', absBasePath + fileInfo['rel']).focus();
    Smoothbox.instance.content.getElement('input').select();
    Smoothbox.instance.doAutoResize();
  }


en4.core.runonce.add(function() {
  sesJqueryObject('#dragandrophandler').show();
  sesJqueryObject('#from-url').hide();
  sesJqueryObject('#file_multi_sesfmm').hide();
  sesJqueryObject('#submit').hide();
  sesJqueryObject('#sesfmm_create_form_tabs li a').on('click',function() {
      sesJqueryObject('#dragandrophandler').hide();
      sesJqueryObject('#from-url').hide();
      sesJqueryObject('#file_multi_sesfmm').hide();
      if(sesJqueryObject(this).hasClass('drag_drop'))
        sesJqueryObject('#dragandrophandler').show();
      else if(sesJqueryObject(this).hasClass('multi_upload')){
        document.getElementById('file_multi_sesfmm').click();			
      }else if(sesJqueryObject(this).hasClass('from_url')){
        document.getElementById('from-url').style.display="flex";
      }
  });
});


sesJqueryObject (document).ready(function() {

  var obj = sesJqueryObject('.dragandrophandler');
  obj.on('dragenter', function (e)  {
      e.stopPropagation();
      e.preventDefault();
      sesJqueryObject (this).addClass("sesbd");
  });
  
  obj.on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
  });
  
  obj.on('drop', function (e)  {
      sesJqueryObject (this).removeClass("sesbd");
      sesJqueryObject (this).addClass("sesbm");
      e.preventDefault();
      var files = e.originalEvent.dataTransfer.files;
      //We need to send dropped files to Server
      handleFileUploadsesfmm(files,obj);
  });
  
  sesJqueryObject (document).on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
  });
  
  sesJqueryObject (document).on('dragover', function (e)  {
    e.stopPropagation();
    e.preventDefault();
  });
  
  sesJqueryObject (document).on('drop', function (e) {
      e.stopPropagation();
      e.preventDefault();
  });
});


var rowCount=0;
function createStatusbarsesfmm(obj,file) {

  rowCount++;
  var row="odd";
  if(rowCount %2 ==0) row ="even";
  var checkedId = sesJqueryObject("input[name=cover]:checked");
  this.objectInsert = sesJqueryObject('<div class="sesfmm_upload_item sesbm '+row+'"></div>');
  this.overlay = sesJqueryObject("<div class='overlay sesfmm_upload_item_overlay'></div>").appendTo(this.objectInsert);
  //this.abort = sesJqueryObject('<div class="abort sesfmm_upload_item_abort" id="abortPhoto_'+countUploadSes+'"><span><i class="fa fa-times"></i></span></div>').appendTo(this.objectInsert);
  this.progressBar = sesJqueryObject('<div class="overlay_image progressBar"><div></div></div>').appendTo(this.objectInsert);
  this.imageContainer = sesJqueryObject('<div class="sesfmm_upload_item_photo"></div>').appendTo(this.objectInsert);
  this.src = sesJqueryObject('<img src="'+en4.core.baseUrl+'application/modules/Sesfmm/externals/images/blank-img.gif">').appendTo(this.imageContainer);
  this.infoContainer = sesJqueryObject('<div class=sesfmm_upload_photo_info sesbasic_clearfix"></div>').appendTo(this.objectInsert);
  this.size = sesJqueryObject('<span class="sesfmm_upload_item_size sesbasic_text_light"></span>').appendTo(this.infoContainer);
  this.filename = sesJqueryObject('<span class="sesfmm_upload_item_name"></span>').appendTo(this.infoContainer);

  var objectAdd = sesJqueryObject(this.objectInsert).appendTo('#show_photo_sesfmm');

  sesJqueryObject(this.objectInsert).css('width', widthSetImageContainer+'px');
  $('upload-complete-message').setStyle('display', '');
  
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
function handleFileUploadsesfmm(files,obj) {
  selectedFileLength = files.length;
  for (var i = 0; i < files.length; i++)  {
    var url = files[i].name;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    //if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
      var status = new createStatusbarsesfmm(obj,files[i]); //Using this we can set progress.
      status.setFileNameSize(files[i].name,files[i].size);
      statusArray[countUploadSes] =status;
      filesArray[countUploadSes] = files[i];
      countUploadSes++;
    //}
  }
  executeuploadsesfmm();
}

var execute = true;
function executeuploadsesfmm(){
	if(Object.keys(filesArray).length == 0 && !sesJqueryObject('#show_photo_sesfmm').find('.sesfmm_upload_item').lenght){
		sesJqueryObject('#submit-wrapper').show();
	}
	if(execute == true){
	 for (var i in filesArray) {
		if (filesArray.hasOwnProperty(i))
    {
     	sendFileToServersesfmm(filesArray[i],statusArray[i],filesArray[i],'upload',i);
			break;
    }			
	 }
	}
}
var jqXHR = new Array();
function sendFileToServersesfmm(formData,status,file,isURL,i)
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
		formData.append('isURL', urlIs);
		sesJqueryObject('#show_photo_sesfmm_container').addClass('iscontent');
		var url = '&isURL='+urlIs;
    var uploadURL ='admin/sesfmm/files/upload'; //absBasePath$('form-upload').action + '?ul=1'+url; //Upload URL
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
    ajaxupload: true, 
    isURL: urlIs,
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
							status.option.find('.sesfmm_upload_item_radio').find('input').attr('value',response.photo_id);
							status.src.attr('src',response.url);
							status.option.attr('data-src',response.photo_id);
							status.overlay.css('display','none');
							status.setProgress(100);
							//status.abort.remove();
					}
					executeuploadsesfmm();
       }
    }); 
}
//Ajax error show before form submit
function readImageUrlsesfmm(input) {
  handleFileUploadsesfmm(input.files,sesJqueryObject('.dragandrophandler'));
}
var isUploadUrl = false;

sesJqueryObject('.dragandrophandler').click(function() {
  document.getElementById('file_multi_sesfmm').click();
});

sesJqueryObject(document).on('click','#upload_from_url',function(e){
  e.preventDefault();
  var url = sesJqueryObject('#from_url_upload').val();
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  var name = url.split('/').pop();
  name = name.substr(0, name.lastIndexOf('.'));
    if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
      var status = new createStatusbarsesfmm(sesJqueryObject('.dragandrophandler'),url,'url'); //Using this we can set progress.
      var fd = new FormData();
      fd.append('Filedata', url);
      status.setFileNameSize(name);
      isUploadUrl = true;
      sesJqueryObject('#loading_image').html('uploading ...');
      sendFileToServersesfmm(fd,status,url,'url');
      isUploadUrl = false;
      sesJqueryObject('#loading_image').html('');
      sesJqueryObject('#from_url_upload').val('');
  }
  return false;
});

sesJqueryObject(document).on('click','.multi_upload_sesact',function(e){
  document.getElementById('file_multi_sesfmm').click();
});

function multiDelete()
{
  return confirm("<?php echo $this->translate('Are you sure you want to delete the selected files?');?>");
}

</script>


<h2><?php echo $this->translate("File & Media Manager") ?></h2>
<p>
  <?php echo $this->translate('You may want to quickly upload images, icons, or other media for use in your layout, announcements, blog entries, etc. You can upload and manage these files here.') ?>
</p>
<br />

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<div class="sesfmm_create_form_tabs sesbasic_clearfix sesbm"><ul id="sesfmm_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop"><?php echo "Drag & Drop"; ?></a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload"><?php echo "Multi Upload"; ?></a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url"><?php echo "From URL"; ?></a></li></ul></div>

<div id="dragandrophandler" class="sesfmm_upload_dragdrop_content sesbasic_bxs dragandrophandler"><img src="application/modules/Sesfmm/externals/images/upload-cloud.png" />Drag & Drop Files Here</div>

<div id="from-url" class="sesfmm_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="Enter Image URL to upload"><span id="loading_image"></span><span></span><button id="upload_from_url">Upload</button></div>

<?php // accept="image/x-png,image/jpeg" ?>
<input type="file"  onchange="readImageUrlsesfmm(this)" multiple="multiple" id="file_multi_sesfmm" name="file_multi">

<div id="show_photo_sesfmm_container" class="sesfmm_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo_sesfmm"></div></div>

<div class="sesfmm_uploaded_media">
<div id="file-status">
  <div id="files-status-overall" style="display: none;">
    <div class="overall-title">Overall Progress</div>
    <img src='<?php echo $this->layout()->staticBaseUrl . "/externals/fancyupload/assets/progress-bar/bar.gif" ?>' class="progress overall-progress">
    <span>0%</span>
  </div>

  <ul id="uploaded-file-list"></ul>
  <div id="base-uploader-progress"></div>
  <div class="base-uploader">
    <input class="file-input" id="upload_file" type="file" multiple="multiple" data-url="<?php echo $this->url(array('action' => 'upload'))?>" data-form-id="#form-upload" name='Filedata'>
  </div>

  <div id="upload-complete-message" style="display:none;">
    <?php echo $this->htmlLink(array('reset' => false), 'Refresh the page to display new files') ?>
  </div>
</div>
</div>
<br />

<?php if(count($this->contents) > 0): $i = 0; ?>
  <div class="admin_files_wrapper">

    <iframe src="about:blank" style="display:none" name="downloadframe"></iframe>
    
    <div class="admin_files_pages">
      <?php $pageInfo = $this->paginator->getPages(); ?>
      <?php echo $this->translate(array('Showing %s-%s of %s file.', 'Showing %s-%s of %s files.', $pageInfo->totalItemCount), $pageInfo->firstItemNumber, $pageInfo->lastItemNumber, $pageInfo->totalItemCount) ?>
      <span>
        <?php if( !empty($pageInfo->previous) ): ?>
          <?php echo $this->htmlLink(array('reset' => false, 'APPEND' => '?path=' . urlencode($this->relPath) . '&page=' . $pageInfo->previous. '&extension=' . $this->extension), 'Previous Page') ?>
        <?php endif; ?>
        <?php if( !empty($pageInfo->previous) && !empty($pageInfo->next) ): ?>
           |
        <?php endif; ?>
        <?php if( !empty($pageInfo->next) ): ?>
          <?php echo $this->htmlLink(array('reset' => false, 'APPEND' => '?path=' . urlencode($this->relPath) . '&page=' . $pageInfo->next. '&extension=' . $this->extension), 'Next Page') ?><i class="fa fa-angle-double-right"></i>
        <?php endif; ?>
      </span>
    </div>

    <form action="<?php echo $this->url(array('action' => 'delete')) ?>?path=<?php echo $this->relPath ?>" method="post" onSubmit="return multiDelete()">
      <ul class="sesfmm_media_list">
        <?php foreach( $this->paginator as $content ): $i++; $id = 'admin_file_' . $i; $contentKey = $content['rel']; ?>
          <li class="sesfmm_media_file sesfmm_file_type_<?php echo $content['type'] ?>" id="<?php echo $id ?>">
           <div class="sesfmm_media_item">
             <div class="sesfmm_file_checkbox">
              <?php echo $this->formCheckbox('actions[]', $content['rel']) ?>
            </div>
            <div class="sesfmm_file_options">
              <?php echo $this->htmlLink('javascript:void(0)', $this->translate(''), array( 'class' => 'fa sesfmm_icon_url', 'title' => 'Copy URL', 'onclick' => 'fileCopyUrl(\''.$contentKey.'\');')) ?>
               <a href="<?php echo $this->url(array('action' => 'rename', 'index' => $i)) ?>?path=<?php echo urlencode($content['rel']) ?>" class="smoothbox fa sesfmm_icon_rename" title="Rename"></a>
               <a href="<?php echo $this->url(array('action' => 'delete', 'index' => $i)) ?>?path=<?php echo urlencode($content['rel']) ?>" class="smoothbox fa sesfmm_icon_delete" title="Delete"></a>
              <?php if( $content['is_file'] ): ?>
               <a href="<?php echo $this->url(array('action' => 'download')) ?><?php echo !empty($content['rel']) ? '?path=' . urlencode($content['rel']) : '' ?>" target="downloadframe" class="fa sesfmm_icon_download" title="Download"></a>
              <?php else: ?>
               <a href="<?php echo $this->url(array('action' => 'index')) ?><?php echo !empty($content['rel']) ? '?path=' . urlencode($content['rel']) : '' ?>"><?php echo $this->translate('open') ?></a>
              <?php endif; ?>
            </div>
            <div class="sesfmm_file_preview sesfmm_file_preview_<?php echo $content['type'] ?>">
              <?php if($content['ext'] == 'pdf'): ?>
                <img src="application/modules/Sesfmm/externals/images/file-icons/pdf.png">
              <?php elseif(in_array($content['ext'], array('text', 'txt'))): ?>
                <img src="application/modules/Sesfmm/externals/images/file-icons/text.png">
              <?php elseif(in_array($content['ext'], array('mpeg', 'x-realaudio', 'wav', 'amr', 'mp3', 'ogg','midi','x-ms-wma', 'x-ms-wax', 'x-matroska'))): ?>
                <img src="application/modules/Sesfmm/externals/images/file-icons/audio.png">
              <?php elseif(in_array($content['ext'], array('mp4', 'flv'))): ?>
                <img src="application/modules/Sesfmm/externals/images/file-icons/video.png">
              <?php elseif(in_array($content['ext'], array('zip', 'tar'))): ?>
                <img src="application/modules/Sesfmm/externals/images/file-icons/zip.png">
              <?php elseif( $content['is_image'] ): ?>
                <?php echo $this->htmlImage($this->baseUrl() . '/public/admin/' . $content['rel'], $content['name']) ?>
              <?php elseif( $content['is_markup'] ): ?>
                <iframe style="background-color: #fff;" src="<?php echo $this->url(array('action' => 'preview')) ?>?path=<?php echo urlencode($content['rel']) ?>"></iframe>
              <?php elseif($content['is_text']): ?>
                <div>
                  <?php echo nl2br($this->escape(file_get_contents($content['path']))) ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="sesfmm_file_name" title="<?php echo $contentKey ?>">
              <?php if( $content['name'] == '..' ): ?>
                <?php echo $this->translate('(up)') ?>
              <?php else: ?>
                <?php echo $content['name'] ?>
              <?php endif; ?>
            </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="admin_files_submit">
        <button type="submit"><?php echo $this->translate('Delete Selected') ?></button>
      </div>
      <?php echo $this->formHidden('path', $this->relPath) ?>
    </form>
  </div>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no files yet.") ?>
    </span>
  </div>
<?php endif; ?>
<!-- IMAGE POPUP -->
<div class="sesfmm_image_popup" style="display:none;">
  <div class="sesfmm_image_popup_inner">
     <span class="sesfmm_close">&times;</span>
     <div class="sesfmm_popup_img">
        <img src="application/modules/Sesfmm/externals/images/1.jpeg" />
     </div>
  </div>
</div>
<script>
jQuery(document).ready(function(){
    jQuery(".sesfmm_close").click(function(){
        jQuery(".sesfmm_image_popup").hide();
    });
});
</script>
