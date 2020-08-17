<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-language.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  sesJqueryObject(document).on('submit', '#sesprofilefield_delete_language', function(e) {
    e.preventDefault();
    sesJqueryObject('#sesprofilefield_language_overlay').show();
    var formData = new FormData(this);
    formData.append('is_ajax', 1);
    formData.append('language_id', <?php echo $this->language_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/delete-language/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_language_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='languagesuccess_message' class='sesprofilefield_success_message languagesuccess_message'><i class='fa-check-circle-o'></i><<span>Your language is successfully added.</span></div>");
        sesJqueryObject('#languagesuccess_message').fadeOut("slow", function() {
          setTimeout(function() {
            sesJqueryObject('#sesprofilefield_language_<?php echo $this->language_id ?>').remove();
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
<div class="sesprofilefield_delete_popup">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_language_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>
<?php } ?>
</div>
