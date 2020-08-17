<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-organization.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_organization', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_organization_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('organization_id', <?php echo $this->organization_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-organization/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_organization_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='organizationsuccess_message' class='sesprofilefield_success_message organizationsuccess_message'><i class='fa-check-circle-o'></i><span>Your organization is successfully added.</span></div>");
        sesJqueryObject('#organizationsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_organization_<?php echo $this->organization_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
          
        if(sesJqueryObject('#organization_count').length) {
          var countType = sesJqueryObject('#organization_count').html();
          sesJqueryObject('#organization_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_organization_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
	<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
