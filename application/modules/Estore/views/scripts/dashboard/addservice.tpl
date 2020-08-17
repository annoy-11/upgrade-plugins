<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: addservice.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="application/javascript">
    
  function addService(formObject) {
  
    var validateServiceForm = validateServiceform();
    
    if(validateServiceForm) {
      
      var input = sesJqueryObject(formObject);
      alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
      if(typeof objectError != 'undefined') {
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
          sesJqueryObject('html, body').animate({
          scrollTop: errorFirstObject.offset().top
        }, 2000);
      }

      return false;
    } else {
      submitCompliment(formObject);
    }
  }

  function submitCompliment(formObject) {
  
    sesJqueryObject('#estoreservice_service_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('store_id', '<?php echo $this->store_id ?>');
    sesJqueryObject.ajax({
      url: "estore/dashboard/addservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#estoreservice_service_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='estoreservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully added.</span></div>");

          sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
//           if(sesJqueryObject('#service_count').length) {
//             sesJqueryObject('#service_count').html(result.count);
//           }
          if(sesJqueryObject('#estoreservice_services').length) {
            if(sesJqueryObject('#service_tip').length)
              sesJqueryObject('#service_tip').hide();
            sesJqueryObject('#estoreservice_services').show();
            sesJqueryObject('#estoreservice_services').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="estore_dashboard_create_popup estore_add_service_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="estoreservice_service_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
    <?php echo $this->form->render($this);?>
  <?php } ?>
</div>
