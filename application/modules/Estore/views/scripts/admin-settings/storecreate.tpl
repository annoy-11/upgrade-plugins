<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: storecreate.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $isPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.addstoreshortcut', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.category.selection', 0);?>
<?php $enableDescription = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.description', 1);?>
<?php $enableEditorChoice = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.editor.media.type', 1);?>
<?php $enableGuidelines = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.guidelines', 1);?>

<script type="text/javascript">
 showQuickOption('<?php echo $isPopup;?>');
 function showQuickOption(value) {
  if(value == 1)
    sesJqueryObject('#estore_icon_open_smoothbox-wrapper').show();
  else
    sesJqueryObject('#estore_icon_open_smoothbox-wrapper').hide();
 }
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#estore_category_icon-wrapper').show();
    sesJqueryObject('#estore_quick_create-wrapper').show();
  }
  else{
    sesJqueryObject('#estore_category_icon-wrapper').hide();
    sesJqueryObject('#estore_quick_create-wrapper').hide();
  }
 }
 showStoreDescription('<?php echo $enableDescription;?>');
 function showStoreDescription(value) {
  if(value == 1)
    sesJqueryObject('#estore_description_required-wrapper').show();
  else
    sesJqueryObject('#estore_description_required-wrapper').hide();
 }
 showDefaultEditor('<?php echo $enableEditorChoice;?>');
 function showDefaultEditor(value) {
  if(value == 1)
    sesJqueryObject('#estore_default_editor-wrapper').hide();
  else
    sesJqueryObject('#estore_default_editor-wrapper').show();
 } 
 showGuideEditor('<?php echo $enableGuidelines;?>');
 function showGuideEditor(value) {
  if(value == 1)
    sesJqueryObject('#estore_message_guidelines-wrapper').show();
  else
    sesJqueryObject('#estore_message_guidelines-wrapper').hide();
 }
 
 
 sesJqueryObject(document).on('change','input[type=radio][name=estore_invite_enable]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_invite_allow_owner-wrapper').show();
      sesJqueryObject('input[type=radio][name=estore_invite_allow_owner]:checked').trigger('change');
    }else{
      sesJqueryObject('#estore_invite_allow_owner-wrapper').hide();
      sesJqueryObject('#estore_invite_people_default-wrapper').hide();
    }
  });
  
   sesJqueryObject(document).on('change','input[type=radio][name=estore_invite_allow_owner]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_invite_people_default-wrapper').hide();
    }else{
      sesJqueryObject('#estore_invite_people_default-wrapper').show();
    }
  });

  sesJqueryObject(document).on('change','input[type=radio][name=estore_allow_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_allow_owner_join-wrapper').show();
      sesJqueryObject('#estore_auto_join-wrapper').show();
      sesJqueryObject('input[type=radio][name=estore_allow_owner_join]:checked').trigger('change');
    }else{
      sesJqueryObject('#estore_allow_owner_join-wrapper').hide();
      sesJqueryObject('#estore_auto_join-wrapper').hide();
      sesJqueryObject('#estore_show_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_joinstore_memtitle-wrapper').hide();
      sesJqueryObject('#estore_memtitle_required-wrapper').hide();
      sesJqueryObject('#estore_default_joinoption-wrapper').hide();
      sesJqueryObject('#estore_default_title_singular-wrapper').hide();
      sesJqueryObject('#estore_default_title_plural-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=estore_allow_owner_join]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_show_approvaloption-wrapper').show();
      sesJqueryObject('#estore_joinstore_memtitle-wrapper').show();
      sesJqueryObject('#estore_memtitle_required-wrapper').show();
      sesJqueryObject('#estore_default_joinoption-wrapper').hide();
      sesJqueryObject('input[type=radio][name=estore_joinstore_memtitle]:checked').trigger('change');
      sesJqueryObject('input[type=radio][name=estore_show_approvaloption]:checked').trigger('change');
    }else{
      sesJqueryObject('#estore_show_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_joinstore_memtitle-wrapper').hide();
      sesJqueryObject('#estore_memtitle_required-wrapper').hide();
      sesJqueryObject('#estore_default_joinoption-wrapper').show();
      sesJqueryObject('#estore_default_title_singular-wrapper').show();
      sesJqueryObject('#estore_default_title_plural-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=estore_show_approvaloption]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
    }else{
      sesJqueryObject('#estore_default_approvaloption-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=estore_joinstore_memtitle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#estore_memtitle_required-wrapper').show();
      sesJqueryObject('#estore_default_title_singular-wrapper').hide();
      sesJqueryObject('#estore_default_title_plural-wrapper').hide();
    }else{
      sesJqueryObject('#estore_memtitle_required-wrapper').hide();
      sesJqueryObject('#estore_default_title_singular-wrapper').show();
      sesJqueryObject('#estore_default_title_plural-wrapper').show();
    }
  });
  window.addEvent('domready', function() {
    
    sesJqueryObject('input[type=radio][name=estore_invite_enable]:checked').trigger('change');
    
    var valueStyle = sesJqueryObject('input[name=estore_allow_join]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#estore_allow_owner_join-wrapper').show();
      sesJqueryObject('#estore_auto_join-wrapper').show();
      var valueOwnerAllowStyle = sesJqueryObject('input[name=estore_allow_owner_join]:checked').val();
      if(valueOwnerAllowStyle == 1) {
        sesJqueryObject('#estore_show_approvaloption-wrapper').show();
        sesJqueryObject('#estore_joinstore_memtitle-wrapper').show();
        sesJqueryObject('#estore_default_joinoption-wrapper').hide();
        sesJqueryObject('#estore_memtitle_required-wrapper').show();
        sesJqueryObject('input[type=radio][name=estore_joinstore_memtitle]:checked').trigger('change');
        var valueStyle = sesJqueryObject('input[name=estore_show_approvaloption]:checked').val();
        if(valueStyle == 1) {
          sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
        }
        else {
          sesJqueryObject('#estore_default_approvaloption-wrapper').show();
        }
      }
      else {
        sesJqueryObject('#estore_show_approvaloption-wrapper').hide();
        sesJqueryObject('#estore_joinstore_memtitle-wrapper').hide();
        sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
        sesJqueryObject('#estore_default_joinoption-wrapper').show();
        sesJqueryObject('#estore_memtitle_required-wrapper').hide();
        sesJqueryObject('input[type=radio][name=estore_joinstore_memtitle]:checked').trigger('change');
      }
      var valueStyle = sesJqueryObject('input[name=estore_joinstore_memtitle]:checked').val();
      if(valueOwnerAllowStyle == 1 && valueStyle == 1) {
        sesJqueryObject('#estore_memtitle_required-wrapper').show();
        sesJqueryObject('#estore_default_title_singular-wrapper').hide();
        sesJqueryObject('#estore_default_title_plural-wrapper').hide();
      }
      else {
        sesJqueryObject('#estore_memtitle_required-wrapper').hide();
        sesJqueryObject('#estore_default_title_singular-wrapper').show();
        sesJqueryObject('#estore_default_title_plural-wrapper').show();
      }
    }
    else {
      sesJqueryObject('#estore_allow_owner_join-wrapper').hide();
      sesJqueryObject('#estore_auto_join-wrapper').hide();
      sesJqueryObject('#estore_show_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_default_approvaloption-wrapper').hide();
      sesJqueryObject('#estore_joinstore_memtitle-wrapper').hide();
      sesJqueryObject('#estore_memtitle_required-wrapper').hide();
      sesJqueryObject('#estore_default_joinoption-wrapper').hide();
      sesJqueryObject('#estore_default_title_singular-wrapper').hide();
      sesJqueryObject('#estore_default_title_plural-wrapper').hide();
    }
 
  });
</script>

