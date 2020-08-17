
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/ses-scripts/jquery.min.js');
?>
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<div class="estore_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'estore', 'controller' => 'manage-offer', 'action' => 'manage','id'=>$this->offer_id), $this->translate("Back to Manage Custom Offers") , array('class'=>'estore_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings estore_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="application/javascript">
window.addEvent('domready',function() {
    backgroundoverlay(jqueryObjectOfSes("input[name='overlay_type']:checked").val()); 
});
function showStartDate(value) {
    if(value == '1')
    jqueryObjectOfSes('#event_start_time-wrapper').hide();
    else
    jqueryObjectOfSes('#event_start_time-wrapper').show();
}
function showEndDate(value) {
    if(value == '1')
    jqueryObjectOfSes('#event_end_time-wrapper').show();
    else
    jqueryObjectOfSes('#event_end_time-wrapper').hide();
}
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
