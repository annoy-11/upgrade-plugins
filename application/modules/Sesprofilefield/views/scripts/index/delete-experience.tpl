<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-experience.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_experience', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_experience_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('experience_id', <?php echo $this->experience_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-experience/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_experience_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='experiencesuccess_message' class='sesprofilefield_success_message experiencesuccess_message'><i class='fa-check-circle-o'></i><span>Your experience is successfully added.</span></div>");
        sesJqueryObject('#experiencesuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_experience_<?php echo $this->experience_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
          
        if(sesJqueryObject('#experience_count').length) {
          var countType = sesJqueryObject('#experience_count').html();
          sesJqueryObject('#experience_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_experience_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
	<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>