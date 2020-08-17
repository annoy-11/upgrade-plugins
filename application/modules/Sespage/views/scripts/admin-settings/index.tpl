<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  function confirmChangeLandingPage(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Welcome page of this plugin as the Landing page of your website. for old landing page you will have to manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name “LP backup from SES Pages”.')){
      sesJqueryObject('#sespage_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sespage_changelanding-0').removeAttr('checked');
      sesJqueryObject('#sespage_changelanding-0').prop('checked',false);	
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.pluginactivated',0)){ ?>
  sesJqueryObject('.global_form').submit(function(e){
    sesJqueryObject('.sesbasic_waiting_msg_box').show();
  });
<?php } ?>
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_allow_follow]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_allow_integration-wrapper').show();
    }else{
      sesJqueryObject('#sespage_allow_integration-wrapper').hide();
    }
    sesJqueryObject('input[type=radio][name=can_chooseprice]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_enable_location]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_search_type-wrapper').show();
      sesJqueryObject('#sespage_enable_map_integration-wrapper').show();
      sesJqueryObject('#sespage_location_isrequired-wrapper').show();
    }else{
      sesJqueryObject('#sespage_search_type-wrapper').hide();
      sesJqueryObject('#sespage_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sespage_location_isrequired-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
    sesJqueryObject('input[type=radio][name=sespage_allow_follow]:checked').trigger('change');
    var valueStyle = sesJqueryObject('input[name=sespage_enable_location]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sespage_search_type-wrapper').show();
      sesJqueryObject('#sespage_enable_map_integration-wrapper').show();
      sesJqueryObject('#sespage_location_isrequired-wrapper').show();
    }
    else {
      sesJqueryObject('#sespage_search_type-wrapper').hide();
      sesJqueryObject('#sespage_enable_map_integration-wrapper').hide();
      sesJqueryObject('#sespage_location_isrequired-wrapper').hide();
    }
  });
  function show_position(value){
    if(value == 1){
      document.getElementById('sespage_position_watermark-wrapper').style.display = 'block';
    }else{
      document.getElementById('sespage_position_watermark-wrapper').style.display = 'none';		
    }
  }
  if(document.querySelector('[name="sespage_watermark_enable"]:checked').value == 0){
    document.getElementById('sespage_position_watermark-wrapper').style.display = 'none';	
  }else{
    document.getElementById('sespage_watermark_enable-wrapper').style.display = 'block';
  }
</script>
<style type="text/css">
#sespage_message_guidelines-element{
	padding-bottom:2px;
}
</style>