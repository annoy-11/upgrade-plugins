
sesJqueryObject(document).on('click','.coursesalbum_photoFav, .coursesalbum_albumFav',function(){
  var data = sesJqueryObject(this).attr('data-src');
  if (typeof data == 'undefined') {
    var data = sesJqueryObject(this).attr('data-url');
  }
  var id = data;
  var date_resource_type = sesJqueryObject(this).attr('data-resource-type');
  var data_contenttype = sesJqueryObject(this).attr('data-contenttype');
  var objectDocument = this;
  (new Request.JSON({
    url : en4.core.baseUrl + 'courses/ajax/favourite',
    data : {
      format : 'json',
        type : date_resource_type,
        id : data,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      var data = JSON.parse(responseElements);
      if(data.status == 'false') {
        if(data.error == 'Login')
          alert(en4.core.language.translate('Please login'));
        else
          alert(en4.core.language.translate('Invalid argument supplied.'));
      } else {
        if(data.condition == 'increment') {
          sesJqueryObject(objectDocument).addClass('button_active');
          sesJqueryObject(objectDocument).find('span').html(data.count);
          if(data_contenttype == 'album') {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Album added as Favourite successfully")+'</span>', 'sesbasic_favourites_notification');
          } else {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Photo added as Favourite successfully")+'</span>', 'sesbasic_favourites_notification');
          }
        }else{
          sesJqueryObject(objectDocument).removeClass('button_active');
          sesJqueryObject(objectDocument).find('span').html(data.count);
          if(data_contenttype == 'album') {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Photo Unfavourited successfully")+'</span>');
          } else {
            showTooltipSesbasic(10,10,'<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Album Unfavourited successfully")+'</span>');
          }
        }
        if(data_contenttype == "album" && sesJqueryObject('.coursesalbum_album_favs_count_'+id)) {
          sesJqueryObject('.coursesalbum_album_favs_count_'+id).html('<i class="sesbasic_icon_favourite_o"></i>'+data.count);
          sesJqueryObject('.coursesalbum_album_favs_count_'+id).attr('title',data.title);
        }
      }
    }
  })).send();
  return false;
});

sesJqueryObject (document).on('click', '.coursesalbum_albumlike', function () {
  like_data_classroom(this, 'like', 'coursesalbum_album');
});
sesJqueryObject (document).on('click', '.coursesalbum_photolike', function () {
  like_data_classroom(this, 'like', 'coursesalbum_photo');
});
//common function for like comment ajax
function like_data_classroom(element, functionName, itemType) {
  if (!sesJqueryObject (element).attr('data-url'))
    return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active')) {
    sesJqueryObject (element).removeClass('button_active');
  } else
    sesJqueryObject (element).addClass('button_active');

  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'courses/ajax/' + functionName,
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
        if(sesJqueryObject(element).hasClass('coursesalbum_albumlike')) {
          var elementCount = 	element;
        } else if(sesJqueryObject(element).hasClass('coursesalbum_photolike')) {
          var elementCount = 	element;
        }
        sesJqueryObject (elementCount).find('span').html(response.count);
        if (response.condition == 'reduced') {
          if(sesJqueryObject(element).hasClass('coursesalbum_cover_btn')) {
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').addClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).removeClass('button_active');
        } else {
          if(sesJqueryObject(element).hasClass('coursesalbum_cover_btn')) {
            sesJqueryObject (element).find('i').addClass('fa-thumbs-up');
            sesJqueryObject (element).find('i').removeClass('fa-thumbs-o-up');
          } else
            sesJqueryObject (elementCount).addClass('button_active');
        }
        if(itemType == "coursesalbum_album" && sesJqueryObject('.coursesalbum_album_likes_count_'+id)) {
          sesJqueryObject('.coursesalbum_album_likes_count_'+id).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
          sesJqueryObject('.coursesalbum_album_likes_count_'+id).attr('title',response.title);
        }
        if(itemType == "coursesalbum_album" && sesJqueryObject('.coursesalbum_album_cover_likes_count_'+id)) {
          sesJqueryObject('.coursesalbum_album_cover_likes_count_'+id).html(response.count);
        }
        if(itemType == "coursesalbum_photo" && sesJqueryObject('.coursesalbum_photo_likes_count_'+id)) {
          sesJqueryObject('.coursesalbum_photo_likes_count_'+id).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
          sesJqueryObject('.coursesalbum_photo_likes_count_'+id).attr('title',response.title);
        } 
      }
      return true;
    }
  })).send();
}
