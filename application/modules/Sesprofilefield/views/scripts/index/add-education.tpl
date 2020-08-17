<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-education.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  en4.core.runonce.add(function() {
    if($('upload_2-wrapper'))
      $('upload_2-wrapper').style.display = 'none';
    if($('upload_3-wrapper'))
      $('upload_3-wrapper').style.display = 'none';
  });
  
  function addmoreEducation() {
    
    var dataRel = parseInt(sesJqueryObject('#addmoreEducation').attr('data-rel'));
    if(dataRel < 4) {
      sesJqueryObject('#upload_'+dataRel+'-wrapper').show();
      sesJqueryObject('#addmoreEducation').attr('data-rel', ++dataRel);
      if(dataRel == 4) {
        sesJqueryObject('#addmoreEducation').hide();
      }
    }
  }
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.school',1)) { ?>
    en4.core.runonce.add(function() {
      if (document.getElementById('school')) {
        new google.maps.places.Autocomplete(document.getElementById('school'));
      }
    });
  <?php } else { ?>
    sesJqueryObject(document).on('click','#school',function(e) {
      profileOptionAutoComplete('school', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'school'),'default',true); ?>");
    });
  <?php } ?>
  
  sesJqueryObject(document).on('click','#degree',function(e) {
    profileOptionAutoComplete('degree', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'degree'),'default',true); ?>");
  });
  
  sesJqueryObject(document).on('click','#field_of_study',function(e) {
    profileOptionAutoComplete('field_of_study', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'field_of_study'),'default',true); ?>");
  });
  
  function checkEndDate(value) {
    var startYear = sesJqueryObject('#fromyear').val();
    if(value < startYear) {
      if($('education_error'))
        sesJqueryObject('#education_error').remove();
        sesJqueryObject('#toyear-wrapper').after("<div id='education_error' class='education_error'><span style='color:red;padding:0px 10px;line-height:1.6rem;'>Your end year can\'t be earlier than your start year.</span></div>");
    } else {
      if($('education_error'))
        sesJqueryObject('#education_error').remove();
    } 
  }

  function addEducation(formObject) {
  
    var validationFm = validateForm();
    
    var startYear = sesJqueryObject('#fromyear').val();
    var endYear = sesJqueryObject('#toyear').val();
    if(startYear && endYear < startYear) { 
      return false;
    }
    
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
  
    sesJqueryObject('#sesprofilefield_education_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/add-education/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
      
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
        
          sesJqueryObject('#sesprofilefield_education_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='educationsuccess_message' class='sesprofilefield_success_message educationsuccess_message'><i class='fa-check-circle-o'></i><span>Your education is successfully added.</span></div>");

          sesJqueryObject('#educationsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          if(sesJqueryObject('#education_count').length) {
            sesJqueryObject('#education_count').html(result.count);
          }
          if(sesJqueryObject('#sesprofilefield_educations').length) {
            if(sesJqueryObject('#education_tip').length)
              sesJqueryObject('#education_tip').hide();
            sesJqueryObject('#sesprofilefield_educations').show();
            sesJqueryObject('#sesprofilefield_educations').html(result.message);
          }
        }
      }
    });
  }

</script>
<div class="sesprofilefield_add_details_form add_education_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_education_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>
<?php } ?>
</div>