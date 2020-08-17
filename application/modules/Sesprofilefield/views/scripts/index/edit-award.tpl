<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-award.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>

  function hideToDate() {
    if(document.getElementById("notexpire").checked == true) {
      $('fieldset-toyearmonth').style.display = 'none';
    } else {
      $('fieldset-toyearmonth').style.display = 'block';
    }
  }
  
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    sesJqueryObject('#sesprofilefield_addaward input, #sesprofilefield_addaward select,#sesprofilefield_addaward checkbox,#sesprofilefield_addaward textarea,#sesprofilefield_addaward radio').each(
      function(index){
        var input = sesJqueryObject(this);
        if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
        if(sesJqueryObject(this).prop('type') == 'checkbox'){
          value = '';
          if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
            value = 1;
          };
          if(value == '')
          error = true;
          else
          error = false;
        }
        else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }
        else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
          if(sesJqueryObject(this).val() === '')
          error = true;
          else
          error = false;
        }
        else if(sesJqueryObject(this).prop('type') == 'radio'){
          if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
          error = true;
          else
          error = false;
        }
        else if(sesJqueryObject(this).prop('type') == 'textarea' && sesJqueryObject(this).prop('id') == 'body'){
          if(tinyMCE.get('body').getContent() === '' || tinyMCE.get('body').getContent() == null)
          error = true;
          else
          error = false;
        }
        else if(sesJqueryObject(this).prop('type') == 'textarea') {
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }
        else{
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }
//         if(error){
//           if(counter == 0){
//             objectError = this;
//           }
//           counter++
//         }
//         else{
//           if(sesJqueryObject('#tabs_form_blogcreate-wrapper').length && sesJqueryObject('.sesblog_upload_item_photo').length == 0){
//             <?php //if($required):?>
//               objectError = sesJqueryObject('.sesblog_create_form_tabs');
//               error = true;
//             <?php //endif;?>
//           }		
//         }
        if(error)
          errorPresent = true;
          error = false;
        }
      }
    );
    return errorPresent ;
  }

  function addAward(formObject) {
  
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
  
    sesJqueryObject('#sesprofilefield_award_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('award_id', <?php echo $this->award_id; ?>);
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/edit-award/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#sesprofilefield_award_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='awardsuccess_message' class='sesprofilefield_success_message awardsuccess_message'><i class='fa-check-circle-o'></i><span>Your award is successfully added.</span></div>");

          sesJqueryObject('#awardsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          
          if(sesJqueryObject('#award_count').length) {
            sesJqueryObject('#award_count').html(result.count);
          }
          
          if(sesJqueryObject('#sesprofilefield_awards').length) {
            if(sesJqueryObject('#award_tip').length)
              sesJqueryObject('#award_tip').hide();
            sesJqueryObject('#sesprofilefield_awards').show();
            sesJqueryObject('#sesprofilefield_awards').html(result.message);
          }
        }
      }
    });
  }
</script>
<div class="sesprofilefield_add_details_form edit_award_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_award_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  	<?php echo $this->form->render($this);?>
<?php } ?>
</div>