<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-education.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_profile_delete', function(e) {
    e.preventDefault();
    
    sesJqueryObject('#sesprofilefield_education_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('education_id', <?php echo $this->education_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-education/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_education_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='educationsuccess_message' class='sesprofilefield_success_message educationsuccess_message'><i class='fa-check-circle-o'></i><span>Your education is successfully added.</span></div>");
        
        sesJqueryObject('#educationsuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_education_<?php echo $this->education_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#education_count').length) {
          var countType = sesJqueryObject('#education_count').html();
          sesJqueryObject('#education_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_education_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
