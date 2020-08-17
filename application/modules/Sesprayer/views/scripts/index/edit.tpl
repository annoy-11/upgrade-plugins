<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
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


  function showSubCategory(cat_id,selectedId,isLoad) {
  
		var selected;
		if(selectedId != '')
			var selected = selectedId;
		
    var url = en4.core.baseUrl + 'sesprayer/category/subcategory/category_id/' + cat_id;
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
		
    var url = en4.core.baseUrl + 'sesprayer/category/subsubcategory/subcategory_id/' + cat_id;
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

    formObj = sesJqueryObject('#sesprayers_create').find('div').find('div').find('div');
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
  
  
    
  function addPrayer(formObject) {
  
    var validationFmPrayer = validatePrayerForm();
    
    if(sesJqueryObject('#title').val() == '') {
      alert('<?php echo $this->translate("Please fill requried fields."); ?>');
      return false;
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
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('prayer_id', '<?php echo $this->prayer_id; ?>');
    sesJqueryObject.ajax({
      url: "sesprayer/index/edit/",
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
<div class="sesprayer_create_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="sesprayer_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
      <?php echo $this->form->render($this);?>
  <?php } ?>
</div>