
function like_data_sesdocument(element, functionName, itemType, classType) {
  if (!sesJqueryObject (element).attr('data-url'))
    return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active')) {
    sesJqueryObject (element).removeClass('button_active');
  } else
    sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesdocument/index/' + functionName,
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

					var elementCount = '.sesdocument_like_sesdocument_document_'+id;

				 sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesdocument_like_sesdocument_document_view') {
						sesJqueryObject('.sesdocument_like_sesdocument_document_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				}
				else {
					if(classType == 'sesdocument_like_sesdocument_document_view') {
						sesJqueryObject('.sesdocument_like_sesdocument_document_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).addClass('button_active');
					}
				}

        if (response.condition == 'reduced') {
					if(sesJqueryObject(element).hasClass('sesdocument_cover_btn')){
						sesJqueryObject (element).find('i').removeClass('fa-thumbs-up');
						sesJqueryObject (element).find('i').addClass('fa-thumbs-o-up');
					}else
						sesJqueryObject (elementCount).removeClass('button_active');
        } else {
					if(sesJqueryObject(element).hasClass('sesdocument_cover_btn')){
						sesJqueryObject (element).find('i').addClass('fa-thumbs-up');
						sesJqueryObject (element).find('i').removeClass('fa-thumbs-o-up');
					}else
						sesJqueryObject (elementCount).addClass('button_active');
        }
      }
      return true;
    }
  })).send();
}
//common function for favourite item ajax
function favourite_data_sesdocument(element, functionName, itemType, classType) {
  if (!sesJqueryObject (element).attr('data-url'))
    return;
   var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active')) {
    sesJqueryObject (element).removeClass('button_active');
  } else
    sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesdocument/index/' + functionName,
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

					var elementCount = 	element;

				sesJqueryObject (elementCount).find('span').html(response.count);

				if (response.condition == 'reduced') {
					if(classType == 'sesdocument_favourite_sesdocument_document_view') {
						sesJqueryObject('.sesdocument_favourite_sesdocument_document_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesdocument_favourite_sesdocument_document_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'sesdocument_favourite_sesdocument_document_view') {
						sesJqueryObject('.sesdocument_favourite_sesdocument_document_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesdocument_favourite_sesdocument_document_'+id).addClass('button_active');
					}
				}

				 if (response.condition == 'reduced' && classType != 'sesdocument_favourite_sesdocument_document_view') {
					if(sesJqueryObject(element).hasClass('sesdocument_cover_btn')){
						sesJqueryObject (element).find('i').removeClass('fa-heart');
						sesJqueryObject (element).find('i').addClass('fa-heart-o');
					}else
						sesJqueryObject (elementCount).removeClass('button_active');
        } else {
					if(sesJqueryObject(element).hasClass('sesdocument_cover_btn')){
						sesJqueryObject (element).find('i').addClass('fa-heart');
						sesJqueryObject (element).find('i').removeClass('fa-heart-o');
					}else
						sesJqueryObject (elementCount).addClass('button_active');
        }
        if(classType != 'sesdocument_favourite_sesdocument_document_view') {
 				sesJqueryObject ('.sesdocument_favourite_sesdocument_document_'+id).find('span').html(response.count);
        if (response.condition == 'reduced') {
					sesJqueryObject ('.sesdocument_favourite_sesdocument_document_'+id).removeClass('button_active');
        } else {
					sesJqueryObject ('.sesdocument_favourite_sesdocument_document_'+id).addClass('button_active');
        }
        }
      }
      return true;
    }
  })).send();
}

//Like
sesJqueryObject (document).on('click', '.sesdocument_like_sesdocument_document_view', function () {
  like_data_sesdocument(this, 'like', 'sesdocument', 'sesdocument_like_sesdocument_document_view');
});

//Like
sesJqueryObject (document).on('click', '.sesdocument_like_sesdocument_document', function () {
  like_data_sesdocument(this, 'like', 'sesdocument');
});

//Favourite
sesJqueryObject (document).on('click', '.sesdocument_favourite_sesdocument_document_view', function () {
  favourite_data_sesdocument(this, 'favourite', 'sesdocument', 'sesdocument_favourite_sesdocument_document_view');
});

//Favourite
sesJqueryObject (document).on('click', '.sesdocument_favourite_sesdocument_document', function () {
  favourite_data_sesdocument(this, 'favourite', 'sesdocument');
});

function chnageManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + documentURLsesdocument + '/' + type;
}


//send quick share link
function sesdocumentsendQuickShare(url){
	if(!url)
		return;
	sesJqueryObject('.sesbasic_popup_slide_close').trigger('click');
	(new Request.HTML({
      method: 'post',
      'url': url,
      'data': {
        format: 'html',
        is_ajax : 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        //keep Silence
        showTooltip('10','10','<i class="fa fa-envelope"></i><span>'+(en4.core.language.translate("Document shared successfully."))+'</span>','sesbasic_message_notification');
      }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}
