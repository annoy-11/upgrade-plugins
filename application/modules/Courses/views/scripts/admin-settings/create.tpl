<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>

<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.description', 1);?>
<?php $enableCategory = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.category', 1);?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.show.new', 1);?>
<?php $enableMainPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.main.photo', 1); ?>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>'); 
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#courses_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#courses_icon_open_smoothbox-wrapper').hide();
 }
 showCourseCategory('<?php echo $enableCategory; ?>');
 function showCourseCategory(value) {
  if(value == 1)
    sesJqueryObject('#courses_category_mandatory-wrapper').show();
  else
     sesJqueryObject('#courses_category_mandatory-wrapper').hide();
  }
 showCourseDescription('<?php echo $enableDescription;?>');
 function showCourseDescription(value) {
  if(value == 1){
    sesJqueryObject('#courses_wysiwyg_editor-wrapper').show();
    sesJqueryObject('#courses_description_mandatory-wrapper').show();
  }else{
    sesJqueryObject('#courses_description_mandatory-wrapper').hide();
    sesJqueryObject('#courses_wysiwyg_editor-wrapper').hide();
  }
 }
  showCoursePhoto('<?php echo $enableMainPhoto; ?>');
 function showCoursePhoto(value) {
  if(value == 1)
    sesJqueryObject('#courses_mainPhoto_mandatory-wrapper').show();
  else
    sesJqueryObject('#courses_mainPhoto_mandatory-wrapper').hide();
 }
 </script>
