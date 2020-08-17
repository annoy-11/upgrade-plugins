<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<?php $sespagenote_adminmenu = Zend_Registry::isRegistered('sespagenote_adminmenu') ? Zend_Registry::get('sespagenote_adminmenu') : null; ?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if($sespagenote_adminmenu) { ?>
      <?php if( count($this->subNavigation) ): ?>
        <div class='sesbasic-admin-sub-tabs'>
          <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
        </div>
      <?php endif; ?>
    <?php } ?>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagenote.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
