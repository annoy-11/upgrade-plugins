//MAP CODE 
//initialize default values
var map;
var infowindow;
var marker;
var mapLoad = true;
function initializeSesArticleMap() {
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
	google.maps.event.addDomListener(window, 'load', initializeSesArticleMap);
}

function editMarkerOnMapArticleEdit(){
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
function initializeSesArticleMapList() {
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
		google.maps.event.addDomListener(window, 'load', initializeSesArticleMapList);
	}
}

function editSetMarkerOnMapListArticle(){
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

sesJqueryObject (document).on('click', '.sesarticle_albumlike', function () {
	like_data_sesarticle(this, 'like', 'sesarticle_album');
});

sesJqueryObject (document).on('click', '.sesarticle_photolike', function () {
	like_data_sesarticle(this, 'like', 'sesarticle_photo');
});


//Favourite
sesJqueryObject (document).on('click', '.sesarticle_favourite', function () {
	favourite_data_sesarticle(this, 'favourite', 'sesarticle_photo');
});

sesJqueryObject (document).on('click', '.sesarticle_albumfavourite', function () {
	favourite_data_sesarticle(this, 'favourite', 'sesarticle_album');
});


//common function for like comment ajax
function like_data_sesarticle(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesarticle/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesarticle_albumlike')){
					var elementCount = 	element;
				} 
				else if(sesJqueryObject(element).hasClass('sesarticle_photolike')){
					var elementCount = 	element;
				}
				else {
					var elementCount = '.sesarticle_like_sesarticle_'+id;
				}
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesarticle_like_sesarticle_view') {
						sesJqueryObject('.sesarticle_like_sesarticle_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
					}
				} 
				else {
					if(classType == 'sesarticle_like_sesarticle_view') {
						sesJqueryObject('.sesarticle_like_sesarticle_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("UnLike")+'</span>');
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
function favourite_data_sesarticle(element, functionName, itemType, moduleName, notificationType, classType) {
	if (!sesJqueryObject (element).attr('data-url'))
		return;
	var id = sesJqueryObject (element).attr('data-url');
	if (sesJqueryObject (element).hasClass('button_active')) {
		sesJqueryObject (element).removeClass('button_active');
	} else
		sesJqueryObject (element).addClass('button_active');
	(new Request.HTML({
		method: 'post',
		'url': en4.core.baseUrl + 'sesarticle/index/' + functionName,
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
				if(sesJqueryObject(element).hasClass('sesarticle_favourite')){
					var elementCount = 	element;
				} else if(sesJqueryObject(element).hasClass('sesarticle_albumfavourite')){
					var elementCount = 	element;
				} 
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					sesJqueryObject (elementCount).removeClass('button_active');
				} else {
					sesJqueryObject (elementCount).addClass('button_active');
				}
				sesJqueryObject ('.sesarticle_favourite_sesarticle_'+id).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesarticle_favourite_sesarticle_view') {
						sesJqueryObject('.sesarticle_favourite_sesarticle_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesarticle_favourite_sesarticle_'+id).removeClass('button_active');
					}
				} else {
					if(classType == 'sesarticle_favourite_sesarticle_view') {
						sesJqueryObject('.sesarticle_favourite_sesarticle_'+id).html('<i class="fa fa-heart"></i><span>'+en4.core.language.translate("Un-Favourite")+'</span>');
					}
					else {
						sesJqueryObject ('.sesarticle_favourite_sesarticle_'+id).addClass('button_active');
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
function sesarticlesendQuickShare(url){
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
				showTooltip('10','10','<i class="fa fa-envelope"></i><span>'+(en4.core.language.translate("Article shared successfully."))+'</span>','sesbasic_message_notification');
      }
    })).send();
}

//open url in smoothbox
function opensmoothboxurl(openURLsmoothbox){
	Smoothbox.open(openURLsmoothbox);
	parent.Smoothbox.close;
	return false;
}

sesJqueryObject(document).on('click','.sesarticle_favourite_sesarticle',function(){
	favourite_data_sesarticle(this,'favourite','sesarticle','sesarticle', '<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Article added as Favourite successfully"))+'</span>','<i class="fa fa-heart"></i><span>'+(en4.core.language.translate("Article Un-Favourited successfully"))+'</span>','sesbasic_favourites_notification');
});

sesJqueryObject(document).on('click','.sesarticle_favourite_sesarticle_view',function(){
	favourite_data_sesarticle(this,'favourite','sesarticle','sesarticle', '', 'sesarticle_favourite_sesarticle_view');
});

sesJqueryObject(document).on('click','.sesarticle_like_sesarticle',function(){
	like_data_sesarticle(this,'like','sesarticle','sesarticle','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Article Liked successfully"))+'</span>','<i class="fa fa-thumbs-up"></i><span>'+(en4.core.language.translate("Article Un-Liked successfully"))+'</span>','sesbasic_liked_notification', '');
});

sesJqueryObject(document).on('click','.sesarticle_like_sesarticle_view',function(){
	like_data_sesarticle(this,'like','sesarticle','sesarticle','', 'sesarticle_like_sesarticle_view');
});

sesJqueryObject(document).on('click', '.sesarticle_like_sesarticle_review', function () {
  like_review_data_sesarticlereview(this, 'like', 'sesarticlereview', 'sesarticle_like_sesarticle_review');
});

sesJqueryObject(document).on('click', '.sesarticle_like_sesarticle_review_view', function () {
  like_review_data_sesarticlereview(this, 'like', 'sesarticlereview', 'sesarticle_like_sesarticle_review_view');
});

function like_review_data_sesarticlereview(element, functionName, itemType, classType) {
  if (!sesJqueryObject (element).attr('data-url'))
  return;
  var id = sesJqueryObject (element).attr('data-url');
  if (sesJqueryObject (element).hasClass('button_active'))
  sesJqueryObject (element).removeClass('button_active');
  else
  sesJqueryObject (element).addClass('button_active');
  (new Request.HTML({
    method: 'post',
    'url': en4.core.baseUrl + 'sesarticle/review/' + functionName,
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
				var elementCount = '.sesarticle_like_sesarticle_review_'+id;
				sesJqueryObject (elementCount).find('span').html(response.count);
				if (response.condition == 'reduced') {
					if(classType == 'sesarticle_like_sesarticle_review_view') {
						sesJqueryObject('.sesarticle_like_sesarticle_review_view').html('<i class="fa fa-thumbs-up"></i><span>'+en4.core.language.translate("Like")+'</span>');
					}
					else {
						sesJqueryObject (elementCount).removeClass('button_active');
						showTooltipSesbasic('10','10','<i class="fa fa-thumbs-down"></i><span>'+(en4.core.language.translate("Review Un-Liked successfully"))+'</span>','sesbasic_member_likeunlike');
					}
				}
				else {
					if(classType == 'sesarticle_like_sesarticle_review_view') {
						sesJqueryObject('.sesarticle_like_sesarticle_review_view').html('<i class="fa fa-thumbs-down"></i><span>'+en4.core.language.translate("Unlike")+'</span>');
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

sesJqueryObject(document).on('click', '.homecategory', function () {
 window.location.href = en4.core.staticBaseUrl + articleURLsesarticle + '/categories';
});
sesJqueryObject(document).on('click', '.homecreate', function () {
 window.location.href = en4.core.staticBaseUrl + articleURLsesarticle + '/create';
})
;
sesJqueryObject(document).on('click', '.homeurl', function () {
 window.location.href = en4.core.staticBaseUrl + articleURLsesarticle + '/home';
});
function changeSesarticleManifestUrl(type) {
  window.location.href = en4.core.staticBaseUrl + articleURLsesarticle + '/' + type;
}

function chnageHrefOfURL(id) {
 var welcomeHomeId = sesJqueryObject(id).attr('onclick').replace("changeSesarticleManifestUrl('","" );
  welcomeHomeId = welcomeHomeId.replace("');","");  
  sesJqueryObject(id).attr('href', en4.core.staticBaseUrl + articleURLsesarticle + '/' + welcomeHomeId); 
}
sesJqueryObject(document).ready(function() {
  var landingPageLink = sesJqueryObject('.sesarticle_landing_link');
  for(i=0; i < landingPageLink.length; i++) {
    chnageHrefOfURL(landingPageLink[i]);
  }  
});


//Slideshow widget
// sesJqueryObject(document).ready(function() {
//   var sesarticleElements = sesJqueryObject('.sesarticle_slideshow');
// 	if(sesarticleElements.length > 0) {
//     sesarticleElements.each(function(){
//       sesarticleJqueryObject(this).owlCarousel({
//         loop:true,
//         items:1,
//         margin:0,
//         autoHeight:true,
//         autoplay:sesarticleJqueryObject(this).attr('autoplay'),
//         autoplayTimeout:sesarticleJqueryObject(this).attr('autoplayTimeout'),
//         autoplayHoverPause:true
//       });
//       sesarticleJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
//       sesarticleJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
//     });
// 	}
// });
