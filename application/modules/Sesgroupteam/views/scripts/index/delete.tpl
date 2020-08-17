<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesgroupteam_delete', function(e) {
    e.preventDefault();
    
    sesJqueryObject('#sesgroupteam_team_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('team_id', <?php echo $this->team_id; ?>);
    sesJqueryObject.ajax({
      url: "sesgroupteam/index/delete/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesgroupteam_team_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='teamsuccess_message' class='sesgroupteam_success_message teamsuccess_message'><i class='fa-check-circle-o'></i><span>Your team is successfully deleted entry.</span></div>");
        
        sesJqueryObject('#teamsuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sesJqueryObject('#sesgroupteam_team_<?php echo $this->team_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
//         if(sesJqueryObject('#team_count').length) {
//           var countType = sesJqueryObject('#team_count').html();
//           sesJqueryObject('#team_count').html(--countType);
//         }
      }
    });
  });
</script>
<div class="sesgroupteam_delete_popup">
  <div class="sesbasic_loading_cont_overlay" id="sesgroupteam_team_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
  <?php } ?>
</div>
