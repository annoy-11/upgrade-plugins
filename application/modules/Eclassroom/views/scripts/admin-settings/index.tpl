<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<?php $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.photos.watermark', 1);?>
<?php $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1);?>
<script type="text/javascript">
 showClassroomWatermark('<?php echo $enableWatermark;?>');
 function showClassroomWatermark(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_watermark_position-wrapper').show();
  else
    sesJqueryObject('#eclassroom_watermark_position-wrapper').hide();
 }
 
 showClassroomLocation('<?php echo $enableWatermark;?>');
 function showClassroomLocation(value) { 
    if(value == 1) {
      sesJqueryObject('#eclassroom_search_type-wrapper').show(); 
      sesJqueryObject('#eclassroom_location_isrequired-wrapper').show();
      sesJqueryObject('#eclassroom_enable_map_integration-wrapper').hide(); 
    } else {
      sesJqueryObject('#eclassroom_location_isrequired-wrapper').hide(); 
      sesJqueryObject('#eclassroom_search_type-wrapper').hide(); 
      sesJqueryObject('#eclassroom_enable_map_integration-wrapper').hide(); 
    }
 }
 </script>
<script type="text/javascript">
  function confirmChangeLandingClassroom(value) {
    if(value == 1 && !confirm('Are you sure want to set the default Welcome classroom of this plugin as the Landing classroom of your website. for old landing classroom you will have to manually make changes in the Landing classroom from Layout Editor. Back up classroom of your current landing classroom will get created with the name “LP backup from SES Stores”.')){
      sesJqueryObject('#eclassroom_changelanding-0').prop('checked',true);
    }else if(value == 0){
        //silence
    }else{
      sesJqueryObject('#eclassroom_changelanding-0').removeAttr('checked');
      sesJqueryObject('#eclassroom_changelanding-0').prop('checked',false);	
    }
  }
</script>
