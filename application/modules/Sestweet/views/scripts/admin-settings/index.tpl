<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sestweet/views/scripts/dismiss_message.tpl';?>

<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';

  window.addEvent('domready',function() {
    enableSelection('<?php echo $settings->getSetting('sestweet_textselection', 1);?>');
  });

function enableSelection(value) {

  if(value == 1) {
  
    if($('sestweet_twitterhandler-wrapper'))
      $('sestweet_twitterhandler-wrapper').style.display = 'block';
    if($('sestweet_enabletwitter-wrapper'))
      $('sestweet_enabletwitter-wrapper').style.display = 'block';
    if($('sestweet_enablefacebook-wrapper'))
      $('sestweet_enablefacebook-wrapper').style.display = 'block';  
  } else {
    if($('sestweet_twitterhandler-wrapper'))
      $('sestweet_twitterhandler-wrapper').style.display = 'none';
    if($('sestweet_enabletwitter-wrapper'))
      $('sestweet_enabletwitter-wrapper').style.display = 'none';
    if($('sestweet_enablefacebook-wrapper'))
      $('sestweet_enablefacebook-wrapper').style.display = 'none';
  }
}
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sestweet.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>