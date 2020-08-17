<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-popup.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');?>
	<?php include APPLICATION_PATH .  '/application/modules/Sespopupbuilder/views/scripts/dismiss_message.tpl';?>
	<div>
	<?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Popups"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
	</div>
	<br/>
	<div class='clear'>
		<div class='settings sesbasic_admin_form popup_setting'>
			<?php echo $this->form->render($this); ?>
		</div>
	</div>
	
	<?php if(isset($this->popup)): ?>
		<?php $popup = json_encode($this->popup->toArray()); ?>
	<?php else: ?>
		<?php $popup = json_encode(''); ?>
	<?php endif; ?>

	<script type="text/javascript">

	var formElements = $('dummy1-wrapper');
	var popup = <?php echo $popup ?>;
	if(popup != null && popup.whenshow == '6' && popup.showspecicurl!= null){
		var urls = popup.showspecicurl;
		var temp = new Array();
		temp = urls.split(",");
		if(temp.length > 0){
			var counter = 0;
			jqueryObjectOfSes.each(temp, function(key,val) {
				var style = 'margin:5px 0 5px 190px; display:block;';
				
				var optionElement = new Element('input', {
					'type': 'text',
					'name': 'showspecicurl['+counter+']',
					'class': 'showspecicurl',
					'placeholder': 'Enter Page URL',
					'value':val,
					'style': style
				});
				optionElement.inject(formElements);
				counter++;
			});
		}
	}
	
	window.addEvent('domready',function() {
    whenshowpopup(jqueryObjectOfSes("input[name='whenshow']:checked").val());
    visibilityday(jqueryObjectOfSes("input[name='how_long_show']:checked").val());
    whenclosepopup(jqueryObjectOfSes("input[name='when_close_popup']:checked").val());
    datedisplaysetting(jqueryObjectOfSes("#date_display_setting").val());
    backgorundofpopup(jqueryObjectOfSes("input[name='background']:checked").val());
    responsivemode(jqueryObjectOfSes("input[name='popup_responsive_mode']:checked").val());
    closebutton(jqueryObjectOfSes("input[name='close_button']:checked").val());
    opcitysound(jqueryObjectOfSes("#opening_popup_sound").val());
    openinganimation(jqueryObjectOfSes("#popup_opening_animation").val());
		chrismisimage1(jqueryObjectOfSes("#christmas_image1_check").val());
		chrismisimage2(jqueryObjectOfSes("#christmas_image2_check").val());
		cookieconfirmation(jqueryObjectOfSes("#cookies_button").val());
		buttonverfication(jqueryObjectOfSes("#is_button_text").val());
		
  });
	
	if($('starttime-wrapper')){
		$('starttime-wrapper').setStyle('display','none');
	}
	if($('endtime-wrapper')){
		$('endtime-wrapper').setStyle('display','none');
	}
	if($('background_color-wrapper')){
		$('background_color-wrapper').setStyle('display','none');
	}
	if($('background_photo-wrapper')){
		$('background_photo-wrapper').setStyle('display','none');
	}
	if($('responsive_size-wrapper')){
		$('responsive_size-wrapper').setStyle('display','none');
	}
	if($('after_inactivity_time-wrapper')){
		$('after_inactivity_time-wrapper').setStyle('display','none');
	}
	if($('close_time-wrapper')){
	$('close_time-wrapper').setStyle('display','none');
	}
	if($('first_button_verifiaction-wrapper')){
		$('first_button_verifiaction-wrapper').setStyle('display','none');
	}
	if($('second_button_verifiaction-wrapper')){
		$('second_button_verifiaction-wrapper').setStyle('display','none');
	}
	if($('cookies_button_title-wrapper')){
		$('cookies_button_title-wrapper').setStyle('display','none');
	}
	if($('christmas_image1_upload-wrapper')){
		$('christmas_image1_upload-wrapper').setStyle('display','none');
	}
	if($('christmas_image2_upload-wrapper')){
		$('christmas_image2_upload-wrapper').setStyle('display','none');
	}
	if($('popup_sound_file-wrapper')){
		$('popup_sound_file-wrapper').setStyle('display','none');
	}

	
	var formElements2 = $('dummy2-wrapper');
	var formElements3 = $('dummy3-wrapper');
	formElements.setStyle('display','none');
	var formElements1 = $('whenshow-wrapper');
	function visibilityday(value){
		if(value=='everytime'){
			if($('popup_visibility_duration-wrapper'))
				$('popup_visibility_duration-wrapper').setStyle('display','block');
		}else{
			if($('popup_visibility_duration-wrapper'))
				$('popup_visibility_duration-wrapper').setStyle('display','none');
		}
	}
	function checkyoutubevideo(videoUrl){
		$('checking-element').getChildren('.description').set('html', 'Checking Url....');
			$('checking-element').getChildren('.description').show();
			var url = en4.core.baseUrl+'admin/sespopupbuilder/manage/get-iframely-information';
			new Request.HTML({
				url: url,
				data: {
						uri:videoUrl			
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					if(responseHTML == 1){
						$('checking-element').getChildren('.description').hide();
					}else{
						$('is_video_found').set("value", 0);
						$('checking-element').getChildren('.description').set('html', 'Url not Found');
					}
				}
		}).send(); 	
	}
	function datedisplaysetting(value){
		if(value=='1'){
			if($('starttime-wrapper'))
				$('starttime-wrapper').setStyle('display','block');
			if($('endtime-wrapper'))
				$('endtime-wrapper').setStyle('display','block');
		}else{
			if($('starttime-wrapper'))
				$('starttime-wrapper').setStyle('display','none');
			if($('endtime-wrapper'))
				$('endtime-wrapper').setStyle('display','none');
		}
	}
	function chrismisimage1(value){
		if(value=='1'){
			if($('christmas_image1_upload-wrapper'))
				$('christmas_image1_upload-wrapper').setStyle('display','block');
			if($('christmas_image1_select-wrapper'))
			$('christmas_image1_select-wrapper').setStyle('display','none');
		}else{
			if($('christmas_image1_upload-wrapper'))
				$('christmas_image1_upload-wrapper').setStyle('display','none');
			if($('christmas_image1_select-wrapper'))
				$('christmas_image1_select-wrapper').setStyle('display','block');
		}
	}
	function chrismisimage2(value){
		if(value=='1'){
			if($('christmas_image2_upload-wrapper'))
				$('christmas_image2_upload-wrapper').setStyle('display','block');
			if($('christmas_image2_select-wrapper'))
				$('christmas_image2_select-wrapper').setStyle('display','none');
		}else{
			if($('christmas_image2_upload-wrapper'))
				$('christmas_image2_upload-wrapper').setStyle('display','none');
			if($('christmas_image2_select-wrapper'))
				$('christmas_image2_select-wrapper').setStyle('display','block');
		}
	}
	function cookieconfirmation(value){
		if(value=='1'){
			if($('cookies_button_title-wrapper'))
				$('cookies_button_title-wrapper').setStyle('display','block');
		}else{
			if($('cookies_button_title-wrapper'))
				$('cookies_button_title-wrapper').setStyle('display','none');
		}
	}
	function buttonverfication(value){
		if(value=='1'){
			if($('first_button_verifiaction-wrapper'))
				$('first_button_verifiaction-wrapper').setStyle('display','block');
			if($('second_button_verifiaction-wrapper'))
				$('second_button_verifiaction-wrapper').setStyle('display','block');
		}else{
			if($('first_button_verifiaction-wrapper'))
				$('first_button_verifiaction-wrapper').setStyle('display','none');
			if($('second_button_verifiaction-wrapper'))
				$('second_button_verifiaction-wrapper').setStyle('display','none');
		}
	}
	function backgorundofpopup(value){
		
		if(value == '1'){
			if($('remove_background_photo-wrapper')){
				$('remove_background_photo-wrapper').setStyle('display','block');
			}
			if($('editdummy_2-wrapper')){
				$('editdummy_2-wrapper').setStyle('display','block');
			}
			if($('background_color-wrapper')){
				$('background_color-wrapper').setStyle('display','none');
			}
			if($('background_photo-wrapper')){
				$('background_photo-wrapper').setStyle('display','block');
			}
		}else if(value == '2'){
			if($('editdummy_2-wrapper')){
				$('editdummy_2-wrapper').setStyle('display','none');
			}
			if($('remove_background_photo-wrapper')){
				$('remove_background_photo-wrapper').setStyle('display','none');
			}
			
			if($('background_photo-wrapper')){
				$('background_photo-wrapper').setStyle('display','none');
			}
			if($('background_color-wrapper')){
				$('background_color-wrapper').setStyle('display','block');
			}
		}else{
			if($('remove_background_photo-wrapper')){
				$('remove_background_photo-wrapper').setStyle('display','none');
			}
			if($('editdummy_2-wrapper')){
				$('editdummy_2-wrapper').setStyle('display','none');
			}
			if($('background_color-wrapper')){
				$('background_color-wrapper').setStyle('display','none');
			}
			if($('background_photo-wrapper')){
				$('background_photo-wrapper').setStyle('display','none');
			}
		}
	}
	function responsivemode(value){
		if(value == '2'){
			if($('custom_width-wrapper')){
				$('custom_width-wrapper').setStyle('display','none');
			}
			if($('custom_height-wrapper')){
				$('custom_height-wrapper').setStyle('display','none');
			}
			if($('responsive_size-wrapper')){
				$('responsive_size-wrapper').setStyle('display','block');
			}
		}else if(value == '1'){
			if($('responsive_size-wrapper')){
				$('responsive_size-wrapper').setStyle('display','none');
			}
			if($('custom_width-wrapper')){
				$('custom_width-wrapper').setStyle('display','block');
			}
			if($('custom_height-wrapper')){
				$('custom_height-wrapper').setStyle('display','block');
			}
		}
	}
	function whenclosepopup(value){
		if(value == '3'){
			if($('close_time-wrapper'))
				$('close_time-wrapper').setStyle('display','block');
		}else{
			if($('close_time-wrapper'))
				$('close_time-wrapper').setStyle('display','none');
		}
	}
	function closebutton(value){
		if(value != '1'){
			if($('close_button_width-wrapper')){
				$('close_button_width-wrapper').setStyle('display','none');
			}
			if($('close_button_height-wrapper')){
				$('close_button_height-wrapper').setStyle('display','none');
			}
			if($('close_button_position-wrapper')){
				$('close_button_position-wrapper').setStyle('display','none');
			}
		}else{
			if($('close_button_width-wrapper')){
				$('close_button_width-wrapper').setStyle('display','block');
			}
			if($('close_button_height-wrapper')){
				$('close_button_height-wrapper').setStyle('display','block');
			}
			if($('close_button_position-wrapper')){
				$('close_button_position-wrapper').setStyle('display','block');
			}
		}
	}
	function opcitysound(value){
		if(value == '1'){
				$('popup_sound_file-wrapper').setStyle('display','block');
		}else{
			if($('popup_sound_file-wrapper')){
				$('popup_sound_file-wrapper').setStyle('display','none');
			}
		}
	}
	function openinganimation(value){
		if(value=='1'){
			if($('opening_type_animation-wrapper')){
				$('opening_type_animation-wrapper').setStyle('display','block');
			}
			if($('opening_speed_animation-wrapper')){
				$('opening_speed_animation-wrapper').setStyle('display','block');
			}
			if($('closing_speed_animation-wrapper')){
				$('closing_speed_animation-wrapper').setStyle('display','block');
			}
		}else{
			if($('opening_type_animation-wrapper')){
				$('opening_type_animation-wrapper').setStyle('display','none');
			}
			if($('opening_speed_animation-wrapper')){
				$('opening_speed_animation-wrapper').setStyle('display','none');
			}
			if($('closing_speed_animation-wrapper')){
				$('closing_speed_animation-wrapper').setStyle('display','none');
			}
		}
	}
	
	function whenshowpopup(value){
		
		if(value == '6'){
			formElements.setStyle('display','block');
			if($('after_inactivity_time-wrapper')){
				$('after_inactivity_time-wrapper').setStyle('display','none');
				$('how_long_show-wrapper').setStyle('display','block');
			}
		}else if(value == '5'){
			formElements.setStyle('display','none');
			$('after_inactivity_time-wrapper').setStyle('display','block');
			$('how_long_show-wrapper').setStyle('display','none');
			$('starttime-wrapper').setStyle('display','none');
			$('endtime-wrapper').setStyle('display','none');
		}else{
			formElements.setStyle('display','none');
			$('after_inactivity_time-wrapper').setStyle('display','none');
			$('how_long_show-wrapper').setStyle('display','block');
			
		}
	}
	var counter = 0;
	jqueryObjectOfSes(document).on('click','#whenshow_specific_url',function(event){
		event.preventDefault();
		var style = 'margin:5px 0 5px 190px; display:block;';
		var optionElement = new Element('input', {
			'type': 'text',
			'name': 'showspecicurl['+counter+']',
			'class': 'showspecicurl',
			'placeholder': 'Enter Page URL',
			'style': style
		});
		optionElement.inject(formElements);
		counter++;
	});
	</script>
 
