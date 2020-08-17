<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfundingvideo/externals/styles/styles.css');?>
<div class="layout_middle">
  <div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
    <div class="_mainhumb"><a href="<?php echo $this->parentItem->getHref(); ?>"><img src="<?php echo $this->parentItem->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
    <div class="_maincont">
      <a href="<?php echo $this->parentItem->getHref(); ?>"><?php echo $this->parentItem->getTitle(); ?></a>
      <span class="sesbasic_text_light">&raquo;</span>
      <span><?php echo $this->translate("Edit Video"); ?></span>
    </div>
  </div>
</div>
<div class="sescrowdfundingvideo_video_form"> 
	<?php echo $this->form->render(); ?>
</div>
<script type="application/javascript">
 en4.core.runonce.add(function() {
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
		});
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfundingvideo_enable_location', 1)){ ?>
sesJqueryObject(document).ready(function(){
sesJqueryObject('#lat-wrapper').css('display' , 'none');
sesJqueryObject('#lng-wrapper').css('display' , 'none');
sesJqueryObject('#mapcanvas-element').attr('id','map-canvas');
sesJqueryObject('#map-canvas').css('height','200px');
sesJqueryObject('#map-canvas').css('width','500px');
sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
sesJqueryObject('#ses_location_data_list').html("<?php echo isset($_POST['location']) ? $_POST['location'] : '' ; ?>");
sesJqueryObject('#ses_location-wrapper').css('display','none');
initializeSesPageVideoMap();
});
sesJqueryObject( window ).load(function() {
	editMarkerOnMapSesPageVideoEdit();
	});
<?php } ?>
function enablePasswordFiled(value){
	if(value == 0){
		document.getElementById('password-wrapper').style.display = 'none';	
	}else{
		document.getElementById('password-wrapper').style.display = 'block';		
	}
}

if(document.getElementById('password-wrapper') && !document.getElementById('password').value)
	document.getElementById('password-wrapper').style.display = 'none';	
else if(document.getElementById('password-wrapper')){
	document.getElementById('password-wrapper').style.display = 'block';	
	sesJqueryObject('#password').val('<?php echo $this->video->password; ?>');
}
</script>
<script type="application/javascript">

//prevent form submit on enter
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
	sesJqueryObject('#form-upload input, #form-upload select,#form-upload checkbox,#form-upload textarea,#form-upload radio').each(
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
sesJqueryObject('#form-upload').submit(function(e){
	var validationFm = validateForm();
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
	}else{
		sesJqueryObject('#upload').attr('disabled',true);
		sesJqueryObject('#upload').html('<?php echo $this->translate("Submitting Form ...") ; ?>');
		return true;
	}			
});
</script>
