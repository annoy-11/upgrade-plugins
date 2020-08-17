<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesletteravatar
 * @package    Sesletteravatar
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesletteravatar/views/scripts/dismiss_message.tpl';?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.pluginactivated',0)){  ?>
  <?php $usersData = Engine_Api::_()->sesletteravatar()->getUsersData(); ?> 
  <?php if($usersData > 0){ ?>
    <div class="sesletteravatar_warning">
      There are <?php echo $usersData; ?> members on your website who have not uploaded their profile pictures. <a href="<?php echo $this->url(array('module' => 'sesletteravatar', 'controller' => 'settings', 'action' => 'sink-userphotos'),'admin_default',true); ?>">click here</a> to create letter avatars for those users.
    </div>
<?php } } ?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $letters = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.letters', 1);?>
<script type="application/javascript">

  window.addEvent('domready',function() {
    showHide('<?php echo $letters;?>');
  });

  function showHide(value) {
  
    if(value == 3) {
      $('sesletteravatar_countchar-wrapper').style.display = 'block';
    } else {
      $('sesletteravatar_countchar-wrapper').style.display = 'none';
    }
  
  }
</script>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesletteravatar.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>