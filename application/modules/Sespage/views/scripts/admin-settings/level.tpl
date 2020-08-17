<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: level.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>

<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/sespage/settings/level/id/' + level_id;
  }
  sesJqueryObject(document).on('change','input[type=radio][name=enable_price]',function(){
    if (this.value == 1) {
      sesJqueryObject('#can_chooseprice-wrapper').show();
      sesJqueryObject('#price_mandatory-wrapper').show();
    }else{
      sesJqueryObject('#can_chooseprice-wrapper').hide();
      sesJqueryObject('#price_mandatory-wrapper').hide();
      sesJqueryObject('#default_prztype-wrapper').hide();
    }
    sesJqueryObject('input[type=radio][name=can_chooseprice]:checked').trigger('change');
  });
  sesJqueryObject(document).on('change','input[type=radio][name=can_chooseprice]',function(){
    if (this.value == 1) {
      sesJqueryObject('#default_prztype-wrapper').hide();
    }else{
      sesJqueryObject('#default_prztype-wrapper').show();
    }
  });
  sesJqueryObject(document).on('change','input[type=radio][name=auth_pagestyle]',function(){
    if (this.value == 1) {
      sesJqueryObject('#select_pagestyle-wrapper').show();
      sesJqueryObject('#page_style_type-wrapper').hide();
    }else{
      sesJqueryObject('#page_style_type-wrapper').show();
      sesJqueryObject('#select_pagestyle-wrapper').hide();
    }
  });
  sesJqueryObject('input[type=radio][name=page_attribution]').change(function() {
   if(this.value == 1){
      sesJqueryObject('#auth_defattribut-wrapper').show();
      sesJqueryObject('#auth_contSwitch-wrapper').show();
      sesJqueryObject('#defattribut-wrapper').hide(); 
   }else{
     sesJqueryObject('#auth_defattribut-wrapper').hide(); 
      sesJqueryObject('#auth_contSwitch-wrapper').hide();
     sesJqueryObject('#defattribut-wrapper').show(); 
   }
   sesJqueryObject('input[type=radio][name=auth_defattribut]:checked').trigger('change');
 });
 sesJqueryObject('input[type=radio][name=auth_defattribut]').change(function() {
   if(this.value == 0){
     sesJqueryObject('#defattribut-wrapper').show();
   }else{
      sesJqueryObject('#defattribut-wrapper').hide();
   }
 });
 sesJqueryObject(document).ready(function(){
  sesJqueryObject('input[type=radio][name=enable_price]:checked').trigger('change');
  sesJqueryObject('input[type=radio][name=auth_pagestyle]:checked').trigger('change');
  sesJqueryObject('input[type=radio][name=page_attribution]:checked').trigger('change');
  sesJqueryObject('input[type=radio][name=auth_defattribut]:checked').trigger('change');  
    var x = document.getElementsByClassName("page_package");
    var i;
    for (i = 0; i < x.length; i++) {
      var elementId = x[i].id.split("-");
      sesJqueryObject('#'+elementId[0]+'-wrapper').hide();
    } 
 })
</script>
<style>
#defattribut-wrapper{
  display:none !important;
}
</style>