<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sessportz_global_setting'>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
	sesJqueryObject('.global_form').submit(function(e){
		sesJqueryObject('.sesbasic_waiting_msg_box').show();
	});
	</script>
<?php else: ?>

<?php $showLoginPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.popupshow', 1);?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showLoginPopup('<?php echo $showLoginPopup;?>');
  });
  
  function showLoginPopup(value) {
    if(value == 1) {
      document.getElementById('sessportz_popup_day-wrapper').style.display = 'block';
      document.getElementById('sessportz_popup_enable-wrapper').style.display = 'block';
    } else {
      document.getElementById('sessportz_popup_day-wrapper').style.display = 'none';
      document.getElementById('sessportz_popup_enable-wrapper').style.display = 'none';
    }
  }
</script>
<?php endif; ?>