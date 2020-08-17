<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-language.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  
  function addLanguage(formObject) {
  
    var validationFm = validateForm();

    if(validationFm) {
      
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
      submitLanguage(formObject);
    }
  }

  function submitLanguage(formObject) {

    sesJqueryObject('#sesprofilefield_language_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('language_id', <?php echo $this->language_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/edit-language/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#sesprofilefield_language_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='languagesuccess_message' class='sesprofilefield_success_message languagesuccess_message'><i class='fa-check-circle-o'></i><span>Your language is successfully added.</span></div>");

          sesJqueryObject('#languagesuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          
          if(sesJqueryObject('#language_count').length) {
            sesJqueryObject('#language_count').html(result.count);
          }
          
          if(sesJqueryObject('#sesprofilefield_languages').length) {
            if(sesJqueryObject('#language_tip').length)
              sesJqueryObject('#language_tip').hide();
            sesJqueryObject('#sesprofilefield_languages').show();
            sesJqueryObject('#sesprofilefield_languages').html(result.message);
          }
        }
      }
    });
  }
</script>
<div class="sesprofilefield_add_details_form edit_language_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_language_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>
<?php } ?>
</div>
