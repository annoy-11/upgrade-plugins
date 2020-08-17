sesJqueryObject(document).on('submit', '#sesbusinessreview_edit_review',function(e) {
  var editURL = sesJqueryObject(this).attr('action');
  var error = false;
  if(sesJqueryObject('#title')) {
    var titleFieldValue = sesJqueryObject('#title').val();
    if(!titleFieldValue){
      sesJqueryObject('#title').css('border','1px solid red');
      error = true;
    }else{
      sesJqueryObject('#title').css('border','');
    }
  }
  if(sesJqueryObject('#description')) {
    var messageFieldValue = sesJqueryObject('#description').val();
    if(!messageFieldValue){
      sesJqueryObject('#description').css('border','1px solid red');
      error = true;
    }else{
      sesJqueryObject('#description').css('border','');
    }
  }
  if(sesJqueryObject('#pros')) {
    var prosFieldValue = sesJqueryObject('#pros').val();
    if(!prosFieldValue){
      sesJqueryObject('#pros').css('border','1px solid red');
      error = true;
    }else{
      sesJqueryObject('#pros').css('border','');
    }
  }
  if(sesJqueryObject('#cons')) {
    var consFieldValue = sesJqueryObject('#description').val();
    if(!consFieldValue){
      sesJqueryObject('#cons').css('border','1px solid red');
      error = true;
    }else{
      sesJqueryObject('#cons').css('border','');
    }
  }
  if(error){
    return false;
  }
  e.preventDefault();
  var formData = new FormData(this);
  var jqXHR=sesJqueryObject.ajax({
    url: editURL,
    type: "POST",
    contentType:false,
    processData: false,
    data: formData,
    success: function(response){
      response = sesJqueryObject.parseJSON(response);
      if(response.status == 'true') {
			sesJqueryObject('#sessmoothbox_container').html("<div id='sesbusinessreview_review_edit_message' class='sesbasic_bxs'><div class='sesbasic_tip clearfix'><img src='application/modules/Sesbusiness/externals/images/success.png' alt=''><span>Review Edit Successfully</span></div></div>");
      	sesJqueryObject('.sessmoothbox_overlay').fadeOut(3000, function(){sessmoothboxclose();});
        window.location.reload();
      }
    }
  });
  return false;
});
function reviewVotes(elem,type){
  if(sesJqueryObject(elem).hasClass('activerequest')) 
    return;
  sesJqueryObject(elem).addClass('activerequest');
  sesJqueryObject(elem).parent().parent().find('p').first().html('<span style="color:green;font-weight:bold">Thanks for your vote!</span>');
  var element = sesJqueryObject(this);
  if (!sesJqueryObject(elem).attr('data-href'))
  	return;
  var text = sesJqueryObject(elem).find('.title').html();
  var id = sesJqueryObject (elem).attr('data-href');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesbusinessreview/index/review-votes',
    'data': {
      format: 'html',
      id: id,
      type: type,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject(elem).removeClass('activerequest');
      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
      	alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
        if (response.condition == 'reduced') {
          sesJqueryObject (elem).removeClass('active');
          sesJqueryObject (elem).find('span').eq(1).html(response.count);
        }
        else {
          sesJqueryObject (elem).addClass('active');
          sesJqueryObject (elem).find('span').eq(1).html(response.count);
        }
      }
      return true;
    }
  })).send();
}
//review votes js
sesJqueryObject(document).on('click', '.sesbusinessreview_review_useful', function (e) {
  reviewVotes(this, '1');
});
sesJqueryObject(document).on('click', '.sesbusinessreview_review_funny', function (e) {
  reviewVotes(this, '2');
});
sesJqueryObject(document).on('click', '.sesbusinessreview_review_cool', function (e) {
  reviewVotes(this, '3');
});

//tooltip code
var sestooltipOrigin;
sesJqueryObject(document).on('mouseover mouseout', '.sesbusinessreview_rating_info_tip', function(event) {
  sesJqueryObject(this).tooltipster({
    interactive: true,				
    content: '',
    contentCloning: false,
    contentAsHTML: true,
    animation: 'fade',
    updateAnimation:false,
    functionBefore: function(origin, continueTooltip) {
      //get attr
      if(typeof sesJqueryObject(origin).attr('data-rel') == 'undefined')
        var guid = sesJqueryObject(origin).attr('data-src');
      else
        var guid = sesJqueryObject(origin).attr('data-rel');
        continueTooltip();
      var data = "<div class='sesbusinessreview_rating_info'>"+sesJqueryObject(this).parent().find('.sesbusinessreview_rating_info').html()+"<div>";
      origin.tooltipster('content', data).data('ajax', 'cached');

    }
  });
  sesJqueryObject(this).tooltipster('show');
});

sesJqueryObject(document).on('click', '.sesbusinessreview_like', function () {
  sesbusinessreview_like_data(this, 'sesbusinessreview_like');
});
//common function for like comment ajax
function sesbusinessreview_like_data(element) {
  if (!sesJqueryObject(element).attr('data-type'))
    return;
  var contentId = sesJqueryObject(element).attr('data-url');
  var elementId = '.sesbusinessreview_like_' + contentId;
  if (sesJqueryObject(elementId).hasClass('button_active')) {
    sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) - 1);
  } else {
    sesJqueryObject(elementId).find('span').html(parseInt(sesJqueryObject(elementId).find('span').html()) + 1);
  }
  if (!sesJqueryObject(element).attr('data-url'))
    return;
  if (sesJqueryObject(element).hasClass('button_active')) {
    sesJqueryObject(element).removeClass('button_active');
  } else
    sesJqueryObject(element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesbusinessreview/review/like',
    'data': {
      format: 'html',
      id: contentId,
      type: 'businessreview',
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {
      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
        alert(en4.core.language.translate('Something went wrong,please try again later'));
      return true;
    }
  })).send();
}