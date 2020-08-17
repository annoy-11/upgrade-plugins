<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: variation-create.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(empty($this->error_message)){ ?>
<div class="sesbsic_popup_form global_form_popup"><?php echo $this->form->render($this) ?></div>
<?php }else{ ?>
<div class="tip">
    <span><?php echo $this->message; ?></span>
</div>
<?php } ?>
<script type="application/javascript">
sesJqueryObject('.hide_elem').closest('.form-wrapper').hide();
sesJqueryObject('.hide_form_element').closest('.form-wrapper').find('.form-label').hide();
var isLoadedFirst = true;
function showFields(obj) {
  var elem =  sesJqueryObject(obj).children();
  elem.each(function () {
      var value = sesJqueryObject(this).attr('value');
      if(value) {
          sesJqueryObject('#dummy_'+value+'-wrapper').hide();
          sesJqueryObject('#option_id_'+value+'-wrapper').hide();
          if(isLoadedFirst == false)
          sesJqueryObject('#option_id_'+value).val('');
          sesJqueryObject('#option_price_'+value+'-wrapper').hide();
          if(isLoadedFirst == false)
          sesJqueryObject('#option_price_'+value).val('');
      }
  });
 var  elemvalue = sesJqueryObject(obj).val();
 if(elemvalue) {
     sesJqueryObject('#dummy_' + elemvalue + '-wrapper').show();
     sesJqueryObject('#option_id_' + elemvalue + '-wrapper').show();
     sesJqueryObject('#option_price_' + elemvalue + '-wrapper').show();
 }
}
sesJqueryObject(document).ready(function (e) {
    sesJqueryObject('select').trigger('change');
    isLoadedFirst = false;
});
</script>