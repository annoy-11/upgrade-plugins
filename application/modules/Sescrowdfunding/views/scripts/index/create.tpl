<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">
window.addEvent('load', function(){
	tinymce.execCommand('mceRemoveEditor',true, 'short_description');
	var desVal = document.getElementById('short_description').value;
	//document.getElementById('short_description').value = desVal.match(/[^<p>].*[^</p>]/g)[0];
});
</script>
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
<?php

$mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.photo.mandatory', '1');
if ($mainPhotoEnable == 1) {
	$required = true; ?>
  <style type='text/css'>
  .sescf_create_form #tabs_form_crowdfundingcreate-label label:after{content: '*';color: #F00;}
  </style>
<?php } else {
	$required = false;
}
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/styles/dashboard.css'); 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>

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
  
  function checkAvailability(submitform) {
  
    var custom_url_value = jqueryObjectOfSes('#custom_url').val();
    
    if(!custom_url_value && typeof submitform == 'undefined')
      return;
      
    jqueryObjectOfSes('#sescrowdfunding_custom_url_wrong').hide();
    jqueryObjectOfSes('#sescrowdfunding_custom_url_correct').hide();
    jqueryObjectOfSes('#sescrowdfunding_custom_url_loading').css('display','block');
		jqueryObjectOfSes('#sescrowdfunding_custom_url_btn').css('display','none');
    
    jqueryObjectOfSes.post('<?php echo $this->url(array('controller' => 'index','module'=>'sescrowdfunding', 'action' => 'custom-url-check'), 'default', true) ?>',{value:custom_url_value},function(response) {
    
      jqueryObjectOfSes('#sescrowdfunding_custom_url_loading').hide();
			jqueryObjectOfSes('#sescrowdfunding_custom_url_btn').show();
      response = jqueryObjectOfSes.parseJSON(response);
      if(response.error) {
        jqueryObjectOfSes('#sescrowdfunding_custom_url_correct').hide();
        jqueryObjectOfSes('#sescrowdfunding_custom_url_wrong').css('display','inline-block');
        if(typeof submitform != 'undefined') {
          alert('<?php echo $this->translate("Custom Url is not available. Please select another URL."); ?>');
          var errorFirstObject = jqueryObjectOfSes('#custom_url').parent().parent();
          jqueryObjectOfSes('html, body').animate({
          scrollTop: errorFirstObject.offset().top
          }, 2000);
        }
      } else {
        jqueryObjectOfSes('#custom_url').val(response.value);
        jqueryObjectOfSes('#sescrowdfunding_custom_url_wrong').hide();
        jqueryObjectOfSes('#sescrowdfunding_custom_url_correct').css('display','inline-block');
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
    
    //Function for check url availability
    jqueryObjectOfSes('#check_custom_url_availability').click(function(){
      checkAvailability();
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
  
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding_enable_location', 1)){ ?>
    jqueryObjectOfSes(document).ready(function(){
    jqueryObjectOfSes('#lat-wrapper').css('display' , 'none');
    jqueryObjectOfSes('#lng-wrapper').css('display' , 'none');
    jqueryObjectOfSes('#mapcanvas-element').attr('id','map-canvas');
    jqueryObjectOfSes('#map-canvas').css('height','200px');
    jqueryObjectOfSes('#map-canvas').css('width','500px');
    jqueryObjectOfSes('#ses_location-label').attr('id','ses_location_data_list');
    jqueryObjectOfSes('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
    jqueryObjectOfSes('#ses_location-wrapper').css('display','none');
    initializeSesCrowdfundingMap();	
  });
  <?php } ?>
</script>

<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
  <div class="tip">
    <span>
      <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
      <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'crowdfunding_general'));?>
    </span>
  </div>
  <br/>
<?php else:?>

<div class="sescf_create_form sesbasic_bxs">
  <?php echo $this->form->render($this);?></div>
<?php endif; ?>

<script type="text/javascript">
  $$('.core_main_sescrowdfunding').getParent().addClass('active');
</script>

<?php 
$defaultProfileFieldId = "0_0_$this->defaultProfileId";
$profile_type = 2;
?>
<?php echo $this->partial('_customFields.tpl', 'sesbasic', array()); ?>
<script type="application/javascript">

jqueryObjectOfSes('#rotation-wrapper').hide();
jqueryObjectOfSes('#embedUrl-wrapper').hide();

function enablePasswordFiled(value){
  if(value == 0)
  jqueryObjectOfSes('#password-wrapper').hide();
  else
  jqueryObjectOfSes('#password-wrapper').show();		
}
jqueryObjectOfSes('#password-wrapper').hide();	
</script>

<script type="text/javascript">

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
      if($(defaultProfileFieldId))
      $(defaultProfileFieldId).value = profile_type;
      changeFields($(defaultProfileFieldId),null,isLoad,type);
    }
  }
  var getProfileType = function(category_id) {
    var mapping = <?php echo Zend_Json_Encoder::encode(Engine_Api::_()->getDbTable('categories', 'sescrowdfunding')->getMapping(array('category_id', 'profile_type'))); ?>;
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
      if(sesJqueryObject('#sessmoothbox_main').length){
        sesJqueryObject('#sespage_create_form').find('div').find('div').find('.form-elements').find('.parent_0').closest('.form-wrapper').hide() ;
      }
    }
  });

  function showSubCategory(cat_id,selectedId) {
        var selected;
        if(selectedId != ''){
            var selected = selectedId;
        }
    var url = en4.core.baseUrl + 'sescrowdfunding/index/subcategory/category_id/' + cat_id;
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
    var url = en4.core.baseUrl + 'sescrowdfunding/index/subsubcategory/subcategory_id/' + cat_id;
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
    formObj = sesJqueryObject('#sescrowdfunding_create_form').find('div').find('div').find('div');
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
  
  //Prevent form submit on enter
  jqueryObjectOfSes("#sescrowdfundings_create").bind("keypress", function (e) {		
    if (e.keyCode == 13 && jqueryObjectOfSes('#'+e.target.id).prop('tagName') != 'TEXTAREA') {
      e.preventDefault();
    } else {
      return true;	
    }
  });
  
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    jqueryObjectOfSes('#sescrowdfundings_create input, #sescrowdfundings_create select,#sescrowdfundings_create checkbox,#sescrowdfundings_create textarea,#sescrowdfundings_create radio').each(function(index) {
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
      else if(jqueryObjectOfSes(this).prop('type') == 'textarea' && jqueryObjectOfSes(this).prop('id') == 'description'){
        if(tinyMCE.get('description').getContent() === '' || tinyMCE.get('description').getContent() == null)
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
      if(error)
        errorPresent = true;
        error = false;
      }
    });
    console.log(errorPresent);
    return errorPresent ;
  }
  
  jqueryObjectOfSes('#submit').click(function(e) {
  
    var validationFm = validateForm();
    
    if(!validationFm) {
			var lastTwoDigitStart = sesJqueryObject('#sescrowdfunding_schedule_time').val().slice('-2');
			var startDate = new Date(sesJqueryObject('#sescrowdfunding_schedule_date').val()+' '+sesJqueryObject('#sescrowdfunding_schedule_time').val().replace(lastTwoDigitStart,'')+':00 '+lastTwoDigitStart);
			var error = checkDateTime(startDate);
			if(error != ''){
				sesJqueryObject('#event_error_time-wrapper').show();
				sesJqueryObject('#sescrowdfunding_schedule_error_time-element').text(error);
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
    } /*else {
      var avacheckAvailability = checkAvailability('true');
      return false;
    }	*/		
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
  
  $$('.core_main_sescrowdfunding').getParent().addClass('active');

  <?php if(Engine_Api::_()->sescrowdfunding()->isMultiCurrencyAvailable()) { ?>
    sesJqueryObject('#price-element').append('<span class="fa fa-retweet sescrowdfunding_convert_icon sesbasic_link_btn" id="sescrowdfunding_currency_coverter" title="<?php echo $this->translate("Convert to %s",Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"));?>"></span>');
    sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"); ?>)</span>');
  <?php } else{ ?>
    sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"); ?>)</span>');
  <?php } ?>
  
  sesJqueryObject(document).on('click','#sescrowdfunding_currency_coverter',function(){
    var url = "<?php echo $this->url(array('module'=>'sescrowdfunding', 'controller'=>'index', 'action'=>'currency-converter'), 'default', true); ?>";
    openURLinSmoothBox(url);
    return false;
  });
</script>
