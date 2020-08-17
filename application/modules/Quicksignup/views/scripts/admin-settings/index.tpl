<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Quicksignup/views/scripts/dismiss_message.tpl';?>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('quicksignup.pluginactivated',0)) { ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<script type="application/javascript">
  sesJqueryObject('input[name="quicksignup_enable"]').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == 0)
    sesJqueryObject('.hideField').closest('.form-wrapper').hide();
    else {
        sesJqueryObject('.hideField').closest('.form-wrapper').show();
        sesJqueryObject('input[name="quicksignup_title"]:checked').trigger('change');
        sesJqueryObject('input[name="quicksignup_description"]:checked').trigger('change');
    }
    
  });
  sesJqueryObject('input[name="quicksignup_title"]').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == 1){
      sesJqueryObject('#quicksignup_titletext-wrapper').show();
    }else{
      sesJqueryObject('#quicksignup_titletext-wrapper').hide();
    }
  });
  sesJqueryObject('input[name="quicksignup_description"]').change(function(e){
      var value = sesJqueryObject(this).val();
      if(value == 1){
          sesJqueryObject('#quicksignup_descriptiontext-wrapper').show();
      }else{
          sesJqueryObject('#quicksignup_descriptiontext-wrapper').hide();
      }
  });
  sesJqueryObject('input[name="quicksignup_enable"]:checked').trigger('change');
</script>
