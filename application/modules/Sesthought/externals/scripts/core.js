sesJqueryObject(document).on('click','.sesthought_likefavfollow',function(){
	sesthought_likefavourite_data(this,'sesthought_likefavfollow');
});

sesJqueryObject(document).on('submit', '#sesthoughts_create', function(e) {
  e.preventDefault();
  addThought(this);
});

//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateThoughtForm() {
  
  var errorPresent = false; 
  sesJqueryObject('.sesthought_create_form input, .sesthought_create_form select, .sesthought_create_form checkbox, .sesthought_create_form textarea, .sesthought_create_form radio').each(
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
      if(error)
        errorPresent = true;
        error = false;
      }
    }
  );
  return errorPresent ;
}


//common function for like comment ajax
function sesthought_likefavourite_data(element) {
    if (!sesJqueryObject(element).attr('data-type'))
		return;
    var clickType = sesJqueryObject(element).attr('data-type');
    var functionName;
    var itemType;
    var contentId;
    var classType;
    var canIntegrate = 0;
    if(clickType == 'like_entry_view') {
      canIntegrate = sesJqueryObject(element).attr('data-integrate');
      functionName = 'like';
      itemType = 'sesthought_participant';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sesthought_entry_like_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }

    else if(clickType == 'like_view') {
      functionName = 'like';
      itemType = 'sesthought_thought';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sesthought_like_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }


    if (!sesJqueryObject(element).attr('data-url'))
      return;
      
    if (sesJqueryObject(element).hasClass('button_active')) {
      sesJqueryObject(element).removeClass('button_active');
    } else
      sesJqueryObject(element).addClass('button_active');
    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'sesthought/index/' + functionName,
      'data': {
            format: 'html',
            id: contentId,
            type: itemType,
            integration:canIntegrate,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
        var response = jQuery.parseJSON(responseHTML);
        if (response.error)
          alert(en4.core.language.translate('Something went wrong,please try again later'));
        else {
                sesJqueryObject(elementId).find('span').html(response.count);
                if (response.condition == 'reduced') {
                  sesJqueryObject(elementId).removeClass('button_active');
                } 
                else {
                  sesJqueryObject (elementId).addClass('button_active');
                }
        }
              if(canIntegrate == 1 && response.vote_status) {
                sesJqueryObject('#sesthought_vote_button_'+contentId).html('<i class="fa fa-hand-o-up"></i><span>Voted</span>');
                sesJqueryObject('#sesthought_vote_button_'+contentId).addClass('disable');
              }
        return true;
      }
    })).send();
}