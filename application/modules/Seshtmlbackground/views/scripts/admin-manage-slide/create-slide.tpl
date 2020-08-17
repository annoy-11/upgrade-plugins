<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-slide.tpl 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Seshtmlbackground/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seshtmlbackground', 'controller' => 'manage-slide', 'action' => 'manage','id'=>$this->gallery_id), $this->translate("Back to Manage Videos and Photos") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="application/javascript">

window.addEvent('domready',function() {
    backgroundoverlay(jqueryObjectOfSes("input[name='overlay_type']:checked").val()); 
});
function sign_button(value){
	if(value == 1)
		jqueryObjectOfSes('div[id^="signup_button_"]').show();
	else
		jqueryObjectOfSes('div[id^="signup_button_"]').hide();
	jqueryObjectOfSes('#signup_button-wrapper').show();
}
function log_button(value){
	if(value == 1)
		jqueryObjectOfSes('div[id^="login_button_"]').show();
	else
		jqueryObjectOfSes('div[id^="login_button_"]').hide();
	
	jqueryObjectOfSes('#login_button-wrapper').show();
}
function register_form(){
	if(jqueryObjectOfSes('#show_register_form').val() == 0 && jqueryObjectOfSes('#show_login_form').val() == 0)
		var value = 0
	else
		var value = 1;
	if(value == 1)
		jqueryObjectOfSes('#position_register_form-wrapper').show();
	 else
	 	jqueryObjectOfSes('#position_register_form-wrapper').hide();
}
function extra_buton(value){
	if(value == 1)
		jqueryObjectOfSes('div[id^="extra_button_"]').show();
	else
		jqueryObjectOfSes('div[id^="extra_button_"]').hide();
	
	jqueryObjectOfSes('#extra_button_-wrapper').show();
}
function backgroundoverlay(value){
	if(value == 1){
		if($('overlay_color-wrapper'))
			$('overlay_color-wrapper').setStyle('display','block');
		if($('overlay_pettern-wrapper'))
			$('overlay_pettern-wrapper').setStyle('display','none');
	}else{
		if($('overlay_color-wrapper'))
			$('overlay_color-wrapper').setStyle('display','none');
		if($('overlay_pettern-wrapper'))
			$('overlay_pettern-wrapper').setStyle('display','block');
	}
}
sign_button(jqueryObjectOfSes('#signup_button').val());
log_button(jqueryObjectOfSes('#login_button').val());
register_form();
extra_buton(jqueryObjectOfSes('#extra_button').val());
</script>
<style type="text/css">
.settings div.form-label label.required:after{
	content:" *";
	color:#f00;
}
</style>