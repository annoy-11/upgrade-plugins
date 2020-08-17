<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: create-slide.tpl 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesadvancedbanner/views/scripts/dismiss_message.tpl';?>
<div class="sesadvancedbanner_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesadvancedbanner', 'controller' => 'manage-banner', 'action' => 'manage','id'=>$this->banner_id), $this->translate("Back to Manage Photo Slides") , array('class'=>'sesadvancedbanner_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesadvancedbanner_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="application/javascript">
window.addEvent('domready',function() {
    backgroundoverlay(jqueryObjectOfSes("input[name='overlay_type']:checked").val()); 
});

function backgroundoverlay(value){
	if(value == 1){
		if($('slide_overlaycolor-wrapper'))
			$('slide_overlaycolor-wrapper').setStyle('display','block');
		if($('overlay_pettern-wrapper'))
			$('overlay_pettern-wrapper').setStyle('display','none');
	}else{
		if($('slide_overlaycolor-wrapper'))
			$('slide_overlaycolor-wrapper').setStyle('display','none');
		if($('overlay_pettern-wrapper'))
			$('overlay_pettern-wrapper').setStyle('display','block');
	}
}
function extra_buton(value){
	if(value == 1)
		jqueryObjectOfSes('div[id^="extra_button_"]').show();
	else
		jqueryObjectOfSes('div[id^="extra_button_"]').hide();
	
	jqueryObjectOfSes('#extra_button_-wrapper').show();
}
extra_buton(jqueryObjectOfSes('#extra_button').val());

function extra_buton1(value){
	if(value == 1)
		jqueryObjectOfSes('div[id^="extra_button1_"]').show();
	else
		jqueryObjectOfSes('div[id^="extra_button1_"]').hide();
	
	jqueryObjectOfSes('#extra_button1_-wrapper').show();
}
extra_buton1(jqueryObjectOfSes('#extra_button1').val());
</script>
<style type="text/css">
.settings div.form-label label.required:after{
	content:" *";
	color:#f00;
}
</style>
