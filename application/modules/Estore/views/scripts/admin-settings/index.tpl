<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  function confirmChangeLandingStore(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Welcome store of this plugin as the Landing store of your website. for old landing store you will have to manually make changes in the Landing store from Layout Editor. Back up store of your current landing store will get created with the name “LP backup from SES Stores”.')){
      sesJqueryObject('#estore_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#estore_changelanding-0').removeAttr('checked');
      sesJqueryObject('#estore_changelanding-0').prop('checked',false);	
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.pluginactivated',0)){ ?>
  sesJqueryObject('.global_form').submit(function(e){
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
  });
<?php } ?>


sesJqueryObject(document).on('change','input[type=radio][name=estore_type]',function() {
    if (this.value == 1) {
        sesJqueryObject('#estore_payment_type-wrapper').show();
        sesJqueryObject('input[type=radio][name=estore_payment_type]:checked').trigger('change');
        sesJqueryObject('#estore_payment_checkinfo-wrapper').show();
    }else{
        sesJqueryObject('#estore_payment_type-wrapper').hide();
        sesJqueryObject('#estore_payment_checkinfo-wrapper').show();
    }
});
sesJqueryObject(document).on('change','input[type=radio][name=estore_payment_type]',function() {
    if (this.value == 1) {
        sesJqueryObject('#estore_payment_sellers-wrapper').hide();
        sesJqueryObject('#estore_payment_siteadmin-wrapper').show();
        sesJqueryObject('#estore_payment_checkinfo-wrapper').show();
    }else{
        sesJqueryObject('#estore_payment_sellers-wrapper').show();
        sesJqueryObject('#estore_payment_siteadmin-wrapper').hide();
        sesJqueryObject('#estore_payment_checkinfo-wrapper').hide();
    }
});



sesJqueryObject(document).on('change','input[type=radio][name=estore_allow_fixedtext]',function(){
    if (this.value == 1) {
        sesJqueryObject('#estore_fixedtext-wrapper').show();
    }else{
        sesJqueryObject('#estore_fixedtext-wrapper').hide();
    }
});
  sesJqueryObject(document).on('change','input[type=radio][name=estore_allow_follow]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_allow_integration-wrapper').show();
    }else{
      sesJqueryObject('#estore_allow_integration-wrapper').hide();
    }
    sesJqueryObject('input[type=radio][name=can_chooseprice]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[type=radio][name=estore_enable_location]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_search_type-wrapper').show();
      sesJqueryObject('#estore_enable_map_integration-wrapper').show();
      sesJqueryObject('#estore_location_isrequired-wrapper').show();
    }else{
      sesJqueryObject('#estore_search_type-wrapper').hide();
      sesJqueryObject('#estore_enable_map_integration-wrapper').hide();
      sesJqueryObject('#estore_location_isrequired-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
      sesJqueryObject('input[type=radio][name=estore_type]:checked').trigger('change');
    sesJqueryObject('input[type=radio][name=estore_allow_fixedtext]:checked').trigger('change');
    sesJqueryObject('input[type=radio][name=estore_allow_follow]:checked').trigger('change');
    var valueStyle = sesJqueryObject('input[name=estore_enable_location]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#estore_search_type-wrapper').show();
      sesJqueryObject('#estore_enable_map_integration-wrapper').show();
      sesJqueryObject('#estore_location_isrequired-wrapper').show();
    }
    else {
      sesJqueryObject('#estore_search_type-wrapper').hide();
      sesJqueryObject('#estore_enable_map_integration-wrapper').hide();
      sesJqueryObject('#estore_location_isrequired-wrapper').hide();
    }
  });
  function show_position(value){
    if(value == 1){
      document.getElementById('estore_position_watermark-wrapper').style.display = 'block';
    }else{
      document.getElementById('estore_position_watermark-wrapper').style.display = 'none';		
    }
  }
  if(document.querySelector('[name="estore_watermark_enable"]:checked').value == 0){
    document.getElementById('estore_position_watermark-wrapper').style.display = 'none';	
  }else{
    document.getElementById('estore_watermark_enable-wrapper').style.display = 'block';
  }
</script>
<style type="text/css">
#estore_message_guidelines-element{
	padding-bottom:2px;
}
</style>
