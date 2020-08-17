sesJqueryObject(document).on('click','.sesdiscussion_likefavfollow',function(){
	sesdiscussion_likefavourite_data(this,'sesdiscussion_likefavfollow');
});

sesJqueryObject(document).on('click','.sesdiscussion_favourite_sesdiscussion_discussion',function() {
	favourite_data_sesdiscussion(this,'favourite','discussion','sesdiscussion', '<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Discussion added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Discussion Un-Favourited successfully"))+'</span>','sesbasic_favourites_notification');
});

//common function for favourite item ajax
function favourite_data_sesdiscussion(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesdiscussion/index/' + functionName,
		'data': {
			format: 'html',
				id: sesJqueryObject (element).attr('data-url'),
                type: itemType,
		},
		onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
			var response = jQuery.parseJSON(responseHTML);
			if (response.error)
				alert(en4.core.language.translate('Something went wrong,please try again later'));
			else {
				if(sesJqueryObject(element).hasClass('sesdiscussion_favourite')){
					var elementCount = 	element;
				} else if(sesJqueryObject(element).hasClass('sesdiscussion_albumfavourite')){
					var elementCount = 	element;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
				} else {
					sesJqueryObject (elementCount).addClass('button_active');
				}
				sesJqueryObject ('.sesdiscussion_favourite_sesdiscussion_discussion_'+id).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesdiscussion_favourite_sesdiscussion_discussion_view') {
						sesJqueryObject('.sesdiscussion_favourite_sesdiscussion_discussion_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesdiscussion_favourite_sesdiscussion_discussion_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'sesdiscussion_favourite_sesdiscussion_discussion_view') {
						sesJqueryObject('.sesdiscussion_favourite_sesdiscussion_discussion_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesdiscussion_favourite_sesdiscussion_discussion_'+id).addClass('button_active');
					}
				}
			}
			return true;
		}
	})).send();
}

sesJqueryObject(document).on('submit', '#sesdiscussions_create', function(e) {
  e.preventDefault();
  addDiscussion(this);
});

//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;
function validateForm() {

  var errorPresent = false;
  sesJqueryObject('.sesdiscussion_create_form input, .sesdiscussion_create_form select, .sesdiscussion_create_form checkbox, .sesdiscussion_create_form textarea, .sesdiscussion_create_form radio').each(
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
function sesdiscussion_likefavourite_data(element) {
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
      itemType = 'sesdiscussion_participant';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sesdiscussion_entry_like_'+contentId;
      if(sesJqueryObject(elementId).hasClass('button_active')) {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())-1);
      }
      else {
        sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html())+1);
      }
    }
    else if (clickType == 'follow_view') {
        functionName = 'follow';
        itemType = 'discussion';
        contentId = sesJqueryObject(element).attr('data-url');
        var elementId = '.sesdiscussion_follow_' + contentId;
        if (sesJqueryObject(elementId).hasClass('button_active')) {
            sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
        } else {
            sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
        }
    }
    else if(clickType == 'like_view') {
      functionName = 'like';
      itemType = 'discussion';
      var contentId = sesJqueryObject(element).attr('data-url');
      var elementId = '.sesdiscussion_like_'+contentId;
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
      'url': en4.core.baseUrl + 'sesdiscussion/index/' + functionName,
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
            sesJqueryObject('#sesdiscussion_vote_button_'+contentId).html('<i class="fa fa-hand-o-up"></i><span>Voted</span>');
            sesJqueryObject('#sesdiscussion_vote_button_'+contentId).addClass('disable');
        }
        return true;
      }
    })).send();
}


sesJqueryObject(document).on('click','.sesdiscussion_upvote_btn',function(){
  if(sesJqueryObject(this).hasClass('_disabled'))
    return;
  if(sesJqueryObject(this).closest('.sesdiscussion_votebtn').hasClass('active'))
    return;
  sesJqueryObject(this).closest('.sesdiscussion_votebtn').addClass('active');
  var viewerid  = sesJqueryObject(this).data('viewerid');
  if(!viewerid)
    return;
  var itemguid  = sesJqueryObject(this).data('itemguid');
  var that = this;
  var userguid  = sesJqueryObject(this).data('userguid');
  var url  = en4.core.baseUrl + 'sesdiscussion/index/voteup';
  new Request.HTML({
    'url' : url,
    'data' : {
      'format' : 'html',
      'itemguid' : itemguid,
      'userguid':userguid,
      'type':'upvote',
    },
    'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if( responseHTML ) {
        sesJqueryObject(that).closest('.sesdiscussion_votebtn').replaceWith(responseHTML);
      }
                    sesJqueryObject(that).closest('.sesdiscussion_votebtn').removeClass('active');
    }
  }).send();
});
sesJqueryObject(document).on('click','.sesdiscussion_downvote_btn',function(){
  if(sesJqueryObject(this).hasClass('_disabled'))
    return;
  if(sesJqueryObject(this).closest('.sesdiscussion_votebtn').hasClass('active'))
    return;
  sesJqueryObject(this).closest('.sesdiscussion_votebtn').addClass('active');
  var viewerid  = sesJqueryObject(this).data('viewerid');
  if(!viewerid)
    return;
  var itemguid  = sesJqueryObject(this).data('itemguid');
  var that = this;
  var userguid  = sesJqueryObject(this).data('userguid');
  var url  = en4.core.baseUrl + 'sesdiscussion/index/voteup';
  new Request.HTML({
    'url' : url,
    'data' : {
      'format' : 'html',
      'itemguid' : itemguid,
      'userguid':userguid,
      'type':'downvote',
    },
    'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if( responseHTML ) {
        sesJqueryObject(that).closest('.sesdiscussion_votebtn').replaceWith(responseHTML);
      }
                    sesJqueryObject(that).closest('.sesdiscussion_votebtn').removeClass('active');
    }
  }).send();
});
