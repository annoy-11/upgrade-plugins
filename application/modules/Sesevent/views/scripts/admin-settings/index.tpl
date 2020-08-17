<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesevent/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <div class='sesbasic-form-cont'>
    <div class='clear'>
		  <div class='settings sesbasic_admin_form'>
		    <?php echo $this->form->render($this); ?>
		  </div>
		</div>
		</div>
  </div>
</div>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.pluginactivated',0)){?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<script type="application/javascript">
sesJqueryObject(document).on('change','input[type=radio][name=sesevent_enable_location]',function(){
	if (this.value == 1) {
    sesJqueryObject('#sesevent_search_type-wrapper').show();
  }else{
		 sesJqueryObject('#sesevent_search_type-wrapper').hide();
	}
});
function hideTerm(value){
	if(value == 0) {
		if($('sesevent_tinymce-wrapper'))
			$('sesevent_tinymce-wrapper').style.display = 'none';
	} else {
		if($('sesevent_tinymce-wrapper'))
			$('sesevent_tinymce-wrapper').style.display = 'block';
	}
}
window.addEvent('domready', function() {
	var valueLocation = sesJqueryObject('input[name=sesevent_enable_location]:checked').val();
	if(valueLocation == 0)
		sesJqueryObject('#sesevent_search_type-wrapper').hide();
  rsvpevent("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.rsvpevent', 1); ?>");
  guestevent("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.inviteguest', 1); ?>");
	hideTerm("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesevent.eventcustom', 1); ?>");
});


function rsvpevent(value) {
	if(value == 1) {
		if($('sesevent_rsvpdefaultval-wrapper'))
			$('sesevent_rsvpdefaultval-wrapper').style.display = 'none';
	} else {
		if($('sesevent_rsvpdefaultval-wrapper'))
			$('sesevent_rsvpdefaultval-wrapper').style.display = 'block';
	}
}

function guestevent(value) {
	if(value == 1) {
		if($('sesevent_guestdefaultval-wrapper'))
			$('sesevent_guestdefaultval-wrapper').style.display = 'none';
	} else {
		if($('sesevent_guestdefaultval-wrapper'))
			$('sesevent_guestdefaultval-wrapper').style.display = 'block';
	}
}

</script>