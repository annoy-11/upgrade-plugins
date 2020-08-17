

function openURLinSmoothBox(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

//Favourite
sesJqueryObject (document).on('click', '.edocument_favourite', function () {
	favourite_data_edocument(this, 'favourite', 'edocument_photo');
});

sesJqueryObject(document).on('click','.edocument_favourite_edocument',function(){
    favourite_data_edocument(this,'favourite','edocument','edocument', '<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Document added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Document Un-Favourited successfully"))+'</span>','sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click','.edocument_favourite_edocument_view',function(){
    favourite_data_edocument(this,'favourite','edocument','edocument', '', 'edocument_favourite_edocument_view');
});

sesJqueryObject(document).on('click','.edocument_like_edocument',function(){
    like_data_edocument(this,'like','edocument','edocument','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Document Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Document Un-Liked successfully"))+'</span>','sesbasic_liked_notification', '');
});

sesJqueryObject(document).on('click','.edocument_like_edocument_view',function(){
	like_data_edocument(this,'like','edocument','edocument','', 'edocument_like_edocument_view');
});

//common function for like comment ajax
function like_data_edocument(element, functionName, itemType, moduleName, notificationType, classType) {

	if (!sesJqueryObject (element).attr('data-url'))
		return;

	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');

	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'edocument/index/' + functionName,
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
                var elementCount = '.edocument_like_edocument_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'edocument_like_edocument_view') {
						sesJqueryObject('.edocument_like_edocument_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				}
				else {
					if(classType == 'edocument_like_edocument_view') {
						sesJqueryObject('.edocument_like_edocument_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).addClass('button_active');
					}
				}
			}
			return true;
		}
	})).send();
}


//common function for favourite item ajax
function favourite_data_edocument(element, functionName, itemType, moduleName, notificationType, classType) {

	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');

	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'edocument/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('edocument_favourite')){
					var elementCount = 	element;
				}

				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
				} else {
					sesJqueryObject (elementCount).addClass('button_active');
				}

				sesJqueryObject ('.edocument_favourite_edocument_'+id).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'edocument_favourite_edocument_view') {
						sesJqueryObject('.edocument_favourite_edocument_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.edocument_favourite_edocument_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'edocument_favourite_edocument_view') {
						sesJqueryObject('.edocument_favourite_edocument_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.edocument_favourite_edocument_'+id).addClass('button_active');
					}
				}
			}
			return true;
		}
	})).send();
}

function showTooltip(x, y, contents, className) {
	if(sesJqueryObject('.sesbasic_notification').length > 0)
		sesJqueryObject('.sesbasic_notification').hide();
	sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
		display: 'block',
	}).appendTo("body").fadeOut(5000,'',function(){
		sesJqueryObject(this).remove();
	});
}

function trim(str, chr) {
  var rgxtrim = (!chr) ? new RegExp('^\\s+|\\s+$', 'g') : new RegExp('^'+chr+'+|'+chr+'+$', 'g');
  return str.replace(rgxtrim, '');
}

sesJqueryObject(document).on('click','.sesbasic_form_opn',function(e){
    sesJqueryObject(this).parent().parent().find('form').show();
    sesJqueryObject(this).parent().parent().find('form').focus();
    var widget_id = sesJqueryObject(this).data('rel');
    if(widget_id)
        eval("pinboardLayout_"+widget_id+"()");
});

//send quick share link
function edocumentsendQuickShare(url){
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

function changeEdocumentManifestUrl(type) {
    window.location.href = en4.core.staticBaseUrl + documentURLedocument + '/' + type;
}

function chnageEdocumentHrefOfURL(id) {
    var welcomeHomeId = sesJqueryObject(id).attr('onclick').replace("changeEdocumentManifestUrl('","" );
    welcomeHomeId = welcomeHomeId.replace("');","");
    sesJqueryObject(id).attr('href', en4.core.staticBaseUrl + documentURLedocument + '/' + welcomeHomeId);
}

sesJqueryObject(document).ready(function() {
    var landingPageLink = sesJqueryObject('.edocument_landing_link');
    for(i=0; i < landingPageLink.length; i++) {
        chnageEdocumentHrefOfURL(landingPageLink[i]);
    }
});

//Slideshow widget
sesJqueryObject(document).ready(function() {
    var edocumentElement = sesJqueryObject('.edocuments_slideshow');
	if(edocumentElement.length > 0) {
        var edocumentElements = edocumentJqueryObject('.edocuments_slideshow');
        edocumentElements.each(function(){
        edocumentJqueryObject(this).owlCarousel({
            loop:true,
            items:1,
            margin:0,
            autoHeight:true,
            autoplay:edocumentJqueryObject(this).attr('autoplay'),
            autoplayTimeout:edocumentJqueryObject(this).attr('autoplayTimeout'),
            autoplayHoverPause:true
        });
        edocumentJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
        edocumentJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
        });
	}
});
