
sesJqueryObject(document).on('click', '.ecoupon_likefavourite', function () {
  ecoupon_likefavourite_data(this, 'ecoupon_likefavourite');
});
//common function for like comment ajax
function ecoupon_likefavourite_data(element) {
  if (!sesJqueryObject(element).attr('data-type'))
    return;
  var clickType = sesJqueryObject(element).attr('data-type');
  var functionName;
  var itemType;
  var contentId;
  var classType;
  var likeTrigger = false;
  if (clickType == 'ecoupon_like_view') {
    functionName = 'like';
    itemType = 'coupon';
    var contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.ecoupon_like_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
    }
  } else if (clickType == 'ecoupon_favourite_view') {
    functionName = 'favourite';
    itemType = 'coupon';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.ecoupon_favourite_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
    }
  }
  if (!sesJqueryObject(element).attr('data-url'))
    return;
  if(sesJqueryObject(element).hasClass('button_active')) {
    sesJqueryObject(elementId).each(function(){
      sesJqueryObject(this).removeClass('button_active');
    });
  }else{
    sesJqueryObject(elementId).each(function(){
      sesJqueryObject(this).addClass('button_active');
    });
  }
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'ecoupon/ajax/' + functionName,
    'data': {
      format: 'html',
      id: contentId,
      type: itemType,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
        alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
        if (response.condition == 'reduced') {
          if(functionName == 'like') {
            sesJqueryObject('.ecoupon_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
            if(sesJqueryObject('.ecoupon_like_count_'+contentId)) {
              sesJqueryObject('.ecoupon_like_count_'+contentId).each(function(){
                sesJqueryObject(this).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                sesJqueryObject(this).attr('title',response.title);
              });
            }
          } 
          if(functionName == 'favourite') {
              if(sesJqueryObject('.ecoupon_favourite_count_'+contentId)) {
                sesJqueryObject('.ecoupon_favourite_count_'+contentId).each(function(){
                  sesJqueryObject(this).html('<i class="sesbasic_icon_favourite"></i>'+response.count);
                  sesJqueryObject(this).attr('title',response.title);
                });
              }  
          }
        } else {
          if(functionName == 'like') {
            if(sesJqueryObject('.ecoupon_like_count_'+contentId)) {
                sesJqueryObject('.ecoupon_like_count_'+contentId).each(function(){
                  sesJqueryObject(this).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                  sesJqueryObject(this).attr('title',response.title);
                });
            }
          }
          if(functionName == 'favourite') {
            if(sesJqueryObject('.ecoupon_favourite_count_'+contentId)) {
              sesJqueryObject('.ecoupon_favourite_count_'+contentId).each(function(){
                sesJqueryObject(this).html('<i class="sesbasic_icon_favourite"></i>'+response.count);
                sesJqueryObject(this).attr('title',response.title);
              });
            }
          }
        }
      }
      return true;
    }
  })).send();
}
sesJqueryObject(document).on('click','.ecoupon_coupon_code',function (e) {
    sesJqueryObject("<textarea/>").appendTo("body").val(sesJqueryObject(this).html()).select().each(function () {
        document.execCommand('copy');
    }).remove();
    showTooltip(10,10,'<i class="fa fa-files-o"></i><span>'+(en4.core.language.translate('Coupon code copied successfully'))+'</span>', 'sesbasic_liked_notification');
});

function showTooltip(x, y, contents, className) {
    if(sesJqueryObject('.sesbasic_notification').length > 0)
        sesJqueryObject('.sesbasic_notification').hide();
    sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
        display: 'block',
    }).appendTo("body").fadeOut(20000,'',function(){
        sesJqueryObject(this).remove();
    });
}
