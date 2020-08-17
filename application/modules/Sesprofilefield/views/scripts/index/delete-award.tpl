<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-award.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_award', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_award_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('award_id', <?php echo $this->award_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-award/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_award_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='awardsuccess_message' class='sesprofilefield_success_message awardsuccess_message'><i class='fa-check-circle-o'></i><span>Your award is successfully added.</span></div>");
        sesJqueryObject('#awardsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_award_<?php echo $this->award_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#award_count').length) {
          var countType = sesJqueryObject('#award_count').html();
          sesJqueryObject('#award_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_award_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
	<?php echo $this->form->render($this) ?>
<?php } ?>
</div>