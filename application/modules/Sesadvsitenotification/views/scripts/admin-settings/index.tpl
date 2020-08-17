<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesadvsitenotification/views/scripts/dismiss_message.tpl';
?>
<div class="settings sesbasic_admin_form">
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php }else{ ?>
<script type="application/javascript">
function notification(value){
  if(value == 0){
    document.getElementById('sesadvsitenotification_position-wrapper').style.display = 'none';
    document.getElementById('sesadvsitenotification_autohide-wrapper').style.display = 'none';
    document.getElementById('sesadvsitenotification_autohideduration-wrapper').style.display = 'none';
    document.getElementById('sesadvsitenotification_autohideduration-wrapper').style.display = 'none';
  }else{
    document.getElementById('sesadvsitenotification_position-wrapper').style.display = 'block';
    document.getElementById('sesadvsitenotification_autohide-wrapper').style.display = 'block';
    document.getElementById('sesadvsitenotification_autohideduration-wrapper').style.display = 'block';
    duration();  
  }  
}
function duration(){
  var value = document.querySelector('input[name="sesadvsitenotification_autohide"]:checked').value; 
  if(value == 0)
     document.getElementById('sesadvsitenotification_autohideduration-wrapper').style.display = 'none';
  else
    document.getElementById('sesadvsitenotification_autohideduration-wrapper').style.display = 'block';
}
notification(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.notification',1); ?>);
</script>
<?php } ?>