<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-skill.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script>
  
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm() {
    var errorPresent = false; 
    sesJqueryObject('#sesprofilefield_addskill input, #sesprofilefield_addskill select,#sesprofilefield_addskill checkbox,#sesprofilefield_addskill textarea,#sesprofilefield_addskill radio').each(
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

  function addSkill(formObject) {

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
      submitSkill(formObject);
    }
  }

  function submitSkill(formObject) {
  
    sesJqueryObject('#sesprofilefield_skill_overlay').show();
    var formData = new FormData(formObject);
    formData.append('is_ajax', 1);
    formData.append('user_id', '<?php echo $this->user_id ?>');
    sesJqueryObject.ajax({
      url: "sesprofilefield/index/add-skill/",
      type: "POST",
      contentType:false,
      processData: false,
      cache: false,
      data: formData,
      success: function(response) {
        var result = sesJqueryObject.parseJSON(response);
        if(result.status == 1) {
          sesJqueryObject('#sesprofilefield_skill_overlay').hide();
          sesJqueryObject('#sessmoothbox_container').html("<div id='skillsuccess_message' class='sesprofilefield_success_message skillsuccess_message'><i class='fa-check-circle-o'></i><span>Your skill is successfully added.</span></div>");

          sesJqueryObject('#skillsuccess_message').fadeOut("slow", function(){
            setTimeout(function() {
              sessmoothboxclose();
            }, 1000);
          });
          
          if(sesJqueryObject('#skill_count').length) {
            sesJqueryObject('#skill_count').html(result.count);
          }
          
          if(sesJqueryObject('#sesprofilefield_skills').length) {
            if(sesJqueryObject('#skill_tip').length)
              sesJqueryObject('#skill_tip').hide();
            sesJqueryObject('#sesprofilefield_skills').show();
            sesJqueryObject('#sesprofilefield_skills').html(result.message);
          }
        }
      }
    });
  }
</script>
<?php
$base_url = $this->layout()->staticBaseUrl;
$this->headScript()
    ->appendFile($base_url . 'externals/autocompleter/Observer.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($base_url . 'externals/autocompleter/Autocompleter.Request.js');
?>
<div class="sesprofilefield_add_details_form add_skill_form">
<div class="sesbasic_loading_cont_overlay" id="sesprofilefield_skill_overlay"></div>
<?php if(empty($this->is_ajax) ) { ?>
  <?php echo $this->form->render($this);?>
<?php } ?>
</div>
<?php if(empty($this->is_ajax) ) { ?>
  <script type="text/javascript">

  var addskillartist = true;
  var previousText = '';
  en4.core.runonce.add(function() {

    //sesJqueryObject('#manageexpert_id-wrapper').hide();
    //var expertLevelData = sesJqueryObject('#manageexpert_id').html();
    sesJqueryObject('#custom_add_skill-wrapper').hide();
    sesJqueryObject('#button').hide();
    sesJqueryObject('#custom_add_skills-wrapper').hide();
    
    var contentAutocomplete = new Autocompleter.Request.JSON('skillname', "sesprofilefield/index/get-skill", {
      'postVar': 'text',
      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'customChoices': true,
      'filterSubset': true,
      'multiple': false,
      'className': 'sesbasic-autosuggest',
      'cache': false,
      'onRequest': function() {
        if(!sesJqueryObject('#sesprofilefield_loading_image').length)
          sesJqueryObject('#skillname').after('<div id="sesprofilefield_loading_image"><img src="http://www.bakadev.com/traviswilson/images/loading.gif"></img></div>');
        sesJqueryObject('.sesbasic-autosuggest').html('');
      },
      'onComplete': function() {
        sesJqueryObject('#sesprofilefield_loading_image').remove();
      },
      'injectChoice': function(token) {
        previousText = sesJqueryObject('#skillname').val();
        var choice = new Element('li', {
          'class': 'autocompleter-choices', 
          'html': token.photo, 
          'id':token.label
        });
        new Element('div', {
          'html': this.markQueryValue(token.label),
          'class': 'autocompleter-choice'
        }).inject(choice);
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
    var counterVal = 1;
    contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
      var skillName = selected.retrieve('autocompleteChoice');
      var id = skillName.id;
      var skillname = skillName.label;
      if(id == 0){
        var nameText = 'new_skill';
        var selectName = 'new_select';
        skillname = previousText;
      }else{
        var nameText = 'existing_skill';
        var selectName = 'existing_select';
        skillname = sesJqueryObject('#skillname').val();
      }
      sesJqueryObject('#custom_add_skill-wrapper').show();
      sesJqueryObject('#custom_add_skills-wrapper').show();
      sesJqueryObject('#button').show();
      var html = '<p class="addskills_popup_list"><span class="addskills_popup_list_name">'+skillname+'</span><span style="display:none;"><input type="text" value="'+skillname+'" name="'+nameText+'[]"></span><span class="addskills_popup_list_right"><span><input type="hidden" name="'+nameText+'_value[]" value="'+id+'" ></span><span><a href="javascript:;" class="removeSkill addskills_popup_list_delete_btn fa fa-close"></a></span></span></p>';
      sesJqueryObject('#custom_add_skill-element').append(html);		
      sesJqueryObject('#skillname').val('');
      sesJqueryObject('.sesbasic-autosuggest').html('');
      sesJqueryObject('#skillname').val('');
    });
    
    sesJqueryObject(document).on('click','.removeSkill',function(e){
      sesJqueryObject(this).parent().parent().parent().remove();
      if(!sesJqueryObject('#custom_add_skill-element').html()) {
        sesJqueryObject('#custom_add_skill-wrapper').hide();
        sesJqueryObject('#custom_add_skills-wrapper').hide();
        sesJqueryObject('#button').hide();
      }
    });
  });
  </script>
<?php } ?>
