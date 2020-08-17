sesJqueryObject(document).on('click','.seslike_like_content_view',function(){
    like_data_seslike(this, 'seslike_like_content_view');
});

//common function for like comment ajax
function like_data_seslike(element, classType) {

	if (!sesJqueryObject (element).attr('data-url'))
        return;

	var id = sesJqueryObject (element).attr('data-id');
    var type = sesJqueryObject (element).attr('data-type');
    var widget = sesJqueryObject (element).attr('data-widget');
	if (sesJqueryObject (element).hasClass('button_active')) {
        sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');

	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'seslike/index/like',
		'data': {
			format: 'html',
                id: sesJqueryObject(element).attr('data-id'),
                type: sesJqueryObject(element).attr('data-type'),
		},
		onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
			var response = jQuery.parseJSON(responseHTML);
			if (response.error)
                alert(en4.core.language.translate('Something went wrong,please try again later'));
			else {
                var elementCount = '.seslike_like_'+type+'_'+id;
                var likeCount = '<span class="_likes sesbasic_text_light" title="'+response.count+' like"><i class="fa fa-thumbs-o-up"></i>'+response.count+'</span>';

				sesJqueryObject('#'+type+'_likecount_'+id).html(likeCount);
				if (response.condition == 'reduced') {
					if(classType == 'seslike_like_content_view' && !widget) {
                        sesJqueryObject('.seslike_like_content_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					} else if(classType == 'seslike_like_content_view' && widget) {
                        sesJqueryObject('.seslike_like_'+type+'_'+id).html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
                    }
					else {
                        sesJqueryObject (elementCount).removeClass('button_active');
					}
				} else {
					if(classType == 'seslike_like_content_view' && !widget) {
						sesJqueryObject('.seslike_like_content_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
					} else if(classType == 'seslike_like_content_view' && widget) {
                        sesJqueryObject('.seslike_like_'+type+'_'+id).html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("Unlike")+'</span>');
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
