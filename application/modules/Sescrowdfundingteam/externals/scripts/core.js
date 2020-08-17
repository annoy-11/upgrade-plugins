

//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;

function validateTeamform() {

  var errorPresent = false;
  sesJqueryObject('.sescrowdfundingteam_formcheck input, .sescrowdfundingteam_formcheck select, .sescrowdfundingteam_formcheck checkbox, .sescrowdfundingteam_formcheck textarea, .sescrowdfundingteam_formcheck radio').each(
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

sesJqueryObject(document).on('submit', '#sescrowdfundingteam_addteam', function(e) {
  e.preventDefault();
  addTeam(this);
});

sesJqueryObject(document).on('submit', '#sescrowdfundingteam_adddesignation', function(e) {
  e.preventDefault();
  addDesignation(this);
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
    $('user_id').value = selected.retrieve('autocompleteChoice').id;
  });
}
