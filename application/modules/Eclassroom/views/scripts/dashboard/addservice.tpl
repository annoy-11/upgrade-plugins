<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: addservice.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
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
    sesJqueryObject('#classroomservice_service_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('classroom_id', '<?php echo $this->classroom_id ?>');
    sesJqueryObject.ajax({
      url: "eclassroom/dashboard/addservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#classroomservice_service_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='classroomservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully added.</span></div>");

          sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          if(sesJqueryObject('#classroomservice_services').length) {
            if(sesJqueryObject('#service_tip').length)
              sesJqueryObject('#service_tip').hide();
            sesJqueryObject('#classroomservice_services').show();
            sesJqueryObject('#classroomservice_services').html(result.message);
          }
        }
      }
    });
  }
</script>
<div class="classroom_dashboard_create_popup classroom_add_service_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="classroomservice_service_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
    <?php echo $this->form->render($this);?>
  <?php } ?>
</div>
