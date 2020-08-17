<?php if(!$this->typesmoothbox){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Ecoupon/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php }else{ ?>

<?php } ?>
<div class="ecoupon_create_form clr">
  <?php echo $this->form->render($this) ?>
</div>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<script>
var photoUrl;
en4.core.runonce.add(function()
{
  if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
      sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
  }
  photoUrl = sesJqueryObject('#coupon_main_photo_preview').attr('src');
  console.log(photoUrl);
  $('photouploader-wrapper').style.display = 'block';
  $('photo-wrapper').style.display = 'none';
  var obj = sesJqueryObject('#dragandrophandlerbackground');
  obj.click(function(e){
    sesJqueryObject('#photo').val('');
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
    handleFileBackgroundUpload(files,'coupon_main_photo_preview');
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
en4.core.runonce.add(function()
{
var obj = jqueryObjectOfSes('#dragandrophandler');
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    jqueryObjectOfSes (this).addClass("sesbd");
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
 
    jqueryObjectOfSes (this).removeClass("sesbd");
    jqueryObjectOfSes (this).addClass("sesbm");
    e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
     //We need to send dropped files to Server
     handleFileUpload(files,obj);
});
jqueryObjectOfSes (document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
jqueryObjectOfSes (document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
});
	jqueryObjectOfSes (document).on('drop', function (e) 
	{
			e.stopPropagation();
			e.preventDefault();
	});
});

var rotation = {
  1: 'rotate(0deg)',
  3: 'rotate(180deg)',
  6: 'rotate(90deg)',
  8: 'rotate(270deg)'
};
function _arrayBufferToBase64(buffer) {
  var binary = ''
  var bytes = new Uint8Array(buffer)
  var len = bytes.byteLength;
  for (var i = 0; i < len; i++) {
    binary += String.fromCharCode(bytes[i])
  }
  return window.btoa(binary);
}
var orientation = function(file, callback) {
  var fileReader = new FileReader();
  fileReader.onloadend = function() {
    var base64img = "data:" + file.type + ";base64," + _arrayBufferToBase64(fileReader.result);
    var scanner = new DataView(fileReader.result);
    var idx = 0;
    var value = 1; // Non-rotated is the default
    if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
      // Not a JPEG
      if (callback) {
        callback(base64img, value);
      }
      return;
    }
    idx += 2;
    var maxBytes = scanner.byteLength;
    while (idx < maxBytes - 2) {
      var uint16 = scanner.getUint16(idx);
      idx += 2;
      switch (uint16) {
        case 0xFFE1: // Start of EXIF
          var exifLength = scanner.getUint16(idx);
          maxBytes = exifLength - idx;
          idx += 2;
          break;
        case 0x0112: // Orientation tag
          // Read the value, its 6 bytes further out
          // See store 102 at the following URL
          // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
          value = scanner.getUint16(idx + 6, false);
          maxBytes = 0; // Stop scanning
          break;
      }
    }
    if (callback) {
      callback(base64img, value);
    }
  }
  fileReader.readAsArrayBuffer(file);
};
var courseidparam = "";
function handleFileBackgroundUpload(input,id) {
  var files = sesJqueryObject(input)[0].files[0];
  var url = input.value;
  if(typeof url == 'undefined')
    url = input.files[0]['name'];
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    courseidparam = id;
    if (files) {
        orientation(files, function(base64img, value) {
          //$(id+'-wrapper').attr('src', base64img);
          sesJqueryObject(courseidparam).closest('.form-wrapper').show();;
          var rotated = sesJqueryObject(courseidparam).attr('src', base64img);
          if (value) {
            sesJqueryObject(courseidparam).css('transform', rotation[value]);
          }
        });
      }
    $('photouploader-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('coupon_main_photo_preview').style.display = 'block';
    $('coupon_main_photo_preview-wrapper').style.display = 'block';
  }
}
function removeImage() {
    $('photouploader-element').style.display = 'block';
    $('removeimage-wrapper').style.display = 'none';
    $('removeimage1').style.display = 'none';
    $('coupon_main_photo_preview').src = '';
    $('coupon_main_photo_preview').src = photoUrl;
    $('MAX_FILE_SIZE').value = '';
    $('removeimage2').value = '';
    $('photo').value = '';
}
var rowCount=0;
jqueryObjectOfSes(document).on('click','div[id^="abortPhoto_"]',function(){
		var id = jqueryObjectOfSes(this).attr('id').match(/\d+/)[0];
		if(typeof jqXHR[id] != 'undefined'){
				jqXHR[id].abort();
				delete filesArray[id];	
				execute = true;
				jqueryObjectOfSes(this).parent().remove();
				executeupload();
		}else{
				delete filesArray[id];	
				jqueryObjectOfSes(this).parent().remove();
		}
});
function hideShow(obj){
  var maxDiv = sesJqueryObject('#hiddenDic').val();
  var object = sesJqueryObject(obj);
  var id = object.attr('id');
  if(sesJqueryObject('.content_'+id).css('display') == 'block')
    return;  
  sesJqueryObject('#img_'+id).find('img').attr('src','application/modules/Ecoupon/externals/images/downarrow.png');
  sesJqueryObject('.content_'+id).slideDown('slow');
  for(i=1;i<=maxDiv;i++){
    if(sesJqueryObject('.content_'+i).css('display') == 'block' && i != id){  
        sesJqueryObject('#img_'+i).find('img').attr('src','application/modules/Ecoupon/externals/images/leftarrow.png');
        sesJqueryObject('.content_'+i).slideUp('slow');
        break;
    }
  }
}

en4.core.runonce.add(function() {
  jqueryObjectOfSes('#coupon_code_availability').click(function(){
      checkAvailsbility();
    });
  });
  function checkAvailsbility(submitform) {
    var coupon_code = jqueryObjectOfSes('#coupon_code').val();
    if(!coupon_code && typeof submitform == 'undefined')
    return;
    jqueryObjectOfSes('#coupon_code_wrong').hide();
    jqueryObjectOfSes('#coupon_code_correct').hide();
    jqueryObjectOfSes('#coupon_code_loading').css('display','block');
    jqueryObjectOfSes.post('<?php echo $this->url(array('action' => 'check-availability','subject'=>$this->subject->resource_type,'resource_id' => $this->subject->resource_id), "ecoupon_general") ?>',{coupon_code:coupon_code},function(response){
      jqueryObjectOfSes('#coupon_code_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
        jqueryObjectOfSes('#coupon_code_correct').hide();
        jqueryObjectOfSes('#coupon_code_wrong').css('display','block');
        if(typeof submitform != 'undefined') {
          alert('<?php echo $this->translate("Coupon Code is not available. Please select another URL."); ?>');
          var errorFirstObject = jqueryObjectOfSes('#coupon_code').parent().parent();
          jqueryObjectOfSes('html, body').animate({
          scrollTop: errorFirstObject.offset().top
          }, 2000);
        }
      } else{
        jqueryObjectOfSes('#coupon_code').val(response.coupon_code);
        jqueryObjectOfSes('#coupon_code_wrong').hide();
        jqueryObjectOfSes('#coupon_code_correct').css('display','block');
        if(typeof submitform != 'undefined') {
          jqueryObjectOfSes('#upload').attr('disabled',true);
          jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
          jqueryObjectOfSes('#submit_check').trigger('click');
        }
      }
    });
  }
  function changeDiscountType(value){
    if(value == 1){ 
      sesJqueryObject('#fixed_discount_value-wrapper').show();
      sesJqueryObject('#percentage_discount_value-wrapper').hide();
    }else{
      sesJqueryObject('#percentage_discount_value-wrapper').show();
      sesJqueryObject('#fixed_discount_value-wrapper').hide();
    }
  
  };
  en4.core.runonce.add(function() {
    var value = sesJqueryObject('input[name=discount_type]:checked').val();
    jqueryObjectOfSes('#discount_type').on('change',function(e){
      changeDiscountType();
    });
    sesJqueryObject('input[name=discount_end_type]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[name=discount_end_type]',function(e){
    var value = sesJqueryObject('input[name=discount_end_type]:checked').val();
    if(value == 1){
      sesJqueryObject('#discount_end_date-wrapper').show();
    }else{
      sesJqueryObject('#discount_end_date-wrapper').hide();
    }
  });
    //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    jqueryObjectOfSes('#ecoupon_create input, #ecoupon_create select,#ecoupon_create checkbox,#ecoupon_create textarea,#ecoupon_create radio').each(
  function(index){
      var input = jqueryObjectOfSes(this);
      if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
          if(jqueryObjectOfSes(this).prop('type') == 'checkbox'){
            value = '';
            if(jqueryObjectOfSes('input[name="'+jqueryObjectOfSes(this).attr('name')+'"]:checked').length > 0) { 
              value = 1;
            };
            if(value == '')
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'select-multiple'){
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'select-one' || jqueryObjectOfSes(this).prop('type') == 'select' ){
            if(jqueryObjectOfSes(this).val() === '')
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'radio'){
            if(jqueryObjectOfSes("input[name='"+jqueryObjectOfSes(this).attr('name').replace('[]','')+"']:checked").val() === '')
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'textarea' && jqueryObjectOfSes(this).prop('id') == 'description'){
            if(tinyMCE.get('description').getContent() === '' || tinyMCE.get('description').getContent() == null)
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'textarea') {
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }else{
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }
          if(error){
            if(counter == 0)
              objectError = this;
            counter++
          }
          if(error)
            errorPresent = true;
          error = false;
        }
      }
    );
    return errorPresent ;
  }
  var isSubmit = false;
en4.core.runonce.add(function() {
  jqueryObjectOfSes('#ecoupon_create_form').submit(function(e) {
    if(isSubmit == true)
      return true;
    e.preventDefault();
    var validationFm = validateForm();
    if(validationFm) {
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
    } else {
       //check server side form validation  
       //submit form 
        sesJqueryObject('.sesbasic_loading_cont_overlay').show();
        var formData = new FormData(this);
        formData.append('is_ajax', 1);
    <?php if($settings->getSetting('ecoupon.enable.wysiwyg',1)) { ?>
        formData.append('description',tinyMCE.get('description').getContent());
    <?php } ?>
        var url = sesJqueryObject(this).attr('action');
        sesJqueryObject.ajax({
          type:'POST',
          dataType:'html',
          url: url,
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(response){
            sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
            var data = sesJqueryObject.parseJSON(response);
            if(sesJqueryObject('.form-errors').length)
              sesJqueryObject('.form-errors').remove();  
            if(data.status == 0){
              sesJqueryObject(data.message).insertBefore('.form-elements'); 
              sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
              var errorFirstObject = jqueryObjectOfSes('.form-errors');
              jqueryObjectOfSes('html, body').animate({
                scrollTop: errorFirstObject.offset().top - 20
              }, 2000);
            }else{
              isSubmit = true;
              sesJqueryObject('#submit_check').trigger('click');
            }
            <?php if($this->edit) { ?>
                if(validationFm)
                 location.reload();
            <?php } ?>
          },
          error: function(data){
            
          }
        });
    }
    return false;
  });
});
</script>
<?php  if($this->typesmoothbox) { ?>
	<script type="application/javascript">
	executetimesmoothboxTimeinterval = 400;
	executetimesmoothbox = true;
	function showHideOptionsCourses(display){
		var elem = sesJqueryObject('.ecoupon_hideelement_smoothbox');
		for(var i = 0 ; i < elem.length ; i++){
				sesJqueryObject(elem[i]).parent().parent().css('display',display);
		}
	}
	en4.core.runonce.add(function()
  {  
    tinymce.execCommand('mceRemoveEditor',true, 'description'); 
    tinymce.execCommand('mceRemoveEditor',true, 'purchase_note');
		tinymce.init({
			mode: "specific_textareas",
			plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
			theme: "modern",
			menubar: false,
			statusbar: false,
			toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
			toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
			toolbar3: "",
			element_format: "html",
			height: "225px",
      content_css: "bbcode.css",
      entity_encoding: "raw",
      add_unload_trigger: "0",
      remove_linebreaks: false,
			convert_urls: false,
			language: "<?php echo $this->language; ?>",
			directionality: "<?php echo $this->direction; ?>",
			upload_url: "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>",
			editor_selector: "tinymce"
		});
	});
  </script>	
<?php	die; 	} ?>

