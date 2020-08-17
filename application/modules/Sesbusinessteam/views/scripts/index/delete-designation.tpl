<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-designation.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesbusinessteam_deletedesignation', function(e) {
    e.preventDefault();
    
    sesJqueryObject('#sesbusinessteam_team_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('designation_id', '<?php echo $this->designation_id; ?>');
    sesJqueryObject.ajax({
      url: "sesbusinessteam/index/delete-designation/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesbusinessteam_team_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='teamsuccess_message' class='sesbusinessteam_success_message teamsuccess_message'><i class='fa-check-circle-o'></i><span>You have successfully deleted entry.</span></div>");
        
        sesJqueryObject('#teamsuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#sesbusinessteam_designation_<?php echo $this->designation_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
      }
    });
  });
</script>
<div class="sesbusinessteam_delete_popup">
  <div class="sesbasic_loading_cont_overlay" id="sesbusinessteam_team_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
  <?php } ?>
</div>
