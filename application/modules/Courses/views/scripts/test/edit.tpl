<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php  $this->headTitle($this->test->getTitle(), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND); ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php if(!$this->typesmoothbox){ ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
  <?php }else{ ?>
    <script type="application/javascript">
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'; ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'; ?>");
    </script>
  <?php } ?>
<div class="courses_test_create_container">
  <div class="courses_test_create_form sesbasic_bxs" style="position:relative;">
    <?php echo $this->form->render($this);?>
  </div>
</div>
<script>
var ignoreValidation = window.ignoreValidation = function() {
      $('submit').style.display = "block";
      $('validation').style.display = "none";
      $('ignore').value = true;
    }
sesJqueryObject("#url").on("change keyup paste", function() {
    if(sesJqueryObject(this).val() == "")
      return;
    var url_element = document.getElementById("url-element");
    var myElement = new Element("p");
    myElement.innerHTML = "test";
    myElement.addClass("description");
    myElement.id = "validation";
    myElement.style.display = "none";
    url_element.appendChild(myElement);  
    var validationUrl = '<?php echo $this->url(array('module' => 'courses', 'controller' => 'lecture', 'action' => 'validation'), 'default', true) ?>';
    var validationErrorMessage = "<?php echo $this->translate("We could not find a video there - please check the URL and try again. If you are sure that the URL is valid, please click %s to continue.", "<a href='javascript:void(0);' onclick='javascript:ignoreValidation();'>".$this->translate("here")."</a>"); ?>";
    var checkingUrlMessage = '<?php echo $this->string()->escapeJavascript($this->translate('Checking URL...')) ?>';
    new Request.JSON({
      'url' : validationUrl,
      'data' : {
        'format': 'json',
        'uri' : sesJqueryObject(this).val(),
        'type' : 'iframely',
      },
      'onRequest' : function() {
        $('validation').style.display = "block";
        $('validation').innerHTML = checkingUrlMessage;
        $('submit').style.display = "none";
      },
      'onSuccess' : function(response) {
        if( response.valid ) {
          $('submit').style.display = "block";
          $('validation').style.display = "none";
          //$('code').value = response.iframely.code;
          if($('title').value == "")
            $('title').value = response.iframely.title;
          if($('description').value == "")
            $('description').value = response.iframely.description;
          $('validation').value = "none";
        } else {
          $('submit').style.display = "none";
          $('validation').innerHTML = validationErrorMessage;
        }
      }
    }).send();  
});
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
          // See Classroom 102 at the following URL
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
var classroomidparam = "";
function handleFileBackgroundUpload(input,id) {
  var files = sesJqueryObject(input)[0].files[0];
  var url = input.value;
  if(typeof url == 'undefined')
    url = input.files[0]['name'];
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    /* var reader = new FileReader();
    reader.onload = function (e) {  
      // $(id+'-wrapper').style.display = 'block';
      $(id).setAttribute('src', e.target.result);
    }*/
    classroomidparam = id;
    if (files) {
        orientation(files, function(base64img, value) {
          //$(id+'-wrapper').attr('src', base64img);
          sesJqueryObject(classroomidparam).closest('.form-wrapper').show();;
          var rotated = sesJqueryObject(classroomidparam).attr('src', base64img);
          if (value) {
            sesJqueryObject(classroomidparam).css('transform', rotation[value]);
          }
        });
      }
    $('photouploader-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('test_main_photo_preview').style.display = 'block';
    $('test_main_photo_preview-wrapper').style.display = 'block';
    //reader.readAsDataURL(input.files[0]);
  }
}
var rotation = {
  1: 'rotate(0deg)',
  3: 'rotate(180deg)',
  6: 'rotate(90deg)',
  8: 'rotate(270deg)'
};
function removeImage() {
    $('photouploader-element').style.display = 'block';
    $('removeimage-wrapper').style.display = 'none';
    $('removeimage1').style.display = 'none';
    $('test_main_photo_preview').style.display = 'none';
    $('test_main_photo_preview-wrapper').style.display = 'none';
    $('test_main_photo_preview').src = '';
    $('MAX_FILE_SIZE').value = '';
    $('removeimage2').value = '';
    $('photo').value = '';
}
//drag drop photo upload
en4.core.runonce.add(function()
{ 
 
  if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
      sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
  }
  $('photouploader-wrapper').style.display = 'block';
  $('test_main_photo_preview-wrapper').style.display = 'none';
  $('photo-wrapper').style.display = 'none';
  
  var obj = sesJqueryObject('#dragandrophandlerbackground');
  obj.click(function(e){
      sesJqueryObject('#photo').val('');
      sesJqueryObject('#test_main_photo_preview').attr('src','');
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
    handleFileBackgroundUpload(files,'test_main_photo_preview');
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
  <?php if($this->img_path){ ?>
    $('test_main_photo_preview-wrapper').style.display = 'block';
  <?php } ?>
});
</script>
<?php  if($this->typesmoothbox) { ?>
	<script type="application/javascript">
	executetimesmoothboxTimeinterval = 300;
	executetimesmoothbox = true;
	function showHideOptionsCourses(display){
		var elem = sesJqueryObject('.courses_hideelement_smoothbox');
		for(var i = 0 ; i < elem.length ; i++){
				sesJqueryObject(elem[i]).parent().parent().css('display',display);
		}
	}
	en4.core.runonce.add(function()
  {
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


