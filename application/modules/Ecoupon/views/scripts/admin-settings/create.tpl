<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: create.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php include APPLICATION_PATH .  '/application/modules/Ecoupon/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.enable.description', 1);?>
<?php $enableCategory = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.enable.category', 1);?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.show.new', 1);?>
<?php $enableMainPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.main.photo', 1); ?>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>'); 
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#ecoupon_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#ecoupon_icon_open_smoothbox-wrapper').hide();
 }
 showCourseCategory('<?php echo $enableCategory; ?>');
 function showCourseCategory(value) {
  if(value == 1)
    sesJqueryObject('#ecoupon_category_mandatory-wrapper').show();
  else
     sesJqueryObject('#ecoupon_category_mandatory-wrapper').hide();
  }
 showCourseDescription('<?php echo $enableDescription;?>');
 function showCourseDescription(value) {
  if(value == 1){
    sesJqueryObject('#ecoupon_wysiwyg_editor-wrapper').show();
    sesJqueryObject('#ecoupon_description_mandatory-wrapper').show();
  }else{
    sesJqueryObject('#ecoupon_description_mandatory-wrapper').hide();
    sesJqueryObject('#ecoupon_wysiwyg_editor-wrapper').hide();
  }
 }
  showCoursePhoto('<?php echo $enableMainPhoto; ?>');
 function showCoursePhoto(value) {
  if(value == 1)
    sesJqueryObject('#ecoupon_mainPhoto_mandatory-wrapper').show();
  else
    sesJqueryObject('#ecoupon_mainPhoto_mandatory-wrapper').hide();
 }
 </script>
