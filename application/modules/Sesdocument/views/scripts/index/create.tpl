

<?php if (($this->current_count >= $this->quota) && !empty($this->quota)){ ?>
<div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
        <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesdocument_general'));?>
    </span>
</div>
<br/>
<?php
    return;
} else if(!empty($this->error_doc_full)){ ?>
    <div class="tip">
        <span>
            <?php echo $this->driveObject->getAboutError(); ?>
        </span>
     </div>
<?php return; } ?>
<div class="sesdocument_create sesbasic_bxs">
  <?php echo $this->form->render($this); ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?> 

<?php 
$defaultProfileFieldId = "0_0_$this->defaultProfileId";
$profile_type = 2;
?>
<?php echo $this->partial('_customFields.tpl', 'sesbasic', array()); ?>

<script type="text/javascript">

    function removeLastMinus (myUrl)
    {
        if (myUrl.substring(myUrl.length-1) == "-")
        {
            myUrl = myUrl.substring(0, myUrl.length-1);
        }
        return myUrl;
    }
    var changeTitle = true;
    var validUrl = true;
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
    sesJqueryObject("#custom_url").blur(function(){
				validUrl = false;
				sesJqueryObject('#check_custom_url_availability').trigger('click');
		});
    //function ckeck url availability
    sesJqueryObject('#check_custom_url_availability').click(function(){
      var custom_url_value = sesJqueryObject('#custom_url').val();
      if(!custom_url_value)
        return;
      sesJqueryObject('#sesdocument_custom_url_wrong').hide();
      sesJqueryObject('#sesdocument_custom_url_correct').hide();
      sesJqueryObject('#sesdocument_custom_url_loading').css('display','inline-block');
      sesJqueryObject.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'sesdocument', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
            sesJqueryObject('#sesdocument_custom_url_loading').hide();
            response = sesJqueryObject.parseJSON(response);
            if(response.error){
              validUrl = false;
              sesJqueryObject('#sesdocument_custom_url_correct').hide();
              sesJqueryObject('#sesdocument_custom_url_wrong').css('display','inline-block');
            }else{
                validUrl = true;
                sesJqueryObject('#custom_url').val(response.value);
                sesJqueryObject('#sesdocument_custom_url_wrong').hide();
                sesJqueryObject('#sesdocument_custom_url_correct').css('display','inline-block');
            }
        });
    });
  });
  
  en4.core.runonce.add(function() {
		//tags
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

  var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
  var profile_type = '<?php echo $profile_type ?>';
  var previous_mapped_level = 0;
	
  function showFields(cat_value, cat_level,typed,isLoad) {
		var categoryId = getProfileType(formObj.find('#category_id-wrapper').find('#category_id-element').find('#category_id').val());
		var subcatId = getProfileType(formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').val());
		var subsubcatId = getProfileType(formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').val());
		var type = categoryId+','+subcatId+','+subsubcatId;
    if (cat_level == 1 || (previous_mapped_level >= cat_level && previous_mapped_level != 1) || (profile_type == null || profile_type == '' || profile_type == 0)) {
      profile_type = getProfileType(cat_value);
      if (profile_type == 0) {
        profile_type = '';
      } else {
        previous_mapped_level = cat_level;
      }
      $(defaultProfileFieldId).value = profile_type;
      changeFields($(defaultProfileFieldId),null,isLoad,type);
    }
  }
  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'sesdocument')->getMapping(array('category_id', 'profile_type'))); ?>;
		  for (i = 0; i < mapping.length; i++) {	
      	if (mapping[i].category_id == category_id)
        return mapping[i].profile_type;
    	}
    return 0;
  }
  en4.core.runonce.add(function() {
    var defaultProfileId = '<?php echo '0_0_' . $this->defaultProfileId ?>' + '-wrapper';
     if ($type($(defaultProfileId)) && typeof $(defaultProfileId) != 'undefined') {
      $(defaultProfileId).setStyle('display', 'none');
    }
  });
  function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesdocument/ajax/subcategory/category_id/' + cat_id;
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
				showFields(cat_id,1);
      }
    }).send(); 
  }
	function showSubSubCategory(cat_id,selectedId,isLoad) {
		var categoryId = getProfileType($('category_id').value);
		if(cat_id == 0){
			if (formObj.find('#subsubcat_id-wrapper').length) {
            formObj.find('#subsubcat_id-wrapper').hide();
            formObj.find('#subsubcat_id-wrapper').find('#subsubcat_id-element').find('#subsubcat_id').html( '<option value="0"></option>');
						document.getElementsByName("0_0_1")[0].value=categoryId;		
      }
			showFields(cat_id,1,categoryId);
			return false;
		}
		showFields(cat_id,1,categoryId);
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesdocument/ajax/subsubcategory/subcategory_id/' + cat_id;
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
	function showCustom(value,isLoad){
		var categoryId = getProfileType(formObj.find('#category_id-wrapper').find('#category_id-element').find('#category_id').val());
		var subcatId = getProfileType(formObj.find('#subcat_id-wrapper').find('#subcat_id-element').find('#subcat_id').val());
		var id = categoryId+','+subcatId;
			showFields(value,1,id,isLoad);
		if(value == 0)
			document.getElementsByName("0_0_1")[0].value=subcatId;	
			return false;
	}
	function showCustomOnLoad(value,isLoad){
	 <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
		var categoryId = getProfileType(<?php echo $this->category_id; ?>)+',';
		<?php if(isset($this->subcat_id) && $this->subcat_id != 0){ ?>
		var subcatId = getProfileType(<?php echo $this->subcat_id; ?>)+',';
		<?php  }else{ ?>
		var subcatId = '';
		<?php } ?>
		<?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
		var subsubcat_id = getProfileType(<?php echo $this->subsubcat_id; ?>)+',';
		<?php  }else{ ?>
		var subsubcat_id = '';
		<?php } ?>
		var id = (categoryId+subcatId+subsubcat_id).replace(/,+$/g,"");;
			showFields(value,1,id,isLoad);
		if(value == 0)
			document.getElementsByName("0_0_1")[0].value=subcatId;	
			return false;
		<?php }else{ ?>
			showFields(value,1,'',isLoad);
		<?php } ?>
	}
   en4.core.runonce.add(function(){
		 	formObj = sesJqueryObject('#sesdocument_create_form').find('div').find('div').find('div');
			var sesdevelopment = 1;
			<?php if(isset($this->category_id) && $this->category_id != 0){ ?>
					<?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
					showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
			 <?php  }else{ ?>
				formObj.find('#subcat_id-wrapper').hide();
			 <?php } ?>
			 <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
				if (<?php echo isset($this->subcat_id) && intval($this->subcat_id) > 0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
				 formObj.find('#subsubcat_id-wrapper').hide();
				} else {
					<?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
					showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
				}
			 <?php }else{ ?>
					 formObj.find('#subsubcat_id-wrapper').hide();
			 <?php } ?>
	 		showCustomOnLoad('','no');
  });
</script>

