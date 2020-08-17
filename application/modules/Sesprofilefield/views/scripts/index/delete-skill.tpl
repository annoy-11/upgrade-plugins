<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-skill.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_skill', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_skill_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('skill_id', <?php echo $this->skill_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-skill/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_skill_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='skillsuccess_message' class='sesprofilefield_success_message skillsuccess_message'><i class='fa-check-circle-o'></i><<span>Your skill is successfully added.</span></div>");
        sesJqueryObject('#skillsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_skill_<?php echo $this->skill_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#skill_count').length) {
          var countType = sesJqueryObject('#skill_count').html();
          sesJqueryObject('#skill_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_skill_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
