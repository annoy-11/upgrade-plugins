<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form '>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php endif; ?>

<script>
    window.onload=function () {
        changeenablelocation();
        changeLocationMandatory();
        changeSupportMandatory();
        changeReasonsMandatory();
    };
    
    function changeenablelocation() {
        var values=document.querySelector('input[name="epetition_enable_location"]:checked').value;
        if(parseInt(values)==1)
        {
            document.getElementById("epetition_search_type-wrapper").style.display='block';
        }
        else
        {
            document.getElementById("epetition_search_type-wrapper").style.display='none';
        }
    }

    function changeLocationMandatory() {
        var values=document.querySelector('input[name="epetition_enb_loc"]:checked').value;
        if(parseInt(values)==1)
        {
            document.getElementById("epetition_loc_man-wrapper").style.display='block';
        }
        else
        {
            document.getElementById("epetition_loc_man-wrapper").style.display='none';
        }
    }

    function changeSupportMandatory() {
        var values=document.querySelector('input[name="epetition_enb_supt"]:checked').value;
        if(parseInt(values)==1)
        {
            document.getElementById("epetition_supt_man-wrapper").style.display='block';
        }
        else
        {
            document.getElementById("epetition_supt_man-wrapper").style.display='none';
        }
    }

    function changeReasonsMandatory() {
        var values=document.querySelector('input[name="epetition_enb_reason"]:checked').value;
        if(parseInt(values)==1)
        {
            document.getElementById("epetition_reason_man-wrapper").style.display='block';
        }
        else
        {
            document.getElementById("epetition_reason_man-wrapper").style.display='none';
        }
    }
</script>
