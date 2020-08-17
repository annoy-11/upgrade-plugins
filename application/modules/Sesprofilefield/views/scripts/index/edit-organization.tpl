<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-organization.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>

  en4.core.runonce.add(function() {
    <?php if($this->organization->currentlywork) { ?>
      if($('fieldset-toyearmonth'))
        $('fieldset-toyearmonth').style.display = 'none';
    <?php } else { ?>
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'none';
    <?php } ?>
  });
  
  function hideToDateExp() {
    if(document.getElementById("currentlywork").checked == true) {
      $('fieldset-toyearmonth').style.display = 'none';
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'block';
    } else {
      $('fieldset-toyearmonth').style.display = 'block';
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'none';
    }
  }

  function addOrganization(formObject) {
  
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
      submitCompliment(formObject);
    }
  }

  function submitCompliment(formObject) {
  
    sesJqueryObject('#sesprofilefield_organization_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('organization_id', <?php echo $this->organization_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/edit-organization/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sesprofilefield_organization_overlay').hide();
          
          sesJqueryObject('#sessmoothbox_container').html("<div id='organizationsuccess_message' class='sesprofilefield_success_message organizationsuccess_message'><i class='fa-check-circle-o'></i><span>Your organization is successfully added.</span></div>");

          sesJqueryObject('#organizationsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });

          if(sesJqueryObject('#organization_count').length) {
            sesJqueryObject('#organization_count').html(result.count);
          }
          if(sesJqueryObject('#sesprofilefield_organizations').length) {
            if(sesJqueryObject('#organization_tip').length)
              sesJqueryObject('#organization_tip').hide();
            sesJqueryObject('#sesprofilefield_organizations').show();
            sesJqueryObject('#sesprofilefield_organizations').html(result.message);
          }
        }
      }
    });
  }
</script>
<div class="sesprofilefield_add_details_form edit_organization_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_organization_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>
<?php } ?>
</div>
