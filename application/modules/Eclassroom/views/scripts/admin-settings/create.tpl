<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
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
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.addstoreshortcut', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.category.selection', 0);?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.description', 1);?>
<?php $enableCategory = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.category', 1);?>
<?php $enableInvite = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.invite.enable', 1);?>
<?php $enableOwnerInvite = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.invite.enable', 1);?>
<?php $enableOwnerJoin = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.join', 1);?>
<?php $enableApprovalOption = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.show.approvaloption', 1);?>
<?php $enableMemTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.joinclass.memtitle', 1); ?>
<?php $enableMainPhoto = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.mainphoto', 1); ?>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>'); 
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#eclassroom_icon_open_smoothbox-wrapper').hide();
 } 
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#eclassroom_category_icon-wrapper').show();
    sesJqueryObject('#eclassroom_quick_create-wrapper').show();
  }
  else{
    sesJqueryObject('#eclassroom_category_icon-wrapper').hide();
    sesJqueryObject('#eclassroom_quick_create-wrapper').hide();
  }
 }
 showClassroomInvite('<?php echo $enableInvite;?>');
 function showClassroomInvite(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_invite_allow_owner-wrapper').show();
  else
    sesJqueryObject('#eclassroom_invite_allow_owner-wrapper').hide();
  
 }
  showClassroomOwnerInvite('<?php echo $enableOwnerInvite;?>');
 function showClassroomOwnerInvite(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_invite_people_default-wrapper').show();
  else
    sesJqueryObject('#eclassroom_invite_people_default-wrapper').hide();
  
 }
  showClassroomOwnerJoin('<?php echo $enableOwnerJoin;?>');
  function showClassroomOwnerJoin(value) {
    if(value == 1) {
      sesJqueryObject('#eclassroom_allow_owner_join-wrapper').show();
      sesJqueryObject('#eclassroom_auto_join-wrapper').show();
    } else {
      sesJqueryObject('#eclassroom_allow_owner_join-wrapper').hide();
      sesJqueryObject('#eclassroom_auto_join-wrapper').hide();
    }
  }
 showClassroomApprovalOptions('<?php echo $enableApprovalOption; ?>');
 function showClassroomApprovalOptions(value) {
  if(value == 1) {
    sesJqueryObject('#eclassroom_default_joinoption-wrapper').hide();
    sesJqueryObject('#eclassroom_joinclass_memtitle-wrapper').show();
  } else {
    sesJqueryObject('#eclassroom_default_joinoption-wrapper').show();
    sesJqueryObject('#eclassroom_joinclass_memtitle-wrapper').hide();
  }
 } 
 showClassroomMemTitle('<?php echo $enableMemTitle; ?>');
 function showClassroomMemTitle(value) {
  if(value == 1) {
     sesJqueryObject('#eclassroom_default_title_singular-wrapper').hide();
    sesJqueryObject('#eclassroom_default_title_plural-wrapper').hide();
    sesJqueryObject('#eclassroom_memtitle_required-wrapper').show();
  } else {
    sesJqueryObject('#eclassroom_default_title_singular-wrapper').show();
    sesJqueryObject('#eclassroom_default_title_plural-wrapper').show();
    sesJqueryObject('#eclassroom_memtitle_required-wrapper').hide();
  }
 } 
 showClassroomCategory('<?php echo $enableCategory; ?>');
 function showClassroomCategory(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_category_mandatory-wrapper').show();
  else
     sesJqueryObject('#eclassroom_category_mandatory-wrapper').hide();
  }
 showClassroomDescription('<?php echo $enableDescription;?>');
 function showClassroomDescription(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_description_required-wrapper').show();
  else
    sesJqueryObject('#eclassroom_description_required-wrapper').hide();
 }
  showClassroomPhoto('<?php echo $enableMainPhoto; ?>');
 function showClassroomPhoto(value) {
  if(value == 1)
    sesJqueryObject('#eclassroom_classmainphoto-wrapper').show();
  else
    sesJqueryObject('#eclassroom_classmainphoto-wrapper').hide();
 }
 </script>
