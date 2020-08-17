<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  function confirmChangeLandingBusiness(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Welcome business of this plugin as the Landing business of your website. for old landing business you will have to manually make changes in the Landing business from Layout Editor. Back up business of your current landing business will get created with the name “LP backup from SES Businesses”.')){
      sesJqueryObject('#sesbusiness_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesbusiness_changelanding-0').removeAttr('checked');
      sesJqueryObject('#sesbusiness_changelanding-0').prop('checked',false);	
    }
  }
</script>
<div class="sesbasic_waiting_msg_box" style="display:none;">
  <div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<script type="text/javascript">
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.pluginactivated',0)){ ?>
  sesJqueryObject('.global_form').submit(function(e){
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
  });
<?php } ?>
  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_allow_follow]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_allow_integration-wrapper').show();
    }else{
      sesJqueryObject('#sesbusiness_allow_integration-wrapper').hide();
    }
    sesJqueryObject('input[type=radio][name=can_chooseprice]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_enable_location]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_search_type-wrapper').show();
      sesJqueryObject('#sesbusiness_enable_map_integration-wrapper').show();
      sesJqueryObject('#sesbusiness_location_isrequired-wrapper').show();
    }else{
      sesJqueryObject('#sesbusiness_search_type-wrapper').hide();
      sesJqueryObject('#sesbusiness_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sesbusiness_location_isrequired-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
    sesJqueryObject('input[type=radio][name=sesbusiness_allow_follow]:checked').trigger('change');
    var valueStyle = sesJqueryObject('input[name=sesbusiness_enable_location]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sesbusiness_search_type-wrapper').show();
      sesJqueryObject('#sesbusiness_enable_map_integration-wrapper').show();
      sesJqueryObject('#sesbusiness_location_isrequired-wrapper').show();
    }
    else {
      sesJqueryObject('#sesbusiness_search_type-wrapper').hide();
      sesJqueryObject('#sesbusiness_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sesbusiness_location_isrequired-wrapper').hide();
    }
  });
  function show_position(value){
    if(value == 1){
      document.getElementById('sesbusiness_position_watermark-wrapper').style.display = 'block';
    }else{
      document.getElementById('sesbusiness_position_watermark-wrapper').style.display = 'none';		
    }
  }
  if(document.querySelector('[name="sesbusiness_watermark_enable"]:checked').value == 0){
    document.getElementById('sesbusiness_position_watermark-wrapper').style.display = 'none';	
  }else{
    document.getElementById('sesbusiness_watermark_enable-wrapper').style.display = 'block';
  }
</script>
<style type="text/css">
#sesbusiness_message_guidelines-element{
	padding-bottom:2px;
}
</style>
