var map_event;
var infowindow_event;
var marker_event;
var mapLoad_event = true;
//list page map
function initializeSesMemberMapList() {
  if (sesJqueryObject('#locationSes').length)
  var input = document.getElementById('locationSes');
  else
  var input = document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);

  google.maps.event.addListener(autocomplete, 'place_changed', function () {

    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
    document.getElementById('lngSesList').value = place.geometry.location.lng();
    document.getElementById('latSesList').value = place.geometry.location.lat();
  });
  if (mapLoad_event) {
    google.maps.event.addDomListener(window, 'load', initializeSesMemberMapList);
  }
}


function likeUnlike(id, type) {
  if ($(type + '_likeunlike_' + id))
    var userId = $(type + '_likeunlike_' + id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesmember/index/like-unlike',
    data: {
      format: 'json',
      'id': id,
      'type': type,
      'userId': userId
    },
    onSuccess: function (responseJSON) {
      if (responseJSON.like_id) {
        if ($(type + '_likeunlike_' + id))
          $(type + '_likeunlike_' + id).value = responseJSON.like_id;
        if ($(type + '_like_' + id))
          $(type + '_like_' + id).style.display = 'none';
        if ($(type + '_unlike_' + id))
          $(type + '_unlike_' + id).style.display = 'inline-block';
      } else {
        if ($(type + '_likeunlike_' + id))
          $(type + '_likeunlike_' + id).value = 0;
        if ($(type + '_like_' + id))
          $(type + '_like_' + id).style.display = 'inline-block';
        if ($(type + '_unlike_' + id))
          $(type + '_unlike_' + id).style.display = 'none';
      }
			if(responseJSON.condition == 'reduced'){
				showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Member unliked successfully"))+'</span>','sesbasic_unliked_notification');
			}else{
				showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Member liked successfully"))+'</span>','sesbasic_liked_notification');
			}


    }
  }));
}
function sesMemberLocation(i) {
   if(!document.getElementById('ses_location_'+i))
  return;

  var input = document.getElementById('ses_location_'+i);
  var autocomplete =  new google.maps.places.Autocomplete(input);
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
      console.log('dddd');
    var place = autocomplete.getPlace();
    if (!place.geometry)
    return;
    document.getElementById('ses_lng').value = place.geometry.location.lng();
    document.getElementById('ses_lat').value = place.geometry.location.lat();

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'latLng': new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng())}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK && results.length) {
	if (results[0]) {
	  for(var i=0; i<results[0].address_components.length; i++) {
	    var postalCode = results[0].address_components[i].long_name;
	  }
	}
	if (results[1]) {
	  var indice=0;
	  for (var j=0; j<results.length; j++) {
	    if (results[j].types[0]=='locality') {
	      indice=j;
	      break;
	    }
	  }
	  for (var i=0; i<results[j].address_components.length; i++) {
	    if (results[j].address_components[i].types[0] == "locality") {
	      //this is the object you are looking for
	      city = results[j].address_components[i].long_name;
	    }
	    if (results[j].address_components[i].types[0] == "administrative_area_level_1") {
	      //this is the object you are looking for
	      state = results[j].address_components[i].long_name;
	    }
	    if (results[j].address_components[i].types[0] == "country") {
	      //this is the object you are looking for
	      country = results[j].address_components[i].long_name;
	    }
	  }
	  if(postalCode)
	  sesJqueryObject('#ses_zip').val(postalCode);
	  if(city)
	  	sesJqueryObject('#ses_city').val(city);
	  if(state)
	 	 sesJqueryObject('#ses_state').val(state);
	  if(country)
	 	 sesJqueryObject('#ses_country').val(country);
	}
      }
    });
  });

}


sesJqueryObject(document).on('click', '.member_followfriend_request', function() {
    var sesthis = this;
    en4.core.request.send(new Request.HTML({
    url: en4.core.baseUrl + 'sesmember/index/add-friend',
    data: {
      format: 'html',
      'user_id': sesJqueryObject(this).attr('data-src')
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
      var result = responseHTML;
      if(typeof result.status == 'undefined')
     	 sestooltipOrigin.tooltipster('content', responseHTML).data('ajax', 'cached');
      else if(result.status == 1)
      	sestooltipOrigin.tooltipster('content', result.message).data('ajax', 'cached');
      else
      alert(result.message);
    }
  }));

});


sesJqueryObject(document).on('click', '.sesmember_follow_user', function () {
	var element = sesJqueryObject(this);
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  var widget = sesJqueryObject (element).attr('data-widgte');

//   if (sesJqueryObject (element).find('i').hasClass('fa-check')){
//   	sesJqueryObject (element).find('i').removeClass('fa-check').addClass('fa-times');
// 		sesJqueryObject (element).find('span').html(en4.core.language.translate(sesmemberUnfollow));
// 	}
//   else{
//   	sesJqueryObject (element).find('i').removeClass('fa-times').addClass('fa-check');
// 		sesJqueryObject (element).find('span').html(en4.core.language.translate(sesmemeberFollow));
// 	}
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesmember/index/follow',
    'data': {
      format: 'html',
      id: sesJqueryObject (element).attr('data-url'),
      type: itemType,
      widget:widget,
    },
    onSuccess: function (responseTree, responseElements, responseHTML, responseJavaScript) {

      var response = jQuery.parseJSON(responseHTML);
      if (response.error)
      	alert(en4.core.language.translate('Something went wrong,please try again later'));
      else {
        if(response.autofollow == 1)  {
            var elementCount = '.sesmember_follow_user_'+id;
            //sesJqueryObject (elementCount).find('span').html(response.count);
            if (response.condition == 'reduced') {
                sesJqueryObject (elementCount).find('i').removeClass('fa-times').addClass('fa-check');
                sesJqueryObject (elementCount).find('span').html(en4.core.language.translate(sesmemeberFollow));
                showTooltipSesbasic('10','10','<i class="fa fa-times"></i><span>'+(en4.core.language.translate("Member unfollow successfully"))+'</span>','sesbasic_unfollow_notification');
            }
            else {
                sesJqueryObject (elementCount).find('span').html(en4.core.language.translate(sesmemberUnfollow));
                sesJqueryObject (elementCount).find('i').removeClass('fa-check').addClass('fa-times');
                showTooltipSesbasic('10','10','<i class="fa fa-check"></i><span>'+(en4.core.language.translate("Member follow successfully"))+'</span>','sesbasic_follow_notification');
            }
        } else {
            sesJqueryObject(element).replaceWith(response.message);
        }
      }
      return true;
    }
  })).send();
});

sesJqueryObject(document).on('click', '.member_addfriend_request', function() {
    var sesthis = this;
    en4.core.request.send(new Request.HTML({
    url: en4.core.baseUrl + 'sesmember/index/add-friend',
    data: {
      format: 'html',
      'user_id': sesJqueryObject(this).attr('data-src')
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
      var result = responseHTML;
      if(typeof result.status == 'undefined')
     	 sestooltipOrigin.tooltipster('content', responseHTML).data('ajax', 'cached');
      else if(result.status == 1)
      	sestooltipOrigin.tooltipster('content', result.message).data('ajax', 'cached');
      else
      alert(result.message);
    }
  }));

});

sesJqueryObject(document).on('click', '.member_cancelfriend_request', function() {
    var sesthis = this;
    en4.core.request.send(new Request.HTML({
    url: en4.core.baseUrl + 'sesmember/index/cancel-friend',
    data: {
      format: 'html',
      'user_id': sesJqueryObject(this).attr('data-src')
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
      var result = responseHTML;
      if(typeof result.status == 'undefined') {
				sestooltipOrigin.tooltipster('content', responseHTML).data('ajax', 'cached');
      }
      else if(result.status == 1) {
				sestooltipOrigin.tooltipster('content', result.message).data('ajax', 'cached');
      }
      else
      alert(result.message);
    }
  }));
});

sesJqueryObject(document).on('click', '.member_removefriend_request', function() {
    var sesthis = this;
    en4.core.request.send(new Request.HTML({
    url: en4.core.baseUrl + 'sesmember/index/remove-friend',
    data: {
      format: 'html',
      'user_id': sesJqueryObject(this).attr('data-src')
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
      var result = responseHTML;
      if(typeof result.status == 'undefined') {
				sestooltipOrigin.tooltipster('content', responseHTML).data('ajax', 'cached');
      }
      else if(result.status == 1) {
				sestooltipOrigin.tooltipster('content', result.message).data('ajax', 'cached');
      }
      else
      alert(result.message);
    }
  }));
});

sesJqueryObject(document).on('click', '.member_acceptfriend_request', function() {
    var sesthis = this;
    en4.core.request.send(new Request.HTML({
    url: en4.core.baseUrl + 'sesmember/index/accept-friend',
    data: {
      format: 'html',
      'user_id': sesJqueryObject(this).attr('data-src')
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavascript) {
      var result = responseHTML;
      if(typeof result.status == 'undefined') {
				sestooltipOrigin.tooltipster('content', responseHTML).data('ajax', 'cached');
      }
      else if(result.status == 1) {
				sestooltipOrigin.tooltipster('content', result.message).data('ajax', 'cached');
      }
      else
     	 alert(result.message);
    }
  }));
});

function like_data_sesmember(element, functionName, itemType) {
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active'))
  sesJqueryObject (element).removeClass('button_active');
  else
  sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesmember/index/' + functionName,
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
				var elementCount = '.sesmember_like_user_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
					showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Member unliked successfully"))+'</span>','sesbasic_member_likeunlike');
				}
				else {
					sesJqueryObject (elementCount).addClass('button_active');
					showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Member liked successfully"))+'</span>','sesbasic_liked_notification');
				}
				if(response.user_verified == 1)
					sesJqueryObject('.sesmember_verified_sign_'+id).show();
				else
					sesJqueryObject('.sesmember_verified_sign_'+id).hide();
      }
      return true;
    }
  })).send();
}

function like_review_data_sesmember(element, functionName, itemType) {
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active'))
  sesJqueryObject (element).removeClass('button_active');
  else
  sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesmember/review/' + functionName,
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
				var elementCount = '.sesmember_like_user_review_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
					showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Review unliked successfully"))+'</span>','sesbasic_member_likeunlike');
				}
				else {
					sesJqueryObject (elementCount).addClass('button_active');
					showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Review liked successfully"))+'</span>','sesbasic_member_likeunlike');
				}
      }
      return true;
    }
  })).send();
}

sesJqueryObject(document).on('click', '.sesmember_button_like_user', function () {
  var element = sesJqueryObject(this);
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).find('i').hasClass('fa-thumbs-up')){
    sesJqueryObject (element).find('i').removeClass('fa-thumbs-up').addClass('fa-thumbs-down');
    sesJqueryObject (element).find('span').html(en4.core.language.translate('Unlike'));
  }
  else{
    sesJqueryObject (element).find('i').removeClass('fa-thumbs-down').addClass('fa-thumbs-up');
    sesJqueryObject (element).find('span').html(en4.core.language.translate('Like'));
  }
  (new Request.HTML({
  method: 'post',
    'url': en4.core.baseUrl + 'sesmember/index/like',
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
	var elementCount = '.sesmember_button_like_user_'+id;
	//sesJqueryObject (elementCount).find('span').html(response.count);
	if (response.condition == 'reduced') {
	  sesJqueryObject (elementCount).find('i').removeClass('fa-thumbs-down').addClass('fa-thumbs-up');
	  sesJqueryObject (elementCount).find('span').html(en4.core.language.translate('Like'));
		showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Member unliked successfully"))+'</span>','sesbasic_member_likeunlike');
	}
	else {
	  sesJqueryObject (elementCount).find('span').html(en4.core.language.translate('Unlike'));
	  sesJqueryObject (elementCount).find('i').removeClass('fa-thumbs-up').addClass('fa-thumbs-down');
		showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Member liked successfully"))+'</span>','sesbasic_liked_notification');
	}
	if(response.user_verified == 1)
	sesJqueryObject('.sesmember_verified_sign_'+id).show();
	else
	sesJqueryObject('.sesmember_verified_sign_'+id).hide();
      }
      return true;
    }
  })).send();
});




sesJqueryObject(document).on('click', '.sesmember_like_user', function () {
  like_data_sesmember(this, 'like', 'user');
});

sesJqueryObject(document).on('click', '.sesmember_like_user_review', function () {
  like_review_data_sesmember(this, 'like', 'user');
});

function reviewVotes(elem,type){
	sesJqueryObject(elem).parent().parent().find('p').first().html('<span style="color:green;font-weight:bold">Thanks for your vote!</span>');
	var element = sesJqueryObject(this);
  if (!sesJqueryObject(elem).attr('data-href'))
  	return;
	var text = sesJqueryObject(elem).find('.title').html();
  var id = sesJqueryObject (elem).attr('data-href');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesmember/index/review-votes',
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
						//showTooltipSesbasic('10','10','<span>'+(en4.core.language.translate(text+" unliked successfully"))+'</span>','sesbasic_unliked_notification')
					}
					else {
						sesJqueryObject (elem).addClass('active');
						sesJqueryObject (elem).find('span').eq(1).html(response.count);
						//showTooltipSesbasic('10','10','<span>'+(en4.core.language.translate(text+" liked successfully"))+'</span>','sesbasic_liked_notification')
					}
      }
      return true;
    }
  })).send();
}

//review votes js
sesJqueryObject(document).on('click', '.sesmember_review_useful', function (e) {
  reviewVotes(this, '1');
});
sesJqueryObject(document).on('click', '.sesmember_review_funny', function (e) {
  reviewVotes(this, '2');
});
sesJqueryObject(document).on('click', '.sesmember_review_cool', function (e) {
  reviewVotes(this, '3');
});

sesJqueryObject(document).on({
	 mouseenter: function(){
		 jqueryObjectOfSes(this).find('.sesbasic_custom_scroll_del').mCustomScrollbar({theme:"minimal-dark"});
	 }
}, '.sesmember_member_grid');

var feturedBlockId;
sesJqueryObject(document).on('click','.fromExistingAlbumPhoto', function(){
  feturedBlockId = '';
  feturedBlockId = sesJqueryObject(this).attr('id');
  sesJqueryObject('#sesmember_popup_existing_upload').show();
  showHtml();
  sesJqueryObject('#sesmember_popup_cam_upload').show();
  sesJqueryObject('#sesmember_popup_existing_upload').show();
  existingAlbumPhotosGet();
});

sesJqueryObject(document).on('click','a[id^="sesmember_profile_upload_existing_photos_"]',function(event){
  event.preventDefault();
  var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
  if(!id)
  return;
	sesJqueryObject('#save_featured_photo').css('pointer-events','').css('cursor','');
  var imageSource = sesJqueryObject(this).find('span').css('background-image').replace('url(','').replace(')','').replace('"','').replace('"','');
  sesJqueryObject('#sesmember-profile-upload-loading').show();
  if(feturedBlockId == 'featured_image_1') {
    sesJqueryObject('#featured_photo_1').val(id);
    sesJqueryObject('#'+feturedBlockId).html('<img src='+ imageSource+ '>');
    sesJqueryObject('#hide_cancel_1').html('<a href="javascript:void(0);" class="" onclick="javascript:removeBlock(\'block_1\', \'1\');"></a>');

  }
  else if(feturedBlockId == 'featured_image_2') {
    if(sesJqueryObject('#featured_photo_1').val() == '') {
      sesJqueryObject('#featured_photo_1').val(id);
      sesJqueryObject('#featured_image_1').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_1').html('<a href="javascript:void(0);" class="" onclick="javascript:removeBlock(\'block_1\', \'1\');"></a>');
    }
    else {
    sesJqueryObject('#featured_photo_2').val(id);
    sesJqueryObject('#'+feturedBlockId).html('<img src='+ imageSource+ '>');
    sesJqueryObject('#hide_cancel_2').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_2\', \'2\');"></a>');
    }
  }
  else if(feturedBlockId == 'featured_image_3') {
    if(sesJqueryObject('#featured_photo_1').val() == '') {
      sesJqueryObject('#featured_photo_1').val(id);
      sesJqueryObject('#featured_image_1').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_1').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_1\', \'1\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_2').val() == '') {
      sesJqueryObject('#featured_photo_2').val(id);
      sesJqueryObject('#featured_image_2').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_2').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_2\', \'2\');"></a>');
    }
    else {
    sesJqueryObject('#featured_photo_3').val(id);
    sesJqueryObject('#'+feturedBlockId).html('<img src='+ imageSource+ '>');
    sesJqueryObject('#hide_cancel_3').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_3\', \'3\');"></a>');
    }
  }
  else if(feturedBlockId == 'featured_image_4') {
    if(sesJqueryObject('#featured_photo_1').val() == '') {
      sesJqueryObject('#featured_photo_1').val(id);
      sesJqueryObject('#featured_image_1').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_1').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_1\', \'1\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_2').val() == '') {
      sesJqueryObject('#featured_photo_2').val(id);
      sesJqueryObject('#featured_image_2').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_2').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_2\', \'2\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_3').val() == '') {
      sesJqueryObject('#featured_photo_3').val(id);
      sesJqueryObject('#featured_image_3').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_3').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_3\', \'3\');"></a>');
    }
    else {
    sesJqueryObject('#featured_photo_4').val(id);
    sesJqueryObject('#'+feturedBlockId).html('<img src='+ imageSource+ '>');
    sesJqueryObject('#hide_cancel_4').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_4\', \'4\');"></a>');
    }
  }
  else if(feturedBlockId == 'featured_image_5') {
    if(sesJqueryObject('#featured_photo_1').val() == '') {
      sesJqueryObject('#featured_photo_1').val(id);
      sesJqueryObject('#featured_image_1').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_1').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_1\', \'1\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_2').val() == '') {
      sesJqueryObject('#featured_photo_2').val(id);
      sesJqueryObject('#featured_image_2').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_2').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_2\', \'2\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_3').val() == '') {
      sesJqueryObject('#featured_photo_3').val(id);
      sesJqueryObject('#featured_image_3').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_3').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_3\', \'3\');"></a>');
    }
    else if(sesJqueryObject('#featured_photo_4').val() == '') {
      sesJqueryObject('#featured_photo_4').val(id);
      sesJqueryObject('#featured_image_4').html('<img src='+ imageSource+ '>');
      sesJqueryObject('#hide_cancel_4').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_4\', \'4\');"></a>');
    }
    else {
    sesJqueryObject('#featured_photo_5').val(id);
    sesJqueryObject('#'+feturedBlockId).html('<img src='+ imageSource+ '>');
    sesJqueryObject('#hide_cancel_5').html('<a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock(\'block_5\', \'5\');"></a>');
    }
  }
  hideProfileAlbumPhotoUpload();
});

sesJqueryObject(document).on('click','#save_featured_photo',function(event){
  event.preventDefault();
  sesJqueryObject('.sesmember_featured_photos_block_overlay').show();
  var photoId1 = sesJqueryObject('#featured_photo_1').val();
  var photoId2 = sesJqueryObject('#featured_photo_2').val();
  var photoId3 = sesJqueryObject('#featured_photo_3').val();
  var photoId4 = sesJqueryObject('#featured_photo_4').val();
  var photoId5 = sesJqueryObject('#featured_photo_5').val();
  sessmoothboxclose();
  var URL = en4.core.staticBaseUrl+'sesmember/index/featured-photos/';
  (new Request.HTML({
    method: 'post',
    'url': URL ,
    'data': {
      format: 'html',
      photoId1: photoId1,
      photoId2: photoId2,
      photoId3: photoId3,
      photoId4: photoId4,
      photoId5: photoId5,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      sesJqueryObject('.layout_sesmember_member_featured_photos').html(responseHTML);
      sesJqueryObject('.sesmember_featured_photos_block_overlay').hide();
    }
  })).send();
});

sesJqueryObject(document).on('click','a[id^="sesmember_existing_album_see_more_"]',function(event){
  event.preventDefault();
  var thatObject = this;
  sesJqueryObject(thatObject).parent().hide();
  var id = sesJqueryObject(this).attr('id').match(/\d+/)[0];
  var pageNum = parseInt(sesJqueryObject(this).attr('data-src'),10);
  sesJqueryObject('#sesmember_existing_album_see_more_loading_'+id).show();
  if(pageNum == 0){
    sesJqueryObject('#sesmember_existing_album_see_more_page_'+id).remove();
    return;
  }
  var URL = en4.core.staticBaseUrl+'sesmember/index/existing-album-photos/';
  (new Request.HTML({
    method: 'post',
    'url': URL ,
    'data': {
      format: 'html',
      page: pageNum+1,
      id: id,
    },
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      document.getElementById('sesmember_photo_content_'+id).innerHTML = document.getElementById('sesmember_photo_content_'+id).innerHTML + responseHTML;
      var dataSrc = sesJqueryObject('#sesmember_existing_album_see_more_page_'+id).html();
      sesJqueryObject('#sesmember_existing_album_see_more_'+id).attr('data-src',dataSrc);
      sesJqueryObject('#sesmember_existing_album_see_more_page_'+id).remove();
      if(dataSrc == 0)
      sesJqueryObject('#sesmember_existing_album_see_more_'+id).parent().remove();
      else
      sesJqueryObject(thatObject).parent().show();
      sesJqueryObject('#sesmember_existing_album_see_more_loading_'+id).hide();
    }
  })).send();
});

sesJqueryObject(document).ready(function(){
  if(typeof sesmemeberLocation != "undefined" && sesmemeberLocation == 1) {
    var locationElement = sesJqueryObject('#timezone-wrapper');
    var tabIndex = sesJqueryObject('#timezone').attr('tabindex');
    var locationTabIndex = tabIndex-1;
    for(i=0;i<locationElement.length;i++) {
      var html = '<div id="ses_location-wrapper" class="form-wrapper"><div id="ses_location-label" class="form-label"><label for="ses_location" class="optional">'+en4.core.language.translate("Location")+'</label></div><div id="ses_location-element" class="form-element"><input tabIndex="'+locationTabIndex+'" name="ses_location" id="ses_location_'+i+'" value="" placeholder="Enter a location" autocomplete="off" type="text"></div></div><input name="ses_lat" value="" id="ses_lat" type="hidden"><input name="ses_lng" value="" id="ses_lng" type="hidden"><input name="ses_zip" value="" id="ses_zip" type="hidden"><input name="ses_city" value="" id="ses_city" type="hidden"><input name="ses_state" value="" id="ses_state" type="hidden"><input name="ses_country" value="" id="ses_country" type="hidden">';
        if(sesJqueryObject(locationElement[i]).closest('form').attr('id') == 'signup_account_form') {
            sesJqueryObject(html).insertBefore(locationElement[i]);
            sesMemberLocation(i);
        }
    }
  }
})
