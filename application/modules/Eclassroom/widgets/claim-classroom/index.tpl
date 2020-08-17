<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
->appendFile($base_url . 'externals/autocompleter/Observer.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>

<?php  $checkClaimRequest = Engine_Api::_()->getDbTable('claims', 'eclassroom')->claimCount();?>
<div class="eclassroom_profile_tabs sesbasic_clearfix">
<div class="eclassroom_profile_tabs_top claim_request active sesbasic_clearfix">
	<a href="<?php echo $this->url(array('action' => 'claim'), 'eclassroom_general', true);?>"><i class=" fa fa-plus"></i><?php echo $this->translate('Claim New Classroom');?></a>
</div>
<?php if($checkClaimRequest):?>
	<div class="eclassroom_profile_tabs_top claim_new_classroom sesbasic_clearfix">
		<a href="<?php echo $this->url(array('action' => 'claim-requests'), 'eclassroom_general', true);?>"><i class="fa fa-files-o"></i><?php echo $this->translate('Your Claim Requests');?></a>
	</div>
<?php endif;?>

</div>
<div>
  <?php echo $this->form->render($this) ?>
</div>

<script type="text/javascript">
	en4.core.runonce.add(function() {
		var contentAutocomplete = new Autocompleter.Request.JSON('title', "<?php echo $this->url(array('module' => 'eclassroom', 'controller' => 'index', 'action' => 'get-classrooms'), 'default', true) ?>", {
			'postVar': 'text',
			'minLength': 1,
			'selectMode': 'pick',
			'autocompleteType': 'tag',
			'customChoices': true,
			'filterSubset': true,
			'multiple': false,
			'className': 'sesbasic-autosuggest',
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
		contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
			$('classroom_id').value = selected.retrieve('autocompleteChoice').id;
		});
	});
	//Ajax error show before form submit
	var error = false;
	var objectError ;
	var counter = 0;
	function validateForm(){
		var errorPresent = false;
		counter = 0;
		sesJqueryObject('#eclassroom_claim_create input, #eclassroom_claim_create select,#eclassroom_claim_create checkbox,#eclassroom_claim_create textarea,#eclassroom_claim_create radio').each(
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
					}
					else if(sesJqueryObject(this).prop('type') == 'textarea'){
						if(sesJqueryObject(this).css('display') == 'none'){
							var	content = tinymce.get(sesJqueryObject(this).attr('id')).getContent();
							if(!content)
							error= true;
							else
							error = false;
						}
						else if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
						error = true;
						else
						error = false;
					}
					else{
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
		sesJqueryObject('#eclassroom_claim_create').submit(function(e){
			var validationFm = validateForm();
			if(validationFm) {
				alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
				if(typeof objectError != 'undefined'){
					var errorFirstObject = sesJqueryObject(objectError).parent().parent();
					sesJqueryObject('html, body').animate({
					scrollTop: errorFirstObject.offset().top
					}, 2000);
				}
				return false;	
			}	
			else{
				sendDataToServer(this);
				return false;		
			}
		});
	});

	function sendDataToServer(object){
		//submit form 
		sesJqueryObject('.sesbasic_loading_cont_overlay').show();
		var formData = new FormData(object);
		formData.append('is_ajax', 1);
		var form = sesJqueryObject(object);
		sesJqueryObject.ajax({
			type:'POST',
			url: en4.core.baseUrl + "widget/index/mod/eclassroom/name/claim-classroom/",
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
				sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
				var data = sesJqueryObject.parseJSON(data);
				if(data.status){
					form.html(data.message);
				}else{
					form.before(data.message);
				}
				window.location.href = '<?php echo $this->url(array("action"=>"claim-requests"),"eclassroom_general",true); ?>';
			},
			error: function(data){
			}
		});
	}
</script>

