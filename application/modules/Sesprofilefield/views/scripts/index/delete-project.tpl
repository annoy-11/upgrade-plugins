<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-project.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_project', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_project_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('project_id', <?php echo $this->project_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-project/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_project_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='projectsuccess_message' class='sesprofilefield_success_message projectsuccess_message'><i class='fa-check-circle-o'></i><span>Your project is successfully added.</span></div>");
        sesJqueryObject('#projectsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_project_<?php echo $this->project_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
          
        if(sesJqueryObject('#project_count').length) {
          var countType = sesJqueryObject('#project_count').html();
          sesJqueryObject('#project_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_project_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
	<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
