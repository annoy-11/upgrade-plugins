<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: businesscreate.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.addbusinesseshortcut', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.category.selection', 0);?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.description', 1);?>
<?php $enableEditorChoice = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.editor.media.type', 1);?>
<?php $enableGuidelines = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.guidelines', 1);?>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>');
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#sesbusiness_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#sesbusiness_icon_open_smoothbox-wrapper').hide();
 }
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#sesbusiness_category_icon-wrapper').show();
    sesJqueryObject('#sesbusiness_quick_create-wrapper').show();
  }
  else{
    sesJqueryObject('#sesbusiness_category_icon-wrapper').hide();
    sesJqueryObject('#sesbusiness_quick_create-wrapper').hide();
  }
 }
 showBusinessDescription('<?php echo $enableDescription;?>');
 function showBusinessDescription(value) {
  if(value == 1)
    sesJqueryObject('#sesbusiness_description_required-wrapper').show();
  else
    sesJqueryObject('#sesbusiness_description_required-wrapper').hide();
 }
 showDefaultEditor('<?php echo $enableEditorChoice;?>');
 function showDefaultEditor(value) {
  if(value == 1)
    sesJqueryObject('#sesbusiness_default_editor-wrapper').hide();
  else
    sesJqueryObject('#sesbusiness_default_editor-wrapper').show();
 } 
 showGuideEditor('<?php echo $enableGuidelines;?>');
 function showGuideEditor(value) {
  if(value == 1)
    sesJqueryObject('#sesbusiness_message_guidelines-wrapper').show();
  else
    sesJqueryObject('#sesbusiness_message_guidelines-wrapper').hide();
 }
 
 
 sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_invite_enable]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_invite_allow_owner-wrapper').show();
      sesJqueryObject('input[type=radio][name=sesbusiness_invite_allow_owner]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesbusiness_invite_allow_owner-wrapper').hide();
      sesJqueryObject('#sesbusiness_invite_people_default-wrapper').hide();
    }
  });
  
   sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_invite_allow_owner]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_invite_people_default-wrapper').hide();
    }else{
      sesJqueryObject('#sesbusiness_invite_people_default-wrapper').show();
    }
  });

  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_allow_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_allow_owner_join-wrapper').show();
      sesJqueryObject('#sesbusiness_auto_join-wrapper').show();
      sesJqueryObject('input[type=radio][name=sesbusiness_allow_owner_join]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesbusiness_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sesbusiness_auto_join-wrapper').hide();
      sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').hide();
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_joinoption-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_plural-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_allow_owner_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').show();
      sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').show();
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').show();
      sesJqueryObject('#sesbusiness_default_joinoption-wrapper').hide();
      sesJqueryObject('input[type=radio][name=sesbusiness_joinbusiness_memtitle]:checked').trigger('change');
      sesJqueryObject('input[type=radio][name=sesbusiness_show_approvaloption]:checked').trigger('change');
    }else{
      sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').hide();
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_joinoption-wrapper').show();
      sesJqueryObject('#sesbusiness_default_title_singular-wrapper').show();
      sesJqueryObject('#sesbusiness_default_title_plural-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_show_approvaloption]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
    }else{
      sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sesbusiness_joinbusiness_memtitle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').show();
      sesJqueryObject('#sesbusiness_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_plural-wrapper').hide();
    }else{
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_singular-wrapper').show();
      sesJqueryObject('#sesbusiness_default_title_plural-wrapper').show();
    }
  });
  window.addEvent('domready', function() {
    
    sesJqueryObject('input[type=radio][name=sesbusiness_invite_enable]:checked').trigger('change');
    
    var valueStyle = sesJqueryObject('input[name=sesbusiness_allow_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sesbusiness_allow_owner_join-wrapper').show();
      sesJqueryObject('#sesbusiness_auto_join-wrapper').show();
      var valueOwnerAllowStyle = sesJqueryObject('input[name=sesbusiness_allow_owner_join]:checked').val();
      if(valueOwnerAllowStyle == 1) {
        sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').show();
        sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').show();
        sesJqueryObject('#sesbusiness_default_joinoption-wrapper').hide();
        sesJqueryObject('#sesbusiness_memtitle_required-wrapper').show();
        sesJqueryObject('input[type=radio][name=sesbusiness_joinbusiness_memtitle]:checked').trigger('change');
        var valueStyle = sesJqueryObject('input[name=sesbusiness_show_approvaloption]:checked').val();
        if(valueStyle == 1) {
          sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
        }
        else {
          sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').show();
        }
      }
      else {
        sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').hide();
        sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').hide();
        sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
        sesJqueryObject('#sesbusiness_default_joinoption-wrapper').show();
        sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
        sesJqueryObject('input[type=radio][name=sesbusiness_joinbusiness_memtitle]:checked').trigger('change');
      }
      var valueStyle = sesJqueryObject('input[name=sesbusiness_joinbusiness_memtitle]:checked').val();
      if(valueOwnerAllowStyle == 1 && valueStyle == 1) {
        sesJqueryObject('#sesbusiness_memtitle_required-wrapper').show();
        sesJqueryObject('#sesbusiness_default_title_singular-wrapper').hide();
        sesJqueryObject('#sesbusiness_default_title_plural-wrapper').hide();
      }
      else {
        sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
        sesJqueryObject('#sesbusiness_default_title_singular-wrapper').show();
        sesJqueryObject('#sesbusiness_default_title_plural-wrapper').show();
      }
    }
    else {
      sesJqueryObject('#sesbusiness_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sesbusiness_auto_join-wrapper').hide();
      sesJqueryObject('#sesbusiness_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sesbusiness_joinbusiness_memtitle-wrapper').hide();
      sesJqueryObject('#sesbusiness_memtitle_required-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_joinoption-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_singular-wrapper').hide();
      sesJqueryObject('#sesbusiness_default_title_plural-wrapper').hide();
    }
 
  });
</script>

