<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmembershorturl/views/scripts/dismiss_message.tpl';?>

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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<?php $enablecustomurl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enablecustomurl', 1);
$enableglobalurl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembershorturl.enableglobalurl', 0);  ?>
<script type="application/javascript">

  function openURL(name){
    if(name == "manual"){
      Smoothbox.open('admin/sesmembershorturl/settings/manual');
      parent.Smoothbox.close;
      return false;
    }else{
      Smoothbox.open('admin/sesmembershorturl/settings/automatic');
      parent.Smoothbox.close;
      return false;
    }  
  }
  
  window.addEvent('domready',function() {
    showHide('<?php echo $enablecustomurl;?>');
    customURL('<?php echo $enableglobalurl;?>');
  });
    
  function customURL(value) {
    if(value == 1) {
      $('sesmembershorturl_customurltext-wrapper').style.display = 'block';
    } else {
      $('sesmembershorturl_customurltext-wrapper').style.display = 'none';
    }
    
  }
  
  function showHide(value) {
    if(value == 1) {
      $('sesmembershorturl_enableglobalurl-wrapper').style.display = 'block';
      $('sesmembershorturl_customurltext-wrapper').style.display = 'block';
      $('sesmembershorturl_update_enable-wrapper').style.display = 'none';
    } else { 
      $('sesmembershorturl_enableglobalurl-wrapper').style.display = 'none';
      $('sesmembershorturl_customurltext-wrapper').style.display = 'none';
      $('sesmembershorturl_update_enable-wrapper').style.display = 'block';
    }
  }
</script>