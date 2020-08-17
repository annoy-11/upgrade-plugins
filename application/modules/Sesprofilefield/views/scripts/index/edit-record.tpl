<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-record.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  
  function addRecord(formObject) {
  
    var validationFm = validateForm();
    if(validationFm) {
      
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
  
    sesJqueryObject('#sesprofilefield_record_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    //formData.append('record_id', <?php echo $this->record_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/edit-record/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
              
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          
          sesJqueryObject('#sesprofilefield_record_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='recordsuccess_message' class='sesprofilefield_success_message recordsuccess_message'><i class='fa-check-circle-o'></i><span>Your record is successfully added.</span></div>");

          sesJqueryObject('#recordsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
            
          if(sesJqueryObject('#record_count').length) {
            sesJqueryObject('#record_count').html(result.count);
          }
          
          if(sesJqueryObject('#sesprofilefield_records').length) {
            sesJqueryObject('#sesprofilefield_records').show();
            sesJqueryObject('#sesprofilefield_records').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sesprofilefield_add_details_form sesprofilefield_edit_record_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_record_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->render($this);?>
<?php } ?>
</div>