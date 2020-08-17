<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmaterial/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesmaterial_global_setting'>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
	sesJqueryObject('.global_form').submit(function(e){
		sesJqueryObject('.sesbasic_waiting_msg_box').show();
	});
	</script>
<?php else: ?>

<?php $showLoginPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.popupshow', 1);?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showLoginPopup('<?php echo $showLoginPopup;?>');
  });
  
  function showLoginPopup(value) {
    if(value == 1) {
      document.getElementById('sesmaterial_popup_day-wrapper').style.display = 'block';
      document.getElementById('sesmaterial_popup_enable-wrapper').style.display = 'block';
    } else {
      document.getElementById('sesmaterial_popup_day-wrapper').style.display = 'none';
      document.getElementById('sesmaterial_popup_enable-wrapper').style.display = 'none';
    }
  }
</script>
<?php endif; ?>
