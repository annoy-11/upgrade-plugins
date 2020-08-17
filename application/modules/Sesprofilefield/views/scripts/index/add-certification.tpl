<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-certification.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  
  en4.core.runonce.add(function() {
    if($('present-wrapper'))
      $('present-wrapper').style.display = 'none';
  });
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilefield.authority',1)) { ?>
    en4.core.runonce.add(function() {
      if (document.getElementById('authority')) {
        new google.maps.places.Autocomplete(document.getElementById('authority'));
      }
    });
  <?php } else { ?>
    sesJqueryObject(document).on('click','#authority',function(e) {
      profileOptionAutoComplete('authority', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'get-data', 'resource_type' => 'authority'),'default',true); ?>");
    });
  <?php } ?>

  function hideToDate() {
    if(document.getElementById("notexpire").checked == true) {
      $('fieldset-toyearmonth').style.display = 'none';
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'block';
    } else {
      $('fieldset-toyearmonth').style.display = 'block';
      if($('present-wrapper'))
        $('present-wrapper').style.display = 'none';
    }
  }
  
  function isUrl(s) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(s);
  }
  
  function checkURL(value) {
    var checkURL = isUrl(value);
    if(!checkURL) {
      sesJqueryObject('#url_error').remove();
      sesJqueryObject('#url-wrapper').after("<div id='url_error' class='education_error'><span style='color:red;padding:0px 10px;line-height:1.6rem;'>Url is incorrectly formatted.</span></div>");
      return false;
    } else {
      sesJqueryObject('#url_error').remove();
    }
  }
  
  
  function addCertification(formObject) {
  
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
    
    //var isURL = isUrl(sesJqueryObject('#url').val());
    //if(!isURL) {
      //sesJqueryObject('#url_error').remove();
      //sesJqueryObject('#url-wrapper').after("<div id='url_error' class='education_error'><span style='color:red;padding:0px 10px;line-height:1.6rem;'>Url is incorrectly formatted.</span></div>");
      //return false;
    //}
    
    sesJqueryObject('#sesprofilefield_certification_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/add-certification/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#sesprofilefield_certification_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='certificationsuccess_message' class='sesprofilefield_success_message certificationsuccess_message'><i class='fa-check-circle-o'></i><span>Your certification is successfully added.</span></div>");

          sesJqueryObject('#certificationsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          
          if(sesJqueryObject('#certification_count').length) {
            sesJqueryObject('#certification_count').html(result.count);
          }
          
          if(sesJqueryObject('#sesprofilefield_certifications').length) {
            if(sesJqueryObject('#certification_tip').length)
              sesJqueryObject('#certification_tip').hide();
            sesJqueryObject('#sesprofilefield_certifications').show();
            sesJqueryObject('#sesprofilefield_certifications').html(result.message);
          }
        }
      }
    });
  }
</script>
<div class="sesprofilefield_add_details_form add_certification_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_certification_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>  
<?php } ?>
</div>
