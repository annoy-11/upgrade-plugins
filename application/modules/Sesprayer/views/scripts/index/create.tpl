<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css');
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

  //SES Custom Work
  function showposttypecreate(value) {
    if(value == 1) {
      if($('networks-wrapper'))
        $('networks-wrapper').style.display = 'block';
      if($('lists-wrapper'))
        $('lists-wrapper').style.display = 'none';
      if($('friendid-wrapper'))
        $('friendid-wrapper').style.display = 'none';
    } else if(value == 2) { 
      if($('networks-wrapper'))
        $('networks-wrapper').style.display = 'none';
      if($('lists-wrapper'))
        $('lists-wrapper').style.display = 'block';
      if($('friendid-wrapper'))
        $('friendid-wrapper').style.display = 'none';
    } else if(value == 3) { 
      if($('networks-wrapper'))
        $('networks-wrapper').style.display = 'none';
      if($('lists-wrapper'))
        $('lists-wrapper').style.display = 'none';
      if($('friendid-wrapper'))
        $('friendid-wrapper').style.display = 'block';
    } else if(value == 0) {
      if($('networks-wrapper'))
        $('networks-wrapper').style.display = 'none';
      if($('lists-wrapper'))
        $('lists-wrapper').style.display = 'none';
      if($('friendid-wrapper'))
        $('friendid-wrapper').style.display = 'none';
    }
  }
  //SES Custom Work

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
      'url' : '<?php echo $this->url(array('module' => 'sesprayer', 'controller' => 'index', 'action' => 'get-iframely-information'), 'default', true) ?>',
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
    var url = en4.core.baseUrl + 'sesprayer/category/subcategory/category_id/'+cat_id;
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
		
    var url = en4.core.baseUrl + 'sesprayer/category/subsubcategory/subcategory_id/' + cat_id;
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
    showposttypecreate(0);
    formObj = sesJqueryObject('#sesprayers_create').find('div').find('div').find('div');
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
  
  en4.core.runonce.add(function() {
    
    var contentAutocomplete = new Autocompleter.Request.JSON('friendid', "<?php echo $this->url(array('module' => 'sesprayer', 'controller' => 'index', 'action' => 'getusers'), 'default', true) ?>", {
      'postVar': 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'injectChoice': function(token) {
        var choice = new Element('li', {
          'class': 'autocompleter-choices', 
          'html': token.photo, 
          'id':token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
      $('user_id').value = selected.retrieve('autocompleteChoice').id;
    });
  });
  
    
  function addPrayer(formObject) {
  
    var validationFmPrayer = validatePrayerForm();
    
    if(sesJqueryObject('#title').val() == '') {
      //alert('<?php echo $this->translate("Please fill requried fields."); ?>');
      //return false;
    }

    if(validationFmPrayer) {
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
      submitPrayer(formObject);
    }
  }
  

  function submitPrayer(formObject) {
  
    sesJqueryObject('#sesprayer_overlay').show();
    if(!sesJqueryObject(formObject).find('#photo-wrapper').find('#photo-element').find('#photo').val()){
       sesJqueryObject(formObject).find('#photo-wrapper').find('#photo-element').find('#photo').remove();
    }
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    sesJqueryObject.ajax({
      url: "sesprayer/index/create/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sesprayer_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='sesprayer_success_message' class='sesprofilefield_success_message sesprayer_success_message'><i class='fa-check-circle-o'></i><span>You have successfully posted discussion.</span></div>");

          sesJqueryObject('#sesprayer_success_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
              var url = '<?php echo $this->url(array('action' => 'manage'), 'sesprayer_general', true); ?>';
              window.location.href = url;
              
            }, 1000);
          });
        }
      }
    });
  }
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css'); ?>
<div class="sesprayer_create_popup sesbasic_bxs sesprayer_create_popup">
  <?php if(empty($this->is_ajax) ) { ?>
      <?php echo $this->form->render($this);?>
  <?php } ?>
  <div class="sesbasic_loading_cont_overlay" id="sesprayer_overlay"></div>
</div>
<?php die; ?>