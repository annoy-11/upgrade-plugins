<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->typesmoothbox){ ?>
<script>
Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'; ?>");
</script>
<?php } ?>
<?php $options = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.options', 'a:4:{i:0;s:5:"topic";i:1;s:5:"photo";i:2;s:5:"video";i:3;s:4:"link";}'));
if(count($options) == 1) {
  $option_array = array();
  if(in_array('topic', $options)) {
    $option = 4;
  } else if(in_array('photo', $options)) { 
    $option = 1;
  } else if(in_array('video', $options)) { 
    $option = 2;
  } else if(in_array('link', $options)) {
    $option = 3;
  }
}

 ?>
<script type="text/javascript">

  var checkingUrlMessage = '<div class="check"><?php echo $this->string()->escapeJavascript($this->translate('Checking URL...')) ?></div>';
  
  //Show choose image 
  function showReadImage(input,id) {
    var url = input.value; 
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
      var reader = new FileReader();
      reader.onload = function (e) {
        $(id+'-wrapper').style.display = 'block';
        $(id).setAttribute('src', e.target.result);
      }
      $(id+'-wrapper').style.display = 'block';
      $('photolink').value = '';
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  function showMediaType(value) {
  
    if(value == 1) {
      $('photo-wrapper').style.display = 'block';
      $('video-wrapper').style.display = 'none';
      $('link-wrapper').style.display = 'none';
      $('video').value = '';
    } else if(value == 2) { 
      $('photo-wrapper').style.display = 'none';
      $('video-wrapper').style.display = 'block';
      $('link-wrapper').style.display = 'none';
    } else if(value == 3) { 
      $('photo-wrapper').style.display = 'block';
      $('video-wrapper').style.display = 'none';
      $('link-wrapper').style.display = 'block';
    } else if(value == 4) { 
      $('photo-wrapper').style.display = 'none';
      $('video-wrapper').style.display = 'none';
      $('link-wrapper').style.display = 'none';
    }
  }

  function linkurl() {
  
    var url_element = document.getElementById("link-element");
    var myElement = new Element("p");
    myElement.innerHTML = "test";
    myElement.addClass("description");
    myElement.id = "validation";
    myElement.style.display = "none";
    url_element.appendChild(myElement);
  
    var url = $('link').value;
    if(url == '') {
      return false;
    }
    
    new Request.JSON({
      'url' : '<?php echo $this->url(array('module' => 'sesdiscussion', 'controller' => 'index', 'action' => 'preview'), 'default', true) ?>',
      'data' : {
        'format': 'json',
        'uri' : url,
      },
      'onRequest' : function() {
        $('validation').style.display = "block";
        $('validation').innerHTML = checkingUrlMessage;
      },
      'onSuccess' : function(response) {
        if( response.valid ) {
        
          $('validation').style.display = "block";
          $('validation').innerHTML = "<div class='valid'>Your url is valid.</div>";
          
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.editortype', 0)) { ?>
            tinymce.activeEditor.setContent(response.description);
          <?php } ?>
          
          //if($('discussiontitle').value == '')
            $('discussiontitle').value = response.title;
          //if($('title').value == '')
            $('title').value = response.description;
          if(response.images) {
              $('photolink').value = response.images;
                    
              if($('photo_preview-wrapper')) {
                $('photo_preview-wrapper').style.display = 'block';
                $('photo_preview').setAttribute('src', response.images);
              }
          } else {
              $('photolink').value = '';
                    
              if($('photo_preview-wrapper')) {
                $('photo_preview-wrapper').style.display = 'none';
                $('photo_preview').setAttribute('src', '');
              }
          }
        } else {
          $('validation').style.display = "block";
          $('validation').innerHTML = '<div class="error">We could not find any thing there - please check the URL and try again.</div>';
        }
      }
    }).send();
  }

  function iframelyurl() {
  
    var url_element = document.getElementById("video-element");
    var myElement = new Element("p");
    myElement.innerHTML = "test";
    myElement.addClass("description");
    myElement.id = "validation";
    myElement.style.display = "none";
    url_element.appendChild(myElement);
  
    var url = $('video').value;
    if(url == '') {
      return false;
    }
    new Request.JSON({
      'url' : '<?php echo $this->url(array('module' => 'sesdiscussion', 'controller' => 'index', 'action' => 'get-iframely-information'), 'default', true) ?>',
      'data' : {
        'format': 'json',
        'uri' : url,
      },
      'onRequest' : function() {
        $('validation').style.display = "block";
        $('validation').innerHTML = checkingUrlMessage;
      },
      'onSuccess' : function(response) {
        if( response.valid ) {
          $('validation').style.display = "block";
          $('validation').innerHTML = "Your url is valid.";
          
          if($('discussiontitle').value == '')
            $('discussiontitle').value = response.iframely.title;
          if($('title').value == '')
            $('title').value = response.iframely.description;
        } else {
          $('validation').style.display = "block";
          $('validation').innerHTML = 'We could not find a video there - please check the URL and try again.';
        }
      }
    }).send();
  }

  function showSubCategory(cat_id,selectedId) {
  
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesdiscussion/category/subcategory/category_id/'+cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if (formObj.find('#subcat_id-wrapper').length && responseHTML) {
          formObj.find('#subcat_id-wrapper').show();
          formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html(responseHTML);
        } else {
          if (formObj.find('#subcat_id-wrapper').length) {
            formObj.find('#subcat_id-wrapper').hide();
            formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html( '<option value="0"></option>');
          }
        }
			  if (formObj.find('#subsubcat_id-wrapper').length) {
          formObj.find('#subsubcat_id-wrapper').hide();
          formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
        }
      }
    }).send(); 
  }
  
	function showSubSubCategory(cat_id,selectedId,isLoad) {

		if(cat_id == 0){
			if (formObj.find('#subsubcat_id-wrapper').length) {
        formObj.find('#subsubcat_id-wrapper').hide();
        formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
      }
			return false;
		}

		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
		
    var url = en4.core.baseUrl + 'sesdiscussion/category/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if (formObj.find('#subsubcat_id-wrapper').length && responseHTML) {
          formObj.find('#subsubcat_id-wrapper').show();
          formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html(responseHTML);
        } else {
          if (formObj.find('#subsubcat_id-wrapper').length) {
            formObj.find('#subsubcat_id-wrapper').hide();
            formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
          }
        }
			}
    })).send();  
  }

  en4.core.runonce.add(function()
  {
    <?php if(count($options) == 1 && $option) { ?>
      showMediaType('<?php echo $option ?>');
    <?php } else { ?>
      showMediaType(4);
    <?php } ?>
    
    <?php if($this->createform) { ?>
      formObj = sesJqueryObject('#sesdiscussions_create').find('div').find('div').find('div');
      formObj.find('#subcat_id-wrapper').hide();
      formObj.find('#subsubcat_id-wrapper').hide();
    <?php } else { ?>
      formObj = sesJqueryObject('#sesdiscussion_create').find('div').find('div').find('div');
      formObj.find('#subcat_id-wrapper').hide();
      formObj.find('#subsubcat_id-wrapper').hide();
    <?php } ?>
    
    if($('photo_preview-wrapper'))
      $('photo_preview-wrapper').style.display = 'none';

    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'customChoices' : true,
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
  
  <?php if($this->createform) { ?>
  function addDiscussion(formObject) {
  
    var validationFm = validateForm();

    if(validationFm) {
      
      var input = sesJqueryObject(formObject);
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined') {
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
          sesJqueryObject('html, body').animate({
          scrollTop: errorFirstObject.offset().top
        }, 2000);
      }

      return false;
    } else {
      submitDiscussion(formObject);
    }
  }
  

  function submitDiscussion(formObject) {
  
    sesJqueryObject('#sesdiscussion_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    sesJqueryObject.ajax({
      url: "sesdiscussion/index/create/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sesdiscussion_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='sesdiscussion_success_message' class='sesprofilefield_success_message sesdiscussion_success_message'><i class='fa-check-circle-o'></i><span>You have successfully posted discussion.</span></div>");

          sesJqueryObject('#sesdiscussion_success_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
              window.location.href = result.url;
            }, 1000);
          });
        }
      }
    });
  }
  <?php } ?>
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css'); ?>

<?php if(empty($this->createform)) { ?>
  <div class="sesdiscussion_create_form sesbasic_bxs">
    <?php echo $this->form->render($this);?>
  </div>
<?php } else { ?>
  <div class="sesdiscussion_create_form sesbasic_bxs">
    <div class="sesbasic_loading_cont_overlay" id="sesdiscussion_overlay"></div>
    <?php if(empty($this->is_ajax) ) { ?>
        <?php echo $this->form->render($this);?>
    <?php } ?>
  </div>
<?php } ?>

<?php if($this->typesmoothbox) { ?>
	<script type="application/javascript">
    en4.core.runonce.add(function() {
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
