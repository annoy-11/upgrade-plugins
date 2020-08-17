<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  function confirmChangeLandingGroup(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Welcome group of this plugin as the Landing group of your website. for old landing group you will have to manually make changes in the Landing group from Layout Editor. Back up group of your current landing group will get created with the name “LP backup from SES Groups”.')){
      sesJqueryObject('#sesgroup_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesgroup_changelanding-0').removeAttr('checked');
      sesJqueryObject('#sesgroup_changelanding-0').prop('checked',false);	
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.pluginactivated',0)){ ?>
  sesJqueryObject('.global_form').submit(function(e){
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
  });
<?php } ?>
  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_allow_follow]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_allow_integration-wrapper').show();
    }else{
      sesJqueryObject('#sesgroup_allow_integration-wrapper').hide();
    }
    sesJqueryObject('input[type=radio][name=can_chooseprice]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_enable_location]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_search_type-wrapper').show();
      sesJqueryObject('#sesgroup_enable_map_integration-wrapper').show();
      sesJqueryObject('#sesgroup_location_isrequired-wrapper').show();
    }else{
      sesJqueryObject('#sesgroup_search_type-wrapper').hide();
      sesJqueryObject('#sesgroup_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sesgroup_location_isrequired-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
    sesJqueryObject('input[type=radio][name=sesgroup_allow_follow]:checked').trigger('change');
    var valueStyle = sesJqueryObject('input[name=sesgroup_enable_location]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sesgroup_search_type-wrapper').show();
      sesJqueryObject('#sesgroup_enable_map_integration-wrapper').show();
      sesJqueryObject('#sesgroup_location_isrequired-wrapper').show();
    }
    else {
      sesJqueryObject('#sesgroup_search_type-wrapper').hide();
      sesJqueryObject('#sesgroup_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sesgroup_location_isrequired-wrapper').hide();
    }
  });
  function show_position(value){
    if(value == 1){
      document.getElementById('sesgroup_position_watermark-wrapper').style.display = 'block';
    }else{
      document.getElementById('sesgroup_position_watermark-wrapper').style.display = 'none';		
    }
  }
  if(document.querySelector('[name="sesgroup_watermark_enable"]:checked').value == 0){
    document.getElementById('sesgroup_position_watermark-wrapper').style.display = 'none';	
  }else{
    document.getElementById('sesgroup_watermark_enable-wrapper').style.display = 'block';
  }
</script>
<style type="text/css">
#sesgroup_message_guidelines-element{
	padding-bottom:2px;
}
</style>