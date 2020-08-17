<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesdiscussion/views/scripts/dismiss_message.tpl';?>

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
<script>
  window.addEvent('domready',function() {
    showCat('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1);?>');
    showASNEW('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.automaticallymarkasnew', 0);?>');
  });
  function showCat(value) {
    if(value == 1) {
      $('sesdiscussion_categoryrequried-wrapper').style.display = 'block';
    } else {
      $('sesdiscussion_categoryrequried-wrapper').style.display = 'none';
    }
  }
  function showASNEW(value) {
    if(value == 1) {
      $('sesdiscussion_newdays-wrapper').style.display = 'block';
    } else {
      $('sesdiscussion_newdays-wrapper').style.display = 'none';
    }
  }
</script>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>