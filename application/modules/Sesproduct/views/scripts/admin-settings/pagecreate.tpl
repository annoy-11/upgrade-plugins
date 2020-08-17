<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: pagecreate.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
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
<?php $descriptionOption = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.productdescription', 1);?>
<?php $isCategorySelection = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.category.selection', 0);?>
<?php $stockmanagement = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.stockmanagement', 1);?>
<?php $enableGuidelines = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.guidline', 1);?>
<script type="text/javascript">
 showDescriptionOption('<?php echo $descriptionOption;?>');
 function showDescriptionOption(value) {
  if(value == 1){
    sesJqueryObject('#sesproduct_enable_wysiwyg-wrapper').show();
    sesJqueryObject('#sesproduct_description_mandatory-wrapper').show();
  }
  else{
    sesJqueryObject('#sesproduct_enable_wysiwyg-wrapper').hide();
    sesJqueryObject('#sesproduct_description_mandatory-wrapper').hide();
    }
 }
 
 showCategoryIcon('<?php echo $isCategorySelection;?>');
 function showCategoryIcon(value) {
  if(value == 1) {
    sesJqueryObject('#sesproduct_category_icon-wrapper').show();
  }
  else{
    sesJqueryObject('#sesproduct_category_icon-wrapper').hide();
  }
 }
 
 showStockManagement('<?php echo $stockmanagement;?>');
 function showStockManagement(value) {
  if(value == 1){
    sesJqueryObject('#sesproduct_outofstock-wrapper').show();
    sesJqueryObject('#sesproduct_backinstock-wrapper').show();
    sesJqueryObject('#sesproduct_minquantity-wrapper').show();
    sesJqueryObject('#sesproduct_maxquantity-wrapper').show();
    }
  else{
     sesJqueryObject('#sesproduct_outofstock-wrapper').hide();
    sesJqueryObject('#sesproduct_backinstock-wrapper').hide();
    sesJqueryObject('#sesproduct_minquantity-wrapper').hide();
    sesJqueryObject('#sesproduct_maxquantity-wrapper').hide();
    }
 }
 
 showGuideEditor('<?php echo $enableGuidelines;?>');
 function showGuideEditor(value) {
  if(value == 1)
    sesJqueryObject('#sesproduct_message_guidelines-wrapper').show();
  else
    sesJqueryObject('#sesproduct_message_guidelines-wrapper').hide();
 }
 
  
</script>

