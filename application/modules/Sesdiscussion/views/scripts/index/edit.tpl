<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->createform){ ?>
<script>
Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'; ?>");
</script>
<?php } ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesdiscussion/externals/styles/styles.css'); ?>

<script type="text/javascript">

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

  function showSubCategory(cat_id,selectedId,isLoad) {
  
		var selected;
		if(selectedId != '')
			var selected = selectedId;
		
    var url = en4.core.baseUrl + 'sesdiscussion/category/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
        'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if (formObj.find('#subcat_id-wrapper')) {
            formObj.find('#subcat_id-wrapper').show();
          }
          formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').html(responseHTML);
        } else {
          if (formObj.find('#subcat_id-wrapper')) {
            formObj.find('#subcat_id-wrapper').hide();
            $('subcat_id').innerHTML = '<option value="0"></option>';
          }
        }
			  if (formObj.find('#subsubcat_id-wrapper')) {
					formObj.find('#subsubcat_id-wrapper').hide();
					$('subsubcat_id').innerHTML = '<option value="0"></option>';
				}
      }
    }).send();
  }
  
	function showSubSubCategory(cat_id,selectedId,isLoad) {

		if(cat_id == 0) {
			if (formObj.find('#subsubcat_id-wrapper')) {
				formObj.find('#subsubcat_id-wrapper').hide();
				$('subsubcat_id').innerHTML = '';
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
        if ($('subsubcat_id') && responseHTML) {
          if (formObj.find('#subsubcat_id-wrapper')) {
            formObj.find('#subsubcat_id-wrapper').show();
            formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html(responseHTML);
          }
       } else {
					// get category id value
					if (formObj.find('#subsubcat_id-wrapper')) {
						formObj.find('#subsubcat_id-wrapper').hide();
						$('subsubcat_id').innerHTML = '<option value="0"></option>';
					} 
				}
			}
    })).send();
  }

  en4.core.runonce.add(function() {
    
    <?php if(!$this->discussion->photo_id) { ?>
      if($('photo_preview-wrapper'))
        $('photo_preview-wrapper').style.display = 'none';
    <?php } ?>
    <?php if($this->createform) { ?>
      formObj = sesJqueryObject('#sesdiscussions_create').find('div').find('div').find('div');
    <?php } else { ?>
      formObj = sesJqueryObject('#sesdiscussion_create').find('div').find('div').find('div');
    <?php } ?>
    var sesdevelopment = 1;
    
    <?php if(isset($this->category_id) && $this->category_id != 0) { ?>
			<?php if(isset($this->subcat_id)) { $catId = $this->subcat_id; } else $catId = ''; ?>
      showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
    <?php  } else { ?>
      formObj.find('#subcat_id-wrapper').hide();
    <?php } ?>
    
	  <?php if(isset($this->subsubcat_id)) { ?>
      if (<?php echo isset($this->subcat_id) && intval($this->subcat_id)>0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
       formObj.find('#subsubcat_id-wrapper').hide();
      } else {
        <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
        showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
      }
    <?php } else { ?>
      formObj.find('#subsubcat_id-wrapper').hide();
	  <?php } ?>
  });

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
      formData.append('discussion_id', '<?php echo $this->discussion_id; ?>');
      sesJqueryObject.ajax({
        url: "sesdiscussion/index/edit/",
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
<?php if(!empty($this->createform)) { ?>
  <div class="sesdiscussion_create_form sesbasic_bxs">
    <div class="sesbasic_loading_cont_overlay" id="sesdiscussion_overlay"></div>
    <?php if(empty($this->is_ajax) ) { ?>
        <?php echo $this->form->render($this);?>
    <?php } ?>
  </div>
<?php } else { ?>
  <div class="sesdiscussion_create_form sesbasic_bxs">
    <?php echo $this->form->render($this);?>
  </div>
<?php } ?>

<?php if($this->createform) { ?>
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
