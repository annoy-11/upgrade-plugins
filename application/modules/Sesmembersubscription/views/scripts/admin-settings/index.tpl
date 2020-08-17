<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembersubscription
 * @package    Sesmembersubscription
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmembersubscription/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesmembersubscription_waiting_msg_box" style="display:none;">
	<div class="sesmembersubscription_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmembersubscription.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesmembersubscription_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<style type="text/css">
.sesmembersubscription_waiting_msg_box{
	background-color:rgba(255, 255, 255, 0.8);
	height:100%;
	left:0;
	position:fixed;
	top:0;
	width:100%;
}
.sesmembersubscription_waiting_msg_box_cont{
	background-color:rgba(255, 255, 255, 0.8);
	border:5px solid #43bbef;
	box-shadow:0 0 5px rgba(0, 0, 0, 0.5);
	font-size:20px;
	font-weight:bold;
	height:100px;
	left:50%;
	margin:-50px 0 0 -300px;
	padding:20px;
	position:fixed;
	text-align:center;
	top:50%;
	width:600px;
	z-index:24;
}
.sesmembersubscription_waiting_msg_box_cont i{
	background-image:url(application/modules/Sesbrowserpush/externals/images/loading.gif);
	background-position:center center;
	background-repeat:no-repeat;
	display:block;
	height:30px;
	margin-top:20px;
	width:100%;
}
</style>