<?php
 /**
 * SocialEngineSolutions
 *
 * @category Application_Sesultimateslide
 * @package Sesultimateslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: index.tpl 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
?>

<h2>
  <?php echo $this->translate('Ultimate Banner Slideshow Plugin') ?>
</h2>
<?php $sesultimateslide_adminmenu = Zend_Registry::isRegistered('sesultimateslide_adminmenu') ? Zend_Registry::get('sesultimateslide_adminmenu') : null; ?>
<?php if(!empty($sesultimateslide_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
  <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
  <?php endif; ?>
<?php } ?>

<div class='clear'>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesultimateslide.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
