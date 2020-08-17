<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesemailverification/views/scripts/dismiss_message.tpl';?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';
</script>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<?php $showHideShow = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.show', 1);?>
<?php $autoaccsuspend = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.autoaccsuspend', 0);?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showHideShow('<?php echo $showHideShow;?>');
    showHideShowAcco('<?php echo $autoaccsuspend;?>');
  });
  
  function showHideShowAcco(value) {
    if(value == 1) {
      document.getElementById('sesemailverification_autoaccsuspendday-wrapper').style.display = 'block';
    } else {
      document.getElementById('sesemailverification_autoaccsuspendday-wrapper').style.display = 'none';
    }
  }
  
  function showHideShow(value) {
    if(value == 1) {
      document.getElementById('sesemailverification_day-wrapper').style.display = 'block';
    } else {
      document.getElementById('sesemailverification_day-wrapper').style.display = 'none';
    }
  }
</script>