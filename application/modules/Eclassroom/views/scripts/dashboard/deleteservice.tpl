<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: deleteservice.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<script>
  sesJqueryObject(document).on('submit', '#classroomservice_delete', function(e) {
    e.preventDefault();
    sesJqueryObject('#classroomservice_service_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('classroom_id', <?php echo $this->classroom_id; ?>);
    formData.append('service_id', <?php echo $this->service_id; ?>);
    sesJqueryObject.ajax({
      url: "eclassroom/dashboard/deleteservice/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#classroomservice_service_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='servicesuccess_message' class='classroomservice_success_message servicesuccess_message'><i class='fa-check-circle-o'></i><span>Your service is successfully deleted entry.</span></div>");
        sesJqueryObject('#servicesuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#classroomservice_service_<?php echo $this->service_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
      }
    });
  });
</script>
<div class="classroomservice_delete_popup">
  <div class="sesbasic_loading_cont_overlay" id="classroomservice_service_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
  <?php }die; ?>
</div>
