
<?php
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
</script>

<div class="headline">
  <h2>
    <?php echo $this->translate('Documents Sharing');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>

<?php echo $this->form->render($this) ?>

<?php $defaultProfileFieldId = "0_0_".$this->defaultProfileId;$profile_type = 2;?>
<script type="application/javascript">
  var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
  var profile_type = '<?php echo $profile_type ?>';
  var previous_mapped_level = 0;
  function showFields(cat_value, cat_level,typed,isLoad) {
				if(sesJqueryObject('#custom_fields_enable').length > 0)
			return;

	if(isLoad == 'custom'){
		var type = typed;
	}else{
		var categoryId = getProfileType($('category_id').value);
		var subcatId = getProfileType($('subcat_id').value);
		var subsubcatId = getProfileType($('subsubcat_id').value);
		var type = categoryId+','+subcatId+','+subsubcatId;
		
	}
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
  
  
  function showSubCategory(cat_id,selectedId, isLoad) {
    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'sesdocument/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {'selected':selected},
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	  if ($('subcat_id') && responseHTML) {
	    if ($('subcat_id-wrapper')) {
	      $('subcat_id-wrapper').style.display = "block";
	    }
	    $('subcat_id').innerHTML = responseHTML;
	  } else {
	    if ($('subcat_id-wrapper')) {
	      $('subcat_id-wrapper').style.display = "none";
	      $('subcat_id').innerHTML = '<option value="0"></option>';
	    }
	  }
	  if ($('subsubcat_id-wrapper')) {
	    $('subsubcat_id-wrapper').style.display = "none";
	    $('subsubcat_id').innerHTML = '<option value="0"></option>';
	  }
	
	<?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
        showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
	if(isLoad != 'yes')
	showFields(cat_id,1);
      }
    }).send(); 
  }
  
  function showSubSubCategory(cat_id,selectedId,isLoad) {     
    var categoryId = getProfileType($('category_id').value);
  
    if(cat_id == 0){
			if ($('subsubcat_id-wrapper')) {
				$('subsubcat_id-wrapper').style.display = "none";
				$('subsubcat_id').innerHTML = '';
				document.getElementsByName("0_0_1")[0].value=categoryId;				
      }
      if(isLoad != 'yes')
      showFields(cat_id,1,categoryId);
      return false;
    }
    if(isLoad != 'yes')
    showFields(cat_id,1,categoryId);
    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'sesdocument/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {'selected':selected},
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	  if ($('subsubcat_id') && responseHTML) {
	    if ($('subsubcat_id-wrapper')) {
	      $('subsubcat_id-wrapper').style.display = "block";
	      $('subsubcat_id').innerHTML = responseHTML;
	    }					
	  }else{
	    // get category id value 						
	    if ($('subsubcat_id-wrapper')) {
	      $('subsubcat_id-wrapper').style.display = "none";
	      $('subsubcat_id').innerHTML = '<option value="0"></option>';
	    } 
	  }
	
      }
    })).send();
  }
  
  function showCustom(value,isLoad){
    var categoryId = getProfileType($('category_id').value);
    var subcatId = getProfileType($('subcat_id').value);
    var id = categoryId+','+subcatId;
    if(isLoad != 'yes')
    showFields(value,1,id,isLoad);
    if(value == 0 && typeof document.getElementsByName("0_0_1")[0] != 'undefined')
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;
  }
  
  function showCustomOnLoad(value,isLoad){
    <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
      var categoryId = getProfileType(<?php echo $this->category_id; ?>)+',';
    <?php }else{ ?>
      var categoryId = '0';
    <?php } ?>
    <?php if(isset($this->subcat_id) && $this->subcat_id != 0){ ?>
      var subcatId = getProfileType(<?php echo $this->subcat_id; ?>)+',';
    <?php  }else{ ?>
      var subcatId = '0';
    <?php } ?>
    <?php if(isset($this->subsubcat_id) && $this->subsubcat_id != 0){ ?>
      var subsubcat_id = getProfileType(<?php echo $this->subsubcat_id; ?>)+',';
    <?php  }else{ ?>
      var subsubcat_id = '0';
    <?php } ?>
    var id = (categoryId+subcatId+subsubcat_id).replace(/,+$/g,"");;
    showFields(value,1,id,'custom');
    if(value == 0 && typeof document.getElementsByName("0_0_1")[0] != 'undefined')
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;
  }
  
  sesJqueryObject(document).ready(function(e){
  var sesdevelopment = 1;
  <?php if(isset($this->category_id) && $this->category_id != 0){ ?>
    <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
  showSubCategory('<?php echo $this->category_id; ?>','<?php echo $catId; ?>','yes');
  <?php  }else{ ?>
    if($('subcat_id-wrapper'))
    $('subcat_id-wrapper').style.display = "none";
  <?php } ?>
  <?php if(isset($this->subsubcat_id)){ ?>
    if (<?php echo isset($this->subcat_id) && intval($this->subcat_id)>0 ? $this->subcat_id : 'sesdevelopment' ?> == 0) {
    $('subsubcat_id-wrapper').style.display = "none";
    } 
  <?php }else{ ?>
    $('subsubcat_id-wrapper').style.display = "none";
  <?php } ?>
  showCustomOnLoad('','no');
  });

</script>

<script type="text/javascript">
  $$('.core_main_sesdocument').getParent().addClass('active');
</script>
