
<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: settings.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if(count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.pluginactivated',0)) { ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<script type="application/javascript">
  function enable_package(value){
    if(value == 1){
      document.getElementById('sesgrouppackage_package_info-wrapper').style.display = 'block';
      document.getElementById('sesgrouppackage_payment_mod_enable-wrapper').style.display = 'block';
    }else{
      document.getElementById('sesgrouppackage_package_info-wrapper').style.display = 'none';
      document.getElementById('sesgrouppackage_payment_mod_enable-wrapper').style.display = 'none';
    }
  }
  enable_package(document.getElementById('sesgrouppackage_enable_package').value);
</script>
