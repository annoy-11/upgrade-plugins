<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmusicapp
 * @package    Sesmusicapp
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmusicapp/views/scripts/dismiss_message.tpl';?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');?>
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
<script type="text/javascript">
	function homelayout(value){
	var url = '<?php echo $this->url(array("id" => null)) ?>';
    window.location.href = en4.core.baseUrl + 'admin/content?page=' + value;
	
}
  function confirmChangeLandingPage(value) {
    if(value == 1 && !confirm('Are you sure want to set the default home page of this plugin as the Landing page of your website. for old landing page you will have to manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name “SES - Advanced Music App  - Landing Page Backup”.')){
      sesJqueryObject('#sesmusicapp_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesmusicapp_changelanding-0').removeAttr('checked');
      sesJqueryObject('#sesmusicapp_changelanding-0').prop('checked',false);	
    }
  }
	function confirmChangeHomePage(value) {
    if(value == 1 && !confirm('Are you sure want to set the default home page of this plugin as the member home page of your website. for old member home page you will have to manually make changes in the member home page from Layout Editor. Back up page of your current member home page will get created with the name “SES - Advanced Music App - Member Home Page Backup”.')){
      sesJqueryObject('#sesmusicapp_changememberhome-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesmusicapp_changememberhome-0').removeAttr('checked');
      sesJqueryObject('#sesmusicapp_changememberhome-0').prop('checked',false);	
    }
  }
	function confirmChangeWelcomePage(value) {
    if(value == 1 && !confirm('Are you sure want to set the default home page of this plugin as the welcome page of Advanced Music Plugin on your website. for old welcome page you will have to manually make changes in the welcome page from Layout Editor. Back up page of your current welcome page will get created with the name “SES - Advanced Music App - Professional Music Welcome Page Backup”.')){
      sesJqueryObject('#sesmusicapp_changewelcome-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesmusicapp_changewelcome-0').removeAttr('checked');
      sesJqueryObject('#sesmusicapp_changewelcome-0').prop('checked',false);	
    }
  }
</script>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmusicapp.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>