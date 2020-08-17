<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seswishe/externals/styles/styles.css');
  if (APPLICATION_ENV == 'production')
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
  else
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>
<script type="text/javascript">

  var checkingUrlMessage = '<?php echo $this->string()->escapeJavascript($this->translate('Checking URL...')) ?>';

  function showMediaType(value) {
  
    if(value == 1) {
      if($('photo-wrapper'))
        $('photo-wrapper').style.display = 'block';
      if($('video-wrapper'))
        $('video-wrapper').style.display = 'none';
      if($('video'))
        $('video').value = '';
    } else if(value == 2) { 
      if($('photo-wrapper'))
        $('photo-wrapper').style.display = 'none';
      if($('video-wrapper'))
        $('video-wrapper').style.display = 'block';
    }
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
      'url' : '<?php echo $this->url(array('module' => 'seswishe', 'controller' => 'index', 'action' => 'get-iframely-information'), 'default', true) ?>',
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
    var url = en4.core.baseUrl + 'seswishe/category/subcategory/category_id/'+cat_id;
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

		if(cat_id == 0) {
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
		
    var url = en4.core.baseUrl + 'seswishe/category/subsubcategory/subcategory_id/' + cat_id;
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

  en4.core.runonce.add(function() {
    showMediaType(1);
    formObj = sesJqueryObject('#seswishes_create').find('div').find('div').find('div');
    formObj.find('#subcat_id-wrapper').hide();
    formObj.find('#subsubcat_id-wrapper').hide();

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
  
    
  function addWishe(formObject) {
  
    var validationFmWishe = validateWisheForm();
    
    if(sesJqueryObject('#title').val() == '') {
      alert('<?php echo $this->translate("Please fill requried fields."); ?>');
      return false;
    }

    if(validationFmWishe) {
      
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
      submitWishe(formObject);
    }
  }
  

  function submitWishe(formObject) {
  
    sesJqueryObject('#seswishe_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    sesJqueryObject.ajax({
      url: "seswishe/index/create/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#seswishe_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='seswishe_success_message' class='sesprofilefield_success_message seswishe_success_message'><i class='fa-check-circle-o'></i><span>You have successfully posted discussion.</span></div>");

          sesJqueryObject('#seswishe_success_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
              var url = '<?php echo $this->url(array('action' => 'manage'), 'seswishe_general', true); ?>';
              window.location.href = url;
              
            }, 1000);
          });
        }
      }
    });
  }
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seswishe/externals/styles/styles.css'); ?>
<div class="seswishe_create_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="seswishe_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
      <?php echo $this->form->render($this);?>
  <?php } ?>
</div>