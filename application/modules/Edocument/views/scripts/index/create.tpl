<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (($this->current_count >= $this->quota) && !empty($this->quota)){ ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesdocument_general'));?>
    </span>
  </div>
  <br/>
<?php return; ?>
<?php } else if(!empty($this->error_doc_full)){ ?>
  <div class="tip">
    <span><?php echo $this->driveObject->getAboutError(); ?></span>
  </div>
<?php return; } ?>

<?php
$baseUrl = $this->layout()->staticBaseUrl;
if (APPLICATION_ENV == 'production')
  $this->headScript()->appendFile($baseUrl . 'externals/autocompleter/Autocompleter.min.js');
else {
  $this->headScript()->appendFile($baseUrl . 'externals/autocompleter/Observer.js')
    ->appendFile($baseUrl . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($baseUrl . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($baseUrl . 'externals/autocompleter/Autocompleter.Request.js');
}

$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Edocument/externals/styles/styles.css'); 
$this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); 
$this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); 

$mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.photo.mandatory', '1');
if ($mainPhotoEnable == 1) {
	$required = true; ?>
  <style type='text/css'>
  .edocument_create #tabs_form_documentcreate-label label:after{content: '*';color: #F00;}
  </style>
<?php } else {
	$required = false;
}
?>
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
    jqueryObjectOfSes('#edocument_custom_url_wrong').hide();
    jqueryObjectOfSes('#edocument_custom_url_correct').hide();
    jqueryObjectOfSes('#edocument_custom_url_loading').css('display','inline-block');
    jqueryObjectOfSes.post('<?php echo $this->url(array('controller' => 'index','module'=>'edocument', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
      jqueryObjectOfSes('#edocument_custom_url_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
        jqueryObjectOfSes('#edocument_custom_url_correct').hide();
        jqueryObjectOfSes('#edocument_custom_url_wrong').css('display','inline-block');
        if(typeof submitform != 'undefined') {
          alert('<?php echo $this->translate("Custom Url is not available. Please select another URL."); ?>');
          var errorFirstObject = jqueryObjectOfSes('#custom_url').parent().parent();
          jqueryObjectOfSes('html, body').animate({
          scrollTop: errorFirstObject.offset().top
          }, 2000);
        }
      } else{
        jqueryObjectOfSes('#custom_url').val(response.value);
        jqueryObjectOfSes('#edocument_custom_url_wrong').hide();
        jqueryObjectOfSes('#edocument_custom_url_correct').css('display','inline-block');
        if(typeof submitform != 'undefined') {
          jqueryObjectOfSes('#upload').attr('disabled',true);
          jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
          jqueryObjectOfSes('#submit_check').trigger('click');
        }
      }
    });
  }

  en4.core.runonce.add(function() {
  
    if(jqueryObjectOfSes('#show_start_time') && jqueryObjectOfSes('input[name="show_start_time"]:checked').val() == '1')
    sesJqueryObject('#event_start_time-wrapper').hide();
    
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

<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'edocument_general'));?>
    </span>
  </div>
  <br/>
<?php else:?>
<div class="edocument_create sesbasic_bxs">
  <?php echo $this->form->render($this);?></div>
<?php endif; ?>

<script type="text/javascript">
  $$('.core_main_edocument').getParent().addClass('active');
</script>

<?php 
$defaultProfileFieldId = "0_0_$this->defaultProfileId";
$profile_type = 2;
?>

<?php echo $this->partial('_customFields.tpl', 'edocument', array()); ?>

<script type="text/javascript">

  var defaultProfileFieldId = '<?php echo $defaultProfileFieldId ?>';
  var profile_type = '<?php echo $profile_type ?>';
  var previous_mapped_level = 0;
  function showFields(cat_value, cat_level,typed,isLoad) {
		if(sesJqueryObject('#custom_fields_enable').length > 0)
			return;
    var categoryId = getProfileType($('category_id').value);
    var subcatId = getProfileType($('subcat_id').value);
    var subsubcatId = getProfileType($('subsubcat_id').value);
    var type = categoryId+','+subcatId+','+subsubcatId;
    if (cat_level == 1 || (previous_mapped_level >= cat_level && previous_mapped_level != 1) || (profile_type == null || profile_type == '' || profile_type == 0)) {
      profile_type = getProfileType(cat_value);
      if (profile_type == 0)
      profile_type = '';
      else
      previous_mapped_level = cat_level;
      $(defaultProfileFieldId).value = profile_type;
      changeFields($(defaultProfileFieldId),null,isLoad,type);
    }
  }
  
  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'edocument')->getMapping(array('category_id', 'profile_type'))); ?>;
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
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'edocument/index/subcategory/category_id/' + cat_id;
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
        if(typeof document.getElementsByName("0_0_1")[0] != 'undefined')
        document.getElementsByName("0_0_1")[0].value=categoryId;				
      }
      
      showFields(cat_id,1,categoryId);
      return false;
    }
    
    showFields(cat_id,1,categoryId);
    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'edocument/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {'selected':selected},
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
          // get category id value 
          if(isLoad == 'no')
          showFields(cat_id,1,categoryId,isLoad);
        } else {
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
    showFields(value,1,id,isLoad);
    if(value == 0 && typeof document.getElementsByName("0_0_1")[0] != 'undefined')
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;
  }

  function showCustomOnLoad(value,isLoad) {
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
    if(value == 0 && typeof document.getElementsByName("0_0_1")[0] != 'undefined')
    document.getElementsByName("0_0_1")[0].value=subcatId;	
    return false;
    <?php } ?>
  }
  
  en4.core.runonce.add(function() {
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
      } else {
        <?php if(isset($this->subsubcat_id)){$subsubcat_id = $this->subsubcat_id;}else $subsubcat_id = ''; ?>
        showSubSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>','yes');
      }
     <?php }else{ ?>
         $('subsubcat_id-wrapper').style.display = "none";
     <?php } ?>
        showCustomOnLoad('','no');
  });
  
  //prevent form submit on enter
  jqueryObjectOfSes("#edocuments_create").bind("keypress", function (e) {
    if (e.keyCode == 13 && jqueryObjectOfSes('#'+e.target.id).prop('tagName') != 'TEXTAREA') {
      e.preventDefault();
    }else{
      return true;	
    }
  });
  
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    jqueryObjectOfSes('#edocuments_create input, #edocuments_create select,#edocuments_create checkbox,#edocuments_create textarea,#edocuments_create radio').each(
      function(index) {
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
            if(sesJqueryObject('#tabs_form_documentcreate-wrapper').length && sesJqueryObject('.edocument_upload_item_photo').length == 0){
              <?php if($required):?>
                objectError = sesJqueryObject('.edocument_create_form_tabs');
                error = true;
              <?php endif;?>
            }		
          }
          if(error)
            errorPresent = true;
            error = false;
          }
      }
    );
    return errorPresent ;
  }
  
en4.core.runonce.add(function() {
  jqueryObjectOfSes('#edocuments_create').submit(function(e) {
    var validationFm = validateForm();
    if(!validationFm) {
			var lastTwoDigitStart = sesJqueryObject('#edocument_schedule_time').val().slice('-2');
			var startDate = new Date(sesJqueryObject('#edocument_schedule_date').val()+' '+sesJqueryObject('#edocument_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
			var error = checkDateTime(startDate);
			if(error != ''){
				sesJqueryObject('#event_error_time-wrapper').show();
				sesJqueryObject('#edocument_schedule_error_time-element').text(error);
			 var errorFirstObject = sesJqueryObject('#event_start_time-label').parent().parent();
			 sesJqueryObject('html, body').animate({
				scrollTop: errorFirstObject.offset().top
			 }, 2000);
				return false;
			}else{
				sesJqueryObject('#event_error_time-wrapper').hide();
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
    }else if(sesJqueryObject('.edocument_upload_item_abort').length){
				alert('<?php echo $this->translate("Please wait till all photos uploaded."); ?>');
				var errorFirstObject = jqueryObjectOfSes('#uploadFileContainer-wrapper');
				jqueryObjectOfSes('html, body').animate({
					scrollTop: errorFirstObject.offset().top
				}, 2000);
				return false;
		}
  });
});
  
$$('.core_main_edocument').getParent().addClass('active');
jqueryObjectOfSes(document).on('click','.icon_close',function(){
  Smoothbox.close();
});
  
function showStartDate(value) {
  if(value == '1')
  jqueryObjectOfSes('#event_start_time-wrapper').hide();
  else
  jqueryObjectOfSes('#event_start_time-wrapper').show();
}

jqueryObjectOfSes('body').click(function(event) {
  if(event.target.id == 'custom_url') {
    jqueryObjectOfSes('#suggestion_tooltip').show();
  }
  else {
    jqueryObjectOfSes('#suggestion_tooltip').hide();
  }
});
</script>
