<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
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
<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
<div class="tip"> <span> <?php echo $this->translate('You have already uploaded the maximum number of questions allowed.');?> <?php echo $this->translate('If you would like to upload a new question, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'sesqa_general'));?> </span> </div>
<br/>
<?php else:?>
<div class="layout_middle">
  <div class="generic_layout_container sesqa_question_form">
		<?php echo $this->form->render($this);?>
  </div>
</div>
<?php endif; ?>
<style>
.disable{
  background-color:red;
}
</style>
<script type="application/javascript">

<?php 
$optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));

if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)){ ?>
  sesJqueryObject(document).ready(function(){
    <?php if(!in_array('lat', $optionsenableglotion)) { ?>
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
    <?php } ?>
    <?php if(!in_array('lng', $optionsenableglotion)) { ?>
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
    <?php } ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
      sesJqueryObject('#lat-wrapper').css('display' , 'none');
      sesJqueryObject('#lng-wrapper').css('display' , 'none');
    <?php } ?>
    sesJqueryObject('#mapcanvas-element').attr('id','map-canvas');
    sesJqueryObject('#map-canvas').css('height','200px');
    sesJqueryObject('#map-canvas').css('width','500px');
    sesJqueryObject('#mapcanvas-wrapper').css('display' , 'none');
    sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
    sesJqueryObject('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
    sesJqueryObject('#ses_location-wrapper').css('display','none');
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
    initializeSesQaMap();
    <?php } ?>
  });
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
  sesJqueryObject( window ).load(function() {
    editMarkerOnMapSesqaEdit();
  });
  <?php } ?>
<?php } ?>

function showSubCategory(cat_id,selectedId) {
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesqa/index/subcategory/category_id/' + cat_id;
    new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subcat_id') && responseHTML) {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "block";
          }
          $('subcat_id').innerHTML = responseHTML;
        } else {
          if ($('subcat_id-wrapper')) {
            $('subcat_id-wrapper').style.display = "none";
            $('subcat_id').innerHTML = '';
          }
					 if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    }).send(); 
  }
	function showSubSubCategory(cat_id,selectedId,isLoad) {
		if(cat_id == 0){
			if ($('subsubcat_id-wrapper')) {
				$('subsubcat_id-wrapper').style.display = "none";
				$('subsubcat_id').innerHTML = '';
      }
			return false;
		}
		var selected;
		if(selectedId != ''){
			var selected = selectedId;
		}
    var url = en4.core.baseUrl + 'sesqa/index/subsubcategory/subcategory_id/' + cat_id;
    (new Request.HTML({
      url: url,
      data: {
				'selected':selected
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if ($('subsubcat_id') && responseHTML) {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "block";
          }
          $('subsubcat_id').innerHTML = responseHTML;
					// get category id value 
				//if(isLoad == 'no')
        } else {
          if ($('subsubcat_id-wrapper')) {
            $('subsubcat_id-wrapper').style.display = "none";
            $('subsubcat_id').innerHTML = '';
          }
        }
      }
    })).send();  
  }

window.addEvent('domready', function() {
  if(sesJqueryObject('#subcat_id').val() == 0)
    sesJqueryObject('#subcat_id-wrapper').hide();
  if(sesJqueryObject('#subsubcat_id').val() == 0)
    sesJqueryObject('#subsubcat_id-wrapper').hide();
});
  
    function showMediaType(value){
      //photo
      if(value == "1"){
        sesJqueryObject('#photo-wrapper').show();
        sesJqueryObject('#video-wrapper').hide();
      }else{
        sesJqueryObject('#photo-wrapper').hide();
        sesJqueryObject('#video-wrapper').show();  
      }
    }
    en4.core.runonce.add(function() {
      if(sesJqueryObject('.form-options-wrapper').length){
        if(sesJqueryObject('.form-options-wrapper').children().length == 1){
            sesJqueryObject('#mediatype-wrapper').hide();
        }
        showMediaType(sesJqueryObject('input[name=mediatype]:checked').val()); 
      }
    })
  
    function iframelyurl() {
    var checkingUrlMessage = "Checking URL..."
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
      'url' : en4.core.baseUrl + '/sesqa/index/get-iframely-information',
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
          $('validation').innerHTML = '<?php echo $this->translate("Your url is valid."); ?>';
        } else {
          $('validation').style.display = "block";
          $('validation').innerHTML = '<?php echo $this->translate('We could not find a video there - please check the URL and try again.'); ?>';
        }
      }
    }).send();
  }

//validate form
	//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateForm(){
		var errorPresent = false;
		sesJqueryObject('#question-create input, #question-create select,#question-create checkbox,#question-create textarea,#question-create radio').each(
				function(index){
						var input = sesJqueryObject(this);
						if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
						  if(sesJqueryObject(this).prop('type') == 'checkbox'){
								value = '';
								if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
										value = 1;
								};
								if(value == '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
								if(sesJqueryObject(this).val() === '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'radio'){
								if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
									error = true;
								else
									error = false;
							}else if(sesJqueryObject(this).prop('type') == 'textarea'){
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}else{
								if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
									error = true;
								else
									error = false;
							}
							if(error){
							 if(counter == 0){
							 	objectError = this;
							 }
								counter++
							}else{
							}
							if(error)
								errorPresent = true;
							error = false;
						}
				}
			);
				
			return errorPresent ;
}
sesJqueryObject('#question-create').submit(function(e){
					var validationFm = validateForm();
          valid = true;
					if(validationFm)
					{
						alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
						if(typeof objectError != 'undefined'){
						 var errorFirstObject = sesJqueryObject(objectError).parent().parent();
						 sesJqueryObject('html, body').animate({
							scrollTop: errorFirstObject.offset().top
						 }, 2000);
						}
						return false;	
					}else if(sesJqueryObject('#is_poll').val() == 1){
              if(!sesJqueryObject('.sesqa_poll_main_container').children().eq(1).find('.form-element').find('input').val()){
                 sesJqueryObject('.sesqa_poll_main_container').children().eq(1).find('.form-element').find('input').css('border','1px solid red');
                  valid = false;
              }else{
                 sesJqueryObject('.sesqa_poll_main_container').children().eq(1).find('.form-element').find('input').css('border','');  
              }
              if(!sesJqueryObject('.sesqa_poll_main_container').children().eq(2).find('.form-element').find('input').val()){
                 sesJqueryObject('.sesqa_poll_main_container').children().eq(2).find('.form-element').find('input').css('border','1px solid red');
                  valid = false;
              }else{
                 sesJqueryObject('.sesqa_poll_main_container').children().eq(2).find('.form-element').find('input').css('border','');  
              }
              if(!valid){
              alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
              var errorFirstObject = sesJqueryObject('.sesqa_poll_main_container').children().eq(2);
               sesJqueryObject('html, body').animate({
                scrollTop: errorFirstObject.offset().top
               }, 2000);
               return false;
              }
          }
          if(valid){
						sesJqueryObject('#submit').attr('disabled',true);
						sesJqueryObject('#submit').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
						return true;
					}			
          return false;
	});

//set options for post
 sesJqueryObject(document).ready(function(){
    <?php
    if(!empty($this->options) && count($this->options)){ ?>
      var optionsArray = <?php echo json_encode($this->options);?>;
      for(counteri=0;counteri<optionsArray.length;counteri++){
          if(counteri < 2){
            sesJqueryObject('#answer'+counteri).val(optionsArray[counteri]);
          }else{
            sesJqueryObject('#addAnswer').trigger('click');
            sesJqueryObject('#answer'+countersesqa).val(optionsArray[counteri]); 
          }
      }
      sesJqueryObject('.addpolloptions').trigger('click');
  <?php     
    }
    if(!empty($this->multi)){ ?>
    sesJqueryObject('#multi').prop('checked',true)
    <?php } ?>
    <?php if($this->isPollDisable){ ?>
    sesJqueryObject('#addpolloptions-wrapper').hide();
    sesJqueryObject('#addAnswer-wrapper').hide();
    sesJqueryObject('.sesqa_poll_main_container').find('input').prop('disabled','disabled');
    sesJqueryObject('.imgs').remove();
  <?php } ?>
  });
 
  var tagsUrl = '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>';
var autocompleter = new Autocompleter.Request.JSON('tags', tagsUrl, {
  'postVar' : 'text',
  'minLength': 1,
  'selectMode': 'pick',
  'autocompleteType': 'tag',
  'className': 'tag-autosuggest',
  'customChoices' : true,
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

</script>
