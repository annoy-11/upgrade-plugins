<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesinterest_delete', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesinterest_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('userinterest_id', <?php echo $this->userinterest_id; ?>);
    sesJqueryObject.ajax({
      url: "sesinterest/index/delete/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesinterest_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='interestsuccess_message' class='sesinterest_success_message interestsuccess_message'><i class='fa-check-circle-o'></i><<span>Your interest is successfully deleted.</span></div>");
        sesJqueryObject('#interestsuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesinterest_<?php echo $this->userinterest_id ?>').remove();
            sessmoothboxclose();
          }, 1000);
        });
        if(sesJqueryObject('#language_count').length) {
          var countType = sesJqueryObject('#language_count').html();
          sesJqueryObject('#language_count').html(--countType);
        }
      }
    });
  });
</script>
<div class="sesinterest_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesinterest_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
