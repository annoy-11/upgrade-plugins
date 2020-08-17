<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Otpsms/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('otpsms.pluginactivated',0)){  ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>

<script type="application/javascript">
  sesJqueryObject('input[name="otpsms_signup_phonenumber"]').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == 1){
      sesJqueryObject('#otpsms_choose_phonenumber-wrapper').show();
      sesJqueryObject('#otpsms_required_phonenumber-wrapper').show();  
      sesJqueryObject('#otpsms_email_format-wrapper').show();  
      sesJqueryObject('input[name="otpsms_choose_phonenumber"]:checked').trigger('change');
    }else{
      sesJqueryObject('#otpsms_choose_phonenumber-wrapper').hide();
      sesJqueryObject('#otpsms_required_phonenumber-wrapper').hide();  
      sesJqueryObject('#otpsms_email_format-wrapper').hide();  
    }
    
  });
  sesJqueryObject('input[name="otpsms_choose_phonenumber"]').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == 1){
      sesJqueryObject('#otpsms_required_phonenumber-wrapper').hide();  
      sesJqueryObject('#otpsms_email_format-wrapper').show();  
    }else{
      sesJqueryObject('#otpsms_required_phonenumber-wrapper').show();  
      sesJqueryObject('#otpsms_email_format-wrapper').hide();  
    }
  });
  sesJqueryObject('input[name="otpsms_signup_phonenumber"]:checked').trigger('change');
  sesJqueryObject('input[name="otpsms_choose_phonenumber"]:checked').trigger('change');
</script>
