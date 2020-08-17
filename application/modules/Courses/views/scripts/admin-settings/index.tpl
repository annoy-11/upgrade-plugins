<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.pluginactivated',0)){  ?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<?php $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.photos.watermark', 1);?>
<?php $enableLocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.location', 1);?>
<script type="text/javascript">
 showCourseWatermark('<?php echo $enableWatermark;?>');
 function showCourseWatermark(value) {
  if(value == 1)
    sesJqueryObject('#courses_watermark_position-wrapper').show();
  else
    sesJqueryObject('#courses_watermark_position-wrapper').hide();
 }
 showCourseLocation('<?php echo $enableLocation; ?>');
 function showCourseLocation(value) { 
    if(value == 1) {
      sesJqueryObject('#courses_search_type-wrapper').show(); 
      sesJqueryObject('#courses_location_isrequired-wrapper').show(); 
      sesJqueryObject('#courses_enable_map_integration-wrapper').show();
    } else {
      sesJqueryObject('#courses_location_isrequired-wrapper').hide(); 
      sesJqueryObject('#courses_search_type-wrapper').hide(); 
      sesJqueryObject('#courses_enable_map_integration-wrapper').hide();
    }
 }
 </script>
