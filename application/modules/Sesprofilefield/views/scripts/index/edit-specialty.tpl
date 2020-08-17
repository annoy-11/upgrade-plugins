<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-specialty.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>

  en4.core.runonce.add(function() {
    <?php if(empty($this->specialty->athletic)) { ?>
      sesJqueryObject('#athletic_specialties-wrapper').hide();
    <?php } ?>
    <?php if(empty($this->specialty->professional)) { ?>
      sesJqueryObject('#professional_specialties-wrapper').hide();
    <?php } ?>
  });

  sesJqueryObject(document).on('click','.professional_specialties',function(e) {
    var checkbox = sesJqueryObject('[name="professional_specialties[]"]:checked').length
    if (checkbox > 3) {
      this.checked = false;
      alert("You can select maximum 3.");
    }
  });
  
  sesJqueryObject(document).on('click','.athletic_specialties',function(e) {
    var checkbox = sesJqueryObject('[name="athletic_specialties[]"]:checked').length
    if (checkbox > 3) {
      this.checked = false;
      alert("You can select maximum 3.");
    }
  });
  
  function addSpecialty(formObject) {
  
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
  
  function athleticHideShow(value) {
    if(value == 1) {
      sesJqueryObject('#athletic_specialties-wrapper').show();
    } else {
      sesJqueryObject('#athletic_specialties-wrapper').hide();
    }
  }
  
  function professionalHideShow(value) {
    if(value == 1) {
      sesJqueryObject('#professional_specialties-wrapper').show();
    } else {
      sesJqueryObject('#professional_specialties-wrapper').hide();
    }
  }

  function submitCompliment(formObject) {
  
    var athleticValue = sesJqueryObject("input[name='athletic']:checked").val();
    var professionalValue = sesJqueryObject("input[name='athletic']:checked").val();
    
    if(athleticValue == 0 && professionalValue == 0) {
      alert("Please choose atleast one option.");
      return false;
    }
    
    sesJqueryObject('#sesprofilefield_specialty_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('specialty_id', <?php echo $this->specialty_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/edit-specialty/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        sesJqueryObject('#sesprofilefield_specialty_overlay').hide();
        sesJqueryObject('#sessmoothbox_container').html("<div id='specialtysuccess_message' class='sesprofilefield_success_message specialtysuccess_message'><i class='fa-check-circle-o'></i><span>Your specialty is successfully added.</span></div>");

        sesJqueryObject('#specialtysuccess_message').fadeOut("slow", function(){
          setTimeout(function() {
            sessmoothboxclose();
          }, 1000);
        });
      }
    });
  }

</script>
<div class="sesprofilefield_add_details_form edit_specialty_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_specialty_overlay"></div>
<?php if(empty($this->is_ajax)) { ?>
  <?php echo $this->form->render($this);?>
<?php } ?>
</div>