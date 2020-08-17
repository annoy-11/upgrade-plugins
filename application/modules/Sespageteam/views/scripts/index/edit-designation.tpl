<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-designation.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">

  function addDesignation(formObject) {
  
    var validateDesignationForm = validateTeamform();
    
    if(validateDesignationForm) {
      
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
  
    sesJqueryObject('#sespageteam_team_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('designation_id', <?php echo $this->designation_id; ?>);
    formData.append('page_id', <?php echo $this->page_id; ?>);
    sesJqueryObject.ajax({
      url: "sespageteam/index/edit-designation/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sespageteam_team_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='teamsuccess_message' class='sespageteam_success_message teamsuccess_message'><i class='fa-check-circle-o'></i><span>Your team is successfully added.</span></div>");

          sesJqueryObject('#teamsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
//           if(sesJqueryObject('#team_count').length) {
//             sesJqueryObject('#team_count').html(result.count);
//           }
          if(sesJqueryObject('#sespage_dashboard_team_desinations').length) {
            if(sesJqueryObject('#team_tip').length)
              sesJqueryObject('#team_tip').hide();
            sesJqueryObject('#sespage_dashboard_team_desinations').show();
            sesJqueryObject('#sespage_dashboard_team_desinations').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sespage_dashboard_create_popup sespage_add_team_popup sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="sespageteam_team_overlay"></div>
  <?php if(empty($this->is_ajax)) { ?>
    <?php echo $this->form->render($this);?>
  <?php } ?>
</div>