<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: pagecreate.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.addpageshortcut', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.category.selection', 0);?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.enable.description', 1);?>
<?php $enableEditorChoice = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.editor.media.type', 1);?>
<?php $enableGuidelines = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.guidelines', 1);?>
<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>');
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#sespage_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#sespage_icon_open_smoothbox-wrapper').hide();
 }
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#sespage_category_icon-wrapper').show();
    sesJqueryObject('#sespage_quick_create-wrapper').show();
  }
  else{
    sesJqueryObject('#sespage_category_icon-wrapper').hide();
    sesJqueryObject('#sespage_quick_create-wrapper').hide();
  }
 }
 showPageDescription('<?php echo $enableDescription;?>');
 function showPageDescription(value) {
  if(value == 1)
    sesJqueryObject('#sespage_description_required-wrapper').show();
  else
    sesJqueryObject('#sespage_description_required-wrapper').hide();
 }
 showDefaultEditor('<?php echo $enableEditorChoice;?>');
 function showDefaultEditor(value) {
  if(value == 1)
    sesJqueryObject('#sespage_default_editor-wrapper').hide();
  else
    sesJqueryObject('#sespage_default_editor-wrapper').show();
 } 
 showGuideEditor('<?php echo $enableGuidelines;?>');
 function showGuideEditor(value) {
  if(value == 1)
    sesJqueryObject('#sespage_message_guidelines-wrapper').show();
  else
    sesJqueryObject('#sespage_message_guidelines-wrapper').hide();
 }
 
 
 sesJqueryObject(document).on('change','input[type=radio][name=sespage_invite_enable]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_invite_allow_owner-wrapper').show();
      sesJqueryObject('input[type=radio][name=sespage_invite_allow_owner]:checked').trigger('change');
    }else{
      sesJqueryObject('#sespage_invite_allow_owner-wrapper').hide();
      sesJqueryObject('#sespage_invite_people_default-wrapper').hide();
    }
  });
  
   sesJqueryObject(document).on('change','input[type=radio][name=sespage_invite_allow_owner]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_invite_people_default-wrapper').hide();
    }else{
      sesJqueryObject('#sespage_invite_people_default-wrapper').show();
    }
  });

  sesJqueryObject(document).on('change','input[type=radio][name=sespage_allow_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_allow_owner_join-wrapper').show();
      sesJqueryObject('#sespage_auto_join-wrapper').show();
      sesJqueryObject('input[type=radio][name=sespage_allow_owner_join]:checked').trigger('change');
    }else{
      sesJqueryObject('#sespage_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sespage_auto_join-wrapper').hide();
      sesJqueryObject('#sespage_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_joinpage_memtitle-wrapper').hide();
      sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
      sesJqueryObject('#sespage_default_joinoption-wrapper').hide();
      sesJqueryObject('#sespage_default_title_singular-wrapper').hide();
      sesJqueryObject('#sespage_default_title_plural-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_allow_owner_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_show_approvaloption-wrapper').show();
      sesJqueryObject('#sespage_joinpage_memtitle-wrapper').show();
      sesJqueryObject('#sespage_memtitle_required-wrapper').show();
      sesJqueryObject('#sespage_default_joinoption-wrapper').hide();
      sesJqueryObject('input[type=radio][name=sespage_joinpage_memtitle]:checked').trigger('change');
      sesJqueryObject('input[type=radio][name=sespage_show_approvaloption]:checked').trigger('change');
    }else{
      sesJqueryObject('#sespage_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_joinpage_memtitle-wrapper').hide();
      sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
      sesJqueryObject('#sespage_default_joinoption-wrapper').show();
      sesJqueryObject('#sespage_default_title_singular-wrapper').show();
      sesJqueryObject('#sespage_default_title_plural-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_show_approvaloption]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
    }else{
      sesJqueryObject('#sespage_default_approvaloption-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=sespage_joinpage_memtitle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#sespage_memtitle_required-wrapper').show();
      sesJqueryObject('#sespage_default_title_singular-wrapper').hide();
      sesJqueryObject('#sespage_default_title_plural-wrapper').hide();
    }else{
      sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
      sesJqueryObject('#sespage_default_title_singular-wrapper').show();
      sesJqueryObject('#sespage_default_title_plural-wrapper').show();
    }
  });
  window.addEvent('domready', function() {
    
    sesJqueryObject('input[type=radio][name=sespage_invite_enable]:checked').trigger('change');
    
    var valueStyle = sesJqueryObject('input[name=sespage_allow_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#sespage_allow_owner_join-wrapper').show();
      sesJqueryObject('#sespage_auto_join-wrapper').show();
      var valueOwnerAllowStyle = sesJqueryObject('input[name=sespage_allow_owner_join]:checked').val();
      if(valueOwnerAllowStyle == 1) {
        sesJqueryObject('#sespage_show_approvaloption-wrapper').show();
        sesJqueryObject('#sespage_joinpage_memtitle-wrapper').show();
        sesJqueryObject('#sespage_default_joinoption-wrapper').hide();
        sesJqueryObject('#sespage_memtitle_required-wrapper').show();
        sesJqueryObject('input[type=radio][name=sespage_joinpage_memtitle]:checked').trigger('change');
        var valueStyle = sesJqueryObject('input[name=sespage_show_approvaloption]:checked').val();
        if(valueStyle == 1) {
          sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
        }
        else {
          sesJqueryObject('#sespage_default_approvaloption-wrapper').show();
        }
      }
      else {
        sesJqueryObject('#sespage_show_approvaloption-wrapper').hide();
        sesJqueryObject('#sespage_joinpage_memtitle-wrapper').hide();
        sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
        sesJqueryObject('#sespage_default_joinoption-wrapper').show();
        sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
        sesJqueryObject('input[type=radio][name=sespage_joinpage_memtitle]:checked').trigger('change');
      }
      var valueStyle = sesJqueryObject('input[name=sespage_joinpage_memtitle]:checked').val();
      if(valueOwnerAllowStyle == 1 && valueStyle == 1) {
        sesJqueryObject('#sespage_memtitle_required-wrapper').show();
        sesJqueryObject('#sespage_default_title_singular-wrapper').hide();
        sesJqueryObject('#sespage_default_title_plural-wrapper').hide();
      }
      else {
        sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
        sesJqueryObject('#sespage_default_title_singular-wrapper').show();
        sesJqueryObject('#sespage_default_title_plural-wrapper').show();
      }
    }
    else {
      sesJqueryObject('#sespage_allow_owner_join-wrapper').hide();
      sesJqueryObject('#sespage_auto_join-wrapper').hide();
      sesJqueryObject('#sespage_show_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_default_approvaloption-wrapper').hide();
      sesJqueryObject('#sespage_joinpage_memtitle-wrapper').hide();
      sesJqueryObject('#sespage_memtitle_required-wrapper').hide();
      sesJqueryObject('#sespage_default_joinoption-wrapper').hide();
      sesJqueryObject('#sespage_default_title_singular-wrapper').hide();
      sesJqueryObject('#sespage_default_title_plural-wrapper').hide();
    }
 
  });
</script>

