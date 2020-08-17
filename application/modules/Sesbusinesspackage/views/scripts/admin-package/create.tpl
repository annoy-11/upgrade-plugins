<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
<div class="sesbasic_search_result">
  <?php echo $this->htmlLink($this->url(array('module' => 'sesbusinesspackage', 'controller' => 'package','action'=>'index')), $this->translate("Back to Manage Packages"), array('class' => 'buttonlink sesbasic_icon_back')); ?>
</div><br />
<div class="sesbasic_admin_form settings">
  <?php echo $this->form->render($this) ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="application/javascript">
  function showRenewData(value){
    if(value == 1)
    document.getElementById('renew_link_days-wrapper').style.display = 'block';
    else
    document.getElementById('renew_link_days-wrapper').style.display = 'none';
  }
  function checkOneTime(value){
    if(value == 'forever'){
      document.getElementById('is_renew_link-wrapper').style.display = 'block';
      document.getElementById('renew_link_days-wrapper').style.display = 'block';
    }else{
      document.getElementById('is_renew_link-wrapper').style.display = 'none';
      document.getElementById('renew_link_days-wrapper').style.display = 'none';
    }
  }
  document.getElementById("recurrence-select").onclick = function(e){
    var value = this.value;
    checkOneTime(value);
    var value = document.getElementById('is_renew_link').value;
    showRenewData(value);
  };
  window.addEvent('domready',function(){
    var value = document.getElementById('recurrence-select').value;
    checkOneTime(value);
    var value = document.getElementById('is_renew_link').value;
    showRenewData(value);
  });
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/sesbusiness/settings/level/id/' + level_id;
    //alert(level_id);
  }
  sesJqueryObject(document).on('change','input[type=radio][name=business_choose_style]',function(){
    if (this.value == 1) {
      sesJqueryObject('#business_chooselayout-wrapper').show();
      sesJqueryObject('#business_style_type-wrapper').hide();
    }else{
      sesJqueryObject('#business_style_type-wrapper').show();
      sesJqueryObject('#business_chooselayout-wrapper').hide();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=can_add_jury]',function(){
    if (this.value == 1) {
      sesJqueryObject('#jury_member_count-wrapper').show();
    }else{
      sesJqueryObject('#jury_member_count-wrapper').hide();
    }
  });
  window.addEvent('domready', function() {
    if(sesJqueryObject('#can_add_jury')) {
      var valueStyle = sesJqueryObject('input[name=can_add_jury]:checked').val();
      if(valueStyle == 1) {
        sesJqueryObject('#jury_member_count-wrapper').show();
      }
      else {
        sesJqueryObject('#jury_member_count-wrapper').hide();
      }
    }
   var valueStyle = sesJqueryObject('input[name=business_choose_style]:checked').val();
    if(valueStyle == 1) {
      sesJqueryObject('#business_chooselayout-wrapper').show();
      sesJqueryObject('#business_style_type-wrapper').hide();
    }
    else {
      sesJqueryObject('#business_style_type-wrapper').show();
      sesJqueryObject('#business_chooselayout-wrapper').hide();
   }
  });
</script>