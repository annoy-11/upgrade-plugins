<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<?php include APPLICATION_PATH .  '/application/modules/Sesqa/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form'>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>

<script type="application/javascript">

sesJqueryObject('input[type=radio][name=sesqa_enable_location]').change(function() {
    if (this.value == '1') {
        sesJqueryObject('#sesqa_location_mandatory-wrapper').show();
         sesJqueryObject('#sesqa_search_type-wrapper').show();
    }else{
        sesJqueryObject('#sesqa_location_mandatory-wrapper').hide();
         sesJqueryObject('#sesqa_search_type-wrapper').hide();
    }
});

sesJqueryObject('#sesqa_enable_newLabel').change(function(){
  if(this.value == 1){
      sesJqueryObject('#sesqa_new_label-wrapper').show();
  }else{
    sesJqueryObject('#sesqa_new_label-wrapper').hide();   
  }
})

sesJqueryObject(document).ready(function(){
  sesJqueryObject('input[type=radio][name=sesqa_enable_location]:checked').trigger('change'); 
  sesJqueryObject('#sesqa_enable_newLabel').trigger('change'); 
})
</script>
