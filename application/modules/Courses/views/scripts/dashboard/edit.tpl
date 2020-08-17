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
<?php
  if (APPLICATION_ENV == 'course')
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js');
  else
    $this->headScript()
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
      ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php if(!$this->is_ajax){ ?>
  <?php
  echo $this->partial('dashboard/left-bar.tpl', 'courses', array(
  'course' => $this->course,
  ));	
  ?>
  <div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<div class="courses_dashboard_form courses_create_form sesbasic_bxs">
  <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
    </div>
      </div>
  </div>
<?php } ?>
<?php $defaultProfileFieldId = "0_0_".$this->defaultProfileId; $profile_type = 2;?>
<?php echo $this->partial('_customFields.tpl', 'courses', array()); ?>

<script type="text/javascript">

  var contentAutocompleteUpsell;
  en4.core.runonce.add(function () {
    contentAutocompleteUpsell = new Autocompleter.Request.JSON('upsell', "<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'upsell-course','course_id'=>($this->course ? $this->course->getIdentity() : "")), 'default', true) ?>", {
      'postVar': 'text',
      'minLength': 1,
      'delay' : 250,
      'selectMode': 'pick',
      'autocompleteType': 'message',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest message-autosuggest',
      'postData': {
        //'share_type': 'self_profile'
      },
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
    contentAutocompleteUpsell.addEvent('onSelection', function(element, selected, value, input) {
      //$('upsell_id').value = selected.retrieve('autocompleteChoice').id;

      var shareItem = selected.retrieve('autocompleteChoice');
      if($('upsell_id').value) {
        var str = $('upsell_id').value;
        var split_str = str.split(",");
        var notAddagain = false;
        for (var i = 0; i < split_str.length; i++) {
          if (split_str[i] == shareItem.id) {
            notAddagain = true;
          }
        }

        if(notAddagain == false) {
          $('upsell_id').value = $('upsell_id').value+','+shareItem.id;
          var shareItemmyElementPrivate = new Element('span', {'id' : 'upsell_remove_'+shareItem.id, 'class' : 'courses_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValueUpsell('+shareItem.id+');">x</a>'
          });
          $('upsell-element').appendChild(shareItemmyElementPrivate);
          $('upsell-element').setStyle('height', 'auto');
          //$('upsell-element').addClass('dnone');
          $('upsell').value = '';
        }
      } else {
        $('upsell_id').value = shareItem.id;
        var shareItemmyElementPrivate = new Element('span', {'id' : 'upsell_remove_'+shareItem.id, 'class' : 'courses_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValueUpsell('+shareItem.id+');">x</a>'
        });
        $('upsell-element').appendChild(shareItemmyElementPrivate);
        $('upsell-element').setStyle('height', 'auto');
        //$('upsell-element').addClass('dnone');
        $('upsell').value = '';
      }
    });
  });
  
  function removeToValueUpsell(id, toValueArray){
    for (var i = 0; i < toValueArray.length; i++){
      if (toValueArray[i]==id) toValueIndex =i;
    }

    toValueArray.splice(toValueIndex, 1);
    $('upsell_id').value = toValueArray.join();
  }
  
  function removeFromToValueUpsell(id) {
  
    var toValues = $('upsell_id').value;
    var toValueArray = toValues.split(",");
    removeToValueUpsell(id, toValueArray);

    $('upsell-element').removeClass('dnone');
    if ($('upsell_remove_'+id)) {
      $('upsell_remove_'+id).destroy();
    }
  }
 
  // cross sell
   var contentAutocompleteCrossSell;
  en4.core.runonce.add(function () {
    <?php if(!empty($this->crosssells)){ ?>
        sesJqueryObject('#crosssell-element').append('<?php echo $this->crosssells; ?>');
    <?php } ?>
    <?php if(!empty($this->upsells)){ ?>
        sesJqueryObject('#upsell-element').append('<?php echo $this->upsells; ?>');
    <?php } ?>
    contentAutocompleteCrossSell = new Autocompleter.Request.JSON('crosssell', "<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'upsell-course','course_id'=>($this->course ? $this->course->getIdentity() : "")), 'default', true) ?>", {
      'postVar': 'text',
      'minLength': 1,
      'delay' : 250,
      'selectMode': 'pick',
      'autocompleteType': 'message',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest message-autosuggest',
      'postData': {
        //'share_type': 'self_profile'
      },
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
    contentAutocompleteCrossSell.addEvent('onSelection', function(element, selected, value, input) {
      //$('crosssell_id').value = selected.retrieve('autocompleteChoice').id;
      var shareItem = selected.retrieve('autocompleteChoice');
      if($('crosssell_id').value) {
        var str = $('crosssell_id').value;
        var split_str = str.split(",");
        var notAddagain = false;
        for (var i = 0; i < split_str.length; i++) {
          if (split_str[i] == shareItem.id) {
            notAddagain = true;
          }
        }

        if(notAddagain == false) {
          $('crosssell_id').value = $('crosssell_id').value+','+shareItem.id;
          var shareItemmyElementPrivate = new Element('span', {'id' : 'crosssell_remove_'+shareItem.id, 'class' : 'courses_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValueCrossSell('+shareItem.id+');">x</a>'
          });
          $('crosssell-element').appendChild(shareItemmyElementPrivate);
          $('crosssell-element').setStyle('height', 'auto');
          //$('crosssell-element').addClass('dnone');
          $('crosssell').value = '';
        }
      } else {
        $('crosssell_id').value = shareItem.id;
        var shareItemmyElementPrivate = new Element('span', {'id' : 'crosssell_remove_'+shareItem.id, 'class' : 'courses_tag tag', 'html' :  shareItem.label  + ' <a href="javascript:void(0);" ' + 'onclick="removeFromToValueCrossSell('+shareItem.id+');">x</a>'
        });
        $('crosssell-element').appendChild(shareItemmyElementPrivate);
        $('crosssell-element').setStyle('height', 'auto');
        //$('crosssell-element').addClass('dnone');
        $('crosssell').value = '';
      }
    });
  });
  
  function removeToValueCrossSell(id, toValueArray){
    for (var i = 0; i < toValueArray.length; i++){
      if (toValueArray[i]==id) toValueIndex =i;
    }
    toValueArray.splice(toValueIndex, 1);
    $('crosssell_id').value = toValueArray.join();
  }
  
  function removeFromToValueCrossSell(id) {  
    var toValues = $('crosssell_id').value;
    var toValueArray = toValues.split(",");
    removeToValueCrossSell(id, toValueArray);
    $('crosssell-element').removeClass('dnone');
    if ($('crosssell_remove_'+id)) {
      $('crosssell_remove_'+id).destroy();
    }
  }
  
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
  function hideShow(obj){
    var id = sesJqueryObject(obj).attr('id');
    
  }
  function hideShow(obj){
    var maxDiv = sesJqueryObject('#hiddenDic').val();
    var object = sesJqueryObject(obj);
    var id = object.attr('id');
    if(sesJqueryObject('.content_'+id).css('display') == 'block')
      return;  
    sesJqueryObject('#img_'+id).find('img').attr('src','application/modules/Courses/externals/images/downarrow.png');
    sesJqueryObject('.content_'+id).slideDown('slow');
    for(i=1;i<=maxDiv;i++){
      if(sesJqueryObject('.content_'+i).css('display') == 'block' && i != id){  
         sesJqueryObject('#img_'+i).find('img').attr('src','application/modules/Courses/externals/images/leftarrow.png');
         sesJqueryObject('.content_'+i).slideUp('slow');
         break;
      }
    }
  }
  <?php if(!empty($this->edit)){ ?>
    showStartDate(<?php echo $this->course->show_start_time; ?>);
  <?php } else { ?>
    showStartDate(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.start.date', '1'); ?>);
  <?php } ?>
  function showStartDate(value) {
    if(value == '1')
    jqueryObjectOfSes('#courses_start_time-wrapper').hide();
    else
    jqueryObjectOfSes('#courses_start_time-wrapper').show();
  }
  <?php if(!empty($this->edit)){ ?>
    showEndDate(<?php echo $this->course->show_end_time; ?>);
  <?php } else { ?>
    showEndDate(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.end.date', '1'); ?>);
  <?php } ?>
  function showEndDate(value) {
    if(value == '1')
    jqueryObjectOfSes('#courses_end_time-wrapper').show();
    else
    jqueryObjectOfSes('#courses_end_time-wrapper').hide();
  }
  sesJqueryObject(document).on('change','input[name=discount]',function(e){
    var value = sesJqueryObject('input[name=discount]:checked').val();
    if(value == 1){
      sesJqueryObject('#discount_type-wrapper').show();
      sesJqueryObject('#fixed_discount_value-wrapper').show();
      sesJqueryObject('#percentage_discount_value-wrapper').show();
      sesJqueryObject('#discount_start_date-wrapper').show();
      sesJqueryObject('#discount_end_date-wrapper').show();
      sesJqueryObject('#allowed_discount_type-wrapper').show();
      sesJqueryObject('#discount_end_type-wrapper').show();
    }else{
      sesJqueryObject('#discount_type-wrapper').hide();
      sesJqueryObject('#fixed_discount_value-wrapper').hide();
      sesJqueryObject('#percentage_discount_value-wrapper').hide();
      sesJqueryObject('#discount_start_date-wrapper').hide();
      sesJqueryObject('#discount_end_date-wrapper').hide();
      sesJqueryObject('#allowed_discount_type-wrapper').hide();
      sesJqueryObject('#discount_end_type-wrapper').hide();
    }
     if(value == 1){
        sesJqueryObject('input[name=discount_type]:checked').trigger('change');
        sesJqueryObject('#discount_type').trigger('change');
        sesJqueryObject('input[name=discount_end_type]:checked').trigger('change');
     }
  });
  sesJqueryObject(document).on('change','#discount_type',function(e){
    var value = sesJqueryObject(this).val();
    if(value == 1){
       sesJqueryObject('#fixed_discount_value-wrapper').show();
        sesJqueryObject('#percentage_discount_value-wrapper').hide();
    }else{
       sesJqueryObject('#fixed_discount_value-wrapper').hide();
        sesJqueryObject('#percentage_discount_value-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[name=discount_end_type]',function(e){
    var value = sesJqueryObject('input[name=discount_end_type]:checked').val();
    if(value == 1){
      sesJqueryObject('#discount_end_date-wrapper').show();
    }else{
      sesJqueryObject('#discount_end_date-wrapper').hide();
    }
  });
  en4.core.runonce.add(function() {
     sesJqueryObject('input[name=discount]:checked').trigger('change');
  });
</script>
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
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'courses')->getMapping(array('category_id', 'profile_type'))); ?>;
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
  showSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
  function showSubCategory(cat_id,selectedId, isLoad) {
    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'courses/ajax/subcategory/category_id/' + cat_id;
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
    var url = en4.core.baseUrl + 'courses/ajax/subsubcategory/subcategory_id/' + cat_id;
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

//course form submit on enter
  sesJqueryObject("#form-upload").bind("keypress", function (e) {		
    if (e.keyCode == 13 && sesJqueryObject('#'+e.target.id).prop('tagName') != 'TEXTAREA') {
    e.preventDefault();
    }else{
    return true;	
    }
  });
	//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
  function validateForm(){
    var errorPresent = false; 
    jqueryObjectOfSes('#courses_edit input, #courses_edit select,#courses_edit checkbox,#courses_edit textarea,#courses_edit radio').each(
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
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'select-multiple'){
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'select-one' || jqueryObjectOfSes(this).prop('type') == 'select' ){
	    if(jqueryObjectOfSes(this).val() === '')
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'radio'){
	    if(jqueryObjectOfSes("input[name='"+jqueryObjectOfSes(this).attr('name').replace('[]','')+"']:checked").val() === '')
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'textarea' && jqueryObjectOfSes(this).prop('id') == 'body'){
	    if(tinyMCE.get('body').getContent() === '' || tinyMCE.get('body').getContent() == null)
	    error = true;
	    else
	    error = false;
	  }
	  else if(jqueryObjectOfSes(this).prop('type') == 'textarea') {
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  else{
	    if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
	    error = true;
	    else
	    error = false;
	  }
	  if(error){
	    if(counter == 0){
	      objectError = this;
	    }
	    counter++
	  }
	  else{
	  }
	  if(error)
	  errorPresent = true;
	  error = false;
	}
      }
    );
    return errorPresent ;
  }
  jqueryObjectOfSes('#courses_edit').submit(function(e){
    var validationFm = validateForm();
		if(!validationFm && sesJqueryObject('#courses_schedule_time').length > 0 ) {
			var lastTwoDigitStart = sesJqueryObject('#courses_schedule_time').val().slice('-2');
			var startDate = new Date(sesJqueryObject('#courses_schedule_date').val()+' '+sesJqueryObject('#courses_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
			var error = checkDateTime(startDate);
			if(error != ''){
				sesJqueryObject('#courses_error_time-wrapper').show();
				sesJqueryObject('#courses_schedule_error_time-element').text(error);
			 var errorFirstObject = sesJqueryObject('#event_start_time-label').parent().parent();
			 sesJqueryObject('html, body').animate({
				scrollTop: errorFirstObject.offset().top
			 }, 2000);
				return false;
			}else{
				sesJqueryObject('#courses_error_time-wrapper').hide();
			}	
		}
    if(validationFm) {
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined'){
	var errorFirstObject = jqueryObjectOfSes(objectError).parent().parent();
	jqueryObjectOfSes('html, body').animate({
	scrollTop: errorFirstObject.offset().top
	}, 2000);
      }
      return false;	
    }
    else{
      jqueryObjectOfSes('#upload').attr('disabled',true);
      jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
      return true;
    }			
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
  en4.core.runonce.add(function() {
    sesJqueryObject('#fields-label').remove();
    if(jqueryObjectOfSes('input[name="show_start_time"]').length && jqueryObjectOfSes('input[name="show_start_time"]:checked').val() == '1'){
      sesJqueryObject('#courses_start_time-wrapper').hide();
    }
    if(jqueryObjectOfSes('input[name="show_end_time"]').length && jqueryObjectOfSes('input[name="show_end_time"]:checked').val() == ''){
      sesJqueryObject('#courses_end_time-wrapper').hide();
    }
    
    jqueryObjectOfSes('#submit_check-wrapper').hide();
    //function ckeck url availability
    jqueryObjectOfSes('#check_custom_url_availability').click(function(){
      checkAvailsbility();
    });
    
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
</script>

<script type="text/javascript">
  function showPreview(value) {
    if(value == 1)
    en4.core.showError('<div class="courses_design_popup"><a class="courses_icon_close"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 1")+'</p><img class="popup_img" src="./application/modules/Courses/externals/images/layout_1.jpg" alt="" /></div>');
    else if(value == 2)
    en4.core.showError('<div class="courses_design_popup"><a class="courses_icon_close"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 2")+'</p><img src="./application/modules/Courses/externals/images/layout_2.jpg" alt="" /></div>');
    else if(value == 3)
    en4.core.showError('<div class="courses_design_popup"><a class="courses_icon_close"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 3")+'</p><img src="./application/modules/Courses/externals/images/layout_3.jpg" alt="" /></div>');
    else if(value == 4)
    en4.core.showError('<div class="courses_design_popup"><a class="courses_icon_close"><i class="fa fa-close"></i></a> <p class="popup_design_title">'+en4.core.language.translate("Design 4")+'</p><img src="./application/modules/Courses/externals/images/layout_4.jpg" alt="" /></div>');
    return;
  }
  $$('.core_main_courses').getParent().addClass('active');
  jqueryObjectOfSes(document).on('click','.courses_icon_close',function(){
    Smoothbox.close();
  });
</script>
