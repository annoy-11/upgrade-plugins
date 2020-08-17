
sesJqueryObject(document).on('click','.sestutorial_like_sestutorial_tutorial',function(){
  like_data_sestutorial(this,'like','sestutorial_tutorial','sestutorial','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Tutorial Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Tutorial Un-Liked successfully"))+'</span>','sesbasic_liked_notification', '');
});

//common function for like comment ajax
function like_data_sestutorial(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sestutorial/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sestutorial_albumlike')){
					var elementCount = 	element;
				} 
				else if(sesJqueryObject(element).hasClass('sestutorial_photolike')){
					var elementCount = 	element;
				}
				else {
					var elementCount = '.sestutorial_like_sestutorial_tutorial_'+id;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sestutorial_like_sestutorial_tutorial_view') {
						sesJqueryObject('.sestutorial_like_sestutorial_tutorial_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				} 
				else {
					if(classType == 'sestutorial_like_sestutorial_tutorial_view') {
						sesJqueryObject('.sestutorial_like_sestutorial_tutorial_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
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