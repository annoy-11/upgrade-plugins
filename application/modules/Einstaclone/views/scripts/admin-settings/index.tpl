<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Einstaclone/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/jQuery/jquery.min.js'); ?>
<div class='clear'>
  <div class='settings einstaclone_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">
  function confirmChangeLandingPage(value, param) {
      if(param == 1) {
        if(value == 1 && !confirm('Are you sure want to set the default Landing page of this theme as the Landing page of your website. For old landing page you will have to manually make changes in the Landing page from Layout Editor. Back up page of your current landing page will get created with the name "LP backup from SES - Insta Clone Theme".')) {
          scriptJquery('#einstaclone_changelanding-0').prop('checked',true);
        } else if(value == 0) {
            //silence
        } else {
          scriptJquery('#einstaclone_changelanding-0').removeAttr('checked');
          scriptJquery('#einstaclone_changelanding-0').prop('checked',false);
        }
      } else if(param == 2) {
        if(value == 1 && !confirm('Are you sure you want to change your member home page? This change can not be undone.')) {
          scriptJquery('#einstaclone_changememberhome-0').prop('checked',true);
        } else if(value == 0) {
            //silence
        } else {
          scriptJquery('#einstaclone_changememberhome-0').removeAttr('checked');
          scriptJquery('#einstaclone_changememberhome-0').prop('checked',false);
        }
      } else if(param == 3) {
        if(value == 1 && !confirm('Are you sure you want to change your member profile page? This change can not be undone.')) {
          scriptJquery('#einstaclone_changememberprofile-0').prop('checked',true);
        } else if(value == 0) {
            //silence
        } else {
          scriptJquery('#einstaclone_changememberprofile-0').removeAttr('checked');
          scriptJquery('#einstaclone_changememberprofile-0').prop('checked',false);
        }
      }
  }
</script>

<div class="einstaclone_waiting_msg_box" style="display:none;">
	<div class="einstaclone_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>

<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.pluginactivated',0)) { ?>
	<script type="application/javascript">
  	scriptJquery('.global_form').submit(function(e){
			scriptJquery('.einstaclone_waiting_msg_box').show();
		});
  </script>
<?php } ?>
