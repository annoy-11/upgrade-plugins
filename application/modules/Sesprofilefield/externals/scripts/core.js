

//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateForm(id) {

  var errorPresent = false;
  sesJqueryObject('.sesprofilefield_formcheck input, .sesprofilefield_formcheck select, .sesprofilefield_formcheck checkbox, .sesprofilefield_formcheck textarea, .sesprofilefield_formcheck radio').each(
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

sesJqueryObject(document).on('submit', '#sesprofilefield_addrecord', function(e) {
  e.preventDefault();
  addRecord(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addspecialty', function(e) {
  e.preventDefault();
  addSpecialty(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addlanguage', function(e) {
  e.preventDefault();
  addLanguage(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addeducation', function(e) {
  e.preventDefault();
  addEducation(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addcertification', function(e) {
  e.preventDefault();
  addCertification(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addcourse', function(e) {
  e.preventDefault();
  addCourse(this);
});


sesJqueryObject(document).on('submit', '#sesprofilefield_addaward', function(e) {
  e.preventDefault();
  addAward(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addexperience', function(e) {
  e.preventDefault();
  addExperience(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addorganization', function(e) {
  e.preventDefault();
  addOrganization(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addproject', function(e) {
  e.preventDefault();
  addProject(this);
});

sesJqueryObject(document).on('submit', '#sesprofilefield_addskill', function(e) {
  e.preventDefault();
  addSkill(this);
});


function profileOptionAutoComplete(fieldname, url) {

  var contentAutocomplete = new Autocompleter.Request.JSON(fieldname, url, {
    'postVar': 'text',
    'minLength': 1,
    'selectMode': 'pick',
    'autocompleteType': 'tag',
    'customChoices': true,
    'filterSubset': true,
    'multiple': false,
    'className': 'sesbasic-autosuggest',
    'injectChoice': function(token) {
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
  contentAutocomplete.addEvent('onSelection', function(element, selected, value, input) {
  });
}
