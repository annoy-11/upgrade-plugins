<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: addservice.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
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
  
    sesJqueryObject('#sespageservice_service_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('page_id', '<?php echo $this->page_id ?>');
    sesJqueryObject.ajax({
      url: "sespage/dashboard/addservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sespageservice_service_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='sespageservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully added.</span></div>");

          sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
//           if(sesJqueryObject('#service_count').length) {
//             sesJqueryObject('#service_count').html(result.count);
//           }
          if(sesJqueryObject('#sespageservice_services').length) {
            if(sesJqueryObject('#service_tip').length)
              sesJqueryObject('#service_tip').hide();
            sesJqueryObject('#sespageservice_services').show();
            sesJqueryObject('#sespageservice_services').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sespage_dashboard_create_popup sespage_add_service_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="sespageservice_service_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
    <?php echo $this->form->render($this);?>
  <?php } ?>
</div>