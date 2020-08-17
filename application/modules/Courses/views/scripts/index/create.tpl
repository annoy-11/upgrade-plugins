<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<?php if(!$this->typesmoothbox){ ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'); ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
  <?php }else{ ?>
    <script type="application/javascript">
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'; ?>");
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/bootstrap-datepicker.css'; ?>");
      Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/datepicker/jquery.timepicker.css'; ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/datepicker/jquery.timepicker.js' ?>");
      Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/datepicker/bootstrap-datepicker.js'; ?>");
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
    jqueryObjectOfSes('#course_custom_url_loading').css('display','block');
    jqueryObjectOfSes.post('<?php echo $this->url(array('controller' => 'ajax','module'=>'courses', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response){
      jqueryObjectOfSes('#course_custom_url_loading').hide();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error){
        jqueryObjectOfSes('#course_custom_url_correct').hide();
        jqueryObjectOfSes('#courses_custom_url_wrong').css('display','block');
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
        jqueryObjectOfSes('#course_custom_url_correct').css('display','block');
        if(typeof submitform != 'undefined') {
          jqueryObjectOfSes('#upload').attr('disabled',true);
          jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
          jqueryObjectOfSes('#submit_check').trigger('click');
        }
      }
    });
  }
  function hideShow(obj){
    var id = sesJqueryObject(obj).attr('id');
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

<?php if (!$this->createLimit): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'courses_general'));?>
    </span>
  </div>
  <br/>
<?php else: ?>
 <div class="courses_create_container">
  <div class="courses_create_form sesbasic_bxs" style="position:relative;">
    <?php echo $this->form->render($this);?>
    <div class="sesbasic_loading_cont_overlay"></div>
  </div>
</div>
<?php endif; ?>
<?php if(!empty($this->edit)){ ?>
</div>
<?php } ?>
<?php 
$defaultProfileFieldId = "0_0_$this->defaultProfileId";
$profile_type = 2;
?>
<?php echo $this->partial('_customFields.tpl', 'courses', array()); ?>

<script type="application/javascript">
sesJqueryObject(document).ready(function (e) {
  jqueryObjectOfSes('#dragandrophandlerbackground').click(function(){ 
    sesJqueryObject('#photo_file').trigger('onclick');
  });
});
jqueryObjectOfSes('#rotation-wrapper').hide();
jqueryObjectOfSes('#embedUrl-wrapper').hide();
function enablePasswordFiled(value) {
  if(value == 0)
  jqueryObjectOfSes('#password-wrapper').hide();
  else
  jqueryObjectOfSes('#password-wrapper').show();		
}
jqueryObjectOfSes('#password-wrapper').hide();	
</script>

<script type="text/javascript">
  
sesJqueryObject('#currency').hide();
sesJqueryObject('#currency-wrapper').hide();
<?php if(Engine_Api::_()->courses()->isMultiCurrencyAvailable()){ ?>
	sesJqueryObject('#price-element').append('<span class="fa fa-retweet courses_convert_icon courses_link_btn" id="courses_currency_coverter" title="<?php echo $this->translate("Convert to %s",Engine_Api::_()->courses()->getCurrentCurrency());?>"></span>');
	sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->courses()->getCurrentCurrency(); ?>)</span>');
<?php }else{ ?>
	sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->courses()->getCurrentCurrency(); ?>)</span>');
<?php } ?>
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
      if($(defaultProfileFieldId)) {
        $(defaultProfileFieldId).value = profile_type;
        changeFields($(defaultProfileFieldId),null,isLoad,type);
      }
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
  showSubCategory('<?php echo $this->subcat_id; ?>','<?php echo $this->subsubcat_id; ?>');
  function showSubCategory(cat_id,selectedId) {
    var selected;
    if(selectedId != '')
    var selected = selectedId;
    var url = en4.core.baseUrl + 'courses/ajax/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {'selected':selected},
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
    var url = en4.core.baseUrl + 'courses/ajax/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {'selected':selected},
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
  en4.core.runonce.add(function(){
      formObj = sesJqueryObject('#courses_create_form').find('div').find('div').find('div');
      var sesdevelopment = 1;
      <?php if((isset($this->category_id) && $this->category_id != 0) || (isset($_GET['category_id']) && $_GET['category_id'] != 0)){ ?>
              <?php if(isset($this->subcat_id)){$catId = $this->subcat_id;}else $catId = ''; ?>
              showSubCategory('<?php echo isset($_GET['category_id'])? $_GET['category_id']:$this->category_id; ?>','<?php echo $catId; ?>','yes');
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
  //prevent form submit on enter
  jqueryObjectOfSes("#coursess_create").bind("keypress", function (e) {
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
    jqueryObjectOfSes('#courses_create input, #courses_create select,#courses_create checkbox,#courses_create textarea,#courses_create radio').each(
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
          }else if(jqueryObjectOfSes(this).prop('type') == 'select-multiple'){
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'select-one' || jqueryObjectOfSes(this).prop('type') == 'select' ){
            if(jqueryObjectOfSes(this).val() === '')
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'radio'){
            if(jqueryObjectOfSes("input[name='"+jqueryObjectOfSes(this).attr('name').replace('[]','')+"']:checked").val() === '')
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'textarea' && jqueryObjectOfSes(this).prop('id') == 'description'){
            if(tinyMCE.get('description').getContent() === '' || tinyMCE.get('description').getContent() == null)
            error = true;
            else
            error = false;
          }else if(jqueryObjectOfSes(this).prop('type') == 'textarea') {
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }else{
            if(jqueryObjectOfSes(this).val() === '' || jqueryObjectOfSes(this).val() == null)
            error = true;
            else
            error = false;
          }
          if(error){
            if(counter == 0)
              objectError = this;
            counter++
          }
          if(error)
            errorPresent = true;
          error = false;
        }
      }
    );
    if(errorPresent == false && sesJqueryObject('#tabs_form_coursecreate-wrapper').length && sesJqueryObject('.courses_upload_item_photo').length == 0){
      <?php if($required):?>
        objectError = sesJqueryObject('.courses_create_form_tabs');
        error = true;
		errorPresent = true;
      <?php endif;?>
    }
    return errorPresent ;
  }
  var isSubmit = false;
en4.core.runonce.add(function() {
  jqueryObjectOfSes('#courses_create_form').submit(function(e) {
    if(isSubmit == true)
      return true;
    e.preventDefault();
    var validationFm = validateForm();
    if(validationFm) {
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined'){
        var elem = sesJqueryObject(objectError).closest('.courses_cnt').prev('h4').trigger('click');
				setTimeout(function(){
          var errorFirstObject = jqueryObjectOfSes(objectError).parent().parent();
            jqueryObjectOfSes('html, description').animate({
              scrollTop: errorFirstObject.offset().top
            }, 1000);  
        },200);
      }
    }else if(sesJqueryObject('.courses_upload_item_abort').length){
				alert('<?php echo $this->translate("Please wait till all photos uploaded."); ?>');
				var errorFirstObject = jqueryObjectOfSes('#uploadFileContainer-wrapper');
				jqueryObjectOfSes('html, description').animate({
					scrollTop: errorFirstObject.offset().top
				}, 2000);
		}else{
       //check server side form validation  
       //submit form 
        sesJqueryObject('.sesbasic_loading_cont_overlay').show();
        var formData = new FormData(this);
        formData.append('is_ajax', 1);
    <?php if($settings->getSetting('courses.enable.wysiwyg',1)) { ?>
        formData.append('description',tinyMCE.get('description').getContent());
    <?php } ?>
        var url = sesJqueryObject(this).attr('action');
        sesJqueryObject.ajax({
          type:'POST',
          dataType:'html',
          url: url,
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(response){
            sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
            var data = sesJqueryObject.parseJSON(response);
            if(sesJqueryObject('.form-errors').length)
              sesJqueryObject('.form-errors').remove();  
            if(data.status == 0){
              sesJqueryObject(data.message).insertBefore('.form-elements'); 
              sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
              var errorFirstObject = jqueryObjectOfSes('.form-errors');
              jqueryObjectOfSes('html, body').animate({
                scrollTop: errorFirstObject.offset().top - 20
              }, 2000);
            }else{
              isSubmit = true;
              sesJqueryObject('#submit_check').trigger('click');
            }
            <?php if($this->edit) { ?>
                if(validationFm)
                 location.reload();
            <?php } ?>
          },
          error: function(data){
            
          }
        });
    }
    return false;
  });
});
</script> 
<script type="text/javascript">
//drag drop photo upload
en4.core.runonce.add(function()
{
  if(sesJqueryObject('#dragandrophandlerbackground').hasClass('requiredClass')){
      sesJqueryObject('#dragandrophandlerbackground').parent().parent().find('#photouploader-label').find('label').addClass('required').removeClass('optional');	
  }
  $('photouploader-wrapper').style.display = 'block';
  $('courses_main_photo_preview-wrapper').style.display = 'none';
  $('photo-wrapper').style.display = 'none';
  var obj = sesJqueryObject('#dragandrophandlerbackground');
  obj.click(function(e){
      sesJqueryObject('#photo').val('');
      sesJqueryObject('#courses_main_photo_preview').attr('src','');
    sesJqueryObject('#photo').trigger('click');
  });
  obj.on('dragenter', function (e) 
  {
      e.stopPropagation();
      e.preventDefault();
      sesJqueryObject (this).addClass("sesbd");
  });
  obj.on('dragover', function (e) 
  {
        e.stopPropagation();
        e.preventDefault();
  });
  obj.on('drop', function (e) 
  {
    sesJqueryObject (this).removeClass("sesbd");
    sesJqueryObject (this).addClass("sesbm");
    e.preventDefault();
    var files = e.originalEvent.dataTransfer;
    handleFileBackgroundUpload(files,'courses_main_photo_preview');
  });
  sesJqueryObject (document).on('dragenter', function (e) 
  {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject (document).on('dragover', function (e) 
  {
    e.stopPropagation();
    e.preventDefault();
  });
  sesJqueryObject (document).on('drop', function (e) 
  {
        e.stopPropagation();
        e.preventDefault();
  });
});
en4.core.runonce.add(function()
{
var obj = jqueryObjectOfSes('#dragandrophandler');
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    jqueryObjectOfSes (this).addClass("sesbd");
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
 
    jqueryObjectOfSes (this).removeClass("sesbd");
    jqueryObjectOfSes (this).addClass("sesbm");
    e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
     //We need to send dropped files to Server
     handleFileUpload(files,obj);
});
jqueryObjectOfSes (document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
jqueryObjectOfSes (document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
});
	jqueryObjectOfSes (document).on('drop', function (e) 
	{
			e.stopPropagation();
			e.preventDefault();
	});
});

var rotation = {
  1: 'rotate(0deg)',
  3: 'rotate(180deg)',
  6: 'rotate(90deg)',
  8: 'rotate(270deg)'
};
function _arrayBufferToBase64(buffer) {
  var binary = ''
  var bytes = new Uint8Array(buffer)
  var len = bytes.byteLength;
  for (var i = 0; i < len; i++) {
    binary += String.fromCharCode(bytes[i])
  }
  return window.btoa(binary);
}
var orientation = function(file, callback) {
  var fileReader = new FileReader();
  fileReader.onloadend = function() {
    var base64img = "data:" + file.type + ";base64," + _arrayBufferToBase64(fileReader.result);
    var scanner = new DataView(fileReader.result);
    var idx = 0;
    var value = 1; // Non-rotated is the default
    if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
      // Not a JPEG
      if (callback) {
        callback(base64img, value);
      }
      return;
    }
    idx += 2;
    var maxBytes = scanner.byteLength;
    while (idx < maxBytes - 2) {
      var uint16 = scanner.getUint16(idx);
      idx += 2;
      switch (uint16) {
        case 0xFFE1: // Start of EXIF
          var exifLength = scanner.getUint16(idx);
          maxBytes = exifLength - idx;
          idx += 2;
          break;
        case 0x0112: // Orientation tag
          // Read the value, its 6 bytes further out
          // See store 102 at the following URL
          // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
          value = scanner.getUint16(idx + 6, false);
          maxBytes = 0; // Stop scanning
          break;
      }
    }
    if (callback) {
      callback(base64img, value);
    }
  }
  fileReader.readAsArrayBuffer(file);
};

var courseidparam = "";
function handleFileBackgroundUpload(input,id) {
  var files = sesJqueryObject(input)[0].files[0];
  var url = input.value;
  if(typeof url == 'undefined')
    url = input.files[0]['name'];
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
    /* var reader = new FileReader();
    reader.onload = function (e) {  
      // $(id+'-wrapper').style.display = 'block';
      $(id).setAttribute('src', e.target.result);
    }*/
    courseidparam = id;
    if (files) {
        orientation(files, function(base64img, value) {
          //$(id+'-wrapper').attr('src', base64img);
          sesJqueryObject(courseidparam).closest('.form-wrapper').show();;
          var rotated = sesJqueryObject(courseidparam).attr('src', base64img);
          if (value) {
            sesJqueryObject(courseidparam).css('transform', rotation[value]);
          }
        });
      }
    $('photouploader-element').style.display = 'none';
    $('removeimage-wrapper').style.display = 'block';
    $('removeimage1').style.display = 'inline-block';
    $('courses_main_photo_preview').style.display = 'block';
    $('courses_main_photo_preview-wrapper').style.display = 'block';
    //reader.readAsDataURL(input.files[0]);
  }
}
function removeImage() {
    $('photouploader-element').style.display = 'block';
    $('removeimage-wrapper').style.display = 'none';
    $('removeimage1').style.display = 'none';
    $('courses_main_photo_preview').style.display = 'none';
    $('courses_main_photo_preview-wrapper').style.display = 'none';
    $('courses_main_photo_preview').src = '';
    $('MAX_FILE_SIZE').value = '';
    $('removeimage2').value = '';
    $('photo').value = '';
}

var rowCount=0;
jqueryObjectOfSes(document).on('click','div[id^="abortPhoto_"]',function(){
		var id = jqueryObjectOfSes(this).attr('id').match(/\d+/)[0];
		if(typeof jqXHR[id] != 'undefined'){
				jqXHR[id].abort();
				delete filesArray[id];	
				execute = true;
				jqueryObjectOfSes(this).parent().remove();
				executeupload();
		}else{
				delete filesArray[id];	
				jqueryObjectOfSes(this).parent().remove();
		}
});

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
  en4.core.runonce.add(function() {
     sesJqueryObject('input[name=discount]:checked').trigger('change');
  });
  var contentAutocompleteUpsell;
  en4.core.runonce.add(function () {
    contentAutocompleteUpsell = new Autocompleter.Request.JSON('upsell', "<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'upsell-course','course_id'=>($this->subject() ? $this->subject()->getIdentity() : "")), 'default', true) ?>", {
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
    contentAutocompleteCrossSell = new Autocompleter.Request.JSON('crosssell', "<?php echo $this->url(array('module' => 'courses', 'controller' => 'index', 'action' => 'upsell-course','course_id'=>($this->subject() ? $this->subject()->getIdentity() : "")), 'default', true) ?>", {
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
  sesJqueryObject(document).on('keydown','.sesdecimal',function(event){
     if (event.shiftKey == true) {
          event.preventDefault();
      }
      if ((event.keyCode >= 48 && event.keyCode <= 57) || 
          (event.keyCode >= 96 && event.keyCode <= 105) || 
          event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
          event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
      } else {
          event.preventDefault();
      }
      if(sesJqueryObject(this).val().indexOf('.') !== -1 && event.keyCode == 190)
          event.preventDefault(); 
      //if a decimal has been added, disable the "."-button
  });
  sesJqueryObject(document).on('keydown','.sesinteger',function(e){
    -1!==sesJqueryObject.inArray(e.keyCode,[46,8,9,27,13,110])||(/65|67|86|88/.test(e.keyCode)&&(e.ctrlKey===true||e.metaKey===true))&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()
  })
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
</script>
<script type="text/javascript">
jqueryObjectOfSes('body').click(function(event) {
  if(event.target.id == 'custom_url') {
    jqueryObjectOfSes('#suggestion_tooltip').show();
  }
  else {
    jqueryObjectOfSes('#suggestion_tooltip').hide();
  }
});
sesJqueryObject(function() {
    sesJqueryObject.fn.scrollBottom = function() {
        return sesJqueryObject(document).height() - this.scrollTop() - this.height();
    };
    var $el = sesJqueryObject('#courses_create_tips');
    var positionInitial = sesJqueryObject('#title').offsetTop;
    sesJqueryObject('<style>#courses_create_tips{top:'+positionInitial+'px;}</style>').appendTo(document.head);
    var $window = sesJqueryObject(window);
    if($el.length){
        $window.bind("scroll resize", function() {
            var positionInitialTitle = sesJqueryObject('#title-element').offsetTop;
            var position = $el.offset().top - $window.scrollTop();
            if($window.scrollTop() < positionInitial){
                $el.css('top',positionInitial);
            }else{
                $el.css('top',$window.scrollTop());
            }
        });
    }
});
</script>
<?php  if($this->typesmoothbox) { ?>
	<script type="application/javascript">
	executetimesmoothboxTimeinterval = 400;
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
    tinymce.execCommand('mceRemoveEditor',true, 'purchase_note');
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
