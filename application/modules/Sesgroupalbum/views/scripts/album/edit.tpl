<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupalbum
 * @package    Sesgroupalbum
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupalbum/externals/styles/styles.css'); ?>
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
    <?php echo $this->translate('Photo Albums');?>
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
<div class="sesgroupalbum_album_form">
  <?php echo $this->form->render(); ?>
</div>

<script type="text/javascript">
function enablePasswordFiled(value){
	if(value == 0){
		sesJqueryObject('#password').val('');
		document.getElementById('password-wrapper').style.display = 'none';	
	}else{
		document.getElementById('password-wrapper').style.display = 'block';		
	}
}
// sesJqueryObject(document).ready(function(){
// 	if(document.getElementById('password-wrapper') && sesJqueryObject('#is_locked').val() == 0) {
// 	  document.getElementById('password-wrapper').style.display = 'none'; 
//   }else if(document.getElementById('password-wrapper')){
// 		document.getElementById('password-wrapper').style.display = 'block'; 
// 		sesJqueryObject('#password').val('<?php //echo $this->album->password; ?>');
// 	}
// });
sesJqueryObject('#lat-wrapper').hide();
sesJqueryObject('#lng-wrapper').hide();
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum_enable_location', 1)){ ?>
sesJqueryObject('#mapcanvas-element').attr('id','map-canvas-list');
//sesJqueryObject('#map-canvas-list').css('height','200px');
sesJqueryObject('#ses_location-label').attr('id','sesgroup_location_data_list');
sesJqueryObject('#sesgroup_location_data_list').html('<?php echo $this->album->location; ?>');
sesJqueryObject('#ses_location-wrapper').css('display','none');
initializeSesGroupAlbumMapList();
 sesJqueryObject( window ).load(function() {
	editGroupSetMarkerOnMapList();
	});
<?php } ?>

  window.addEvent('domready', function() {
	var sesdevelopment = 1;
  });
	//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateForm(){
		var errorPresent = false;
		sesJqueryObject('#albums_edit input, #albums_edit select,#albums_edit checkbox,#albums_edit textarea,#albums_edit radio').each(
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
								//sesJqueryObject(this).closest('div').parent().css('border','1px dashed #ff0000');
								counter++
							}else{
							 	//sesJqueryObject(this).closest('div').parent().css('border','');
							}
							if(error)
								errorPresent = true;
							error = false;
						}
				}
			);
				
			return errorPresent ;
}
sesJqueryObject(document).on('submit', '#albums_edit',function(e) {
		var validation = validateForm();
		if(validation)
		{
			alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
			if(typeof objectError != 'undefined'){
			 var errorFirstObject = sesJqueryObject(objectError).parent().parent();
			 sesJqueryObject('html, body').animate({
        scrollTop: errorFirstObject.offset().top
    	 }, 2000);
			 window.location.hash = '#'+errorFirstObject;
			}
			return false;	
		}else
			return true;
});
</script>