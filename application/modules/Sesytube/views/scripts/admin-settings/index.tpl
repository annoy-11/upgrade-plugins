<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="text/javascript">
  function confirmChangeMemberHomePage(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Landing page of this theme as the Member Home page of your website. For old member home page you will have to manually make changes in the Member Home page from Layout Editor. Back up page of your current member home page will get created with the name “MH backup from SES UTube Clone Theme”.')){
      sesJqueryObject('#sesytube_changememberhomepage-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#sesytube_changememberhomepage-0').removeAttr('checked');
      sesJqueryObject('#sesytube_changememberhomepage-0').prop('checked',false);	
    }
  }
</script>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.popupsign', 1);
$loginsignupvisiablity = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.popup.enable', 1);
?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showPopup('<?php echo $showPopup;?>');
    loginsignupvisiablity('<?php echo $loginsignupvisiablity;?>');
  });
  
  function loginsignupvisiablity(value) {
    if(value == 1) {
			document.getElementById('sesytube_popup_day-wrapper').style.display = 'block';
		} else {
			document.getElementById('sesytube_popup_day-wrapper').style.display = 'none';
    }
  }
  
  function showPopup(value) {
    if(value == 1) {
			document.getElementById('sesytube_popup_enable-wrapper').style.display = 'block';
      document.getElementById('sesytube_popup_day-wrapper').style.display = 'block';
			document.getElementById('sesytube_popupfixed-wrapper').style.display = 'block';
		} else {
			document.getElementById('sesytube_popup_enable-wrapper').style.display = 'none';
      document.getElementById('sesytube_popup_day-wrapper').style.display = 'none';
			document.getElementById('sesytube_popupfixed-wrapper').style.display = 'none';
		}
  }
</script>
     
