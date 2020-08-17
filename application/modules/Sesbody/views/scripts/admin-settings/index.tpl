 <?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesbody/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesbody_global_setting'>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
	sesJqueryObject('.global_form').submit(function(e){
		sesJqueryObject('.sesbasic_waiting_msg_box').show();
	});
	</script>
<?php else: ?>

<?php $showLoginPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbody.popupshow', 1);?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showLoginPopup('<?php echo $showLoginPopup;?>');
  });
  
  function showLoginPopup(value) {
    if(value == 1) {
      document.getElementById('sesbody_popup_day-wrapper').style.display = 'block';
      document.getElementById('sesbody_popup_enable-wrapper').style.display = 'block';
    } else {
      document.getElementById('sesbody_popup_day-wrapper').style.display = 'none';
      document.getElementById('sesbody_popup_enable-wrapper').style.display = 'none';
    }
  }
</script>
<?php endif; ?>