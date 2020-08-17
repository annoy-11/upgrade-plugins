<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: groupcreate.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.addgroupshortcut', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.category.selection', 0);?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.enable.description', 1);?>
<?php $enableEditorChoice = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.editor.media.type', 1);?>
<?php $enableGuidelines = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.guidelines', 1);?>
<style type='text/css'>
  #sesgroup_allow_join-wrapper, #sesgroup_allow_owner_join-wrapper, #sesgroup_show_approvaloption-wrapper, #sesgroup_joingroup_memtitle-wrapper{
	display:none !important;
  }
</style>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>');
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#sesgroup_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#sesgroup_icon_open_smoothbox-wrapper').hide();
 }
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#sesgroup_category_icon-wrapper').show();
    sesJqueryObject('#sesgroup_quick_create-wrapper').show();
  }
  else{
    sesJqueryObject('#sesgroup_category_icon-wrapper').hide();
    sesJqueryObject('#sesgroup_quick_create-wrapper').hide();
  }
 }
 showGroupDescription('<?php echo $enableDescription;?>');
 function showGroupDescription(value) {
  if(value == 1)
    sesJqueryObject('#sesgroup_description_required-wrapper').show();
  else
    sesJqueryObject('#sesgroup_description_required-wrapper').hide();
 }
 showDefaultEditor('<?php echo $enableEditorChoice;?>');
 function showDefaultEditor(value) {
  if(value == 1)
    sesJqueryObject('#sesgroup_default_editor-wrapper').hide();
  else
    sesJqueryObject('#sesgroup_default_editor-wrapper').show();
 } 
 showGuideEditor('<?php echo $enableGuidelines;?>');
 function showGuideEditor(value) {
  if(value == 1)
    sesJqueryObject('#sesgroup_message_guidelines-wrapper').show();
  else
    sesJqueryObject('#sesgroup_message_guidelines-wrapper').hide();
 }
 
 
 sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_invite_enable]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_invite_allow_owner-wrapper').show();
      sesJqueryObject('input[type=radio][name=sesgroup_invite_allow_owner]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesgroup_invite_allow_owner-wrapper').hide();
      sesJqueryObject('#sesgroup_invite_people_default-wrapper').hide();
    }
  });
  
   sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_invite_allow_owner]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_invite_people_default-wrapper').hide();
    }else{
      sesJqueryObject('#sesgroup_invite_people_default-wrapper').show();
    }
  });

  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_allow_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_allow_owner_join-wrapper').show();
      sesJqueryObject('#sesgroup_auto_join-wrapper').show();
      sesJqueryObject('input[type=radio][name=sesgroup_allow_owner_join]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesgroup_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sesgroup_auto_join-wrapper').hide();
      sesJqueryObject('#sesgroup_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').hide();
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesgroup_default_joinoption-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_plural-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_allow_owner_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_show_approvaloption-wrapper').show();
      sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').show();
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').show();
      sesJqueryObject('#sesgroup_default_joinoption-wrapper').hide();
      sesJqueryObject('input[type=radio][name=sesgroup_joingroup_memtitle]:checked').trigger('change');
      sesJqueryObject('input[type=radio][name=sesgroup_show_approvaloption]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesgroup_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').hide();
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesgroup_default_joinoption-wrapper').show();
      sesJqueryObject('#sesgroup_default_title_singular-wrapper').show();
      sesJqueryObject('#sesgroup_default_title_plural-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_show_approvaloption]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
    }else{
      sesJqueryObject('#sesgroup_default_approvaloption-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesgroup_joingroup_memtitle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').show();
      sesJqueryObject('#sesgroup_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_plural-wrapper').hide();
    }else{
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_singular-wrapper').show();
      sesJqueryObject('#sesgroup_default_title_plural-wrapper').show();
    }
  });
  window.addEvent('domready', function() {
    
    sesJqueryObject('input[type=radio][name=sesgroup_invite_enable]:checked').trigger('change');
    
    var valueStyle = sesJqueryObject('input[name=sesgroup_allow_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sesgroup_allow_owner_join-wrapper').show();
      sesJqueryObject('#sesgroup_auto_join-wrapper').show();
      var valueOwnerAllowStyle = sesJqueryObject('input[name=sesgroup_allow_owner_join]:checked').val();
      if(valueOwnerAllowStyle == 1) {
        sesJqueryObject('#sesgroup_show_approvaloption-wrapper').show();
        sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').show();
        sesJqueryObject('#sesgroup_default_joinoption-wrapper').hide();
        sesJqueryObject('#sesgroup_memtitle_required-wrapper').show();
        sesJqueryObject('input[type=radio][name=sesgroup_joingroup_memtitle]:checked').trigger('change');
        var valueStyle = sesJqueryObject('input[name=sesgroup_show_approvaloption]:checked').val();
        if(valueStyle == 1) {
          sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
        }
        else {
          sesJqueryObject('#sesgroup_default_approvaloption-wrapper').show();
        }
      }
      else {
        sesJqueryObject('#sesgroup_show_approvaloption-wrapper').hide();
        sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').hide();
        sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
        sesJqueryObject('#sesgroup_default_joinoption-wrapper').show();
        sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
        sesJqueryObject('input[type=radio][name=sesgroup_joingroup_memtitle]:checked').trigger('change');
      }
      var valueStyle = sesJqueryObject('input[name=sesgroup_joingroup_memtitle]:checked').val();
      if(valueOwnerAllowStyle == 1 && valueStyle == 1) {
        sesJqueryObject('#sesgroup_memtitle_required-wrapper').show();
        sesJqueryObject('#sesgroup_default_title_singular-wrapper').hide();
        sesJqueryObject('#sesgroup_default_title_plural-wrapper').hide();
      }
      else {
        sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
        sesJqueryObject('#sesgroup_default_title_singular-wrapper').show();
        sesJqueryObject('#sesgroup_default_title_plural-wrapper').show();
      }
    }
    else {
      sesJqueryObject('#sesgroup_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sesgroup_auto_join-wrapper').hide();
      sesJqueryObject('#sesgroup_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesgroup_joingroup_memtitle-wrapper').hide();
      sesJqueryObject('#sesgroup_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesgroup_default_joinoption-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesgroup_default_title_plural-wrapper').hide();
    }
 
  });
</script>

