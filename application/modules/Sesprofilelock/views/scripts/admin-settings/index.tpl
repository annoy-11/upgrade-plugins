<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesprofilelock/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<style type="text/css">
#remove{
	margin-left:190px;
}
</style>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.pluginactivated',0)){ 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php }else{ ?>
<script type="application/javascript">
showelem("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.lock', 1); ?>");
function showelem(value){
	if(value == 1){
		if($('sesprofilelock_lockedlink-wrapper'))
			$('sesprofilelock_lockedlink-wrapper').style.display = 'block';
		if($('sesproflelock_levels-wrapper'))
			$('sesproflelock_levels-wrapper').style.display = 'block';
		if($('sesprofilelock_popupinfo-wrapper'))
			$('sesprofilelock_popupinfo-wrapper').style.display = 'block';	
	}else{
		if($('sesprofilelock_lockedlink-wrapper'))
			$('sesprofilelock_lockedlink-wrapper').style.display = 'none';
		if($('sesproflelock_levels-wrapper'))
			$('sesproflelock_levels-wrapper').style.display = 'none';
		if($('sesprofilelock_popupinfo-wrapper'))
			$('sesprofilelock_popupinfo-wrapper').style.display = 'none';	
	}
}
</script>
<?php } ?>