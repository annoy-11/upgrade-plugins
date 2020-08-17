
//Ajax error show before form submit
var error = false;
var objectError ;
var counter = 0;

function validateServiceform() {
  var errorPresent = false;
  sesJqueryObject('.classroomservice_formcheck input, .classroomservice_formcheck select, .classroomservice_formcheck checkbox, .classroomservice_formcheck textarea, .classroomservice_formcheck radio').each(
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
sesJqueryObject(document).on('submit', '#courses_add_question', function(e) {
  e.preventDefault();
  addQuestion(this);
});
sesJqueryObject(document).on('submit', '#courses_edit_question', function(e) {
  e.preventDefault();
  editQuestion(this);
});
sesJqueryObject(document).on('submit', '#courses_add_answer', function(e) {
  e.preventDefault();
  addAnswer(this);
});
sesJqueryObject(document).on('submit', '#courses_edit_answer', function(e) {
  e.preventDefault();
  editAnswer(this);
});

sesJqueryObject(document).on('click', '.courses_category_follow', function () {
  courses_category_follow_data(this, 'courses_category_follow');
});

function courses_category_follow_data(element) {
  var contentId = sesJqueryObject(element).attr('data-url');
  var elementId = '.courses_category_follow_'+contentId;
  if(sesJqueryObject(element).data('status') == 1) {
    sesJqueryObject(elementId).html('<i class="fa fa-check"></i><span>'+en4.core.language.translate("Follow")+'</span>');
    sesJqueryObject(elementId).data("status",0);
  }
  else {
    sesJqueryObject(elementId).html('<i class="fa fa-times"></i><span>'+en4.core.language.translate("UnFollow")+'</span>');
    sesJqueryObject(elementId).data("status",1);
  }
  if (!sesJqueryObject(element).attr('data-url'))
      return;
  if (sesJqueryObject(element).hasClass('button_active')) {
      sesJqueryObject(element).removeClass('button_active');
  } else
    sesJqueryObject(element).addClass('button_active');
  (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'courses/ajax/follow-category',
      'data': {
        format: 'html',
        id: contentId,
        type: 'courses_category',
        integration:0,
      },
      onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      }
  })).send();
}

sesJqueryObject(document).on('click', '.courses_likefavfollow', function () {
  courses_likefavourite_data(this, 'courses_likefavfollow');
});

var coursesTriggerFollow = false;
var coursesTriggerLike = false;
//common function for like comment ajax
function courses_likefavourite_data(element) {
  if (!sesJqueryObject(element).attr('data-type'))
    return;
  var clickType = sesJqueryObject(element).attr('data-type');
  var functionName;
  var itemType;
  var contentId;
  var classType;
  var followTrigger = false;
  var likeTrigger = false;
  if (clickType == 'courses_like_view') {
    functionName = 'like';
    itemType = 'courses';
    var contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.courses_like_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(coursesTriggerLike == false)
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        coursesTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      followTrigger = true;
      if(coursesTriggerLike == true) {
        sesJqueryObject(element).addClass('button_active');
        coursesIntegrateFollow(contentId,functionName);
        coursesTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'courses_wishlist_like_view') {
    functionName = 'like';
    itemType = 'courses_wishlist';
    var contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.courses_wishlist_like_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      if(coursesTriggerLike == false)
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
      else {
        coursesTriggerLike = false;
        return;
      }
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
      followTrigger = true;
      if(coursesTriggerLike == true) {
        sesJqueryObject(element).addClass('button_active');
        coursesIntegrateFollow(contentId,functionName);
        coursesTriggerLike = false;
        return;
      }
    }
  } else if (clickType == 'courses_favourite_view') {
    functionName = 'favourite';
    itemType = 'courses';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.courses_favourite_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).each(function(){
        sesJqueryObject(this).find('span').html(parseInt(sesJqueryObject(this).find('span').html()) - 1);
      });
    } else {
      sesJqueryObject(elementId).each(function(){
        sesJqueryObject(this).find('span').html(parseInt(sesJqueryObject(this).find('span').html()) + 1);
      });
    }
  } else if (clickType == 'courses_wishlist_favourite_view') {
    functionName = 'favourite';
    itemType = 'courses_wishlist';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.courses_wishlist_favourite_' + contentId;
    if (sesJqueryObject(elementId).hasClass('button_active')) {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
    } else {
      sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
    }
  } else if (clickType == 'favourite_course_button_view') {
    classType = 'courses_favourite_course_view';
    functionName = 'favourite';
    itemType = 'courses';
    contentId = sesJqueryObject(element).attr('data-url');
    var elementId = '.courses_favourite_' + contentId;
    if (sesJqueryObject(element).data('status') == 1) {
      sesJqueryObject('.courses_favourite_view_' + contentId).html('<i class="fa fa-heart-o"></i><span>' + en4.core.language.translate("Add to Favorite") + '</span>');
      sesJqueryObject('.courses_favourite_course_view').data("status", 0);;
    } else {
      sesJqueryObject('.courses_favourite_view_' + contentId).html('<i class="fa fa-heart"></i><span>' + en4.core.language.translate("Favorited") + '</span>');
      sesJqueryObject('.courses_favourite_course_view').data("status", 1);
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
    'url': en4.core.baseUrl + 'courses/ajax/' + functionName,
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
            if(itemType == "courses") {
              if(sesJqueryObject('.courses_like_count_' + contentId) != "undefined") {
                sesJqueryObject('.courses_like_count_' + contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                sesJqueryObject('.courses_like_count_' + contentId).attr('title',response.title);
              }
              sesJqueryObject('.courses_like_view_' + contentId).html('<i class="fa fa-thumbs-up"></i><span>' + en4.core.language.translate("Like") + '</span>');
              sesJqueryObject('.courses_like_course_view').data("status",0);
              sesJqueryObject('.courses_like_' + contentId).find('span').html(response.count);
              sesJqueryObject('.courses_like_' + contentId).removeClass('button_active');
            } else if(itemType == 'courses_wishlist'){
              sesJqueryObject('.courses_wishlist_like_count_' + contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
              sesJqueryObject('.courses_wishlist_like_count_' + contentId).attr('title',response.title);
            }
          }
          if(functionName == 'favourite') {
            if(itemType == "courses") {
              if(sesJqueryObject('.courses_favourite_count_' + contentId) != "undefined") {
                sesJqueryObject('.courses_favourite_count_' + contentId).html('<i class="sesbasic_icon_favourite_o"></i>'+response.count);
                sesJqueryObject('.courses_favourite_count_' + contentId).attr('title',response.title);
              }
            } else if(itemType == 'courses_wishlist'){
              sesJqueryObject('.courses_wishlist_favourite_count_' + contentId).html('<i class="fa fa-heart"></i>'+response.count);
               sesJqueryObject('.courses_wishlist_like_count_' + contentId).attr('title',response.title);
            }
          }
        } else {
          if(functionName == 'like') {
            if(itemType == 'courses_wishlist'){
              sesJqueryObject('.courses_wishlist_like_count_' + contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
              sesJqueryObject('.courses_wishlist_like_count_' + contentId).attr('title',response.title);
             } else if(itemType == "courses") {
              if(sesJqueryObject('.courses_like_count_' + contentId) != "undefined") {
                sesJqueryObject('.courses_like_count_' + contentId).html('<i class="sesbasic_icon_like_o"></i>'+response.count);
                sesJqueryObject('.courses_like_count_' + contentId).attr('title',response.title);
              }
              sesJqueryObject('.courses_like_view_' + contentId).html('<i class="fa fa-thumbs-down"></i><span>' + en4.core.language.translate("Unlike") + '</span>');
              sesJqueryObject('.courses_like_course_view').data("status",1);
              sesJqueryObject('.courses_like_' + contentId).find('span').html(response.count);
              sesJqueryObject('.courses_like_' + contentId).addClass('button_active');
            }
          }
          if(functionName == 'favourite') { 
            if(itemType == 'courses_wishlist'){
              sesJqueryObject('.courses_wishlist_favourite_count_' + contentId).html('<i class="fa fa-heart"></i>'+response.count);
              sesJqueryObject('.courses_wishlist_like_count_' + contentId).attr('title',response.title);
            } else if(itemType == "courses") {
              if(sesJqueryObject('.courses_favourite_count_' + contentId) != "undefined") {
                sesJqueryObject('.courses_favourite_count_' + contentId).html('<i class="sesbasic_icon_favourite_o"></i>'+response.count);
                sesJqueryObject('.courses_favourite_count_' + contentId).attr('title',response.title);
              }
            }
          }
        }
      }
      return true;
    }
  })).send();
}
function coursesIntegrateFollow(contentId,functionName) {
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'courses/ajax/' + functionName,
    'data': {
      format: 'html',
      id: contentId,
      type: course,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {

    }
  })).send();
}
sesJqueryObject(document).on('click','.course_addtocart',function (e) {
    e.preventDefault();
    if(sesJqueryObject(this).find('.loading_image').length){
        return;
    }
    var course_id = sesJqueryObject(this).attr('data-action');
    var isBuy = sesJqueryObject(this).attr('data-buy');
    if(course_id){
        sesJqueryObject(this).prepend('<img class="loading_image" src="application/modules/Core/externals/images/loading.gif">');
        var that = this;

        var url = 'courses/cart/addtocart';
        new Request.JSON({
            url : url,
            data : {
                format: 'json',
                course_id:course_id,
                isBuy:isBuy,
            },
            onComplete : function(responseJSON) {
                sesJqueryObject(that).find('.loading_image').remove();
                showTipOnAddToCart(responseJSON);
                getCourseCartValue();
                if(isBuy){ 
                    window.location.href = sesJqueryObject(that).attr('data-url');
                }
            }
        }).send();
    }
});
function getCourseCartValue() {
    sesJqueryObject.post('courses/cart/course-cart',{},function (response) {
        if(sesJqueryObject('.courses_cart_count').length){
            if(response > 0) {
                sesJqueryObject('.courses_cart_count').show();
                var count = parseInt(sesJqueryObject('.courses_cart_count').html());
                sesJqueryObject('.courses_cart_count').html(response);
            }else{
                sesJqueryObject('.courses_cart_count').hide();
                sesJqueryObject('.courses_cart_count').html(0);
            }
        }
    });
}
function showTipOnAddToCart(responseJSON) {
    if(responseJSON.status == 1){
        showCartTooltip(10,10,'<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate(responseJSON.message))+'</span>', 'sesbasic_liked_notification');
    }else{
        //error
        showCartTooltip(10,10,'<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate(responseJSON.message))+'</span>', 'sesbasic_unlikedliked_notification');
    }
}
function showCartTooltip(x, y, contents, className) {
    if(sesJqueryObject('.sesbasic_notification').length > 0)
        sesJqueryObject('.sesbasic_notification').hide();
    sesJqueryObject('<div class="sesbasic_notification '+className+'">' + contents + '</div>').css( {
        display: 'block',
    }).appendTo("body").fadeOut(20000,'',function(){
        sesJqueryObject(this).remove();
    });
}
sesJqueryObject(document).on('click','.courses_wishlist',function(e){
  e.preventDefault();
  var id = sesJqueryObject(this).data('rel');
  if(id == "" || id < 1)
    return;
  opensmoothboxurl('courses/wishlist/add/course_id/'+id);
});

//send quick share link
function coursessendQuickShare(url){
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
				showTooltip('10','10','<i class="fa fa-envelope"></i><span>'+(en4.core.language.translate("Course shared successfully."))+'</span>','sesbasic_message_notification');
      }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

function reviewVotesCourses(elem,type){
    sesJqueryObject(elem).parent().parent().find('p').first().html('<span style="color:green;font-weight:bold">Thanks for your vote!</span>');
    var element = sesJqueryObject(this);
    if (!sesJqueryObject(elem).attr('data-href'))
        return;
    var text = sesJqueryObject(elem).find('.title').html();
    var id = sesJqueryObject (elem).attr('data-href');
    (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + 'courses/index/review-votes',
        'data': {
            format: 'html',
            id: id,
            type: type,
        },
        onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
            var response = jQuery.parseJSON(responseHTML);
            if (response.error)
                alert(en4.core.language.translate('Something went wrong,please try again later'));
            else {
                //sesJqueryObject (elementCount).find('span').html(response.count);
                if (response.condition == 'reduced') {
                    sesJqueryObject (elem).removeClass('active');
                    sesJqueryObject (elem).find('span').eq(1).html(response.count);
                }else{
                    sesJqueryObject (elem).addClass('active');
                    sesJqueryObject (elem).find('span').eq(1).html(response.count);
                }
            }
            return true;
        }
    })).send();
}
//review votes js
sesJqueryObject(document).on('click', '.courses_review_useful', function (e) {
    reviewVotesCourses(this, '1');
});
sesJqueryObject(document).on('click', '.courses_review_funny', function (e) {
    reviewVotesCourses(this, '2');
});
sesJqueryObject(document).on('click', '.courses_review_cool', function (e) {
    reviewVotesCourses(this, '3');
});


sesJqueryObject(document).on('click', '#dragandrophandlerecourselocation', function () {
  document.getElementById('file_multi').click();
});
sesJqueryObject(document).on('click', '.delete_image_upload_courselocation', function (e) {
  e.preventDefault();
  sesJqueryObject(this).parent().parent().find('.courses_upload_item_overlay').css('display', 'block');
  var sesthat = this;
  var photo_id = sesJqueryObject(this).closest('.courses_upload_item_options').attr('data-src');
  if (photo_id) {
    request = new Request.JSON({
      'format': 'json',
      'url': coursePhotoDeleteUrl,
      'data': {
        'locationphoto_id': photo_id
      },
      onSuccess: function (responseJSON) {
        parent.sesJqueryObject('#courses_locationphoto_' + photo_id).remove();
        sesJqueryObject(sesthat).parent().parent().remove();
        sesJqueryObject('#courses_location_' + photo_id).remove();
        if (sesJqueryObject('#show_photo').html() == '') {
          sesJqueryObject('#show_photo_container').removeClass('iscontent');
        }
        return false;
      }
    });
    request.send();
  } else
    return false;
});
function removeCourseLocationPhoto(photoId) {
  var removePhoto = new Request.JSON({
    'format': 'json',
    'url': coursePhotoDeleteUrl,
    'data': {
      'locationphoto_id': photoId
    },
    onSuccess: function (responseJSON) {
      sesJqueryObject('#courses_locationphoto_' + photoId).remove();
    }
  });
  removePhoto.send();
}


sesJqueryObject(document).on("click", '.courses_thumb_img', function (e) {
	if( /iPhone|iPad|iPod|BlackBerry|IEMobile/i.test(navigator.userAgent) ) {
		return true;
	}
	e.preventDefault();
	var imageObject = sesJqueryObject(this);
  var getImageHref = imageObject.attr('href');
	videoURLsesbasic = coursesURL;
	if(openVideoInLightBoxsesbasic == 0 ){
		window.location.href = getImageHref;
		return true;
	}
	var imageSource = imageObject.find('span').css('background-image').replace('url(','').replace(')','').replace('"','').replace('"','');
	getImageHref = getImageHref.replace('/view','/imageviewerdetail');
	getRequestedVideoForImageViewer(imageSource,getImageHref);
});
