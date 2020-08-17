<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-experience.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
  <script>
    sesJqueryObject(document).on('click','#title',function(e) {
      profileOptionAutoComplete('title', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'position'),'default',true); ?>");
    });

    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.company',1)) { ?>
      en4.core.runonce.add(function() {
        if (document.getElementById('company')) {
          new google.maps.places.Autocomplete(document.getElementById('company'));
        }
      });
    <?php } else { ?>
      sesJqueryObject(document).on('click','#company',function(e) {
        profileOptionAutoComplete('company', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'company'),'default',true); ?>");
      });
    <?php } ?>
    
    en4.core.runonce.add(function() {
      if (document.getElementById('location')) {
        new google.maps.places.Autocomplete(document.getElementById('location'));
      }
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'none';
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

    function addExperience(formObject) {
    
      var validationFm = validateForm('sesprofilefield_addexperience');
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
    
      sesJqueryObject('#sesprofilefield_experience_overlay').show();
      var formData = new FormData(formObject);
      formData.append('is_ajax', 1);
      sesJqueryObject.ajax({
        url: "sesprofilefield/index/add-experience/",
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        success: function(response) {
        
          var result = sesJqueryObject.parseJSON(response);
          if(result.status == 1) {
          
            sesJqueryObject('#sesprofilefield_experience_overlay').hide();
            sesJqueryObject('#sessmoothbox_container').html("<div id='experiencesuccess_message' class='sesprofilefield_success_message experiencesuccess_message'><i class='fa-check-circle-o'></i><span>Your experience is successfully added.</span></div>");

            sesJqueryObject('#experiencesuccess_message').fadeOut("slow", function(){
              setTimeout(function() {
                sessmoothboxclose();
              }, 1000);
            });
            
            if(sesJqueryObject('#experience_count').length) {
              sesJqueryObject('#experience_count').html(result.count);
            }
            if(sesJqueryObject('#sesprofilefield_experiences').length) {
              if(sesJqueryObject('#experience_tip').length)
                sesJqueryObject('#experience_tip').hide();
              sesJqueryObject('#sesprofilefield_experiences').show();
              sesJqueryObject('#sesprofilefield_experiences').html(result.message);
            }
          }
        }
      });
    }
  </script>
  <div class="sesprofilefield_add_details_form add_experience_form">
  <div class="sesbasic_loading_cont_overlay" id="sesprofilefield_experience_overlay"></div>
  <?php if(empty($this->is_ajax) ) { ?>
      <?php echo $this->form->render($this);?>  
  <?php } ?>
  </div>