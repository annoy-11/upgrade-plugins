<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: deleteservice.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script>
  sesJqueryObject(document).on('submit', '#sesgroupservice_delete', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesgroupservice_service_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('group_id', <?php echo $this->group_id; ?>);
    formData.append('service_id', <?php echo $this->service_id; ?>);
    sesJqueryObject.ajax({
      url: "sesgroup/dashboard/deleteservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesgroupservice_service_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='sesgroupservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully deleted entry.</span></div>");
        
        sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#sesgroupservice_service_<?php echo $this->service_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
      }
    });
  });
</script>
<div class="sesgroupservice_delete_popup">
  <div class="sesbasic_loading_cont_overlay" id="sesgroupservice_service_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
  <?php } ?>
</div>