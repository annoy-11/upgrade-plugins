<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: add-photos.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="courses_addlocation_photos_popup sesbasic_bxs">
	<div class="sesbasic_clearfix">
    <input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrlbuysell(this)" multiple="multiple" id="file_multi" name="file_multi" style="display:none">
    <div class="courselocation_compose_photo_container sesbasic_clearfix">
      <div id="courselocation_compose_photo_container_inner" class="sesbasic_clearfix">
        <div id="show_photo" class="sesbasic_clearfix"></div>
        <div id="dragandrophandlerecourselocation" class="courselocation_compose_photo_uploader">
          <i class="fa fa-plus"></i>
          <span><?php echo $this->translate("Choose a file to upload"); ?></span>
        </div>
      </div>
    </div>
  </div>
</div>
<script  type="text/javascript">
  var rowCount=0;

  function createStatusbarbuysell(obj,file){
    rowCount++;
    var row="odd";
    if(rowCount %2 ==0) row ="even";
    var checkedId = sesJqueryObject("input[name=cover]:checked");
    this.objectInsert = sesJqueryObject('<div class="courselocation_compose_photo_item sesbm '+row+'"></div>');
    this.overlay = sesJqueryObject("<div class='overlay courselocation_compose_photo_item_overlay'></div>").appendTo(this.objectInsert);
    this.abort = sesJqueryObject('<div class="abort courses_upload_item_abort" id="abortPhotocourselocation_'+countUploadSes+'"><span><?php echo $this->translate("Cancel Uploading"); ?></span></div>').appendTo(this.objectInsert);
    this.progressBar = sesJqueryObject('<div class="overlay_image progressBar"><div></div></div>').appendTo(this.objectInsert);
    this.imageContainer = sesJqueryObject('<div class="courselocation_compose_photo_item_photo"></div>').appendTo(this.objectInsert);
    this.src = sesJqueryObject('<img src="'+en4.core.baseUrl+'application/modules/Sesalbum/externals/images/blank-img.gif">').appendTo(this.imageContainer);
    this.infoContainer = sesJqueryObject('<div class=courselocation_compose_photo_item_info sesbasic_clearfix"></div>').appendTo(this.objectInsert);
    this.size = sesJqueryObject('<span class="courses_upload_item_size sesbasic_text_light"></span>').appendTo(this.infoContainer);
    this.filename = sesJqueryObject('<span class="courses_upload_item_name"></span>').appendTo(this.infoContainer);
    this.option = sesJqueryObject('<div class="courses_upload_item_options clear sesbasic_clearfix"><a class="delete_image_upload_courselocation" href="javascript:void(0);"><i class="fa fa-close"></i></a></div>').appendTo(this.objectInsert);
    var objectAdd = sesJqueryObject(this.objectInsert).appendTo('#show_photo');
	jqueryObjectOfSes(".sesbasic_custom_horizontal_scroll").mCustomScrollbar("scrollTo",jqueryObjectOfSes('.sesbasic_custom_horizontal_scroll').find('.mCSB_container').find('#courselocation_compose_photo_container_inner').find('#dragandrophandlerecourselocation'));
    this.setFileNameSize = function(name,size){
      if(typeof size != 'undefined'){
        var sizeStr="";
        var sizeKB = size/1024;
        if(parseInt(sizeKB) > 1024){
          var sizeMB = sizeKB/1024;
          sizeStr = sizeMB.toFixed(2)+" MB";
        }
        else{
          sizeStr = sizeKB.toFixed(2)+" KB";
        }
        this.size.html(sizeStr);
      }
      this.filename.html(name);
    }
    this.setProgress = function(progress){       
      var progressBarWidth =progress*this.progressBar.width()/ 100;  
      this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
      if(parseInt(progress) >= 100){
        sesJqueryObject(this.progressBar).remove();
      }
    }
    this.setAbort = function(jqXHRbuysell){
      var sb = this.objectInsert;	
      this.abort.click(function(){
        jqXHRbuysell.abort();
        sb.hide();
        executeuploadsesbuysell();
      });
    }
  }
  var selectedFileLength = 0;
  var statusArray =new Array();
  var filesArray = [];
  var countUploadSes = 0;
  var fdSes = new Array();
  function handleFileUploadsesbuysell(files,obj){
    selectedFileLength = files.length;
   for (var i = 0; i < files.length; i++) {
    var url = files[i].name;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if((ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG' || ext == 'gif' || ext == 'GIF')){
        var status = new createStatusbarbuysell(obj,files[i]); //Using this we can set progress.
        status.setFileNameSize(files[i].name,files[i].size);
        statusArray[countUploadSes] =status;
        filesArray[countUploadSes] = files[i];
        countUploadSes++;
      }
    }
	executeuploadsesbuysell();
  }
  var execute = true;
  function executeuploadsesbuysell(){
    if(Object.keys(filesArray).length == 0 && sesJqueryObject('#show_photo').html() != ''){
      sesJqueryObject('#compose-menu').show();
    }
	if(execute == true){
      for (var i in filesArray) {
        if (filesArray.hasOwnProperty(i)){
          sendFileToServer(filesArray[i],statusArray[i],filesArray[i],'upload',i);
          break;
        }			
      }
	}
  }
  var jqXHRbuysell = new Array();
  function sendFileToServer(formData,status,file,isURL,i){
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
    var uploadURL = "<?php echo $this->url(array('course_id' => $this->course->custom_url,'location_id' => $this->location->location_id,'action'=>'compose-upload'),'courses_dashboard',true);?>";
    var extraData ={}; //Extra Data.
    jqXHRbuysell[i]=sesJqueryObject.ajax({
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
        response = sesJqueryObject.parseJSON(response);
        if (response.status) {
          status.src.attr('src',response.src);
          status.option.attr('data-src',response.locationphoto_id);
          status.overlay.css('display','none');
          status.setProgress(100);
          status.abort.remove();
          var parentPhotoHtml = '<div class="_thumb" id="courses_locationphoto_'+response.locationphoto_id+'"><span class="bg_item_photo" style="background-image:url('+response.src+');"></span><a href="javascript:void(0);" onclick="removeClassLcationPhoto('+response.locationphoto_id+');" class="fa fa-times"></a></div>';
          sesJqueryObject('#courses_location_'+response.location_id).append(parentPhotoHtml);
        }else
          status.abort.html('<span>Error In Uploading File</span>');
        executeuploadsesbuysell();
      }
    }); 
  }
  function readImageUrlbuysell(input) {
    handleFileUploadsesbuysell(input.files,sesJqueryObject('#dragandrophandlerecourselocation'));
  }
  var isUploadUrl = false;
  var coursePhotoDeleteUrl = '<?php echo $this->url(Array('action' => 'remove','course_id' => $this->course->custom_url), 'courses_dashboard') ?>';
  <?php if(isset($_POST['file']) && $_POST['file'] != ''){ ?>
      sesJqueryObject('#fancyalbumuploadfileids').val("<?php echo $_POST['file'] ?>");    	
  <?php } ?>
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
