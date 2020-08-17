<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbchat
 * @package    Sesfbchat
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesfbchat/views/scripts/dismiss_message.tpl';
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
?>

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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfbchat.pluginactivated',0)) { ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>

<script type="application/javascript">

sesJqueryObject(document).on('change','input[type=radio][name=sesfbchat_enable_messenger]',function(){
    var value = sesJqueryObject(this).val();
    if(value == 1){
        sesJqueryObject('#sesfbchat_login_text-wrapper').show();
        sesJqueryObject('#sesfbchat_logout_text-wrapper').show();    
        sesJqueryObject('#sesfbchat_enable_timing-wrapper').show();
        sesJqueryObject('#sesfbchat_messenger_icon-wrapper').show();
        sesJqueryObject('#sesfbchat_starttime-wrapper').show();
        sesJqueryObject('#sesfbchat_endtime-wrapper').show();        
        sesJqueryObject('#sesfbchat_theme_color-wrapper').show();
        sesJqueryObject('#sesfbchat_devices-wrapper').show();
        sesJqueryObject('#sesfbchat_position-wrapper').show();
        sesJqueryObject('#sesfbchat_button_size-wrapper').show();
        sesJqueryObject('#sesfbchat_app_id-wrapper').show();
        sesJqueryObject('#sesfbchat_page_id-wrapper').show();
    }else{
        sesJqueryObject('#sesfbchat_login_text-wrapper').hide();
        sesJqueryObject('#sesfbchat_logout_text-wrapper').hide();    
        sesJqueryObject('#sesfbchat_enable_timing-wrapper').hide();
        sesJqueryObject('#sesfbchat_messenger_icon-wrapper').hide();
        sesJqueryObject('#sesfbchat_starttime-wrapper').hide();
        sesJqueryObject('#sesfbchat_endtime-wrapper').hide();        
        sesJqueryObject('#sesfbchat_theme_color-wrapper').hide();
        sesJqueryObject('#sesfbchat_devices-wrapper').hide();
        sesJqueryObject('#sesfbchat_position-wrapper').hide();
        sesJqueryObject('#sesfbchat_button_size-wrapper').hide();
        sesJqueryObject('#sesfbchat_app_id-wrapper').hide();
        sesJqueryObject('#sesfbchat_page_id-wrapper').hide();
     }
})
  sesJqueryObject(document).ready(function(e){
  sesJqueryObject('.event_calendar_container').hide();
    sesJqueryObject('input[type=radio][name=sesfbchat_enable_messenger]:checked').trigger('change');    
  });

sesJqueryObject(document).on('change','input[type=radio][name=sesfbchat_enable_timing]',function(){
    var value = sesJqueryObject(this).val();
    if(value == 1){
       
        sesJqueryObject('#sesfbchat_starttime-wrapper').show();
        sesJqueryObject('#sesfbchat_endtime-wrapper').show();
    }else{
    
        sesJqueryObject('#sesfbchat_starttime-wrapper').hide();
        sesJqueryObject('#sesfbchat_endtime-wrapper').hide();
     }
})
  sesJqueryObject(document).ready(function(e){
    sesJqueryObject('input[type=radio][name=sesfbchat_enable_timing]:checked').trigger('change');    
  });

  

</script>
