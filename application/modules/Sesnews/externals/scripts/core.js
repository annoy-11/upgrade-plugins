//MAP CODE
//initialize default values
var map;
var infowindow;
var marker;
var mapLoad = true;
function initializeSesNewsMap() {
  var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 17
  };
   map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  var input = document.getElementById('locationSes');

  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo('bounds', map);

   infowindow = new google.maps.InfoWindow();
   marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
		document.getElementById('lngSes').value = place.geometry.location.lng();
		document.getElementById('latSes').value = place.geometry.location.lat();
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
		return false;
  });
	google.maps.event.addDomListener(window, 'load', initializeSesNewsMap);
}

function editMarkerOnMapNewsEdit(){
  geocoder = new google.maps.Geocoder();
  var address = trim(document.getElementById('locationSes').value);
  var lat = document.getElementById('latSes').value;
  var lng = document.getElementById('lngSes').value;
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	map.setZoom(17);
	marker = new google.maps.Marker({
	    position: latlng,
	    map: map
	});
	infowindow.setContent(results[0].formatted_address);
	infowindow.open(map, marker);
    } else {
      //console.log("Map failed to show location due to: " + status);
    }
  });
}

//list page map
function initializeSesNewsMapList() {
if(mapLoad){
  var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 17
  };
   map = new google.maps.Map(document.getElementById('map-canvas-list'),
    mapOptions);
}
  var input =document.getElementById('locationSesList');

  var autocomplete = new google.maps.places.Autocomplete(input);
if(mapLoad)
  autocomplete.bindTo('bounds', map);

if(mapLoad){
   infowindow = new google.maps.InfoWindow();
   marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });
}
  google.maps.event.addListener(autocomplete, 'place_changed', function() {

	if(mapLoad){
    infowindow.close();
    marker.setVisible(false);
	}
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }
	if(mapLoad){
    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
	}
		document.getElementById('lngSesList').value = place.geometry.location.lng();
		document.getElementById('latSesList').value = place.geometry.location.lat();
if(mapLoad){
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
}
    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
  if(mapLoad){
	  infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
		return false;
	}
	});
	if(mapLoad){
		google.maps.event.addDomListener(window, 'load', initializeSesNewsMapList);
	}
}

function editSetMarkerOnMapListNews(){
	geocoder = new google.maps.Geocoder();
if(mapLoad){
	if(document.getElementById('ses_location_data_list'))
		var address = trim(document.getElementById('ses_location_data_list').innerHTML);
}else{
	if(document.getElementById('locationSesList'))
		var address = trim(document.getElementById('locationSesList').innerHTML);
}
	var lat = document.getElementById('lngSesList').value;
	var lng = document.getElementById('latSesList').value;
  var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
          map.setCenter(results[0].geometry.location);
          marker = new google.maps.Marker({
              position: results[0].geometry.location,
              map: map
          });
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker);
      } else {
        //console.log("Map failed to show location due to: " + status);
      }
    });
}
function openURLinSmoothBox(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

//Like

sesJqueryObject (document).on('click', '.sesnews_albumlike', function () {
	like_data_sesnews(this, 'like', 'sesnews_album');
});

sesJqueryObject (document).on('click', '.sesnews_photolike', function () {
	like_data_sesnews(this, 'like', 'sesnews_photo');
});


//Favourite
sesJqueryObject (document).on('click', '.sesnews_favourite', function () {
	favourite_data_sesnews(this, 'favourite', 'sesnews_photo');
});

sesJqueryObject (document).on('click', '.sesnews_albumfavourite', function () {
	favourite_data_sesnews(this, 'favourite', 'sesnews_album');
});


//common function for like comment ajax
function like_data_sesnews(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesnews/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesnews_albumlike')){
					var elementCount = 	element;
				}
				else if(sesJqueryObject(element).hasClass('sesnews_photolike')){
					var elementCount = 	element;
				}
				else {
					var elementCount = '.sesnews_like_sesnews_news_'+id;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesnews_like_sesnews_news_view') {
						sesJqueryObject('.sesnews_like_sesnews_news_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				}
				else {
					if(classType == 'sesnews_like_sesnews_news_view') {
						sesJqueryObject('.sesnews_like_sesnews_news_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
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
function favourite_data_sesnews(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesnews/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesnews_favourite')){
					var elementCount = 	element;
				} else if(sesJqueryObject(element).hasClass('sesnews_albumfavourite')){
					var elementCount = 	element;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
				} else {
					sesJqueryObject (elementCount).addClass('button_active');
				}
				sesJqueryObject ('.sesnews_favourite_sesnews_news_'+id).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesnews_favourite_sesnews_news_view') {
						sesJqueryObject('.sesnews_favourite_sesnews_news_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesnews_favourite_sesnews_news_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'sesnews_favourite_sesnews_news_view') {
						sesJqueryObject('.sesnews_favourite_sesnews_news_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesnews_favourite_sesnews_news_'+id).addClass('button_active');
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
function sesnewsendQuickShare(url){
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
				showTooltip('10','10','<i class="fa fa-envelope"></i><span>'+(en4.core.language.translate("News shared successfully."))+'</span>','sesbasic_message_notification');
      }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

sesJqueryObject(document).on('click','.sesnews_favourite_sesnews_news',function(){
	favourite_data_sesnews(this,'favourite','sesnews_news','sesnews', '<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("News added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("News Un-Favourited successfully"))+'</span>','sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click','.sesnews_favourite_sesnews_news_view',function(){
	favourite_data_sesnews(this,'favourite','sesnews_news','sesnews', '', 'sesnews_favourite_sesnews_news_view');
});

sesJqueryObject(document).on('click','.sesnews_like_sesnews_news',function(){
	like_data_sesnews(this,'like','sesnews_news','sesnews','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("News Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("News Un-Liked successfully"))+'</span>','sesbasic_liked_notification', '');
});

sesJqueryObject(document).on('click','.sesnews_like_sesnews_news_view',function(){
	like_data_sesnews(this,'like','sesnews_news','sesnews','', 'sesnews_like_sesnews_news_view');
});

sesJqueryObject(document).on('click', '.sesnews_like_sesnews_review', function () {
  like_review_data_sesnewsreview(this, 'like', 'sesnews_review', 'sesnews_like_sesnews_review');
});

sesJqueryObject(document).on('click', '.sesnews_like_sesnews_review_view', function () {
  like_review_data_sesnewsreview(this, 'like', 'sesnews_review', 'sesnews_like_sesnews_review_view');
});

function like_review_data_sesnewsreview(element, functionName, itemType, classType) {
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active'))
  sesJqueryObject (element).removeClass('button_active');
  else
  sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesnews/review/' + functionName,
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
				var elementCount = '.sesnews_like_sesnews_review_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesnews_like_sesnews_review_view') {
						sesJqueryObject('.sesnews_like_sesnews_review_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
						showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Review Un-Liked successfully"))+'</span>','sesbasic_member_likeunlike');
					}
				}
				else {
					if(classType == 'sesnews_like_sesnews_review_view') {
						sesJqueryObject('.sesnews_like_sesnews_review_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("Unlike")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).addClass('button_active');
						showTooltipSesbasic('10','10','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Review Liked successfully"))+'</span>','sesbasic_member_likeunlike');
					}
				}
      }
      return true;
    }
  })).send();
}

function changeSesnewsManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + newsURLsesnews + '/' + type;
}

function chnageSesnewsHrefOfURL(id) {
 var welcomeHomeId = sesJqueryObject(id).attr('onclick').replace("changeSesnewsManifestUrl('","" );
  welcomeHomeId = welcomeHomeId.replace("');","");
  sesJqueryObject(id).attr('href', en4.core.staticBaseUrl + newsURLsesnews + '/' + welcomeHomeId);
}
sesJqueryObject(document).ready(function() {
  var landingPageLink = sesJqueryObject('.sesnews_landing_link');
  for(i=0; i < landingPageLink.length; i++) {
    chnageSesnewsHrefOfURL(landingPageLink[i]);
  }
});


//Slideshow widget
sesJqueryObject(document).ready(function() {
  var sesnewsElement = sesJqueryObject('.sesnews_news_slideshow');
	if(sesnewsElement.length > 0) {
    var sesnewsElements = sesnewsJqueryObject('.sesnews_news_slideshow');
    sesnewsElements.each(function(){
      sesnewsJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:sesnewsJqueryObject(this).attr('autoplay'),
        autoplayTimeout:sesnewsJqueryObject(this).attr('autoplayTimeout'),
        autoplayHoverPause:true
      });
      sesnewsJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sesnewsJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});

//Subscription Function
function sesnews_subs(resource_id, resource_type) {

  if ($(resource_type + '_subshidden_' + resource_id))
    var subs_id = $(resource_type + '_subshidden_' + resource_id).value

  en4.core.request.send(new Request.JSON({
    url: en4.core.baseUrl + 'sesnews/rss/subscription',
    data: {
      format: 'json',
      'type': resource_type,
      'id': resource_id,
      'subs_id': subs_id
    },
    onSuccess: function(responseJSON) {
      if (responseJSON.subs_id) {
        if ($(resource_type + '_unsubscribe_' + resource_id))
          $(resource_type + '_unsubscribe_' + resource_id).style.display = 'inline-block';
        if ($(resource_type + '_subshidden_' + resource_id))
          $(resource_type + '_subshidden_' + resource_id).value = responseJSON.subs_id;
        if ($(resource_type + '_subscribe_' + resource_id))
          $(resource_type + '_subscribe_' + resource_id).style.display = 'none';
      } else {
        if ($(resource_type + '_subshidden_' + resource_id))
          $(resource_type + '_subshidden_' + resource_id).value = 0;
        if ($(resource_type + '_unsubscribe_' + resource_id))
          $(resource_type + '_unsubscribe_' + resource_id).style.display = 'none';
        if ($(resource_type + '_subscribe_' + resource_id))
          $(resource_type + '_subscribe_' + resource_id).style.display = 'inline-block';

      }
    }
  }));
}
