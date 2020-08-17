<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">
window.addEvent('load', function(){
	tinymce.execCommand('mceRemoveEditor',true, 'short_description');
	var desVal = document.getElementById('short_description').value;
	document.getElementById('short_description').value = desVal.match(/[^<p>].*[^</p>]/g)[0];
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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>

<?php if(!$this->is_ajax) { ?>
  <?php echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding)); ?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    <div class="sescrowdfunding_dashboard_form sescf_create_form sesbasic_bxs">
      <?php echo $this->form->render() ?>
    </div>
<?php if(!$this->is_ajax) { ?>
      </div>
    </div>
  </div>  
<?php } ?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
  
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
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding_enable_location', 1)) { ?>
    sesJqueryObject(document).ready(function() {
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
      sesJqueryObject('#mapcanvas-element').attr('id','map-canvas');
      sesJqueryObject('#map-canvas').css('height','200px');
      sesJqueryObject('#map-canvas').css('width','500px');
      sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
      sesJqueryObject('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
      sesJqueryObject('#ses_location-wrapper').css('display','none');
      initializeSesCrowdfundingMap();
    });
    sesJqueryObject( window ).load(function() {
      editMarkerOnMapCrowdfundingEdit();
    });
  <?php } ?>
</script>

<script type="application/javascript">

  function showFields(cat_value, cat_level,typed,isLoad) {

    if(isLoad == 'custom') {
      var type = typed;
    } else {
      var categoryId = getProfileType($('category_id').value);
      var subcatId = getProfileType($('subcat_id').value);
      var subsubcatId = getProfileType($('subsubcat_id').value);
      var type = categoryId+','+subcatId+','+subsubcatId;
      
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

  
  function showSubCategory(cat_id,selectedId, isLoad) {
  
    var selected;
    if(selectedId != '')
      var selected = selectedId;
      
    var url = en4.core.baseUrl + 'sescrowdfunding/index/subcategory/category_id/' + cat_id;
    
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
      }
    }).send(); 
  }
  
  function showSubSubCategory(cat_id,selectedId,isLoad) {
  
    var categoryId = getProfileType($('category_id').value);
  
    if(cat_id == 0) {
			if ($('subsubcat_id-wrapper')) {
				$('subsubcat_id-wrapper').style.display = "none";
				$('subsubcat_id').innerHTML = '';
				//document.getElementsByName("0_0_1")[0].value=categoryId;				
      }
      return false;
    }

    var selected;
    if(selectedId != ''){
      var selected = selectedId;
    }
    var url = en4.core.baseUrl + 'sescrowdfunding/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {'selected':selected},
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "block";
            $('subsubcat_id').innerHTML = responseHTML;
          }
        } else {
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
    //showCustomOnLoad('','no');
  });

  //prcrowdfunding form submit on enter
  sesJqueryObject("#form-upload").bind("keypress", function (e) {		
    if (e.keyCode == 13 && sesJqueryObject('#'+e.target.id).prop('tagName') != 'TEXTAREA') {
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
    jqueryObjectOfSes('#sescrowdfundings_edit input, #sescrowdfundings_edit select,#sescrowdfundings_edit checkbox,#sescrowdfundings_edit textarea,#sescrowdfundings_edit radio').each(function(index) {
    
    var input = jqueryObjectOfSes(this);
    if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements') {
      if(jqueryObjectOfSes(this).prop('type') == 'checkbox') {
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
    });
    return errorPresent ;
  }
  
  jqueryObjectOfSes('#sescrowdfundings_edit').submit(function(e) {
  
    var validationFm = validateForm();
		if(!validationFm && sesJqueryObject('#sescrowdfunding_schedule_time').length > 0 ) {
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
    }
    else{
      jqueryObjectOfSes('#upload').attr('disabled',true);
      jqueryObjectOfSes('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
      return true;
    }
  });
  
  
  $$('.core_main_sescrowdfunding').getParent().addClass('active');
  
  <?php if(empty($this->crowdfunding->price)) { ?>
    <?php if(Engine_Api::_()->sescrowdfunding()->isMultiCurrencyAvailable()) { ?>
      sesJqueryObject('#price-element').append('<span class="fa fa-retweet sescrowdfunding_convert_icon sesbasic_link_btn" id="sescrowdfunding_currency_coverter" title="<?php echo $this->translate("Convert to %s",Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"));?>"></span>');
      sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"); ?>)</span>');
    <?php } else{ ?>
      sesJqueryObject('#price-label').append('<span> (<?php echo Engine_Api::_()->getApi("settings","core")->getSetting("sesbasic.defaultcurrency","USD"); ?>)</span>');
    <?php } ?>
    
    sesJqueryObject(document).on('click','#sescrowdfunding_currency_coverter',function(){
      var url = "<?php echo $this->url(array('module'=>'sesbasic', 'controller'=>'index', 'action'=>'currency-converter'), 'default', true); ?>";
      openURLinSmoothBox(url);
      return false;
    });
  <?php } ?>
</script>
