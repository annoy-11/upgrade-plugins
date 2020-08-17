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
<?php  $this->headTitle($this->lecture->getTitle(), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND); ?>
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
<script type="text/javascript">
  function removeLastMinus (myUrl) {
    if (myUrl.substring(myUrl.length-1) == "-") {
      myUrl = myUrl.substring(0, myUrl.length-1);
    }
    return myUrl;
  }
  var changeTitle = true;
  en4.core.runonce.add(function() {
    //auto fill custom url value
    sesJqueryObject("#title").keyup(function(){
      var Text = sesJqueryObject(this).val();
      if(!changeTitle)
      return;
      Text = Text.toLowerCase();
      Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
      Text = removeLastMinus(Text);
      sesJqueryObject("#custom_url").val(Text);        
    });
    sesJqueryObject("#title").blur(function(){
      if(sesJqueryObject(this).val()){
        changeTitle = false;
      }
    });
  });
  function checkAvailsbility(submitform) {
    var custom_url_value = jqueryObjectOfSes('#custom_url').val();
    if(!custom_url_value && typeof submitform == 'undefined')
    return;
    jqueryObjectOfSes('#course_custom_url_wrong').hide();
    jqueryObjectOfSes('#course_custom_url_correct').hide();
    jqueryObjectOfSes('#course_custom_url_loading').css('display','inline-block');
    jqueryObjectOfSes.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'courses', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
      jqueryObjectOfSes('#course_custom_url_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
        jqueryObjectOfSes('#course_custom_url_correct').hide();
        jqueryObjectOfSes('#courses_custom_url_wrong').css('display','inline-block');
        if(typeof submitform != 'undefined') {
          alert('<?php echo $this->translate("Custom URL is not available. Please select another URL."); ?>');
          var errorFirstObject = jqueryObjectOfSes('#custom_url').parent().parent();
          jqueryObjectOfSes('html, body').animate({
          scrollTop: errorFirstObject.offset().top
          }, 2000);
        }
      } else{
        jqueryObjectOfSes('#custom_url').val(response.value);
        jqueryObjectOfSes('#course_custom_url_wrong').hide();
        jqueryObjectOfSes('#course_custom_url_correct').css('display','inline-block');
        if(typeof submitform != 'undefined') {
          jqueryObjectOfSes('#upload').attr('disabled',true);
          jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
          jqueryObjectOfSes('#submit_check').trigger('click');
        }
      }
    });
  }
</script>
<div class="courses_lecture_create_container">
  <div class="courses_lecture_create_form sesbasic_bxs" style="position:relative;">
    <?php echo $this->form->render($this);?>
  </div>
</div>
<script>
  function updateTextFields(value) { 
      if(value == 'html'){
        sesJqueryObject('#htmltext-wrapper').show();
        sesJqueryObject('#Filedata-wrapper').hide();
        sesJqueryObject('#url-wrapper').hide();
        sesJqueryObject('#photo_id-wrapper').hide();
        sesJqueryObject('#upload_video-wrapper').hide();
      } else if(value == 'internal') {
         sesJqueryObject('#htmltext-wrapper').hide();
        //sesJqueryObject('#Filedata-wrapper').show();
        sesJqueryObject('#upload_video-wrapper').show();
        sesJqueryObject('#url-wrapper').hide();
         sesJqueryObject('#photo_id-wrapper').show(); 
      } else if(value == 'external') {
        sesJqueryObject('#htmltext-wrapper').hide();
        sesJqueryObject('#Filedata-wrapper').hide();
        sesJqueryObject('#url-wrapper').show();
        sesJqueryObject('#photo_id-wrapper').hide();
        sesJqueryObject('#upload_video-wrapper').hide();
      }
  }
var ignoreValidation = window.ignoreValidation = function() {
      $('submit').style.display = "block";
      $('validation').style.display = "none";
      $('ignore').value = true;
    }
en4.core.runonce.add(function(){  
  updateTextFields('<?php echo $this->type; ?>');
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
});
</script>
<?php  if($this->typesmoothbox) { ?>
	<script type="application/javascript">
	executetimesmoothboxTimeinterval = 200;
	executetimesmoothbox = true;
	function showHideOptionsCourses(display){
		var elem = sesJqueryObject('.courses_hideelement_smoothbox');
		for(var i = 0 ; i < elem.length ; i++){
				sesJqueryObject(elem[i]).parent().parent().css('display',display);
		}
	}
	en4.core.runonce.add(function()
  {  
    tinymce.execCommand('mceRemoveEditor',true, 'description'); 
    tinymce.execCommand('mceRemoveEditor',true, 'htmltext');
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

