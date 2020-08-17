<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: deleteservice.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script>
  sesJqueryObject(document).on('submit', '#estoreservice_delete', function(e) {
    e.preventDefault();
    sesJqueryObject('#estoreservice_service_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('store_id', <?php echo $this->store_id; ?>);
    formData.append('service_id', <?php echo $this->service_id; ?>);
    sesJqueryObject.ajax({
      url: "estore/dashboard/deleteservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#estoreservice_service_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='estoreservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully deleted entry.</span></div>");
        
        sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#estoreservice_service_<?php echo $this->service_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
      }
    });
  });
</script>
<div class="estoreservice_delete_popup">
  <div class="sesbasic_loading_cont_overlay" id="estoreservice_service_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
  <?php } ?>
</div>
