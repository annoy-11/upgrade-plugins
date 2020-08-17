<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-certification.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_certification', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_certification_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('certification_id', <?php echo $this->certification_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-certification/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_certification_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='certificationsuccess_message' class='sesprofilefield_success_message certificationsuccess_message'><i class='fa-check-circle-o'></i><<span>Your certification is successfully added.</span></div>");
        sesJqueryObject('#certificationsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_certification_<?php echo $this->certification_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#certification_count').length) {
          var countType = sesJqueryObject('#certification_count').html();
          sesJqueryObject('#certification_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_certification_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>