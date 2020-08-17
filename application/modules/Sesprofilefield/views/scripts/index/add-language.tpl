<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-language.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
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
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/add-language/",
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

//   function submitLanguage(formObject) {
//     
//     sesJqueryObject('#sesprofilefield_language_overlay').show();
//     var formData = new FormData(formObject);
//     formData.append('is_ajax', 1);
//     sesJqueryObject.ajax({
//       url: "sesprofilefield/index/add-language/",
//       type: "POST",
//       contentType:false,
//       processData: false,
//       cache: false,
//       data: formData,
//       success: function(response) {
//         sesJqueryObject('#sesprofilefield_language_overlay').hide();
//         sesJqueryObject('#sessmoothbox_container').html("<div id='languagesuccess_message' class='sesprofilefield_success_message languagesuccess_message'><i class='fa-check-circle-o'></i><span>Your Language is successfully added.</span></div>");
// 
//         sesJqueryObject('#languagesuccess_message').fadeOut("slow", function(){
//           setTimeout(function() {
//             sessmoothboxclose();
//           }, 1000);
//         });
//       }
//     });
//   }
  
  sesJqueryObject(document).on('click','#languagename',function(e) {
    profileOptionAutoComplete('languagename', "<?php echo $this->url(array('module' =>'sesprofilefield','controller' => 'index', 'action' => 'getlanguage-data', 'resource_type' => 'language'),'default',true); ?>");
  });

</script>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
    ->appendFile($base_url . 'externals/autocompleter/Observer.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesprofilefield_add_details_form add_specialty_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_language_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>
<?php } ?>
</div>
