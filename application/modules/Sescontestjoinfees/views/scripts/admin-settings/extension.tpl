<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontestjoinfees
 * @package    Sescontestjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: extension.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php $this->headLink()->appendStylesheet('application/modules/Sesbasic/externals/styles/font-awesome.css'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
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
<script type="application/javascript">
  sesJqueryObject('#commision').hide();
</script>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontestjoinfees.pluginactivated',0)) { ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>